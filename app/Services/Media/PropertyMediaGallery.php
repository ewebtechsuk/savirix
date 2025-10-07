<?php

namespace App\Services\Media;

use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class PropertyMediaGallery
{
    public function attach(Property $property, array $files, array $captions = [], ?int $primaryIndex = null): void
    {
        if (empty($files)) {
            return;
        }

        $order = (int) $property->media()->max('order');

        foreach ($files as $index => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $storedPath = $file->store('property_media/'.$property->id, 'public');

            $media = $property->media()->create([
                'file_path' => $storedPath,
                'type' => $file->getClientMimeType(),
                'disk' => 'public',
                'order' => ++$order,
                'caption' => Arr::get($captions, $index),
                'is_primary' => $primaryIndex !== null && (int) $primaryIndex === (int) $index,
            ]);

            if ($media->is_primary) {
                $property->media()
                    ->where('id', '!=', $media->id)
                    ->update(['is_primary' => false]);
            }
        }
    }
}
