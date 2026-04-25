<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-3 p-md-4 mt-n3">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3 gap-2">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Cập nhật bài viết
                </h5>
                <a href="<?php echo BASE_URL; ?>admin/manageNews" class="btn btn-sm btn-outline-secondary w-auto">Quay
                    lại danh sách</a>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/editNews/<?php echo $data['article']->id; ?>" method="POST"
                enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input class="form-control" type="text" name="title"
                                value="<?php echo $data['article']->title; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tóm tắt nội dung</label>
                            <textarea class="form-control" name="summary"
                                rows="3"><?php echo $data['article']->summary; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea class="form-control" name="content" rows="15"
                                required><?php echo $data['article']->content; ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="admin-card bg-light border mb-4">
                            <h5 class="mb-3">Cài đặt bài viết</h5>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Trạng thái</label>
                                <select class="form-select" name="status">
                                    <option value="published" <?php echo $data['article']->status == 'published' ? 'selected' : ''; ?>>Công khai (Published)</option>
                                    <option value="draft" <?php echo $data['article']->status == 'draft' ? 'selected' : ''; ?>>Bản nháp (Draft)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Tác giả</label>
                                <input class="form-control" type="text" name="author"
                                    value="<?php echo $data['article']->author; ?>">
                            </div>
                            <div class="mb-0 text-center">
                                <label class="form-label d-block small fw-bold text-uppercase text-start">Ảnh đại
                                    diện</label>
                                <?php if ($data['article']->image): ?>
                                    <div class="p-2 border rounded bg-white mb-2 text-center">
                                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $data['article']->image; ?>"
                                            alt="current" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                <?php endif; ?>
                                <input class="form-control" type="file" name="image">
                                <small class="text-muted d-block mt-1">Để trống nếu không muốn thay đổi ảnh.</small>
                            </div>
                        </div>

                        <div class="admin-card border">
                            <h5 class="mb-3 text-primary font-weight-bold">Tối ưu SEO</h5>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Từ khóa</label>
                                <input class="form-control" type="text" name="seo_keywords"
                                    value="<?php echo $data['article']->seo_keywords; ?>">
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase text-muted">Mô tả SEO</label>
                                <textarea class="form-control" name="seo_description"
                                    rows="4"><?php echo $data['article']->seo_description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                        <i class="fa-solid fa-save me-2"></i> Lưu & Cập nhật ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>