<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?> | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --admin-bg: #f3f4f6; --admin-sidebar: #111827; --admin-accent: #3b82f6; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--admin-bg); display: flex; }
        .sidebar { width: 260px; height: 100vh; background: var(--admin-sidebar); color: white; padding: 30px 20px; position: fixed; }
        .sidebar h2 { font-size: 20px; margin-bottom: 40px; color: var(--admin-accent); }
        .sidebar nav ul { list-style: none; }
        .sidebar nav ul li { margin-bottom: 10px; }
        .sidebar nav ul li a { color: #9ca3af; text-decoration: none; display: block; padding: 12px; border-radius: 8px; transition: 0.3s; }
        .sidebar nav ul li a:hover, .sidebar nav ul li a.active { background: #1f2937; color: white; }
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .header-content { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 15px; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .badge-unread { background: #fee2e2; color: #991b1b; }
        .badge-read { background: #dcfce7; color: #166534; }
        .btn-sm { padding: 6px 12px; border-radius: 6px; font-size: 13px; text-decoration: none; display: inline-block; }
        .pagination { display: flex; gap: 5px; margin-top: 30px; }
        .pagination a { padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; color: #374151; }
        .pagination a.active { background: var(--admin-accent); color: white; border-color: var(--admin-accent); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>BookStore Admin</h2>
        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>admin"><i class="fas fa-chart-line" style="width: 25px;"></i> Dashboard</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/manageInfo" class="<?php echo $data['title'] == 'Quản lý thông tin website' ? 'active' : ''; ?>"><i class="fas fa-info-circle" style="width: 25px;"></i> Thông tin Website</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/manageProducts"><i class="fas fa-book" style="width: 25px;"></i> Sản phẩm</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/manageContacts" class="<?php echo $data['title'] == 'Quản lý liên hệ' ? 'active' : ''; ?>"><i class="fas fa-envelope" style="width: 25px;"></i> Liên hệ</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <div class="header-content">
            <h1><?php echo $data['title']; ?></h1>
            <div class="admin-profile">Admin</div>
        </div>
