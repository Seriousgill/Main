<?php
include '../includes/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

if (isset($_POST['add_product'])) {
    $title = trim($_POST['title']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    $categoryId = (int) $_POST['category_id'];
    $description = trim($_POST['description']);
    $specifications = trim($_POST['specifications']);
    $price = trim($_POST['price']);
    $status = isset($_POST['status']) ? 1 : 0;
    $image = $_FILES['image']['name'] ?? '';

    if ($image !== '') {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }

    $stmt = $conn->prepare('INSERT INTO products (category_id, title, slug, description, specifications, image, price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('issssssi', $categoryId, $title, $slug, $description, $specifications, $image, $price, $status);
    $stmt->execute();
}

if (isset($_POST['delete_product']) && csrf_is_valid($_POST['csrf_token'] ?? null)) {
    $id = (int) $_POST['delete_product'];
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

$categories = $conn->query('SELECT id, name FROM categories ORDER BY name ASC');
$products = $conn->query('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id ORDER BY p.id DESC');
?>
<?php include 'includes/sidebar.php'; ?>
<div class="col-md-10 p-4">
    <h3>Manage Products</h3>
    <form method="post" enctype="multipart/form-data" class="row g-2 mb-4">
        <div class="col-md-3"><input class="form-control" name="title" placeholder="Product Title" required></div>
        <div class="col-md-2">
            <select class="form-select" name="category_id" required>
                <option value="">Category</option>
                <?php while ($cat = $categories->fetch_assoc()) { ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2"><input class="form-control" name="price" placeholder="Price"></div>
        <div class="col-md-2"><input class="form-control" type="file" name="image"></div>
        <div class="col-md-2 form-check pt-2"><input class="form-check-input" type="checkbox" name="status" checked> Active</div>
        <div class="col-md-6"><textarea class="form-control" name="description" placeholder="Description" rows="2"></textarea></div>
        <div class="col-md-4"><textarea class="form-control" name="specifications" placeholder="Specifications" rows="2"></textarea></div>
        <div class="col-md-2"><button class="btn btn-primary w-100" name="add_product">Add</button></div>
    </form>

    <table class="table table-bordered table-sm">
        <tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th>Action</th></tr>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></td>
                <td><?php echo $row['status'] ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete product?')">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                        <input type="hidden" name="delete_product" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
