# UI Mockup Installation & Run Guide

## Requirements
- Any modern browser (Chrome/Edge/Firefox)
- Optional: Python 3 (for local static server)

## Quick Start (Option A: Open Directly)
1. Open `ui-mockup/index.html` in browser.
2. Navigate pages via links.

## Recommended (Option B: Local Server)
From repository root:
```bash
cd ui-mockup
python3 -m http.server 8080
```
Then open:
- `http://localhost:8080/index.html` (Landing)
- `http://localhost:8080/user/dashboard.html` (User panel)
- `http://localhost:8080/admin/dashboard.html` (Admin panel)

## Page Map
- Public: `index.html`, `register.html`, `login.html`
- User: `user/*.html`
- Admin: `admin/*.html`
- Theme/CSS: `assets/styles.css`
- Basic interactions: `assets/app.js`

## Customization
- Update color tokens in `assets/styles.css` `:root` block.
- Add/remove plans or modules by editing page card/table sections.
- Integrate with backend by replacing static placeholders with API-driven templates.

## Production Integration Notes
- Convert repeated layout sections into reusable components (Blade/React/Vue).
- Load dynamic data from APIs in `routes/api.php` contract.
- Add auth guards and route protection on actual framework routes.
