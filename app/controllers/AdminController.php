<?php
// bookstore_web/app/controllers/AdminController.php

class AdminController extends Controller
{
    private $settingModel;
    private $contactModel;
    private $articleModel;
    private $commentModel;
    private $faqModel;

    public function __construct()
    {
        // Kiểm tra quyền Admin (Sẽ được CHUNG hiện thực sau)
        $this->settingModel = $this->model('Setting');
        $this->contactModel = $this->model('Contact');
        $this->articleModel = $this->model('Article');
        $this->commentModel = $this->model('Comment');
        $this->faqModel = $this->model('Faq');
    }

    public function index()
    {
        # [Dashboard tổng quan]
        $this->view('admin/dashboard');
    }

    // --- PHẦN CHUNG ---
    public function users()
    {
        # [Quản lý người dùng - CHUNG]
        # todo: Xem, sửa, cấm, xóa, reset mật khẩu
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
                $destination = 'public/uploads/' . $filename;
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
        # [Quản lý sản phẩm - TÂM]
        # todo: Thêm, sửa, xóa, tìm kiếm sản phẩm
    }

    public function manageOrders()
    {
        # [Quản lý giỏ hàng và đơn hàng - TÂM]
        # todo: Xem và cập nhật trạng thái đơn hàng
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
                'content' => trim($_POST['content']),
                'summary' => trim($_POST['summary']),
                'author' => $_SESSION['user_name'] ?? 'Admin',
                'seo_keywords' => trim($_POST['seo_keywords']),
                'seo_description' => trim($_POST['seo_description']),
                'status' => $_POST['status']
            ];

            // Xử lý upload ảnh
            if (!empty($_FILES['image']['name'])) {
                $filename = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/' . $filename)) {
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
                'content' => trim($_POST['content']),
                'summary' => trim($_POST['summary']),
                'author' => $_POST['author'],
                'seo_keywords' => trim($_POST['seo_keywords']),
                'seo_description' => trim($_POST['seo_description']),
                'status' => $_POST['status'],
                'image' => $article->image
            ];

            if (!empty($_FILES['image']['name'])) {
                $filename = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/' . $filename)) {
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
