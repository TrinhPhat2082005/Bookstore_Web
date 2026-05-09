<?php
// bookstore_web/app/controllers/AuthController.php

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'client';
            
            if (!empty($username) && !empty($password)) {
                $userModel = $this->model('User');
                $loggedInUser = $userModel->login($username, $password, $role);
                
                if ($loggedInUser) {
                    $_SESSION['user_id'] = $loggedInUser->id;
                    $_SESSION['username'] = $loggedInUser->username;
                    $_SESSION['role'] = $loggedInUser->role;
                    
                    if ($loggedInUser->role === 'admin') {
                        header("Location: " . BASE_URL . "admin");
                        exit;
                    } else {
                        header("Location: " . BASE_URL);
                        exit;
                    }
                } else {
                    $_SESSION['error_msg'] = "Tên đăng nhập, mật khẩu hoặc vai trò không chính xác.";
                }
            } else {
                $_SESSION['error_msg'] = "Vui lòng nhập đầy đủ thông tin.";
            }
        }
        $data = ['title' => 'Đăng nhập'];
        $this->view('client/auth/login', $data);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirm_password) {
                $_SESSION['error_msg'] = "Mật khẩu không khớp.";
            } else if (!empty($username) && !empty($password) && !empty($email)) {
                $userModel = $this->model('User');
                
                // Check if username already exists
                if ($userModel->findUserByUsername($username)) {
                    $_SESSION['error_msg'] = "Tên đăng nhập đã tồn tại.";
                } else if ($userModel->findUserByEmail($email)) {
                    // Check if email already exists
                    $_SESSION['error_msg'] = "Email này đã được đăng ký. Vui lòng sử dụng email khác.";
                    $_SESSION['duplicate_email'] = true; // Flag for UI to show a popup window
                } else {
                    $data = [
                        'username' => $username,
                        'email' => $email,
                        'password' => $password
                    ];
                    
                    if ($userModel->register($data)) {
                        $_SESSION['success_msg'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                        header("Location: " . BASE_URL . "auth/login");
                        exit;
                    } else {
                        $_SESSION['error_msg'] = "Có lỗi xảy ra, vui lòng thử lại sau.";
                    }
                }
            } else {
                $_SESSION['error_msg'] = "Vui lòng nhập đầy đủ thông tin.";
            }
        }
        $data = ['title' => 'Đăng ký'];
        $this->view('client/auth/register', $data);
    }

    public function profile() {
        // todo: Cập nhật thông tin profile của thành viên
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header("Location: " . BASE_URL);
        exit;
    }
}
