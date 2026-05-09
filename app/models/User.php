<?php
// bookstore_web/app/models/User.php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($username, $password, $role = 'client')
    {
        $this->db->query("SELECT * FROM users WHERE username = :username AND role = :role");
        $this->db->bind(':username', $username);
        $this->db->bind(':role', $role);

        $row = $this->db->single();
        if ($row) {
            if (password_verify($password, $row->password)) {
                return $row;
            }
        }
        return false;
    }

    public function register($data)
    {
        $this->db->query("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");

        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);

        // Hash password before saving
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':role', 'client'); // Default to client on register

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserByUsername($username)
    {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    public function findUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function updateProfile($id, $data)
    {
        # [Thay đổi thông tin cá nhân - CHUNG]
        # todo: Cập nhật thông tin profile của thành viên
        return false;
    }

    public function changePassword($id, $new_password)
    {
        # [Đổi mật khẩu - CHUNG]
        # todo: Cập nhật mật khẩu mới (đã mã hóa)
        return false;
    }

    public function banUser($id)
    {
        # [Quản lý người dùng - CHUNG]
        # todo: Cập nhật trạng thái 'banned' của user
        return false;
    }

    public function resetPassword($id)
    {
        # [Quản lý người dùng - CHUNG]
        # todo: Reset mật khẩu về mặc định cho user
        return false;
    }

    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) as total FROM users");
        return $this->db->single()->total;
    }
}
