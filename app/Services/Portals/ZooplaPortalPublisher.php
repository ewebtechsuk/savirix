<?php

namespace App\Services\Portals;

use App\Models\Property;
use Illuminate\Support\Facades\Http;

class ZooplaPortalPublisher implements PortalPublisher
{
    public function publish(Property $property): PortalPublisherResult
    {
        $config = config('services.zoopla');
        if (empty($config['endpoint'])) {
            return new PortalPublisherResult(false, null, ['reason' => 'Zoopla endpoint not configured']);
        }

        $response = Http::withToken($config['api_key'] ?? null)
            ->post($config['endpoint'], $this->buildPayload($property));

        $success = $response->successful();

        return new PortalPublisherResult(
            $success,
            $response->json('message_id') ?? null,
            ['status' => $response->status(), 'body' => $response->json()]
        );
    }

    protected function buildPayload(Property $property): array
    {
        return [
            'property_id' => $property->id,
            'summary' => $property->description,
            'price' => $property->price,
            'location' => [
                'address' => $property->address,
                'city' => $property->city,
                'postcode' => $property->postcode,
                'latitude' => $property->latitude,
                'longitude' => $property->longitude,
            ],
            'rooms' => [
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
            ],
            'features' => $property->features->map(fn ($feature) => [
                'code' => $feature->catalog?->portal_key ?? $feature->name,
                'value' => $feature->value,
            ])->toArray(),
            'media' => $property->media->map(fn ($media) => [
                'url' => \Storage::disk($media->disk)->url($media->file_path),
                'caption' => $media->caption,
                'primary' => $media->is_primary,
            ])->toArray(),
        ];
    }
}
