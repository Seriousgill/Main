# How to Install Laravel Visitor Management System on Hosting

## 1) Server requirements
- PHP 8.1+ with extensions: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- MySQL 8+
- Composer 2+
- Nginx or Apache

## 2) Upload project
1. Upload project files to hosting directory (e.g., `/var/www/visitor-management-system`).
2. Point your domain document root to `/public`.

## 3) Install dependencies
```bash
composer install --no-dev --optimize-autoloader
```

## 4) Configure environment
```bash
cp .env.example .env
php artisan key:generate
```
Update `.env` values:
- `APP_URL`
- `DB_*`
- mail/push credentials
- alarm/QR values (`config/alarm.php`, `config/qr.php`)

## 5) Database setup
```bash
php artisan migrate --force
php artisan db:seed --force
```

## 6) Storage/link and permissions
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

## 7) Build assets (if using Vite on production)
```bash
npm ci
npm run build
```

## 8) Optimize for production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 9) Queue + scheduler (recommended)
- Run queue worker with Supervisor/systemd:
```bash
php artisan queue:work --tries=3 --timeout=120
```
- Add cron:
```cron
* * * * * php /var/www/visitor-management-system/artisan schedule:run >> /dev/null 2>&1
```

## 10) Security checklist
- Force HTTPS
- Enable firewall/WAF
- Rotate app key and API tokens securely
- Enable rate limiting for API routes
- Review and monitor activity logs in `storage/logs`
