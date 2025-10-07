<?php

namespace App\Services\Portals;

use App\Models\Property;
use Illuminate\Support\Facades\Http;

class RightmovePortalPublisher implements PortalPublisher
{
    public function publish(Property $property): PortalPublisherResult
    {
        $config = config('services.rightmove');
        if (empty($config['endpoint'])) {
            return new PortalPublisherResult(false, null, ['reason' => 'Rightmove endpoint not configured']);
        }

        $response = Http::withHeaders([
            'X-API-KEY' => $config['api_key'] ?? null,
            'X-API-SECRET' => $config['api_secret'] ?? null,
        ])->post($config['endpoint'], $this->buildPayload($property));

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
            'id' => $property->id,
            'title' => $property->title,
            'price' => $property->price,
            'address' => $property->address,
            'city' => $property->city,
            'postcode' => $property->postcode,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,
            'type' => $property->type,
            'status' => $property->status,
            'features' => $property->features->map(fn ($feature) => $feature->catalog?->portal_key ?? $feature->name)->filter()->values(),
            'media' => $property->media->map(fn ($media) => [
                'url' => \Storage::disk($media->disk)->url($media->file_path),
                'caption' => $media->caption,
                'is_primary' => $media->is_primary,
            ])->toArray(),
        ];
    }
}
