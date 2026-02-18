<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'quality');
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>Quality & Manufacturing</h1>
    <p>We follow strict quality control procedures from raw material inspection to final dispatch.</p>
    <div class="row g-3">
        <?php foreach (['Raw Material Inspection','Precision Machining','Dynamic Balancing','Hydraulic Testing','Surface Grinding & Finishing','Final Inspection & Dispatch'] as $step): ?>
            <div class="col-md-4"><div class="section-card"><?= e($step); ?></div></div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
