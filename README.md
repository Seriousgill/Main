# Event Ticket Booking Platform

Monorepo scaffold for a production-style platform similar to BookMyShow/DryTickets.

## Structure
- `backend/`: Laravel API + Blade Admin panel
- `frontend/`: Next.js + Tailwind customer app

## Completed Modules
- Auth system (roles: user/organizer/admin)
- Event workflow (organizer create, admin approve/reject)
- Ticket inventory and overbooking safeguards
- Booking lifecycle (pending/paid/cancelled)
- Razorpay order+verify service abstraction
- QR validation API
- Email ticket dispatch flow
- Admin dashboard with management pages and settings
- Mobile-responsive frontend pages

## Notes
This repository contains production-oriented architecture and code structure ready to be plugged into a standard Laravel + Next installation. If package installation is available, run framework bootstrapping and drop these modules in place.
