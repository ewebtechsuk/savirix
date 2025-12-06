<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Services\TenantProvisioner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PropertyMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_update_adds_media_with_required_fields(): void
    {
        Storage::fake('public');

        [$tenant, $user, $domain] = $this->provisionTenantUser('media-test@example.com');

        tenancy()->initialize($tenant);
        $property = Property::factory()->create(['title' => 'Existing Property']);
        tenancy()->end();

        $this->useTenantDomain($domain);

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($user)
            ->put('http://' . $domain . route('properties.update', $property, false), [
                'title' => 'Updated Property',
                'media' => [$file],
            ]);

        $response->assertRedirect(route('properties.index'));

        tenancy()->initialize($tenant);
        $freshProperty = Property::findOrFail($property->id);
        $media = $freshProperty->media()->first();
        tenancy()->end();

        $this->assertNotNull($media);
        $this->assertSame('photo', $media->media_type);
        $this->assertNotNull($media->media_url);
        $this->assertSame(1, $media->order);
        Storage::disk('public')->assertExists($media->file_path);
    }

    private function provisionTenantUser(string $email): array
    {
        $tenantProvisioner = app(TenantProvisioner::class);

        $tenant = $tenantProvisioner->provision([
            'subdomain' => 'agency-' . Str::random(6),
            'name' => 'Property Agency',
            'user' => [
                'name' => 'Test User',
                'email' => $email,
                'password' => 'password',
            ],
        ])->tenant();

        $this->assertNotNull($tenant, 'Tenant was not provisioned.');

        $domain = $tenant->domains()->first()->domain;

        tenancy()->initialize($tenant);
        $userModel = config('auth.providers.users.model');
        $user = $userModel::where('email', $email)->firstOrFail();
        tenancy()->end();

        $this->useTenantDomain($domain);

        return [$tenant, $user, $domain];
    }
}
