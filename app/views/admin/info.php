<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="card">
    <?php if(isset($_GET['success'])): ?>
        <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <i class="fas fa-check-circle"></i> Cấu hình đã được cập nhật thành công!
        </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>admin/manageInfo" method="POST" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tên website</label>
                    <input type="text" name="site_name" value="<?php echo $data['settings']['site_name']; ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Khẩu hiệu / Giới thiệu ngắn</label>
                    <input type="text" name="site_intro" value="<?php echo $data['settings']['site_intro']; ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Địa chỉ</label>
                    <input type="text" name="site_address" value="<?php echo $data['settings']['site_address']; ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Điện thoại</label>
                    <input type="text" name="site_phone" value="<?php echo $data['settings']['site_phone']; ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                    <input type="email" name="site_email" value="<?php echo $data['settings']['site_email']; ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
            </div>

            <div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Logo website</label>
                    <?php if(!empty($data['settings']['site_logo'])): ?>
                        <div style="margin-bottom: 15px; background: #eee; padding: 20px; border-radius: 8px; text-align: center;">
                            <img src="<?php echo BASE_URL; ?>public/uploads/<?php echo $data['settings']['site_logo']; ?>" alt="Logo" style="max-height: 100px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="site_logo" style="width: 100%; padding: 12px; border: 1px dashed #d1d5db; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nội dung trang Giới thiệu</label>
                    <textarea name="about_content" rows="10" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-family: inherit;"><?php echo $data['settings']['about_content']; ?></textarea>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 30px;">
            <button type="submit" style="background: var(--admin-accent); color: white; padding: 15px 40px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-save" style="margin-right: 10px;"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div>

</body>
</html>
