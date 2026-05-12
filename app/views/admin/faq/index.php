<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Quản lý Hỏi/Đáp (FAQ)</h4>
                <a href="<?php echo BASE_URL; ?>admin/addFaq" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i> Thêm câu hỏi
                </a>
            </div>

            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    <strong>Thành công!</strong> 
                    <?php 
                        if($_GET['success'] == 'added') echo 'Đã thêm câu hỏi mới.';
                        if($_GET['success'] == 'updated') echo 'Câu hỏi đã được cập nhật.';
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Danh mục</th>
                            <th>Câu hỏi</th>
                            <th>Câu trả lời</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['faqs'] as $faq): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-info-subtle text-info p-2 fw-normal"><?php echo $faq->category; ?></span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?php echo $faq->question; ?></div>
                                </td>
                                <td>
                                    <div class="small text-muted text-truncate" style="max-width: 400px;"><?php echo $faq->answer; ?></div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>admin/editFaq/<?php echo $faq->id; ?>" class="btn btn-sm btn-outline-secondary" title="Sửa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>admin/manageFaq?action=delete&id=<?php echo $faq->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa câu hỏi này?')" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($data['faqs'])): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Chưa có danh sách Hỏi/Đáp.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php 
                $paginationData = [
                    'currentPage' => $data['current_page'],
                    'totalPages'  => $data['total_pages'],
                    'baseUrl'     => BASE_URL . 'admin/manageFaq'
                ];
                extract($paginationData);
                require __DIR__ . '/../../layout/pagination.php';
            ?>
        </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>
