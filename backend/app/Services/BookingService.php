<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\BookingItem;
use App\Models\Event;
use App\Models\TicketType;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function __construct(private readonly BookingRepository $bookingRepository)
    {
    }

    public function createPendingBooking(int $userId, int $eventId, array $items): array
    {
        $event = Event::query()->where('status', 'approved')->findOrFail($eventId);

        return DB::transaction(function () use ($userId, $event, $items): array {
            $total = 0;
            $preparedItems = [];

            foreach ($items as $item) {
                $ticket = TicketType::query()->lockForUpdate()->findOrFail($item['ticket_type_id']);
                $requestedQty = (int) $item['quantity'];

                if ($ticket->event_id !== $event->id) {
                    throw ValidationException::withMessages(['items' => ['Invalid ticket for this event.']]);
                }

                if (($ticket->quantity - $ticket->sold) < $requestedQty) {
                    throw ValidationException::withMessages(['items' => ["Insufficient inventory for {$ticket->name}."]]);
                }

                $total += $ticket->price * $requestedQty;
                $preparedItems[] = ['ticket' => $ticket, 'quantity' => $requestedQty, 'price' => $ticket->price];
            }

            $booking = $this->bookingRepository->create([
                'user_id' => $userId,
                'event_id' => $event->id,
                'status' => BookingStatus::Pending,
                'total_amount' => $total,
            ]);

            foreach ($preparedItems as $preparedItem) {
                BookingItem::query()->create([
                    'booking_id' => $booking->id,
                    'ticket_type_id' => $preparedItem['ticket']->id,
                    'quantity' => $preparedItem['quantity'],
                    'unit_price' => $preparedItem['price'],
                ]);
            }

            return $booking->load('items.ticketType', 'event')->toArray();
        });
    }
}
