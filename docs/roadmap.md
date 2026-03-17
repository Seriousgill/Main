# Delivery Roadmap

## Phase 1: Foundation (completed in this commit)
- Core DB schema for visitor lifecycle, approvals, passes, logs, reports
- Express API skeleton with auth middleware and seed role model
- Dockerized local development

## Phase 2: Core operations
- Implement CRUD APIs for departments, employees, locations
- Complete visit request workflow (submit, approve, reject, notify)
- Add kiosk flow + QR appointment scan endpoint
- Build security guard check-in/check-out endpoints

## Phase 3: Integrations
- WhatsApp provider abstraction (Twilio/Meta)
- SMTP email templates
- Object storage integration for visitor photos and ID files
- Face recognition microservice contract and matching endpoint

## Phase 4: UI applications
- Next.js app router with role-based app sections
- Kiosk mode optimized for tablets
- Employee and admin analytics dashboards
- Report generation UX (PDF/Excel/CSV)

## Phase 5: Enterprise hardening
- OTP and 2FA
- Audit trails and tamper-evident logs
- SSO/SAML and advanced policy controls
- CI/CD, observability, load testing (100k+ visitor scale)
