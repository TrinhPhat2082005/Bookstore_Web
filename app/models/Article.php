<?php
// bookstore_web/app/models/Article.php

class Article
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function list()
    {
        # [Danh sách bài viết - KHANG]
        # todo: Lấy danh sách tin tức mới nhất
        $this->db->query("SELECT * FROM articles WHERE status = 'published' ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function search($keyword)
    {
        # [Tìm kiếm bài viết - KHANG]
        # todo: Tìm kiếm bài viết theo từ khóa
        $this->db->query("SELECT * FROM articles WHERE status = 'published' AND (title LIKE :keyword OR content LIKE :keyword) ORDER BY created_at DESC");
        $this->db->bind(':keyword', '%' . $keyword . '%');
        return $this->db->resultSet();
    }

    public function getDetail($id)
    {
        # [Chi tiết bài viết - KHANG]
        # todo: Lấy nội dung chi tiết của một bài báo
        $this->db->query("SELECT * FROM articles WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function seoMetaData($id)
    {
        # [Quản lý tin tức và SEO - KHANG]
        # todo: Lấy/Cập nhật thông tin SEO (keywords, description)
        $this->db->query("SELECT seo_keywords, seo_description FROM articles WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function add($data)
    {
        # [Quản lý tin tức - KHANG]
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
}
