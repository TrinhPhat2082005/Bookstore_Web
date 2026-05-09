<?php // session is started in public/index.php ?>
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
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/main.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark"
                    href="<?php echo BASE_URL; ?>">
                    <i class="fas fa-book-open text-accent"></i> <?php echo $data['settings']['site_name'] ?? 'BookStore'; ?>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link active" href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>home/about">Giới thiệu</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>product">Cửa hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>news">Tin tức</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>home/contact">Liên hệ</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <a href="<?php echo BASE_URL; ?>cart" class="text-dark position-relative text-decoration-none">
                            <i class="fas fa-shopping-bag fs-5"></i>
                            <?php $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                            <?php if ($cartCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-accent p-1" style="font-size: 0.6rem; min-width: 18px;">
                                    <?php echo $cartCount; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <?php if (isset($_SESSION['username'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/profile">Hồ sơ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>auth/logout">Đăng xuất</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary btn-sm px-4">Đăng nhập</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>