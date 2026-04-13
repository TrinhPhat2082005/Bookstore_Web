<?php
// bookstore_web/app/controllers/ProductController.php

class ProductController extends Controller {
    public function index() {
        # [Danh sách sản phẩm - TÂM]
        # todo: Hiển thị danh sách và lọc/tìm kiếm theo từ khóa
        $this->view('client/products/index');
    }

    public function detail($id) {
        # [Chi tiết sản phẩm - TÂM]
        # todo: Hiển thị thông tin chi tiết của 1 sản phẩm
        $this->view('client/products/detail');
    }
}
