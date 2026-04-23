<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $bookings = Booking::query()
            ->with('user', 'event')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => BookingStatus::Cancelled]);
        return back()->with('status', 'Booking cancelled by admin.');
    }
}
