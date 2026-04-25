<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="table-container p-4">
            <h4 class="mb-4">Chỉnh sửa Câu hỏi</h4>
            <form action="<?php echo BASE_URL; ?>admin/editFaq/<?php echo $data['faq']->id; ?>" method="POST">
                <div class="mb-4">
                    <label class="form-label fw-bold">Câu hỏi</label>
                    <input class="form-control" type="text" name="question"
                        value="<?php echo $data['faq']->question; ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select class="form-select" name="category">
                        <option value="General" <?php echo $data['faq']->category == 'General' ? 'selected' : ''; ?>>Chung
                        </option>
                        <option value="Shipping" <?php echo $data['faq']->category == 'Shipping' ? 'selected' : ''; ?>>
                            Giao hàng</option>
                        <option value="Payment" <?php echo $data['faq']->category == 'Payment' ? 'selected' : ''; ?>>Thanh
                            toán</option>
                        <option value="Account" <?php echo $data['faq']->category == 'Account' ? 'selected' : ''; ?>>Tài
                            khoản</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Câu trả lời</label>
                    <textarea class="form-control" name="answer" rows="6"
                        required><?php echo $data['faq']->answer; ?></textarea>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">Cập nhật câu hỏi</button>
                    <a href="<?php echo BASE_URL; ?>admin/manageFaq" class="btn btn-light ms-2">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>