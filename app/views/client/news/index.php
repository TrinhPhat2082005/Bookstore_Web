<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark">Tin tức mới nhất</h1>
        <p class="lead text-secondary">Cập nhật những thông tin, bài viết và đánh giá sách mới nhất từ BookStore.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <?php foreach ($data['articles'] as $article): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition-hover">
                    <div class="article-image position-relative" style="height: 220px; background: #f1f5f9;">
                        <?php if ($article->image): ?>
                            <img src="<?php echo BASE_URL?>uploads/<?php echo $article->image; ?>"
                                class="card-img-top h-100 w-100 object-fit-cover" alt="<?php echo $article->title; ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 opacity-25">
                                <i class="fas fa-newspaper display-4"></i>
                            </div>
                        <?php endif; ?>
                        <div class="position-absolute bottom-0 start-0 p-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?php echo date('d/m/Y', strtotime($article->created_at)); ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold mb-3">
                            <a href="<?php echo BASE_URL . 'news/detail/' . $article->id; ?>"
                                class="text-dark text-decoration-none transition-color">
                                <?php echo $article->title; ?>
                            </a>
                        </h3>
                        <p class="card-text text-secondary mb-4 small line-clamp-3">
                            <?php echo $article->summary; ?>
                        </p>
                        <a href="<?php echo BASE_URL . 'news/detail/' . $article->id; ?>"
                            class="btn btn-link p-0 text-primary fw-bold text-decoration-none d-inline-flex align-items-center gap-2">
                            Đọc thêm <i class="fas fa-arrow-right small"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>