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
                <img src="https://placehold.co/1400x520?text=Shri+Balaji+Foundry" class="d-block w-100 slider-img" alt="Default slide">
                <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                    <h2>Since 1968 - Trusted Engineering for Agriculture & Industry</h2>
                    <p>Chaff Cutters | Workshop Machinery | Casting | Fabrication</p>
                    <a href="contact.php" class="btn btn-primary">Request a Quote</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<section class="container py-5">
    <h2 class="text-center section-title">Our Product Categories</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>Chaff Cutters</h5>
                    <p class="small text-muted">Sarpanch Taj, Wheel-2, Bomb, Steel Gear, Heavy Duty, MLP and hand-operated models.</p>
                    <a href="products.php" class="btn btn-primary btn-sm">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>Workshop Machinery</h5>
                    <p class="small text-muted">Lathe, Drilling, Shaper, Plano Miller and Boring machines for industrial use.</p>
                    <a href="workshop-machinery.php" class="btn btn-primary btn-sm">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>Casting</h5>
                    <p class="small text-muted">CI/steel casting solutions for machine bodies, housings, frames, and OEM requirements.</p>
                    <a href="casting.php" class="btn btn-primary btn-sm">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5>Fabricated Components</h5>
                    <p class="small text-muted">Custom fabrication with cutting, bending, welding, and assembly as per drawings.</p>
                    <a href="fabrication.php" class="btn btn-primary btn-sm">Explore</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5">
    <h2 class="text-center section-title">Popular Chaff Cutter Models</h2>
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
            <div class="col-12">
                <div class="alert alert-info">Add products from admin to display model-wise cards here.</div>
            </div>
        <?php } ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
