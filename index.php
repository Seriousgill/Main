<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div id="homeSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $sliderResult = $conn->query('SELECT * FROM slider ORDER BY id DESC');
        $active = 'active';
        if ($sliderResult && $sliderResult->num_rows > 0) {
            while ($row = $sliderResult->fetch_assoc()) {
                ?>
                <div class="carousel-item <?php echo $active; ?>">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="d-block w-100 slider-img" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p><?php echo htmlspecialchars($row['subtitle']); ?></p>
                        <a href="<?php echo htmlspecialchars($row['button_link']); ?>" class="btn btn-primary">
                            <?php echo htmlspecialchars($row['button_text']); ?>
                        </a>
                    </div>
                </div>
                <?php
                $active = '';
            }
        } else {
            ?>
            <div class="carousel-item active">
                <img src="https://placehold.co/1400x500?text=Shri+Balaji+Foundry" class="d-block w-100 slider-img" alt="Default slide">
                <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                    <h2>Engineering Strength, Built to Last</h2>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<section class="container py-5">
    <h2 class="text-center section-title">Our Products</h2>
    <div class="row g-4">
        <?php
        $productResult = $conn->query('SELECT * FROM products WHERE status = 1 ORDER BY id DESC LIMIT 6');
        if ($productResult && $productResult->num_rows > 0) {
            while ($row = $productResult->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top product-thumb" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <a href="product-details.php?slug=<?php echo urlencode($row['slug']); ?>" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p class="text-center">Products will appear here after adding from the admin panel.</p>
        <?php } ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
