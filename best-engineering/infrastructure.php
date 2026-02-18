<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'infrastructure');
$stmt = $pdo->query("SELECT content FROM content_blocks WHERE block_key='infrastructure' LIMIT 1");
$content = $stmt->fetchColumn() ?: "Heavy Duty Lathe Machines\nShaper Machines\nRadial Drill Machines\nPlanner Machines";
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>Infrastructure</h1>
    <p>Our manufacturing facility is equipped with advanced workshop machinery enabling dimensional accuracy, precision machining, and superior finishing.</p>
    <div class="row g-3">
        <?php foreach (array_filter(array_map('trim', explode("\n", $content))) as $item): ?>
            <div class="col-md-6"><div class="section-card"><?= e($item); ?></div></div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
