<!-- Sidebar -->
<div id="sidebar-wrapper">
    <div class="sidebar-heading">
        <a href="<?php echo BASE_URL; ?>admin" class="text-decoration-none text-white">
            <i class="fa-solid fa-book-open me-2"></i> BS Admin
        </a>
    </div>
    <div class="list-group list-group-flush flex-grow-1">
        <?php $title = isset($data['title']) ? $data['title'] : ''; ?>

        <a href="<?php echo BASE_URL; ?>admin"
            class="list-group-item list-group-item-action <?php echo ($title == '' || strpos($title, 'Dashboard') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageProducts"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'Sản phẩm') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-book"></i> Quản lý Sách
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageNews"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'Tin tức') !== false || strpos($title, 'bài viết') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-newspaper"></i> Quản lý Tin tức
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageComments"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'Bình luận') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-comments"></i> Quản lý Bình luận
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageContacts"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'liên hệ') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-envelope"></i> Quản lý Liên hệ
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageFaq"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'Hỏi/Đáp') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-circle-question"></i> Quản lý Hỏi/Đáp
        </a>
        <a href="<?php echo BASE_URL; ?>admin/manageInfo"
            class="list-group-item list-group-item-action <?php echo (strpos($title, 'thông tin website') !== false) ? 'active' : ''; ?>">
            <i class="fa-solid fa-gears"></i> Cấu hình Website
        </a>

        <div class="mt-auto">
            <a href="<?php echo BASE_URL; ?>" class="list-group-item border-top bg-dark w-100">
                <i class="fa-solid fa-arrow-left"></i> Về trang chủ
            </a>
        </div>
    </div>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg top-navbar">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary d-lg-block" id="sidebarToggle"><i
                    class="fa-solid fa-bars"></i></button>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=8918fe&color=fff"
                            class="rounded-circle me-2" width="30"> Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i> Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2"></i> Cài đặt</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#"><i
                                    class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Breadcrumb -->
    <div class="page-breadcrumb">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="breadcrumb-title"><?php echo $title ? $title : 'Dashboard'; ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-uppercase fw-bold">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>admin"
                            class="text-decoration-none">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $title ? $title : 'Dashboard'; ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Dynamic Content Starts Here -->
    <div class="container-fluid px-4 pb-5">