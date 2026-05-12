<?php
// bookstore_web/app/models/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll($page = 1, $limit = 12)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function getFilteredProducts($filters = [], $page = 1, $limit = 12)
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

        // Pagination
        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT :offset, :limit";

        $this->db->query($sql);
        
        // Bind basic params
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        
        // Bind pagination params as integers
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);

        return $this->db->resultSet();
    }

    public function countFilteredProducts($filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE status = 'active'";
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
            if ($min > 0 && $min < 1000) $min *= 1000;
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $min;
        }

        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $max = floatval($filters['max_price']);
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

        $this->db->query($sql);
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }
        return $this->db->single()->total;
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

    // Tìm kiếm theo tên, tác giả hoặc mô tả với phân trang
    public function searchByKeyword($keyword, $page = 1, $limit = 12)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM products WHERE status = 'active' AND (name LIKE :keyword OR author LIKE :keyword OR description LIKE :keyword OR category LIKE :keyword) ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countSearch($keyword)
    {
        $this->db->query("SELECT COUNT(*) as total FROM products WHERE status = 'active' AND (name LIKE :keyword OR author LIKE :keyword OR description LIKE :keyword OR category LIKE :keyword)");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        return $this->db->single()->total;
    }

    // Lấy sản phẩm theo danh mục với phân trang
    public function getByCategory($category, $page = 1, $limit = 12)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM products WHERE status = 'active' AND category = :category ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':category', $category);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countByCategory($category)
    {
        $this->db->query("SELECT COUNT(*) as total FROM products WHERE status = 'active' AND category = :category");
        $this->db->bind(':category', $category);
        return $this->db->single()->total;
    }

    // Lấy danh sách danh mục
    public function getCategories()
    {
        $this->db->query("SELECT DISTINCT category FROM products WHERE status = 'active' AND category IS NOT NULL ORDER BY category");
        return $this->db->resultSet();
    }

    // Lấy toàn bộ danh sách sản phẩm với phân trang
    public function getAllAdmin($page = 1, $limit = 10, $keyword = '')
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM products";
        if (!empty($keyword)) {
            $sql .= " WHERE name LIKE :keyword OR author LIKE :keyword OR category LIKE :keyword";
        }
        $sql .= " ORDER BY created_at DESC LIMIT :offset, :limit";
        
        $this->db->query($sql);
        if (!empty($keyword)) {
            $this->db->bind(':keyword', '%' . $keyword . '%');
        }
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Đếm tổng số sản phẩm
    public function countAll($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        if (!empty($keyword)) {
            $sql .= " WHERE name LIKE :keyword OR author LIKE :keyword OR category LIKE :keyword";
        }
        $this->db->query($sql);
        if (!empty($keyword)) {
            $this->db->bind(':keyword', '%' . $keyword . '%');
        }
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

    public function decreaseStock($product_id, $quantity)
    {
        $this->db->query("UPDATE products SET stock = GREATEST(0, stock - :quantity) WHERE id = :id");
        $this->db->bind(':quantity', $quantity, PDO::PARAM_INT);
        $this->db->bind(':id', $product_id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function increaseStock($product_id, $quantity)
    {
        $this->db->query("UPDATE products SET stock = stock + :quantity WHERE id = :id");
        $this->db->bind(':quantity', $quantity, PDO::PARAM_INT);
        $this->db->bind(':id', $product_id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
