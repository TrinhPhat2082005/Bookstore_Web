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
                <h5 class="mb-0">Doanh thu 7 ngày qua</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        Tuần này
                    </button>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="revenueChart"></canvas>
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

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create Gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($data['chartLabels']); ?>,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: <?php echo json_encode($data['chartValues']); ?>,
                borderColor: '#6366f1',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN').format(context.raw) + '₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { 
                                notation: "compact", 
                                compactDisplay: "short" 
                            }).format(value) + '₫';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            }
        }
    });
});
</script>

<?php require_once '../app/views/admin/layout/footer.php'; ?>