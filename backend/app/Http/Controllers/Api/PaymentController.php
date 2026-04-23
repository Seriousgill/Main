<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function createOrder(Request $request): JsonResponse
    {
        $payload = $request->validate(['booking_id' => ['required', 'integer', 'exists:bookings,id']]);
        $booking = Booking::query()->where('id', $payload['booking_id'])->where('user_id', $request->user()->id)->firstOrFail();

        abort_if($booking->status !== BookingStatus::Pending, 422, 'Only pending bookings can be paid.');

        return response()->json($this->paymentService->createRazorpayOrder($booking));
    }

    public function verify(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
        ]);

        $booking = Booking::query()
            ->where('id', $payload['booking_id'])
            ->where('user_id', $request->user()->id)
            ->with('items.ticketType', 'user', 'event')
            ->firstOrFail();

        $this->paymentService->verifyAndCapture($booking, $payload);

        return response()->json(['message' => 'Payment verified and booking confirmed.']);
    }
}
