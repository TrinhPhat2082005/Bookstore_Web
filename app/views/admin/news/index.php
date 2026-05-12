<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Quản lý Tin tức</h4>
                <a href="<?php echo BASE_URL; ?>admin/addNews" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i> Viết bài mới
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="mb-4">
                <form method="GET" action="<?php echo BASE_URL; ?>admin/manageNews" class="row g-2">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                            <input type="text" name="keyword" class="form-control border-start-0 ps-0" 
                                   placeholder="Tìm kiếm theo tiêu đề, tác giả..." 
                                   value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">Tìm kiếm</button>
                    </div>
                </form>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    <strong>Thành công!</strong>
                    <?php
                    if ($_GET['success'] == 'added')
                        echo 'Bài viết mới đã được đăng tải.';
                    if ($_GET['success'] == 'updated')
                        echo 'Nội dung bài viết đã được cập nhật.';
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Bài viết</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Ngày cập nhật</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['articles'] as $article): ?>
                            <tr>
                                <td>
                                    <?php if ($article->image): ?>
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $article->image; ?>" alt="thumb"
                                            class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fa-solid fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $article->title; ?></div>
                                    <small class="text-muted d-block text-truncate"
                                        style="max-width: 300px;"><?php echo $article->summary; ?></small>
                                </td>
                                <td class="small text-muted"><?php echo $article->author; ?></td>
                                <td>
                                    <span
                                        class="badge <?php echo $article->status == 'published' ? 'bg-success' : 'bg-warning text-dark'; ?>-subtle text-<?php echo $article->status == 'published' ? 'success' : 'warning'; ?> p-2 px-3 fw-normal">
                                        <?php echo $article->status == 'published' ? 'Công khai' : 'Bản nháp'; ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?php echo date('d/m/Y', strtotime($article->created_at)); ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>admin/editNews/<?php echo $article->id; ?>"
                                            class="btn btn-sm btn-outline-secondary" title="Chỉnh sửa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>admin/manageNews?action=delete&id=<?php echo $article->id; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($data['articles'])): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Chưa có bài viết nào trong hệ thống.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($data['total_pages'] > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
                            <li class="page-item <?php echo $data['current_page'] == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&keyword=<?php echo urlencode($data['keyword'] ?? ''); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>