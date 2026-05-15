<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="py-5" style="background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-4 py-2 mb-3 fw-bold">Trợ giúp & Hỗ trợ</span>
            <h1 class="display-4 fw-bold text-dark">Câu hỏi thường gặp</h1>
            <p class="lead text-secondary mx-auto" style="max-width: 600px;">Chúng tôi luôn sẵn sàng giải đáp mọi thắc mắc của bạn để mang lại trải nghiệm mua sắm tốt nhất.</p>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden bg-white border-0">
                    <span class="input-group-text bg-white border-0 ps-4"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="faqSearch" class="form-control border-0 shadow-none py-3" placeholder="Tìm kiếm câu hỏi...">
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if (empty($data['faqs'])): ?>
                    <div class="text-center py-5 glass-card rounded-5">
                        <i class="fas fa-question-circle text-muted mb-3 display-3 opacity-25"></i>
                        <p class="text-secondary italic fs-5">Hiện tại chưa có câu hỏi nào được cập nhật.</p>
                    </div>
                <?php else: ?>
                    <div class="accordion accordion-custom" id="faqAccordion">
                        <?php foreach ($data['faqs'] as $index => $faq): ?>
                            <div class="accordion-item mb-3 border-0 rounded-4 overflow-hidden glass-card faq-item" data-question="<?php echo strtolower(htmlspecialchars($faq->question)); ?>">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold py-4 px-4 shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $index; ?>"
                                        aria-expanded="false">
                                        <span class="me-3 text-primary">0<?php echo $index + 1; ?>.</span>
                                        <?php echo htmlspecialchars($faq->question); ?>
                                    </button>
                                </h2>
                                <div id="collapse-<?php echo $index; ?>" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-4 px-4 text-secondary bg-white bg-opacity-50" style="line-height: 1.8;">
                                        <?php echo Security::sanitizeHTML($faq->answer); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row justify-content-center mt-5 pt-4">
            <div class="col-lg-9">
                <div class="p-5 text-center rounded-5 glass-card position-relative overflow-hidden">
                    <h3 class="fw-bold text-dark mb-3">Vẫn còn thắc mắc khác?</h3>
                    <p class="text-secondary mb-4 fs-5">Đội ngũ hỗ trợ khách hàng của BookStore Premium luôn sẵn sàng phục vụ bạn 24/7.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="<?php echo BASE_URL; ?>home/contact"
                            class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg fw-bold transition-transform hover-scale">
                            Gửi yêu cầu hỗ trợ <i class="fas fa-paper-plane ms-2"></i>
                        </a>
                        <a href="tel:0123456789" class="btn btn-outline-dark btn-lg px-5 rounded-pill fw-bold">
                            <i class="fas fa-phone-alt me-2"></i> 0123 456 789
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqSearch = document.getElementById('faqSearch');
    const faqItems = document.querySelectorAll('.faq-item');

    if (faqSearch) {
        faqSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            faqItems.forEach(item => {
                const question = item.getAttribute('data-question');
                if (question.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .accordion-custom .accordion-button {
        background: transparent;
        color: var(--bs-dark);
        transition: all 0.3s ease;
    }

    .accordion-custom .accordion-button:not(.collapsed) {
        color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.05);
    }

    .accordion-custom .accordion-button::after {
        background-size: 1rem;
        transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }

    .hover-scale:hover {
        transform: translateY(-5px);
    }

    .faq-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .faq-item:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }
</style>

<?php require_once '../app/views/client/layout/footer.php'; ?>