<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$settings = fetch_site_settings($pdo);
$seo = $seo ?? ['meta_title' => 'Best Engineering Works', 'meta_description' => '', 'meta_keywords' => ''];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($seo['meta_title']); ?></title>
    <meta name="description" content="<?= e($seo['meta_description']); ?>">
    <meta name="keywords" content="<?= e($seo['meta_keywords']); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="sticky-top main-header">
    <nav class="navbar navbar-expand-lg navbar-dark container py-3">
        <a class="navbar-brand fw-bold" href="index.php">BEST ENGINEERING WORKS</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="infrastructure.php">Infrastructure</a></li>
                <li class="nav-item"><a class="nav-link" href="industries.php">Industries</a></li>
                <li class="nav-item"><a class="nav-link" href="quality.php">Quality</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="btn btn-warning btn-sm ms-lg-2" href="quote.php">Request a Quote</a></li>
            </ul>
        </div>
    </nav>
</header>
<main>
