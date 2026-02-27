<?php
include '../includes/db.php';
include 'includes/header.php';

if (isset($_POST['add_slider'])) {
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $buttonText = trim($_POST['button_text']);
    $buttonLink = trim($_POST['button_link']);
    $image = $_FILES['image']['name'] ?? '';

    if ($image !== '') {
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }

    $stmt = $conn->prepare('INSERT INTO slider (title, subtitle, image, button_text, button_link) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $title, $subtitle, $image, $buttonText, $buttonLink);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM slider WHERE id = $id");
}

$items = $conn->query('SELECT * FROM slider ORDER BY id DESC');
?>
<?php include 'includes/sidebar.php'; ?>
<div class="col-md-10 p-4">
    <h3>Manage Slider</h3>
    <form method="post" enctype="multipart/form-data" class="row g-2 mb-4">
        <div class="col-md-3"><input class="form-control" name="title" placeholder="Title" required></div>
        <div class="col-md-3"><input class="form-control" name="subtitle" placeholder="Subtitle" required></div>
        <div class="col-md-2"><input class="form-control" name="button_text" placeholder="Button Text" required></div>
        <div class="col-md-2"><input class="form-control" name="button_link" placeholder="Button Link" required></div>
        <div class="col-md-2"><input class="form-control" type="file" name="image"></div>
        <div class="col-md-12"><button class="btn btn-primary" name="add_slider">Add Slide</button></div>
    </form>

    <table class="table table-bordered">
        <tr><th>ID</th><th>Title</th><th>Button</th><th>Action</th></tr>
        <?php while ($row = $items->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['button_text']); ?></td>
                <td><a class="btn btn-sm btn-danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete slide?')">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
