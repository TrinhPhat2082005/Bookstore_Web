<?php
// bookstore_web/app/controllers/AuthController.php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'client';

            if (!empty($username) && !empty($password)) {
                $userModel = $this->model('User');
                $loggedInUser = $userModel->login($username, $password, $role);

                if ($loggedInUser) {
                    if ($loggedInUser->status === 'banned') {
                        $_SESSION['error_msg'] = "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.";
                    } else {
                        $_SESSION['user_id'] = $loggedInUser->id;
                        $_SESSION['username'] = $loggedInUser->username;
                        $_SESSION['role'] = $loggedInUser->role;

                        if ($loggedInUser->role === 'admin') {
                            header("Location: " . BASE_URL . "admin");
                            exit;
                        } else {
                            // Xử lý Remember Me
                            if (isset($_POST['remember'])) {
                                $token = bin2hex(random_bytes(16));
                                $userModel->updateRememberToken($loggedInUser->id, $token);
                                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
                            }
                            
                            header("Location: " . BASE_URL);
                            exit;
                        }
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

    public function register()
    {
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

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }

        $userModel = $this->model('User');
        $orderModel = $this->model('Order');
        $id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update_profile') {
                $data = [
                    'email' => $_POST['email'] ?? '',
                    'full_name' => $_POST['full_name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'address' => $_POST['address'] ?? ''
                ];

                if ($userModel->updateProfile($id, $data)) {
                    $_SESSION['success_msg'] = "Cập nhật thông tin thành công!";
                } else {
                    $_SESSION['error_msg'] = "Có lỗi xảy ra khi cập nhật.";
                }
            } elseif ($action === 'change_password') {
                $old_password = $_POST['old_password'] ?? '';
                $new_password = $_POST['new_password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                $user = $userModel->getUserById($id);
                if (password_verify($old_password, $user->password)) {
                    if ($new_password === $confirm_password) {
                        if ($userModel->changePassword($id, $new_password)) {
                            $_SESSION['success_msg'] = "Đổi mật khẩu thành công!";
                        } else {
                            $_SESSION['error_msg'] = "Có lỗi xảy ra khi đổi mật khẩu.";
                        }
                    } else {
                        $_SESSION['error_msg'] = "Mật khẩu mới không khớp.";
                    }
                } else {
                    $_SESSION['error_msg'] = "Mật khẩu cũ không chính xác.";
                }
            }
            header("Location: " . BASE_URL . "auth/profile");
            exit;
        }

        $user = $userModel->getUserById($id);

        if (!$user) {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['role']);
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }

        $orders = $orderModel->getByEmail($user->email);
        $settings = $this->model('Setting')->getAll();

        $data = [
            'title' => 'Thông tin cá nhân',
            'user' => $user,
            'orders' => $orders,
            'settings' => $settings
        ];

        $this->view('client/auth/profile', $data);
    }

    public function orderDetail($id)
    {
        $orderModel = $this->model('Order');
        $items = $orderModel->getItems($id);
        
        header('Content-Type: application/json');
        echo json_encode($items);
        exit;
    }

    public function logout()
    {
        // Xóa token trong database nếu có cookie
        if (isset($_COOKIE['remember_token'])) {
            $userModel = $this->model('User');
            $user = $userModel->getUserByRememberToken($_COOKIE['remember_token']);
            if ($user) {
                $userModel->updateRememberToken($user->id, null);
            }
            // Xóa cookie trình duyệt
            setcookie('remember_token', '', time() - 3600, '/');
        }

        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header("Location: " . BASE_URL);
        exit;
    }
}
