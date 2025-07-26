<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('search')) {
            $query->where('address', 'like', '%'.$request->search.'%');
        }
        $properties = $query->paginate(20);
        return PropertyResource::collection($properties);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'status' => 'required|string',
            'owner_id' => 'nullable|exists:contacts,id',
            'price' => 'nullable|numeric',
            'address' => 'required|string',
            'title' => 'nullable|string',
            'landlord_id' => 'nullable|exists:contacts,id',
            'vendor_id' => 'nullable|exists:contacts,id',
            'applicant_id' => 'nullable|exists:contacts,id',
        ]);
        $property = Property::create($validated);
        return new PropertyResource($property);
    }

    public function show(Property $property)
    {
        return new PropertyResource($property);
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'type' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
            'owner_id' => 'nullable|exists:contacts,id',
            'price' => 'nullable|numeric',
            'address' => 'sometimes|required|string',
            'title' => 'nullable|string',
            'landlord_id' => 'nullable|exists:contacts,id',
            'vendor_id' => 'nullable|exists:contacts,id',
            'applicant_id' => 'nullable|exists:contacts,id',
        ]);
        $property->update($validated);
        return new PropertyResource($property);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
