<?php require_once '../app/views/client/layout/header.php'; ?>

<div>
    <section class="hero-slider-section">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-slide"
                    style="background-image: url('<?php echo BASE_URL; ?>assets/bookstore_hero_premium.png');">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-7">
                                <div class="hero-glass-box p-4 p-md-5" data-aos="fade-right">
                                    <span class="text-uppercase letter-spacing-2 fw-bold text-accent mb-3 d-block">Chào
                                        mừng đến với cửa hàng của chúng tôi</span>
                                    <h1 class="hero-title display-4 fw-bold mb-4">
                                        Mang cả thế giới <br> <span class="text-accent">Tri thức</span> trong tầm tay
                                    </h1>
                                    <p class="hero-subtitle mb-5">
                                        <?php echo $data['settings']['site_intro'] ?? 'Khám phá bộ sưu tập sách được tuyển chọn kỹ lưỡng, từ nghệ thuật, thiết kế đến văn học kinh điển.'; ?>
                                    </p>
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo BASE_URL; ?>product"
                                            class="btn btn-primary px-5 shadow-lg">Khám phá ngay</a>
                                        <a href="<?php echo BASE_URL; ?>home/about" class="btn btn-outline-dark px-5">Về
                                            chúng tôi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide hero-slide"
                    style="background-image: url('<?php echo BASE_URL; ?>assets/bookstore_hero_premium_2.avif');">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-7">
                                <div class="hero-glass-box p-4 p-md-5">
                                    <span class="text-uppercase letter-spacing-2 fw-bold text-accent mb-3 d-block">Không
                                        gian văn hóa đọc</span>
                                    <h1 class="hero-title display-4 fw-bold mb-4">
                                        Nơi hội ngộ của <br> <span class="text-accent">Những tâm hồn</span> yêu sách
                                    </h1>
                                    <p class="hero-subtitle mb-5">
                                        Đắm mình trong không gian yên tĩnh và khám phá những đầu sách mới nhất từ khắp
                                        nơi trên thế giới.
                                    </p>
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo BASE_URL; ?>product"
                                            class="btn btn-primary px-5 shadow-lg">Xem tất cả sách</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next d-none d-md-flex"></div>
            <div class="swiper-button-prev d-none d-md-flex"></div>
        </div>
    </section>
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
                <div>
                    <span class="text-accent fw-bold text-uppercase small d-block mb-2"
                        style="letter-spacing: 1px;">Sách mới nhất</span>
                    <h2 class="h3 fw-bold mb-0">New Releases</h2>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-shop-all btn-dark">Xem thêm</a>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($data['products'])): ?>
                    <?php $delay = 0;
                    foreach ($data['products'] as $product): ?>
                        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="book-card">
                                <?php $delay += 100; ?>
                                <div class="book-frame shadow-sm">
                                    <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>">
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $product->image; ?>"
                                            alt="<?php echo htmlspecialchars($product->name); ?>" loading="lazy">
                                    </a>
                                </div>
                                <div class="book-info text-center mt-3">
                                    <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                                        class="book-title" title="<?php echo htmlspecialchars($product->name); ?>">
                                        <?php echo $product->name; ?>
                                    </a>
                                    <p class="book-author text-secondary small"><?php echo $product->author ?? 'Tác giả'; ?></p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span
                                            class="book-price"><?php echo number_format($product->price, 0, ',', '.'); ?>₫</span>
                                        <?php if ($product->stock > 0): ?>
                                            <button class="btn btn-primary btn-sm rounded-pill px-3 ajax-add-to-cart"
                                                data-product-id="<?php echo $product->id; ?>">
                                                <i class="fas fa-cart-plus me-1"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
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
    <section class="py-5 bg-body">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="glass-card p-5 text-center h-100 rounded-5">
                        <div class="mb-4 text-accent">
                            <i class="fas fa-shipping-fast fa-3x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Vận chuyển toàn quốc</h3>
                        <p class="text-secondary small mb-0">Giao hàng nhanh chóng và an toàn đến tận tay bạn.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass-card p-5 text-center h-100 rounded-5">
                        <div class="mb-4 text-accent">
                            <i class="fas fa-shield-alt fa-3x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Sách bản quyền</h3>
                        <p class="text-secondary small mb-0">Cam kết 100% sách chính hãng từ các nhà xuất bản uy tín.
                        </p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass-card p-5 text-center h-100 rounded-5">
                        <div class="mb-4 text-accent">
                            <i class="fas fa-sync-alt fa-3x"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Đổi trả dễ dàng</h3>
                        <p class="text-secondary small mb-0">Chính sách đổi trả linh hoạt trong vòng 7 ngày.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once '../app/views/client/layout/footer.php'; ?>