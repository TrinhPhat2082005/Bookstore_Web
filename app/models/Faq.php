<?php
// bookstore_web/app/models/Faq.php

class Faq {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        # [Trang FAQ - KHANG]
        # todo: Lấy toàn bộ danh sách câu hỏi/đáp
        return [];
    }

    public function add($data) {
        # [Quản lý Hỏi/Đáp - KHANG]
        # todo: Thêm câu hỏi/đáp mới
        return false;
    }

    public function delete($id) {
        # [Quản lý Hỏi/Đáp - KHANG]
        # todo: Xóa câu hỏi/đáp
        return false;
    }
}
