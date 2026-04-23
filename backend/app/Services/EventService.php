<?php

namespace App\Services;

use App\Models\TicketType;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function __construct(private readonly EventRepository $eventRepository)
    {
    }

    public function createEventWithTickets(array $payload, int $organizerId): array
    {
        return DB::transaction(function () use ($payload, $organizerId): array {
            $event = $this->eventRepository->create([
                'organizer_id' => $organizerId,
                'title' => $payload['title'],
                'description' => $payload['description'],
                'city' => $payload['city'],
                'event_date' => $payload['date'],
                'event_time' => $payload['time'],
                'banner_image' => $payload['banner_image'] ?? null,
                'status' => 'pending',
            ]);

            foreach ($payload['ticket_types'] as $ticketType) {
                TicketType::query()->create([
                    'event_id' => $event->id,
                    'name' => $ticketType['name'],
                    'price' => $ticketType['price'],
                    'quantity' => $ticketType['quantity'],
                ]);
            }

            return $event->load('ticketTypes')->toArray();
        });
    }
}
