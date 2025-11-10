<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Response;

class PropertyAssignController extends Controller
{
    // Assign a property to a landlord (contact)
    public function assign(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'landlord_id' => 'required|exists:contacts,id',
        ]);
        $property = Property::findOrFail($request->property_id);
        $property->landlord_id = $request->landlord_id;
        $property->save();
        return redirect()->back()->with('success', 'Property assigned to landlord.');
    }

    // For AJAX select2 search
    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $results = Property::whereNull('landlord_id')
            ->where(function($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                      ->orWhere('address', 'like', "%$q%")
                      ->orWhere('id', $q);
            })
            ->orderBy('title')
            ->limit(10)
            ->get(['id', 'title', 'address']);
        return response()->json($results);
    }
}
