    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h3 style="margin-bottom: 20px;">Về chúng tôi</h3>
                    <p style="color: var(--gray);"><?php echo $data['settings']['site_intro']; ?></p>
                </div>
                <div>
                    <h3 style="margin-bottom: 20px;">Liên kết</h3>
                    <ul style="list-style: none; color: var(--gray);">
                        <li><a href="<?php echo BASE_URL; ?>home/about" style="color: inherit; text-decoration: none;">Giới thiệu</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/contact" style="color: inherit; text-decoration: none;">Liên hệ</a></li>
                        <li><a href="#" style="color: inherit; text-decoration: none;">Điều khoản dịch vụ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 style="margin-bottom: 20px;">Thông tin liên hệ</h3>
                    <p style="color: var(--gray); margin-bottom: 10px;"><i class="fas fa-map-marker-alt" style="width: 25px;"></i> <?php echo $data['settings']['site_address']; ?></p>
                    <p style="color: var(--gray); margin-bottom: 10px;"><i class="fas fa-phone" style="width: 25px;"></i> <?php echo $data['settings']['site_phone']; ?></p>
                    <p style="color: var(--gray);"><i class="fas fa-envelope" style="width: 25px;"></i> <?php echo $data['settings']['site_email']; ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <?php echo date('Y'); ?> <?php echo $data['settings']['site_name']; ?>. Toàn bộ bản quyền được bảo lưu.
            </div>
        </div>
    </footer>
</body>
</html>
