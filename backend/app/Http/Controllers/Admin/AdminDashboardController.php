<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::query()->count(),
            'events' => Event::query()->count(),
            'bookings' => Booking::query()->count(),
            'revenue' => Payment::query()->where('status', 'paid')->sum('amount'),
        ];

        $revenueByDay = Payment::query()
            ->where('status', 'paid')
            ->selectRaw('DATE(created_at) as day, SUM(amount) as amount')
            ->groupBy('day')
            ->orderBy('day')
            ->limit(14)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'revenueByDay'));
    }
}
