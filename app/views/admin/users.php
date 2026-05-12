<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Người dùng</h1>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> Thao tác thực hiện thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Tên người dùng / Email</th>
                            <th class="py-3">Họ tên</th>
                            <th class="py-3">Vai trò</th>
                            <th class="py-3">Trạng thái</th>
                            <th class="py-3">Ngày đăng ký</th>
                            <th class="px-4 py-3 text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td class="px-4 text-muted">#<?php echo $user->id; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($user->username); ?></div>
                                    <div class="small text-muted"><?php echo htmlspecialchars($user->email); ?></div>
                                </td>
                                <td><?php echo htmlspecialchars($user->full_name ?? 'N/A'); ?></td>
                                <td>
                                    <span class="badge <?php echo $user->role == 'admin' ? 'bg-dark' : 'bg-info'; ?> rounded-   pill">
                                        <?php echo $user->role == 'admin' ? 'Quản trị' : 'Khách hàng'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user->status == 'active'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Đang hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Đã bị khóa</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?php echo date('d/m/Y', strtotime($user->created_at)); ?></td>
                                <td class="px-4 text-end">
                                    <?php if ($user->role !== 'admin'): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                                <li>
                                                    <a class="dropdown-item py-2" href="?action=toggle_status&id=<?php echo $user->id; ?>">
                                                        <i class="fa-solid <?php echo $user->status == 'active' ? 'fa-user-slash' : 'fa-user-check'; ?> me-2 text-warning"></i>
                                                        <?php echo $user->status == 'active' ? 'Khóa người dùng' : 'Mở khóa'; ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2" href="?action=reset_password&id=<?php echo $user->id; ?>" 
                                                       onclick="return confirm('Mật khẩu sẽ được reset về mặc định (user123). Tiếp tục?')">
                                                        <i class="fa-solid fa-key me-2 text-info"></i> Reset mật khẩu
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item py-2 text-danger" href="?action=delete&id=<?php echo $user->id; ?>" 
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                        <i class="fa-solid fa-trash-can me-2"></i> Xóa vĩnh viễn
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-end pe-2">
                                            <span class="badge bg-light text-muted border rounded-pill">
                                                <i class="fa-solid fa-shield-halved me-1"></i> Hệ thống
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            <?php 
                $paginationData = [
                    'currentPage' => $data['current_page'],
                    'totalPages'  => $data['total_pages'],
                    'baseUrl'     => BASE_URL . 'admin/manageUsers'
                ];
                extract($paginationData);
                require '../layout/pagination.php';
            ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>
