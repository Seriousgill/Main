@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Payment Monitoring</h2>
<div class="space-y-2">
@foreach($payments as $payment)
    <div class="bg-slate-900 p-3 rounded text-sm">
        {{ $payment->provider_order_id }} | {{ $payment->status }} | ₹{{ number_format($payment->amount,2) }} | Booking #{{ $payment->booking_id }}
    </div>
@endforeach
</div>
{{ $payments->links() }}
@endsection
