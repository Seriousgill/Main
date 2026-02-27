<?php
include '../includes/db.php';
include 'includes/header.php';

if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    $status = isset($_POST['status']) ? 1 : 0;
    $image = $_FILES['image']['name'] ?? '';

    if ($image !== '') {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }

    $stmt = $conn->prepare('INSERT INTO categories (name, slug, image, status) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sssi', $name, $slug, $image, $status);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id = $id");
}

$categories = $conn->query('SELECT * FROM categories ORDER BY id DESC');
?>
<?php include 'includes/sidebar.php'; ?>
<div class="col-md-10 p-4">
    <h3>Manage Categories</h3>
    <form method="post" enctype="multipart/form-data" class="row g-2 mb-4">
        <div class="col-md-3"><input class="form-control" name="name" placeholder="Category Name" required></div>
        <div class="col-md-3"><input class="form-control" type="file" name="image"></div>
        <div class="col-md-2 form-check pt-2"><input class="form-check-input" type="checkbox" name="status" checked> <label class="form-check-label">Active</label></div>
        <div class="col-md-2"><button class="btn btn-primary" name="add_category">Add</button></div>
    </form>

    <table class="table table-bordered">
        <tr><th>ID</th><th>Name</th><th>Slug</th><th>Status</th><th>Action</th></tr>
        <?php while ($row = $categories->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['slug']); ?></td>
                <td><?php echo $row['status'] ? 'Active' : 'Inactive'; ?></td>
                <td><a class="btn btn-sm btn-danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete category?')">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
