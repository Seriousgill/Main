<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shri Balaji Foundry - Manufacturer and exporter of chaff cutters, workshop machinery, casting, and fabricated components since 1968.">
    <title>Shri Balaji Foundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-xl navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Shri Balaji Foundry</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Chaff Cutters</a></li>
                <li class="nav-item"><a class="nav-link" href="workshop-machinery.php">Workshop Machinery</a></li>
                <li class="nav-item"><a class="nav-link" href="casting.php">Casting</a></li>
                <li class="nav-item"><a class="nav-link" href="fabrication.php">Fabrication</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
