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
        # todo: Thành viên gửi bình luận/đánh giá
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
        # todo: Lấy danh sách bình luận cho một bài viết
        $this->db->query("SELECT * FROM comments WHERE article_id = :article_id AND status = 'approved' ORDER BY created_at DESC");
        $this->db->bind(':article_id', $article_id);
        return $this->db->resultSet();
    }

    public function approve($id)
    {
        # [Quản lý bình luận - KHANG]
        # todo: Duyệt hiển thị bình luận
        $this->db->query("UPDATE comments SET status = 'approved' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        # [Quản lý bình luận - KHANG]
        # todo: Xóa bình luận không phù hợp
        $this->db->query("DELETE FROM comments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
