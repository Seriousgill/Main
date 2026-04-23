@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Booking Management</h2>
<form class="mb-3">
    <select name="status" class="bg-slate-800 rounded px-2 py-1">
        <option value="">All statuses</option>
        <option value="pending" @selected($status==='pending')>pending</option>
        <option value="paid" @selected($status==='paid')>paid</option>
        <option value="cancelled" @selected($status==='cancelled')>cancelled</option>
    </select>
    <button class="bg-cyan-700 px-3 py-1 rounded">Filter</button>
</form>
@foreach($bookings as $booking)
<div class="bg-slate-900 p-4 rounded mb-3 flex justify-between">
    <div>
        <p>#{{ $booking->id }} • {{ $booking->status->value }}</p>
        <p class="text-sm">{{ $booking->user->email }} • {{ $booking->event->title }}</p>
    </div>
    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}">@csrf @method('PATCH')
        <button class="bg-rose-700 px-2 py-1 rounded">Cancel</button>
    </form>
</div>
@endforeach
{{ $bookings->links() }}
@endsection
