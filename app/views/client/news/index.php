<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5 pb-4">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-4 py-2 mb-3 fw-bold text-uppercase tracking-wider">Tin tức & Blog</span>
            <h1 class="display-4 fw-bold text-dark mb-3">Thế giới sách qua góc nhìn của chúng tôi</h1>
            <p class="lead text-secondary mx-auto" style="max-width: 700px;">Cập nhật những thông tin, bài viết chuyên sâu và đánh giá sách mới nhất từ cộng đồng BookStore Premium.</p>
        </div>

        <div class="row g-5 justify-content-center">
            <?php foreach ($data['articles'] as $article): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg rounded-5 overflow-hidden glass-card transition-hover">
                        <div class="position-relative overflow-hidden" style="height: 240px;">
                            <?php if ($article->image): ?>
                                <img src="<?php echo BASE_URL?>uploads/<?php echo $article->image; ?>"
                                    class="card-img-top h-100 w-100 object-fit-cover transition-transform" alt="<?php echo $article->title; ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 bg-secondary bg-opacity-10 opacity-50">
                                    <i class="fas fa-newspaper display-4"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute top-0 start-0 p-3">
                                <span class="badge bg-white bg-opacity-75 text-dark backdrop-blur rounded-pill px-3 py-2 fw-bold small">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i>
                                    <?php echo date('d/m/Y', strtotime($article->created_at)); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h3 class="h4 fw-bold mb-3 line-clamp-2">
                                <a href="<?php echo BASE_URL . 'news/detail/' . $article->id; ?>"
                                    class="text-dark text-decoration-none hover-primary transition-color">
                                    <?php echo $article->title; ?>
                                </a>
                            </h3>
                            <p class="card-text text-secondary mb-4 flex-grow-1 line-clamp-3">
                                <?php echo strip_tags($article->summary); ?>
                            </p>
                            <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                                <a href="<?php echo BASE_URL . 'news/detail/' . $article->id; ?>"
                                    class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    Đọc bài viết <i class="fas fa-arrow-right ms-2 small"></i>
                                </a>
                                <div class="text-muted small">
                                    <i class="far fa-user me-1"></i> <?php echo htmlspecialchars($article->author ?? 'Admin'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .glass-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
    }

    .transition-transform {
        transition: transform 0.6s ease;
    }

    .glass-card:hover .transition-transform {
        transform: scale(1.1);
    }

    .backdrop-blur {
        backdrop-filter: blur(5px);
    }

    .hover-primary:hover {
        color: var(--bs-primary) !important;
    }

    .tracking-wider {
        letter-spacing: 0.1em;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<?php require_once '../app/views/client/layout/footer.php'; ?>