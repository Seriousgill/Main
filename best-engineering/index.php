<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'home');
$home = get_homepage($pdo);
$featuredStmt = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
$featured = null;
if (!empty($home['featured_product_id'])) {
    $featuredStmt->execute([$home['featured_product_id']]);
    $featured = $featuredStmt->fetch();
}
$products = $pdo->query("SELECT * FROM products WHERE status='active' ORDER BY created_at DESC LIMIT 6")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<section class="hero text-center">
    <div class="container">
        <h1 class="display-5 fw-bold"><?= e($home['hero_title']); ?></h1>
        <p class="lead mb-4"><?= e($home['hero_subtitle']); ?></p>
        <a href="quote.php" class="btn btn-warning me-2">Request a Quote</a>
        <a href="products.php" class="btn btn-outline-light">View Products</a>
    </div>
</section>
<section class="container py-5">
    <h2>About Preview</h2>
    <p><?= e($home['about_text']); ?></p>
</section>
<section class="container pb-5">
    <h2>Why Choose Us</h2>
    <div class="row g-3">
        <?php $points = array_filter(array_map('trim', explode("\n", $home['why_choose_us'] ?: "50+ Years of Manufacturing Excellence\nUp to 6000 mm Diameter Capability\nUp to 40 Module Gear Manufacturing\nHigh-Speed Machine Compatibility (750 MPM)\nDynamically Balanced Components\nReliable After-Sales Support")));
        foreach ($points as $point): ?>
            <div class="col-md-4"><div class="section-card"><?= e($point); ?></div></div>
        <?php endforeach; ?>
    </div>
</section>
<section class="container pb-5">
    <h2>Featured Product</h2>
    <div class="section-card">
        <h3><?= e($featured['name'] ?? 'BC-901 Cast Nylon Gears & Pinions'); ?></h3>
        <p><?= e($featured['short_description'] ?? 'Reduced Noise, Vibration Absorption, No Lubrication, High Wear Resistance'); ?></p>
        <a class="btn btn-warning btn-sm" href="products.php">Explore Products</a>
    </div>
</section>
<section class="container pb-5">
    <h2>Industries Served</h2>
    <div class="row g-3">
        <?php foreach (['Paper Industry','Sugar Industry','Cement Industry','Heavy Engineering Sector'] as $industry): ?>
            <div class="col-md-3"><div class="section-card text-center"><?= e($industry); ?></div></div>
        <?php endforeach; ?>
    </div>
</section>
<section class="container pb-5">
    <h2>Products</h2>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4"><div class="section-card"><h4><?= e($product['name']); ?></h4><p><?= e($product['short_description']); ?></p><a href="product-details.php?slug=<?= e($product['slug']); ?>" class="btn btn-outline-warning btn-sm">View Details</a></div></div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
