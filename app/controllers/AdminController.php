<?php
// bookstore_web/app/controllers/AdminController.php

class AdminController extends Controller
{
    private $settingModel;
    private $contactModel;
    private $articleModel;
    private $commentModel;
    private $faqModel;
    private $productModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
        $this->settingModel = $this->model('Setting');
        $this->contactModel = $this->model('Contact');
        $this->articleModel = $this->model('Article');
        $this->commentModel = $this->model('Comment');
        $this->faqModel = $this->model('Faq');
        $this->productModel = $this->model('Product');
        $this->orderModel   = $this->model('Order');
        $this->userModel    = $this->model('User');

        // Global CSRF Check for Admin POST requests
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Skip check for Dropzone AJAX uploads if needed, but for standard forms it's required
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                $_SESSION['error_msg'] = "Lỗi bảo mật: CSRF token không hợp lệ.";
                header('Location: ' . BASE_URL . 'admin');
                exit();
            }
        }
    }

    public function index()
    {
        # [Dashboard tổng quan]
        $userCount = $this->userModel->countAll();
        $orderCount = $this->orderModel->countAll();
        $totalRevenue = $this->orderModel->getTotalRevenue();
        
        // Lấy thông báo mới (kết hợp user mới và đơn hàng mới)
        $latestUsers = $this->userModel->getLatest(3);
        $latestOrders = $this->orderModel->getLatest(3);
        
        $notifications = [];
        foreach ($latestUsers as $user) {
            $notifications[] = [
                'type' => 'user',
                'title' => 'Người dùng mới đăng ký',
                'content' => ($user->full_name ?: $user->username) . ' vừa tạo tài khoản',
                'time' => $user->created_at,
                'icon' => 'fas fa-user-plus text-primary'
            ];
        }
        foreach ($latestOrders as $order) {
            $statusLabel = 'vừa tạo đơn hàng mới';
            $icon = 'fas fa-shopping-cart text-warning';
            if ($order->status === 'delivered') {
                $statusLabel = 'vừa hoàn tất đơn hàng #' . $order->id;
                $icon = 'fas fa-check-circle text-success';
            }
            
            $notifications[] = [
                'type' => 'order',
                'title' => 'Đơn hàng #' . $order->id,
                'content' => $order->customer_name . ' ' . $statusLabel,
                'time' => $order->created_at,
                'icon' => $icon
            ];
        }
        
        // Sắp xếp thông báo theo thời gian mới nhất
        usort($notifications, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        $data = [
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'totalRevenue' => $totalRevenue,
            'notifications' => array_slice($notifications, 0, 5), // Lấy 5 cái mới nhất
            'title' => 'Bảng điều khiển'
        ];
        
        $this->view('admin/dashboard', $data);
    }

    // --- PHẦN CHUNG ---
    public function manageUsers()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;

        // Xử lý các hành động quản lý
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $action = $_GET['action'];

            if ($action == 'toggle_status') {
                $user = $this->userModel->getUserById($id);
                if ($user) $this->userModel->toggleStatus($id, $user->status);
            } elseif ($action == 'reset_password') {
                $this->userModel->resetPassword($id);
            } elseif ($action == 'delete') {
                $this->userModel->deleteUser($id);
            }

            header('Location: ' . BASE_URL . 'admin/manageUsers?success=1');
            exit();
        }

        $users = $this->userModel->getAll($page, $limit);
        $total = $this->userModel->countAll();

        $data = [
            'users' => $users,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'title' => 'Quản lý Người dùng'
        ];
        $this->view('admin/users', $data);
    }

    // --- PHÁT: Trang chủ, Liên hệ & Giới thiệu ---
    public function manageInfo()
    {
        $settings = $this->settingModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST as $key => $value) {
                if (isset($settings[$key])) {
                    $this->settingModel->update($key, trim($value));
                }
            }

            // Xử lý upload Logo (Nếu có)
            if (!empty($_FILES['site_logo']['name'])) {
                $filename = time() . '_' . $_FILES['site_logo']['name'];
                $destination = 'uploads/' . $filename;
                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $destination)) {
                    $this->settingModel->update('site_logo', $filename);
                }
            }

            header('Location: ' . BASE_URL . 'admin/manageInfo?success=1');
            exit();
        }

        $data = [
            'settings' => $this->settingModel->getAll(),
            'title' => 'Quản lý thông tin website'
        ];
        $this->view('admin/info', $data);
    }

    public function manageContacts()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;

        // Xử lý xóa/đánh dấu
        if (isset($_GET['action'])) {
            $id = (int) $_GET['id'];
            if ($_GET['action'] == 'read')
                $this->contactModel->markAsRead($id);
            if ($_GET['action'] == 'delete')
                $this->contactModel->delete($id);
            header('Location: ' . BASE_URL . 'admin/manageContacts');
            exit();
        }

        $contacts = $this->contactModel->getAll($page, $limit);
        $total = $this->contactModel->countAll();

        $data = [
            'contacts' => $contacts,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'title' => 'Quản lý liên hệ'
        ];
        $this->view('admin/contacts', $data);
    }

    // --- TÂM: Sản phẩm & Giỏ hàng ---
    public function manageProducts()
    {
        $page    = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit   = 10;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        // Xử lý xóa sản phẩm
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $this->productModel->delete((int) $_GET['id']);
            header('Location: ' . BASE_URL . 'admin/manageProducts?success=deleted');
            exit();
        }

        $products    = $this->productModel->getAllAdmin($page, $limit);
        $total       = $this->productModel->countAll();

        $data = [
            'products'     => $products,
            'current_page' => $page,
            'total_pages'  => ceil($total / $limit),
            'keyword'      => $keyword,
            'title'        => 'Quản lý Sản phẩm'
        ];
        $this->view('admin/products/index', $data);
    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name'        => trim($_POST['name']),
                'author'      => trim($_POST['author']),
                'description' => Security::sanitizeHTML($_POST['description']),
                'price'       => (float) $_POST['price'],
                'stock'       => (int) $_POST['stock'],
                'category'    => trim($_POST['category']),
                'status'      => $_POST['status'],
                'name_err'    => '',
                'price_err'   => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Vui lòng nhập tên sách.';
            if ($data['price'] <= 0)  $data['price_err'] = 'Giá phải lớn hơn 0.';

            if (empty($data['name_err']) && empty($data['price_err'])) {
                // Xử lý upload ảnh
                if (!empty($_FILES['image']['name'])) {
                    $filename = time() . '_' . basename($_FILES['image']['name']);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename)) {
                        $data['image'] = $filename;
                    }
                }
                if ($this->productModel->add($data)) {
                    header('Location: ' . BASE_URL . 'admin/manageProducts?success=added');
                    exit();
                }
            }

            $data['title'] = 'Thêm sách mới';
            $this->view('admin/products/add', $data);
        } else {
            $data = ['title' => 'Thêm sách mới'];
            $this->view('admin/products/add', $data);
        }
    }

    public function editProduct($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . 'admin/manageProducts');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name'        => trim($_POST['name']),
                'author'      => trim($_POST['author']),
                'description' => Security::sanitizeHTML($_POST['description']),
                'price'       => (float) $_POST['price'],
                'stock'       => (int) $_POST['stock'],
                'category'    => trim($_POST['category']),
                'status'      => $_POST['status'],
                'image'       => $product->image
            ];

            // Xử lý upload ảnh mới (nếu có)
            if (!empty($_FILES['image']['name'])) {
                $filename = time() . '_' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename)) {
                    $data['image'] = $filename;
                }
            }

            if ($this->productModel->update($id, $data)) {
                header('Location: ' . BASE_URL . 'admin/manageProducts?success=updated');
                exit();
            }
        }

        $data = [
            'product' => $product,
            'title'   => 'Chỉnh sửa sách'
        ];
        $this->view('admin/products/edit', $data);
    }

    public function manageOrders()
    {
        $page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;

        // Cập nhật trạng thái đơn hàng
        if (isset($_GET['action']) && $_GET['action'] == 'update_status' && isset($_GET['id']) && isset($_GET['status'])) {
            $this->orderModel->updateStatus((int) $_GET['id'], $_GET['status']);
            header('Location: ' . BASE_URL . 'admin/manageOrders?success=1');
            exit();
        }

        $orders = $this->orderModel->getAll($page, $limit);
        $total  = $this->orderModel->countAll();

        $data = [
            'orders'       => $orders,
            'total'        => $total,
            'current_page' => $page,
            'total_pages'  => ceil($total / $limit),
            'title'        => 'Quản lý Đơn hàng'
        ];
        $this->view('admin/orders/index', $data);
    }

    public function viewOrder($id)
    {
        $order = $this->orderModel->getDetail($id);
        if (!$order) {
            header('Location: ' . BASE_URL . 'admin/manageOrders');
            exit();
        }
        $items = $this->orderModel->getItems($id);
        $data  = [
            'order' => $order,
            'items' => $items,
            'title' => 'Chi tiết đơn hàng #' . $id
        ];
        $this->view('admin/orders/detail', $data);
    }

    // --- KHANG: Tin tức, Bình luận & Hỏi/Đáp ---
    public function manageNews()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;

        // Xử lý Xóa bài viết
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $this->articleModel->delete((int) $_GET['id']);
            header('Location: ' . BASE_URL . 'admin/manageNews');
            exit();
        }

        $articles = $this->articleModel->getAllAdmin($page, $limit);
        $total = $this->articleModel->countAllAdmin();

        $data = [
            'articles' => $articles,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'title' => 'Quản lý Tin tức'
        ];
        $this->view('admin/news/index', $data);
    }

    public function addNews()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'content' => Security::sanitizeHTML($_POST['content']),
                'summary' => trim($_POST['summary']),
                'author' => $_SESSION['user_name'] ?? 'Admin',
                'seo_keywords' => trim($_POST['seo_keywords']),
                'seo_description' => trim($_POST['seo_description']),
                'status' => $_POST['status']
            ];

            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $filename = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename)) {
                    $data['image'] = $filename;
                }
            }

            if ($this->articleModel->add($data)) {
                header('Location: ' . BASE_URL . 'admin/manageNews?success=added');
                exit();
            }
        }

        $data = ['title' => 'Thêm bài viết mới'];
        $this->view('admin/news/add', $data);
    }

    public function editNews($id)
    {
        $article = $this->articleModel->getDetail($id);
        if (!$article) {
            header('Location: ' . BASE_URL . 'admin/manageNews');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'content' => Security::sanitizeHTML($_POST['content']),
                'summary' => trim($_POST['summary']),
                'author' => $_POST['author'],
                'seo_keywords' => trim($_POST['seo_keywords']),
                'seo_description' => trim($_POST['seo_description']),
                'status' => $_POST['status'],
                'image' => $article->image
            ];

            if (!empty($_FILES['image']['name'])) {
                $filename = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $filename)) {
                    $data['image'] = $filename;
                }
            }

            if ($this->articleModel->update($id, $data)) {
                header('Location: ' . BASE_URL . 'admin/manageNews?success=updated');
                exit();
            }
        }

        $data = [
            'article' => $article,
            'title' => 'Chỉnh sửa bài viết'
        ];
        $this->view('admin/news/edit', $data);
    }

    public function manageComments()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = 10;

        // Xử lý Duyệt/Xóa
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($_GET['action'] == 'approve')
                $this->commentModel->approve($id);
            if ($_GET['action'] == 'delete')
                $this->commentModel->delete($id);
            header('Location: ' . BASE_URL . 'admin/manageComments');
            exit();
        }

        $comments = $this->commentModel->getAllAdmin($page, $limit);
        $total = $this->commentModel->countAllAdmin();

        $data = [
            'comments' => $comments,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'title' => 'Quản lý Bình luận'
        ];
        $this->view('admin/comments', $data);
    }

    public function manageFaq()
    {
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $this->faqModel->delete((int) $_GET['id']);
            header('Location: ' . BASE_URL . 'admin/manageFaq');
            exit();
        }

        $faqs = $this->faqModel->getAll();
        $data = [
            'faqs' => $faqs,
            'title' => 'Quản lý Hỏi/Đáp (FAQ)'
        ];
        $this->view('admin/faq/index', $data);
    }

    public function addFaq()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'question' => trim($_POST['question']),
                'answer' => trim($_POST['answer']),
                'category' => trim($_POST['category'])
            ];

            if ($this->faqModel->add($data)) {
                header('Location: ' . BASE_URL . 'admin/manageFaq?success=added');
                exit();
            }
        }

        $data = ['title' => 'Thêm FAQ mới'];
        $this->view('admin/faq/add', $data);
    }

    public function editFaq($id)
    {
        $faq = $this->faqModel->getDetail($id);
        if (!$faq) {
            header('Location: ' . BASE_URL . 'admin/manageFaq');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'question' => trim($_POST['question']),
                'answer' => trim($_POST['answer']),
                'category' => trim($_POST['category'])
            ];

            if ($this->faqModel->update($id, $data)) {
                header('Location: ' . BASE_URL . 'admin/manageFaq?success=updated');
                exit();
            }
        }

        $data = [
            'faq' => $faq,
            'title' => 'Chỉnh sửa FAQ'
        ];
        $this->view('admin/faq/edit', $data);
    }
}
