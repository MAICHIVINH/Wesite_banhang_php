<?php
require_once __DIR__ . '/../controllers/GeminiService.php';
require_once __DIR__ . '/../models/AiKnowledgeBase.php';

$gemini = new GeminiService();
$kbModel = new AiKnowledgeBase();

echo "=== TEST 1: HỎI TRI THỨC MẶC ĐỊNH SẴN CÓ ===\n";
$q1 = "Địa chỉ cửa hàng GARENA ở đâu?";
echo "Hỏi: \"$q1\"\n";
echo "AI Trả Lời:\n" . $gemini->ask($q1) . "\n\n";

echo "=== TEST 2: HUẤN LUYỆN AI TRI THỨC MỚI (CHÍNH SÁCH HỌC SINH SINH VIÊN) ===\n";
$kbModel->insert([
    'keywords' => 'học sinh, sinh viên, hssv, ưu đãi sinh viên, giảm giá sinh viên',
    'intent_category' => 'Ưu đãi Sinh Viên',
    'question_pattern' => 'Shop có giảm giá cho học sinh sinh viên không?',
    'answer_template' => "Dạ GARENA có chương trình **ƯU ĐÃI ĐẶC BIỆT CHO HỌC SINH - SINH VIÊN**:\n\n- **Giảm ngay 500.000 VNĐ** cho tất cả các dòng Laptop & MacBook khi xuất trình thẻ HSSV chính chủ.\n- **Tặng thêm balo cao cấp** và voucher vệ sinh máy miễn phí trọn đời!",
    'priority' => 15,
    'status' => 1,
    'isDeleted' => 0
]);
echo "-> Đã nạp tri thức mới về 'Ưu đãi Sinh Viên' vào cơ sở dữ liệu ai_knowledge_base!\n\n";

echo "=== TEST 3: HỎI CÂU VỪA HUẤN LUYỆN DẠY AI ===\n";
$q2 = "Em là sinh viên có được giảm giá mua laptop không?";
echo "Hỏi: \"$q2\"\n";
echo "AI Trả Lời:\n" . $gemini->ask($q2) . "\n\n";
