<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <h4 class="mb-4">Viết bài mới</h4>
            <form action="<?php echo BASE_URL; ?>admin/addNews" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input class="form-control" type="text" name="title"
                                placeholder="Nhập tiêu đề hấp dẫn cho bài viết..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tóm tắt nội dung</label>
                            <textarea class="form-control" name="summary" rows="3"
                                placeholder="Sẽ hiển thị ở trang danh sách tin tức..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea class="form-control" name="content" rows="15" placeholder="Nội dung bài viết..."
                                required></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="admin-card bg-light border mb-4">
                            <h5 class="mb-3">Cài đặt bài viết</h5>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase">Trạng thái</label>
                                <select class="form-select" name="status">
                                    <option value="published">Công khai (Published)</option>
                                    <option value="draft">Bản nháp (Draft)</option>
                                </select>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase">Ảnh đại diện</label>
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>

                        <div class="admin-card border">
                            <h5 class="mb-3 text-primary"><i class="fa-solid fa-magnifying-glass me-2"></i>Tối ưu SEO
                            </h5>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Từ khóa</label>
                                <input class="form-control" type="text" name="seo_keywords"
                                    placeholder="Keyword 1, Keyword 2...">
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase text-muted">Mô tả SEO</label>
                                <textarea class="form-control" name="seo_description" rows="4"
                                    placeholder="Nhập mô tả ngắn gọn cho bộ máy tìm kiếm..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                        <i class="fa-solid fa-paper-plane me-2"></i> Lưu & Đăng bài
                    </button>
                    <a href="<?php echo BASE_URL; ?>admin/manageNews" class="btn btn-light px-4 py-2 ms-2">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>