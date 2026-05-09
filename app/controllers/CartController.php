<?php
// bookstore_web/app/controllers/CartController.php

class CartController extends Controller {
    private $productModel;
    private $orderModel;
    private $settingModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->orderModel   = $this->model('Order');
        $this->settingModel = $this->model('Setting');

        // Đảm bảo giỏ hàng luôn tồn tại trong session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // [Giỏ hàng - TÂM] Hiển thị danh sách sản phẩm trong giỏ hàng
    public function index() {
        $settings = $this->settingModel->getAll();
        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = [
            'settings' => $settings,
            'cart'     => $cart,
            'total'    => $total,
            'title'    => 'Giỏ hàng'
        ];

        $this->view('client/cart/index', $data);
    }

    // Thêm sản phẩm vào giỏ hàng (session)
    public function add($id) {
        $product = $this->productModel->getById($id);

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$product || $product->stock <= 0) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm hết hàng hoặc không tồn tại.']);
                exit();
            }
            header('Location: ' . BASE_URL . 'product');
            exit();
        }

        if (isset($_SESSION['cart'][$id])) {
            // Tăng số lượng nếu đã có trong giỏ
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            // Thêm mới vào giỏ
            $_SESSION['cart'][$id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'author'     => $product->author,
                'price'      => $product->price,
                'image'      => $product->image,
                'quantity'   => 1
            ];
        }

        if ($isAjax) {
            $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
            echo json_encode([
                'success' => true, 
                'message' => "Đã thêm '{$product->name}' vào giỏ hàng.",
                'cartCount' => $cartCount
            ]);
            exit();
        }

        // Redirect về trang trước hoặc giỏ hàng
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'cart';
        header('Location: ' . $referer . '?added=1');
        exit();
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
                foreach ($_POST['quantities'] as $id => $qty) {
                    $qty = (int)$qty;
                    if ($qty <= 0) {
                        unset($_SESSION['cart'][$id]);
                    } else {
                        if (isset($_SESSION['cart'][$id])) {
                            $_SESSION['cart'][$id]['quantity'] = $qty;
                        }
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }

    // Xóa toàn bộ giỏ hàng
    public function clear() {
        $_SESSION['cart'] = [];
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }

    // [Thanh toán - TÂM] Xử lý giao diện và logic đặt hàng
    public function checkout() {
        $settings = $this->settingModel->getAll();
        $cart = $_SESSION['cart'];

        if (empty($cart)) {
            header('Location: ' . BASE_URL . 'cart');
            exit();
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'customer_name'    => trim($_POST['customer_name'] ?? ''),
                'customer_email'   => trim($_POST['customer_email'] ?? ''),
                'customer_phone'   => trim($_POST['customer_phone'] ?? ''),
                'customer_address' => trim($_POST['customer_address'] ?? ''),
                'note'             => trim($_POST['note'] ?? ''),
                'total_amount'     => $total,
                'items'            => [],
                // form values for re-display
                'name_err'    => '',
                'email_err'   => '',
                'address_err' => '',
            ];

            // Build items list
            foreach ($cart as $id => $item) {
                $data['items'][] = [
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price']
                ];
            }

            // Validation
            if (empty($data['customer_name']))
                $data['name_err'] = 'Vui lòng nhập họ tên.';
            if (empty($data['customer_email']) || !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL))
                $data['email_err'] = 'Vui lòng nhập email hợp lệ.';
            if (empty($data['customer_address']))
                $data['address_err'] = 'Vui lòng nhập địa chỉ giao hàng.';

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['address_err'])) {
                $order_id = $this->orderModel->create($data);
                if ($order_id) {
                    // Xóa giỏ hàng sau khi đặt thành công
                    $_SESSION['cart'] = [];
                    header('Location: ' . BASE_URL . 'cart/success/' . $order_id);
                    exit();
                }
            }

            // Có lỗi - hiện lại form
            $data['settings'] = $settings;
            $data['cart']     = $cart;
            $data['total']    = $total;
            $data['title']    = 'Thanh toán';
            $this->view('client/cart/checkout', $data);

        } else { // First time access to checkout page
            $customer_name = '';
            $customer_email = '';
            $customer_phone = '';
            $customer_address = '';

            // Nếu đã đăng nhập, tự động điền thông tin từ profile
            if (isset($_SESSION['user_id'])) {
                $userModel = $this->model('User');
                $user = $userModel->getUserById($_SESSION['user_id']);
                if ($user) {
                    $customer_name = $user->full_name ?? '';
                    $customer_email = $user->email ?? '';
                    $customer_phone = $user->phone ?? '';
                    $customer_address = $user->address ?? '';
                }
            }

            $data = [
                'settings'         => $settings,
                'cart'             => $cart,
                'total'            => $total,
                'title'            => 'Thanh toán',
                'customer_name'    => $customer_name,
                'customer_email'   => $customer_email,
                'customer_phone'   => $customer_phone,
                'customer_address' => $customer_address,
                'note'             => '',
                'name_err'         => '',
                'email_err'        => '',
                'address_err'      => ''
            ];
            $this->view('client/cart/checkout', $data);
        }
    }

    // Trang xác nhận đặt hàng thành công
    public function success($order_id) {
        $settings = $this->settingModel->getAll();
        $order    = $this->orderModel->getDetail($order_id);
        $items    = $this->orderModel->getItems($order_id);

        if (!$order) {
            header('Location: ' . BASE_URL);
            exit();
        }

        $data = [
            'settings' => $settings,
            'order'    => $order,
            'items'    => $items,
            'title'    => 'Đặt hàng thành công'
        ];
        $this->view('client/cart/success', $data);
    }
}
