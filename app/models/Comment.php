<?php
// bookstore_web/app/models/Comment.php

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add($data)
    {
        # [Bình luận - KHANG]
        $this->db->query("INSERT INTO comments (article_id, name, content, status) VALUES (:article_id, :name, :content, :status)");
        $this->db->bind(':article_id', $data['article_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':status', 'pending'); // Default status is pending
        return $this->db->execute();
    }

    public function getByArticle($article_id)
    {
        # [Chi tiết bài viết - KHANG]
        $this->db->query("SELECT * FROM comments WHERE article_id = :article_id AND status = 'approved' ORDER BY created_at DESC");
        $this->db->bind(':article_id', $article_id);
        return $this->db->resultSet();
    }

    public function getAllAdmin($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT c.*, a.title as article_title 
                          FROM comments c 
                          JOIN articles a ON c.article_id = a.id 
                          ORDER BY c.created_at DESC 
                          LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countAllAdmin()
    {
        $this->db->query("SELECT COUNT(*) as total FROM comments");
        return $this->db->single()->total;
    }

    public function approve($id)
    {
        $this->db->query("UPDATE comments SET status = 'approved' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM comments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
