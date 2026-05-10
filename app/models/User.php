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

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateProfile($id, $data)
    {
        $this->db->query("UPDATE users SET email = :email, full_name = :full_name, phone = :phone, address = :address WHERE id = :id");
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($id, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = :password WHERE id = :id");
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function toggleStatus($id, $current_status)
    {
        $new_status = ($current_status === 'active') ? 'banned' : 'active';
        $this->db->query("UPDATE users SET status = :status WHERE id = :id");
        $this->db->bind(':status', $new_status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function resetPassword($id, $default_password = 'user123')
    {
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = :password WHERE id = :id");
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteUser($id)
    {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) as total FROM users");
        return $this->db->single()->total;
    }

    public function updateRememberToken($id, $token)
    {
        $this->db->query("UPDATE users SET remember_token = :token WHERE id = :id");
        $this->db->bind(':token', $token);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getUserByRememberToken($token)
    {
        $this->db->query("SELECT * FROM users WHERE remember_token = :token");
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function getLatest($limit = 5)
    {
        $this->db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
