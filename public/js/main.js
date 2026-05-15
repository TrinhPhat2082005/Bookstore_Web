let latestCartCount = null;
let swup = null;

document.addEventListener('DOMContentLoaded', () => {
    swup = new Swup({
        containers: ["#swup", "#main-nav", "#header-user-actions"],
        animationSelector: '[class*="transition-"]',
        plugins: [],
        ignoreVisit: (url, { el } = {}) => {
            return url === window.location.href;
        }
    });
    initPremiumEffects();
    initAjaxCart();
    initProductFilters();
    initReadingProgress();
    initHeaderSearch();
    initHeroSlider();
    initRelatedSwiper();
    initHamburgerClose();
    swup.hooks.on('page:view', () => {
        initPremiumEffects();
        initAjaxCart();
        initProductFilters();
        initReadingProgress();
        initHeaderSearch();
        initHeroSlider();
        initRelatedSwiper();
        initHamburgerClose();
        syncCartBadge();
        window.scrollTo(0, 0);
    });
});
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
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsPanel.contains(e.target)) {
            resultsPanel.classList.add('d-none');
        }
    });
    searchInput.addEventListener('focus', () => {
        if (searchInput.value.trim().length >= 2) {
            resultsPanel.classList.remove('d-none');
        }
    });
}
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
}
function initPremiumEffects() {
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
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    }
}
function initProductFilters() {
    const filterForm = document.getElementById('filter-form');
    const productGrid = document.getElementById('product-grid');
    const categoryItems = document.querySelectorAll('.category-item');
    const categoryInput = document.getElementById('category-input');
    
    if (!filterForm || !productGrid) return;
    const handleFilterChange = debounce(() => {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
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
            initPremiumEffects();
            initAjaxCart();
            window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
        });
    }, 300);
    filterForm.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', handleFilterChange);
    });
    const mobileSearch = document.querySelector('.mobile-search-input');
    const mainSearch = filterForm.querySelector('input[name="keyword"]');
    if (mobileSearch && mainSearch) {
        mobileSearch.addEventListener('input', (e) => {
            mainSearch.value = e.target.value;
            handleFilterChange();
        });
    }
    categoryItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            categoryInput.value = item.getAttribute('data-value');
            categoryItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            
            handleFilterChange();
        });
    });
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
function debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}
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
function initAjaxCart() {
    const addBtn = document.querySelectorAll('.ajax-add-to-cart');
    
    addBtn.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-product-id');
            const quantity = btn.getAttribute('data-qty') || 1;
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
                    latestCartCount = data.cartCount;
                    if (swup && swup.cache) {
                        swup.cache.clear();
                    }
                    const badge = document.querySelector('.cart-count-badge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        badge.classList.remove('d-none');
                    }
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
