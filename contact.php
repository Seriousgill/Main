<?php include 'includes/header.php'; ?>
<section class="container py-5">
    <h1 class="section-title">Contact Shri Balaji Foundry</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">Thank you! Your enquiry has been submitted successfully.</div>
            <?php } ?>
            <form action="enquiry-process.php" method="post" class="row g-3">
                <div class="col-md-6"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
                <div class="col-md-6"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
                <div class="col-md-6"><input class="form-control" type="text" name="phone" placeholder="Phone" required></div>
                <div class="col-md-6"><input class="form-control" type="text" name="product_name" value="<?php echo htmlspecialchars($_GET['product'] ?? ''); ?>" placeholder="Model / Product Name"></div>
                <div class="col-12"><textarea class="form-control" name="message" rows="5" placeholder="Share your requirement: model, capacity, motor HP, phase, quantity, and delivery location" required></textarea></div>
                <div class="col-12"><button class="btn btn-primary" type="submit" name="submit_enquiry">Submit Enquiry</button></div>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-body">
                    <h5>Factory Address</h5>
                    <p>Shahabpura, G.T. Road, Batala, Punjab, India</p>
                    <h6>Office Address</h6>
                    <p>Railway Road, Opp. UCO Bank, Batala - 143505, Punjab, India</p>
                    <h6>Phone</h6>
                    <p class="mb-1">+91-98725-96664</p>
                    <p class="mb-1">+91-98780-98408</p>
                    <p class="mb-1">01871-242338 / 01871-241238</p>
                    <h6 class="mt-3">Email</h6>
                    <p class="mb-0">trehan_balaji@hotmail.com</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
