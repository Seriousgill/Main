</main>
<footer class="footer py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <h5>Best Engineering Works (Regd.)</h5>
                <p class="mb-0">Precision Gears & Paper Dryers Manufacturer.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1"><strong>Phone:</strong> <?= e($settings['phone'] ?? ''); ?></p>
                <p class="mb-1"><strong>Email:</strong> <?= e($settings['email'] ?? ''); ?></p>
                <p class="mb-0"><strong>Address:</strong> <?= e($settings['address'] ?? ''); ?></p>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
