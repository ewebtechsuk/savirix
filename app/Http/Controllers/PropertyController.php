<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureCatalog;
use App\Models\PropertyChannel;
use App\Jobs\SyncPropertyToPortals;
use App\Services\Media\PropertyMediaGallery;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenant = tenant();
        if (!$tenant) {
            abort(404, 'Tenant not found.');
        }
        $company_id = $tenant->company_id;
        $query = Property::where('company_id', $company_id);
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%") ;
            });
        }

        if ($request->filled('origin') && $request->filled('radius')) {
            $coords = $this->geocodeAddress($request->input('origin'));
            if ($coords) {
                $lat = $coords['lat'];
                $lng = $coords['lng'];
                $radius = $request->input('radius');
                $query->selectRaw("properties.*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                      ->having('distance', '<=', $radius)
                      ->orderBy('distance');
            }
        }

        $properties = $query->get();
        // Always return the view, even if $properties is empty
        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $landlord_id = $request->get('landlord_id');
        $featuresList = PropertyFeatureCatalog::orderBy('name')->get();
        $channels = PropertyChannel::where('is_active', true)->orderBy('name')->get();

        return view('properties.create', compact('landlord_id', 'featuresList', 'channels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postcode' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'media_captions.*' => 'nullable|string|max:255',
            'publish_to_portal' => 'boolean',
            'send_marketing_campaign' => 'boolean',
            'features' => 'array',
            'features.*' => 'integer|exists:property_feature_catalogs,id',
            'channels' => 'array',
            'channels.*' => 'integer|exists:property_channels,id',
            'primary_media' => 'nullable|integer',
        ]);

        $selectedChannels = $request->input('channels', []);
        $mediaFiles = [];
        $captions = $request->input('media_captions', []);
        $primaryMediaIndex = $request->input('primary_media');

        if ($request->hasFile('photo')) {
            $mediaFiles[] = $request->file('photo');
            $primaryMediaIndex = $primaryMediaIndex ?? 0;
        }
        if ($request->hasFile('media')) {
            $mediaFiles = array_merge($mediaFiles, $request->file('media'));
        }

        if (auth()->user() && auth()->user()->is_admin) {
            $validated['vendor_id'] = $request->input('vendor_id');
            $validated['landlord_id'] = $request->input('landlord_id');
            $validated['applicant_id'] = $request->input('applicant_id');
            $validated['notes'] = $request->input('notes');
            if ($request->hasFile('document')) {
                $validated['document'] = $request->file('document')->store('property_docs', 'public');
            }
        }
        $validated['publish_to_portal'] = $request->boolean('publish_to_portal');
        $validated['send_marketing_campaign'] = $request->boolean('send_marketing_campaign');
        $tenant = tenant(); // Stancl Tenancy v3+ helper
        if ($tenant) {
            $validated['tenant_id'] = $tenant->id;
        }
        $coords = null;
        if (!empty($validated['address']) || !empty($validated['city']) || !empty($validated['postcode'])) {
            $coords = $this->geocodeAddress(trim(($validated['address'] ?? '') . ' ' . ($validated['city'] ?? '') . ' ' . ($validated['postcode'] ?? '')));
            if ($coords) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }
        $property = null;

        DB::transaction(function () use (&$property, $validated, $request, $mediaFiles, $captions, $primaryMediaIndex, $selectedChannels) {
            $features = $request->input('features', []);

            $property = Property::create($validated);

            /** @var PropertyMediaGallery $gallery */
            $gallery = app(PropertyMediaGallery::class);
            $gallery->attach($property, $mediaFiles, $captions, $primaryMediaIndex);

            if (! empty($features)) {
                $catalog = PropertyFeatureCatalog::whereIn('id', $features)->get();
                foreach ($catalog as $feature) {
                    $property->features()->create([
                        'feature_catalog_id' => $feature->id,
                        'name' => $feature->name,
                        'value' => 1,
                    ]);
                }
            }

            if (! empty($selectedChannels)) {
                $syncData = collect($selectedChannels)->mapWithKeys(fn ($id) => [$id => ['status' => 'pending']]);
                $property->channels()->sync($syncData->all());
            }
        });

        if ($property && ! empty($selectedChannels)) {
            SyncPropertyToPortals::dispatch($property->fresh(['channels']));
        }

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $tenant = tenant(); // Stancl Tenancy v3+ helper
        if (!$tenant || $property->tenant_id !== $tenant->id) {
            abort(404, 'Property not found for this tenant.');
        }
        $property->load(['media', 'features', 'landlord', 'documents']);
        $features = $property->features()->pluck('name')->toArray();
        return view('properties.show', compact('property', 'features'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $featuresList = PropertyFeatureCatalog::orderBy('name')->get();
        $selectedFeatures = $property->features()->pluck('feature_catalog_id')->toArray();
        $channels = PropertyChannel::where('is_active', true)->orderBy('name')->get();
        $selectedChannels = $property->channels()->pluck('property_channel_id')->toArray();

        return view('properties.edit', compact('property', 'featuresList', 'selectedFeatures', 'channels', 'selectedChannels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'postcode' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'media_captions.*' => 'nullable|string|max:255',
            'publish_to_portal' => 'boolean',
            'send_marketing_campaign' => 'boolean',
            'features' => 'array',
            'features.*' => 'integer|exists:property_feature_catalogs,id',
            'channels' => 'array',
            'channels.*' => 'integer|exists:property_channels,id',
            'primary_media' => 'nullable|integer',
        ]);

        $selectedChannels = $request->input('channels', []);
        $mediaFiles = [];
        $captions = $request->input('media_captions', []);
        $primaryMediaIndex = $request->input('primary_media');

        if ($request->hasFile('photo')) {
            $mediaFiles[] = $request->file('photo');
            $primaryMediaIndex = $primaryMediaIndex ?? 0;
        }
        if ($request->hasFile('media')) {
            $mediaFiles = array_merge($mediaFiles, $request->file('media'));
        }
        if (auth()->user() && auth()->user()->is_admin) {
            $validated['vendor_id'] = $request->input('vendor_id');
            $validated['landlord_id'] = $request->input('landlord_id');
            $validated['applicant_id'] = $request->input('applicant_id');
            $validated['notes'] = $request->input('notes');
            if ($request->hasFile('document')) {
                $validated['document'] = $request->file('document')->store('property_docs', 'public');
            }
        }
        $validated['publish_to_portal'] = $request->boolean('publish_to_portal');
        $validated['send_marketing_campaign'] = $request->boolean('send_marketing_campaign');
        if (!empty($validated['address']) || !empty($validated['city']) || !empty($validated['postcode'])) {
            $coords = $this->geocodeAddress(trim(($validated['address'] ?? '') . ' ' . ($validated['city'] ?? '') . ' ' . ($validated['postcode'] ?? '')));
            if ($coords) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }
        DB::transaction(function () use ($property, $validated, $request, $mediaFiles, $captions, $primaryMediaIndex, $selectedChannels) {
            $property->update($validated);

            if (! empty($mediaFiles)) {
                /** @var PropertyMediaGallery $gallery */
                $gallery = app(PropertyMediaGallery::class);
                $gallery->attach($property, $mediaFiles, $captions, $primaryMediaIndex);
            }

            $property->features()->delete();
            $features = $request->input('features', []);
            if (! empty($features)) {
                $catalog = PropertyFeatureCatalog::whereIn('id', $features)->get();
                foreach ($catalog as $feature) {
                    $property->features()->create([
                        'feature_catalog_id' => $feature->id,
                        'name' => $feature->name,
                        'value' => 1,
                    ]);
                }
            }

            $syncData = collect($selectedChannels)->mapWithKeys(fn ($id) => [$id => ['status' => 'pending']]);
            $property->channels()->sync($syncData->all());
        });

        if (! empty($selectedChannels)) {
            SyncPropertyToPortals::dispatch($property->fresh(['channels']));
        }

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    /**
     * Assign a landlord to a property.
     */
    public function assignLandlord(Request $request, Property $property)
    {
        $request->validate([
            'landlord_id' => 'required|exists:contacts,id',
        ]);
        $property->landlord_id = $request->landlord_id;
        $property->save();
        return redirect()->route('properties.show', $property)->with('success', 'Landlord assigned successfully.');
    }

    /**
     * Geocode an address to coordinates.
     */
    protected function geocodeAddress(string $address): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Ressapp'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
            'limit' => 1,
        ]);

        if ($response->successful() && isset($response[0])) {
            return [
                'lat' => $response[0]['lat'],
                'lng' => $response[0]['lon'],
            ];
        }

        return null;
    }
}
