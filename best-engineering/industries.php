<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'industries');
$stmt = $pdo->query("SELECT content FROM content_blocks WHERE block_key='industries' LIMIT 1");
$content = $stmt->fetchColumn() ?: "Paper Industry\nSugar Industry\nCement Industry\nHeavy Engineering Sector";
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>Industries We Serve</h1>
    <div class="row g-3">
        <?php foreach (array_filter(array_map('trim', explode("\n", $content))) as $item): ?>
            <div class="col-md-3"><div class="section-card text-center"><?= e($item); ?></div></div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
