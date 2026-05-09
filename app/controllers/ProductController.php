<?php
// bookstore_web/app/controllers/ProductController.php

class ProductController extends Controller {
    private $productModel;
    private $settingModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->settingModel = $this->model('Setting');
    }

    // [Danh sách sản phẩm - TÂM] Hiển thị danh sách và lọc/tìm kiếm theo từ khóa
    public function index() {
        $settings = $this->settingModel->getAll();
        
        $filters = [
            'keyword'      => isset($_GET['keyword']) ? trim($_GET['keyword']) : '',
            'category'     => isset($_GET['category']) ? trim($_GET['category']) : '',
            'min_price'    => isset($_GET['min_price']) ? $_GET['min_price'] : '',
            'max_price'    => isset($_GET['max_price']) ? $_GET['max_price'] : '',
            'availability' => isset($_GET['availability']) ? $_GET['availability'] : '',
            'sort'         => isset($_GET['sort']) ? $_GET['sort'] : 'newest'
        ];
        
        $products = $this->productModel->getFilteredProducts($filters);
        $categories = $this->productModel->getCategories();

        $data = [
            'settings'   => $settings,
            'products'   => $products,
            'categories' => $categories,
            'filters'    => $filters,
            'title'      => 'Sản phẩm'
        ];

        $this->view('client/products/index', $data);
    }

    public function detail($id) {
        $settings = $this->settingModel->getAll();
        $product = $this->productModel->getById($id);

        if (!$product) {
            header('Location: ' . BASE_URL . 'product');
            exit();
        }

        // Lấy sản phẩm liên quan (cùng category)
        $related = $this->productModel->getByCategory($product->category);
        // Loại bỏ sản phẩm hiện tại khỏi danh sách liên quan
        $related = array_filter((array)$related, fn($p) => $p->id != $id);
        $related = array_slice(array_values($related), 0, 4);

        $data = [
            'settings' => $settings,
            'product'  => $product,
            'related'  => $related,
            'title'    => $product->name
        ];

        $this->view('client/products/detail', $data);
    }
}
