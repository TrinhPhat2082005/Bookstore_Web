<?php
// bookstore_web/app/controllers/NewsController.php

class NewsController extends Controller {
    public function index() {
        # [Danh sách bài viết - KHANG]
        # todo: Tìm kiếm bài viết theo từ khóa
        $this->view('client/news/index');
    }

    public function detail($id) {
        # [Chi tiết bài viết - KHANG]
        # todo: Xây dựng trang đọc bài viết chi tiết
        $this->view('client/news/detail');
    }

    public function comment() {
        # [Bình luận - KHANG]
        # todo: Thành viên bình luận trên bài viết
    }
}
