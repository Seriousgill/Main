# MLM Software Professional Color Theme & Design Tokens

## 1) Primary Brand Theme (Modern Fintech)

### Primary Color
- **Deep Royal Blue**: `#1E3A8A`
- Use for:
  - Header
  - Sidebar
  - Primary buttons
  - Active menu item

### Secondary Accent (Premium)
- **Purple Gradient**: `#6D28D9 -> #9333EA`
- Use for:
  - Hero gradients
  - Highlight CTAs
  - Premium actions (e.g., upgrade/spin)

### Semantic Colors
- **Success / Income**: `#16A34A`
- **Withdrawal / Error / Danger**: `#DC2626`
- **Warning / Pending**: `#F59E0B`
- **Primary Text**: `#111827`
- **Secondary Text**: `#6B7280`
- **Light Surface**: `#F9FAFB`

---

## 2) Background & Surface System
- **Main App Background**: `#F3F4F6`
- **Card Background**: `#FFFFFF`
- **Sidebar Background (User)**: `#111827`
- **Sidebar Active Item**: `#1E3A8A`

### Admin Theme Variant
- **Admin Sidebar**: `#0F172A`
- **Admin Highlight**: `#06B6D4`
- **Profit Card**: `#16A34A`
- **Loss Card**: `#DC2626`

---

## 3) Button Design System

### Primary Button
- Background: `#1E3A8A`
- Text: `#FFFFFF`
- Hover: `#1D4ED8`
- Use for: Buy Plan, Submit, Complete Task

### Success Button
- Background: `#16A34A`
- Hover: `#15803D`
- Use for: Approve Withdrawal, Confirm

### Danger Button
- Background: `#DC2626`
- Hover: `#B91C1C`
- Use for: Reject, Delete

### Premium Gradient Button
- Background: `linear-gradient(90deg, #6D28D9, #9333EA)`
- Use for: Spin Lucky Wheel, Upgrade Plan

---

## 4) Dashboard Card Color Guide

| Card Type | Background | Border |
|---|---|---|
| Total Earnings | White | Blue left border |
| Today Income | Light Green | Green border |
| Referral Income | Light Purple | Purple border |
| Withdrawal Balance | Light Yellow | Yellow border |
| Pending | Light Red | Red border |

Example border:
```css
border-left: 4px solid #1E3A8A;
```

---

## 5) Chart Color Palette
- **Income Line**: `#1E3A8A`
- **Income Fill**: `rgba(30, 58, 138, 0.2)`
- **Referral**: `#9333EA`
- **Withdrawal**: `#DC2626`

---

## 6) Lucky Wheel Palette
- Wheel section palette: Purple, Blue, Green, Yellow, Orange, Pink
- Center button: Purple gradient
- Winning text: Gold `#FBBF24`

---

## 7) Dark Mode (Optional Premium)
- **Background**: `#0F172A`
- **Card**: `#1E293B`
- **Text**: `#E5E7EB`
- **Primary**: `#3B82F6`
- **Success**: `#22C55E`

---

## 8) Typography & UI Style
- Font family: **Poppins** / **Inter**
- Heading: Bold
- Body: Regular
- Card shadow: `0 4px 12px rgba(0,0,0,0.05)`
- Card radius: `12px`
- Button radius: `8px`
- Icon set: Feather or Lucide

---

## 9) Suggested CSS Token Map
```css
:root {
  --color-primary: #1E3A8A;
  --color-primary-hover: #1D4ED8;
  --color-accent-1: #6D28D9;
  --color-accent-2: #9333EA;
  --color-success: #16A34A;
  --color-danger: #DC2626;
  --color-danger-hover: #B91C1C;
  --color-warning: #F59E0B;

  --text-primary: #111827;
  --text-secondary: #6B7280;

  --bg-main: #F3F4F6;
  --bg-surface: #F9FAFB;
  --bg-card: #FFFFFF;
  --bg-sidebar: #111827;
  --bg-sidebar-active: #1E3A8A;

  --radius-card: 12px;
  --radius-btn: 8px;
  --shadow-card: 0 4px 12px rgba(0,0,0,0.05);
}
```

---

## 10) Theme Outcome
This theme delivers:
- modern fintech style,
- premium trust-focused visual identity,
- clear income/withdraw status contrast,
- scalable token-based implementation for user + admin panels.
