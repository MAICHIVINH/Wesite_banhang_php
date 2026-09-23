<?php
require_once __DIR__ . '/../core/Models.php';

class AiKnowledgeBase extends Model
{
    protected $table = "ai_knowledge_base";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'keywords' => 'TEXT',
        'intent_category' => 'VARCHAR(100)',
        'question_pattern' => 'TEXT',
        'answer_template' => 'TEXT',
        'priority' => 'INT DEFAULT 0',
        'status' => 'TINYINT(1) DEFAULT 1',
        'isDeleted' => 'TINYINT(1) DEFAULT 0',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function getAllActive()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 1 AND isDeleted = 0 ORDER BY priority DESC, id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function seedDefaultKnowledge()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        $count = (int)$stmt->fetchColumn();

        if ($count === 0) {
            $defaults = [
                [
                    'keywords' => 'địa chỉ, cửa hàng, ở đâu, vị trí, shop ở đâu, tới shop',
                    'intent_category' => 'Địa chỉ cửa hàng',
                    'question_pattern' => 'Địa chỉ cửa hàng GARENA ở đâu?',
                    'answer_template' => "Cửa hàng GARENA có trụ sở chính tại **123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh**.\n\n- Giờ mở cửa: **8:00 - 21:30** (Tất cả các ngày trong tuần, kể cả Thứ 7 và Chủ Nhật).\n- Hotline hỗ trợ: **1900 6868**.",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ],
                [
                    'keywords' => 'bảo hành, 1 đổi 1, thời gian bảo hành, tem bảo hành, đổi trả',
                    'intent_category' => 'Bảo hành & Đổi trả',
                    'question_pattern' => 'Chính sách bảo hành tại GARENA như thế nào?',
                    'answer_template' => "Tất cả sản phẩm bán ra tại **GARENA** đều là hàng chính hãng 100%:\n\n- **Bảo hành**: 12 - 24 tháng theo tiêu chuẩn nhà sản xuất.\n- **Chính sách 1 đổi 1**: Áp dụng trong 30 ngày đầu tiên nếu máy phát sinh lỗi phần cứng từ NSX.\n- **Hỗ trợ**: Tiếp nhận bảo hành tại tất cả chi nhánh hoặc gửi chuyển phát nhanh miễn phí.",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ],
                [
                    'keywords' => 'giao hàng, ship, vận chuyển, hỏa tốc, phí ship, ship toàn quốc',
                    'intent_category' => 'Giao hàng & Vận chuyển',
                    'question_pattern' => 'GARENA có giao hàng tận nơi không?',
                    'answer_template' => "GARENA hỗ trợ **giao hàng hỏa tốc toàn quốc**:\n\n- **Nội thành TP.HCM**: Giao nhanh trong 2 giờ.\n- **Toàn quốc**: Miễn phí vận chuyển cho đơn hàng từ 5.000.000 VNĐ.\n- **Kiểm tra hàng**: Khách hàng được đồng kiểm và thử máy trước khi thanh toán.",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ],
                [
                    'keywords' => 'trả góp, 0%, lãi suất, cccd, thẻ tín dụng, thủ tục trả góp',
                    'intent_category' => 'Trả góp',
                    'question_pattern' => 'Shop có bán trả góp 0% không?',
                    'answer_template' => "GARENA hỗ trợ mua **trả góp 0% lãi suất** vô cùng linh hoạt:\n\n- **Qua Thẻ Tín Dụng**: Hỗ trợ 28 ngân hàng, duyệt online 3 phút.\n- **Qua Công Ty Tài Chính**: Chỉ cần CCCD gắn chip, duyệt nhanh 15 phút không cần chứng minh thu nhập.",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ],
                [
                    'keywords' => 'khuyến mãi, ưu đãi, giảm giá, voucher, quà tặng',
                    'intent_category' => 'Khuyến mãi',
                    'question_pattern' => 'Shop đang có chương trình khuyến mãi gì?',
                    'answer_template' => "Các chương trình ưu đãi hấp dẫn đang diễn ra tại GARENA:\n\n- **Giảm ngay đến 20%** cho các dòng MacBook & iPhone mới nhất.\n- **Tặng combo phụ kiện** trị giá 500.000 VNĐ khi mua Laptop Gaming.\n- **Voucher 200.000 VNĐ** cho khách hàng đăng ký tài khoản mới.",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ],
                [
                    'keywords' => 'liên hệ, hotline, tổng đài, tư vấn viên, gặp nhân viên',
                    'intent_category' => 'Liên hệ',
                    'question_pattern' => 'Làm sao để liên hệ gặp nhân viên tư vấn?',
                    'answer_template' => "Bạn có thể liên hệ trực tiếp với đội ngũ hỗ trợ của GARENA qua các kênh:\n\n- **Hotline tư vấn**: 1900 6868 (8:00 - 21:30)\n- **Zalo Chăm sóc khách hàng**: 0988 123 456\n- **Email**: hotro@garena-store.vn",
                    'priority' => 10,
                    'status' => 1,
                    'isDeleted' => 0
                ]
            ];

            foreach ($defaults as $data) {
                $sql = "INSERT INTO {$this->table} (keywords, intent_category, question_pattern, answer_template, priority, status, isDeleted) VALUES (:keywords, :intent_category, :question_pattern, :answer_template, :priority, :status, :isDeleted)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($data);
            }
        }
    }
}
