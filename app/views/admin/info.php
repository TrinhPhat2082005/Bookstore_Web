<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <h4 class="mb-4">Cấu hình Website</h4>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Cấu hình đã được cập nhật thành công!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>admin/manageInfo" method="POST" enctype="multipart/form-data">
                <?php Security::csrfField(); ?>
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold font-sm">Tên website</label>
                            <input type="text" name="site_name" class="form-control"
                                value="<?php echo $data['settings']['site_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold font-sm">Khẩu hiệu / Giới thiệu ngắn</label>
                            <input type="text" name="site_intro" class="form-control"
                                value="<?php echo $data['settings']['site_intro']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold font-sm">Địa chỉ</label>
                            <input type="text" name="site_address" class="form-control"
                                value="<?php echo $data['settings']['site_address']; ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold font-sm">Điện thoại</label>
                                <input type="text" name="site_phone" class="form-control"
                                    value="<?php echo $data['settings']['site_phone']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold font-sm">Email</label>
                                <input type="email" name="site_email" class="form-control"
                                    value="<?php echo $data['settings']['site_email']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold font-sm">Nội dung trang Giới thiệu</label>
                            <textarea name="about_content" class="form-control"
                                rows="8"><?php echo $data['settings']['about_content']; ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="admin-card bg-light border">
                            <label class="form-label font-weight-bold font-sm">Logo hiện tại</label>
                            <?php if (!empty($data['settings']['site_logo'])): ?>
                                <div class="text-center p-4 mb-3 rounded bg-white border">
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $data['settings']['site_logo']; ?>"
                                        alt="Logo" style="max-height: 80px;">
                                </div>
                            <?php endif; ?>
                            <div class="mb-4">
                                <label class="form-label font-sm">Thay đổi Logo</label>
                                <input type="file" name="site_logo" class="form-control border-dashed">
                                <small class="text-muted d-block mt-1">Hỗ trợ JPG, PNG. Dung lượng tối đa 2MB.</small>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <i class="fa-solid fa-circle-info text-primary me-2"></i>
                            <span class="small text-muted">Các cài đặt này sẽ ảnh hưởng trực tiếp đến giao diện bên
                                ngoài.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5 btn-lg">
                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>