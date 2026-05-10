<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <!-- Page Header -->
    <div class="bg-light py-3 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Trang
                            chủ</a></li>
                    <li class="breadcrumb-item active">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <h1 class="fw-bold mb-5">
                <i class="fas fa-shopping-cart text-primary me-2"></i>
                Giỏ hàng của bạn
                <span class="badge rounded-pill ms-2 fs-6" style="background: var(--primary-color);">
                    <?php echo count($data['cart']); ?> sách
                </span>
            </h1>

            <?php if (empty($data['cart'])): ?>
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart fa-5x text-secondary opacity-25"></i>
                    </div>
                    <h4 class="text-secondary mb-3">Giỏ hàng của bạn đang trống</h4>
                    <p class="text-secondary mb-4">Hãy thêm sách vào giỏ hàng để tiến hành mua sắm!</p>
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary btn-lg px-5 rounded-pill">
                        <i class="fas fa-book me-2"></i>Xem danh sách sách
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-0">
                                <form action="<?php echo BASE_URL; ?>cart/update" method="POST" id="cart-form">
                                    <?php Security::csrfField(); ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4 py-3 rounded-top-start-4">Sách</th>
                                                    <th class="text-center py-3">Đơn giá</th>
                                                    <th class="text-center py-3">Số lượng</th>
                                                    <th class="text-center py-3">Thành tiền</th>
                                                    <th class="text-center py-3 rounded-top-end-4">Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['cart'] as $id => $item): ?>
                                                    <tr>
                                                        <td class="ps-4 py-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <?php if ($item['image']): ?>
                                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($item['image']); ?>"
                                                                        alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                                        class="rounded-3 shadow-sm"
                                                                        style="width: 70px; height: 90px; object-fit: cover;">
                                                                <?php else: ?>
                                                                    <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                                                        style="width: 70px; height: 90px;">
                                                                        <i class="fas fa-book text-primary fs-4"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <h6 class="mb-1 fw-bold">
                                                                        <?php echo htmlspecialchars($item['name']); ?>
                                                                    </h6>
                                                                    <?php if ($item['author']): ?>
                                                                        <small class="text-secondary">
                                                                            <i
                                                                                class="fas fa-pen-nib me-1"></i><?php echo htmlspecialchars($item['author']); ?>
                                                                        </small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="fw-semibold" style="color: var(--primary-color);">
                                                                <?php echo number_format($item['price'], 0, ',', '.'); ?>₫
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="number" name="quantities[<?php echo $id; ?>]"
                                                                value="<?php echo $item['quantity']; ?>" min="1" max="99"
                                                                class="form-control form-control-sm text-center mx-auto"
                                                                style="width: 70px;" onchange="this.form.submit()">
                                                        </td>
                                                        <td class="text-center fw-bold">
                                                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="submit" formaction="<?php echo BASE_URL; ?>cart/remove/<?php echo $id; ?>" formmethod="POST"
                                                                class="btn btn-sm btn-outline-danger rounded-circle"
                                                                onclick="return confirm('Xóa sách này khỏi giỏ hàng?')"
                                                                title="Xóa">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Cart Actions -->
                                    <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                        <button type="submit" formaction="<?php echo BASE_URL; ?>cart/clear" formmethod="POST"
                                            class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                                            <i class="fas fa-trash me-1"></i>Xóa tất cả
                                        </button>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo BASE_URL; ?>product"
                                                class="btn btn-sm btn-outline-secondary rounded-pill">
                                                <i class="fas fa-arrow-left me-1"></i>Tiếp tục mua
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 90px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 pb-2 border-bottom">Tóm tắt đơn hàng</h5>

                                <div class="d-flex justify-content-between mb-2 text-secondary">
                                    <span>Tạm tính (<?php echo count($data['cart']); ?> sách)</span>
                                    <span><?php echo number_format($data['total'], 0, ',', '.'); ?>₫</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 text-secondary">
                                    <span>Phí vận chuyển</span>
                                    <span class="text-success fw-semibold">Miễn phí</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                    <span>Tổng cộng</span>
                                    <span style="color: var(--primary-color);">
                                        <?php echo number_format($data['total'], 0, ',', '.'); ?>₫
                                    </span>
                                </div>

                                <a href="<?php echo BASE_URL; ?>cart/checkout"
                                    class="btn btn-primary w-100 btn-lg rounded-3 fw-semibold">
                                    <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                                </a>

                                <!-- Secure Badges -->
                                <div class="text-center mt-3">
                                    <small class="text-secondary">
                                        <i class="fas fa-lock me-1"></i>Thanh toán an toàn &amp; bảo mật
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>