<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <!-- Breadcrumb -->
    <div class="bg-light py-3 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Trang
                            chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>cart" class="text-decoration-none">Giỏ
                            hàng</a></li>
                    <li class="breadcrumb-item active">Thanh toán</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <h1 class="fw-bold mb-5">
                <i class="fas fa-credit-card text-primary me-2"></i>Thanh toán
            </h1>

            <!-- Progress Steps -->
            <div class="d-flex align-items-center justify-content-center gap-2 mb-5">
                <div class="d-flex align-items-center gap-2 text-secondary">
                    <span class="badge rounded-circle d-flex align-items-center justify-content-center bg-success"
                        style="width:32px;height:32px;">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="d-none d-sm-inline small fw-semibold">Giỏ hàng</span>
                </div>
                <div class="flex-grow-1 mx-2 border-top" style="max-width: 80px;"></div>
                <div class="d-flex align-items-center gap-2" style="color: var(--primary-color);">
                    <span class="badge rounded-circle d-flex align-items-center justify-content-center"
                        style="width:32px;height:32px;background:var(--primary-color);">2</span>
                    <span class="d-none d-sm-inline small fw-bold">Thông tin</span>
                </div>
                <div class="flex-grow-1 mx-2 border-top" style="max-width: 80px;"></div>
                <div class="d-flex align-items-center gap-2 text-secondary">
                    <span class="badge rounded-circle d-flex align-items-center justify-content-center bg-secondary"
                        style="width:32px;height:32px; opacity:0.4;">3</span>
                    <span class="d-none d-sm-inline small">Xác nhận</span>
                </div>
            </div>

            <div class="row g-5">
                <!-- Checkout Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h5 class="fw-bold mb-4">Thông tin giao hàng</h5>

                            <form action="<?php echo BASE_URL; ?>cart/checkout" method="POST" id="checkout-form">
                                <?php Security::csrfField(); ?>
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label fw-semibold">
                                        Họ và tên <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name"
                                        class="form-control rounded-3 <?php echo !empty($data['name_err']) ? 'is-invalid' : ''; ?>"
                                        placeholder="Nguyễn Văn A"
                                        value="<?php echo htmlspecialchars($data['customer_name'] ?? ''); ?>">
                                    <?php if (!empty($data['name_err'])): ?>
                                        <div class="invalid-feedback"><?php echo $data['name_err']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="customer_email" class="form-label fw-semibold">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" id="customer_email" name="customer_email"
                                            class="form-control rounded-3 <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>"
                                            placeholder="email@example.com"
                                            value="<?php echo htmlspecialchars($data['customer_email'] ?? ''); ?>">
                                        <?php if (!empty($data['email_err'])): ?>
                                            <div class="invalid-feedback"><?php echo $data['email_err']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customer_phone" class="form-label fw-semibold">Số điện thoại</label>
                                        <input type="tel" id="customer_phone" name="customer_phone"
                                            class="form-control rounded-3" placeholder="0912 345 678"
                                            value="<?php echo htmlspecialchars($data['customer_phone'] ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="customer_address" class="form-label fw-semibold">
                                        Địa chỉ giao hàng <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="customer_address" name="customer_address"
                                        class="form-control rounded-3 <?php echo !empty($data['address_err']) ? 'is-invalid' : ''; ?>"
                                        placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành"
                                        value="<?php echo htmlspecialchars($data['customer_address'] ?? ''); ?>">
                                    <?php if (!empty($data['address_err'])): ?>
                                        <div class="invalid-feedback"><?php echo $data['address_err']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label for="note" class="form-label fw-semibold">Ghi chú đơn hàng</label>
                                    <textarea id="note" name="note" class="form-control rounded-3" rows="3"
                                        placeholder="Ghi chú cho người giao hàng (tùy chọn)..."><?php echo htmlspecialchars($data['note'] ?? ''); ?></textarea>
                                </div>

                                <!-- Payment Method (Display Only) -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Phương thức thanh toán</label>
                                    <div class="form-check p-3 border rounded-3 bg-light">
                                        <input class="form-check-input" type="radio" name="payment" id="cod" value="cod"
                                            checked>
                                        <label class="form-check-label ms-2 fw-semibold" for="cod">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                                            Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <a href="<?php echo BASE_URL; ?>cart"
                                        class="btn btn-outline-secondary rounded-3 px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary flex-grow-1 rounded-3 fw-semibold"
                                        id="btn-place-order">
                                        <i class="fas fa-check-circle me-2"></i>Đặt hàng ngay
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 pb-2 border-bottom">
                                Đơn hàng của bạn
                                <span class="badge rounded-pill ms-1 fs-6" style="background: var(--primary-color);">
                                    <?php echo count($data['cart']); ?>
                                </span>
                            </h5>

                            <!-- Cart Items Summary -->
                            <div class="mb-4" style="max-height: 320px; overflow-y: auto;">
                                <?php foreach ($data['cart'] as $id => $item): ?>
                                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                        <?php if ($item['image']): ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($item['image']); ?>"
                                                class="rounded-3 flex-shrink-0" style="width:55px;height:70px;object-fit:cover;"
                                                alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <?php else: ?>
                                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width:55px;height:70px;">
                                                <i class="fas fa-book text-primary"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="fw-semibold mb-1 small">
                                                <?php echo htmlspecialchars($item['name']); ?></h6>
                                            <small
                                                class="text-secondary d-block mb-1"><?php echo htmlspecialchars($item['author'] ?? ''); ?></small>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-secondary">x<?php echo $item['quantity']; ?></small>
                                                <small class="fw-bold" style="color: var(--primary-color);">
                                                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Price Summary -->
                            <div class="d-flex justify-content-between mb-2 text-secondary small">
                                <span>Tạm tính</span>
                                <span><?php echo number_format($data['total'], 0, ',', '.'); ?>₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-secondary small">
                                <span>Phí vận chuyển</span>
                                <span class="text-success fw-semibold">Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Tổng cộng</span>
                                <span style="color: var(--primary-color);">
                                    <?php echo number_format($data['total'], 0, ',', '.'); ?>₫
                                </span>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded-3 text-center">
                                <small class="text-secondary">
                                    <i class="fas fa-lock me-1 text-success"></i>
                                    Thông tin của bạn được bảo mật tuyệt đối
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>