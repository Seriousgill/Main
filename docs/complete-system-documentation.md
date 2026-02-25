# MLM Software — Complete System Documentation (Developer Handover)

## 1. Document Purpose
This document is the implementation-ready functional specification for a **dynamic MLM software system** with:
- dynamic plan management,
- daily task income,
- referral one-time + daily income,
- lucky wheel rewards,
- wallet + transaction ledger,
- weekly withdrawal lifecycle,
- user/admin panel controls,
- automation and security controls.

---

## 2. Roles & Access

## 2.1 Public (Guest)
- Can view landing pages, plans, FAQ, terms/privacy, contact.
- Can register and login.

## 2.2 User (Authenticated Member)
- Can buy/upgrade plans.
- Can complete daily tasks.
- Can refer users and earn referral income.
- Can use lucky wheel if spins available.
- Can view wallet and request withdrawals.
- Can manage profile, payout details, and KYC.

## 2.3 Admin
- Full operations control:
  - plans,
  - plan tasks,
  - users,
  - withdrawals,
  - lucky wheel rewards,
  - settings,
  - reports,
  - manual credit/debit.

---

## 3. User Panel — Pages, Buttons, Features, Logic

## 3.1 Landing Page (Public)
**Sections**
- Logo/Brand
- About Company
- Plan Comparison
- How It Works
- Referral Program Overview
- Contact Support
- FAQ
- Terms & Conditions
- Privacy Policy

**Buttons**
- `Register`
- `Login`
- `View Plans`
- `Contact Support`
- `How It Works`

**Logic**
- CTA navigation to auth or plans.
- Plans are fetched dynamically from active rows in `plans`.

## 3.2 Registration Page
**Fields**
- Full Name
- Mobile Number
- Email
- Password
- Confirm Password
- Referral Code (Optional)
- Accept Terms Checkbox

**Buttons**
- `Register`
- `Back to Login`

**Logic**
1. Validate mobile/email uniqueness.
2. If referral code entered, validate against `users.referral_code`.
3. Create user record + unique referral code.
4. Initialize `wallets` and `user_spin_ledger`.
5. Optional OTP verification workflow.

## 3.3 Login Page
**Fields**
- Email/Mobile
- Password

**Buttons**
- `Login`
- `Forgot Password`
- `Register`

**Logic**
1. Validate credentials.
2. Check account status (`ACTIVE` required).
3. Issue JWT/session.
4. Redirect to dashboard.

## 3.4 User Dashboard
**Widgets**
- Active Plan Name
- Plan Expiry Date
- Total Earnings
- Today Income
- Referral Income
- Lucky Wheel Income
- Wallet Balance / Withdrawable Balance
- Total Referrals
- Days Remaining

**Buttons**
- `Complete Daily Task`
- `Refer & Earn`
- `Spin Lucky Wheel`
- `Withdraw Money`
- `Upgrade Plan`
- `View Transactions`

**Logic**
- All dashboard values are aggregate reads from `user_plans`, `wallets`, `transactions`, and `referrals`.

## 3.5 Buy Plan Page
**Shows**
- Active and available plans
- Price
- Validity
- Daily task income
- Referral daily income
- One-time bonus
- Withdrawal limits

**Buttons**
- `Buy Now`
- `Compare Plans`

**Logic**
1. User selects plan.
2. Create payment order.
3. Verify payment callback signature.
4. Create `user_plans` (active plan period).
5. Trigger referral qualification checks for sponsor payouts/spin unlock.

## 3.6 Daily Task Page
**Shows**
- Task Title
- Task Description/Instructions
- Task Type (Video/Form/Quiz/Visit)
- Timer/Cutoff
- Task Status

**Buttons**
- `Submit Task`
- `Refresh Status`

**Logic**
1. Check plan is active.
2. Check task system enabled in `system_settings`.
3. If already completed for date, disable submit.
4. On submit -> validate completion -> mark `COMPLETED`.
5. Income credited by settlement logic.
6. If skipped by cutoff -> marked `MISSED`, income = 0.

## 3.7 Referral Page
**Shows**
- Unique Referral Link
- Referral Code
- Referral List
- Referral Earnings Summary

**Buttons**
- `Copy Link`
- `Share WhatsApp`
- `Share Facebook`
- `View Referral History`

**Logic**
- Referral created at registration.
- Sponsor receives one-time bonus only when referred user becomes qualified (plan purchase).
- Daily referral income credited by cron, respecting active-plan and setting rules.

## 3.8 Lucky Wheel Page
**Shows**
- Available Spins
- Wheel/Reward Tiles
- Spin History

**Buttons**
- `Spin`
- `View Reward History`

**Logic**
1. Validate wheel enabled.
2. Validate available spins > 0 and per-day limit.
3. Weighted random reward from `lucky_wheel_rewards`.
4. Credit reward to wallet and decrement spin count atomically.

## 3.9 Wallet Page
**Shows**
- Task Income Balance
- Referral Income Balance
- Lucky Income Balance
- Total Withdrawable
- Transaction History

**Buttons**
- `View All Transactions`
- `Export Statement` (optional)

**Logic**
- Wallet values are derived from transaction ledger and maintained with transactional updates.

## 3.10 Withdrawal Page
**Shows**
- Available Balance
- Minimum Withdrawal (by plan)
- Weekly Limit (count + amount)
- Current Cycle Status

**Fields**
- Amount
- Payout Mode (UPI/Bank)
- UPI ID or Bank Details

**Buttons**
- `Submit Withdrawal Request`
- `View Withdrawal History`

**Logic**
1. Validate active plan.
2. Validate minimum withdrawal.
3. Validate weekly request limit and max weekly amount.
4. Apply fee% if configured.
5. Create `withdrawals` record as `PENDING`.
6. Admin approves/rejects.

## 3.11 Profile Page
**Features**
- Update Name
- Change Password
- Add/Update Bank Details
- Upload KYC Docs

**Buttons**
- `Save Profile`
- `Change Password`
- `Upload KYC`

**Logic**
- Server-side validation and secure file upload.
- KYC status transitions: NOT_SUBMITTED -> PENDING -> VERIFIED/REJECTED.

## 3.12 Support Page
**Features**
- Submit Ticket
- View Ticket Status (if ticket module enabled)

**Buttons**
- `Create Ticket`
- `View Tickets`

---

## 4. Admin Panel — Pages, Buttons, Features, Logic

## 4.1 Admin Dashboard
**Shows**
- Total Users
- Active Plans
- Total Deposits
- Total Withdrawals
- Pending Withdrawals
- Total Profit
- Module Status (task/referral/wheel/maintenance)

**Buttons**
- `Go to Plan Management`
- `Review Withdrawals`
- `System Settings`

## 4.2 Plan Management
**Features**
- Add Plan
- Edit Plan
- Delete Plan
- Activate/Deactivate Plan

**Fields**
- Plan Name
- Price
- Validity
- Daily Task Income
- Referral Daily Income
- One-Time Bonus
- Minimum Withdrawal
- Weekly Limit
- Status

**Buttons**
- `Add Plan`
- `Save Changes`
- `Delete`
- `Toggle Active`

**Logic**
- Unlimited dynamic plans.
- No code change required for new plans.

## 4.3 Plan Task Management
**Features**
- Add plan-specific tasks
- Set task type + reward
- Enable/disable task template

**Buttons**
- `Add Task`
- `Update Task`
- `Delete Task`

## 4.4 User Management
**Features**
- User list + search
- Block/Unblock
- Upgrade Plan
- Manual Credit
- Manual Debit

**Buttons**
- `Block`
- `Unblock`
- `Upgrade Plan`
- `Manual Credit`
- `Manual Debit`

**Logic**
- Every admin action logs to `audit_logs`.
- Manual financial actions create `transactions` entries.

## 4.5 Withdrawal Management
**Features**
- View pending requests
- Approve/reject
- View paid/rejected history

**Buttons**
- `Approve`
- `Reject`
- `Mark Paid`

**Logic**
- Approval updates request status.
- Payment completion debits wallet and creates withdrawal transaction.

## 4.6 Lucky Wheel Management
**Features**
- Add/edit/delete reward slabs
- Set probability weights
- Enable/disable wheel globally

**Buttons**
- `Add Reward`
- `Update Reward`
- `Delete Reward`
- `Enable/Disable Wheel`

## 4.7 Transaction Management
**Shows**
- All income credits/debits
- Withdrawals ledger
- Filters by user/date/type/status

**Buttons**
- `Export Excel`
- `Export CSV`

## 4.8 System Settings
**Features**
- Enable/disable task system
- Enable/disable referral system
- Enable/disable lucky wheel
- Maintenance mode
- Site name
- Withdrawal fee%
- KYC required toggle
- Anti-fake-referral toggle

**Buttons**
- `Save Settings`
- `Reset Defaults` (optional)

## 4.9 Payment Gateway Settings
**Features**
- Configure Razorpay keys
- Configure UPI fallback
- Enable/disable gateway modes

**Buttons**
- `Save Gateway Settings`
- `Test Connection`

---

## 5. Complete System Logic (End-to-End)
1. User registers (with optional referral).
2. User buys a plan.
3. Plan activates for configured validity window.
4. User completes daily task to earn daily income.
5. User refers others to earn one-time and daily referral income.
6. Lucky wheel spins unlocked by referral qualification.
7. Wallet updates via transaction ledger.
8. User requests withdrawal.
9. Admin approves/rejects; successful payout updates wallet/ledger.
10. Plan expires; earnings stop.

---

## 6. Background Automation (Cron/Jobs)
- **DailyTaskSettlementJob**: mark missed tasks, settle completed tasks.
- **ReferralDailyIncomeJob**: credit daily referral income.
- **PlanExpiryJob**: expire ended plans.
- **WeeklyWithdrawalCycleJob**: reset/enforce weekly limits.

---

## 7. Security, Compliance, and Fraud Controls
- Password hashing (bcrypt/argon2).
- OTP verification for user login (optional by setting).
- Admin 2FA.
- Payment signature verification.
- Anti fake referral checks (IP/device velocity/rule thresholds).
- Rate limiting on auth/task/spin/withdrawal endpoints.
- Immutable financial ledger + audit logs.
- KYC workflow support for compliance.

---

## 8. Developer Implementation Notes
- Implement wallet and payout operations in DB transactions with row locking.
- Use idempotency keys for cron-generated credits and callbacks.
- Keep business rules read from `plans` and `system_settings` to ensure dynamic behavior.
- Prefer async queues for payment callbacks, settlement jobs, and notifications.
- Add observability (job run logs, payout reconciliation reports, error alerts).
