<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Duyệt Bình luận</h4>
                <div class="badge bg-purple-subtle text-primary p-2 px-3">Phản hồi từ bạn đọc</div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Người gửi</th>
                            <th>Nội dung bình luận</th>
                            <th>Bài viết</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['comments'] as $comment): ?>
                            <tr>
                                <td style="width: 150px;">
                                    <div class="fw-bold"><?php echo $comment->name; ?></div>
                                    <small
                                        class="text-muted"><?php echo date('d/m/Y', strtotime($comment->created_at)); ?></small>
                                </td>
                                <td>
                                    <div class="p-2 bg-light rounded small"
                                        style="max-width: 400px; border-left: 3px solid var(--admin-primary);">
                                        <?php echo $comment->content; ?>
                                    </div>
                                </td>
                                <td class="small">
                                    <a href="#" class="text-decoration-none"><?php echo $comment->article_title; ?></a>
                                </td>
                                <td>
                                    <?php if ($comment->status == 'pending'): ?>
                                        <span class="badge bg-warning-subtle text-warning p-2 px-3 fw-normal">Chờ duyệt</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success p-2 px-3 fw-normal">Đã hiển thị</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <?php if ($comment->status == 'pending'): ?>
                                            <a href="?action=approve&id=<?php echo $comment->id; ?>"
                                                class="btn btn-sm btn-success" title="Duyệt bình luận">
                                                <i class="fa-solid fa-check"></i> Duyệt
                                            </a>
                                        <?php endif; ?>
                                        <a href="?action=delete&id=<?php echo $comment->id; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Xóa bình luận này?')" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($data['comments'])): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Chưa có bình luận nào cần xử lý.</td>
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
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>