<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<section class="container py-5">
    <h1 class="section-title">Chaff Cutters</h1>
    <p class="mb-4">Shri Balaji Foundry manufactures the Sarpanch range of chaff cutters for livestock feed preparation. These machines are designed to cut hay, straw, and grass into small pieces for better digestibility and reduced labor.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="info-chip">Sarpanch Taj (up to ~800 kg/hr)*</div></div>
        <div class="col-md-3"><div class="info-chip">Wheel-2 (~500+ kg/hr)*</div></div>
        <div class="col-md-3"><div class="info-chip">Bomb / Side Spring</div></div>
        <div class="col-md-3"><div class="info-chip">Steel Gear / Heavy Duty</div></div>
    </div>
    <small class="text-muted d-block mb-4">*Throughput depends on fodder type, motor HP, and operating conditions.</small>

    <div class="row g-4">
        <?php
        $query = 'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE p.status = 1 ORDER BY p.id DESC';
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top product-thumb" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted mb-2"><?php echo htmlspecialchars($row['category_name'] ?? 'General'); ?></p>
                            <a class="btn btn-primary btn-sm" href="product-details.php?slug=<?php echo urlencode($row['slug']); ?>">View Details</a>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-info">No model-wise products found in database. You can add all models from Admin → Manage Products.</div>
            </div>
        <?php } ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
