<?php
include __DIR__ . '/_header.php';

$home = get_homepage($pdo);
$blocks = [];
foreach ($pdo->query('SELECT block_key, content FROM content_blocks')->fetchAll() as $row) {
    $blocks[$row['block_key']] = $row['content'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf($_POST['csrf_token'] ?? null)) {
    $heroTitle = trim($_POST['hero_title'] ?? '');
    $heroSubtitle = trim($_POST['hero_subtitle'] ?? '');
    $aboutText = trim($_POST['about_text'] ?? '');
    $whyChooseUs = trim($_POST['why_choose_us'] ?? '');
    $featuredProductId = to_nullable_int($_POST['featured_product_id'] ?? null);

    if ((int)$home['id'] > 0) {
        $stmt = $pdo->prepare('UPDATE homepage_content SET hero_title=?, hero_subtitle=?, about_text=?, why_choose_us=?, featured_product_id=? WHERE id=?');
        $stmt->execute([$heroTitle, $heroSubtitle, $aboutText, $whyChooseUs, $featuredProductId, (int)$home['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO homepage_content (hero_title, hero_subtitle, about_text, why_choose_us, featured_product_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$heroTitle, $heroSubtitle, $aboutText, $whyChooseUs, $featuredProductId]);
    }

    foreach (['infrastructure', 'industries'] as $key) {
        $pdo->prepare('INSERT INTO content_blocks (block_key, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content=VALUES(content)')
            ->execute([$key, trim($_POST[$key] ?? '')]);
    }

    header('Location: content.php');
    exit;
}

$products = $pdo->query("SELECT id,name FROM products WHERE status='active' ORDER BY name")->fetchAll();
?>
<h1>Homepage & Content Blocks</h1>
<form method="post" class="section-card">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
    <div class="mb-3"><label>Hero Title</label><input class="form-control" name="hero_title" value="<?= e($home['hero_title']); ?>"></div>
    <div class="mb-3"><label>Hero Subtitle</label><textarea class="form-control" name="hero_subtitle"><?= e($home['hero_subtitle']); ?></textarea></div>
    <div class="mb-3"><label>About Preview</label><textarea class="form-control" name="about_text"><?= e($home['about_text']); ?></textarea></div>
    <div class="mb-3"><label>Why Choose Us (one point per line)</label><textarea class="form-control" rows="6" name="why_choose_us"><?= e($home['why_choose_us']); ?></textarea></div>
    <div class="mb-3">
        <label>Featured Product</label>
        <select class="form-select" name="featured_product_id">
            <option value="">Select</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= (int)$p['id']; ?>" <?= ((int)$home['featured_product_id'] === (int)$p['id']) ? 'selected' : ''; ?>><?= e($p['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Infrastructure (one per line)</label><textarea class="form-control" rows="5" name="infrastructure"><?= e($blocks['infrastructure'] ?? ''); ?></textarea></div>
    <div class="mb-3"><label>Industries (one per line)</label><textarea class="form-control" rows="5" name="industries"><?= e($blocks['industries'] ?? ''); ?></textarea></div>
    <button class="btn btn-warning">Save Content</button>
</form>
<?php include __DIR__ . '/_footer.php'; ?>
