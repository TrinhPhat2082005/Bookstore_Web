<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php
        if ($_GET['success'] == 'added')
            echo 'Sản phẩm đã được thêm thành công!';
        elseif ($_GET['success'] == 'updated')
            echo 'Sản phẩm đã được cập nhật!';
        elseif ($_GET['success'] == 'deleted')
            echo 'Sản phẩm đã được xóa!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Quản lý toàn bộ danh mục sách trong hệ thống.</p>
    </div>
    <a href="<?php echo BASE_URL; ?>admin/addProduct" class="btn btn-primary rounded-3">
        <i class="fas fa-plus me-1"></i>Thêm sách mới
    </a>
</div>
<div class="admin-card mb-4">
    <form method="GET" action="<?php echo BASE_URL; ?>admin/manageProducts" class="row g-3 align-items-end">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="keyword" class="form-control border-start-0 ps-0"
                    placeholder="Tìm theo tên sách, tác giả..."
                    value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 rounded-3">
                <i class="fas fa-filter me-1"></i>Lọc
            </button>
        </div>
        <div class="col-md-2">
            <a href="<?php echo BASE_URL; ?>admin/manageProducts" class="btn btn-outline-secondary w-100 rounded-3">
                <i class="fas fa-undo me-1"></i>Xóa lọc
            </a>
        </div>
    </form>
</div>
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 fw-bold">
            Tổng cộng: <span class="badge"
                style="background: var(--primary-color);"><?php echo count($data['products']); ?> sách</span>
        </h6>
        <small class="text-muted">Trang <?php echo $data['current_page']; ?> /
            <?php echo max(1, $data['total_pages']); ?></small>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Sách</th>
                    <th>Danh mục</th>
                    <th class="text-end">Giá</th>
                    <th class="text-center">Kho</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['products'])): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-book fa-3x opacity-25 mb-3 d-block"></i>
                            Chưa có sản phẩm nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['products'] as $i => $product): ?>
                        <tr>
                            <td class="ps-3 text-secondary small">
                                <?php echo (($data['current_page'] - 1) * 10) + $i + 1; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($product->image): ?>
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                                            class="rounded-3" style="width:45px;height:55px;object-fit:cover;"
                                            alt="<?php echo htmlspecialchars($product->name); ?>">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                            style="width:45px;height:55px;">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($product->name); ?></div>
                                        <small
                                            class="text-muted"><?php echo htmlspecialchars($product->author ?? 'N/A'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if ($product->category): ?>
                                    <span
                                        class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                        <?php echo htmlspecialchars($product->category); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end fw-semibold" style="color: var(--primary-color);">
                                <?php echo number_format($product->price, 0, ',', '.'); ?>₫
                            </td>
                            <td class="text-center">
                                <?php if ($product->stock == 0): ?>
                                    <span class="badge bg-danger rounded-pill">Hết</span>
                                <?php elseif ($product->stock <= 5): ?>
                                    <span class="badge bg-warning text-dark rounded-pill"><?php echo $product->stock; ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success rounded-pill"><?php echo $product->stock; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($product->status == 'active'): ?>
                                    <span
                                        class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill">Đang
                                        bán</span>
                                <?php else: ?>
                                    <span
                                        class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25 rounded-pill">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="<?php echo BASE_URL; ?>admin/editProduct/<?php echo $product->id; ?>"
                                        class="btn btn-sm btn-outline-primary rounded-3" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/manageProducts?action=delete&id=<?php echo $product->id; ?>"
                                        class="btn btn-sm btn-outline-danger rounded-3" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa sách này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php 
        $paginationData = [
            'currentPage' => $data['current_page'],
            'totalPages'  => $data['total_pages'],
            'baseUrl'     => BASE_URL . 'admin/manageProducts'
        ];
        extract($paginationData);
        require __DIR__ . '/../../layout/pagination.php';
    ?>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>