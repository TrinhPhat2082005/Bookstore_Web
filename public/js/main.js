/**
 * Bookstore Premium Core JS
 * Handles: Swup, Theme Toggle, Vanilla Tilt, and AJAX Logic
 */

// Biến toàn cục lưu số lượng giỏ hàng mới nhất (cập nhật bởi AJAX)
let latestCartCount = null;
let swup = null; // Biến toàn cục để các hàm khác có thể truy cập Swup

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Swup for smooth page transitions
    swup = new Swup({
        containers: ["#swup", "#main-nav", "#header-user-actions"],
        animationSelector: '[class*="transition-"]',
        plugins: [],
        ignoreVisit: (url, { el } = {}) => {
            // Ignore if clicking same page
            return url === window.location.href;
        }
    });

    // 2. Initial Run
    initPremiumEffects();
    initAjaxCart();
    initProductFilters();
    initReadingProgress();
    initHeaderSearch();
    initHeroSlider();
    initRelatedSwiper();
    initHamburgerClose();

    // 3. Robust lifecycle handling
    swup.hooks.on('page:view', () => {
        initPremiumEffects();
        initAjaxCart();
        initProductFilters();
        initReadingProgress();
        initHeaderSearch();
        initHeroSlider();
        initRelatedSwiper();
        initHamburgerClose();
        syncCartBadge(); // Đồng bộ lại badge giỏ hàng sau khi Swup chuyển trang
        window.scrollTo(0, 0);
    });
});

/**
 * Related Products Swiper
 */
function initRelatedSwiper() {
    if (document.querySelector('.related-swiper')) {
        new Swiper('.related-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: true,
            },
        });
    }
}

/**
 * Hero Slider initialization
 */
function initHeroSlider() {
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
}

/**
 * Header Live Search with instant results
 */
function initHeaderSearch() {
    const searchInput = document.getElementById('header-search');
    const resultsPanel = document.getElementById('search-results');
    
    if (!searchInput || !resultsPanel) return;

    const handleSearch = debounce(async (e) => {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            resultsPanel.classList.add('d-none');
            return;
        }

        try {
            const response = await fetch(`${window.location.origin}/bookstore_web/product/search_api?keyword=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();

            if (data.length > 0) {
                let html = '<div class="p-2">';
                data.forEach(item => {
                    html += `
                        <a href="${window.location.origin}/bookstore_web/product/detail/${item.id}" class="d-flex align-items-center gap-3 p-3 text-decoration-none hover-light rounded-4">
                            <div class="flex-shrink-0" style="width: 45px; height: 60px;">
                                <img src="${item.image || (window.location.origin + '/bookstore_web/assets/no-image.png')}" class="w-100 h-100 object-fit-cover rounded-2 shadow-sm">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="text-main mb-0 text-truncate fw-bold">${item.name}</h6>
                                <p class="text-secondary small mb-0 text-truncate">${item.author || 'Tác giả'}</p>
                                <span class="text-accent small fw-bold">${item.price}₫</span>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
                html += `
                    <a href="${window.location.origin}/bookstore_web/product?keyword=${encodeURIComponent(query)}" class="d-block p-3 text-center bg-light text-decoration-none text-main fw-bold small border-top">
                        Xem tất cả kết quả
                    </a>
                `;
                resultsPanel.innerHTML = html;
                resultsPanel.classList.remove('d-none');
            } else {
                resultsPanel.innerHTML = '<div class="p-4 text-center text-secondary small">Không tìm thấy kết quả nào</div>';
                resultsPanel.classList.remove('d-none');
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);

    searchInput.addEventListener('input', handleSearch);

    // Close on click outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsPanel.contains(e.target)) {
            resultsPanel.classList.add('d-none');
        }
    });

    // Re-show on focus if has value
    searchInput.addEventListener('focus', () => {
        if (searchInput.value.trim().length >= 2) {
            resultsPanel.classList.remove('d-none');
        }
    });
}

/**
 * Reading Progress Bar for articles
 */
function initReadingProgress() {
    const progressBar = document.getElementById('progress-bar');
    if (!progressBar) return;

    const updateProgress = () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    };

    window.addEventListener('scroll', updateProgress);
    // Cleanup event on page change if needed or just let it overwrite
}

/**
 * Re-initializes 3D Tilt and other visual effects
 */
function initPremiumEffects() {
    // 3D Tilt for Book Covers
    const tiltElements = document.querySelectorAll('.book-frame');
    if (tiltElements.length > 0) {
        VanillaTilt.init(tiltElements, {
            max: 12,
            speed: 400,
            glare: true,
            "max-glare": 0.2,
            perspective: 1000,
            scale: 1.03
        });
    }

    // Initialize Bootstrap Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Refresh AOS for new elements
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    }
}

/**
 * AJAX Product Filtering
 */
function initProductFilters() {
    const filterForm = document.getElementById('filter-form');
    const productGrid = document.getElementById('product-grid');
    const categoryItems = document.querySelectorAll('.category-item');
    const categoryInput = document.getElementById('category-input');
    
    if (!filterForm || !productGrid) return;

    // Handle Input Changes (Instant Filter)
    const handleFilterChange = debounce(() => {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        
        // Show Loading State (Skeleton)
        productGrid.style.opacity = '0.5';
        productGrid.style.pointerEvents = 'none';

        fetch(`${filterForm.action}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            productGrid.innerHTML = html;
            productGrid.style.opacity = '1';
            productGrid.style.pointerEvents = 'auto';
            
            // Re-init Effects for new items
            initPremiumEffects();
            initAjaxCart();
            
            // Update URL without reload
            window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
        });
    }, 300);

    // Bind inputs
    filterForm.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', handleFilterChange);
    });

    // Handle Mobile Search Sync
    const mobileSearch = document.querySelector('.mobile-search-input');
    const mainSearch = filterForm.querySelector('input[name="keyword"]');
    if (mobileSearch && mainSearch) {
        mobileSearch.addEventListener('input', (e) => {
            mainSearch.value = e.target.value;
            handleFilterChange();
        });
    }

    // Handle Category Items (Special Case)
    categoryItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            categoryInput.value = item.getAttribute('data-value');
            
            // Update Active Class
            categoryItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            
            handleFilterChange();
        });
    });

    // Price Range Validation
    filterForm.addEventListener('submit', (e) => {
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
                    text: 'Giá tối đa phải lớn hơn hoặc bằng giá tối thiểu.'
                });
                return;
            }
        }
        e.preventDefault();
        handleFilterChange();
    });
}

/**
 * Debounce utility to limit rapid function calls
 */
function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}


/**
 * Đồng bộ badge giỏ hàng sau khi Swup chuyển trang
 * Nếu latestCartCount đã được cập nhật bởi AJAX, ghi đè lên giá trị server-rendered
 */
function syncCartBadge() {
    if (latestCartCount !== null) {
        const badge = document.querySelector('.cart-count-badge');
        if (badge) {
            badge.textContent = latestCartCount;
            if (latestCartCount > 0) {
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }
        }
    }
}

/**
 * AJAX Add-to-cart Logic
 */
function initAjaxCart() {
    const addBtn = document.querySelectorAll('.ajax-add-to-cart');
    
    addBtn.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-product-id');
            const quantity = btn.getAttribute('data-qty') || 1;
            
            // Visual feedback on button
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Đang thêm...';
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                const response = await fetch(`${window.location.origin}/bookstore_web/cart/add/${productId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Lưu số lượng mới nhất vào biến toàn cục
                    latestCartCount = data.cartCount;
                    
                    // Xóa cache Swup để trang Cart luôn tải dữ liệu mới
                    if (swup && swup.cache) {
                        swup.cache.clear();
                    }
                    
                    // Update Cart Badge
                    const badge = document.querySelector('.cart-count-badge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        badge.classList.remove('d-none');
                    }
                    
                    // Success Toast
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã thêm vào giỏ hàng!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: error.message || 'Không thể thêm sản phẩm vào giỏ hàng.'
                });
            } finally {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        });
    });
}

/**
 * Auto-close hamburger menu on link click (for Swup transitions)
 */
function initHamburgerClose() {
    const navbarCollapse = document.getElementById('navbarNav');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link, .dropdown-item');
    
    if (navbarCollapse && navLinks.length > 0) {
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    }
}
