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
        # todo: Lấy toàn bộ danh sách câu hỏi/đáp
        $this->db->query("SELECT * FROM faqs ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function add($data)
    {
        # [Quản lý Hỏi/Đáp - KHANG]
        # todo: Thêm câu hỏi/đáp mới
        $this->db->query("INSERT INTO faqs (question, answer, category) VALUES (:question, :answer, :category)");
        $this->db->bind(':question', $data['question']);
        $this->db->bind(':answer', $data['answer']);
        $this->db->bind(':category', $data['category'] ?? 'General');
        return $this->db->execute();
    }

    public function delete($id)
    {
        # [Quản lý Hỏi/Đáp - KHANG]
        # todo: Xóa câu hỏi/đáp
        $this->db->query("DELETE FROM faqs WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
