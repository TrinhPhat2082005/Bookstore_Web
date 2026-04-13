<?php
// bookstore_web/app/models/Comment.php

class Comment {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function add($data) {
        # [Bình luận - KHANG]
        # todo: Thành viên gửi bình luận/đánh giá
        return false;
    }

    public function getByArticle($article_id) {
        # [Chi tiết bài viết - KHANG]
        # todo: Lấy danh sách bình luận cho một bài viết
        return [];
    }

    public function approve($id) {
        # [Quản lý bình luận - KHANG]
        # todo: Duyệt hiển thị bình luận
        return false;
    }

    public function delete($id) {
        # [Quản lý bình luận - KHANG]
        # todo: Xóa bình luận không phù hợp
        return false;
    }
}
