<?php require_once '../app/views/client/layout/header.php'; ?>

<style>
    :root {
        --th-primary: #1a1a1a;
        --th-accent: #3b82f6;
        --th-bg: #f9fafb;
    }

    .products-container {
        background-color: var(--th-bg);
        min-height: 100vh;
    }

    .sidebar-sticky {
        position: sticky;
        top: 100px;
        height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .glass-sidebar {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 1.5rem;
    }

    .filter-section {
        border-bottom: 1px solid #eee;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-section:last-child {
        border-bottom: none;
    }

    .filter-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--th-primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        margin-bottom: 1rem;
    }

    .product-card {
        border: none;
        background: transparent;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .product-card .image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        aspect-ratio: 2/3;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .product-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .quick-add {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        transition: bottom 0.3s ease;
    }

    .image-wrapper:hover .quick-add {
        bottom: 0;
    }

    .product-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        margin-top: 1rem;
        margin-bottom: 0.25rem;
        color: var(--th-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-author {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--th-accent);
    }

    .custom-checkbox .form-check-input:checked {
        background-color: var(--th-primary);
        border-color: var(--th-primary);
    }

    .btn-apply {
        background: var(--th-primary);
        color: white;
        border-radius: 2rem;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-apply:hover {
        background: #333;
        transform: scale(1.02);
    }

    .sort-select {
        border-radius: 2rem;
        padding-left: 1.25rem;
        padding-right: 2.5rem;
        background-color: white;
        border: 1px solid #eee;
    }
    .sidebar-sticky::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-sticky::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-sticky::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    .category-list {
        max-height: 200px;
        overflow-y: auto;
    }

    .category-item {
        display: block;
        padding: 0.25rem 0;
        color: #555;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.2s ease;
    }

    .category-item:hover,
    .category-item.active {
        color: var(--th-accent);
        font-weight: 600;
    }
</style>

<div class="products-container py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-sticky">
                    <div class="glass-sidebar p-4 shadow-sm">
                        <form action="<?php echo BASE_URL; ?>product" method="GET" id="filter-form">
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#avail-collapse">
                                    Tình trạng <i class="fas fa-chevron-down small"></i>
                                </div>
                                <div class="collapse show" id="avail-collapse">
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="radio" name="availability" value=""
                                            id="avail-all" <?php echo empty($data['filters']['availability']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="avail-all">Tất cả</label>
                                    </div>
                                    <div class="form-check custom-checkbox mb-2">
                                        <input class="form-check-input" type="radio" name="availability"
                                            value="in_stock" id="avail-in" <?php echo $data['filters']['availability'] === 'in_stock' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="avail-in">Còn hàng</label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input class="form-check-input" type="radio" name="availability"
                                            value="out_of_stock" id="avail-out" <?php echo $data['filters']['availability'] === 'out_of_stock' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="avail-out">Hết hàng</label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#cat-collapse">
                                    Danh mục <i class="fas fa-chevron-down small"></i>
                                </div>
                                <div class="collapse show" id="cat-collapse">
                                    <div class="category-list">
                                        <a href="#"
                                            class="category-item <?php echo empty($data['filters']['category']) ? 'active' : ''; ?>"
                                            data-value="">Tất cả</a>
                                        <?php foreach ($data['categories'] as $cat): ?>
                                            <a href="#"
                                                class="category-item <?php echo $data['filters']['category'] === $cat->category ? 'active' : ''; ?>"
                                                data-value="<?php echo htmlspecialchars($cat->category); ?>">
                                                <?php echo htmlspecialchars($cat->category); ?>
                                            </a>
                                        <?php endforeach; ?>
                                        <input type="hidden" name="category" id="category-input"
                                            value="<?php echo htmlspecialchars($data['filters']['category']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="filter-section">
                                <div class="filter-title" data-bs-toggle="collapse" data-bs-target="#price-collapse">
                                    Giá <i class="fas fa-chevron-down small"></i>
                                </div>
                                <div class="collapse show" id="price-collapse">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-5">
                                            <input type="number" name="min_price" id="min_price"
                                                class="form-control form-control-sm rounded-pill" placeholder="Min"
                                                min="0"
                                                value="<?php echo htmlspecialchars($data['filters']['min_price']); ?>">
                                        </div>
                                        <div class="col-2 text-center text-muted small">—</div>
                                        <div class="col-5">
                                            <input type="number" name="max_price" id="max_price"
                                                class="form-control form-control-sm rounded-pill" placeholder="Max"
                                                min="0"
                                                value="<?php echo htmlspecialchars($data['filters']['max_price']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-section">
                                <div class="filter-title">
                                    Tìm kiếm
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="keyword"
                                        class="form-control rounded-pill-start border-end-0" placeholder="Tên sách..."
                                        value="<?php echo htmlspecialchars($data['filters']['keyword']); ?>">
                                    <button class="btn btn-outline-secondary rounded-pill-end border-start-0"
                                        type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-apply w-100 shadow-sm mt-2">
                                Áp dụng
                            </button>

                            <a href="<?php echo BASE_URL; ?>product"
                                class="btn btn-link w-100 text-decoration-none text-muted small mt-2">
                                Xóa bộ lọc
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="d-lg-none mb-4">
                    <div class="input-group glass-card rounded-pill px-3 py-2 shadow-sm border-0 bg-white">
                        <span class="input-group-text border-0 bg-transparent ps-0">
                            <i class="fas fa-search text-muted opacity-50"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-0 bg-transparent shadow-none mobile-search-input" 
                               placeholder="Tìm kiếm sách..." value="<?php echo htmlspecialchars($data['filters']['keyword']); ?>">
                    </div>
                </div>

                <div id="product-grid">
                    <?php require '_grid.php'; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once '../app/views/client/layout/footer.php'; ?>