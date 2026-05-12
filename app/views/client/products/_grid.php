<!-- Toolbar -->
<div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
    <h2 class="h4 fw-bold mb-0 text-main">
        <?php echo count($data['products']); ?> sách được tìm thấy
    </h2>
    <div class="d-flex align-items-center gap-3">
        <label class="small text-muted d-none d-sm-block">Sắp xếp theo:</label>
        <select name="sort" class="form-select form-select-sm sort-select border-0 shadow-sm px-3" form="filter-form" id="sort-select">
            <option value="newest" <?php echo $data['filters']['sort'] === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
            <option value="price_asc" <?php echo $data['filters']['sort'] === 'price_asc' ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
            <option value="price_desc" <?php echo $data['filters']['sort'] === 'price_desc' ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
        </select>
    </div>
</div>

<!-- Active Filters Display -->
<?php if (!empty(array_filter($data['filters'], fn($v) => $v !== '' && $v !== 'newest'))): ?>
    <div class="d-flex flex-wrap gap-2 mb-4">
        <?php foreach ($data['filters'] as $key => $value): ?>
            <?php if (!empty($value) && $key !== 'sort'): ?>
                <span class="badge bg-main text-white glass-card rounded-pill px-3 py-2 fw-normal" style="background: var(--accent-color) !important;">
                    <?php
                    if ($key === 'availability')
                        echo $value === 'in_stock' ? 'Còn hàng' : 'Hết hàng';
                    elseif ($key === 'min_price')
                        echo 'Từ: ' . number_format($value) . '₫';
                    elseif ($key === 'max_price')
                        echo 'Đến: ' . number_format($value) . '₫';
                    else
                        echo htmlspecialchars($value);
                    ?>
                </span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (empty($data['products'])): ?>
    <div class="text-center py-5 my-5">
        <div class="mb-4">
            <i class="fas fa-search fa-4x text-muted opacity-25"></i>
        </div>
        <h3 class="fw-bold">Không tìm thấy sách phù hợp</h3>
        <p class="text-secondary">Vui lòng thử điều chỉnh bộ lọc hoặc từ khóa tìm kiếm.</p>
        <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary rounded-pill px-5 py-2 mt-3">Xóa tất cả bộ lọc</a>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 g-xl-5">
        <?php $delay = 0;
        foreach ($data['products'] as $product): ?>
            <div class="col" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <?php $delay = ($delay < 400) ? $delay + 100 : 0; ?>
                <div class="product-card">
                    <div class="image-wrapper shadow-sm position-relative">
                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                            class="text-decoration-none">
                            <?php if ($product->image): ?>
                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                                    alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php else: ?>
                                <div class="h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-book fa-3x text-muted opacity-25"></i>
                                </div>
                            <?php endif; ?>
                        </a>

                        <?php if ($product->stock <= 0): ?>
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-danger rounded-pill">Hết hàng</span>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Add Button (Hover) -->
                        <?php if ($product->stock > 0): ?>
                            <div class="quick-add d-flex justify-content-center">
                                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold ajax-add-to-cart" data-product-id="<?php echo $product->id; ?>">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-center mt-3">
                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                            class="text-decoration-none">
                            <h3 class="product-title"><?php echo htmlspecialchars($product->name); ?></h3>
                        </a>
                        <p class="product-author">
                            <?php echo htmlspecialchars($product->author ?? 'Unknown Author'); ?>
                        </p>
                        <p class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>₫</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
