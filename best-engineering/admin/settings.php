<?php
include __DIR__ . '/_header.php';

$settings = fetch_site_settings($pdo);
$seoRows = $pdo->query('SELECT * FROM seo_settings ORDER BY page_key')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf($_POST['csrf_token'] ?? null)) {
    $logo = trim($_POST['logo'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ((int)$settings['id'] > 0) {
        $pdo->prepare('UPDATE site_settings SET logo=?, phone=?, email=?, address=? WHERE id=?')
            ->execute([$logo, $phone, $email, $address, (int)$settings['id']]);
    } else {
        $pdo->prepare('INSERT INTO site_settings (logo, phone, email, address) VALUES (?, ?, ?, ?)')
            ->execute([$logo, $phone, $email, $address]);
    }

    if (!empty($_POST['seo'])) {
        foreach ($_POST['seo'] as $id => $meta) {
            $pdo->prepare('UPDATE seo_settings SET meta_title=?, meta_description=?, meta_keywords=? WHERE id=?')->execute([
                trim($meta['meta_title'] ?? ''),
                trim($meta['meta_description'] ?? ''),
                trim($meta['meta_keywords'] ?? ''),
                (int)$id,
            ]);
        }
    }

    header('Location: settings.php');
    exit;
}
?>
<h1>Website Settings & SEO</h1>
<form method="post" class="section-card mb-4">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
    <h5>Contact Settings</h5>
    <div class="row g-2 mb-3">
        <div class="col-md-6"><input class="form-control" name="logo" value="<?= e($settings['logo']); ?>" placeholder="Logo path"></div>
        <div class="col-md-6"><input class="form-control" name="phone" value="<?= e($settings['phone']); ?>" placeholder="Phone"></div>
        <div class="col-md-6"><input class="form-control" name="email" value="<?= e($settings['email']); ?>" placeholder="Email"></div>
        <div class="col-md-6"><input class="form-control" name="address" value="<?= e($settings['address']); ?>" placeholder="Address"></div>
    </div>

    <h5>SEO Settings</h5>
    <?php foreach ($seoRows as $row): ?>
        <div class="border rounded p-3 mb-2">
            <strong><?= e($row['page_key']); ?></strong>
            <input class="form-control my-2" name="seo[<?= (int)$row['id']; ?>][meta_title]" value="<?= e($row['meta_title']); ?>" placeholder="Meta title">
            <textarea class="form-control my-2" name="seo[<?= (int)$row['id']; ?>][meta_description]" placeholder="Meta description"><?= e($row['meta_description']); ?></textarea>
            <input class="form-control" name="seo[<?= (int)$row['id']; ?>][meta_keywords]" value="<?= e($row['meta_keywords']); ?>" placeholder="Meta keywords">
        </div>
    <?php endforeach; ?>

    <button class="btn btn-warning">Save Settings</button>
</form>
<?php include __DIR__ . '/_footer.php'; ?>
