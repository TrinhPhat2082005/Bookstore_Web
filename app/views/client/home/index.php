<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%); min-height: 60vh; display: flex; align-items: center; overflow: hidden;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">
                        Mang cả thế giới <span class="text-primary">Tri thức</span> vào tầm tay bạn.
                    </h1>
                    <p class="lead text-secondary mb-5">
                        <?php echo $data['settings']['site_intro']; ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL; ?>product"
                            class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">Khám phá ngay</a>
                        <a href="<?php echo BASE_URL; ?>home/about"
                            class="btn btn-outline-secondary btn-lg px-5 rounded-pill">Về chúng tôi</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block hero-image-wrapper">
                    <div class="position-relative">
                        <div class="bg-primary rounded-circle position-absolute top-50 start-50 translate-middle opacity-10"
                            style="width: 100%; max-width: 400px; aspect-ratio: 1/1;"></div>
                        <img src="<?php echo BASE_URL; ?>assets/hero-books.png" alt="Books Hero"
                            class="img-fluid position-relative z-1"
                            style="max-height: 400px; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.1));">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Tại sao chọn chúng tôi?</h2>
                <p class="text-secondary lead">Cam kết mang lại trải nghiệm tốt nhất cho độc giả.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4 transition-hover">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-4 mb-4 d-inline-flex align-items-center justify-content-center"
                            style="width: 70px; height: 70px;">
                            <i class="fas fa-shipping-fast fs-2"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Giao hàng nhanh</h3>
                        <p class="text-secondary mb-0">Giao hàng toàn quốc trong vòng 2-3 ngày làm việc với dịch vụ vận
                            chuyển uy tín.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4 transition-hover">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-4 mb-4 d-inline-flex align-items-center justify-content-center"
                            style="width: 70px; height: 70px;">
                            <i class="fas fa-shield-alt fs-2"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Sách chính hãng</h3>
                        <p class="text-secondary mb-0">Chúng tôi cam kết 100% sách có bản quyền và chất lượng in ấn tốt
                            nhất.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 rounded-4 transition-hover">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-4 mb-4 d-inline-flex align-items-center justify-content-center"
                            style="width: 70px; height: 70px;">
                            <i class="fas fa-headset fs-2"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Hỗ trợ 24/7</h3>
                        <p class="text-secondary mb-0">Đội ngũ nhân viên giàu kinh nghiệm luôn sẵn sàng giải đáp mọi
                            thắc mắc của bạn.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>