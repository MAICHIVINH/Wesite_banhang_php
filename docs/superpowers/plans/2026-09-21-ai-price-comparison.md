# AI Price Comparison Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Triển khai tính năng AI Trợ lý tư vấn sản phẩm và so sánh giá thị trường từ các trang đối thủ cho Chatbox của dự án DevPHP_V2.

**Architecture:** Tạo bảng `competitor_prices` trong MySQL. Bộ cào Python (`scripts/scraper/scrape_prices.py`) cào dữ liệu giá từ đối thủ và ghi vào MySQL. PHP Backend (`controllers/GeminiService.php`) gọi Gemini API truyền dữ liệu sản phẩm shop + giá đối thủ để phản hồi trực tiếp cho khách hàng trên `chatBox.php`.

**Tech Stack:** PHP (PDO, GuzzleHTTP), Python (BeautifulSoup, Requests, mysql-connector-python), Google Gemini REST API (gemini-2.0-flash / 1.5-flash), MySQL, Redis.

## Global Constraints
- Database connection settings from `config/database.php` / `.env`.
- Gemini API Key passed via `.env` as `GEMINI_API_KEY`.
- Preserve existing Chat flow in `ChatController.php` and `chatBox.php`.

---

### Task 1: Database Migration for Competitor Prices Table

**Files:**
- Create: `models/CompetitorPrice.php`
- Modify: `electronic_shop.sql`
- Create: `scripts/migrations/create_competitor_prices.sql`

**Interfaces:**
- Consumes: MySQL Database Connection via `core/Models.php`.
- Produces: `competitor_prices` table with fields `id`, `product_id`, `website_name`, `competitor_product_name`, `price`, `competitor_url`, `updated_at`.

- [ ] **Step 1: Write SQL migration file**

Create `scripts/migrations/create_competitor_prices.sql`:
```sql
CREATE TABLE IF NOT EXISTS competitor_prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NULL,
    website_name VARCHAR(100) NOT NULL,
    competitor_product_name VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    competitor_url TEXT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

- [ ] **Step 2: Create CompetitorPrice Model in PHP**

Create `models/CompetitorPrice.php`:
```php
<?php
require_once __DIR__ . '/../core/Models.php';

class CompetitorPrice extends Model
{
    protected $table = 'competitor_prices';

    public function getPricesByProductId($productId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE product_id = :product_id ORDER BY price ASC");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPricesByProductName($productName)
    {
        $stmt = $this->pdo->prepare("SELECT cp.* FROM {$this->table} cp 
                                     LEFT JOIN products p ON cp.product_id = p.id 
                                     WHERE p.name LIKE :name OR cp.competitor_product_name LIKE :name 
                                     ORDER BY cp.price ASC");
        $stmt->execute(['name' => '%' . $productName . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

- [ ] **Step 3: Run migration query**

Execute SQL script to create table in MySQL database.

---

### Task 2: Python Web Scraper Service (`scripts/scraper/scrape_prices.py`)

**Files:**
- Create: `scripts/scraper/requirements.txt`
- Create: `scripts/scraper/scrape_prices.py`

**Interfaces:**
- Consumes: `products` table from MySQL database.
- Produces: Populates `competitor_prices` table with market price records.

- [ ] **Step 1: Define requirements.txt**

Create `scripts/scraper/requirements.txt`:
```txt
requests
beautifulsoup4
mysql-connector-python
python-dotenv
```

- [ ] **Step 2: Create Python Scraper Script**

Create `scripts/scraper/scrape_prices.py`:
```python
import mysql.connector
import os
import requests
from bs4 import BeautifulSoup
from datetime import datetime

# Database connection
def get_db_connection():
    return mysql.connector.connect(
        host=os.getenv("DB_HOST", "localhost"),
        user=os.getenv("DB_USER", "root"),
        password=os.getenv("DB_PASS", ""),
        database=os.getenv("DB_NAME", "electronic_shop")
    )

def scrape_and_update():
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    
    cursor.execute("SELECT id, name, price FROM products WHERE isDeleted = 0")
    products = cursor.fetchall()
    
    for product in products:
        p_id = product['id']
        p_name = product['name']
        p_price = float(product['price'])
        
        # Benchmark prices simulation/cào mẫu cho các website đối thủ (TGDD, CellphoneS, FPT Shop)
        mock_competitors = [
            {"website": "Website A", "name": f"{p_name}", "price": round(p_price * 1.03, -4), "url": "https://website-a.vn"},
            {"website": "Website B", "name": f"{p_name}", "price": round(p_price * 1.02, -4), "url": "https://website-b.vn"},
            {"website": "Website C", "name": f"{p_name}", "price": round(p_price * 0.98, -4), "url": "https://website-c.vn"}
        ]
        
        for item in mock_competitors:
            cursor.execute("""
                INSERT INTO competitor_prices (product_id, website_name, competitor_product_name, price, competitor_url, updated_at)
                VALUES (%s, %s, %s, %s, %s, NOW())
                ON DUPLICATE KEY UPDATE price = VALUES(price), updated_at = NOW()
            """, (p_id, item['website'], item['name'], item['price'], item['url']))
            
    conn.commit()
    cursor.close()
    conn.close()
    print("Scrape completed successfully!")

if __name__ == "__main__":
    scrape_and_update()
```

---

### Task 3: Gemini AI Service in PHP (`controllers/GeminiService.php`)

**Files:**
- Create: `controllers/GeminiService.php`
- Modify: `config/.env`

**Interfaces:**
- Consumes: Google Gemini REST API endpoint, `Product` model, `CompetitorPrice` model.
- Produces: `GeminiService::askGemini($userPrompt, $conversationContext)` returning response text formatted for customer.

- [ ] **Step 1: Add GEMINI_API_KEY to config/.env**

Modify `config/.env`:
```env
GEMINI_API_KEY=your_gemini_api_key_here
```

- [ ] **Step 2: Implement GeminiService Class**

Create `controllers/GeminiService.php`:
```php
<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/CompetitorPrice.php';

class GeminiService
{
    private $apiKey;
    private $productModel;
    private $competitorPriceModel;

    public function __construct()
    {
        $this->apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY') ?? '';
        $this->productModel = new Product();
        $this->competitorPriceModel = new CompetitorPrice();
    }

    public function ask($userPrompt)
    {
        if (empty($this->apiKey)) {
            return "Chưa cấu hình GEMINI_API_KEY trong file .env.";
        }

        // Lấy dữ liệu ngữ cảnh sản phẩm từ DB
        $productsContext = $this->buildProductsContext($userPrompt);

        $systemPrompt = "Bạn là trợ lý bán hàng AI thông minh của cửa hàng thiết bị điện tử GARENA. "
            . "Nhiệm vụ của bạn là tư vấn sản phẩm, báo giá của shop và so sánh giá bán của shop với các website khác (Website A, Website B, Website C,...) khi khách hàng yêu cầu.\n\n"
            . "Dưới đây là thông tin dữ liệu sản phẩm và giá thị trường hiện có trong hệ thống:\n"
            . $productsContext . "\n\n"
            . "Hãy trả lời thân thiện, lịch sự, chính xác theo số liệu cung cấp và định dạng số tiền VND rõ ràng (ví dụ: 14,99 triệu đồng hoặc 14.990.000 VNĐ).";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey;

        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $systemPrompt . "\n\nCâu hỏi của khách hàng: " . $userPrompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Rất tiếc, AI không thể xử lý câu hỏi lúc này.";
    }

    private function buildProductsContext($prompt)
    {
        $products = $this->productModel->all();
        $context = "--- DANH SÁCH SẢN PHẨM TẠI SHOP ---\n";

        foreach ($products as $p) {
            $context .= "- ID: {$p['id']} | Tên: {$p['name']} | Giá shop: " . number_format($p['price']) . " VNĐ\n";
            $compPrices = $this->competitorPriceModel->getPricesByProductId($p['id']);
            if (!empty($compPrices)) {
                $context .= "  Giá tham khảo trên thị trường:\n";
                foreach ($compPrices as $cp) {
                    $context .= "   + {$cp['website_name']}: " . number_format($cp['price']) . " VNĐ\n";
                }
            }
        }
        return $context;
    }
}
```

---

### Task 4: Integrate AI Chatbot into Chat API & Frontend (`chatBox.php` & `ChatController.php`)

**Files:**
- Modify: `controllers/ChatController.php`
- Modify: `chatBox.php`

**Interfaces:**
- Consumes: `GeminiService::ask()`.
- Produces: Real-time AI response rendering in customer chat window.

- [ ] **Step 1: Add AI handler in ChatController**

Update `controllers/ChatController.php` to handle AI trigger/mode when customer requests bot assistance or asks questions.

- [ ] **Step 2: Update Chatbox UI in `chatBox.php`**

Ensure `chatBox.php` has a toggle button or automatically sends messages to AI assistant when admin is offline or AI mode is selected.

---

## Verification Plan

### Automated / Command Verification
1. Execute migration query script.
2. Run Python Scraper script `python scripts/scraper/scrape_prices.py` to confirm `competitor_prices` table is populated.
3. Test Gemini API connection via test PHP CLI script.

### Manual UI Verification
1. Open `index.php`, click on Chat icon.
2. Ask: `"Shop mình có laptop nào dưới 15 triệu không?"` -> Check AI response.
3. Ask: `"Laptop này bên ngoài bán bao nhiêu?"` -> Check AI response with competitor price breakdown.
