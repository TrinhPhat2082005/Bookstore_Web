<?php
// bookstore_web/app/controllers/CartController.php

class CartController extends Controller {
    public function index() {
        # [Giỏ hàng - TÂM]
        # todo: Hiển thị danh sách sản phẩm trong giỏ hàng
        $this->view('client/cart/index');
    }

    public function checkout() {
        # [Thanh toán - TÂM]
        # todo: Xử lý giao diện và logic đặt hàng
        $this->view('client/cart/checkout');
    }

    public function add($id) {
        # todo: Thêm sản phẩm vào giỏ hàng (session)
    }
}
