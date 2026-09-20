<?php
$url = "https://www.thegioididong.com/tim-kiem?key=" . urlencode("iPhone 16 Pro Max");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
curl_close($ch);

if (preg_match_all('/(iPhone 16 Pro Max[^\x00-\x1F<]{1,100})/u', $html, $matches)) {
    echo "Found title matches:\n";
    print_r(array_unique(array_slice($matches[1], 0, 10)));
}

if (preg_match_all('/([\d]{1,3}(?:\.[\d]{3}){2,3}\s*₫)/u', $html, $matchesPrice)) {
    echo "Found price matches:\n";
    print_r(array_unique(array_slice($matchesPrice[1], 0, 10)));
}
