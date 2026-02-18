<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=? AND p.status='active' LIMIT 1");
$stmt->execute([$slug]);
$product = $stmt->fetch();
$seo = fetch_seo($pdo, 'product-details');
if (!$product) {
    http_response_code(404);
    include __DIR__ . '/includes/header.php';
    echo '<section class="container py-5"><h1>Product Not Found</h1></section>';
    include __DIR__ . '/includes/footer.php';
    exit;
}
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1><?= e($product['name']); ?></h1>
    <p class="text-accent"><?= e($product['category_name'] ?: 'Industrial Components'); ?></p>
    <div class="section-card mb-4">
        <p><?= nl2br(e($product['full_description'])); ?></p>
    </div>
    <div class="section-card">
        <h4>Specifications</h4>
        <p><?= nl2br(e($product['specifications'])); ?></p>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
