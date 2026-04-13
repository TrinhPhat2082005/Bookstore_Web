<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%); padding: 120px 0;">
        <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 60px;">
            <div>
                <h1 style="font-size: 56px; line-height: 1.1; margin-bottom: 30px;">
                    Mang cả thế giới <span style="color: var(--primary);">Tri thức</span> vào tầm tay bạn.
                </h1>
                <p style="font-size: 20px; color: var(--gray); margin-bottom: 40px;">
                    <?php echo $data['settings']['site_intro']; ?>
                </p>
                <div style="display: flex; gap: 20px;">
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary" style="padding: 16px 36px;">Khám phá ngay</a>
                    <a href="<?php echo BASE_URL; ?>home/about" class="btn" style="border: 2px solid #e2e8f0; padding: 14px 34px;">Về chúng tôi</a>
                </div>
            </div>
            <div style="text-align: right;">
                <img src="<?php echo BASE_URL; ?>public/assets/hero-books.png" alt="Books Hero" style="max-width: 100%; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.1));">
                <!-- Fallback if image not exists -->
                <div style="background: #e2e8f0; width: 100%; height: 400px; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--gray);">
                    [Hình ảnh minh họa sách]
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section>
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 36px;">Tại sao chọn chúng tôi?</h2>
                <p style="color: var(--gray);">Cam kết mang lại trải nghiệm tốt nhất cho độc giả.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div style="background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <i class="fas fa-shipping-fast" style="font-size: 40px; color: var(--primary); margin-bottom: 20px;"></i>
                    <h3>Giao hàng nhanh</h3>
                    <p style="color: var(--gray);">Giao hàng toàn quốc trong vòng 2-3 ngày làm việc.</p>
                </div>
                <div style="background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <i class="fas fa-shield-alt" style="font-size: 40px; color: var(--primary); margin-bottom: 20px;"></i>
                    <h3>Sách chính hãng</h3>
                    <p style="color: var(--gray);">Chúng tôi cam kết 100% sách có bản quyền và chất lượng cao.</p>
                </div>
                <div style="background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <i class="fas fa-headset" style="font-size: 40px; color: var(--primary); margin-bottom: 20px;"></i>
                    <h3>Hỗ trợ 24/7</h3>
                    <p style="color: var(--gray);">Đội ngũ nhân viên luôn sẵn sàng giải đáp mọi thắc mắc.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>
