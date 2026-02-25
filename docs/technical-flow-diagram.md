# Full Technical Flow Diagram — Dynamic MLM Software

## 1) System Overview Flow
```text
User Register
   -> Select Plan
   -> Payment Gateway Verification
   -> Plan Activation (start 90-day timer or configured validity)
   -> User Dashboard
   -> Daily Task / Referral / Lucky Wheel / Wallet / Withdrawal flows
```

## 2) User Registration Flow
```text
Open Website/App
   -> Register (name, mobile, email, password, optional referral code)
   -> Validate referral code
      -> valid: map sponsor + create referral relation
      -> invalid: reject or continue without sponsor (business rule)
   -> Generate unique referral code
   -> Create wallet + spin ledger defaults
   -> Login
```

## 3) Plan Purchase + Activation Flow
```text
User Login
   -> Select plan (dynamic from plans table)
   -> Pay via gateway (UPI/Razorpay)
   -> Verify payment callback signature
   -> Create user_plan
   -> Set activated_at / expires_at
   -> Create daily task rows for settlement window
```

## 4) Daily Task Income Flow
```text
User -> Open today's task
   -> System checks:
        - active plan?
        - task system enabled?
        - task already completed?
   -> User submits task
   -> Validate completion
   -> Mark task COMPLETED
   -> Credit task income transaction
```

Skip rule:
```text
If task not completed by cutoff
   -> Daily cron marks task MISSED
   -> income_credited = 0
```

## 5) Referral Income Flow
```text
Referred user registers with sponsor code
   -> referred user buys a plan
   -> system qualifies referral
   -> sponsor gets one-time bonus (once)
   -> sponsor spin ledger increments (lucky wheel unlock)
```

Daily referral cron:
```text
For each qualified active referral
   -> check sponsor plan status + settings
   -> credit referral daily income
   -> write transaction + update wallet
```

## 6) Lucky Wheel Flow
```text
Referral qualifies
   -> available spins +1 in user_spin_ledger
User clicks spin
   -> check wheel enabled + available spins + per-day limits
   -> random weighted reward from lucky_wheel_rewards
   -> create spin record
   -> credit wallet + decrement available spins
```

## 7) Wallet Flow
```text
Income Sources:
   Task income + Referral daily + Referral one-time + Lucky wheel + Manual admin credit

Wallet Segments:
   task_income_balance
   referral_income_balance
   lucky_wheel_income_balance
   withdrawable_balance
```

All changes are append-only ledger writes via `transactions`.

## 8) Withdrawal Flow
```text
User requests withdrawal
   -> Validate:
        - active plan
        - minimum withdrawal by plan
        - weekly request limit (cycle)
        - max weekly amount (plan/settings)
   -> Create withdrawal request (PENDING)
Admin reviews
   -> APPROVE or REJECT
   -> If approved: debit withdrawable wallet + mark PAID when transferred
```

## 9) Admin Flow
```text
Admin Dashboard
   -> Manage plans (add/edit/delete/toggle)
   -> Manage plan tasks
   -> Manage users (block/upgrade/manual credit/debit)
   -> Manage withdrawals
   -> Manage lucky wheel rewards/probability
   -> Manage dynamic settings (platform/income/withdrawal/security)
```

## 10) Automation / Cron Flow
```text
Daily (00:00)
   -> DailyTaskSettlementJob
   -> ReferralDailyIncomeJob
   -> PlanExpiryJob

Weekly
   -> WeeklyWithdrawalCycleJob (reset request cycle windows)
```

## 11) Architecture + Data Relation
```text
Frontend (Web/App)
   -> Laravel API
      -> MySQL
      -> Payment Gateway API
      -> Queue + Scheduler
```

Key relational chain:
```text
users
 -> user_plans
 -> daily_tasks / referrals
 -> transactions
 -> wallets
 -> withdrawals
 -> lucky_wheel_spins
```

## 12) Security Flow
- Password hashing (bcrypt/argon).
- OTP verification option for user onboarding.
- Admin 2FA.
- Payment signature verification before plan activation.
- Anti-fake-referral checks (IP/device/rule limits).
- Audit logs for all financial and admin mutations.
