<?php
require_once __DIR__ . '/../controllers/GeminiService.php';

$gemini = new GeminiService();

$tests = [
    "Đồng hồ này sài thế nào",
    "Laptop này xài tốt không",
    "Shop có đồng hồ Xiaomi Watch không?",
    "Tư vấn cho tôi 1 máy tính có tầm giá 30tr"
];

foreach ($tests as $i => $q) {
    echo "=== TEST " . ($i + 1) . ": \"$q\" ===\n";
    echo "AI Trả lời:\n" . $gemini->ask($q) . "\n\n";
}
