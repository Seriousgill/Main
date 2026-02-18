# Best Engineering Works (Regd.) Website + Admin Panel

## Tech Stack
- Frontend: HTML5, CSS3, Bootstrap 5, JavaScript
- Backend: Core PHP (PDO)
- Database: MySQL

## Installation
1. Import database schema and seed data:
   ```sql
   SOURCE database.sql;
   ```
2. Update DB credentials in `includes/db.php` if needed.
3. Serve project root `best-engineering/` in Apache/Nginx or PHP built-in server:
   ```bash
   php -S 0.0.0.0:8080 -t best-engineering
   ```

## Admin Login
- URL: `/admin/login.php`
- Username: `admin`
- Password: `123456`

## Features
- Dynamic products, categories, and product detail pages.
- Admin CMS for products, categories, content blocks, inquiries, SEO and site settings.
- Secure admin authentication with password hashing and sessions.
- CSRF token validation on sensitive forms.
- Prepared statements for all dynamic SQL writes and lookups.
