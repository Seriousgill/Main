<?php
include '../includes/db.php';
include 'includes/header.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM enquiries WHERE id = $id");
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
                <td><a class="btn btn-sm btn-danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete enquiry?')">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
