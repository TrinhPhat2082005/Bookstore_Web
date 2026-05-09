<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="mb-4">Về chúng tôi</h5>
                <p class="text-secondary small"><?php echo $data['settings']['site_intro']; ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-4">Liên kết</h5>
                <ul class="list-unstyled text-secondary small">
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>home/about"
                            class="text-secondary text-decoration-none">Giới thiệu</a></li>
                    <li class="mb-2"><a href="<?php echo BASE_URL; ?>home/contact"
                            class="text-secondary text-decoration-none">Liên hệ</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none">Điều khoản dịch vụ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-4">Thông tin liên hệ</h5>
                <div class="text-secondary small">
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2" style="width: 20px;"></i>
                        <?php echo $data['settings']['site_address']; ?></p>
                    <p class="mb-2"><i class="fas fa-phone me-2" style="width: 20px;"></i>
                        <?php echo $data['settings']['site_phone']; ?></p>
                    <p class="mb-0"><i class="fas fa-envelope me-2" style="width: 20px;"></i>
                        <?php echo $data['settings']['site_email']; ?></p>
                </div>
            </div>
        </div>
        <hr class="my-4 opacity-10">
        <div class="text-center text-secondary small">
            &copy; <?php echo date('Y'); ?> <?php echo $data['settings']['site_name']; ?>. Toàn bộ bản quyền được bảo
            lưu.
        </div>
    </div>
</footer>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Vanilla Tilt JS for 3D Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
</body>

</html>