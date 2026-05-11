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

    /* Custom Scrollbar for Sidebar */
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
            <!-- Sidebar Filters -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="sidebar-sticky">
                    <div class="glass-sidebar p-4 shadow-sm">
                        <form action="<?php echo BASE_URL; ?>product" method="GET" id="filter-form">
                            <!-- Availability -->
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

                            <!-- Categories -->
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

                            <!-- Price Range -->
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

                            <!-- Search Keyword -->
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

            <!-- Products List -->
            <div class="col-lg-9">
                <!-- Toolbar -->
                <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom">
                    <h2 class="h4 fw-bold mb-0">
                        <?php echo count($data['products']); ?> sách được tìm thấy
                    </h2>
                    <div class="d-flex align-items-center gap-3">
                        <label class="small text-muted d-none d-sm-block">Sắp xếp theo:</label>
                        <select name="sort" class="form-select form-select-sm sort-select" form="filter-form"
                            onchange="this.form.submit()">
                            <option value="newest" <?php echo $data['filters']['sort'] === 'newest' ? 'selected' : ''; ?>>
                                Mới nhất</option>
                            <option value="price_asc" <?php echo $data['filters']['sort'] === 'price_asc' ? 'selected' : ''; ?>>Giá: Từ thấp đến cao</option>
                            <option value="price_desc" <?php echo $data['filters']['sort'] === 'price_desc' ? 'selected' : ''; ?>>Giá: Từ cao đến thấp</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <?php if (!empty(array_filter($data['filters'], fn($v) => $v !== '' && $v !== 'newest'))): ?>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php foreach ($data['filters'] as $key => $value): ?>
                            <?php if (($value !== '' && $value !== null) && $key !== 'sort'): ?>
                                <span class="badge bg-white text-dark border rounded-pill px-3 py-2 fw-normal">
                                    <?php
                                    if ($key === 'availability')
                                        echo $value === 'in_stock' ? 'In Stock' : 'Out of Stock';
                                    elseif ($key === 'min_price') {
                                        $displayVal = $value;
                                        if ($displayVal > 0 && $displayVal < 1000)
                                            $displayVal *= 1000;
                                        echo 'Min: ' . number_format($displayVal) . '₫';
                                    } elseif ($key === 'max_price') {
                                        $displayVal = $value;
                                        if ($displayVal > 0 && $displayVal < 1000)
                                            $displayVal *= 1000;
                                        echo 'Max: ' . number_format($displayVal) . '₫';
                                    } else
                                        echo htmlspecialchars($value);
                                    ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($data['products'])): ?>
                    <div class="text-center py-5 my-5">
                        <div class="mb-4">
                            <i class="fas fa-search fa-4x text-muted opacity-25"></i>
                        </div>
                        <h3 class="fw-bold">No books match your criteria</h3>
                        <p class="text-secondary">Try adjusting your filters or search term.</p>
                        <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary rounded-pill px-5 py-2 mt-3">Reset
                            All Filters</a>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 g-xl-5">
                        <?php $delay = 0;
                        foreach ($data['products'] as $product): ?>
                            <div class="col" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                                <?php $delay = ($delay < 400) ? $delay + 100 : 0; ?>
                                <div class="product-card">
                                    <div class="image-wrapper shadow-sm position-relative">
                                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                                            class="text-decoration-none">
                                            <?php if ($product->image): ?>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($product->image); ?>"
                                                    alt="<?php echo htmlspecialchars($product->name); ?>">
                                            <?php else: ?>
                                                <div class="h-100 d-flex align-items-center justify-content-center bg-light">
                                                    <i class="fas fa-book fa-3x text-muted opacity-25"></i>
                                                </div>
                                            <?php endif; ?>
                                        </a>

                                        <?php if ($product->stock <= 0): ?>
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span class="badge bg-danger rounded-pill">Out of Stock</span>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Quick Add Button (Hover) -->
                                        <?php if ($product->stock > 0): ?>
                                            <div class="quick-add d-flex justify-content-center">
                                                <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold ajax-add-to-cart" data-product-id="<?php echo $product->id; ?>">
                                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="<?php echo BASE_URL; ?>product/detail/<?php echo $product->id; ?>"
                                            class="text-decoration-none">
                                            <h3 class="product-title"><?php echo htmlspecialchars($product->name); ?></h3>
                                        </a>
                                        <p class="product-author">
                                            <?php echo htmlspecialchars($product->author ?? 'Unknown Author'); ?>
                                        </p>
                                        <p class="product-price"><?php echo number_format($product->price, 0, ',', '.'); ?>₫</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryItems = document.querySelectorAll('.category-item');
        const categoryInput = document.getElementById('category-input');
        const filterForm = document.getElementById('filter-form');

        // Handle Category selection
        categoryItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                categoryInput.value = this.getAttribute('data-value');
                filterForm.submit();
            });
        });

        // Handle Min/Max Price Validation
        if (filterForm) {
            filterForm.addEventListener('submit', function (e) {
                const minInput = document.getElementById('min_price');
                const maxInput = document.getElementById('max_price');

                if (minInput && maxInput) {
                    const min = parseFloat(minInput.value) || 0;
                    const max = parseFloat(maxInput.value) || Infinity;

                    if (max < min && max !== Infinity) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Lỗi khoảng giá',
                            text: 'Giá tối đa phải lớn hơn hoặc bằng giá tối thiểu.',
                            confirmButtonColor: '#6366f1'
                        });
                    }
                }
            });
        }

        // Handle tilt effect (if VanillaTilt is loaded)
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.querySelectorAll(".image-wrapper"), {
                max: 10,
                speed: 400,
                glare: true,
                "max-glare": 0.3,
            });
        }
    });
</script>

<?php require_once '../app/views/client/layout/footer.php'; ?>