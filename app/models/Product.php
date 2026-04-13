<?php
// bookstore_web/app/models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        # [Danh sách sản phẩm - TÂM]
        # todo: Lấy toàn bộ danh sách sản phẩm
        return [];
    }

    public function getById($id) {
        # [Chi tiết sản phẩm - TÂM]
        # todo: Lấy thông tin 1 sản phẩm theo ID
        return null;
    }

    public function searchByKeyword($keyword) {
        # [Tìm kiếm sản phẩm - TÂM]
        # todo: Tìm kiếm sản phẩm theo tên hoặc mô tả
        return [];
    }

    public function add($data) {
        # [Quản lý sản phẩm - TÂM]
        # todo: Thêm sản phẩm mới
        return false;
    }

    public function update($id, $data) {
        # [Quản lý sản phẩm - TÂM]
        # todo: Cập nhật thông tin sản phẩm
        return false;
    }

    public function delete($id) {
        # [Quản lý sản phẩm - TÂM]
        # todo: Xóa sản phẩm khỏi database
        return false;
    }
}
