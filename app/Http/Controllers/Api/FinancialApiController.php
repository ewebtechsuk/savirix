<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Http\Resources\FinancialResource;
use Illuminate\Http\Request;

class FinancialApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Financial::query();
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        $financials = $query->paginate(20);
        return FinancialResource::collection($financials);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'property_id' => 'nullable|exists:properties,id',
            'tenancy_id' => 'nullable|exists:tenancies,id',
            'contact_id' => 'nullable|exists:contacts,id',
        ]);
        $financial = Financial::create($validated);
        return new FinancialResource($financial);
    }

    public function show(Financial $financial)
    {
        return new FinancialResource($financial);
    }

    public function update(Request $request, Financial $financial)
    {
        $validated = $request->validate([
            'type' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric',
            'date' => 'sometimes|required|date',
            'description' => 'nullable|string',
            'property_id' => 'nullable|exists:properties,id',
            'tenancy_id' => 'nullable|exists:tenancies,id',
            'contact_id' => 'nullable|exists:contacts,id',
        ]);
        $financial->update($validated);
        return new FinancialResource($financial);
    }

    public function destroy(Financial $financial)
    {
        $financial->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
