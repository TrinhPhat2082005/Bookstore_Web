<?php
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$baseUrl = $baseUrl ?? '';
$queryParams = $_GET;
unset($queryParams['url']);
unset($queryParams['page']);
$buildUrl = function($page) use ($baseUrl, $queryParams) {
    $params = $queryParams;
    if ($page > 1) {
        $params['page'] = $page;
    }
    $queryString = !empty($params) ? '?' . http_build_query($params) : '';
    return $baseUrl . $queryString;
};
$window = 5;
?>

<?php if ($totalPages > 1): ?>
    <nav class="pagination-container" aria-label="Page navigation">
        <ul class="pagination pagination-modern justify-content-center">
            <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage > 1 ? $buildUrl($currentPage - 1) : '#'; ?>" aria-label="Previous">
                    <i class="fas fa-chevron-left small"></i>
                </a>
            </li>

            <?php
            $start = max(1, $currentPage - 2);
            $end = min($totalPages, $currentPage + 2);
            if ($currentPage <= 3) {
                $end = min($totalPages, 5);
            }
            if ($currentPage > $totalPages - 2) {
                $start = max(1, $totalPages - 4);
            }
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
            <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage < $totalPages ? $buildUrl($currentPage + 1) : '#'; ?>" aria-label="Next">
                    <i class="fas fa-chevron-right small"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
