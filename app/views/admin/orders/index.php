<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>Cập nhật trạng thái đơn hàng thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_msg'])): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Xem và quản lý trạng thái tất cả đơn hàng.</p>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <?php
    $statuses = [
        'pending' => ['label' => 'Chờ xử lý', 'color' => 'warning', 'icon' => 'clock'],
        'processing' => ['label' => 'Đang xử lý', 'color' => 'info', 'icon' => 'spinner'],
        'shipped' => ['label' => 'Đang giao', 'color' => 'primary', 'icon' => 'truck'],
        'delivered' => ['label' => 'Đã giao', 'color' => 'success', 'icon' => 'check-circle'],
        'cancelled' => ['label' => 'Đã hủy', 'color' => 'danger', 'icon' => 'ban']
    ];
    foreach ($statuses as $key => $s):
        $count = 0;
        foreach ($data['orders'] as $o) {
            if ($o->status == $key)
                $count++;
        }
        ?>
        <div class="col">
            <div class="admin-card py-3 text-center">
                <i class="fas fa-<?php echo $s['icon']; ?> text-<?php echo $s['color']; ?> mb-2"></i>
                <div class="fw-bold fs-4"><?php echo $count; ?></div>
                <small class="text-muted"><?php echo $s['label']; ?></small>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 fw-bold">
            Tổng cộng: <span class="badge" style="background: var(--primary-color);"><?php echo $data['total']; ?> đơn
                hàng</span>
        </h6>
        <small class="text-muted">Trang <?php echo $data['current_page']; ?> /
            <?php echo max(1, $data['total_pages']); ?></small>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Liên hệ</th>
                    <th class="text-end">Tổng tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Ngày đặt</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['orders'])): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-box-open fa-3x opacity-25 mb-3 d-block"></i>
                            Chưa có đơn hàng nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['orders'] as $order): ?>
                        <?php
                        $statusMap = [
                            'pending' => ['Chờ xử lý', 'warning'],
                            'processing' => ['Đang xử lý', 'info'],
                            'shipped' => ['Đang giao', 'primary'],
                            'delivered' => ['Đã giao', 'success'],
                            'cancelled' => ['Đã hủy', 'danger']
                        ];
                        [$statusLabel, $statusColor] = $statusMap[$order->status] ?? ['Unknown', 'secondary'];
                        ?>
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-primary">#<?php echo $order->id; ?></span>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo htmlspecialchars($order->customer_name); ?></div>
                                <small
                                    class="text-muted"><?php echo htmlspecialchars($order->customer_address ?? ''); ?></small>
                            </td>
                            <td>
                                <div class="small"><?php echo htmlspecialchars($order->customer_email); ?></div>
                                <?php if ($order->customer_phone): ?>
                                    <div class="small text-muted"><?php echo htmlspecialchars($order->customer_phone); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="text-end fw-bold" style="color: var(--primary-color);">
                                <?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫
                            </td>
                            <td class="text-center">
                                <form action="<?php echo BASE_URL; ?>admin/manageOrders" method="GET" class="d-inline">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                                    <select name="status"
                                        class="form-select form-select-sm rounded-3 border-0 fw-semibold text-<?php echo $statusColor; ?>"
                                        style="font-size: 0.8rem; background: transparent;" onchange="this.form.submit()"
                                        <?php echo $order->status === 'cancelled' ? 'disabled' : ''; ?>>
                                        <?php foreach ($statusMap as $val => [$label, $color]): ?>
                                            <?php $isSelected = ($order->status == $val) ? 'selected' : ''; ?>
                                            <option value="<?php echo $val; ?>" <?php echo $isSelected; ?>>
                                                <?php echo $label; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center small text-muted">
                                <?php echo date('d/m/Y', strtotime($order->created_at)); ?>
                                <div><?php echo date('H:i', strtotime($order->created_at)); ?></div>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo BASE_URL; ?>admin/viewOrder/<?php echo $order->id; ?>"
                                    class="btn btn-sm btn-outline-primary rounded-3" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($data['total_pages'] > 1): ?>
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Phân trang">
                <ul class="pagination mb-0">
                    <?php for ($p = 1; $p <= $data['total_pages']; $p++): ?>
                        <li class="page-item <?php echo $data['current_page'] == $p ? 'active' : ''; ?>">
                            <a class="page-link rounded-3 mx-1"
                                href="<?php echo BASE_URL; ?>admin/manageOrders?page=<?php echo $p; ?>">
                                <?php echo $p; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>