<?php require_once '../app/views/client/layout/header.php'; ?>
<?php $order = $data['order']; ?>

<main>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Card -->
                    <div class="card border-0 shadow-sm rounded-4 text-center p-5 mb-4">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10"
                                style="width: 100px; height: 100px;">
                                <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-success mb-3">Đặt hàng thành công!</h2>
                        <p class="text-secondary fs-5 mb-2">
                            Cảm ơn bạn, <strong><?php echo htmlspecialchars($order->customer_name); ?></strong>!
                        </p>
                        <p class="text-secondary mb-0">
                            Đơn hàng <strong class="text-primary">#<?php echo $order->id; ?></strong> của bạn đã được
                            ghi nhận.
                            Chúng tôi sẽ liên hệ qua email
                            <strong><?php echo htmlspecialchars($order->customer_email); ?></strong> để xác nhận.
                        </p>
                    </div>

                    <!-- Order Info -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 pb-2 border-bottom">
                                <i class="fas fa-file-alt text-primary me-2"></i>Thông tin đơn hàng
                                #<?php echo $order->id; ?>
                            </h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="text-secondary small mb-1">Người nhận</div>
                                    <div class="fw-semibold"><?php echo htmlspecialchars($order->customer_name); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-secondary small mb-1">Email</div>
                                    <div class="fw-semibold"><?php echo htmlspecialchars($order->customer_email); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-secondary small mb-1">Số điện thoại</div>
                                    <div class="fw-semibold">
                                        <?php echo htmlspecialchars($order->customer_phone ?: 'Không có'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-secondary small mb-1">Trạng thái</div>
                                    <span class="badge bg-warning text-dark rounded-pill px-3">
                                        <i class="fas fa-clock me-1"></i>Đang xử lý
                                    </span>
                                </div>
                                <div class="col-12">
                                    <div class="text-secondary small mb-1">Địa chỉ giao hàng</div>
                                    <div class="fw-semibold"><?php echo htmlspecialchars($order->customer_address); ?>
                                    </div>
                                </div>
                                <?php if ($order->note): ?>
                                    <div class="col-12">
                                        <div class="text-secondary small mb-1">Ghi chú</div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($order->note); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 pb-2 border-bottom">
                                <i class="fas fa-box text-primary me-2"></i>Sản phẩm đã đặt
                            </h5>
                            <?php foreach ($data['items'] as $item): ?>
                                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                    <?php if ($item->product_image): ?>
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($item->product_image); ?>"
                                            class="rounded-3" style="width:60px;height:75px;object-fit:cover;"
                                            alt="<?php echo htmlspecialchars($item->product_name); ?>">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                            style="width:60px;height:75px;">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold mb-1"><?php echo htmlspecialchars($item->product_name); ?>
                                        </h6>
                                        <div class="text-secondary small">
                                            Đơn giá: <?php echo number_format($item->price, 0, ',', '.'); ?>₫ &times;
                                            <?php echo $item->quantity; ?>
                                        </div>
                                    </div>
                                    <div class="fw-bold" style="color: var(--primary-color);">
                                        <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>₫
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="d-flex justify-content-between fw-bold fs-5 pt-2">
                                <span>Tổng cộng</span>
                                <span style="color: var(--primary-color);">
                                    <?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary px-5 rounded-pill">
                            <i class="fas fa-book me-2"></i>Tiếp tục mua sắm
                        </a>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-secondary px-5 rounded-pill">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>