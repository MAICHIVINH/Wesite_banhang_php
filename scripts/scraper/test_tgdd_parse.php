<?php
$url = "https://www.thegioididong.com/tim-kiem?key=" . urlencode("iPhone 16 Pro Max");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
curl_close($ch);

// Tìm li.item hoặc item-img hoặc h3 trong TGDD search
preg_match_all('/<h3[^>]*>(.*?)<\/h3>.*?<strong class="price"[^>]*>(.*?)<\/strong>/s', $html, $matches, PREG_SET_ORDER);

echo "Found items: " . count($matches) . "\n";
foreach (array_slice($matches, 0, 5) as $item) {
    $title = trim(strip_tags($item[1]));
    $price = trim(strip_tags($item[2]));
    echo "TGDD Item: $title - Price: $price\n";
}
