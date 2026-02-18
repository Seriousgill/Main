<?php
include __DIR__ . '/_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf($_POST['csrf_token'] ?? null)) {
    if (($_POST['action'] ?? '') === 'mark_contacted') {
        $id = to_nullable_int($_POST['inquiry_id'] ?? null);
        if ($id !== null) {
            $pdo->prepare("UPDATE inquiries SET status='contacted' WHERE id=?")->execute([$id]);
        }
    }
    header('Location: inquiries.php');
    exit;
}

$inquiries = $pdo->query('SELECT * FROM inquiries ORDER BY id DESC')->fetchAll();
?>
<h1>Inquiries Management</h1>
<div class="section-card">
    <table class="table table-sm">
        <tr><th>Date</th><th>Name</th><th>Contact</th><th>Product</th><th>Status</th><th></th></tr>
        <?php foreach ($inquiries as $q): ?>
            <tr>
                <td><?= e($q['created_at']); ?></td>
                <td><?= e($q['name']); ?><br><small><?= e($q['company_name']); ?></small></td>
                <td><?= e($q['phone']); ?><br><?= e($q['email']); ?></td>
                <td><?= e($q['product']); ?><br><small><?= e($q['message']); ?></small></td>
                <td><?= e($q['status']); ?></td>
                <td>
                    <?php if ($q['status'] === 'new'): ?>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                            <input type="hidden" name="action" value="mark_contacted">
                            <input type="hidden" name="inquiry_id" value="<?= (int)$q['id']; ?>">
                            <button class="btn btn-sm btn-warning">Mark Contacted</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
