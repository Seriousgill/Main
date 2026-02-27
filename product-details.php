<?php
include 'includes/db.php';
$slug = $_GET['slug'] ?? '';
$stmt = $conn->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.slug = ? LIMIT 1');
$stmt->bind_param('s', $slug);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
include 'includes/header.php';
?>
<section class="container py-5">
    <?php if ($product) { ?>
        <h1 class="section-title"><?php echo htmlspecialchars($product['title']); ?></h1>
        <div class="row g-4">
            <div class="col-md-5">
                <img class="img-fluid rounded" src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
            </div>
            <div class="col-md-7">
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name'] ?? 'General'); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <h5>Specifications</h5>
                <p><?php echo nl2br(htmlspecialchars($product['specifications'])); ?></p>
                <a class="btn btn-primary" href="contact.php?product=<?php echo urlencode($product['title']); ?>">Enquire Now</a>
            </div>
        </div>
    <?php } else { ?>
        <p>Product not found.</p>
    <?php } ?>
</section>
<?php include 'includes/footer.php'; ?>
