<?php require_once '../app/views/client/layout/header.php'; ?>

<div class="py-5 bg-body">
    <div class="container">
        <div class="text-center mb-5 pb-4">
            <span class="badge bg-main text-white glass-card rounded-pill px-4 py-2 mb-3 fw-bold text-uppercase tracking-wider" style="background: var(--accent-color) !important;">Tin tức & Blog</span>
            <h1 class="display-4 fw-bold text-main mb-3">Thế giới sách qua góc nhìn của chúng tôi</h1>
            <p class="lead text-secondary mx-auto" style="max-width: 700px;">Cập nhật những thông tin, bài viết chuyên sâu và đánh giá sách mới nhất từ cộng đồng BookStore Premium.</p>
        </div>

        <div class="row g-5">
            <?php foreach ($data['articles'] as $article): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card h-100 rounded-5 overflow-hidden transition-hover border-0">
                        <div class="position-relative overflow-hidden" style="height: 240px;">
                            <?php if ($article->image): ?>
                                <img src="<?php echo BASE_URL?>uploads/<?php echo $article->image; ?>"
                                    class="w-100 h-100 object-fit-cover transition-transform" alt="<?php echo $article->title; ?>">
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
                                    class="text-main text-decoration-none hover-accent transition-color">
                                    <?php echo $article->title; ?>
                                </a>
                            </h3>
                            <p class="card-text text-secondary mb-4 flex-grow-1 line-clamp-3 fs-6 lh-lg">
                                <?php echo strip_tags($article->summary); ?>
                            </p>
                            <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                                <a href="<?php echo BASE_URL . 'news/detail/' . $article->id; ?>"
                                    class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    Đọc thêm <i class="fas fa-arrow-right ms-2 small"></i>
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
</div>

<?php require_once '../app/views/client/layout/footer.php'; ?>