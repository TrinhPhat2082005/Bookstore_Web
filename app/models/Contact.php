<?php
// bookstore_web/app/models/Contact.php

class Contact {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function add($data) {
        $this->db->query("INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        
        return $this->db->execute();
    }

    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }

    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM contacts");
        return $this->db->single()->total;
    }

    public function markAsRead($id) {
        $this->db->query("UPDATE contacts SET status = 'read' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM contacts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
