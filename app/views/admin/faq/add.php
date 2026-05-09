<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="table-container p-4">
            <h4 class="mb-4">Thêm Câu hỏi mới</h4>
            <form action="<?php echo BASE_URL; ?>admin/addFaq" method="POST">
                <?php Security::csrfField(); ?>
                <div class="mb-4">
                    <label class="form-label fw-bold">Câu hỏi</label>
                    <input class="form-control" type="text" name="question" placeholder="Ví dụ: Làm sao để mua hàng?"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select class="form-select" name="category">
                        <option value="General">Chung</option>
                        <option value="Shipping">Giao hàng</option>
                        <option value="Payment">Thanh toán</option>
                        <option value="Account">Tài khoản</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Câu trả lời</label>
                    <textarea class="form-control" name="answer" rows="6" placeholder="Nhập câu trả lời chi tiết..."
                        required></textarea>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">Lưu câu hỏi</button>
                    <a href="<?php echo BASE_URL; ?>admin/manageFaq" class="btn btn-light ms-2">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card border">
            <h5 class="mb-3 text-muted"><i class="fa-solid fa-lightbulb me-2"></i>Hướng dẫn</h5>
            <p class="small text-muted mb-0">Hãy cố gắng viết câu trả lời ngắn gọn và dễ hiểu nhất cho khách hàng. Bạn
                có thể phân loại theo các danh mục có sẵn để khách hàng dễ tìm kiếm hơn.</p>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>