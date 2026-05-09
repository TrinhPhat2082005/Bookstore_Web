<?php require_once '../app/views/client/layout/header.php'; ?>

<div class="py-5 bg-body">
    <section>
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <h1 class="display-4 fw-bold mb-4">Liên hệ với chúng tôi</h1>
                    <p class="lead text-secondary mb-5">Bạn có thắc mắc hoặc cần hỗ trợ? Đừng ngần ngại gửi tin nhắn cho
                        chúng tôi.</p>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4">
                            <i class="fas fa-map-marker-alt fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold mb-1">Địa chỉ</h4>
                            <p class="text-secondary mb-0"><?php echo $data['settings']['site_address']; ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4">
                            <i class="fas fa-phone fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold mb-1">Điện thoại</h4>
                            <p class="text-secondary mb-0"><?php echo $data['settings']['site_phone']; ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4">
                            <i class="fas fa-envelope fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold mb-1">Email</h4>
                            <p class="text-secondary mb-0"><?php echo $data['settings']['site_email']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                        <?php if (!empty($data['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i> <?php echo $data['success']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form id="contactForm" action="<?php echo BASE_URL; ?>home/contact" method="POST" novalidate>
                            <?php Security::csrfField(); ?>
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">Họ tên *</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-lg rounded-3 <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $data['name']; ?>" placeholder="Nhập họ tên của bạn">
                                    <div class="invalid-feedback" id="name_feedback"><?php echo $data['name_err']; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Email *</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-lg rounded-3 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo $data['email']; ?>" placeholder="example@gmail.com">
                                    <div class="invalid-feedback" id="email_feedback"><?php echo $data['email_err']; ?>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="subject" class="form-label fw-semibold">Tiêu đề</label>
                                    <input type="text" name="subject" id="subject"
                                        class="form-control form-control-lg rounded-3"
                                        value="<?php echo $data['subject']; ?>"
                                        placeholder="Bạn cần hỗ trợ về vấn đề gì?">
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="message" class="form-label fw-semibold">Nội dung tin nhắn *</label>
                                    <textarea name="message" id="message"
                                        class="form-control form-control-lg rounded-3 <?php echo (!empty($data['message_err'])) ? 'is-invalid' : ''; ?>"
                                        rows="5"
                                        placeholder="Nhập nội dung chi tiết..."><?php echo $data['message']; ?></textarea>
                                    <div class="invalid-feedback" id="message_feedback">
                                        <?php echo $data['message_err']; ?></div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">Gửi yêu
                                        cầu ngay <i class="fas fa-paper-plane ms-2"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        let isValid = true;
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const message = document.getElementById('message');

        // Reset
        [name, email, message].forEach(el => el.classList.remove('is-invalid'));

        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            document.getElementById('name_feedback').innerText = 'Họ tên không được để trống.';
            isValid = false;
        }
        if (!email.value.trim()) {
            email.classList.add('is-invalid');
            document.getElementById('email_feedback').innerText = 'Email không được để trống.';
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.classList.add('is-invalid');
            document.getElementById('email_feedback').innerText = 'Email không đúng định dạng.';
            isValid = false;
        }
        if (!message.value.trim()) {
            message.classList.add('is-invalid');
            document.getElementById('message_feedback').innerText = 'Nội dung không được để trống.';
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });
</script>

<?php require_once '../app/views/client/layout/footer.php'; ?>