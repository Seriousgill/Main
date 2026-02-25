# MLM Backend (Laravel 10)

Production-oriented REST backend for MLM software with JWT auth, role middleware, dynamic plans, financial ledger, referrals, lucky wheel, withdrawals, and scheduler automation.

## Architecture
- Controllers: thin request/response handlers
- Services: business logic and financial consistency
- Request classes: strict validation
- Middleware: role access control
- Commands + Scheduler: cron workflows

## Main Endpoints
- `POST /api/register`
- `POST /api/login`
- `GET /api/dashboard`
- `GET /api/plans`
- `POST /api/buy-plan`
- `POST /api/complete-task`
- `GET /api/referrals`
- `POST /api/spin-wheel`
- `GET /api/wallet`
- `POST /api/withdraw`
- `GET /api/admin/dashboard`
- `POST /api/admin/plan`
- `PUT /api/admin/plan/{id}`
- `DELETE /api/admin/plan/{id}`
- `POST /api/admin/withdrawal/{id}/approve`
- `POST /api/admin/withdrawal/{id}/reject`

## Cron Commands
- `mlm:daily-task-reset`
- `mlm:daily-referral-income`
- `mlm:expire-plans`
- `mlm:weekly-withdrawal-reset`
