<?php
// bookstore_web/app/models/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function getFilteredProducts($filters = [])
    {
        $sql = "SELECT * FROM products WHERE status = 'active'";
        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (name LIKE :keyword OR author LIKE :keyword OR description LIKE :keyword OR category LIKE :keyword)";
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category'])) {
            $sql .= " AND category = :category";
            $params[':category'] = $filters['category'];
        }

        if (isset($filters['min_price']) && $filters['min_price'] !== '') {
            $min = floatval($filters['min_price']);
            // Smart VND handle: if user enters 80, assume 80,000
            if ($min > 0 && $min < 1000) $min *= 1000;
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $min;
        }

        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $max = floatval($filters['max_price']);
            // Smart VND handle: if user enters 200, assume 200,000
            if ($max > 0 && $max < 1000) $max *= 1000;
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $max;
        }

        if (isset($filters['availability'])) {
            if ($filters['availability'] === 'in_stock') {
                $sql .= " AND stock > 0";
            } elseif ($filters['availability'] === 'out_of_stock') {
                $sql .= " AND stock = 0";
            }
        }

        // Sorting
        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY price DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY created_at DESC";
                break;
        }

        $this->db->query($sql);
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        return $this->db->resultSet();
    }

    public function getLatest($limit = 8)
    {
        $this->db->query("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // [Tìm kiếm sản phẩm - TÂM] Tìm kiếm theo tên, tác giả hoặc mô tả
    public function searchByKeyword($keyword)
    {
        $this->db->query("SELECT * FROM products WHERE status = 'active' AND (name LIKE :keyword OR author LIKE :keyword OR description LIKE :keyword OR category LIKE :keyword) ORDER BY created_at DESC");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        return $this->db->resultSet();
    }

    // Lấy sản phẩm theo danh mục
    public function getByCategory($category)
    {
        $this->db->query("SELECT * FROM products WHERE status = 'active' AND category = :category ORDER BY created_at DESC");
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    // Lấy danh sách danh mục
    public function getCategories()
    {
        $this->db->query("SELECT DISTINCT category FROM products WHERE status = 'active' AND category IS NOT NULL ORDER BY category");
        return $this->db->resultSet();
    }

    // [Quản lý sản phẩm - Admin] Lấy toàn bộ danh sách sản phẩm với phân trang
    public function getAllAdmin($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM products ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Đếm tổng số sản phẩm
    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) as total FROM products");
        return $this->db->single()->total;
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO products (name, author, description, price, stock, image, category, status) 
                          VALUES (:name, :author, :description, :price, :stock, :image, :category, :status)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':author', $data['author'] ?? null);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock'] ?? 0);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':category', $data['category'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->query("UPDATE products SET 
                          name = :name, 
                          author = :author, 
                          description = :description, 
                          price = :price, 
                          stock = :stock, 
                          image = :image, 
                          category = :category, 
                          status = :status 
                          WHERE id = :id");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':author', $data['author'] ?? null);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock'] ?? 0);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':category', $data['category'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
