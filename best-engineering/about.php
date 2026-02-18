<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$seo = fetch_seo($pdo, 'about');
include __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
    <h1>About Us</h1>
    <p>Best Engineering Works (Regd.) is a more than 50-year-old manufacturing company engaged in producing industrial gears and paper industry components.</p>
    <p>We manufacture: BC-901 Cast Nylon Gears, CI Press Rolls, Drying Cylinders, MG Gears, Bearing Housings, Washer Gears, Girth Gears, and Gear Box Repair Solutions.</p>
    <p>Our team continuously focuses on modernization, precision engineering, and strict quality control to deliver dependable and long-lasting industrial solutions.</p>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
