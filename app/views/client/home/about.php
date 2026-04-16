<?php require_once '../app/views/client/layout/header.php'; ?>

<main class="py-5">
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold mb-3">Câu chuyện của chúng tôi</h1>
                        <p class="lead text-secondary">Hành trình mang tri thức đến với mọi nhà</p>
                    </div>

                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5">
                            <div class="content mb-5 text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                                <?php echo nl2br($data['settings']['about_content']); ?>
                            </div>

                            <div class="p-4 bg-light rounded-4 mb-5">
                                <p class="mb-0 text-dark fw-medium italic">
                                    "Được thành lập với niềm đam mê đọc sách, chúng tôi không chỉ bán những trang giấy,
                                    chúng tôi mang đến những hành trình, cảm hứng và tri thức cho cộng đồng."
                                </p>
                            </div>

                            <div class="row g-4 text-center">
                                <div class="col-6">
                                    <div
                                        class="p-4 border-start border-primary border-4 bg-primary bg-opacity-10 rounded-end-4">
                                        <h3 class="display-6 fw-bold text-primary mb-1">5,000+</h3>
                                        <p class="text-secondary mb-0 fw-medium">Đầu sách đa dạng</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div
                                        class="p-4 border-start border-primary border-4 bg-primary bg-opacity-10 rounded-end-4">
                                        <h3 class="display-6 fw-bold text-primary mb-1">10,000+</h3>
                                        <p class="text-secondary mb-0 fw-medium">Khách hàng tin tưởng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>