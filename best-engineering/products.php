<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'products');
$stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.status='active' ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>Products</h1>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4">
                <div class="section-card">
                    <p class="small text-accent mb-2"><?= e($product['category_name'] ?: 'Industrial Components'); ?></p>
                    <h4><?= e($product['name']); ?></h4>
                    <p><?= e($product['short_description']); ?></p>
                    <a href="product-details.php?slug=<?= e($product['slug']); ?>" class="btn btn-outline-warning btn-sm">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
