<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/CompetitorPrice.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class GeminiService
{
    private $apiKey;
    private $productModel;
    private $competitorPriceModel;

    public function __construct()
    {
        $envFile = __DIR__ . '/../config/.env';
        if (file_exists($envFile)) {
            $dotenv = Dotenv::createImmutable(dirname($envFile));
            $dotenv->safeLoad();
        }

        $this->apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY') ?? '';
        $this->productModel = new Product();
        $this->competitorPriceModel = new CompetitorPrice();
    }

    public function ask($userPrompt)
    {
        // Nếu đã cấu hình API key Gemini thực tế (khác placeholder) thì gọi Gemini REST API
        if (!empty($this->apiKey) && $this->apiKey !== 'your_gemini_api_key_here' && strpos($this->apiKey, 'AIzaSy') === 0) {
            $apiResult = $this->callGeminiApi($userPrompt);
            if ($apiResult) {
                return $apiResult;
            }
        }

        // Bộ xử lý tư vấn bán hàng thông minh đa năng
        return $this->generateLocalAiResponse($userPrompt);
    }

    private function formatVndPrice($price)
    {
        $priceNum = (float)$price;
        $formatted = number_format($priceNum, 0, ',', '.') . " VNĐ";
        if ($priceNum >= 1000000) {
            $million = number_format($priceNum / 1000000, 2, ',', '');
            return "{$formatted} ({$million} triệu)";
        }
        return $formatted;
    }

    private function getRealProducts()
    {
        $all = $this->productModel->all();
        $realProducts = [];
        foreach ($all as $p) {
            $name = trim($p['name']);
            $lowerName = mb_strtolower($name, 'UTF-8');

            // Lọc loại bỏ dữ liệu test rác, chỉ giữ sản phẩm công nghệ thực tế
            if (
                strpos($lowerName, 'iphone') !== false ||
                strpos($lowerName, 'samsung') !== false ||
                strpos($lowerName, 'galaxy') !== false ||
                strpos($lowerName, 'dell') !== false ||
                strpos($lowerName, 'laptop') !== false ||
                strpos($lowerName, 'macbook') !== false ||
                strpos($lowerName, 'mac') !== false ||
                strpos($lowerName, 'apple') !== false ||
                strpos($lowerName, 'watch') !== false ||
                strpos($lowerName, 'imac') !== false
            ) {
                $realProducts[] = $p;
            }
        }

        return !empty($realProducts) ? array_values($realProducts) : $all;
    }

    private function callGeminiApi($userPrompt)
    {
        $productsContext = $this->buildProductsContext();

        $systemPrompt = "Bạn là Trợ lý AI tư vấn bán hàng của cửa hàng điện tử GARENA.\n"
            . "Nhiệm vụ: Trả lời câu hỏi khách hàng, tư vấn sản phẩm của shop và so sánh giá với các website khác khi khách hàng hỏi.\n\n"
            . "DỮ LIỆU SẢN PHẨM & GIÁ THỊ TRƯỜNG CỦA SHOP:\n"
            . $productsContext . "\n\n"
            . "YÊU CẦU TRẢ LỜI:\n"
            . "- Trả lời tự nhiên, thân thiện, chính xác dựa trên dữ liệu ở trên.\n"
            . "- Khi khách hỏi về cách sử dụng, tính năng, trải nghiệm (ví dụ: 'Đồng hồ này sài thế nào', 'Laptop này mượt không'): Trả lời hướng dẫn tính năng, trải nghiệm cụ thể chứ KHÔNG chỉ kê lại bảng giá.\n"
            . "- Nếu khách hỏi sản phẩm/thương hiệu mà shop không có (ví dụ Xiaomi Watch, Laptop Asus, Oppo): Trả lời lịch sự rằng shop chưa có sản phẩm đó, sau đó gợi ý các sản phẩm tương tự mà shop đang kinh doanh.\n"
            . "- Đơn vị tiền tệ hiển thị đầy đủ VNĐ (ví dụ: 14.990.000 VNĐ hoặc 14,99 triệu VNĐ).\n"
            . "- Khi so sánh giá đối thủ: xuống dòng rõ ràng từng Website đối thủ và giá tại shop.";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey;

        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $systemPrompt . "\n\nKhách hàng: " . $userPrompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            }
        }

        return null;
    }

    private function generateLocalAiResponse($userPrompt)
    {
        $lowerPrompt = mb_strtolower($userPrompt, 'UTF-8');
        $products = $this->getRealProducts();

        // 1. CHỦ ĐỀ: Hỏi chính sách chung (Giao hàng, Bảo hành, Trả góp, Đổi trả, Khuyến mãi)
        if (strpos($lowerPrompt, 'giao hàng') !== false || strpos($lowerPrompt, 'vận chuyển') !== false || strpos($lowerPrompt, 'ship') !== false) {
            return "Dạ GARENA hỗ trợ **giao hàng hỏa tốc toàn quốc**:\n\n"
                . "- **Nội thành**: Giao nhanh trong 2 giờ.\n\n"
                . "- **Toàn quốc**: Miễn phí vận chuyển cho đơn hàng từ 5 triệu đồng.\n\n"
                . "Bạn đang quan tâm sản phẩm nào để shop kiểm tra thời gian giao hàng cụ thể nhé!";
        }

        if (strpos($lowerPrompt, 'bảo hành') !== false || strpos($lowerPrompt, 'đổi trả') !== false) {
            return "Tất cả sản phẩm tại **GARENA** đều là hàng chính hãng 100%:\n\n"
                . "- **Bảo hành**: 12 - 24 tháng chính hãng theo tiêu chuẩn nhà sản xuất.\n\n"
                . "- **1 đổi 1**: Trong 30 ngày đầu nếu có lỗi phần cứng từ nhà sản xuất.\n\n"
                . "Bạn cần hỗ trợ bảo hành cho sản phẩm nào ạ?";
        }

        if (strpos($lowerPrompt, 'trả góp') !== false) {
            return "GARENA hỗ trợ mua **trả góp 0% lãi suất** linh hoạt:\n\n"
                . "- Trả góp qua thẻ tín dụng (Visa/MasterCard/JCB).\n\n"
                . "- Trả góp qua công ty tài chính (chỉ cần CCCD, duyệt nhanh 15 phút).\n\n"
                . "Bạn đang cần tư vấn mua trả góp dòng sản phẩm nào ạ?";
        }

        // 2. CHỦ ĐỀ: Hỏi CÁCH SỬ DỤNG / TÍNH NĂNG / TRẢI NGHIỆM ("sài thế nào", "dùng thế nào", "xài tốt không", "dùng ra sao", "kết nối thế nào")
        if (
            strpos($lowerPrompt, 'sài thế nào') !== false ||
            strpos($lowerPrompt, 'dùng thế nào') !== false ||
            strpos($lowerPrompt, 'sử dụng thế nào') !== false ||
            strpos($lowerPrompt, 'xài thế nào') !== false ||
            strpos($lowerPrompt, 'sài ra sao') !== false ||
            strpos($lowerPrompt, 'dùng ra sao') !== false ||
            strpos($lowerPrompt, 'xài tốt không') !== false ||
            strpos($lowerPrompt, 'dùng tốt không') !== false ||
            strpos($lowerPrompt, 'kết nối') !== false
        ) {
            if (strpos($lowerPrompt, 'đồng hồ') !== false || strpos($lowerPrompt, 'watch') !== false) {
                return "Đồng hồ thông minh **Apple Watch Ultra 2** tại GARENA cực kỳ dễ sử dụng và sở hữu nhiều tính năng cao cấp:\n\n"
                    . "- **Kết nối dễ dàng**: Ghép đôi nhanh chóng với iPhone qua Bluetooth và ứng dụng Apple Watch.\n\n"
                    . "- **Theo dõi sức khỏe**: Đo nhịp tim liên tục, đo nồng độ oxy trong máu (SpO2), theo dõi giấc ngủ và cảnh báo nhịp tim bất thường.\n\n"
                    . "- **Tính năng thể thao & eSIM**: Hỗ trợ GPS tần số kép chính xác, kháng nước đến 100m, hỗ trợ nghe gọi độc lập không cần mang theo điện thoại.\n\n"
                    . "- **Thời lượng pin**: Pin hoạt động liên tục 36 - 72 giờ.\n\n"
                    . "Bạn cần shop hướng dẫn cụ thể về tính năng nào nữa không ạ?";
            }

            if (strpos($lowerPrompt, 'laptop') !== false || strpos($lowerPrompt, 'máy tính') !== false || strpos($lowerPrompt, 'mac') !== false) {
                return "Các dòng Laptop & Máy tính tại GARENA rất dễ sử dụng và đáp ứng tốt mọi nhu cầu:\n\n"
                    . "- **Vận hành**: Cài sẵn Windows/macOS bản quyền, khởi động siêu nhanh trong vài giây.\n\n"
                    . "- **Hiệu năng**: Đáp ứng mượt mà công việc văn phòng, đồ họa, lập trình và giải trí game đỉnh cao.\n\n"
                    . "- **Kết nối**: Hỗ trợ Wi-Fi 6, Bluetooth, USB-C, HDMI kết nối màn hình ngoài tiện lợi.\n\n"
                    . "Bạn cần tư vấn chi tiết cấu hình dòng máy nào ạ?";
            }

            return "Các thiết bị công nghệ tại GARENA đều là hàng chính hãng 100%, tích hợp giao diện tiếng Việt thân thiện và cực kỳ dễ sử dụng. Nhân viên kỹ thuật của shop sẽ hỗ trợ cài đặt và hướng dẫn chi tiết khi bạn nhận máy nhé!";
        }

        // 3. CHỦ ĐỀ: Kiểm tra thương hiệu / sản phẩm cụ thể mà SHOP KHÔNG CÓ HÀNG
        $knownExternalBrands = [
            'xiaomi' => 'Xiaomi',
            'redmi' => 'Xiaomi Redmi',
            'oppo' => 'OPPO',
            'vivo' => 'Vivo',
            'realme' => 'Realme',
            'asus' => 'Asus',
            'lenovo' => 'Lenovo',
            'thinkpad' => 'Lenovo ThinkPad',
            'hp' => 'HP',
            'acer' => 'Acer',
            'msi' => 'MSI',
            'garmin' => 'Garmin',
            'huawei' => 'Huawei',
            'honor' => 'Honor',
            'sony' => 'Sony'
        ];

        foreach ($knownExternalBrands as $brandKey => $brandName) {
            if (strpos($lowerPrompt, $brandKey) !== false) {
                // Kiểm tra xem DB shop có sản phẩm thương hiệu này không
                $hasBrandInDb = false;
                foreach ($products as $p) {
                    if (strpos(mb_strtolower($p['name'], 'UTF-8'), $brandKey) !== false) {
                        $hasBrandInDb = true;
                        break;
                    }
                }

                // Nếu shop KHÔNG CÓ sản phẩm thương hiệu này
                if (!$hasBrandInDb) {
                    $isWatch = (strpos($lowerPrompt, 'đồng hồ') !== false || strpos($lowerPrompt, 'watch') !== false);
                    $isLaptop = (strpos($lowerPrompt, 'laptop') !== false || strpos($lowerPrompt, 'máy tính') !== false);

                    if ($isWatch) {
                        $watches = array_filter($products, function ($p) {
                            return strpos(mb_strtolower($p['name'], 'UTF-8'), 'watch') !== false;
                        });
                        $reply = "Dạ rất tiếc, hiện tại cửa hàng **GARENA** chưa kinh doanh các dòng đồng hồ thương hiệu **{$brandName}**.\n\n";
                        if (!empty($watches)) {
                            $reply .= "Tuy nhiên, shop hiện đang có sẵn các mẫu Đồng hồ thông minh cao cấp chính hãng dưới đây để bạn tham khảo:\n\n";
                            foreach ($watches as $w) {
                                $reply .= "- **{$w['name']}**: " . $this->formatVndPrice($w['price']) . "\n\n";
                            }
                        }
                        $reply .= "Bạn có muốn xem chi tiết dòng đồng hồ nào trên đây không ạ?";
                        return $reply;
                    }

                    if ($isLaptop) {
                        $laptops = array_filter($products, function ($p) {
                            $n = mb_strtolower($p['name'], 'UTF-8');
                            return strpos($n, 'laptop') !== false || strpos($n, 'mac') !== false || strpos($n, 'dell') !== false;
                        });
                        $reply = "Dạ rất tiếc, hiện tại **GARENA** chưa phân phối sản phẩm Laptop thuộc thương hiệu **{$brandName}**.\n\n";
                        if (!empty($laptops)) {
                            $reply .= "Tuy nhiên, shop đang sẵn hàng các dòng Laptop & Máy tính cao cấp cấu hình mạnh mẽ dưới đây:\n\n";
                            foreach (array_slice($laptops, 0, 3) as $l) {
                                $reply .= "- **{$l['name']}**: " . $this->formatVndPrice($l['price']) . "\n\n";
                            }
                        }
                        $reply .= "Bạn xem qua các gợi ý trên có phù hợp với nhu cầu không nhé!";
                        return $reply;
                    }

                    // Mặc định điện thoại / sản phẩm khác
                    $phones = array_filter($products, function ($p) {
                        $n = mb_strtolower($p['name'], 'UTF-8');
                        return strpos($n, 'iphone') !== false || strpos($n, 'samsung') !== false;
                    });
                    $reply = "Dạ rất tiếc, hiện tại **GARENA** chưa có sản phẩm thương hiệu **{$brandName}**.\n\n";
                    if (!empty($phones)) {
                        $reply .= "Shop hiện đang kinh doanh chính hãng các dòng điện thoại cao cấp sẵn hàng dưới đây:\n\n";
                        foreach ($phones as $ph) {
                            $reply .= "- **{$ph['name']}**: " . $this->formatVndPrice($ph['price']) . "\n\n";
                        }
                    }
                    $reply .= "Bạn muốn tư vấn thêm về sản phẩm nào ạ?";
                    return $reply;
                }
            }
        }

        // 4. CHỦ ĐỀ: So sánh giá đối thủ (Thế Giới Di Động, FPT Shop, CellphoneS, bên ngoài, web khác)
        if (
            strpos($lowerPrompt, 'bên ngoài') !== false ||
            strpos($lowerPrompt, 'web khác') !== false ||
            strpos($lowerPrompt, 'so sánh') !== false ||
            strpos($lowerPrompt, 'đối thủ') !== false ||
            strpos($lowerPrompt, 'tgdd') !== false ||
            strpos($lowerPrompt, 'fpt') !== false ||
            strpos($lowerPrompt, 'cellphones') !== false
        ) {
            $targetProduct = null;

            // Lọc chính xác tên sản phẩm trong prompt
            foreach ($products as $p) {
                if (mb_strpos($lowerPrompt, mb_strtolower($p['name'], 'UTF-8'), 0, 'UTF-8') !== false) {
                    $targetProduct = $p;
                    break;
                }
            }

            // Phân loại theo thương hiệu / nhóm
            if (!$targetProduct) {
                foreach ($products as $p) {
                    $pLower = mb_strtolower($p['name'], 'UTF-8');
                    if ((strpos($lowerPrompt, 'điện thoại') !== false || strpos($lowerPrompt, 'iphone') !== false) && strpos($pLower, 'iphone') !== false) {
                        $targetProduct = $p;
                        break;
                    }
                    if ((strpos($lowerPrompt, 'samsung') !== false || strpos($lowerPrompt, 'galaxy') !== false) && strpos($pLower, 'samsung') !== false) {
                        $targetProduct = $p;
                        break;
                    }
                    if ((strpos($lowerPrompt, 'laptop') !== false || strpos($lowerPrompt, 'dell') !== false) && strpos($pLower, 'dell') !== false) {
                        $targetProduct = $p;
                        break;
                    }
                    if (strpos($lowerPrompt, 'mac') !== false && strpos($pLower, 'mac') !== false) {
                        $targetProduct = $p;
                        break;
                    }
                }
            }

            if (!$targetProduct && !empty($products)) {
                $targetProduct = $products[0];
            }

            if ($targetProduct) {
                $pId = $targetProduct['id'];
                $compPrices = $this->competitorPriceModel->getPricesByProductId($pId);

                $shopPriceStr = $this->formatVndPrice($targetProduct['price']);
                $reply = "Dưới đây là bảng so sánh giá thị trường cho sản phẩm **{$targetProduct['name']}**:\n\n";

                foreach ($compPrices as $cp) {
                    $cPriceStr = $this->formatVndPrice($cp['price']);
                    $reply .= "- **{$cp['website_name']}**: {$cPriceStr}\n\n";
                }

                $reply .= "**Giá niêm yết tại GARENA:** {$shopPriceStr}\n\n*Shop cam kết mang lại mức giá canh tranh tốt nhất cho bạn!*";
                return $reply;
            }
        }

        // 5. CHỦ ĐỀ: Ngân sách / Tầm giá (15tr, 30tr, 35 triệu, 20 củ,...)
        if (preg_match('/(\d+(?:\.\d+)?)\s*(tr|triệu|trieu|trđ|củ|k|ngàn|nghìn)/u', $lowerPrompt, $matches)) {
            $budgetNum = (float)$matches[1];
            // Xử lý đơn vị k / ngàn
            if (in_array($matches[2], ['k', 'ngàn', 'nghìn'])) {
                $budgetVnd = $budgetNum * 1000;
            } else {
                $budgetVnd = $budgetNum * 1000000;
            }

            $isLaptopCategory = (strpos($lowerPrompt, 'máy tính') !== false || strpos($lowerPrompt, 'laptop') !== false || strpos($lowerPrompt, 'macbook') !== false || strpos($lowerPrompt, 'mac') !== false || strpos($lowerPrompt, 'dell') !== false);
            $isPhoneCategory = (strpos($lowerPrompt, 'điện thoại') !== false || strpos($lowerPrompt, 'phone') !== false || strpos($lowerPrompt, 'iphone') !== false || strpos($lowerPrompt, 'samsung') !== false);

            // Dải giá linh hoạt (0.45x đến 1.35x ngân sách)
            $minPrice = $budgetVnd * 0.45;
            $maxPrice = $budgetVnd * 1.35;

            $filtered = array_filter($products, function ($item) use ($minPrice, $maxPrice, $isLaptopCategory, $isPhoneCategory) {
                $itemPrice = (float)$item['price'];
                if ($itemPrice < $minPrice || $itemPrice > $maxPrice) {
                    return false;
                }
                $itemNameLower = mb_strtolower($item['name'], 'UTF-8');
                if ($isLaptopCategory) {
                    return (strpos($itemNameLower, 'laptop') !== false || strpos($itemNameLower, 'mac') !== false || strpos($itemNameLower, 'dell') !== false || strpos($itemNameLower, 'imac') !== false);
                }
                if ($isPhoneCategory) {
                    return (strpos($itemNameLower, 'iphone') !== false || strpos($itemNameLower, 'samsung') !== false || strpos($itemNameLower, 'galaxy') !== false);
                }
                return true;
            });

            // Sắp xếp các mẫu có giá sát với ngân sách nhất lên trên
            usort($filtered, function ($a, $b) use ($budgetVnd) {
                return abs((float)$a['price'] - $budgetVnd) <=> abs((float)$b['price'] - $budgetVnd);
            });

            $count = count($filtered);
            if ($count > 0) {
                $categoryLabel = $isLaptopCategory ? "Máy tính / Laptop" : ($isPhoneCategory ? "Điện thoại" : "sản phẩm");
                $reply = "Dựa trên ngân sách tầm **{$budgetNum} triệu**, shop xin tư vấn các mẫu {$categoryLabel} phù hợp nhất sau đây:\n\n";
                $i = 1;
                foreach (array_slice($filtered, 0, 5) as $item) {
                    $priceStr = $this->formatVndPrice($item['price']);
                    $reply .= "{$i}. **{$item['name']}** - Giá: {$priceStr}\n\n";
                    $i++;
                }
                $reply .= "Bạn muốn xem chi tiết hoặc so sánh giá thị trường dòng nào trên đây?";
                return trim($reply);
            } else {
                return "Hiện tại shop đang cập nhật thêm hàng cho phân khúc tầm " . $budgetNum . " triệu. Bạn có thể xem thêm các sản phẩm khác hoặc liên hệ hotline để được hỗ trợ nhé!";
            }
        }

        // 6. CHỦ ĐỀ: Điện thoại ("điện thoại", "iphone", "samsung", "galaxy")
        if (strpos($lowerPrompt, 'điện thoại') !== false || strpos($lowerPrompt, 'phone') !== false || strpos($lowerPrompt, 'iphone') !== false || strpos($lowerPrompt, 'samsung') !== false) {
            $phones = array_filter($products, function ($p) {
                $n = mb_strtolower($p['name'], 'UTF-8');
                return strpos($n, 'iphone') !== false || strpos($n, 'samsung') !== false || strpos($n, 'galaxy') !== false;
            });

            if (!empty($phones)) {
                $reply = "Chào bạn! Cửa hàng GARENA đang phân phối các dòng điện thoại cao cấp chính hãng:\n\n";
                foreach ($phones as $p) {
                    $priceStr = $this->formatVndPrice($p['price']);
                    $reply .= "- **{$p['name']}**: {$priceStr}\n\n";
                }
                $reply .= "Bạn đang quan tâm dòng điện thoại nào hoặc cần so sánh giá với các đại lý khác?";
                return $reply;
            }
        }

        // 7. CHỦ ĐỀ: Laptop / Máy tính ("laptop", "macbook", "máy tính", "imac", "mac mini", "dell")
        if (strpos($lowerPrompt, 'laptop') !== false || strpos($lowerPrompt, 'macbook') !== false || strpos($lowerPrompt, 'máy tính') !== false || strpos($lowerPrompt, 'mac') !== false || strpos($lowerPrompt, 'dell') !== false) {
            $laptops = array_filter($products, function ($p) {
                $n = mb_strtolower($p['name'], 'UTF-8');
                return strpos($n, 'laptop') !== false || strpos($n, 'macbook') !== false || strpos($n, 'mac') !== false || strpos($n, 'imac') !== false || strpos($n, 'dell') !== false;
            });

            if (!empty($laptops)) {
                $reply = "Dưới đây là các dòng Laptop & Máy tính để bàn chính hãng tại shop:\n\n";
                foreach ($laptops as $p) {
                    $priceStr = $this->formatVndPrice($p['price']);
                    $reply .= "- **{$p['name']}**: {$priceStr}\n\n";
                }
                $reply .= "Bạn cần tư vấn chi tiết cấu hình hay so sánh giá bán của dòng máy nào?";
                return $reply;
            }
        }

        // 8. CHỦ ĐỀ: Đồng hồ / Phụ kiện ("đồng hồ", "watch", "apple watch")
        if (strpos($lowerPrompt, 'đồng hồ') !== false || strpos($lowerPrompt, 'watch') !== false) {
            $watches = array_filter($products, function ($p) {
                $n = mb_strtolower($p['name'], 'UTF-8');
                return strpos($n, 'watch') !== false || strpos($n, 'đồng hồ') !== false;
            });

            if (!empty($watches)) {
                $reply = "Các dòng Đồng hồ thông minh chính hãng tại GARENA:\n\n";
                foreach ($watches as $p) {
                    $priceStr = $this->formatVndPrice($p['price']);
                    $reply .= "- **{$p['name']}**: {$priceStr}\n\n";
                }
                $reply .= "Bạn cần tư vấn thêm về dòng đồng hồ nào ạ?";
                return $reply;
            }
        }

        // 9. TRẢ LỜI TỔNG QUÁT TẤT CẢ CÁC CÂU HỎI KHÁC
        $sampleProducts = array_slice($products, 0, 5);
        $reply = "Chào bạn! Tôi là Trợ lý AI bán hàng của GARENA. Shop hiện đang có các dòng sản phẩm nổi bật:\n\n";
        foreach ($sampleProducts as $p) {
            $priceStr = $this->formatVndPrice($p['price']);
            $reply .= "- **{$p['name']}**: {$priceStr}\n\n";
        }
        $reply .= "Bạn có thể hỏi tôi bất kỳ thông tin nào:\n"
            . "• *Tư vấn theo ngân sách (ví dụ: 'Tầm 30tr mua máy tính gì?')*\n"
            . "• *So sánh giá các website khác (ví dụ: 'Laptop Dell bên ngoài bán bao nhiêu?')*\n"
            . "• *Hỏi cách sử dụng (ví dụ: 'Đồng hồ này sài thế nào?')*\n"
            . "• *Hỏi chính sách (ví dụ: 'Shop có trả góp / giao hàng không?')*";
        return $reply;
    }

    private function buildProductsContext()
    {
        $products = $this->getRealProducts();
        $context = "";

        foreach ($products as $p) {
            $priceStr = $this->formatVndPrice($p['price']);
            $context .= "Sản phẩm: {$p['name']} | Giá Shop: {$priceStr}\n";
            $compPrices = $this->competitorPriceModel->getPricesByProductId($p['id']);
            if (!empty($compPrices)) {
                $context .= "  Giá các website khác:\n";
                foreach ($compPrices as $cp) {
                    $cPriceStr = $this->formatVndPrice($cp['price']);
                    $context .= "   - {$cp['website_name']}: {$cPriceStr}\n";
                }
            }
            $context .= "\n";
        }
        return $context;
    }
}
