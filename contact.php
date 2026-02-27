<?php include 'includes/header.php'; ?>
<section class="container py-5">
    <h1 class="section-title">Contact Us</h1>
    <form action="enquiry-process.php" method="post" class="row g-3">
        <div class="col-md-6"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
        <div class="col-md-6"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
        <div class="col-md-6"><input class="form-control" type="text" name="phone" placeholder="Phone" required></div>
        <div class="col-md-6"><input class="form-control" type="text" name="product_name" value="<?php echo htmlspecialchars($_GET['product'] ?? ''); ?>" placeholder="Product (optional)"></div>
        <div class="col-12"><textarea class="form-control" name="message" rows="5" placeholder="Your message" required></textarea></div>
        <div class="col-12"><button class="btn btn-primary" type="submit" name="submit_enquiry">Submit Enquiry</button></div>
    </form>
</section>
<?php include 'includes/footer.php'; ?>
