<?php
function fetchTgddRealPrice($keyword) {
    $url = "https://www.thegioididong.com/tim-kiem?key=" . urlencode($keyword);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    // Tìm các thẻ chứa data-price và tên sản phẩm
    if (preg_match_all('/data-name="([^"]+)".*?data-price="([\d\.]+)"/s', $html, $matches, PREG_SET_ORDER)) {
        return $matches;
    }
    
    // Pattern 2: data-price trước, name trong h3
    if (preg_match_all('/<li[^>]*class="[^"]*item[^"]*"[^>]*data-price="([\d\.]+)".*?>.*?<h3>(.*?)<\/h3>/s', $html, $matches, PREG_SET_ORDER)) {
        return $matches;
    }

    return [];
}

$results = fetchTgddRealPrice("iPhone 16 Pro Max 256GB");
echo "Found " . count($results) . " items on TGDD:\n";
print_r(array_slice($results, 0, 5));
