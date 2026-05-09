<?php // session is started in public/index.php ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $data['settings']['site_intro'] ?? 'Hiệu sách trực tuyến'; ?>">
    <title><?php echo $data['title']; ?> | <?php echo $data['settings']['site_name'] ?? 'BookStore'; ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/main.css">
    
</head>

<body>
    <header class="glass-nav navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-book-open text-accent"></i> <?php echo $data['settings']['site_name'] ?? 'BookStore'; ?>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="mx-auto d-none d-lg-block w-50 px-4">
                    <div class="position-relative search-container">
                        <form action="<?php echo BASE_URL; ?>product" method="GET">
                            <div class="input-group glass-card rounded-pill px-3 py-1 shadow-sm border-0">
                                <span class="input-group-text border-0 bg-transparent ps-0">
                                    <i class="fas fa-search text-muted opacity-50"></i>
                                </span>
                                <input type="text" name="keyword" id="header-search" class="form-control border-0 bg-transparent shadow-none" 
                                       placeholder="Tìm kiếm sách, tác giả..." autocomplete="off">
                            </div>
                        </form>
                        <!-- Live Search Results Dropdown -->
                        <div id="search-results" class="glass-card position-absolute w-100 mt-2 shadow-lg d-none overflow-hidden" 
                             style="z-index: 1000; max-height: 400px; overflow-y: auto; border-radius: 1.5rem;">
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?php echo ($data['title'] == 'Trang chủ' || empty($data['title'])) ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($data['title'] == 'Giới thiệu') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>home/about">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($data['title'] == 'Sản phẩm') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>product">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($data['title'] == 'Tin tức') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>news">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($data['title'] == 'Liên hệ') ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>home/contact">Liên hệ</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="<?php echo BASE_URL; ?>cart" class="text-dark position-relative text-decoration-none cart-icon">
                        <i class="fas fa-shopping-bag fs-5 text-main"></i>
                        <?php $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                        <span class="cart-count-badge position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger <?php echo ($cartCount > 0) ? '' : 'd-none'; ?>" style="font-size: 0.6rem; min-width: 18px;">
                            <?php echo $cartCount; ?>
                        </span>
                    </a>
                    
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark btn-sm dropdown-toggle glass-card border-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg glass-card" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/profile">Hồ sơ</a></li>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item text-primary fw-bold" href="<?php echo BASE_URL; ?>admin"><i class="fas fa-user-shield me-2"></i> Quản trị</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>auth/logout">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary btn-sm px-4 shadow-sm">Đăng nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content for Swup -->
    <main id="swup" class="transition-fade">
