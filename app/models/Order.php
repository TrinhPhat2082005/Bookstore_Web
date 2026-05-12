<?php
// bookstore_web/app/models/Order.php

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create($data) {
        // 1. Tạo đơn hàng
        $this->db->query("INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount, note, status) 
                          VALUES (:customer_name, :customer_email, :customer_phone, :customer_address, :total_amount, :note, 'pending')");
        $this->db->bind(':customer_name', $data['customer_name']);
        $this->db->bind(':customer_email', $data['customer_email']);
        $this->db->bind(':customer_phone', $data['customer_phone'] ?? null);
        $this->db->bind(':customer_address', $data['customer_address']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':note', $data['note'] ?? null);
        
        if (!$this->db->execute()) {
            return false;
        }

        // 2. Lấy ID đơn hàng vừa tạo
        $this->db->query("SELECT LAST_INSERT_ID() as id"); // Lấy id vừa mới insert xong
        $row = $this->db->single();
        $order_id = $row->id;

        // 3. Thêm chi tiết từng sản phẩm trong đơn
        foreach ($data['items'] as $item) {
            $this->db->query("INSERT INTO order_items (order_id, product_id, quantity, price) 
                              VALUES (:order_id, :product_id, :quantity, :price)");
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':product_id', $item['product_id']);
            $this->db->bind(':quantity', $item['quantity']);
            $this->db->bind(':price', $item['price']);
            $this->db->execute();
        }

        return $order_id;
    }

    // Lấy danh sách đơn hàng theo email với phân trang
    public function getByEmail($email, $page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM orders WHERE customer_email = :email ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':email', $email);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countByEmail($email) {
        $this->db->query("SELECT COUNT(*) as total FROM orders WHERE customer_email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single()->total;
    }

    // Lấy chi tiết một đơn hàng kèm sản phẩm
    public function getDetail($id) {
        $this->db->query("SELECT * FROM orders WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Lấy các item của một đơn hàng
    public function getItems($order_id) {
        $this->db->query("SELECT oi.*, p.name as product_name, p.image as product_image 
                          FROM order_items oi 
                          JOIN products p ON oi.product_id = p.id 
                          WHERE oi.order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }

    // Lấy toàn bộ danh sách đơn hàng (Admin)
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Đếm tổng số đơn hàng
    public function countAll() {
        $this->db->query("SELECT COUNT(*) as total FROM orders");
        return $this->db->single()->total;
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE orders SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getTotalRevenue() {
        $this->db->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
        $result = $this->db->single();
        return $result ? (float)$result->total : 0;
    }

    public function getLatest($limit = 5) {
        $this->db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function getRevenueLast7Days() {
        $this->db->query("
            SELECT 
                DATE(created_at) as date, 
                SUM(total_amount) as total,
                COUNT(*) as order_count
            FROM orders 
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
              AND status != 'cancelled'
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");
        return $this->db->resultSet();
    }
}
