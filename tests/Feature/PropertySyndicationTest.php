<?php

namespace Tests\Feature;

use App\Jobs\SendContactCommunication;
use App\Jobs\SyncPropertyToPortals;
use App\Models\Contact;
use App\Models\ContactTag;
use App\Models\Property;
use App\Models\PropertyChannel;
use App\Models\PropertyFeatureCatalog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertySyndicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_property_creation_queues_portal_sync_with_channels(): void
    {
        $this->seed(\Database\Seeders\PropertyFeatureCatalogSeeder::class);

        Bus::fake();
        Storage::fake('public');
        Http::fake([
            'https://nominatim.openstreetmap.org/*' => Http::response([], 200),
        ]);

        $user = User::factory()->create(['is_admin' => true]);
        $features = PropertyFeatureCatalog::take(2)->pluck('id')->toArray();
        $rightmove = PropertyChannel::create([
            'name' => 'Rightmove',
            'slug' => 'rightmove',
            'handler' => \App\Services\Portals\RightmovePortalPublisher::class,
        ]);
        $zoopla = PropertyChannel::create([
            'name' => 'Zoopla',
            'slug' => 'zoopla',
            'handler' => \App\Services\Portals\ZooplaPortalPublisher::class,
        ]);
        $channels = [$rightmove->id, $zoopla->id];

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'Canalside Apartment',
            'description' => 'Bright and spacious apartment with river views.',
            'price' => 350000,
            'address' => '123 River Road',
            'city' => 'London',
            'postcode' => 'E14 5AB',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'type' => 'Flat',
            'status' => 'available',
            'photo' => UploadedFile::fake()->image('cover.jpg'),
            'features' => $features,
            'channels' => $channels,
            'publish_to_portal' => true,
        ]);

        $response->assertRedirect(route('properties.index'));

        $property = Property::latest()->with(['features', 'channels'])->first();
        $this->assertNotNull($property);
        $this->assertEqualsCanonicalizing($features, $property->features->pluck('feature_catalog_id')->toArray());
        $this->assertEqualsCanonicalizing($channels, $property->channels->pluck('id')->toArray());
        // Debug: inspect queue pushes during test execution
        Bus::assertDispatched(SyncPropertyToPortals::class, 1);
    }

    public function test_contact_communications_are_logged_via_providers(): void
    {
        $contact = Contact::factory()->create([
            'email' => 'applicant@example.com',
            'phone' => '+441234567890',
        ]);

        Mail::fake();
        Http::fake([
            '*' => Http::response(['sid' => 'SM12345'], 200),
        ]);

        SendContactCommunication::dispatchSync($contact, 'email', [
            'subject' => 'Viewing Confirmation',
            'body' => 'Your viewing is confirmed for tomorrow.',
        ], null);

        SendContactCommunication::dispatchSync($contact, 'sms', [
            'body' => 'Reminder: viewing tomorrow at 10am.',
        ], null);

        $communications = $contact->communications()->orderBy('created_at')->get();
        $this->assertCount(2, $communications);
        $this->assertEquals('email', $communications->first()->channel);
        $this->assertEquals('delivered', $communications->first()->status);
        $this->assertEquals('sms', $communications->last()->channel);
        $this->assertEquals('delivered', $communications->last()->status);
        $this->assertEquals('twilio', $communications->last()->provider);
    }

    public function test_bulk_segment_dispatches_jobs_for_tagged_contacts(): void
    {
        $this->seed(\Database\Seeders\PropertyFeatureCatalogSeeder::class);
        $tag = ContactTag::create(['name' => 'Investors']);
        Contact::factory()->count(2)->create()->each(function ($contact) use ($tag) {
            $contact->tags()->attach($tag->id);
        });

        Bus::fake();
        Http::fake([
            'https://nominatim.openstreetmap.org/*' => Http::response([], 200),
        ]);

        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('contacts.bulk'), [
            'action' => 'email',
            'contacts' => [],
            'segment_tags' => [$tag->id],
            'subject' => 'New property launch',
            'body' => 'Check out our new listings.',
        ]);

        $response->assertRedirect();
        Bus::assertDispatched(SendContactCommunication::class, 2);
    }
}
