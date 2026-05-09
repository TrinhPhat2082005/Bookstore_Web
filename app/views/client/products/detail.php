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
            <!-- Toast notification -->
            <?php if (isset($_GET['added'])): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>Đã thêm
                    "<strong><?php echo htmlspecialchars($product->name); ?></strong>" vào giỏ hàng!
                    <a href="<?php echo BASE_URL; ?>cart" class="btn btn-sm btn-success ms-3 rounded-pill">Xem giỏ hàng</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-5">
                <!-- Book Image -->
                <div class="col-lg-4 text-center">
                    <div class="sticky-top" style="top: 90px;">
                        <?php if ($product->image): ?>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                                alt="<?php echo htmlspecialchars($product->name); ?>" class="img-fluid rounded-4 shadow-lg"
                                style="max-height: 450px; object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-4 shadow-lg d-flex align-items-center justify-content-center bg-primary bg-opacity-10 mx-auto"
                                style="height: 400px; max-width: 300px;">
                                <i class="fas fa-book fa-6x text-primary opacity-40"></i>
                            </div>
                        <?php endif; ?>

                        <?php if ($product->category): ?>
                            <div class="mt-3">
                                <a href="<?php echo BASE_URL; ?>product?category=<?php echo urlencode($product->category); ?>"
                                    class="badge rounded-pill text-decoration-none px-3 py-2 fs-6"
                                    style="background-color: var(--primary-color);">
                                    <i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($product->category); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-2"><?php echo htmlspecialchars($product->name); ?></h1>

                    <?php if ($product->author): ?>
                        <p class="text-secondary mb-4 fs-5">
                            <i class="fas fa-pen-nib me-2"></i>
                            <span class="fw-semibold"><?php echo htmlspecialchars($product->author); ?></span>
                        </p>
                    <?php endif; ?>

                    <!-- Price & Stock -->
                    <div class="d-flex align-items-center gap-4 mb-4 p-4 bg-light rounded-4 flex-wrap price-stock-bar">
                        <div>
                            <div class="text-secondary small mb-1">Giá bán</div>
                            <div class="fw-bold fs-2" style="color: var(--primary-color);">
                                <?php echo number_format($product->price, 0, ',', '.'); ?>₫
                            </div>
                        </div>
                        <div class="vr"></div>
                        <div>
                            <div class="text-secondary small mb-1">Tình trạng</div>
                            <?php if ($product->stock > 0): ?>
                                <span class="badge bg-success rounded-pill fs-6 px-3 py-2">
                                    <i class="fas fa-check me-1"></i>Còn hàng (<?php echo $product->stock; ?>)
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill fs-6 px-3 py-2">
                                    <i class="fas fa-times me-1"></i>Hết hàng
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <?php if ($product->description): ?>
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Mô tả sách</h5>
                            <div class="text-secondary lh-lg"><?php echo $product->description; ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-3">
                        <?php if ($product->stock > 0): ?>
                            <a href="<?php echo BASE_URL; ?>cart/add/<?php echo $product->id; ?>"
                                class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="btn-add-cart">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg px-5 rounded-pill" disabled>
                                <i class="fas fa-ban me-2"></i>Hết hàng
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>product"
                            class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>

                    <!-- Delivery Info -->
                    <div class="row g-3 mt-4">
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-2 text-secondary small">
                                <i class="fas fa-shipping-fast text-primary fs-5"></i>
                                <span>Giao hàng toàn quốc</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-2 text-secondary small">
                                <i class="fas fa-shield-alt text-primary fs-5"></i>
                                <span>Sách chính hãng 100%</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-center gap-2 text-secondary small">
                                <i class="fas fa-undo text-primary fs-5"></i>
                                <span>Đổi trả trong 7 ngày</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($data['related'])): ?>
        <section class="py-5 bg-light">
            <div class="container">
                <h3 class="fw-bold mb-4">Sách cùng danh mục</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    <?php foreach ($data['related'] as $rel): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 transition-hover">
                                <?php if ($rel->image): ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($rel->image); ?>"
                                        class="card-img-top rounded-top-4" alt="<?php echo htmlspecialchars($rel->name); ?>"
                                        style="height: 180px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-top-4 d-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                                        style="height: 180px;">
                                        <i class="fas fa-book fa-3x text-primary opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-1 line-clamp-2"><?php echo htmlspecialchars($rel->name); ?></h6>
                                    <p class="text-secondary small mb-2"><?php echo htmlspecialchars($rel->author ?? ''); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold" style="color: var(--primary-color);">
                                            <?php echo number_format($rel->price, 0, ',', '.'); ?>₫
                                        </span>
                                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $rel->id; ?>"
                                            class="btn btn-sm btn-outline-primary rounded-3">Xem</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>