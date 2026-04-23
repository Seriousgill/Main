# Ticket Booking Platform Backend (Laravel Architecture)

This folder contains a production-oriented Laravel API + Blade Admin architecture for an event ticket booking system.

## Highlights
- Sanctum-based token authentication with role checks.
- Event creation by organizers and admin approval workflow.
- Multi-type ticket inventory with overbooking prevention.
- Razorpay order creation and signature verification flow.
- QR code issuance + validation endpoint for entry checks.
- Ticket confirmation email with booking and QR details.
- Admin dashboard for users, events, bookings, payments, analytics, and settings.

## Environment Variables (expected)
- `APP_URL`
- `DB_*`
- `MAIL_*`
- `RAZORPAY_KEY_ID`
- `RAZORPAY_KEY_SECRET`
- `PLATFORM_COMMISSION_PERCENT`
- `PLATFORM_FEE`

## Suggested Packages
- `laravel/sanctum`
- `simplesoftwareio/simple-qrcode`
- `razorpay/razorpay`

