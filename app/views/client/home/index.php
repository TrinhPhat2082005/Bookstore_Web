<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="text-uppercase letter-spacing-2 fw-bold text-accent mb-3 d-block">Chào mừng đến với cửa
                        hàng của chúng tôi</span>
                    <h1 class="hero-title">
                        Mang cả thế giới <br> <span class="text-accent">Tri thức</span> trong tầm tay.
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo $data['settings']['site_intro'] ?? 'Khám phá bộ sưu tập sách được tuyển chọn kỹ lưỡng, từ nghệ thuật, thiết kế đến văn học kinh điển.'; ?>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary px-5">Khám phá ngay</a>
                        <a href="<?php echo BASE_URL; ?>home/about" class="btn btn-outline-primary px-5">Về chúng
                            tôi</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="<?php echo BASE_URL; ?>assets/bookstore_hero_premium.png" alt="Premium Bookstore"
                            class="img-fluid" style="filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12));">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section (New Releases) -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <span class="text-accent fw-bold text-uppercase small d-block mb-2"
                        style="letter-spacing: 1px;">Sách mới nhất</span>
                    <h2 class="h3 fw-bold mb-0">New Releases</h2>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="slider-arrows d-none d-md-flex mb-0">
                        <button class="arrow-btn" type="button"><i class="fas fa-chevron-left"></i></button>
                        <button class="arrow-btn" type="button"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-shop-all">Xem thêm</a>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($data['products'])): ?>
                    <?php foreach ($data['products'] as $product): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="book-card">
                                <div class="book-frame">
                                    <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>">
                                        <img src="<?php echo BASE_URL; ?>public/uploads/<?php echo $product->image; ?>"
                                            alt="<?php echo htmlspecialchars($product->name); ?>" loading="lazy">
                                    </a>
                                    <button class="quick-view-btn" type="button" title="Quick View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="book-info">
                                    <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                                        class="book-title" title="<?php echo htmlspecialchars($product->name); ?>">
                                        <?php echo $product->name; ?>
                                    </a>
                                    <p class="book-author"><?php echo $product->author ?? 'Tác giả'; ?></p>
                                    <span class="book-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="py-5 bg-light rounded-4">
                            <i class="fas fa-book-open fs-1 text-muted mb-3"></i>
                            <p class="text-muted">Đang cập nhật sản phẩm mới...</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5 bg-light-gray">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-shipping-fast fs-3 text-dark"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Vận chuyển toàn quốc</h3>
                    <p class="text-secondary small">Giao hàng nhanh chóng và an toàn đến tận tay bạn.</p>
                </div>
                <div class="col-md-4 text-center border-start border-end">
                    <div class="mb-4">
                        <i class="fas fa-shield-alt fs-3 text-dark"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Sách bản quyền</h3>
                    <p class="text-secondary small">Cam kết 100% sách chính hãng từ các nhà xuất bản uy tín.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-sync-alt fs-3 text-dark"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-3">Đổi trả dễ dàng</h3>
                    <p class="text-secondary small">Chính sách đổi trả linh hoạt trong vòng 7 ngày.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>