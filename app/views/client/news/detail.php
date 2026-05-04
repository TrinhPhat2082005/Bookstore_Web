<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <article class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                <!-- Header -->
                <header class="text-center mb-5">
                    <div class="d-flex align-items-center justify-content-center gap-3 text-secondary small mb-3">
                        <span><i class="far fa-calendar-alt me-1"></i>
                            <?php echo date('d/m/Y', strtotime($data['article']->created_at)); ?></span>
                        <span class="opacity-25">|</span>
                        <span><i class="far fa-user me-1"></i> <?php echo $data['article']->author; ?></span>
                    </div>
                    <h1 class="display-5 fw-bold text-dark mb-4"><?php echo $data['article']->title; ?></h1>
                </header>

                <!-- Featured Image -->
                <?php if ($data['article']->image): ?>
                    <div class="mb-5 rounded-4 overflow-hidden shadow-sm">
                        <img src="<?php echo BASE_URL ?>uploads/<?php echo $data['article']->image; ?>"
                            class="img-fluid w-100" alt="<?php echo $data['article']->title; ?>">
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="article-body fs-5 text-secondary mb-5" style="line-height: 1.8;">
                    <?php echo nl2br($data['article']->content); ?>
                </div>

                <hr class="my-5 opacity-10">

                <!-- Comment Section -->
                <section class="comments-section">
                    <h3 class="fw-bold mb-4">Bình luận (<?php echo count($data['comments']); ?>)</h3>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i> Bình luận của bạn đã được gửi và đang chờ duyệt!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Comment List -->
                    <div class="mb-5">
                        <?php if (empty($data['comments'])): ?>
                            <div class="text-center py-4 text-muted border rounded-4 border-dashed">
                                <i class="far fa-comment-dots fs-1 mb-3 opacity-25"></i>
                                <p class="mb-0 italic">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['comments'] as $comment): ?>
                                <div class="card border-0 bg-light rounded-4 mb-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold text-dark mb-0"><?php echo $comment->name; ?></h6>
                                        <small
                                            class="text-secondary small"><?php echo date('d/m/Y', strtotime($comment->created_at)); ?></small>
                                    </div>
                                    <p class="text-secondary mb-0 small"><?php echo nl2br($comment->content); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Comment Form -->
                    <div class="card border-0 bg-primary bg-opacity-5 rounded-4 p-4 p-md-5">
                        <h4 class="fw-bold mb-4">Gửi bình luận</h4>
                        <form action="<?php echo BASE_URL . 'news/comment/' . $data['article']->id; ?>" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Họ và tên</label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg rounded-3 border-0 shadow-sm" required
                                    placeholder="Nhập tên của bạn...">
                            </div>
                            <div class="mb-4">
                                <label for="content" class="form-label fw-semibold">Nội dung</label>
                                <textarea name="content" id="content"
                                    class="form-control form-control-lg rounded-3 border-0 shadow-sm" rows="4" required
                                    placeholder="Nhập bình luận của bạn..."></textarea>
                            </div>
                            <button type="submit"
                                class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">Gửi bình luận ngay
                                <i class="fas fa-paper-plane ms-2"></i></button>
                        </form>
                    </div>
                </section>
            </article>
        </div>
    </div>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>