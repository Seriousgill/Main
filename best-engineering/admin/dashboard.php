<?php include __DIR__ . '/_header.php';
$productCount = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$inquiryCount = $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
$newCount = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status='new'")->fetchColumn();
?>
<h1>Dashboard</h1>
<div class="row g-3 mt-2">
  <div class="col-md-4"><div class="section-card"><h4>Total Products</h4><p class="display-6"><?= (int)$productCount; ?></p></div></div>
  <div class="col-md-4"><div class="section-card"><h4>Total Inquiries</h4><p class="display-6"><?= (int)$inquiryCount; ?></p></div></div>
  <div class="col-md-4"><div class="section-card"><h4>New Inquiries</h4><p class="display-6"><?= (int)$newCount; ?></p></div></div>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
