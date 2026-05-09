<?php
// bookstore_web/app/models/Faq.php

class Faq
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        # [Trang FAQ - KHANG]
        $this->db->query("SELECT * FROM faqs ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function add($data)
    {
        # [Quản lý Hỏi/Đáp - KHANG]
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
