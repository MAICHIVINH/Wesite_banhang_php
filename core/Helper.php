<?php

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('renderPagination')) {
    /**
     * Hiển thị phân trang rút gọn thông minh với dấu ... cho dữ liệu lớn.
     *
     * @param int $totalPages Tổng số trang
     * @param int $currentPage Trang hiện tại
     * @param string|null $baseUrl URL tùy chỉnh (tùy chọn)
     * @param string|null $pageParam Tên tham số số trang (mặc định tự phát hiện: 'pageNumber' hoặc 'number')
     */
    function renderPagination(int $totalPages, int $currentPage, ?string $baseUrl = null, ?string $pageParam = null): void
    {
        if ($totalPages <= 1) {
            return;
        }

        if (empty($pageParam)) {
            if (isset($_GET['pageNumber'])) {
                $pageParam = 'pageNumber';
            } else {
                $pageParam = 'number';
            }
        }

        $currentPage = max(1, min((int)$currentPage, $totalPages));
        $adjacents = 2;

        $buildUrl = function ($p) use ($baseUrl, $pageParam) {
            if (!empty($baseUrl)) {
                if (strpos($baseUrl, '{page}') !== false) {
                    return str_replace('{page}', $p, $baseUrl);
                }
                $delimiter = (strpos($baseUrl, '?') !== false) ? '&' : '?';
                return $baseUrl . $delimiter . urlencode($pageParam) . '=' . $p;
            }

            $params = $_GET;
            $params[$pageParam] = $p;
            $script = isset($_SERVER['SCRIPT_NAME']) ? basename($_SERVER['SCRIPT_NAME']) : '';
            return ($script ? $script : '') . '?' . http_build_query($params);
        };

        echo '<nav aria-label="Phân trang" class="mt-4">';
        echo '<ul class="pagination justify-content-center flex-wrap gap-1 m-0">';

        // Nút Trang trước
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . e($buildUrl($currentPage - 1)) . '" aria-label="Trang trước">&laquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
        }

        $start = max(1, $currentPage - $adjacents);
        $end = min($totalPages, $currentPage + $adjacents);

        // Hiển thị trang 1
        if ($start > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . e($buildUrl(1)) . '">1</a></li>';
            if ($start > 2) {
                echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
            }
        }

        // Các trang giữa
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . e($buildUrl($i)) . '">' . $i . '</a></li>';
            }
        }

        // Hiển thị trang cuối
        if ($end < $totalPages) {
            if ($end < $totalPages - 1) {
                echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="' . e($buildUrl($totalPages)) . '">' . $totalPages . '</a></li>';
        }

        // Nút Trang sau
        if ($currentPage < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="' . e($buildUrl($currentPage + 1)) . '" aria-label="Trang sau">&raquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
}

