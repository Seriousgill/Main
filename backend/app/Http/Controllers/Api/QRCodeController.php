<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function validateCode(Request $request): JsonResponse
    {
        $payload = $request->validate(['qr_code' => ['required', 'string']]);

        $booking = Booking::query()->where('qr_code', $payload['qr_code'])->with('event', 'user')->first();

        if (!$booking || $booking->status !== BookingStatus::Paid) {
            return response()->json(['valid' => false, 'message' => 'Invalid or unpaid ticket.'], 422);
        }

        return response()->json([
            'valid' => true,
            'booking_id' => $booking->id,
            'attendee' => $booking->user->name,
            'event' => $booking->event->title,
        ]);
    }
}
