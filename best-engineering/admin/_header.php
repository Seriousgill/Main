<?php require_once __DIR__ . '/_init.php'; require_admin(); ?>
<!doctype html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head><body class="admin-layout">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container"><a class="navbar-brand" href="dashboard.php">Admin CMS</a>
  <ul class="navbar-nav ms-auto gap-2">
    <li class="nav-item"><a class="nav-link" href="manage-products.php">Products</a></li>
    <li class="nav-item"><a class="nav-link" href="manage-categories.php">Categories</a></li>
    <li class="nav-item"><a class="nav-link" href="content.php">Content</a></li>
    <li class="nav-item"><a class="nav-link" href="inquiries.php">Inquiries</a></li>
    <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
  </ul></div>
</nav>
<div class="container py-4">
