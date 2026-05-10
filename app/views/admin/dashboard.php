<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<!-- Statistics Section -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-icon bg-icon-purple">
                <i class="fa-solid fa-users"></i>
            </div>
            <h6 class="text-muted mb-1">Người dùng</h6>
            <h3 class="mb-0"><?php echo number_format($data['userCount']); ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-icon bg-icon-amber">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h6 class="text-muted mb-1">Đơn hàng</h6>
            <h3 class="mb-0"><?php echo number_format($data['orderCount']); ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-icon bg-icon-emerald">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
            <h6 class="text-muted mb-1">Doanh thu</h6>
            <h3 class="mb-0"><?php echo number_format($data['totalRevenue'], 0, ',', '.'); ?>₫</h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Placeholder -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Thống kê truy cập</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        7 ngày qua
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Hôm nay</a></li>
                        <li><a class="dropdown-item" href="#">Năm nay</a></li>
                    </ul>
                </div>
            </div>
            <div class="bg-light rounded p-5 text-center text-muted"
                style="height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <i class="fa-solid fa-chart-line fa-3x mb-3 opacity-25"></i>
                <p>Biểu đồ thống kê đang được xử lý...</p>
                <small>(Dữ liệu sẽ được kết nối sau)</small>
            </div>
        </div>
    </div>

    <!-- Right Column Placeholder (Most Active etc) -->
    <div class="col-lg-4">
        <div class="admin-card">
            <h5 class="mb-4">Thông báo mới</h5>
            <div class="list-group list-group-flush">
                <?php if (empty($data['notifications'])): ?>
                    <p class="text-muted small">Chưa có thông báo mới.</p>
                <?php else: ?>
                    <?php foreach ($data['notifications'] as $noti): ?>
                        <div class="list-group-item px-0 py-3 border-bottom border-light bg-transparent">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="badge rounded-circle p-2 bg-light"><i class="<?php echo $noti['icon']; ?>"></i></span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1 small font-weight-bold"><?php echo $noti['title']; ?></h6>
                                    <p class="mb-0 small text-muted"><?php echo $noti['content']; ?></p>
                                    <small class="text-muted opacity-50"><?php echo date('H:i d/m/Y', strtotime($noti['time'])); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button class="btn btn-sm btn-link text-decoration-none mt-3 w-100 p-0 text-start" 
                    data-bs-toggle="modal" data-bs-target="#notificationsModal">
                Xem tất cả thông báo
            </button>
        </div>
    </div>
</div>

<!-- All Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">Tất cả thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="list-group list-group-flush">
                    <?php foreach ($data['notifications'] as $noti): ?>
                        <div class="list-group-item px-0 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge rounded-circle p-2 bg-light"><i class="<?php echo $noti['icon']; ?>"></i></span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1 small font-weight-bold"><?php echo $noti['title']; ?></h6>
                                    <p class="mb-0 small text-muted"><?php echo $noti['content']; ?></p>
                                    <small class="text-muted opacity-50"><?php echo date('H:i d/m/Y', strtotime($noti['time'])); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>