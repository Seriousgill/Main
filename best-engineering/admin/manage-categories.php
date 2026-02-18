<?php
include __DIR__ . '/_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf($_POST['csrf_token'] ?? null)) {
    $action = $_POST['action'] ?? 'create';

    if ($action === 'delete') {
        $deleteId = to_nullable_int($_POST['delete_id'] ?? null);
        if ($deleteId !== null) {
            $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
            $stmt->execute([$deleteId]);
        }
        header('Location: manage-categories.php');
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
        $stmt = $pdo->prepare('INSERT INTO categories (name, slug, status) VALUES (?, ?, ?)');
        $stmt->execute([$name, slugify($name), $status]);
    }

    header('Location: manage-categories.php');
    exit;
}

$categories = $pdo->query('SELECT * FROM categories ORDER BY id DESC')->fetchAll();
?>
<h1>Manage Categories</h1>
<form method="post" class="section-card mb-4">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
    <input type="hidden" name="action" value="create">
    <div class="row g-2">
        <div class="col-md-5"><input class="form-control" name="name" placeholder="Category name" required></div>
        <div class="col-md-3"><select class="form-select" name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
        <div class="col-md-2"><button class="btn btn-warning w-100">Add</button></div>
    </div>
</form>
<div class="section-card">
    <table class="table">
        <tr><th>ID</th><th>Name</th><th>Status</th><th></th></tr>
        <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= (int)$c['id']; ?></td>
                <td><?= e($c['name']); ?></td>
                <td><?= e($c['status']); ?></td>
                <td>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="delete_id" value="<?= (int)$c['id']; ?>">
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete category?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
