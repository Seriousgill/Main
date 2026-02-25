# Dynamic MLM Software Blueprint (Laravel + MySQL)

This repository contains a **full dynamic backend blueprint** for MLM software where admin can control everything without code edits:
- add/edit/delete plans,
- change plan pricing/income rules,
- configure daily tasks,
- configure referral payouts,
- configure lucky wheel rewards/probability,
- configure withdrawal rules,
- pause/resume platform modules.

## Included Business Baseline (Seed Data)

| Plan | Price | Validity | Daily Task Income | Daily Referral | One-Time Referral Bonus | Minimum Withdrawal |
|---|---:|---:|---:|---:|---:|---:|
| Silver | ₹1800 | 90 days | ₹50 | ₹5 | ₹160 | ₹400 |
| Gold | ₹4200 | 90 days | ₹120 | ₹10 | ₹340 | ₹850 |
| Diamond | ₹7400 | 90 days | ₹230 | ₹25 | ₹780 | ₹1200 |

Seeded lucky wheel reward pool: `₹5, ₹10, ₹56, ₹97, ₹109, ₹222, ₹555, ₹1200`.

## Dynamic Admin Controls

- **Plans**: unlimited add/edit/delete/toggle.
- **Plan tasks**: per-plan task type and reward.
- **Referral rules**: daily + one-time and on/off controls.
- **Lucky wheel**: reward list, probability weights, enable/disable.
- **Withdrawals**: minimum limits, weekly limits, fee %, auto/manual approval.
- **Platform/security**: maintenance mode, KYC requirement, anti-fraud settings.

## Files

- `database/schema.sql` — normalized SQL schema + seed values.
- `routes/api.php` — API routes for user + admin dynamic controls.
- `docs/api-contract.md` — API contract and automation/security behavior.
- `docs/technical-flow-diagram.md` — complete technical flow diagram requested.
- `docs/complete-system-documentation.md` — full professional documentation for all pages, buttons, features, and logic (user + admin).
- `docs/ui-wireframe-spec.md` — complete landing/user/admin UI wireframe and layout specification, including mobile behavior.
- `docs/professional-color-theme.md` — professional fintech color theme, design tokens, and component color guidelines.

## Automation (Cron)

- Daily task settlement (missed-task => no income).
- Daily referral income settlement.
- Plan expiry processing.
- Weekly withdrawal cycle enforcement.

## Notes

- Keep wallet updates transactional and idempotent.
- Use background workers for settlement reliability.
- Verify payment gateway signatures before plan activation.
- Add legal/compliance checks before launch (important for MLM programs).


## UI Mockup
- `ui-mockup/` contains complete landing + user + admin fintech MLM UI mockup.
- Run locally using instructions in `ui-mockup/INSTALL.md`.
