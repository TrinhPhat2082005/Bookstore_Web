<?php require_once '../app/views/client/layout/header.php'; ?>
<div id="reading-progress" class="fixed-top shadow-sm" style="height: 4px; background: rgba(var(--bs-primary-rgb), 0.1); z-index: 1050;">
    <div id="progress-bar" style="height: 100%; width: 0%; background: linear-gradient(90deg, var(--accent-color) 0%, #8918fe 100%); transition: width 0.1s ease;"></div>
</div>

<div class="py-5 bg-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>news" class="text-decoration-none">Tin tức</a></li>
                        <li class="breadcrumb-item active text-truncate" aria-current="page"><?php echo $data['article']->title; ?></li>
                    </ol>
                </nav>

                <article class="bg-white p-4 p-md-5 rounded-5 shadow-lg border-0 overflow-hidden position-relative">
                    <div class="position-absolute top-0 start-0 end-0" style="height: 6px; background: linear-gradient(90deg, var(--bs-primary) 0%, #8918fe 100%);"></div>
                    <header class="mb-5">
                        <div class="d-flex align-items-center gap-3 text-secondary small mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">Blog Post</span>
                            <span class="opacity-25">|</span>
                            <span><i class="far fa-calendar-alt me-1"></i> <?php echo date('d/m/Y', strtotime($data['article']->created_at)); ?></span>
                            <span class="opacity-25 d-none d-sm-inline">|</span>
                            <span class="d-none d-sm-inline"><i class="far fa-user me-1"></i> <?php echo htmlspecialchars($data['article']->author ?? 'Admin'); ?></span>
                        </div>
                        <h1 class="display-4 fw-bold text-dark mb-4" style="letter-spacing: -0.02em;"><?php echo $data['article']->title; ?></h1>
                        <p class="lead text-secondary fw-normal"><?php echo strip_tags($data['article']->summary); ?></p>
                    </header>
                    <?php if ($data['article']->image): ?>
                        <div class="mb-5 rounded-5 overflow-hidden shadow-sm position-relative card-image-container">
                            <img src="<?php echo BASE_URL ?>uploads/<?php echo $data['article']->image; ?>"
                                class="img-fluid w-100" alt="<?php echo $data['article']->title; ?>" style="max-height: 500px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                    <div class="article-body fs-5 text-dark mb-5 content-rendered" style="line-height: 1.9; font-family: 'Inter', sans-serif;">
                        <?php echo $data['article']->content; ?>
                    </div>
                    <div class="d-flex align-items-center gap-3 py-4 border-top border-bottom border-light mb-5">
                        <span class="fw-bold text-dark small text-uppercase">Chia sẻ bài viết:</span>
                        <a href="#" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <section class="comments-section" id="comments">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h3 class="fw-bold mb-0">Bình luận (<?php echo count($data['comments']); ?>)</h3>
                            <a href="#comment-form" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">Viết bình luận</a>
                        </div>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4 shadow-sm border-0" role="alert">
                                <i class="fas fa-check-circle me-2"></i> <strong>Thành công!</strong> Bình luận của bạn đã được gửi và đang chờ duyệt.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="mb-5">
                            <?php if (empty($data['comments'])): ?>
                                <div class="text-center py-5 bg-light rounded-5 border border-dashed">
                                    <div class="mb-3">
                                        <i class="far fa-comment-dots display-4 text-muted opacity-25"></i>
                                    </div>
                                    <h5 class="text-secondary">Chưa có bình luận nào</h5>
                                    <p class="text-muted small mb-0">Hãy là người đầu tiên chia sẻ suy nghĩ của bạn!</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($data['comments'] as $comment): ?>
                                    <div class="d-flex gap-3 mb-4">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($comment->name); ?>&background=random" class="rounded-circle shadow-sm" width="48" height="48">
                                        </div>
                                        <div class="flex-grow-1 bg-light p-3 p-md-4 rounded-5 position-relative">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($comment->name); ?></h6>
                                                <span class="text-muted small"><?php echo date('d/m/Y', strtotime($comment->created_at)); ?></span>
                                            </div>
                                            <p class="text-secondary mb-0" style="font-size: 0.95rem;"><?php echo nl2br(htmlspecialchars($comment->content)); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="glass-card rounded-5 p-4 p-md-5 mb-5 shadow-lg" id="comment-form">
                            <h4 class="fw-bold mb-4">Để lại suy nghĩ của bạn</h4>
                            <form action="<?php echo BASE_URL . 'news/comment/' . $data['article']->id; ?>" method="POST">
                                <?php Security::csrfField(); ?>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label small text-uppercase fw-bold opacity-75">Họ và tên</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control bg-secondary bg-opacity-10 border-0 text-main rounded-4 p-3 shadow-none" required
                                                placeholder="Nhập tên của bạn..." style="background-color: rgba(var(--bs-primary-rgb), 0.05) !important;">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label for="content" class="form-label small text-uppercase fw-bold opacity-75">Nội dung bình luận</label>
                                            <textarea name="content" id="content"
                                                class="form-control bg-secondary bg-opacity-10 border-0 text-main rounded-4 p-3 shadow-none" rows="5" required
                                                placeholder="Chia sẻ ý kiến của bạn về bài viết này..." style="background-color: rgba(var(--bs-primary-rgb), 0.05) !important;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow-lg transition-transform hover-scale">
                                            Gửi bình luận <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
</div>



<style>
    .content-rendered h2, .content-rendered h3, .content-rendered h4 {
        color: var(--bs-dark);
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .content-rendered p {
        margin-bottom: 1.5rem;
    }
    .content-rendered img {
        max-width: 100%;
        height: auto;
        border-radius: 1.5rem;
        margin: 2rem 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .hover-scale:hover {
        transform: scale(1.05);
    }
    .card-image-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40%;
        background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
        pointer-events: none;
    }
</style>

<?php require_once '../app/views/client/layout/footer.php'; ?>