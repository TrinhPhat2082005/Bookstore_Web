<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $data['settings']['site_intro'] ?? 'Hiệu sách trực tuyến'; ?>">
    <title><?php echo $data['title']; ?> | <?php echo $data['settings']['site_name'] ?? 'BookStore'; ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.8);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Outfit', sans-serif; background: var(--light); color: var(--dark); line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        header { background: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        nav { display: flex; justify-content: space-between; align-items: center; height: 80px; }
        .logo { font-size: 24px; font-weight: 700; color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .nav-links { list-style: none; display: flex; gap: 30px; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 500; transition: color 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .btn { padding: 10px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer; transition: 0.3s; display: inline-block; }
        .btn-primary { background: var(--primary); color: var(--white); border: none; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); }
        footer { background: var(--dark); color: var(--white); padding: 60px 0 20px; margin-top: 80px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; }
        .footer-bottom { text-align: center; padding-top: 40px; margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); color: var(--gray); font-size: 14px; }
        section { padding: 80px 0; }
        h1, h2 { margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; font-size: 16px; }
        input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
        .error { color: #ef4444; font-size: 14px; margin-top: 4px; }
        .success { background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <i class="fas fa-book-open"></i> <?php echo $data['settings']['site_name'] ?? 'BookStore'; ?>
                </a>
                <ul class="nav-links">
                    <li><a href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                    <li><a href="<?php echo BASE_URL; ?>home/about">Giới thiệu</a></li>
                    <li><a href="<?php echo BASE_URL; ?>product">Sản phẩm</a></li>
                    <li><a href="<?php echo BASE_URL; ?>home/contact">Liên hệ</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary">Đăng nhập</a>
                </div>
            </nav>
        </div>
    </header>
