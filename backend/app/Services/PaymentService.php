<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Mail\TicketBookedMail;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentService
{
    public function createRazorpayOrder(Booking $booking): array
    {
        $providerOrderId = 'order_' . Str::uuid();

        $payment = Payment::query()->create([
            'booking_id' => $booking->id,
            'provider' => 'razorpay',
            'provider_order_id' => $providerOrderId,
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        return [
            'order_id' => $providerOrderId,
            'amount' => (int) round($booking->total_amount * 100),
            'currency' => 'INR',
            'booking_id' => $booking->id,
            'key' => config('services.razorpay.key_id'),
            'payment_record' => $payment,
        ];
    }

    public function verifyAndCapture(Booking $booking, array $payload): void
    {
        // In production, use Razorpay SDK signature verification.
        $payment = Payment::query()
            ->where('booking_id', $booking->id)
            ->where('provider_order_id', $payload['razorpay_order_id'])
            ->firstOrFail();

        $payment->update([
            'provider_payment_id' => $payload['razorpay_payment_id'],
            'status' => 'paid',
            'payload' => $payload,
        ]);

        $booking->update([
            'status' => BookingStatus::Paid,
            'paid_at' => now(),
            'qr_code' => 'TIX-' . strtoupper(Str::random(18)),
        ]);

        foreach ($booking->items as $item) {
            $item->ticketType->increment('sold', $item->quantity);
        }

        Mail::to($booking->user->email)->queue(new TicketBookedMail($booking->fresh(['event', 'items.ticketType', 'user'])));
    }
}
