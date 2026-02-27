<?php
include '../includes/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

if (isset($_POST['delete_enquiry']) && csrf_is_valid($_POST['csrf_token'] ?? null)) {
    $id = (int) $_POST['delete_enquiry'];
    $stmt = $conn->prepare('DELETE FROM enquiries WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

$enquiries = $conn->query('SELECT e.*, p.title AS product_title FROM enquiries e LEFT JOIN products p ON p.id = e.product_id ORDER BY e.id DESC');
?>
<?php include 'includes/sidebar.php'; ?>
<div class="col-md-10 p-4">
    <h3>Manage Enquiries</h3>
    <table class="table table-bordered table-sm">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Product</th><th>Message</th><th>Date</th><th>Action</th></tr>
        <?php while ($row = $enquiries->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['product_title'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['message']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete enquiry?')">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                        <input type="hidden" name="delete_enquiry" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
