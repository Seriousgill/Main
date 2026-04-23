<!doctype html>
<html>
<head><meta charset="utf-8"><title>Ticket Confirmation</title></head>
<body style="font-family: Arial, sans-serif; line-height: 1.5;">
    <h2>Booking Confirmed #{{ $booking->id }}</h2>
    <p>Event: {{ $booking->event->title }}</p>
    <p>Date: {{ $booking->event->event_date->format('d M Y') }} {{ $booking->event->event_time }}</p>
    <p>City: {{ $booking->event->city }}</p>
    <p>Booking Amount: ₹{{ number_format($booking->total_amount, 2) }}</p>
    <p>QR Code: <strong>{{ $booking->qr_code }}</strong></p>
    <p>Present this QR code at event entry.</p>
</body>
</html>
