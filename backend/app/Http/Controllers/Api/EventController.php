<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly EventService $eventService,
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->eventRepository->approvedPaginated());
    }

    public function show(Event $event): JsonResponse
    {
        abort_if($event->status !== 'approved', 404);

        return response()->json($event->load('ticketTypes', 'organizer:id,name'));
    }

    public function store(Request $request): JsonResponse
    {
        abort_if($request->user()->role !== 'organizer', 403);

        $payload = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'banner_image' => ['nullable', 'url'],
            'ticket_types' => ['required', 'array', 'min:1'],
            'ticket_types.*.name' => ['required', 'string', 'max:100'],
            'ticket_types.*.price' => ['required', 'numeric', 'min:0'],
            'ticket_types.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $event = $this->eventService->createEventWithTickets($payload, $request->user()->id);

        return response()->json($event, 201);
    }

    public function approve(Event $event): JsonResponse
    {
        $event->update(['status' => 'approved']);
        return response()->json(['message' => 'Event approved.']);
    }

    public function reject(Event $event): JsonResponse
    {
        $event->update(['status' => 'rejected']);
        return response()->json(['message' => 'Event rejected.']);
    }
}
