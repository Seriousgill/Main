# Visitor / Vigilance Management System SaaS (Foundation)

This repository now contains a production-oriented **foundation** for an enterprise Visitor & Vigilance Management System designed to evolve into the full platform described in the product brief.

## Included in this commit

- Domain-driven PostgreSQL schema covering the required core entities:
  - users, roles, employees, departments, visitors, visitor_photos, visitor_ids
  - visits, visit_requests, appointments, visitor_passes, notifications
  - blacklist, locations, entry_logs, exit_logs, reports
- Express API skeleton with secure defaults and module-oriented routing.
- JWT-based authentication scaffolding with role-aware middleware.
- Docker compose stack for local development (PostgreSQL + API service).
- High-level architecture and phased delivery plan.

## Tech baseline

- Backend: Node.js + Express
- Database: PostgreSQL 15
- Auth: JWT + role middleware (expandable to OTP / 2FA)
- Containerization: Docker Compose

## Quick start

```bash
cp .env.example .env
docker compose up --build
```

API health endpoint:

```bash
curl http://localhost:4000/health
```

## Project structure

- `db/schema.sql` – relational schema and indexes
- `backend/src/server.js` – app bootstrap
- `backend/src/routes/*.js` – grouped REST endpoints
- `backend/src/middleware/*.js` – auth + RBAC helpers
- `docs/architecture.md` – architecture and module mapping
- `docs/roadmap.md` – delivery phases for full enterprise rollout

## Notes

This is an implementation starter designed for incremental hardening and feature delivery. The face recognition microservice, WhatsApp integration, and Next.js UI are represented in architecture/roadmap and intended as next milestones.
