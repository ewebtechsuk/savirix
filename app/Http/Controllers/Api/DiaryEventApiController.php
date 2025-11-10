<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiaryEvent;
use App\Http\Resources\DiaryEventResource;
use Illuminate\Http\Request;

class DiaryEventApiController extends Controller
{
    public function index(Request $request)
    {
        $query = DiaryEvent::query();
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('start', [$request->start, $request->end]);
        }
        $events = $query->get();
        return DiaryEventResource::collection($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date',
            'type' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'property_id' => 'nullable|exists:properties,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'color' => 'nullable|string',
        ]);
        $event = DiaryEvent::create($validated);
        return new DiaryEventResource($event);
    }

    public function show(DiaryEvent $diaryEvent)
    {
        return new DiaryEventResource($diaryEvent);
    }

    public function update(Request $request, DiaryEvent $diaryEvent)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'start' => 'sometimes|required|date',
            'end' => 'nullable|date',
            'type' => 'sometimes|required|string',
            'user_id' => 'nullable|exists:users,id',
            'property_id' => 'nullable|exists:properties,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'color' => 'nullable|string',
        ]);
        $diaryEvent->update($validated);
        return new DiaryEventResource($diaryEvent);
    }

    public function destroy(DiaryEvent $diaryEvent)
    {
        $diaryEvent->delete();
        return response()->json(['message' => 'Deleted'], 204);
    }
}
