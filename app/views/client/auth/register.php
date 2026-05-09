<?php require_once '../app/views/client/layout/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Đăng ký</h2>
                        <p class="text-muted">Tạo tài khoản mới</p>
                    </div>
                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div class="alert alert-danger rounded-pill text-center"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success_msg'])): ?>
                        <div class="alert alert-success rounded-pill text-center"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['duplicate_email'])): ?>
                        <script>
                            alert("Lỗi: Email này đã tồn tại trong hệ thống! Vui lòng sử dụng một email khác hoặc đăng nhập.");
                        </script>
                        <?php unset($_SESSION['duplicate_email']); ?>
                    <?php endif; ?>
                    <form action="<?php echo BASE_URL; ?>auth/register" method="POST">
                        <?php Security::csrfField(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control rounded-pill px-4 py-2" required placeholder="Tên đăng nhập...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control rounded-pill px-4 py-2" required placeholder="Email của bạn...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" id="registerPassword" name="password" class="form-control rounded-start-pill px-4 py-2" required placeholder="Mật khẩu...">
                                <button class="btn btn-outline-secondary rounded-end-pill px-3 toggle-password" type="button" data-target="registerPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <input type="password" id="confirmPassword" name="confirm_password" class="form-control rounded-start-pill px-4 py-2" required placeholder="Xác nhận mật khẩu...">
                                <button class="btn btn-outline-secondary rounded-end-pill px-3 toggle-password" type="button" data-target="confirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Đăng Ký</button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Đã có tài khoản? <a href="<?php echo BASE_URL; ?>auth/login" class="text-primary fw-semibold text-decoration-none">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Hàm kiểm tra form đăng ký
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
        
        // Regex kiểm tra định dạng email (mặc dù type="email" đã hỗ trợ 1 phần)
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Vui lòng nhập đúng định dạng Email (ví dụ: abc@gmail.com)!');
            return;
        }
        
        // Regex kiểm tra mật khẩu: 5-20 ký tự, ít nhất 1 chữ cái và 1 chữ số
        const pwdRegex = /^(?=.*[a-zA-Z])(?=.*\d).{5,20}$/;
        if (!pwdRegex.test(password)) {
            e.preventDefault();
            alert('Mật khẩu không hợp lệ! Vui lòng nhập từ 5-20 ký tự, phải bao gồm ít nhất 1 chữ cái và 1 chữ số.');
            return;
        }
    });
</script>
<?php require_once '../app/views/client/layout/footer.php'; ?>
