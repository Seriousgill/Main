<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $bookings = Booking::query()
            ->where('user_id', $request->user()->id)
            ->with('event', 'items.ticketType')
            ->latest()
            ->paginate(10);

        return response()->json($bookings);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ticket_type_id' => ['required', 'integer', 'exists:ticket_types,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $booking = $this->bookingService->createPendingBooking(
            $request->user()->id,
            (int) $payload['event_id'],
            $payload['items']
        );

        return response()->json($booking, 201);
    }

    public function cancel(Request $request, Booking $booking): JsonResponse
    {
        abort_if($booking->user_id !== $request->user()->id && $request->user()->role !== 'admin', 403);
        abort_if($booking->status === BookingStatus::Paid, 422, 'Paid booking cannot be cancelled here.');

        $booking->update(['status' => BookingStatus::Cancelled]);

        return response()->json(['message' => 'Booking cancelled.']);
    }
}
