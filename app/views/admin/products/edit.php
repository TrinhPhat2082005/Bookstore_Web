<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>
<?php $product = $data['product']; ?>

<div class="admin-card" style="max-width: 750px;">
    <h5 class="fw-bold mb-4 pb-2 border-bottom">
        <i class="fas fa-edit text-primary me-2"></i>Chỉnh sửa sách
    </h5>

    <form action="<?php echo BASE_URL; ?>admin/editProduct/<?php echo $product->id; ?>" method="POST"
        enctype="multipart/form-data">
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

        <!-- Current Image Preview -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Ảnh bìa sách</label>
            <?php if ($product->image): ?>
                <div class="mb-2 d-flex align-items-center gap-3">
                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                        class="rounded-3 shadow-sm" style="height: 100px; object-fit: cover;">
                    <div>
                        <div class="fw-semibold small">Ảnh hiện tại</div>
                        <div class="text-muted small"><?php echo htmlspecialchars($product->image); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <input type="file" id="prod_image" name="image" class="form-control rounded-3" accept="image/*">
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

<?php require_once '../app/views/admin/layout/footer.php'; ?>