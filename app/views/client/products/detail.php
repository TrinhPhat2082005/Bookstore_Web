<?php require_once '../app/views/client/layout/header.php'; ?>
<?php $product = $data['product']; ?>

<main>
    <!-- Breadcrumb -->
    <div class="bg-light py-3 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Trang
                            chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>product"
                            class="text-decoration-none">Sản phẩm</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($product->name); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Book Image -->
                <div class="col-lg-4 text-center">
                    <div class="sticky-top" style="top: 100px;">
                        <div class="book-frame shadow-lg mx-auto" style="max-width: 350px;">
                            <?php if ($product->image): ?>
                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                                    alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php else: ?>
                                <div class="h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-book fa-6x text-muted opacity-25"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($product->category): ?>
                            <div class="mt-4">
                                <a href="<?php echo BASE_URL; ?>product?category=<?php echo urlencode($product->category); ?>"
                                    class="badge bg-main text-dark glass-card rounded-pill text-decoration-none px-4 py-2 fs-6 ">
                                    <i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($product->category); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3 text-main"><?php echo htmlspecialchars($product->name); ?></h1>

                    <?php if ($product->author): ?>
                        <p class="text-secondary mb-5 fs-4">
                            <i class="fas fa-pen-nib me-2 text-accent"></i>
                            <span class="fw-medium"><?php echo htmlspecialchars($product->author); ?></span>
                        </p>
                    <?php endif; ?>

                    <!-- Price & Stock -->
                    <div class="glass-card p-4 mb-5 d-flex align-items-center gap-5 flex-wrap">
                        <div>
                            <div class="text-muted small mb-1">Giá bán</div>
                            <div class="fw-bold fs-1 text-accent">
                                <?php echo number_format($product->price, 0, ',', '.'); ?>₫
                            </div>
                        </div>
                        <div class="vr opacity-10 d-none d-sm-block"></div>
                        <div>
                            <div class="text-muted small mb-1">Tình trạng</div>
                            <?php if ($product->stock > 0): ?>
                                <span
                                    class="badge bg-success-subtle text-success rounded-pill fs-6 px-3 py-2 border border-success-subtle">
                                    <i class="fas fa-check-circle me-1"></i>Còn hàng (<?php echo $product->stock; ?>)
                                </span>
                            <?php else: ?>
                                <span
                                    class="badge bg-danger-subtle text-danger rounded-pill fs-6 px-3 py-2 border border-danger-subtle">
                                    <i class="fas fa-times-circle me-1"></i>Hết hàng
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <?php if ($product->description): ?>
                        <div class="mb-5">
                            <h5 class="fw-bold mb-4 text-main border-bottom pb-3">Giới thiệu nội dung</h5>
                            <div class="text-secondary fs-5 lh-lg article-body">
                                <?php echo $product->description; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3 pb-5 border-bottom">
                        <?php if ($product->stock > 0): ?>
                            <button class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg ajax-add-to-cart"
                                data-product-id="<?php echo $product->id; ?>" id="btn-add-cart">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                            </button>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg px-5 rounded-pill" disabled>
                                <i class="fas fa-ban me-2"></i>Sản phẩm tạm hết hàng
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-dark btn-lg px-4 rounded-pill">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="row g-4 mt-4">
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                    <i class="fas fa-shipping-fast text-primary fs-5"></i>
                                </div>
                                <span class="small fw-medium text-dark">Giao hàng nhanh</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                    <i class="fas fa-shield-alt text-primary fs-5"></i>
                                </div>
                                <span class="small fw-medium text-dark">Bản quyền 100%</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                                    <i class="fas fa-undo text-primary fs-5"></i>
                                </div>
                                <span class="small fw-medium text-dark">7 ngày đổi trả</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($data['related'])): ?>
        <section class="py-5 bg-body">
            <div class="container">
                <h3 class="fw-bold mb-5 text-main">Sách cùng danh mục</h3>
                <div class="swiper related-swiper pb-5">
                    <div class="swiper-wrapper">
                        <?php foreach ($data['related'] as $rel): ?>
                            <div class="swiper-slide">
                                <div class="book-card h-100">
                                    <div class="book-frame shadow-sm">
                                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $rel->id; ?>">
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($rel->image); ?>"
                                                alt="<?php echo htmlspecialchars($rel->name); ?>" loading="lazy">
                                        </a>
                                    </div>
                                    <div class="book-info text-center mt-3">
                                        <h6 class="book-title line-clamp-2"><?php echo htmlspecialchars($rel->name); ?></h6>
                                        <p class="text-secondary small mb-3"><?php echo htmlspecialchars($rel->author ?? 'Tác giả'); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="book-price">
                                                <?php echo number_format($rel->price, 0, ',', '.'); ?>₫
                                            </span>
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 ajax-add-to-cart"
                                                    data-product-id="<?php echo $rel->id; ?>">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Add Pagination & Navigation -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>