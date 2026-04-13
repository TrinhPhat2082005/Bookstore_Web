<?php
// bookstore_web/app/models/Article.php

class Article {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function list() {
        # [Danh sách bài viết - KHANG]
        # todo: Lấy danh sách tin tức mới nhất
        return [];
    }

    public function search($keyword) {
        # [Tìm kiếm bài viết - KHANG]
        # todo: Tìm kiếm bài viết theo từ khóa
        return [];
    }

    public function getDetail($id) {
        # [Chi tiết bài viết - KHANG]
        # todo: Lấy nội dung chi tiết của một bài báo
        return null;
    }

    public function seoMetaData($id) {
        # [Quản lý tin tức và SEO - KHANG]
        # todo: Lấy/Cập nhật thông tin SEO (keywords, description)
        return [];
    }

    public function add($data) {
        # [Quản lý tin tức - KHANG]
        return false;
    }
}
