<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="profile-page py-5"
    style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 80vh;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-4">
                <div class="glass-card p-4 rounded-4 shadow-sm h-100 sticky-top" style="top: 100px;">
                    <div class="text-center mb-4">
                        <div class="avatar-wrapper mb-3 mx-auto">
                            <i class="fas fa-user-circle text-primary" style="font-size: 5rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($data['user']->username); ?></h4>
                        <p class="text-muted small"><?php echo htmlspecialchars($data['user']->email); ?></p>
                        <span class="badge bg-primary-subtle text-primary px-3 rounded-pill">Thành viên</span>
                    </div>

                    <div class="nav flex-column nav-pills" id="profile-tabs" role="tablist">
                        <button class="nav-link active text-start mb-2 rounded-3 p-3" id="info-tab"
                            data-bs-toggle="pill" data-bs-target="#info-pane" type="button">
                            <i class="fas fa-id-card me-2"></i> Thông tin cá nhân
                        </button>
                        <button class="nav-link text-start mb-2 rounded-3 p-3" id="password-tab" data-bs-toggle="pill"
                            data-bs-target="#password-pane" type="button">
                            <i class="fas fa-key me-2"></i> Đổi mật khẩu
                        </button>
                        <button class="nav-link text-start mb-2 rounded-3 p-3" id="orders-tab" data-bs-toggle="pill"
                            data-bs-target="#orders-pane" type="button">
                            <i class="fas fa-shopping-bag me-2"></i> Lịch sử đơn hàng
                        </button>
                        <hr class="my-3">
                        <a href="<?php echo BASE_URL; ?>auth/logout"
                            class="nav-link text-start text-danger rounded-3 p-3">
                            <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="glass-card p-4 p-md-5 rounded-4 shadow-sm min-vh-50">

                    <?php if (isset($_SESSION['success_msg'])): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm"
                            role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $_SESSION['success_msg'];
                            unset($_SESSION['success_msg']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm"
                            role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo $_SESSION['error_msg'];
                            unset($_SESSION['error_msg']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="tab-content" id="profile-tabs-content">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="info-pane" role="tabpanel">
                            <h3 class="fw-bold mb-4">Thông tin cá nhân</h3>
                            <form action="<?php echo BASE_URL; ?>auth/profile" method="POST">
                                <input type="hidden" name="action" value="update_profile">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tên đăng nhập</label>
                                        <input type="text" class="form-control rounded-3 bg-light"
                                            value="<?php echo htmlspecialchars($data['user']->username); ?>" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" class="form-control rounded-3"
                                            value="<?php echo htmlspecialchars($data['user']->email); ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Họ và tên</label>
                                        <input type="text" name="full_name" class="form-control rounded-3"
                                            value="<?php echo htmlspecialchars($data['user']->full_name ?? ''); ?>"
                                            placeholder="Nhập họ và tên của bạn">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control rounded-3"
                                            value="<?php echo htmlspecialchars($data['user']->phone ?? ''); ?>"
                                            placeholder="Nhập số điện thoại">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                                        <textarea name="address" class="form-control rounded-3" rows="3"
                                            placeholder="Nhập địa chỉ nhận hàng của bạn"><?php echo htmlspecialchars($data['user']->address ?? ''); ?></textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit"
                                            class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                            Lưu thay đổi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password-pane" role="tabpanel">
                            <h3 class="fw-bold mb-4">Đổi mật khẩu</h3>
                            <form action="<?php echo BASE_URL; ?>auth/profile" method="POST">
                                <input type="hidden" name="action" value="change_password">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Mật khẩu hiện tại</label>
                                        <input type="password" name="old_password" class="form-control rounded-3"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Mật khẩu mới</label>
                                        <input type="password" name="new_password" class="form-control rounded-3"
                                            required minlength="6">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="confirm_password" class="form-control rounded-3"
                                            required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit"
                                            class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                            Cập nhật mật khẩu
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Order History Tab -->
                        <div class="tab-pane fade" id="orders-pane" role="tabpanel">
                            <h3 class="fw-bold mb-4">Lịch sử đơn hàng</h3>
                            <?php if (empty($data['orders'])): ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-shopping-cart text-light-emphasis" style="font-size: 4rem;"></i>
                                    </div>
                                    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                                    <a href="<?php echo BASE_URL; ?>product"
                                        class="btn btn-outline-primary rounded-pill px-4">Mua sắm ngay</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-light">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0">Mã đơn</th>
                                                <th class="border-0">Ngày đặt</th>
                                                <th class="border-0 text-end">Tổng cộng</th>
                                                <th class="border-0 text-center">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data['orders'] as $order): ?>
                                                <tr>
                                                    <td class="fw-bold">#ORD-<?php echo $order->id; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($order->created_at)); ?></td>
                                                    <td class="text-end fw-semibold text-primary">
                                                        <?php echo number_format($order->total_amount, 0, ',', '.'); ?>đ
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        $badge_class = 'bg-secondary';
                                                        $status_text = 'Đang xử lý';
                                                        switch ($order->status) {
                                                            case 'pending':
                                                                $badge_class = 'bg-warning-subtle text-warning';
                                                                $status_text = 'Chờ xử lý';
                                                                break;
                                                            case 'processing':
                                                                $badge_class = 'bg-info-subtle text-info';
                                                                $status_text = 'Đang xử lý';
                                                                break;
                                                            case 'shipped':
                                                                $badge_class = 'bg-primary-subtle text-primary';
                                                                $status_text = 'Đang giao';
                                                                break;
                                                            case 'delivered':
                                                                $badge_class = 'bg-success-subtle text-success';
                                                                $status_text = 'Đã giao';
                                                                break;
                                                            case 'cancelled':
                                                                $badge_class = 'bg-danger-subtle text-danger';
                                                                $status_text = 'Đã hủy';
                                                                break;
                                                        }
                                                        ?>
                                                        <span
                                                            class="badge <?php echo $badge_class; ?> px-3 rounded-pill"><?php echo $status_text; ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .nav-pills .nav-link {
        color: #495057;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background: rgba(var(--bs-primary-rgb), 0.05);
    }

    .nav-pills .nav-link.active {
        background: var(--bs-primary);
        box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.25);
    }

    .avatar-wrapper {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.15);
        border-color: var(--bs-primary);
    }

    .min-vh-50 {
        min-height: 50vh;
    }
</style>

<?php require_once '../app/views/client/layout/footer.php'; ?>