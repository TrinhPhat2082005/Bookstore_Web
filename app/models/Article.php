<?php
// bookstore_web/app/models/Article.php

class Article
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function list($page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM articles WHERE status = 'published' ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countPublished()
    {
        $this->db->query("SELECT COUNT(*) as total FROM articles WHERE status = 'published'");
        return $this->db->single()->total;
    }

    public function search($keyword, $page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM articles WHERE status = 'published' AND (title LIKE :keyword OR content LIKE :keyword) ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countSearch($keyword)
    {
        $this->db->query("SELECT COUNT(*) as total FROM articles WHERE status = 'published' AND (title LIKE :keyword OR content LIKE :keyword)");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        return $this->db->single()->total;
    }

    public function getDetail($id)
    {
        $this->db->query("SELECT * FROM articles WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getAllAdmin($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $this->db->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countAllAdmin()
    {
        $this->db->query("SELECT COUNT(*) as total FROM articles");
        return $this->db->single()->total;
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO articles (title, content, summary, author, image, seo_keywords, seo_description, status) 
                          VALUES (:title, :content, :summary, :author, :image, :seo_keywords, :seo_description, :status)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':summary', $data['summary'] ?? null);
        $this->db->bind(':author', $data['author'] ?? null);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':seo_keywords', $data['seo_keywords'] ?? null);
        $this->db->bind(':seo_description', $data['seo_description'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'published');

        return $this->db->execute();
    }
    
    public function update($id, $data)
    {
        $this->db->query("UPDATE articles SET 
                          title = :title, 
                          content = :content, 
                          summary = :summary, 
                          author = :author, 
                          image = :image, 
                          seo_keywords = :seo_keywords, 
                          seo_description = :seo_description, 
                          status = :status 
                          WHERE id = :id");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':summary', $data['summary'] ?? null);
        $this->db->bind(':author', $data['author'] ?? null);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':seo_keywords', $data['seo_keywords'] ?? null);
        $this->db->bind(':seo_description', $data['seo_description'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'published');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM articles WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
