<?php
// bookstore_web/app/models/Order.php

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($data) {
        # [Thanh toán - TÂM]
        # todo: Tạo đơn hàng và chi tiết đơn hàng mới
        return false;
    }

    public function getByUser($user_id) {
        # [Lịch sử mua hàng - TÂM]
        # todo: Lấy danh sách đơn hàng của 1 user
        return [];
    }

    public function getAll() {
        # [Quản lý giỏ hàng và đơn hàng - TÂM]
        # todo: Lấy toàn bộ danh sách đơn hàng hệ thống
        return [];
    }

    public function updateStatus($id, $status) {
        # [Quản lý giỏ hàng và đơn hàng - TÂM]
        # todo: Cập nhật trạng thái đơn hàng (Đã xử lý, đang giao,...)
        return false;
    }
}
