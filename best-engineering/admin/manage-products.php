<?php
include __DIR__ . '/_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf($_POST['csrf_token'] ?? null)) {
    $action = $_POST['action'] ?? 'save';

    if ($action === 'delete') {
        $deleteId = to_nullable_int($_POST['delete_id'] ?? null);
        if ($deleteId !== null) {
            $pdo->prepare('DELETE FROM products WHERE id = ?')->execute([$deleteId]);
        }
        header('Location: manage-products.php');
        exit;
    }

    $id = to_nullable_int($_POST['id'] ?? null) ?? 0;
    $name = trim($_POST['name'] ?? '');

    if ($name !== '') {
        $data = [
            to_nullable_int($_POST['category_id'] ?? null),
            $name,
            slugify($name),
            trim($_POST['short_description'] ?? ''),
            trim($_POST['full_description'] ?? ''),
            trim($_POST['specifications'] ?? ''),
            trim($_POST['image'] ?? ''),
            ($_POST['featured'] ?? 'no') === 'yes' ? 'yes' : 'no',
            ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active',
        ];

        if ($id > 0) {
            $sql = 'UPDATE products SET category_id=?, name=?, slug=?, short_description=?, full_description=?, specifications=?, image=?, featured=?, status=? WHERE id=?';
            $stmt = $pdo->prepare($sql);
            $data[] = $id;
            $stmt->execute($data);
        } else {
            $sql = 'INSERT INTO products (category_id,name,slug,short_description,full_description,specifications,image,featured,status) VALUES (?,?,?,?,?,?,?,?,?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
        }
    }

    header('Location: manage-products.php');
    exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $editId = to_nullable_int($_GET['edit'] ?? null);
    if ($editId !== null) {
        $st = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $st->execute([$editId]);
        $edit = $st->fetch();
    }
}

$categories = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY name")->fetchAll();
$products = $pdo->query('SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC')->fetchAll();
?>
<h1>Manage Products</h1>

<form method="post" class="section-card mb-4">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0); ?>">

    <div class="row g-2">
        <div class="col-md-4"><input class="form-control" name="name" value="<?= e($edit['name'] ?? ''); ?>" placeholder="Product name" required></div>
        <div class="col-md-4">
            <select class="form-select" name="category_id">
                <option value="">Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int)$cat['id']; ?>" <?= ((int)($edit['category_id'] ?? 0) === (int)$cat['id']) ? 'selected' : ''; ?>><?= e($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4"><input class="form-control" name="image" value="<?= e($edit['image'] ?? ''); ?>" placeholder="Image filename"></div>
        <div class="col-md-6"><textarea class="form-control" name="short_description" rows="2" placeholder="Short description"><?= e($edit['short_description'] ?? ''); ?></textarea></div>
        <div class="col-md-6"><textarea class="form-control" name="full_description" rows="2" placeholder="Full description"><?= e($edit['full_description'] ?? ''); ?></textarea></div>
        <div class="col-md-6"><textarea class="form-control" name="specifications" rows="3" placeholder="Specifications"><?= e($edit['specifications'] ?? ''); ?></textarea></div>
        <div class="col-md-3"><select class="form-select" name="featured"><option value="no">Not Featured</option><option value="yes" <?= (($edit['featured'] ?? '') === 'yes') ? 'selected' : ''; ?>>Featured</option></select></div>
        <div class="col-md-3"><select class="form-select" name="status"><option value="active">Active</option><option value="inactive" <?= (($edit['status'] ?? '') === 'inactive') ? 'selected' : ''; ?>>Inactive</option></select></div>
        <div class="col-md-3"><button class="btn btn-warning w-100"><?= $edit ? 'Update' : 'Add'; ?> Product</button></div>
    </div>
</form>

<div class="section-card">
    <table class="table table-sm">
        <tr><th>Name</th><th>Category</th><th>Status</th><th>Actions</th></tr>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= e($p['name']); ?></td>
                <td><?= e($p['category_name'] ?? '-'); ?></td>
                <td><?= e($p['status']); ?></td>
                <td>
                    <a class="btn btn-sm btn-outline-warning" href="?edit=<?= (int)$p['id']; ?>">Edit</a>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="delete_id" value="<?= (int)$p['id']; ?>">
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete product?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
