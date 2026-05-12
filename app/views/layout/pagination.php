<?php
/**
 * Shared Pagination Partial
 * Expected variables:
 * - $currentPage: int
 * - $totalPages: int
 * - $baseUrl: string (e.g. BASE_URL . 'product')
 */

$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$baseUrl = $baseUrl ?? '';

// Get all current GET parameters except 'page'
$queryParams = $_GET;
unset($queryParams['url']); // Remove MVC routing parameter if exists
unset($queryParams['page']);

/**
 * Helper to build page URL
 */
$buildUrl = function($page) use ($baseUrl, $queryParams) {
    $params = $queryParams;
    if ($page > 1) {
        $params['page'] = $page;
    }
    $queryString = !empty($params) ? '?' . http_build_query($params) : '';
    return $baseUrl . $queryString;
};

// Window sizing logic: 5 for desktop, 3 for mobile (handled via CSS d-none or PHP logic)
// To keep it simple and consistent with the user's request, we'll calculate the window here.
$window = 5; // Default window
?>

<?php if ($totalPages > 1): ?>
    <nav class="pagination-container" aria-label="Page navigation">
        <ul class="pagination pagination-modern justify-content-center">
            
            <!-- Previous Page -->
            <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage > 1 ? $buildUrl($currentPage - 1) : '#'; ?>" aria-label="Previous">
                    <i class="fas fa-chevron-left small"></i>
                </a>
            </li>

            <?php
            // Calculation logic for sliding window
            $start = max(1, $currentPage - 2);
            $end = min($totalPages, $currentPage + 2);
            
            // Adjust if at the beginning or end to keep window size
            if ($currentPage <= 3) {
                $end = min($totalPages, 5);
            }
            if ($currentPage > $totalPages - 2) {
                $start = max(1, $totalPages - 4);
            }

            // Small layout (mobile) window logic
            // We can output all and use CSS to hide some, or handle it here.
            // Let's use CSS classes to hide extra numbers on mobile.
            ?>

            <?php if ($start > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $buildUrl(1); ?>">1</a>
                </li>
                <?php if ($start > 2): ?>
                    <li class="page-item disabled ellipsis"><span class="page-link">...</span></li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <?php 
                    // Mark items for mobile visibility
                    // We want 3 items on mobile: current, prev, next (or close to it)
                    $isMobileVisible = ($i >= $currentPage - 1 && $i <= $currentPage + 1);
                ?>
                <li class="page-item <?php echo $currentPage == $i ? 'active' : ''; ?> <?php echo !$isMobileVisible ? 'd-none d-md-block' : ''; ?>">
                    <a class="page-link" href="<?php echo $buildUrl($i); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($end < $totalPages): ?>
                <?php if ($end < $totalPages - 1): ?>
                    <li class="page-item disabled ellipsis"><span class="page-link">...</span></li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $buildUrl($totalPages); ?>"><?php echo $totalPages; ?></a>
                </li>
            <?php endif; ?>

            <!-- Next Page -->
            <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage < $totalPages ? $buildUrl($currentPage + 1) : '#'; ?>" aria-label="Next">
                    <i class="fas fa-chevron-right small"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
