# MLM Software UI Wireframe & Layout Specification

## 1) Public Website (Landing)

## 1.1 Header
**Left:**
- Logo

**Center/Right Navigation:**
- Home
- Plans
- About
- Contact

**Actions (Right):**
- `Login` button
- `Register` button (highlight color)

## 1.2 Hero Section
**Heading:**
- “Earn Smart With Our Reward System”

**Subtext:**
- One-line trust/value statement about dynamic MLM income system.

**CTA Buttons:**
- `Get Started`
- `View Plans`

## 1.3 Plans Section
- 3 cards by default (dynamic rendering for unlimited plans)
- Each card shows:
  - Plan Name
  - Price
  - Validity
  - Daily Income
  - Referral Bonus
  - `Buy Now` button

## 1.4 How It Works Section
- Step 1: Register
- Step 2: Buy Plan
- Step 3: Complete Task
- Step 4: Withdraw Earnings

## 1.5 Footer
- About
- Terms
- Privacy
- Contact Info
- Social Links

---

## 2) Registration Page

## 2.1 Layout
- Centered card layout
- Responsive single-column form

## 2.2 Fields
- Full Name
- Email
- Mobile
- Password
- Confirm Password
- Referral Code
- Accept Terms checkbox

## 2.3 Buttons/Links
- `Register`
- “Already have account? `Login`”

## 2.4 Behavior
- Validate email/mobile uniqueness
- Validate referral code (if entered)
- Show inline validation messages

---

## 3) Login Page

## 3.1 Layout
- Simple centered card

## 3.2 Fields
- Email / Mobile
- Password

## 3.3 Buttons/Links
- `Login`
- `Forgot Password`

---

## 4) User Dashboard (Main Panel)

## 4.1 Left Sidebar
- Dashboard
- Buy Plan
- Daily Task
- Referral
- Lucky Wheel
- Wallet
- Withdraw
- Transactions
- Profile
- Support
- Logout

## 4.2 Top Bar
- User Name
- Notification Icon
- Wallet Balance
- Profile Icon

## 4.3 Main Dashboard Area
### Row 1 — Summary Cards
- Active Plan
- Total Earnings
- Today Income
- Referral Income
- Lucky Income
- Available Balance

### Row 2 — Quick Actions
- `Complete Task`
- `Refer Now`
- `Spin Wheel`
- `Withdraw Now`

### Row 3 — Visuals
- Monthly Earnings Chart

---

## 5) Buy Plan Page

## 5.1 Layout
- Card grid

## 5.2 Per Plan Card
- Plan Name
- Price
- Validity
- Income details
- `Buy Now`

## 5.3 Flow after Click
`Buy Now` -> payment popup -> gateway -> success screen -> active plan state

---

## 6) Daily Task Page

## 6.1 Top Summary
- Plan Status
- Days Remaining

## 6.2 Task Card
- Task Title
- Description
- Timer
- `Complete Task` button

## 6.3 Completion State
- Success animation/checkmark
- “Income Credited” message

---

## 7) Referral Page

## 7.1 Top Block
- Referral Link
- `Copy` button
- Share buttons (WhatsApp, Facebook)

## 7.2 Metrics
- Total Referrals
- Active Referrals
- Referral Income

## 7.3 Table
Columns:
- Name
- Plan
- Status
- Income Generated

---

## 8) Lucky Wheel Page

## 8.1 Main Area
- Wheel design (center)
- `Spin` button

## 8.2 Side Info
- Available Spins
- Prize List

## 8.3 History
- Spin History table

---

## 9) Wallet Page

## 9.1 Cards
- Task Income
- Referral Income
- Lucky Income
- Total Balance

## 9.2 Table
Columns:
- Date
- Type
- Amount
- Status

---

## 10) Withdrawal Page

## 10.1 Top Info
- Available Balance
- Minimum Withdrawal
- Weekly Limit

## 10.2 Form
Fields:
- Amount
- Payment Method

Buttons:
- `Submit`

## 10.3 History Table
- Request date
- Amount
- Method
- Status
- Admin remarks

---

## 11) Admin Panel Wireframe

## 11.1 Admin Dashboard
Cards:
- Total Users
- Active Plans
- Total Deposits
- Total Withdrawals
- Pending Withdrawals
- System Profit

Graphs:
- Daily Revenue
- Withdrawal Graph

## 11.2 Plan Management
Table columns:
- Plan Name
- Price
- Daily Income
- Referral Income
- Status
- `Edit`
- `Delete`

Top action:
- `Add Plan` (top-right)

## 11.3 User Management
- Search bar
- User table columns:
  - Name
  - Plan
  - Balance
  - Status
  - `Block`
  - `View Details`

## 11.4 Withdrawal Management
Table columns:
- User
- Amount
- Payment Details
- Status
- `Approve`
- `Reject`

## 11.5 Lucky Wheel Management
Table columns:
- Reward Amount
- Probability %
- Status
- `Edit`

---

## 12) Design System Recommendations
- Primary: Blue/Purple gradient
- Accent success: Green
- Accent debit/withdrawal: Red
- Rounded cards + soft shadows
- Font: Poppins or Inter
- Spacing scale: 8px base grid

---

## 13) Mobile Responsive Behavior
- Sidebar converts to bottom navigation
- Cards stack vertically
- Data tables are horizontal-scroll enabled
- Sticky action buttons for key flows (`Complete Task`, `Spin`, `Withdraw`)
- Touch target minimum 44px height

---

## 14) Final UI Outcome
This wireframe structure covers:
- Public website,
- full user panel,
- full admin panel,
- responsive layout,
- fintech modern visual style,
- scalable dynamic page structure.

## 15) Theme Integration
- Use the approved fintech palette/tokens from `docs/professional-color-theme.md`.
- Apply semantic colors consistently: income=success, withdrawal=danger, pending=warning.
- Keep contrast WCAG-compliant for text and button labels.
