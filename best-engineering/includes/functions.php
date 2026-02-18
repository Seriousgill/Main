<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function slugify(string $text): string
{
    $slug = strtolower(trim($text));
    $slug = preg_replace('/[^a-z0-9-\s]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    return trim($slug, '-') ?: 'item';
}

function to_nullable_int(mixed $value): ?int
{
    if ($value === null || $value === '') {
        return null;
    }

    $int = filter_var($value, FILTER_VALIDATE_INT);
    return $int === false ? null : (int) $int;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validate_csrf(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function fetch_site_settings(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM site_settings ORDER BY id ASC LIMIT 1');
    $row = $stmt->fetch();

    if ($row) {
        return $row;
    }

    return [
        'id' => 0,
        'logo' => '',
        'phone' => '+91-00000-00000',
        'email' => 'info@bestengineeringworks.com',
        'address' => 'Industrial Area, Punjab, India',
    ];
}

function fetch_seo(PDO $pdo, string $page): array
{
    $stmt = $pdo->prepare('SELECT * FROM seo_settings WHERE page_key = ? LIMIT 1');
    $stmt->execute([$page]);
    return $stmt->fetch() ?: [
        'meta_title' => 'Best Engineering Works (Regd.)',
        'meta_description' => 'Industrial gears and paper dryers manufacturer.',
        'meta_keywords' => 'industrial gears,paper dryers,engineering works',
    ];
}

function get_homepage(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM homepage_content ORDER BY id ASC LIMIT 1');
    $row = $stmt->fetch();

    if ($row) {
        return $row;
    }

    return [
        'id' => 0,
        'hero_title' => 'Precision Industrial Gears & Paper Machinery Solutions',
        'hero_subtitle' => 'Delivering High-Performance Engineering Components for Over 50 Years.',
        'about_text' => 'Best Engineering Works (Regd.) is a leading manufacturer of industrial gears and paper machine components.',
        'featured_product_id' => null,
        'why_choose_us' => '',
    ];
}
