<?php require_once '../app/views/client/layout/header.php'; ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1e293b 0%, #3f3944ff 100%);
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.3);
    }

    .about-page {
        background-color: #fcfcfd;
        color: #1e293b;
        overflow-x: hidden;
    }

    /* Hero Section */
    .hero-about {
        padding: 100px 0;
        background: var(--primary-gradient);
        position: relative;
        color: white;
        text-align: center;
        border-radius: 0 0 50px 50px;
        margin-bottom: -50px;
        z-index: 1;
    }

    .hero-about h1 {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -2px;
        margin-bottom: 20px;
    }

    /* Floating Cards */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
    }

    /* Stats Section */
    .stat-box {
        text-align: center;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
    }

    /* Image Placeholder */
    .img-placeholder {
        background: #e2e8f0;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-weight: 600;
        aspect-ratio: 16/9;
        border: 2px dashed #cbd5e1;
    }

    .img-placeholder-portrait {
        aspect-ratio: 3/4;
    }

    /* Timeline */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 0;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 4px;
        background: #e2e8f0;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -2px;
    }

    .timeline-item {
        padding: 10px 40px;
        position: relative;
        width: 50%;
        box-sizing: border-box;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        right: -10px;
        background: white;
        border: 4px solid #6366f1;
        top: 20px;
        border-radius: 50%;
        z-index: 1;
    }

    .left {
        left: 0;
        text-align: right;
    }

    .right {
        left: 50%;
    }

    .right::after {
        left: -10px;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.8s ease forwards;
    }

    .delay-1 {
        animation-delay: 0.2s;
    }

    .delay-2 {
        animation-delay: 0.4s;
    }

    /* Timeline Section Background */
    .timeline-section-wrapper {
        position: relative;
        padding: 80px 40px;
        margin: 60px -40px;
        background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop');
        /* Placeholder image */
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: inset 0 0 100px rgba(223, 220, 220, 1);
    }

    .timeline-section-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.15);
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        z-index: 1;
    }

    .timeline .glass-card {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(4px);
    }

    .timeline-content-relative {
        position: relative;
        z-index: 2;
    }
</style>

<div class="about-page">
    <!-- Hero Section -->
    <section class="hero-about">
        <div class="container animate-in">
            <span class="badge bg-white text-primary rounded-pill px-4 py-2 mb-3 fw-bold shadow-sm">Khát vọng của chúng
                tôi</span>
            <h1>Kết nối Tri thức</h1>
            <p class="lead opacity-75 mx-auto" style="max-width: 700px;">
                Tại Bookstore Premium, mỗi trang sách là một cơ hội để mở mang tâm trí và thay đổi cuộc sống.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" style="margin-top: -30px; position: relative; z-index: 2;">
        <div class="row g-4">
            <!-- Our Story -->
            <div class="col-12">
                <div class="glass-card animate-in delay-1">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6">
                            <h2 class="display-5 fw-bold mb-4">Câu chuyện của chúng tôi</h2>
                            <div class="lead text-secondary mb-4" style="line-height: 1.8;">
                                <?php echo nl2br($data['settings']['about_content']); ?>
                            </div>
                            <p class="text-muted">
                                Bắt đầu từ một niềm đam mê cháy bỏng với những bản in giấy, chúng tôi đã không ngừng nỗ
                                lực để mang những tác phẩm giá trị nhất từ khắp nơi trên thế giới đến với độc giả Việt
                                Nam.
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <img src="<?php echo BASE_URL; ?>public/uploads/about_us_background.jpg"
                                alt="Không gian nhà sách" class="img-fluid rounded-5 shadow-lg animate-in delay-1"
                                style="object-fit: cover; width: 100%; height: 100%; min-height: 400px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="col-md-4">
                <div class="glass-card text-center animate-in delay-2">
                    <div class="stat-number">5k+</div>
                    <div class="fw-bold text-uppercase small tracking-wider text-secondary">Đầu sách tinh tuyển</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card text-center animate-in delay-2">
                    <div class="stat-number">10k+</div>
                    <div class="fw-bold text-uppercase small tracking-wider text-secondary">Độc giả tin yêu</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card text-center animate-in delay-2">
                    <div class="stat-number">24/7</div>
                    <div class="fw-bold text-uppercase small tracking-wider text-secondary">Hỗ trợ tận tâm</div>
                </div>
            </div>

            <!-- Our Values -->
            <div class="col-12 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-6">Giá trị cốt lõi</h2>
                    <div class="mx-auto"
                        style="width: 80px; height: 4px; background: var(--primary-gradient); border-radius: 2px;">
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="glass-card h-100 text-center">
                            <div class="mb-4 d-inline-block p-4 rounded-4" style="background: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-heart text-danger fs-2"></i>
                            </div>
                            <h4 class="fw-bold">Tận tâm</h4>
                            <p class="text-secondary">Chúng tôi chăm chút cho từng đơn hàng như chính món quà cho người
                                thân.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card h-100 text-center">
                            <div class="mb-4 d-inline-block p-4 rounded-4" style="background: rgba(168, 85, 247, 0.1);">
                                <i class="fas fa-shield-alt text-purple fs-2" style="color: #081dd6ff;"></i>
                            </div>
                            <h4 class="fw-bold">Chất lượng</h4>
                            <p class="text-secondary">Cam kết sách thật, bản quyền và chất lượng in ấn tốt nhất thị
                                trường.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card h-100 text-center">
                            <div class="mb-4 d-inline-block p-4 rounded-4" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-rocket text-warning fs-2"></i>
                            </div>
                            <h4 class="fw-bold">Đổi mới</h4>
                            <p class="text-secondary">Luôn tiên phong trong việc áp dụng công nghệ để nâng tầm trải
                                nghiệm đọc.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Section -->
            <div class="col-12 my-5">
                <div class="timeline-section-wrapper shadow-lg">
                    <div class="timeline-content-relative">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold display-6 d-inline-block px-5 py-3 rounded-pill glass-card shadow-sm"
                                style="background: rgba(255, 255, 255, 0.95) !important;">
                                Hành trình phát triển
                            </h2>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item left">
                                <div class="glass-card p-3">
                                    <h5 class="fw-bold text-primary">2020</h5>
                                    <p class="mb-0">Khởi đầu từ một cửa hàng nhỏ tại TP.HCM</p>
                                </div>
                            </div>
                            <div class="timeline-item right">
                                <div class="glass-card p-3">
                                    <h5 class="fw-bold text-primary">2022</h5>
                                    <p class="mb-0">Đạt cột mốc 5,000 khách hàng thân thiết</p>
                                </div>
                            </div>
                            <div class="timeline-item left">
                                <div class="glass-card p-3">
                                    <h5 class="fw-bold text-primary">2024</h5>
                                    <p class="mb-0">Trở thành một trong những nền tảng sách online hàng đầu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="col-12 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-6">Đội ngũ sáng lập</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4 col-lg-3">
                        <div class="glass-card p-2 text-center">
                            <div class="img-placeholder img-placeholder-portrait mb-3">
                                <img src="<?php echo BASE_URL; ?>public/uploads/Trinh_Nguyen_Phat.jpg"
                                    alt="Không gian nhà sách" class="img-fluid rounded-5 shadow-lg animate-in delay-1"
                                    style="object-fit: cover; width: 100%; height: 100%; min-height: 400px;">
                            </div>
                            <h5 class="fw-bold mb-1">Trịnh Nguyên Phát</h5>
                            <p class="text-muted small">CEO & Founder</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="glass-card p-2 text-center">
                            <div class="img-placeholder img-placeholder-portrait mb-3">
                                <img src="<?php echo BASE_URL; ?>public/uploads/Duong_ba_khang.jpg"
                                    alt="Không gian nhà sách" class="img-fluid rounded-5 shadow-lg animate-in delay-1"
                                    style="object-fit: cover; width: 100%; height: 100%; min-height: 400px;">
                            </div>
                            <h5 class="fw-bold mb-1">Dương Bá Khang</h5>
                            <p class="text-muted small">CTO & Co-Founder</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="glass-card p-2 text-center">
                            <div class="img-placeholder img-placeholder-portrait mb-3">
                                <img src="<?php echo BASE_URL; ?>public/uploads/Le_Duc_Tam.jpg"
                                    alt="Không gian nhà sách" class="img-fluid rounded-5 shadow-lg animate-in delay-1"
                                    style="object-fit: cover; width: 100%; height: 100%; min-height: 400px;">
                            </div>
                            <h5 class="fw-bold mb-1">Lê Đức Tâm</h5>
                            <p class="text-muted small">Marketing Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="col-12 my-5 text-center">
                <div class="p-5 rounded-5 shadow-lg animate-in"
                    style="background: var(--primary-gradient); color: white;">
                    <h2 class="fw-bold mb-4">Bạn đã sẵn sàng khám phá tri thức mới?</h2>
                    <a href="<?php echo BASE_URL; ?>product"
                        class="btn btn-white btn-lg rounded-pill px-5 fw-bold shadow-sm"
                        style="background: white; color: #6366f1;">
                        Xem ngay các đầu sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/client/layout/footer.php'; ?>