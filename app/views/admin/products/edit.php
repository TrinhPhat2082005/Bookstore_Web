<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>
<?php $product = $data['product']; ?>

<div class="admin-card" style="max-width: 750px;">
    <h5 class="fw-bold mb-4 pb-2 border-bottom">
        <i class="fas fa-edit text-primary me-2"></i>Chỉnh sửa sách
    </h5>

    <form action="<?php echo BASE_URL; ?>admin/editProduct/<?php echo $product->id; ?>" method="POST"
        enctype="multipart/form-data" id="edit-product-form">
        <?php Security::csrfField(); ?>
        <div class="mb-3">
            <label for="prod_name" class="form-label fw-semibold">Tên sách <span class="text-danger">*</span></label>
            <input type="text" id="prod_name" name="name" class="form-control rounded-3" required
                value="<?php echo htmlspecialchars($product->name); ?>">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="prod_author" class="form-label fw-semibold">Tác giả</label>
                <input type="text" id="prod_author" name="author" class="form-control rounded-3"
                    value="<?php echo htmlspecialchars($product->author ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="prod_category" class="form-label fw-semibold">Danh mục</label>
                <input type="text" id="prod_category" name="category" class="form-control rounded-3"
                    value="<?php echo htmlspecialchars($product->category ?? ''); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="prod_description" class="form-label fw-semibold">Mô tả</label>
            <textarea id="prod_description" name="description" class="form-control rounded-3"
                rows="4"><?php echo htmlspecialchars($product->description ?? ''); ?></textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="prod_price" class="form-label fw-semibold">Giá bán (₫) <span
                        class="text-danger">*</span></label>
                <input type="number" id="prod_price" name="price" class="form-control rounded-3" required min="0"
                    step="1000" value="<?php echo htmlspecialchars($product->price); ?>">
            </div>
            <div class="col-md-4">
                <label for="prod_stock" class="form-label fw-semibold">Tồn kho</label>
                <input type="number" id="prod_stock" name="stock" class="form-control rounded-3" min="0"
                    value="<?php echo htmlspecialchars($product->stock); ?>">
            </div>
            <div class="col-md-4">
                <label for="prod_status" class="form-label fw-semibold">Trạng thái</label>
                <select id="prod_status" name="status" class="form-select rounded-3">
                    <option value="active" <?php echo $product->status == 'active' ? 'selected' : ''; ?>>Đang bán</option>
                    <option value="inactive" <?php echo $product->status == 'inactive' ? 'selected' : ''; ?>>Ẩn</option>
                </select>
            </div>
        </div>

        <!-- Current Image Preview & Upload -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Ảnh bìa sách</label>
            <div class="d-flex flex-wrap gap-3 mb-3">
                <?php if ($product->image): ?>
                    <div class="position-relative">
                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                            class="rounded-3 shadow-sm border" style="height: 120px; width: 90px; object-fit: cover;">
                        <div class="small text-center mt-1 text-muted">Hiện tại</div>
                    </div>
                <?php endif; ?>
                
                <div id="image-dropzone" class="dropzone rounded-3 border-dashed bg-light d-flex align-items-center justify-content-center flex-grow-1" style="min-height: 120px; cursor: pointer;">
                    <div class="dz-message" data-dz-message>
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                            <p class="mb-0 small fw-bold">Kéo thả hoặc click để thay đổi ảnh</p>
                            <p class="text-muted smaller mb-0">Hỗ trợ JPG, PNG, WEBP</p>
                        </div>
                    </div>
                </div>
            </div>
            <input type="file" id="prod_image" name="image" class="d-none" accept="image/*">
            <div class="form-text">Để trống nếu không muốn thay đổi ảnh.</div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary rounded-3 px-4">
                <i class="fas fa-save me-1"></i>Lưu thay đổi
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