@extends('admin.layouts.app')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Dashboard</h2>
<div class="grid md:grid-cols-4 gap-4 mb-6">
    <div class="bg-slate-900 p-4 rounded">Users: {{ $stats['users'] }}</div>
    <div class="bg-slate-900 p-4 rounded">Events: {{ $stats['events'] }}</div>
    <div class="bg-slate-900 p-4 rounded">Bookings: {{ $stats['bookings'] }}</div>
    <div class="bg-slate-900 p-4 rounded">Revenue: ₹{{ number_format($stats['revenue'], 2) }}</div>
</div>
<div class="bg-slate-900 p-4 rounded">
    <h3 class="font-semibold mb-2">Revenue trend (last 14 records)</h3>
    <ul class="text-sm text-slate-300">
        @foreach($revenueByDay as $point)
            <li>{{ $point->day }} — ₹{{ number_format($point->amount, 2) }}</li>
        @endforeach
    </ul>
</div>
@endsection
