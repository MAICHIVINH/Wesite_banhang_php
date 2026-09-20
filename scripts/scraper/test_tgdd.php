<?php
function testScrapeTgdd($keyword) {
    $url = "https://www.thegioididong.com/tim-kiem?key=" . urlencode($keyword);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    echo "TGDD HTML length: " . strlen($html) . "\n";
    
    // Tìm giá trong HTML (ví dụ class="price" hoặc regex số tiền)
    if (preg_match_all('/(?:class="price"|strong class="price"|strong>)([\d\.\s₫\?đ]+)/u', $html, $matches)) {
        print_r(array_slice($matches[1], 0, 10));
    }
}

testScrapeTgdd("iPhone 16 Pro Max");
