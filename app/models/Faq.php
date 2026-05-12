<?php
// bookstore_web/app/models/Faq.php

class Faq
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM faqs ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) as total FROM faqs");
        return $this->db->single()->total;
    }

    public function add($data)
    {
        // Thêm FAQ mới
        $this->db->query("INSERT INTO faqs (question, answer, category) VALUES (:question, :answer, :category)");
        $this->db->bind(':question', $data['question']);
        $this->db->bind(':answer', $data['answer']);
        $this->db->bind(':category', $data['category'] ?? 'General');
        return $this->db->execute();
    }

    public function getDetail($id)
    {
        $this->db->query("SELECT * FROM faqs WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function update($id, $data)
    {
        $this->db->query("UPDATE faqs SET question = :question, answer = :answer, category = :category WHERE id = :id");
        $this->db->bind(':question', $data['question']);
        $this->db->bind(':answer', $data['answer']);
        $this->db->bind(':category', $data['category'] ?? 'General');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM faqs WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
