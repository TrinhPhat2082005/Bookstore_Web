<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <section>
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start;">
                <div>
                    <h1 style="font-size: 40px; margin-bottom: 20px;">Liên hệ với chúng tôi</h1>
                    <p style="color: var(--gray); margin-bottom: 40px;">Bạn có thắc mắc hoặc cần hỗ trợ? Đừng ngần ngại gửi tin nhắn cho chúng tôi.</p>
                    
                    <div style="margin-bottom: 30px;">
                        <h4 style="margin-bottom: 10px;"><i class="fas fa-map-marker-alt" style="color: var(--primary); width: 30px;"></i> Địa chỉ</h4>
                        <p style="color: var(--gray);"><?php echo $data['settings']['site_address']; ?></p>
                    </div>
                    <div style="margin-bottom: 30px;">
                        <h4 style="margin-bottom: 10px;"><i class="fas fa-phone" style="color: var(--primary); width: 30px;"></i> Điện thoại</h4>
                        <p style="color: var(--gray);"><?php echo $data['settings']['site_phone']; ?></p>
                    </div>
                    <div style="margin-bottom: 30px;">
                        <h4 style="margin-bottom: 10px;"><i class="fas fa-envelope" style="color: var(--primary); width: 30px;"></i> Email</h4>
                        <p style="color: var(--gray);"><?php echo $data['settings']['site_email']; ?></p>
                    </div>
                </div>

                <div style="background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                    <?php if(!empty($data['success'])): ?>
                        <div class="success"><?php echo $data['success']; ?></div>
                    <?php endif; ?>

                    <form id="contactForm" action="<?php echo BASE_URL; ?>home/contact" method="POST">
                        <div class="form-group">
                            <label for="name">Họ tên *</label>
                            <input type="text" name="name" id="name" value="<?php echo $data['name']; ?>">
                            <div class="error" id="name_err"><?php echo $data['name_err']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" name="email" id="email" value="<?php echo $data['email']; ?>">
                            <div class="error" id="email_err"><?php echo $data['email_err']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Tiêu đề</label>
                            <input type="text" name="subject" id="subject" value="<?php echo $data['subject']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="message">Nội dung tin nhắn *</label>
                            <textarea name="message" id="message" rows="5"><?php echo $data['message']; ?></textarea>
                            <div class="error" id="message_err"><?php echo $data['message_err']; ?></div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    // Client-side validation [Rule 21]
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        let isValid = true;
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Reset errors
        document.getElementById('name_err').innerText = '';
        document.getElementById('email_err').innerText = '';
        document.getElementById('message_err').innerText = '';

        if (!name.trim()) {
            document.getElementById('name_err').innerText = 'Họ tên không được để trống.';
            isValid = false;
        }
        if (!email.trim()) {
            document.getElementById('email_err').innerText = 'Email không được để trống.';
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email_err').innerText = 'Email không đúng định dạng.';
            isValid = false;
        }
        if (!message.trim()) {
            document.getElementById('message_err').innerText = 'Nội dung không được để trống.';
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });
</script>

<?php require_once '../app/views/client/layout/footer.php'; ?>
