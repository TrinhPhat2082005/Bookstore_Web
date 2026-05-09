<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="py-5" style="background-color: #f8fafc; background-image: radial-gradient(#e2e8f0 1px, transparent 1px); background-size: 40px 40px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- Hero Section -->
                <div class="text-center mb-5 pb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-4 py-2 mb-3 fw-bold shadow-sm">Về chúng tôi</span>
                    <h1 class="display-3 fw-bold text-dark mb-3" style="letter-spacing: -0.02em;">Mang cả thế giới vào tầm mắt của bạn</h1>
                    <p class="lead text-secondary mx-auto" style="max-width: 600px;">Hành trình từ một tiệm sách nhỏ đến điểm dừng chân lý tưởng của những tâm hồn yêu chữ.</p>
                </div>

                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden glass-main-card position-relative">
                    <div class="position-absolute top-0 end-0 p-5 opacity-5 d-none d-lg-block">
                        <i class="fas fa-book-reader" style="font-size: 200px;"></i>
                    </div>
                    <div class="card-body p-4 p-md-5 position-relative">
                        <div class="row align-items-center g-5">
                            <div class="col-lg-12">
                                <div class="content mb-5 text-dark" style="line-height: 2; font-size: 1.15rem; font-family: 'Inter', sans-serif;">
                                    <?php echo nl2br($data['settings']['about_content']); ?>
                                </div>

                                <div class="p-4 p-md-5 rounded-5 mb-5 shadow-inner" style="background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.05) 0%, rgba(137, 24, 254, 0.05) 100%); border-left: 5px solid var(--bs-primary);">
                                    <p class="mb-0 text-dark fw-bold h4 italic" style="line-height: 1.5;">
                                        "Chúng tôi không chỉ bán sách, chúng tôi kiến tạo những giá trị tinh thần bền vững cho cộng đồng người đọc Việt."
                                    </p>
                                </div>

                                <div class="row g-4 mt-2">
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-5 glass-card-stat text-center transition-hover shadow-sm">
                                            <div class="icon-circle mb-3 mx-auto shadow-sm">
                                                <i class="fas fa-books text-primary"></i>
                                            </div>
                                            <h3 class="display-5 fw-bold text-dark mb-1 counter">5,000+</h3>
                                            <p class="text-secondary mb-0 fw-bold text-uppercase small tracking-wider">Đầu sách tinh tuyển</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 rounded-5 glass-card-stat text-center transition-hover shadow-sm">
                                            <div class="icon-circle mb-3 mx-auto shadow-sm">
                                                <i class="fas fa-users text-primary"></i>
                                            </div>
                                            <h3 class="display-5 fw-bold text-dark mb-1 counter">10,000+</h3>
                                            <p class="text-secondary mb-0 fw-bold text-uppercase small tracking-wider">Độc giả tin yêu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Our Values -->
                <div class="row g-4 mt-5 text-center">
                    <div class="col-md-4">
                        <div class="p-4">
                            <i class="fas fa-heart text-danger mb-3 fs-1"></i>
                            <h5 class="fw-bold">Tâm huyết</h5>
                            <p class="text-secondary small">Mỗi cuốn sách đến tay khách hàng đều được chúng tôi nâng niu.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4">
                            <i class="fas fa-shield-alt text-success mb-3 fs-1"></i>
                            <h5 class="fw-bold">Uy tín</h5>
                            <p class="text-secondary small">Sách bản quyền 100%, chất lượng in ấn và nội dung hàng đầu.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4">
                            <i class="fas fa-rocket text-warning mb-3 fs-1"></i>
                            <h5 class="fw-bold">Sáng tạo</h5>
                            <p class="text-secondary small">Luôn đổi mới để mang lại trải nghiệm mua sắm hiện đại nhất.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .glass-main-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }
    
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }
    
    .glass-card-stat {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }
    
    .glass-card-stat:hover {
        background: white;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.02);
    }
    
    .tracking-wider {
        letter-spacing: 0.15em;
    }
    
    .italic {
        font-style: italic;
    }
</style>

<?php require_once '../app/views/client/layout/footer.php'; ?>