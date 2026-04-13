<?php
// bookstore_web/app/controllers/AdminController.php

class AdminController extends Controller {
    private $settingModel;
    private $contactModel;

    public function __construct() {
        // Kiểm tra quyền Admin (Sẽ được CHUNG hiện thực sau)
        $this->settingModel = $this->model('Setting');
        $this->contactModel = $this->model('Contact');
    }

    public function index() {
        # [Dashboard tổng quan]
        $this->view('admin/dashboard');
    }

    // --- PHẦN CHUNG ---
    public function users() {
        # [Quản lý người dùng - CHUNG]
        # todo: Xem, sửa, cấm, xóa, reset mật khẩu
    }

    // --- PHÁT: Trang chủ, Liên hệ & Giới thiệu ---
    public function manageInfo() {
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

    public function manageContacts() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        // Xử lý xóa/đánh dấu
        if (isset($_GET['action'])) {
            $id = (int)$_GET['id'];
            if ($_GET['action'] == 'read') $this->contactModel->markAsRead($id);
            if ($_GET['action'] == 'delete') $this->contactModel->delete($id);
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
    public function manageProducts() {
        # [Quản lý sản phẩm - TÂM]
        # todo: Thêm, sửa, xóa, tìm kiếm sản phẩm
    }

    public function manageOrders() {
        # [Quản lý giỏ hàng và đơn hàng - TÂM]
        # todo: Xem và cập nhật trạng thái đơn hàng
    }

    // --- KHANG: Tin tức, Bình luận & Hỏi/Đáp ---
    public function manageNews() {
        # [Quản lý tin tức và SEO - KHANG]
        # todo: Thêm, sửa, xóa bài viết, từ khóa SEO
    }

    public function manageComments() {
        # [Quản lý bình luận - KHANG]
        # todo: Quản lý đánh giá/bình luận của thành viên
    }

    public function manageFaq() {
        # [Quản lý Hỏi/Đáp - KHANG]
        # todo: Thêm, sửa, xóa câu hỏi/đáp
    }
}
