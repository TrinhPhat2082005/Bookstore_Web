<?php
// bookstore_web/app/models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        # [Đăng nhập người dùng - CHUNG]
        # todo: Thực hiện truy vấn kiểm tra username và password
        return false;
    }

    public function register($data) {
        # [Đăng ký người dùng - CHUNG]
        # todo: Thêm record mới vào bảng users
        return false;
    }

    public function updateProfile($id, $data) {
        # [Thay đổi thông tin cá nhân - CHUNG]
        # todo: Cập nhật thông tin profile của thành viên
        return false;
    }

    public function changePassword($id, $new_password) {
        # [Đổi mật khẩu - CHUNG]
        # todo: Cập nhật mật khẩu mới (đã mã hóa)
        return false;
    }

    public function banUser($id) {
        # [Quản lý người dùng - CHUNG]
        # todo: Cập nhật trạng thái 'banned' của user
        return false;
    }

    public function resetPassword($id) {
        # [Quản lý người dùng - CHUNG]
        # todo: Reset mật khẩu về mặc định cho user
        return false;
    }

    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM users");
        return $this->db->single()->total;
    }
}
