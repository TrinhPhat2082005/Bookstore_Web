<?php require_once '../app/views/client/layout/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Đăng nhập</h2>
                        <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                    </div>
                    <?php if (isset($_SESSION['error_msg'])): ?>
                        <div class="alert alert-danger rounded-pill text-center"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success_msg'])): ?>
                        <div class="alert alert-success rounded-pill text-center"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
                    <?php endif; ?>
                    <form action="<?php echo BASE_URL; ?>auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control rounded-pill px-4 py-2" required placeholder="Nhập tên đăng nhập...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" id="loginPassword" name="password" class="form-control rounded-start-pill px-4 py-2" required placeholder="Nhập mật khẩu...">
                                <button class="btn btn-outline-secondary rounded-end-pill px-3 toggle-password" type="button" data-target="loginPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Vai trò</label>
                            <select name="role" class="form-select rounded-pill px-4 py-2" required>
                                <option value="client">Khách hàng (Client)</option>
                                <option value="admin">Quản trị viên (Admin)</option>
                            </select>
                        </div>
                        <div class="mb-3 form-check ms-1">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                            <label class="form-check-label text-muted" for="rememberMe">Ghi nhớ đăng nhập</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Đăng Nhập</button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>auth/register" class="text-primary fw-semibold text-decoration-none">Đăng ký ngay</a></p>
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

    // Hàm kiểm tra form đăng nhập
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.querySelector('input[name="password"]').value;
        
        // Regex kiểm tra mật khẩu: 5-20 ký tự, ít nhất 1 chữ cái và 1 chữ số
        const pwdRegex = /^(?=.*[a-zA-Z])(?=.*\d).{5,20}$/;
        if (!pwdRegex.test(password)) {
            e.preventDefault();
            alert('Mật khẩu không hợp lệ! Mật khẩu phải từ 5-20 ký tự, bao gồm ít nhất 1 chữ cái và 1 chữ số.');
            return;
        }
    });
</script>
<?php require_once '../app/views/client/layout/footer.php'; ?>
