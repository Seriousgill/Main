<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'contact');
$settings = fetch_site_settings($pdo);
$success = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Invalid request token.';
    }

    $name = trim($_POST['name'] ?? '');
    $company = trim($_POST['company_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $phone === '' || $email === '' || $message === '') {
        $errors[] = 'Please fill required fields.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO inquiries (name, company_name, phone, email, product, message) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $company, $phone, $email, $product, $message]);
        $success = 'Thank you. We will contact you soon.';
    }
}

include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>Contact Us</h1>
    <p>Phone: <?= e($settings['phone']); ?> | Email: <?= e($settings['email']); ?> | Address: <?= e($settings['address']); ?></p>
    <?php if ($success): ?><div class="alert alert-success"><?= e($success); ?></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)); ?></div><?php endif; ?>
    <form method="post" class="section-card">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
        <div class="row g-3">
            <div class="col-md-6"><input class="form-control" name="name" placeholder="Name" required></div>
            <div class="col-md-6"><input class="form-control" name="company_name" placeholder="Company Name"></div>
            <div class="col-md-6"><input class="form-control" name="phone" placeholder="Phone" required></div>
            <div class="col-md-6"><input class="form-control" name="email" type="email" placeholder="Email" required></div>
            <div class="col-md-12"><input class="form-control" name="product" placeholder="Product Interested"></div>
            <div class="col-md-12"><textarea class="form-control" name="message" rows="4" placeholder="Message" required></textarea></div>
            <div class="col-md-12"><button class="btn btn-warning">Submit Inquiry</button></div>
        </div>
    </form>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
