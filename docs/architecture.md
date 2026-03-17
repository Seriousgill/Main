# Architecture Overview

## Platform shape

- **Client tier**: Next.js 14 app (kiosk, employee dashboard, guard panel, admin panel).
- **API tier**: Express service exposing role-protected REST endpoints.
- **Data tier**: PostgreSQL with tenant-ready location partitioning.
- **Async tier**: Notification workers for WhatsApp/email/push.
- **AI tier**: Python face-recognition microservice (HTTP/gRPC integration).

## Module mapping

1. Visitor kiosk system → `/api/visit-requests`, `/api/visitors`
2. Face recognition → `/api/ai/faces/match`
3. Approval flow → `/api/visit-requests/:id/approve|reject`
4. Pass generation → `/api/visitor-passes`
5. Guard panel → `/api/entry-logs`, `/api/exit-logs`
6. Admin analytics → `/api/analytics/*`
7. Employee dashboard → `/api/appointments`, `/api/visit-requests`
8. Employee management → `/api/employees`
9. Department management → `/api/departments`
10. Appointment QR → `/api/appointments`
11. Blacklist enforcement → `/api/blacklist`
12. Behavior analytics → `/api/analytics/visitors`
13. Global search → `/api/search`
14. Reporting → `/api/reports`
15. Multi-location → location_id foreign keys in core tables
16. Authentication → `/api/auth` (JWT, OTP, 2FA in roadmap)
17. WhatsApp notifications → worker reading `notifications` table

## Security baseline

- JWT authentication and RBAC middleware
- Helmet + CORS + payload limits
- Strong DB constraints and indexed audit/event tables
- Split responsibilities (API, worker, AI service)

## Scalability approach

- Move notification delivery to queue workers
- Introduce Redis cache for frequent dashboards
- Add read replicas for analytics-heavy workloads
- Optional partitioning by location and date for `visits`, `entry_logs`, `exit_logs`
