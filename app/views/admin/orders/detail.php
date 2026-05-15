<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>
<?php $order = $data['order']; ?>

<div class="mb-4">
    <a href="<?php echo BASE_URL; ?>admin/manageOrders" class="btn btn-sm btn-outline-secondary rounded-3">
        <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <h5 class="fw-bold mb-4 pb-2 border-bottom">
                <i class="fas fa-box text-primary me-2"></i>Sản phẩm trong đơn
            </h5>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sách</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($item->product_image): ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($item->product_image); ?>"
                                                class="rounded-3" style="width:45px;height:55px;object-fit:cover;">
                                        <?php else: ?>
                                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                                style="width:45px;height:55px;">
                                                <i class="fas fa-book text-primary"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span
                                            class="fw-semibold"><?php echo htmlspecialchars($item->product_name); ?></span>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo $item->quantity; ?></td>
                                <td class="text-end"><?php echo number_format($item->price, 0, ',', '.'); ?>₫</td>
                                <td class="text-end fw-bold" style="color: var(--primary-color);">
                                    <?php echo number_format($item->price * $item->quantity, 0, ',', '.'); ?>₫
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="text-end fw-bold fs-5" style="color: var(--primary-color);">
                                <?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card mb-4">
            <h5 class="fw-bold mb-4 pb-2 border-bottom">
                <i class="fas fa-info-circle text-primary me-2"></i>Thông tin đơn #<?php echo $order->id; ?>
            </h5>
            <dl class="row mb-0">
                <dt class="col-5 text-muted small">Khách hàng</dt>
                <dd class="col-7 fw-semibold"><?php echo htmlspecialchars($order->customer_name); ?></dd>

                <dt class="col-5 text-muted small">Email</dt>
                <dd class="col-7"><?php echo htmlspecialchars($order->customer_email); ?></dd>

                <dt class="col-5 text-muted small">Điện thoại</dt>
                <dd class="col-7"><?php echo htmlspecialchars($order->customer_phone ?: '—'); ?></dd>

                <dt class="col-5 text-muted small">Địa chỉ</dt>
                <dd class="col-7"><?php echo htmlspecialchars($order->customer_address); ?></dd>

                <?php if ($order->note): ?>
                    <dt class="col-5 text-muted small">Ghi chú</dt>
                    <dd class="col-7 fst-italic"><?php echo htmlspecialchars($order->note); ?></dd>
                <?php endif; ?>

                <dt class="col-5 text-muted small">Ngày đặt</dt>
                <dd class="col-7"><?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></dd>
            </dl>
        </div>
        <div class="admin-card">
            <?php if ($order->status === 'cancelled'): ?>
                <div class="alert alert-danger py-2 small mb-3">
                    <i class="fas fa-ban me-1"></i> Đơn hàng đã bị hủy và không thể thay đổi.
                </div>
            <?php endif; ?>
            <form action="<?php echo BASE_URL; ?>admin/manageOrders" method="GET">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                <select name="status" class="form-select rounded-3 mb-3" <?php echo $order->status === 'cancelled' ? 'disabled' : ''; ?>>
                    <?php
                    $statusMap = [
                        'pending' => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipped' => 'Đang giao',
                        'delivered' => 'Đã giao',
                        'cancelled' => 'Đã hủy'
                    ];
                    foreach ($statusMap as $val => $label):
                        ?>
                        <option value="<?php echo $val; ?>" <?php echo $order->status == $val ? 'selected' : ''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary w-100 rounded-3" <?php echo $order->status === 'cancelled' ? 'disabled' : ''; ?>>
                    <i class="fas fa-save me-1"></i>Lưu trạng thái
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>