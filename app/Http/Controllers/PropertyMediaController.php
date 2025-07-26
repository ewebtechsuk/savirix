<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyMedia;
use Illuminate\Http\Request;

class PropertyMediaController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'media.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('property_media', 'public');
                $property->media()->create(['file_path' => $path]);
            }
        }
        return back()->with('success', 'Images uploaded.');
    }

    public function destroy(Property $property, PropertyMedia $media)
    {
        if ($media->property_id !== $property->id) {
            abort(403);
        }
        \Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return back()->with('success', 'Image deleted.');
    }
}
