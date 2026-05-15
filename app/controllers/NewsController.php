<?php

class NewsController extends Controller
{
    private $articleModel;
    private $settingModel;
    private $commentModel;

    public function __construct()
    {
        $this->articleModel = $this->model('Article');
        $this->settingModel = $this->model('Setting');
        $this->commentModel = $this->model('Comment');
    }

    public function index()
    {
        $settings = $this->settingModel->getAll();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $limit = 6;

        $articles = $this->articleModel->list($page, $limit);
        $totalArticles = $this->articleModel->countPublished();
        $totalPages = ceil($totalArticles / $limit);

        $data = [
            'settings'    => $settings,
            'articles'    => $articles,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'title'       => 'Tin tức'
        ];

        $this->view('client/news/index', $data);
    }

    public function detail($id)
    {
        $settings = $this->settingModel->getAll();
        $article = $this->articleModel->getDetail($id);

        if (!$article) {
            header('Location: ' . BASE_URL . 'news');
            exit;
        }

        $comments = $this->commentModel->getByArticle($id);

        $data = [
            'settings' => $settings,
            'article' => $article,
            'comments' => $comments,
            'title' => $article->title
        ];

        $this->view('client/news/detail', $data);
    }

    public function comment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                die('Lỗi bảo mật: CSRF token không hợp lệ.');
            }
            $data = [
                'article_id' => $id,
                'name' => Security::xssClean(trim($_POST['name'] ?? '')),
                'content' => Security::xssClean(trim($_POST['content'] ?? ''))
            ];

            if (!empty($data['name']) && !empty($data['content'])) {
                if ($this->commentModel->add($data)) {
                    header('Location: ' . BASE_URL . 'news/detail/' . $id . '?success=1');
                    exit;
                }
            }
        }
        header('Location: ' . BASE_URL . 'news/detail/' . $id);
    }
}
