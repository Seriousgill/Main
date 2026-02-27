<?php
include '../includes/db.php';
include 'includes/header.php';
?>
<?php include 'includes/sidebar.php'; ?>
<div class="col-md-10 p-4">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>
    <div class="row g-3 mt-2">
        <?php
        $stats = [
            'Products' => 'SELECT COUNT(*) AS total FROM products',
            'Categories' => 'SELECT COUNT(*) AS total FROM categories',
            'Slider Items' => 'SELECT COUNT(*) AS total FROM slider',
            'Enquiries' => 'SELECT COUNT(*) AS total FROM enquiries',
        ];

        foreach ($stats as $label => $query) {
            $res = $conn->query($query);
            $total = $res ? (int) $res->fetch_assoc()['total'] : 0;
            ?>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6><?php echo $label; ?></h6>
                        <h3><?php echo $total; ?></h3>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
