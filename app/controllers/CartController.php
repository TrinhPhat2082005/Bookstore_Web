<?php

class CartController extends Controller {
    private $productModel;
    private $orderModel;
    private $settingModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->orderModel   = $this->model('Order');
        $this->settingModel = $this->model('Setting');
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
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
    public function add($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                echo json_encode(['success' => false, 'message' => 'Lỗi bảo mật: CSRF token không hợp lệ.']);
                exit();
            }
        }
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
            $_SESSION['cart'][$id]['quantity']++;
        } else {
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
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'cart';
        header('Location: ' . $referer . '?added=1');
        exit();
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                header('Location: ' . BASE_URL . 'cart');
                exit();
            }
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
    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }
    public function clear() {
        $_SESSION['cart'] = [];
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }
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
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                die('Lỗi bảo mật: CSRF token không hợp lệ.');
            }
            $data = [
                'customer_name'    => trim($_POST['customer_name'] ?? ''),
                'customer_email'   => trim($_POST['customer_email'] ?? ''),
                'customer_phone'   => trim($_POST['customer_phone'] ?? ''),
                'customer_address' => trim($_POST['customer_address'] ?? ''),
                'note'             => trim($_POST['note'] ?? ''),
                'total_amount'     => $total,
                'items'            => [],
                'name_err'    => '',
                'email_err'   => '',
                'address_err' => '',
            ];
            foreach ($cart as $id => $item) {
                $data['items'][] = [
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price']
                ];
            }
            if (empty($data['customer_name']))
                $data['name_err'] = 'Vui lòng nhập họ tên.';
            if (empty($data['customer_email']) || !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL))
                $data['email_err'] = 'Vui lòng nhập email hợp lệ.';
            if (empty($data['customer_address']))
                $data['address_err'] = 'Vui lòng nhập địa chỉ giao hàng.';

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['address_err'])) {
                $order_id = $this->orderModel->create($data);
                if ($order_id) {
                    foreach ($cart as $id => $item) {
                        $this->productModel->decreaseStock($item['product_id'], $item['quantity']);
                    }
                    $_SESSION['cart'] = [];
                    header('Location: ' . BASE_URL . 'cart/success/' . $order_id);
                    exit();
                }
            }
            $data['settings'] = $settings;
            $data['cart']     = $cart;
            $data['total']    = $total;
            $data['title']    = 'Thanh toán';
            $this->view('client/cart/checkout', $data);

        } else {
            $customer_name = '';
            $customer_email = '';
            $customer_phone = '';
            $customer_address = '';
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
