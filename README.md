# Visitor Management System (Laravel Structure)

Production-style Laravel 10+ project scaffold for a QR-based Visitor Management System with web + mobile API layers.

## Included modules
- Role-based auth scaffolding (admin/host/visitor lanes)
- QR visit approval and scan flow scaffolding
- Alarm + notifications architecture (events/listeners/notifications)
- Services and repository-ready clean architecture layers
- Database migration + seeder stubs for key tables

## High-level flow
Visitor registers → `VisitCreated` event → host notification + alarm trigger → host approval → QR generation → entry/exit scans → audit logs.

## Installation on hosting
See [INSTALL_HOSTING.md](INSTALL_HOSTING.md) for complete step-by-step deployment.
