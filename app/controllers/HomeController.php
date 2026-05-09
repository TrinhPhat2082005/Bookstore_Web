<?php
// bookstore_web/app/controllers/HomeController.php

class HomeController extends Controller
{
    private $settingModel;
    private $contactModel;
    private $faqModel;
    private $productModel;

    public function __construct()
    {
        $this->settingModel = $this->model('Setting');
        $this->contactModel = $this->model('Contact');
        $this->faqModel = $this->model('Faq');
        $this->productModel = $this->model('Product');
    }

    public function index()
    {
        $settings = $this->settingModel->getAll();
        $products = $this->productModel->getLatest(8); // Lấy 8 sản phẩm mới nhất
        $data = [
            'settings' => $settings,
            'products' => $products,
            'title' => 'Trang chủ'
        ];
        $this->view('client/home/index', $data);
    }

    public function about()
    {
        $settings = $this->settingModel->getAll();
        $data = [
            'settings' => $settings,
            'title' => 'Giới thiệu'
        ];
        $this->view('client/home/about', $data);
    }

    public function contact()
    {
        $settings = $this->settingModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                die('Lỗi bảo mật: CSRF token không hợp lệ.');
            }
            // Sanitize input
            // Using Security::xssClean instead of deprecated filter_input_array
            $data = [
                'name' => Security::xssClean(trim($_POST['name'] ?? '')),
                'email' => Security::xssClean(trim($_POST['email'] ?? '')),
                'subject' => Security::xssClean(trim($_POST['subject'] ?? '')),
                'message' => Security::xssClean(trim($_POST['message'] ?? '')),
                'settings' => $settings,
                'name_err' => '',
                'email_err' => '',
                'message_err' => ''
            ];

            // Server-side Validation
            if (empty($data['name']))
                $data['name_err'] = 'Vui lòng nhập tên.';
            if (empty($data['email']))
                $data['email_err'] = 'Vui lòng nhập email.';
            if (empty($data['message']))
                $data['message_err'] = 'Vui lòng nhập nội dung.';

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['message_err'])) {
                if ($this->contactModel->add($data)) {
                    $data['success'] = 'Cảm ơn bạn! Tin nhắn của bạn đã được gửi.';
                    // Clear form
                    $data['name'] = $data['email'] = $data['subject'] = $data['message'] = '';
                } else {
                    die('Đã xảy ra lỗi.');
                }
            }

            $this->view('client/home/contact', $data);
        } else {
            $data = [
                'settings' => $settings,
                'title' => 'Liên hệ',
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
                'name_err' => '',
                'email_err' => '',
                'message_err' => ''
            ];
            $this->view('client/home/contact', $data);
        }
    }

    public function faq()
    {
        $settings = $this->settingModel->getAll();
        $faqs = $this->faqModel->getAll();

        $data = [
            'settings' => $settings,
            'faqs' => $faqs,
            'title' => 'Hỏi đáp (FAQ)'
        ];

        $this->view('client/home/faq', $data);
    }
}
