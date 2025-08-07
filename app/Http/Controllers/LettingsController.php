<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class LettingsController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        // Filter for lettings (assuming a 'type' or 'category' field, adjust as needed)
        $query->where('type', 'letting');

        if ($request->filled('address')) {
            $query->where('address_1', 'like', '%' . $request->address . '%');
        }
        if ($request->filled('borough')) {
            $query->where('borough', $request->borough);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $properties = $query->latest()->paginate(20);

        return view('properties.lettings', compact('properties'));
    }

    public function create()
    {
        return view('properties.lettings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_1' => 'required|string|max:255',
            'borough' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'pinned' => 'nullable|boolean',
        ]);
        $validated['type'] = 'letting'; // Ensure type is always 'letting'
        $validated['pinned'] = $request->has('pinned');
        $property = \App\Models\Property::create($validated);
        return redirect()->route('lettings.index')->with('success', 'Lettings property added successfully.');
    }

    public function show($id)
    {
        $property = \App\Models\Property::findOrFail($id);
        return view('properties.lettings.show', compact('property'));
    }

    public function edit($id)
    {
        $property = \App\Models\Property::findOrFail($id);
        return view('properties.lettings.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = \App\Models\Property::findOrFail($id);
        $validated = $request->validate([
            'address_1' => 'required|string|max:255',
            'borough' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'pinned' => 'nullable|boolean',
        ]);
        $validated['type'] = 'letting'; // Always set type to letting
        $validated['pinned'] = $request->has('pinned');
        $property->update($validated);
        return redirect()->route('lettings.show', $property)->with('success', 'Lettings property updated successfully.');
    }
}
