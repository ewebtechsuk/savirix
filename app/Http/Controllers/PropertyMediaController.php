<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PropertyMediaController extends Controller
{
    /**
     * Remove a media item from a property.
     */
    public function destroy(Property $property, PropertyMedia $media): RedirectResponse
    {
        if ($media->property_id !== $property->id) {
            abort(404);
        }

        $this->authorize('update', $property);

        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        $property->media()
            ->orderBy('order')
            ->get()
            ->values()
            ->each(function (PropertyMedia $item, int $index): void {
                $item->update(['order' => $index + 1]);
            });

        return back()->with('success', 'Media item removed.');
    }
}
