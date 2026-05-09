<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="admin-card" style="max-width: 750px;">
    <h5 class="fw-bold mb-4 pb-2 border-bottom">
        <i class="fas fa-plus-circle text-primary me-2"></i>Thêm sách mới
    </h5>

    <form action="<?php echo BASE_URL; ?>admin/addProduct" method="POST" enctype="multipart/form-data">
        <?php Security::csrfField(); ?>
        <div class="mb-3">
            <label for="prod_name" class="form-label fw-semibold">Tên sách <span class="text-danger">*</span></label>
            <input type="text" id="prod_name" name="name" class="form-control rounded-3" required
                placeholder="Nhập tên sách..." value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>">
            <?php if (!empty($data['name_err'])): ?>
                <div class="text-danger small mt-1"><?php echo $data['name_err']; ?></div>
            <?php endif; ?>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="prod_author" class="form-label fw-semibold">Tác giả</label>
                <input type="text" id="prod_author" name="author" class="form-control rounded-3"
                    placeholder="Tên tác giả..." value="<?php echo htmlspecialchars($data['author'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="prod_category" class="form-label fw-semibold">Danh mục</label>
                <input type="text" id="prod_category" name="category" class="form-control rounded-3"
                    placeholder="VD: Kỹ năng sống, Văn học..."
                    value="<?php echo htmlspecialchars($data['category'] ?? ''); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="prod_description" class="form-label fw-semibold">Mô tả</label>
            <textarea id="prod_description" name="description" class="form-control rounded-3" rows="4"
                placeholder="Mô tả nội dung sách..."><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="prod_price" class="form-label fw-semibold">Giá bán (₫) <span
                        class="text-danger">*</span></label>
                <input type="number" id="prod_price" name="price" class="form-control rounded-3" required min="0"
                    step="1000" placeholder="89000" value="<?php echo htmlspecialchars($data['price'] ?? ''); ?>">
                <?php if (!empty($data['price_err'])): ?>
                    <div class="text-danger small mt-1"><?php echo $data['price_err']; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="prod_stock" class="form-label fw-semibold">Số lượng tồn kho</label>
                <input type="number" id="prod_stock" name="stock" class="form-control rounded-3" min="0" placeholder="0"
                    value="<?php echo htmlspecialchars($data['stock'] ?? '0'); ?>">
            </div>
            <div class="col-md-4">
                <label for="prod_status" class="form-label fw-semibold">Trạng thái</label>
                <select id="prod_status" name="status" class="form-select rounded-3">
                    <option value="active" <?php echo ($data['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Đang bán
                    </option>
                    <option value="inactive" <?php echo ($data['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Ẩn
                    </option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Ảnh bìa sách</label>
            <div id="image-dropzone" class="dropzone rounded-3 border-dashed bg-light d-flex align-items-center justify-content-center" style="min-height: 150px; cursor: pointer;">
                <div class="dz-message" data-dz-message>
                    <div class="text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h6 class="fw-bold">Kéo thả hoặc click để tải ảnh lên</h6>
                        <p class="text-muted small mb-0">Định dạng hỗ trợ: JPG, PNG, WEBP. Khuyến nghị tỷ lệ 2:3.</p>
                    </div>
                </div>
            </div>
            <input type="file" id="prod_image" name="image" class="d-none" accept="image/*">
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary rounded-3 px-4">
                <i class="fas fa-save me-1"></i>Lưu sách
            </button>
            <a href="<?php echo BASE_URL; ?>admin/manageProducts" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="fas fa-times me-1"></i>Hủy
            </a>
        </div>
    </form>
</div>

<script>
    Dropzone.autoDiscover = false;
    new Dropzone("#image-dropzone", {
        url: "#",
        autoProcessQueue: false,
        maxFiles: 1,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        init: function() {
            this.on("addedfile", function(file) {
                if (this.files.length > 1) this.removeFile(this.files[0]);
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('prod_image').files = dt.files;
            });
            this.on("removedfile", function() {
                document.getElementById('prod_image').value = "";
            });
        }
    });
</script>

<?php require_once '../app/views/admin/layout/footer.php'; ?>