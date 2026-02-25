# MLM Software API Contract & Dynamic System Structure

## Stack
- Backend: Laravel (PHP 8.x)
- Database: MySQL 8+
- API: JSON REST
- Auth: JWT for users/admin
- Scheduler: Laravel scheduler + queue workers

## Dynamic Engine Principles
1. All plans are data-driven from `plans` table (add/edit/delete/toggle without code changes).
2. Task reward logic comes from plan/task configuration and system settings.
3. Referral one-time + daily payouts are runtime-configurable by admin.
4. Lucky wheel rewards and probability are fully DB-driven.
5. Withdrawal rules (minimum, weekly limits, fee%, auto/manual approval) are setting-driven.
6. System toggles (maintenance, task enable, referral enable, wheel enable) are centralized in `system_settings`.

---

## Authentication APIs
### `POST /api/auth/register`
- Inputs: name, mobile, email, password, optional referral code.
- Validates referral code and links sponsor if valid.

### `POST /api/auth/login`
Returns JWT token + profile.

### `POST /api/auth/verify-otp`
Marks account as OTP verified when enabled.

---

## User APIs
### `GET /api/dashboard`
Returns earnings summary, plan status, days remaining, eligible actions.

### `POST /api/plans/activate`
Activates selected plan after payment verification.

### `GET /api/tasks/today`
Returns today's assigned task from `plan_task_templates`.

### `POST /api/tasks/complete`
Completes task; income credited only if validation passes and task system is enabled.

### `GET /api/referrals/link`
Returns unique referral link/code.

### `GET /api/referrals/list`
Returns direct referrals and status.

### `GET /api/lucky-wheel/eligibility`
Returns available spins from `user_spin_ledger` and per-day limits.

### `POST /api/lucky-wheel/spin`
Consumes one spin and credits random prize.

### `GET /api/wallet/summary`
Wallet segments: task, referral, lucky wheel, total withdrawable.

### `POST /api/withdrawals/request`
Validates plan minimum + weekly limits + active plan; creates request.

---

## Admin APIs (Full Dynamic Control)
### Plans
- `GET /api/admin/plans`
- `POST /api/admin/plans`
- `PUT /api/admin/plans/{planId}`
- `DELETE /api/admin/plans/{planId}`
- `POST /api/admin/plans/{planId}/toggle`

Configurable fields include price, validity, daily task income, referral incomes, minimum withdrawal, max weekly withdrawal.

### Plan Task Templates
- `GET /api/admin/plan-tasks`
- `POST /api/admin/plan-tasks`
- `PUT /api/admin/plan-tasks/{taskId}`
- `DELETE /api/admin/plan-tasks/{taskId}`

Supports task type (`VIDEO`, `FORM`, `QUIZ`, `VISIT_PAGE`, `CUSTOM`) and reward per plan.

### User Management
- block/unblock user
- plan upgrades
- manual credit/debit

### Withdrawal Management
- pending queue
- approve/reject requests
- payment status updates

### Lucky Wheel Management
- add/edit/delete rewards
- modify probabilities
- enable/disable wheel

### Dynamic Settings
- platform settings (site, maintenance)
- income settings (task/referral enable, payout constraints)
- withdrawal settings (fee%, cycle days, limits)
- security settings (KYC required, anti-fake referral, max accounts per IP)

---

## Scheduler Jobs (Automation)
1. **DailyTaskSettlementJob**
   - ensures skipped tasks are marked `MISSED`
   - credits only completed tasks
2. **ReferralDailyIncomeJob**
   - credits referral daily payout for active qualified referrals
3. **PlanExpiryJob**
   - expires plans after validity and blocks new income accrual
4. **WeeklyWithdrawalCycleJob**
   - opens/closes cycle windows and enforces weekly request limits

---

## Security Controls
- Password hashing + optional OTP verification.
- Admin 2FA support.
- Payment verification callback checks before plan activation.
- Anti fake referral controls (device/IP/rule checks).
- Strict server-side validation and rate limiting.
- Transactional wallet updates with idempotency keys.
- Comprehensive audit logging for all financial/admin actions.
