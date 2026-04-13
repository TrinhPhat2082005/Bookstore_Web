<?php
// bookstore_web/app/controllers/AuthController.php

class AuthController extends Controller {
    public function login() {
        # [Đăng nhập người dùng]
        # todo: Xử lý xác thực, session và phân quyền (Khách, Thành viên, Admin)
        $this->view('client/auth/login');
    }

    public function register() {
        # [Đăng ký người dùng]
        # todo: Lưu thông tin người dùng mới vào database
        $this->view('client/auth/register');
    }

    public function profile() {
        # [Thay đổi thông tin cá nhân, mật khẩu, avatar]
        # todo: Cập nhật thông tin profile của thành viên
    }

    public function logout() {
        # todo: Huỷ session và chuyển hướng về trang chủ
    }
}
