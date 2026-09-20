<?php
function searchCellphoneS($keyword) {
    $url = "https://cellphones.com.vn/graphql";
    // Đơn giản hơn: Cào từ Google Search hoặc Bing HTML search hoặc DuckDuckGo HTML
    $searchUrl = "https://html.duckduckgo.com/html/?q=" . urlencode($keyword . " cellphones.com.vn fptshop.com.vn thegioididong.com gia ban");
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $html = curl_exec($ch);
    curl_close($ch);
    
    echo "Length: " . strlen($html) . "\n";
    if (preg_match_all('/<a class="result__url" href="([^"]+)".*?>(.*?)<\/a>/s', $html, $matches)) {
        print_r(array_slice($matches[1], 0, 5));
    }
}

searchCellphoneS("iPhone 16 Pro Max 256GB");
