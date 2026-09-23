-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 23, 2026 lúc 09:55 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `electronic_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `password_hash`, `email`, `role`, `created_at`, `isDeleted`) VALUES
(1, 'Vĩnh', '123456', 'vinh092004@gmail.com', 'admin', '2025-07-18 07:09:36', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ai_chat_logs`
--

CREATE TABLE `ai_chat_logs` (
  `id` int(11) NOT NULL,
  `user_query` text DEFAULT NULL,
  `ai_response` text DEFAULT NULL,
  `rating` tinyint(4) DEFAULT 0,
  `is_resolved` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ai_chat_logs`
--

INSERT INTO `ai_chat_logs` (`id`, `user_query`, `ai_response`, `rating`, `is_resolved`, `created_at`) VALUES
(1, 'Địa chỉ cửa hàng GARENA ở đâu?', 'Cửa hàng GARENA có trụ sở chính tại **123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh**.\n\n- Giờ mở cửa: **8:00 - 21:30** (Tất cả các ngày trong tuần, kể cả Thứ 7 và Chủ Nhật).\n- Hotline hỗ trợ: **1900 6868**.', 0, 1, '2026-09-21 20:46:51'),
(2, 'Địa chỉ cửa hàng GARENA ở đâu?', 'Cửa hàng GARENA có trụ sở chính tại **123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh**.\n\n- Giờ mở cửa: **8:00 - 21:30** (Tất cả các ngày trong tuần, kể cả Thứ 7 và Chủ Nhật).\n- Hotline hỗ trợ: **1900 6868**.', 0, 1, '2026-09-21 20:47:01'),
(3, 'Em là sinh viên có được giảm giá mua laptop không?', 'Dạ GARENA có chương trình **ƯU ĐÃI ĐẶC BIỆT CHO HỌC SINH - SINH VIÊN**:\n\n- **Giảm ngay 500.000 VNĐ** cho tất cả các dòng Laptop & MacBook khi xuất trình thẻ HSSV chính chủ.\n- **Tặng thêm balo cao cấp** và voucher vệ sinh máy miễn phí trọn đời!', 0, 1, '2026-09-21 20:47:01'),
(4, 'ƯU đãi cho sinh viên', 'Dạ GARENA có chương trình **ƯU ĐÃI ĐẶC BIỆT CHO HỌC SINH - SINH VIÊN**:\n\n- **Giảm ngay 500.000 VNĐ** cho tất cả các dòng Laptop & MacBook khi xuất trình thẻ HSSV chính chủ.\n- **Tặng thêm balo cao cấp** và voucher vệ sinh máy miễn phí trọn đời!', 0, 1, '2026-09-21 20:49:17'),
(5, 'Máy ở shop chơi gem mượt không', 'Chào bạn! Tôi là Trợ lý AI bán hàng của GARENA. Shop hiện đang có các dòng sản phẩm sẵn hàng:\n\n📦 **LAPTOP**:\n- **MacBook Air 15 inch M2 2023 8CPU 10GPU **: 37.890.000 VNĐ (37,89 triệu)\n- **MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB **: 93.790.000 VNĐ (93,79 triệu)\n- **Mac mini M4 2024 10CPU 10GPU 16GB 256GB**: 14.990.000 VNĐ (14,99 triệu)\n- **Laptop Dell Gaming G15 5530 i7 13650HX**: 35.290.000 VNĐ (35,29 triệu)\n\n📦 **MÀN HÌNH**:\n- **iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB**: 39.990.000 VNĐ (39,99 triệu)\n\n📦 **TAI NGHE**:\n- **Tai nghe chống ồn không dây Sony 1000X The Collexion**: 16.990.000 VNĐ (16,99 triệu)\n\n📦 **ĐIỆN THOẠI**:\n- **Điện thoại iPhone 18 Pro 2TB**: 77.990.000 VNĐ (77,99 triệu)\n- **iPhone 16 Pro Max 256GB | Chính hãng VN/A**: 34.990.000 VNĐ (34,99 triệu)\n- **Samsung Galaxy S25 Ultra 12GB 256GB**: 33.380.000 VNĐ (33,38 triệu)\n\n📦 **ĐỒNG HỒ**:\n- **Apple Watch Ultra 2 2024 49mm 4G Viền Titan**: 25.990.000 VNĐ (25,99 triệu)\n\nBạn có thể hỏi tôi bất kỳ thông tin nào:\n• *Tư vấn theo ngân sách (ví dụ: \'Tầm 30tr mua máy tính gì?\')*\n• *So sánh giá các website khác (ví dụ: \'Laptop Dell bên ngoài bán bao nhiêu?\')*\n• *Hỏi cách sử dụng (ví dụ: \'Đồng hồ này sài thế nào?\')*\n• *Hỏi chính sách (ví dụ: \'Shop có trả góp / giao hàng không?\')*', 0, 0, '2026-09-21 20:52:17'),
(6, 'Chào bạn', 'Chào bạn! Tôi là Trợ lý AI bán hàng của GARENA. Shop hiện đang có các dòng sản phẩm sẵn hàng:\n\n📦 **LAPTOP**:\n- **MacBook Air 15 inch M2 2023 8CPU 10GPU **: 37.890.000 VNĐ (37,89 triệu)\n- **MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB **: 93.790.000 VNĐ (93,79 triệu)\n- **Mac mini M4 2024 10CPU 10GPU 16GB 256GB**: 14.990.000 VNĐ (14,99 triệu)\n- **Laptop Dell Gaming G15 5530 i7 13650HX**: 35.290.000 VNĐ (35,29 triệu)\n\n📦 **MÀN HÌNH**:\n- **iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB**: 39.990.000 VNĐ (39,99 triệu)\n\n📦 **TAI NGHE**:\n- **Tai nghe chống ồn không dây Sony 1000X The Collexion**: 16.990.000 VNĐ (16,99 triệu)\n\n📦 **ĐIỆN THOẠI**:\n- **Điện thoại iPhone 18 Pro 2TB**: 77.990.000 VNĐ (77,99 triệu)\n- **iPhone 16 Pro Max 256GB | Chính hãng VN/A**: 34.990.000 VNĐ (34,99 triệu)\n- **Samsung Galaxy S25 Ultra 12GB 256GB**: 33.380.000 VNĐ (33,38 triệu)\n\n📦 **ĐỒNG HỒ**:\n- **Apple Watch Ultra 2 2024 49mm 4G Viền Titan**: 25.990.000 VNĐ (25,99 triệu)\n\nBạn có thể hỏi tôi bất kỳ thông tin nào:\n• *Tư vấn theo ngân sách (ví dụ: \'Tầm 30tr mua máy tính gì?\')*\n• *So sánh giá các website khác (ví dụ: \'Laptop Dell bên ngoài bán bao nhiêu?\')*\n• *Hỏi cách sử dụng (ví dụ: \'Đồng hồ này sài thế nào?\')*\n• *Hỏi chính sách (ví dụ: \'Shop có trả góp / giao hàng không?\')*', 0, 0, '2026-09-23 19:45:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ai_knowledge_base`
--

CREATE TABLE `ai_knowledge_base` (
  `id` int(11) NOT NULL,
  `keywords` text DEFAULT NULL,
  `intent_category` varchar(100) DEFAULT NULL,
  `question_pattern` text DEFAULT NULL,
  `answer_template` text DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `isDeleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ai_knowledge_base`
--

INSERT INTO `ai_knowledge_base` (`id`, `keywords`, `intent_category`, `question_pattern`, `answer_template`, `priority`, `status`, `isDeleted`, `created_at`) VALUES
(1, 'địa chỉ, cửa hàng, ở đâu, vị trí, shop ở đâu, tới shop', 'Địa chỉ cửa hàng', 'Địa chỉ cửa hàng GARENA ở đâu?', 'Cửa hàng GARENA có trụ sở chính tại **123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh**.\n\n- Giờ mở cửa: **8:00 - 21:30** (Tất cả các ngày trong tuần, kể cả Thứ 7 và Chủ Nhật).\n- Hotline hỗ trợ: **1900 6868**.', 10, 1, 0, '2026-09-21 20:44:19'),
(2, 'bảo hành, 1 đổi 1, thời gian bảo hành, tem bảo hành, đổi trả', 'Bảo hành & Đổi trả', 'Chính sách bảo hành tại GARENA như thế nào?', 'Tất cả sản phẩm bán ra tại **GARENA** đều là hàng chính hãng 100%:\n\n- **Bảo hành**: 12 - 24 tháng theo tiêu chuẩn nhà sản xuất.\n- **Chính sách 1 đổi 1**: Áp dụng trong 30 ngày đầu tiên nếu máy phát sinh lỗi phần cứng từ NSX.\n- **Hỗ trợ**: Tiếp nhận bảo hành tại tất cả chi nhánh hoặc gửi chuyển phát nhanh miễn phí.', 10, 1, 0, '2026-09-21 20:44:19'),
(3, 'giao hàng, ship, vận chuyển, hỏa tốc, phí ship, ship toàn quốc', 'Giao hàng & Vận chuyển', 'GARENA có giao hàng tận nơi không?', 'GARENA hỗ trợ **giao hàng hỏa tốc toàn quốc**:\n\n- **Nội thành TP.HCM**: Giao nhanh trong 2 giờ.\n- **Toàn quốc**: Miễn phí vận chuyển cho đơn hàng từ 5.000.000 VNĐ.\n- **Kiểm tra hàng**: Khách hàng được đồng kiểm và thử máy trước khi thanh toán.', 10, 1, 0, '2026-09-21 20:44:19'),
(4, 'trả góp, 0%, lãi suất, cccd, thẻ tín dụng, thủ tục trả góp', 'Trả góp', 'Shop có bán trả góp 0% không?', 'GARENA hỗ trợ mua **trả góp 0% lãi suất** vô cùng linh hoạt:\n\n- **Qua Thẻ Tín Dụng**: Hỗ trợ 28 ngân hàng, duyệt online 3 phút.\n- **Qua Công Ty Tài Chính**: Chỉ cần CCCD gắn chip, duyệt nhanh 15 phút không cần chứng minh thu nhập.', 10, 1, 0, '2026-09-21 20:44:19'),
(5, 'khuyến mãi, ưu đãi, giảm giá, voucher, quà tặng', 'Khuyến mãi', 'Shop đang có chương trình khuyến mãi gì?', 'Các chương trình ưu đãi hấp dẫn đang diễn ra tại GARENA:\n\n- **Giảm ngay đến 20%** cho các dòng MacBook & iPhone mới nhất.\n- **Tặng combo phụ kiện** trị giá 500.000 VNĐ khi mua Laptop Gaming.\n- **Voucher 200.000 VNĐ** cho khách hàng đăng ký tài khoản mới.', 10, 1, 0, '2026-09-21 20:44:19'),
(6, 'liên hệ, hotline, tổng đài, tư vấn viên, gặp nhân viên', 'Liên hệ', 'Làm sao để liên hệ gặp nhân viên tư vấn?', 'Bạn có thể liên hệ trực tiếp với đội ngũ hỗ trợ của GARENA qua các kênh:\n\n- **Hotline tư vấn**: 1900 6868 (8:00 - 21:30)\n- **Zalo Chăm sóc khách hàng**: 0988 123 456\n- **Email**: hotro@garena-store.vn', 10, 1, 0, '2026-09-21 20:44:19'),
(7, 'học sinh, sinh viên, hssv, ưu đãi sinh viên, giảm giá sinh viên', 'Ưu đãi Sinh Viên', 'Shop có giảm giá cho học sinh sinh viên không?', 'Dạ GARENA có chương trình **ƯU ĐÃI ĐẶC BIỆT CHO HỌC SINH - SINH VIÊN**:\n\n- **Giảm ngay 500.000 VNĐ** cho tất cả các dòng Laptop & MacBook khi xuất trình thẻ HSSV chính chủ.\n- **Tặng thêm balo cao cấp** và voucher vệ sinh máy miễn phí trọn đời!', 15, 1, 0, '2026-09-21 20:47:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` varchar(50) DEFAULT 'slider_main'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `image`, `status`, `isDeleted`, `title`, `link`, `position`) VALUES
(1, './uploads/banners/banner_1789931717_5757.webp', 1, 1, 'Khuyến mãi', '', 'slider_main'),
(2, './uploads/banners/banner_1789931803_2048.webp', 1, 0, 'Khuyến mãi', '', 'middle_home'),
(3, './uploads/banners/banner_1789931941_3622.webp', 1, 0, 'kk', '', 'slider_main'),
(4, './uploads/banners/banner_1789931958_8599.webp', 1, 1, 'kk', '', 'slider_main'),
(5, './uploads/banners/banner_1789932087_5265.webp', 1, 0, 'kk', '', 'slider_main'),
(6, './uploads/banners/banner_1789932097_6343.png', 1, 0, 'kk', '', 'slider_main'),
(7, './uploads/banners/banner_1789932107_9841.png', 1, 0, 'kk', '', 'slider_main'),
(8, './uploads/banners/banner_1789937957_1216.webp', 0, 0, 'kk', '', 'slider_main');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `email`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, 'HOÀNG VĂN THỤ', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'hoangvanthu1234@gmail.com', 0, '2025-07-19 07:19:46', '2025-07-19 14:19:46'),
(2, 'NGUYỄN VĂN CỪ', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'nguyenvancu@gmail.com', 0, '2025-07-20 13:39:03', '2025-07-20 20:39:03'),
(3, 'BÙI THỊ XUÂN', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'vinh092004@gmail.com', 0, '2025-08-09 15:29:05', '2025-08-09 22:29:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `created_at`, `isDeleted`, `status`) VALUES
(1, 'Laptop', 'https://res.cloudinary.com/direvsslz/image/upload/v1754847890/products/main/kgzdzktmrpnwqg4dt4et.webp', '2025-06-22 02:55:58', 0, 0),
(3, 'Tai nghe', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766513/products/main/bdrsuzg7o5r73xsloznv.png', '2025-07-17 15:35:14', 1, 1),
(6, 'Màn hình', 'https://res.cloudinary.com/direvsslz/image/upload/v1754829759/products/main/xkseimkyevdivj3bgh6t.webp', '2025-08-10 12:42:40', 0, 0),
(7, 'Đồng hồ', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830309/products/main/hxsq5y2dzanq3bggurxe.webp', '2025-08-10 12:51:49', 0, 0),
(8, 'Tai nghe', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830485/products/main/tyuzwsgpzdg7cuo5z3xp.jpg', '2025-08-10 12:54:46', 0, 0),
(9, 'Điện thoại', 'https://res.cloudinary.com/direvsslz/image/upload/v1754832618/products/main/rjsz8z4wkzebegoxekik.webp', '2025-08-10 13:30:19', 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_role` varchar(50) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `sender_id`, `sender_role`, `message`, `created_at`, `isDeleted`) VALUES
(122, 6, NULL, 'user', 'Hi shop ạ', '2026-09-21 01:31:55', 0),
(123, 6, NULL, 'user', 'Hi ạ', '2026-09-21 01:35:20', 0),
(124, 6, NULL, 'user', 'shop ơi', '2026-09-21 01:35:26', 0),
(125, 6, 1, 'admin', 'sao vậy bạn', '2026-09-21 01:36:02', 0),
(126, 6, 1, 'admin', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 01:49:13', 0),
(127, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:23', 0),
(128, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:24', 0),
(129, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:33', 0),
(130, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(131, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(132, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(133, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(134, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(135, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(136, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:34', 0),
(137, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:35', 0),
(138, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:36', 0),
(139, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ', '2026-09-21 02:03:37', 0),
(140, 6, NULL, 'user', 'Bạn có câu hỏi gì muốn hỏi shop ạ? Bạn cứ nói shop sẽ tư vấn cho bạn ạ 123456', '2026-09-21 02:03:57', 0),
(141, 6, NULL, 'user', 'Sao ạ', '2026-09-21 02:05:44', 0),
(142, 6, 1, 'admin', 'Không sao á bạn', '2026-09-21 02:05:56', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `competitor_prices`
--

CREATE TABLE `competitor_prices` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `website_name` varchar(100) NOT NULL,
  `competitor_product_name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `competitor_url` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `competitor_prices`
--

INSERT INTO `competitor_prices` (`id`, `product_id`, `website_name`, `competitor_product_name`, `price`, `competitor_url`, `updated_at`) VALUES
(285, 26, 'Thế Giới Di Động', 'Samsung', 29990000.00, 'https://www.thegioididong.com/tim-kiem?key=Samsung+Galaxy+S25+Ultra+12GB+256GB', '2026-09-24 02:49:36'),
(286, 27, 'Thế Giới Di Động', 'iPhone 18 Pro 256GB', 38990000.00, 'https://www.thegioididong.com/tim-kiem?key=iPhone+16+Pro+Max+256GB+%7C+Ch%C3%ADnh+h%C3%A3ng+VN%2FA', '2026-09-24 02:49:39'),
(287, 30, 'Thế Giới Di Động', 'HP', 34635636.00, 'https://www.thegioididong.com/tim-kiem?key=Laptop+Dell+Gaming+G15+5530+i7+13650HX', '2026-09-24 02:49:43'),
(288, 31, 'Thế Giới Di Động', 'Xiaomi', 22572000.00, 'https://www.thegioididong.com/tim-kiem?key=Apple+Watch+Ultra+2+2024+49mm+4G+Vi%E1%BB%81n+Titan', '2026-09-24 02:49:49'),
(289, 32, 'Thế Giới Di Động', 'Apple', 39990000.00, 'https://www.thegioididong.com/tim-kiem?key=iMac+M4+2024+24+inch+10CPU+10GPU+16GB+256GB', '2026-09-24 02:49:53'),
(290, 34, 'Thế Giới Di Động', 'Mac mini M4 16GB/256GB', 20990000.00, 'https://www.thegioididong.com/tim-kiem?key=Mac+mini+M4+2024+10CPU+10GPU+16GB+256GB', '2026-09-24 02:49:57'),
(291, 36, 'Thế Giới Di Động', 'MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB', 95670000.00, 'https://www.thegioididong.com', '2026-09-24 02:50:02'),
(292, 36, 'FPT Shop', 'MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB', 94730000.00, 'https://fptshop.com.vn', '2026-09-24 02:50:02'),
(293, 36, 'CellphoneS', 'MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB', 92850000.00, 'https://cellphones.com.vn', '2026-09-24 02:50:02'),
(294, 37, 'Thế Giới Di Động', 'MacBook Air 15 inch M5 24GB/1TB', 54990000.00, 'https://www.thegioididong.com/tim-kiem?key=MacBook+Air+15+inch+M2+2023+8CPU+10GPU', '2026-09-24 02:50:06'),
(295, 39, 'Thế Giới Di Động', 'Tai nghe TWS JBL Live Beam 4', 4990000.00, 'https://www.thegioididong.com/tim-kiem?key=Tai+nghe+ch%E1%BB%91ng+%E1%BB%93n+kh%C3%B4ng+d%C3%A2y+Sony+1000X+The+Collexion', '2026-09-24 02:50:09'),
(296, 40, 'Thế Giới Di Động', 'Samsung', 80990000.00, 'https://www.thegioididong.com/tim-kiem?key=%C4%90i%E1%BB%87n+tho%E1%BA%A1i+iPhone+18+Pro+2TB', '2026-09-24 02:50:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `branch_id` int(11) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `is_first_login` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `email`, `position`, `address`, `isDeleted`, `created_at`, `branch_id`, `password_hash`, `is_first_login`) VALUES
(1, 'Vĩnh', '0394529044', 'vinh23861@gmail.com', 'Nhân viên', 'Bến Tre', 0, '2025-07-26 12:06:42', 2, '$2y$10$a512FIfDMYhk3a7fHDn9zeOhlFGU1GPpdk6A1vLTL34MgtFf7Ei4q', 1),
(3, 'Mai Chí Dĩnh', '0394529044', 'maivinh2609@gmail.com', 'Nhân viên', 'Ba Tri, Bến Tre', 0, '2025-08-10 08:05:57', 1, '$2y$10$ILDCUagaqIb.2iD1UbKoO.On3VCB9AWYOLDUDHnN6SBg6nvtcSxIm', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee_menu`
--

CREATE TABLE `employee_menu` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employee_menu`
--

INSERT INTO `employee_menu` (`id`, `employee_id`, `menu_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:06:42'),
(11, 3, 3, 0, '2025-08-12 18:53:22'),
(12, 3, 1, 0, '2025-08-12 18:53:22'),
(13, 3, 2, 0, '2025-08-12 18:53:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT 'HOT SALE GIÁ SỐC',
  `end_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `flash_sales`
--

INSERT INTO `flash_sales` (`id`, `title`, `end_time`, `status`, `updated_at`) VALUES
(1, 'HOT SALE GIÁ SỐC', '2026-09-22 07:59:00', 1, '2026-09-22 03:23:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `image_url`, `product_id`, `isDeleted`, `created_at`) VALUES
(145, 'https://res.cloudinary.com/direvsslz/image/upload/v1754667070/products/extra/lznfz6eapwilmwmtt3zs.webp', 37, 0, '2025-08-08 15:31:11'),
(146, 'https://res.cloudinary.com/direvsslz/image/upload/v1754667073/products/extra/cozfxhgwtyuqky8tlidr.webp', 37, 0, '2025-08-08 15:31:14'),
(147, 'https://res.cloudinary.com/direvsslz/image/upload/v1754667075/products/extra/znm9shcstlixbevt15m1.webp', 37, 0, '2025-08-08 15:31:17'),
(148, 'https://res.cloudinary.com/direvsslz/image/upload/v1754667077/products/extra/eb2rzogpaw8tdvdgx9sq.webp', 37, 0, '2025-08-08 15:31:19'),
(149, 'uploads/689891e59be67_MacBook Pro 16 M4 Max 2024 16CPU 1.webp', 36, 0, '2025-08-10 12:34:45'),
(150, 'uploads/689891e59cfaf_MacBook Pro 16 M4 Max 2024 16CPU 2.webp', 36, 0, '2025-08-10 12:34:45'),
(151, 'uploads/689891e59d91b_MacBook Pro 16 M4 Max 2024 16CPU 3.webp', 36, 0, '2025-08-10 12:34:45'),
(152, 'uploads/689891e59e1cd_MacBook Pro 16 M4 Max 2024 16CPU 4.webp', 36, 0, '2025-08-10 12:34:45'),
(153, 'uploads/68989327e89cd_Mac mini M4 2024 10CPU 10GPU 16GB 256GB 1.webp', 34, 0, '2025-08-10 12:40:07'),
(154, 'uploads/68989327e92cd_Mac mini M4 2024 10CPU 10GPU 16GB 256GB 2.webp', 34, 0, '2025-08-10 12:40:07'),
(155, 'uploads/68989327e9de7_Mac mini M4 2024 10CPU 10GPU 16GB 256GB 3.webp', 34, 0, '2025-08-10 12:40:07'),
(156, 'uploads/68989327eaa7f_Mac mini M4 2024 10CPU 10GPU 16GB 256GB 4.webp', 34, 0, '2025-08-10 12:40:07'),
(157, 'uploads/68989452949df_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB 1.webp', 32, 0, '2025-08-10 12:45:06'),
(158, 'uploads/68989452959fe_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB 2.webp', 32, 0, '2025-08-10 12:45:06'),
(159, 'uploads/6898945296d0f_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB 3.webp', 32, 0, '2025-08-10 12:45:06'),
(160, 'uploads/68989452977ba_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB 4.webp', 32, 0, '2025-08-10 12:45:06'),
(161, 'uploads/689897bd3fe81_Apple Watch Ultra 2 2024 49mm 4G Viền Titan 1.webp', 31, 0, '2025-08-10 12:59:41'),
(162, 'uploads/689897bd408f4_Apple Watch Ultra 2 2024 49mm 4G Viền Titan 2.webp', 31, 0, '2025-08-10 12:59:41'),
(163, 'uploads/689897bd41377_Apple Watch Ultra 2 2024 49mm 4G Viền Titan 3.webp', 31, 0, '2025-08-10 12:59:41'),
(164, 'uploads/689897bd41e0e_Apple Watch Ultra 2 2024 49mm 4G Viền Titan 4.webp', 31, 0, '2025-08-10 12:59:41'),
(165, 'uploads/68989b54bf8b3_Laptop Dell Gaming G15 5530 i7 13650HX 1.webp', 30, 0, '2025-08-10 13:15:00'),
(166, 'uploads/68989b54c0fcf_Laptop Dell Gaming G15 5530 i7 13650HX 2.webp', 30, 0, '2025-08-10 13:15:00'),
(167, 'uploads/68989b54c1993_Laptop Dell Gaming G15 5530 i7 13650HX 3.webp', 30, 0, '2025-08-10 13:15:00'),
(168, 'uploads/68989b54c225b_Laptop Dell Gaming G15 5530 i7 13650HX 4.webp', 30, 0, '2025-08-10 13:15:00'),
(173, 'uploads/689a411745f10_iPhone 16 Pro Max 256GB 1.webp', 27, 0, '2025-08-11 19:14:31'),
(174, 'uploads/689a411746921_iPhone 16 Pro Max 256GB 2.webp', 27, 0, '2025-08-11 19:14:31'),
(175, 'uploads/689a41174728e_iPhone 16 Pro Max 256GB 3.webp', 27, 0, '2025-08-11 19:14:31'),
(176, 'uploads/689a411747cb0_iPhone 16 Pro Max 256GB 4.webp', 27, 0, '2025-08-11 19:14:31'),
(177, 'uploads/689a43267bb61_Samsung Galaxy S25 Ultra 1.webp', 26, 0, '2025-08-11 19:23:18'),
(178, 'uploads/689a43267c563_Samsung Galaxy S25 Ultra 2.webp', 26, 0, '2025-08-11 19:23:18'),
(179, 'uploads/689a43267d00f_Samsung Galaxy S25 Ultra 3.webp', 26, 0, '2025-08-11 19:23:18'),
(180, 'uploads/689a43267d92a_Samsung Galaxy S25 Ultra 4.webp', 26, 0, '2025-08-11 19:23:18'),
(181, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1789937689/products/extra/wcgqe5g5za4i8a4kgusr.webp', 39, 0, '2026-09-20 20:54:50'),
(182, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1789937690/products/extra/mavqqbxzxkkyj2khvsti.webp', 39, 0, '2026-09-20 20:54:51'),
(183, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1789937692/products/extra/kjezf5ojinnw042nlp4p.webp', 39, 0, '2026-09-20 20:54:52'),
(184, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1789937693/products/extra/u41lppxlpsuewhhi7hse.webp', 39, 0, '2026-09-20 20:54:54'),
(185, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1790023156/products/extra/hurennshz4lk42xrlddm.jpg', 40, 0, '2026-09-21 20:39:17'),
(186, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1790023164/products/extra/gohgnu5r8wtv4uw3294c.jpg', 40, 0, '2026-09-21 20:39:25'),
(187, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1790023166/products/extra/oigbcuw4bofzneeeqsdl.jpg', 40, 0, '2026-09-21 20:39:28'),
(188, 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1790023169/products/extra/ipzcnbb3ujcxrbsb9k59.jpg', 40, 0, '2026-09-21 20:39:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `inventory`
--

INSERT INTO `inventory` (`id`, `stock_quantity`, `last_update`, `product_id`, `isDeleted`, `branch_id`) VALUES
(12, 117, '2025-08-12 19:22:14', 36, 0, 1),
(13, 119, '2025-08-12 19:22:23', 27, 0, 1),
(14, 120, '2025-08-12 19:22:31', 26, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `menu_url`, `isDeleted`, `created_at`) VALUES
(1, 'Chuyển trạng thái đơn hàng', 'modules/Admin/Orders/ChangeStatusOrder.php', 0, '2025-07-26 12:00:58'),
(2, 'Sửa đơn hàng', 'modules/Admin/Orders/UpdateOrder.php', 0, '2025-08-12 12:37:08'),
(3, 'Chuyển đơn shipper', 'modules/Admin/Shipping/OrderTransfer.php', 0, '2025-08-12 12:43:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `shipping_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  `cancel_reason` text DEFAULT NULL,
  `cancel_at` datetime DEFAULT NULL,
  `cancel_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `total_amount`, `payment_id`, `shipping_id`, `user_id`, `create_at`, `note`, `status_id`, `isDeleted`, `code`, `cancel_reason`, `cancel_at`, `cancel_by`, `branch_id`, `employee_id`) VALUES
(43, 91914200.00, 55, 41, 6, '2026-09-20 21:18:43', '', 5, 1, '303ADCA0', 'Muốn đổi sản phẩm', '2026-09-21 04:19:05', 'user.6', 1, NULL),
(44, 91914200.00, 56, 42, 6, '2026-09-20 21:19:26', '', 1, 1, 'F2CD3BD2', NULL, NULL, NULL, 1, NULL),
(45, 0.00, 57, 43, 6, '2026-09-20 21:20:41', '', 5, 1, '69554F91', 'Đặt nhầm', '2026-09-21 04:23:30', 'user.6', 1, NULL),
(46, 91914200.00, 58, 44, 6, '2026-09-20 21:21:09', '', 5, 1, '4A11B756', 'Muốn đổi sản phẩm', '2026-09-21 04:24:04', 'user.6', 1, NULL),
(47, 91914200.00, 59, 45, 6, '2026-09-20 21:24:53', '', 1, 1, '93B21106', NULL, NULL, NULL, 1, NULL),
(48, 91914200.00, 60, 46, 6, '2026-09-20 21:28:24', '', 1, 1, 'CDE7F6D9', NULL, NULL, NULL, 1, NULL),
(49, 91914200.00, 61, 47, NULL, '2026-09-20 21:34:39', '', 1, 0, 'AB920B7D', NULL, NULL, NULL, 1, NULL),
(50, 91914200.00, 62, 48, 6, '2026-09-20 21:38:44', '', 1, 1, '85D6386D', NULL, NULL, NULL, 1, NULL),
(51, 91914200.00, 63, 49, 6, '2026-09-20 21:45:32', '', 6, 0, 'D8AE38B4', NULL, NULL, NULL, 1, 1),
(52, 30091400.00, 64, 50, 6, '2026-09-21 12:31:16', '', 1, 1, 'F4E1E38C', NULL, NULL, NULL, 2, NULL),
(53, 30091400.00, 65, 51, 6, '2026-09-21 12:32:14', '', 1, 1, 'A1B9E3AB', NULL, NULL, NULL, 2, NULL),
(54, 91914200.00, 67, 52, 6, '2026-09-23 19:30:19', '', 1, 0, '3E68D5A8', NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `quantity`, `unit_price`, `product_id`, `order_id`, `isDeleted`) VALUES
(34, 1, 91914200.00, 36, 43, 0),
(35, 1, 91914200.00, 36, 44, 0),
(36, 1, 91914200.00, 36, 46, 0),
(37, 1, 91914200.00, 36, 47, 0),
(38, 1, 91914200.00, 36, 48, 0),
(39, 1, 91914200.00, 36, 49, 0),
(40, 1, 91914200.00, 36, 50, 0),
(41, 1, 91914200.00, 36, 51, 0),
(42, 1, 30091400.00, 27, 52, 0),
(43, 1, 30091400.00, 27, 53, 0),
(44, 1, 91914200.00, 36, 54, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(1, 1, '591221', '2025-08-05 00:47:48', '2025-08-05 00:42:48'),
(2, 1, '249275', '2025-08-05 20:35:48', '2025-08-05 20:30:48'),
(3, 1, '382562', '2025-08-05 20:36:09', '2025-08-05 20:31:09'),
(4, 1, '271564', '2025-08-05 20:43:35', '2025-08-05 20:38:35'),
(5, 1, '509973', '2025-08-05 20:43:41', '2025-08-05 20:38:41'),
(6, 1, '302154', '2025-08-05 20:43:44', '2025-08-05 20:38:44'),
(7, 1, '680924', '2025-08-05 20:43:48', '2025-08-05 20:38:48'),
(8, 1, '510382', '2025-08-05 20:43:51', '2025-08-05 20:38:51'),
(9, 1, '683549', '2025-08-05 20:43:54', '2025-08-05 20:38:54'),
(10, 1, '506677', '2025-08-05 20:43:58', '2025-08-05 20:38:58'),
(11, 1, '797984', '2025-08-05 20:44:01', '2025-08-05 20:39:01'),
(12, 1, '818109', '2025-08-05 20:44:04', '2025-08-05 20:39:04'),
(13, 1, '128236', '2025-08-05 20:44:08', '2025-08-05 20:39:08'),
(14, 1, '693669', '2025-08-05 20:44:19', '2025-08-05 20:39:19'),
(15, 1, '799574', '2025-08-05 20:47:03', '2025-08-05 20:42:03'),
(16, 1, '712596', '2025-08-05 20:54:03', '2025-08-05 20:49:03'),
(17, 1, '788773', '2025-08-05 21:08:11', '2025-08-05 21:03:11'),
(18, 1, '813897', '2025-08-05 21:12:38', '2025-08-05 21:07:38'),
(19, 1, '583742', '2025-08-05 21:25:25', '2025-08-05 21:20:25'),
(20, 1, '314876', '2025-08-05 21:28:10', '2025-08-05 21:23:10'),
(21, 1, '608157', '2025-08-05 21:59:12', '2025-08-05 21:54:12'),
(22, 1, '281289', '2025-08-05 22:07:29', '2025-08-05 22:02:29'),
(23, 1, '995621', '2025-08-05 22:53:52', '2025-08-05 22:48:52'),
(24, 1, '550358', '2025-08-10 15:28:20', '2025-08-10 15:23:20'),
(25, 1, '780094', '2025-08-10 15:30:01', '2025-08-10 15:25:01'),
(26, 1, '511362', '2025-08-10 15:31:21', '2025-08-10 15:26:21'),
(27, 1, '562323', '2025-08-10 15:31:24', '2025-08-10 15:26:24'),
(28, 1, '331165', '2025-08-10 15:32:11', '2025-08-10 15:27:11'),
(29, 1, '943279', '2025-08-10 15:33:04', '2025-08-10 15:28:04'),
(30, 1, '299374', '2025-08-10 15:35:07', '2025-08-10 15:30:07'),
(31, 1, '748433', '2025-08-13 15:13:10', '2025-08-13 15:08:10'),
(32, 1, '147519', '2025-08-13 15:13:14', '2025-08-13 15:08:14'),
(33, 6, '938431', '2026-09-24 02:43:22', '2026-09-24 02:38:22'),
(34, 6, '274677', '2026-09-24 02:47:45', '2026-09-24 02:42:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `method`, `status`, `paid_at`) VALUES
(1, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-01 12:08:09'),
(2, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-04 11:38:46'),
(3, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-04 13:40:57'),
(4, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-04 13:42:19'),
(5, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-04 13:43:10'),
(6, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-07 21:35:35'),
(7, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:32:39'),
(8, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:32:55'),
(9, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:33:04'),
(10, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:33:12'),
(11, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:33:21'),
(12, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-10 19:33:31'),
(13, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:21:14'),
(14, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:24:55'),
(15, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:27:49'),
(16, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:40:31'),
(17, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:42:09'),
(18, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-19 14:42:54'),
(19, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 11:36:23'),
(20, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 11:36:51'),
(21, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 11:44:42'),
(22, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 11:52:35'),
(23, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:05:18'),
(24, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:20:44'),
(25, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:20:50'),
(26, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:21:16'),
(27, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:21:34'),
(28, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:24:06'),
(29, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:24:11'),
(30, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-20 12:24:18'),
(31, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-23 01:13:02'),
(32, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-23 01:13:09'),
(33, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-26 18:52:18'),
(34, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-26 19:23:34'),
(35, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-07-26 19:24:47'),
(36, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-09 22:06:47'),
(37, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-12 19:24:21'),
(38, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-12 19:35:52'),
(39, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-12 19:54:09'),
(40, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-13 01:52:08'),
(41, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-13 14:58:38'),
(42, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-12-16 22:33:28'),
(43, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-12-16 22:33:48'),
(44, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-12-16 22:34:09'),
(45, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2026-04-20 20:21:21'),
(46, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(47, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(48, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(49, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(50, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(51, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(52, 'Thanh toán Online (VNPay)', 'Chưa thanh toán', NULL),
(53, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:16:58'),
(54, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:17:18'),
(55, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:18:43'),
(56, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:19:26'),
(57, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:20:41'),
(58, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:21:09'),
(59, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 04:24:53'),
(60, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Đã thanh toán (MoMo/ShopeePay/VietQR)', '2026-09-21 04:32:47'),
(61, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Đã xác nhận chuyển khoản (Chờ đối soát)', '2026-09-21 04:36:21'),
(62, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Đã xác nhận chuyển khoản (Chờ đối soát)', '2026-09-21 04:38:49'),
(63, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Đã xác nhận chuyển khoản (Chờ đối soát)', '2026-09-21 04:45:38'),
(64, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 19:31:16'),
(65, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-21 19:32:14'),
(66, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2026-09-21 19:42:00'),
(67, 'Thanh toán Online (MoMo/ShopeePay/VietQR)', 'Chờ thanh toán', '2026-09-24 02:30:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `discount`, `description`, `image_url`, `category_id`, `supplier_id`, `created_at`, `content`, `isDeleted`) VALUES
(26, 'Samsung Galaxy S25 Ultra 12GB 256GB', 33380000.00, 15.00, '<h2 class=\"ksp-title\">Đặc điểm nổi bật của Samsung Galaxy S25 Ultra 12GB 256GB</h2>\r\n<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<blockquote>\r\n<p><a title=\"Samsung Galaxy S25 Ultra\" href=\"https://cellphones.com.vn/dien-thoai-samsung-galaxy-s25-ultra.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung Galaxy S25 Ultra</strong></a>&nbsp;mạnh mẽ với chip&nbsp;<strong>Snapdragon 8 Elite For Galaxy</strong>&nbsp;mới nhất,&nbsp;RAM 12GB&nbsp;v&agrave; bộ nhớ trong&nbsp;256GB-1TB. Hệ thống&nbsp;<strong>3 camera sau</strong>&nbsp;chất lượng gồm&nbsp;camera ch&iacute;nh 200MP, camera tele 50MP v&agrave; camera g&oacute;c si&ecirc;u rộng 50MP. Thiết kế&nbsp;k&iacute;nh cường lực&nbsp;<strong>Corning Gorilla Armor 2</strong>&nbsp;v&agrave; khung&nbsp;<strong>viền&nbsp;Titanium</strong>,&nbsp;m&agrave;n h&igrave;nh&nbsp;Dynamic AMOLED 6.9 inch. Điện thoại n&agrave;y c&ograve;n c&oacute; vi&ecirc;n pin&nbsp;<strong>5000mAh</strong>,&nbsp;hỗ trợ&nbsp;<strong>5G</strong>&nbsp;v&agrave;&nbsp;<strong>Galaxy AI</strong> ấn tượng, n&acirc;ng cao trải nghiệm người d&ugrave;ng!</p>\r\n<h2 id=\"samsung-galaxy-s25-ultra-gia-bao-nhieu\"><strong>Samsung Galaxy S25 Ultra gi&aacute; bao nhi&ecirc;u?</strong></h2>\r\n<p><strong>Bảng gi&aacute; S25 Ultra 5G ch&iacute;nh h&atilde;ng</strong>&nbsp;mới nhất:</p>\r\n<p>&nbsp;</p>\r\n<div>\r\n<table class=\"seo-table seo-product-price table is-bordered is-narrow is-hoverable is-fullwidth\">\r\n<thead>\r\n<tr>\r\n<td>\r\n<p><strong>T&ecirc;n sản phẩm</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; b&aacute;n</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; thu cũ l&ecirc;n đời</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 12GB 256GB</p>\r\n</td>\r\n<td>\r\n<p>26.980.000đ</p>\r\n</td>\r\n<td>\r\n<p>24.980.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 512GB</p>\r\n</td>\r\n<td>\r\n<p>29.490.000đ</p>\r\n</td>\r\n<td>\r\n<p>26.490.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 1TB</p>\r\n</td>\r\n<td>\r\n<p>35.490.000đ</p>\r\n</td>\r\n<td>\r\n<p>34.490.000đ</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p>Tại thị trường Việt Nam,&nbsp;<strong>gi&aacute; Samsung Galaxy S25 Ultra</strong>&nbsp;khởi điểm&nbsp;<strong>từ 33.38 triệu đồng</strong>&nbsp;cho bản&nbsp;<strong>12GB/256GB</strong>. Mua tại CellphoneS giảm thẳng đến 5 triệu.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-gia-bao-nhieu_1.jpg\" alt=\"Gi&aacute; Samsung Galaxy S25 Ultra rẻ nhất \" loading=\"lazy\"></p>\r\n<h2 id=\"danh-gia-s25-ultra-5g-chinh-hang-moi-nhat\"><strong>Đ&aacute;nh gi&aacute; S25 Ultra 5G ch&iacute;nh h&atilde;ng mới nhất</strong></h2>\r\n<p>C&aacute;c th&ocirc;ng số kh&aacute;c như dung lượng pin v&agrave; c&aacute;c t&iacute;nh năng kh&aacute;c được cho l&agrave; kh&ocirc;ng c&oacute; nhiều thay đổi đ&aacute;ng kể. Tuy nhi&ecirc;n, với những cải tiến đ&aacute;ng ch&uacute; &yacute; về kiểu d&aacute;ng v&agrave; camera, Galaxy S25 Ultra vẫn l&agrave; một lựa chọn n&acirc;ng cấp hấp dẫn so với tiền nhiệm.</p>\r\n<p>M&aacute;y mới&nbsp;lần n&agrave;y&nbsp;kh&ocirc;ng chỉ l&agrave; một chiếc điện thoại th&ocirc;ng minh, m&agrave; c&ograve;n l&agrave; biểu tượng của sự đẳng cấp v&agrave; c&ocirc;ng nghệ ti&ecirc;n tiến. T&igrave;m hiểu ngay qua c&aacute;c nội dung ch&iacute;nh sau:</p>\r\n<h3 id=\"thiet-ke-goc-vien-bo-cong-tinh-te\"><strong>Thiết kế g&oacute;c viền bo cong tinh tế</strong></h3>\r\n<p>Samsung tiếp tục duy tr&igrave;&nbsp;<strong>ng&ocirc;n ngữ thiết kế đặc trưng</strong>&nbsp;cho d&ograve;ng<strong>&nbsp;S25 Ultra</strong>. Thay đổi lớn nhất về thiết kế nằm ở&nbsp;<strong>c&aacute;c g&oacute;c bo tr&ograve;n v&agrave; mỏng hơn, với trọng lượng giảm 14g so với trước</strong>, điều n&agrave;y gi&uacute;p người d&ugrave;ng thoải m&aacute;i hơn khi cầm nắm thiết bị.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-thiet-ke.jpg\" alt=\"Điện thoại S25 Ultra bo cong tinh tế\" loading=\"lazy\"></p>\r\n<p>Camera vẫn được xếp&nbsp;<strong>theo h&agrave;ng dọc</strong>&nbsp;ở mặt lưng, với c&aacute;c ống k&iacute;nh nh&ocirc; ra tương tự phi&ecirc;n bản tiền nhiệm. Điều n&agrave;y mang lại vẻ ngo&agrave;i hiện đại, tối ưu h&oacute;a t&iacute;nh thẩm mỹ v&agrave; cảm gi&aacute;c cầm nắm.</p>\r\n<p>Về chất liệu, Samsung duy tr&igrave;&nbsp;<strong>khung titan cao cấp</strong>, đ&acirc;y l&agrave; sự lựa chọn l&yacute; tưởng khi vừa đảm bảo độ bền vừa giảm trọng lượng thiết bị. S25 Ultra sẽ c&oacute; c&aacute;c t&ugrave;y chọn m&agrave;u sắc đa dạng như Xanh Titan, Bạc Titan, X&aacute;m Titan, Đen Titan. Ngo&agrave;i ra, một số phi&ecirc;n bản m&agrave;u chỉ c&oacute; tại Samsung.com như V&agrave;ng Hồng, Đen Tuyền, v&agrave; Xanh Ngọc.&nbsp;</p>\r\n<h3 id=\"man-hinh-dynamic-amoled-2x-6-9-inch-hien-thi-ruc-ro\"><strong>M&agrave;n h&igrave;nh Dynamic AMOLED 2x 6.9 inch, hiển thị rực rỡ</strong></h3>\r\n<p><strong>S25 Ultra trang bị tấm nền&nbsp;Dynamic AMOLED 2x k&iacute;ch thước</strong>&nbsp;<strong>6,9 inch độ ph&acirc;n giải QHD+&nbsp;</strong>mang đến trải nghiệm h&igrave;nh ảnh sống động. Điểm nhấn đ&aacute;ng ch&uacute; &yacute; nằm ở viền bezel si&ecirc;u mỏng, kh&ocirc;ng chỉ mang lại trải nghiệm hiển thị rộng r&atilde;i m&agrave; c&ograve;n l&agrave;m nổi bật vẻ đẹp sang trọng của m&aacute;y.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-man-hinh.jpg\" alt=\"Dynamic AMOLED 2x lớn sắc n&eacute;t\" loading=\"lazy\"></p>\r\n<h3 id=\"chiset-snapdragon-8-elite-for-galaxy-moi-va-manh-me\"><strong>Chiset Snapdragon 8 Elite for Galaxy mới v&agrave; mạnh mẽ</strong></h3>\r\n<p><strong>Với tầm gi&aacute; Samsung Galaxy S25 Ultra</strong>&nbsp;hiện nay được kỳ vọng sẽ đạt&nbsp;<strong>đỉnh cao mới về hiệu năng</strong>&nbsp;nhờ sức mạnh của chipset&nbsp;<strong>Snapdragon 8 Elite for Galaxy</strong>&nbsp;(hay Snap 8 Elite). Đ&acirc;y l&agrave; vi xử l&yacute; mới từ Qualcomm, mang lại cải tiến ấn tượng cả về tốc độ xử l&yacute; v&agrave; khả năng đồ họa. Snapdragon 8 Elite cho thấy hiệu suất l&otilde;i đơn&nbsp;<strong>NPU&nbsp;tăng đến 40%</strong>, gi&uacute;p xử l&yacute; nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c c&aacute;c t&aacute;c vụ AI. Kh&ocirc;ng chỉ vậy, hiệu suất&nbsp;<strong>CPU tăng hơn 37%</strong>&nbsp;gi&uacute;p tối ưu hiệu năng sử dụng, đồng thời&nbsp;<strong>cải tiến GPU đến 30%</strong>.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-hieu-nang.jpg\" alt=\"Snapdragon 8 Elite mạnh mẽ tr&ecirc;n Samsung S25 Ultra 5G\" loading=\"lazy\"></p>\r\n<p>Với&nbsp;<strong>điện thoại Samsung S25 Ultra</strong>, điểm Benchmark lần lượt:</p>\r\n<ul>\r\n<li>\r\n<p><strong>CPU: 560.967</strong>&nbsp;-&gt; Cho ph&eacute;p m&aacute;y chạy đa nhiệm mượt m&agrave;, xử l&yacute; c&aacute;c t&aacute;c vụ nặng như chơi game 3D, chỉnh sửa video một c&aacute;ch dễ d&agrave;ng</p>\r\n</li>\r\n<li>\r\n<p><strong>GPU: 889.301</strong>&nbsp;-&gt;&nbsp;&nbsp;Khả năng xử l&yacute; đồ họa của m&aacute;y rất tốt</p>\r\n</li>\r\n<li>\r\n<p><strong>MEM: 444.565</strong>&nbsp;-&gt;&nbsp;Hiệu năng truy xuất dữ liệu của m&aacute;y rất nhanh,&nbsp;gi&uacute;p m&aacute;y chạy c&aacute;c ứng dụng một c&aacute;ch mượt m&agrave; v&agrave; kh&ocirc;ng bị giật lag</p>\r\n</li>\r\n<li>\r\n<p><strong>UX: 349.427</strong>&nbsp;-&gt; Hiệu năng tổng thể của m&aacute;y rất tốt, bao gồm cả tốc độ phản hồi, thời gian mở ứng dụng v&agrave; khả năng đa nhiệm</p>\r\n</li>\r\n</ul>\r\n<p>Với những điểm số Benchmark tr&ecirc;n, c&oacute; thể thấy rằng&nbsp;<a title=\"điện thoại\" href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" rel=\"noopener\"><strong>điện thoại</strong></a>&nbsp;S25 Ultra lần n&agrave;y l&agrave; một chiếc smartphone c&oacute; hiệu năng cực kỳ mạnh mẽ. M&aacute;y ho&agrave;n to&agrave;n c&oacute; thể đ&aacute;p ứng được mọi nhu cầu sử dụng của người d&ugrave;ng, từ những t&aacute;c vụ cơ bản đến những t&aacute;c vụ nặng.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-benchmark.jpg\" alt=\"Điểm Antutu Samsung S25 Ultra 5G\" loading=\"lazy\"></p>\r\n<p>Hiệu năng ấn tượng kết hợp với t&iacute;nh năng ti&ecirc;n tiến như chế độ&nbsp;<strong>Khả năng AI tối ưu h&oacute;a</strong>, S25 Ultra 5G kh&ocirc;ng chỉ đ&aacute;p ứng nhu cầu của người d&ugrave;ng m&agrave; c&ograve;n định h&igrave;nh lại chuẩn mực hiệu suất cho smartphone cao cấp năm 2025.</p>\r\n<h3 id=\"camera-200mp-sac-net-zoom-xa-100x-cuc-chi-tiet\"><strong>Camera 200MP sắc n&eacute;t, zoom xa 100x cực chi tiết</strong></h3>\r\n<p><strong>Camera Samsung S25 Ultra</strong>&nbsp;tiếp tục khẳng định vị thế dẫn đầu về c&ocirc;ng nghệ camera với những n&acirc;ng cấp đ&aacute;ng ch&uacute; &yacute;. Điểm nhấn của&nbsp;<a title=\"Samsung S series\" href=\"https://cellphones.com.vn/mobile/samsung/galaxy-s.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung S series</strong></a>&nbsp;lần n&agrave;y nằm ở cảm biến ch&iacute;nh&nbsp;<strong>200MP</strong>, mang đến độ chi tiết ấn tượng v&agrave; khả năng chụp ảnh chất lượng cao trong nhiều điều kiện &aacute;nh s&aacute;ng. Đi k&egrave;m với đ&oacute; l&agrave; t&iacute;nh năng&nbsp;<strong>Space Zoom 100x</strong>, cho ph&eacute;p người d&ugrave;ng kh&aacute;m ph&aacute; những chi tiết nhỏ nhất từ xa.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-camera.jpg\" alt=\"camera Samsung S25 Ultra 5G 200MP\" loading=\"lazy\"></p>\r\n<p>Một trong những n&acirc;ng cấp đ&aacute;ng ch&uacute; &yacute; l&agrave; cảm biến g&oacute;c si&ecirc;u rộng, được n&acirc;ng cấp từ 12MP l&ecirc;n 50MP.&nbsp;Camera g&oacute;c si&ecirc;u rộng n&agrave;y c&oacute; khẩu độ f/1.9, hỗ trợ ổn định h&igrave;nh ảnh v&agrave; độ ph&acirc;n giải cao, hứa hẹn mang lại trải nghiệm chụp phong cảnh v&agrave; ảnh nh&oacute;m xuất sắc.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-camera-1.jpg\" alt=\"Camera Galaxy S25 Ultra 5G zoom 100X\" loading=\"lazy\"></p>\r\n<p>Ống k&iacute;nh tele hỗ trợ zoom quang học 3x với độ ph&acirc;n giải 10MP, 5x với độ ph&acirc;n giải 50MP mang lại sự linh hoạt đ&aacute;ng kể, đặc biệt khi quay video. Ngo&agrave;i ra, ống k&iacute;nh c&ograve;n hỗ trợ zoom chuẩn quang học 2x, 10x. Nhờ c&ocirc;ng nghệ ti&ecirc;n tiến tr&ecirc;n cụm camera m&agrave; &aacute;nh macro si&ecirc;u chi tiết tăng đ&aacute;ng kể v&ugrave;ng ph&acirc;n giải, v&ugrave;ng s&aacute;ng, cho ảnh tốt hơn ở điều kiện s&aacute;ng kh&aacute;c nhau. Kh&ocirc;ng chỉ vậy, ảnh macro c&ograve;n chi tiết hơn 4 lần so với S24 Ultra.</p>\r\n<h3 id=\"ss-s25-ultra-dung-luong-pin-5000mah\"><strong>SS S25 Ultra dung lượng pin 5000mAh</strong></h3>\r\n<p>Samsung&nbsp;S25&nbsp;Ultra 5G tiếp tục giữ vi&ecirc;n&nbsp;<strong>pin dung lượng 5.000 mAh</strong>, hỗ trợ sạc nhanh 45W, đảm bảo hiệu suất sử dụng d&agrave;i l&acirc;u. Tuy nhi&ecirc;n, sự kh&aacute;c biệt đ&aacute;ng ch&uacute; &yacute; nằm ở c&aacute;c cải tiến tối ưu h&oacute;a năng lượng từ chipset Snapdragon 8 Elite, với hiệu suất CPU v&agrave; NPU được cải thiện lần lượt&nbsp;<strong>37% v&agrave; 40%</strong>, g&oacute;p phần&nbsp;<strong>k&eacute;o d&agrave;i thời gian sử dụng</strong>&nbsp;d&ugrave; dung lượng pin kh&ocirc;ng đổi.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-pin.jpg\" alt=\"Pin SS S25 Ultra dung lượng lớn 5000mAh\" loading=\"lazy\"></p>\r\n<h2 id=\"nen-mua-samsung-s25-ultra-5g-hay-s24-ultra\"><strong>N&ecirc;n mua Samsung S25 Ultra 5G hay S24 Ultra?</strong></h2>\r\n<p>H&atilde;y c&ugrave;ng&nbsp;<strong>so s&aacute;nh Samsung S25 Ultra v&agrave;&nbsp;<a href=\"https://cellphones.com.vn/samsung-galaxy-s24-ultra.html\" target=\"_blank\" rel=\"noopener\">S24 Ultra</a></strong>&nbsp;xem thế hệ Galaxy S mới nhất đ&atilde; được thay đổi những g&igrave; v&agrave; đưa ra quyết định n&ecirc;n mua phi&ecirc;n bản mới hay thế hệ tiền nhiệm!</p>\r\n<table border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><strong>Ti&ecirc;u ch&iacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>S25 Ultra</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>S24 Ultra</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Thiết kế</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Viền bo cong,</strong>&nbsp;khung titan</p>\r\n</td>\r\n<td>\r\n<p>Viền vu&ocirc;ng vức, khung titan</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;u sắc</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Xanh Titan,</strong>&nbsp;X&aacute;m Titan,&nbsp;<strong>Bạc Titan</strong>&nbsp;v&agrave; Đen Titan</p>\r\n</td>\r\n<td>\r\n<p>V&agrave;ng,&nbsp; X&aacute;m , T&iacute;m, Đen</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;n h&igrave;nh</strong></p>\r\n</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X,&nbsp;<strong>6.9 inch</strong></p>\r\n</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X, 6.8 inch</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Vi xử l&yacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Snapdragon 8 Elite for Galaxy</strong></p>\r\n</td>\r\n<td>\r\n<p>Snapdragon 8 Gen 3 for Galaxy</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>RAM</strong></p>\r\n</td>\r\n<td>\r\n<p>12GB</p>\r\n</td>\r\n<td>\r\n<p>12GB</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Bộ nhớ trong</strong></p>\r\n</td>\r\n<td>\r\n<p>256GB - 512GB - 1TB</p>\r\n</td>\r\n<td>\r\n<p>256GB - 512GB - 1TB</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Camera trước</strong></p>\r\n</td>\r\n<td>\r\n<p>12MP</p>\r\n</td>\r\n<td>\r\n<p>12MP</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Camera sau</strong></p>\r\n</td>\r\n<td>\r\n<p>200MP (ch&iacute;nh) +&nbsp;<strong>50MP (si&ecirc;u rộng)</strong>&nbsp;+ 10MP (tele 3x)&nbsp;+ 50MP (tele 5x)</p>\r\n</td>\r\n<td>\r\n<p>200MP (ch&iacute;nh) + 12MP (si&ecirc;u rộng) + 10MP (tele 3x) + 50MP (tele 5x)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Pin</strong></p>\r\n</td>\r\n<td>\r\n<p>5.000 mAh</p>\r\n</td>\r\n<td>\r\n<p>5.000 mAh</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Như vậy,&nbsp;<strong>kh&aacute;c biệt ch&iacute;nh của S25 Ultra v&agrave; S24 Ultra</strong>&nbsp;nằm ở&nbsp;<strong>diện mạo, hiệu năng, m&agrave;n h&igrave;nh</strong>&nbsp;v&agrave;&nbsp;<strong>hệ thống camera</strong>&nbsp;n&acirc;ng cấp. Về diện mạo, m&aacute;y S25 Ultra c&oacute; vẻ ngo&agrave;i được bo tr&ograve;n mềm mại hơn, mang lại cảm gi&aacute;c cầm nắm dễ chịu hơn, viền mỏng hơn gia tăng kh&ocirc;ng gian hiển thị. Về khả năng chụp ảnh, camera&nbsp;<a title=\"Samsung\" href=\"https://cellphones.com.vn/mobile/samsung.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung</strong></a>&nbsp;g&oacute;c si&ecirc;u rộng của d&ograve;ng điện thoại mới được n&acirc;ng cấp l&ecirc;n độ ph&acirc;n giải 50MP, hứa hẹn chất lượng ảnh chụp ấn tượng hơn.</p>\r\n<h2 id=\"mot-vai-cau-hoi-khi-mua-s25-ultra-5g-chinh-hang\"><strong>Một v&agrave;i c&acirc;u hỏi khi mua S25 Ultra 5G ch&iacute;nh h&atilde;ng</strong></h2>\r\n<p>Việc lựa chọn một chiếc flagship đi đ&ocirc;i với tầm gi&aacute; S25 Ultra 5G mang đến sẽ đ&ograve;i hỏi sự c&acirc;n nhắc kỹ lưỡng về hiệu năng, c&ocirc;ng nghệ v&agrave; trải nghiệm thực tế. Người d&ugrave;ng thường đặt ra nhiều c&acirc;u hỏi li&ecirc;n quan đến cấu h&igrave;nh, t&iacute;nh năng v&agrave; gi&aacute; trị sử dụng trước khi đưa ra quyết định. Dưới đ&acirc;y l&agrave; những vấn đề quan trọng cần xem x&eacute;t để đảm bảo m&aacute;y đ&aacute;p ứng đ&uacute;ng nhu cầu của bạn.</p>\r\n<h3 id=\"samsung-s25-ultra-khi-nao-ra-mat\"><strong>Samsung S25 Ultra khi n&agrave;o ra mắt?</strong></h3>\r\n<p><strong>Samsung S25 Ultra</strong>&nbsp;ra mắt Việt Nam v&agrave;o&nbsp;<strong>1:00 s&aacute;ng ng&agrave;y 23/1/2025</strong>&nbsp;tại sự kiện&nbsp;<strong>Galaxy Unpacked 2025</strong>&nbsp;diễn ra ở&nbsp;<strong>San Jose, Hoa Kỳ</strong>.</p>\r\n<p>Điểm nhấn từ thư mời của Samsung l&agrave; biểu tượng ng&ocirc;i sao 4 c&aacute;nh, gợi nhắc đến logo&nbsp;<strong>Galaxy AI</strong>&nbsp;&ndash; t&iacute;nh năng tr&iacute; tuệ nh&acirc;n tạo đột ph&aacute;. Điện thoại lần n&agrave;y hứa hẹn sẽ thiết lập ti&ecirc;u chuẩn mới cho c&ocirc;ng nghệ di động năm 2025.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-khi-nao-ra-mat.jpg\" alt=\"Samsung S25 Ultra ra mắt Việt Nam ng&agrave;y 23/01/2025\" loading=\"lazy\"></p>\r\n<h3 id=\"samsung-s25-ultra-co-gi-cai-tien-hon-truoc\"><strong>Samsung S25 Ultra c&oacute; g&igrave; cải tiến hơn trước?</strong></h3>\r\n<p><strong>C&ocirc;ng nghệ AI</strong>&nbsp;l&agrave; một trong những điểm&nbsp;<strong>quan trọng nhất</strong>&nbsp;tr&ecirc;n d&ograve;ng&nbsp;<strong>Samsung&nbsp;S&nbsp;Series</strong>&nbsp;n&oacute;i chung, với c&aacute;c t&iacute;nh năng&nbsp;<strong>Galaxy AI</strong>&nbsp;được n&acirc;ng cấp mạnh mẽ, bao gồm:</p>\r\n<ul>\r\n<li>\r\n<p>Human-like AI Agents</p>\r\n</li>\r\n<li>\r\n<p>Nền tảng AI t&iacute;ch hợp</p>\r\n</li>\r\n<li>\r\n<p>AI C&aacute; nh&acirc;n ho&aacute;</p>\r\n</li>\r\n</ul>\r\n<h3 id=\"samsung-s25-ultra-co-may-mau-mau-nao-moi-xuat-hien\"><strong>Samsung S25 Ultra c&oacute; mấy m&agrave;u? M&agrave;u n&agrave;o mới xuất hiện?</strong></h3>\r\n<p><strong>S25 Ultra</strong>&nbsp;<strong>Samsung&nbsp;</strong>sở hữu&nbsp;<strong>4 m&agrave;u sắc</strong>&nbsp;tinh tế v&agrave; hiện đại gồm:&nbsp;<strong>Xanh Titan, X&aacute;m Titan, Bạc Titan v&agrave; Đen Titan</strong>. C&oacute; thể thấy m&agrave;u sắc mới xuất hiện l&agrave;<strong>&nbsp;Bạc Titan</strong>&nbsp;v&agrave; Xanh Titan thay thế cho T&iacute;m v&agrave; V&agrave;ng của đời trước. Ngo&agrave;i ra c&oacute; 1 số m&agrave;u sắc kh&aacute;c chỉ c&oacute; tại Samsung.com như V&agrave;ng Hồng, Đen Tuyền, Xanh Ngọc Titan. Với nhiều tuỳ chọn n&agrave;y, người d&ugrave;ng dễ d&agrave;ng lựa chọn phi&ecirc;n bản ph&ugrave; hợp với phong c&aacute;ch c&aacute; nh&acirc;n.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-co-may-mau_1.jpg\" alt=\"Samsung S25 Ultra c&oacute; 4 m&agrave;u n&ecirc;n mua\" loading=\"lazy\"></p>\r\n<h3 id=\"samsung-s25-ultra-co-chong-nuoc-khong\"><strong>Samsung S25 Ultra c&oacute; chống nước kh&ocirc;ng?</strong></h3>\r\n<p><strong>Samsung Galaxy S25 Ultra</strong>&nbsp;được thiết kế chống nước vượt trội&nbsp;<strong>đạt chuẩn IP68</strong>, cho ph&eacute;p thiết bị hoạt động ổn định trong nhiều điều kiện. Khung titan chắc chắn c&ugrave;ng&nbsp;<strong>k&iacute;nh Corning&reg; Gorilla&reg; Armor 2</strong>&nbsp;mang lại sự bảo vệ to&agrave;n diện trước những t&aacute;c động h&agrave;ng ng&agrave;y như trầy xước, bụi bẩn v&agrave; va đập. Đ&acirc;y l&agrave; chiếc smartphone l&yacute; tưởng cho những ai t&igrave;m kiếm sự bền bỉ, mạnh mẽ m&agrave; kh&ocirc;ng l&agrave;m mất đi sự tinh tế v&agrave; sang trọng trong thiết kế.</p>\r\n<p>B&ecirc;n cạnh đ&oacute;, bạn c&oacute; thể kh&aacute;m ph&aacute; ngay tổng hợp c&aacute;c mẫu&nbsp;<a title=\"Samsung S25\" href=\"https://cellphones.com.vn/mobile/samsung/galaxy-s/s25-series.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung S25</strong></a>&nbsp;ch&iacute;nh h&atilde;ng để c&oacute; th&ecirc;m nhiều lựa chọn đa dạng hơn với mức ưu đ&atilde;i sốc hơn 10 triệu khi mua tại CellphoneS. C&ugrave;ng kh&aacute;m ph&aacute; ngay để kh&ocirc;ng bỏ qua cơ hội chọn mua sản phẩm ph&ugrave; hợp ngay nh&eacute;!</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-co-chong-nuoc-khong.jpg\" alt=\"Samsung Galaxy S25 5G Ultra chống nước chuẩn IP68\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-samsung-s25-ultra-gia-re-chinh-hang-tai-cellphones\"><strong>Mua Samsung S25 Ultra gi&aacute; rẻ, ch&iacute;nh h&atilde;ng tại CellphoneS&nbsp;</strong></h2>\r\n<p>Sở hữu si&ecirc;u phẩm flagship hiệu năng đỉnh cao v&agrave; thiết kế thời thượng chỉ trong tầm tay tại CellphoneS.&nbsp;<strong>Mua ngay Samsung Galaxy S25 Ultra</strong>&nbsp;gi&aacute; rẻ, ch&iacute;nh h&atilde;ng&nbsp;<strong>tại CellphoneS</strong> để trải nghiệm sự tuyệt vời của chiếc điện thoại n&agrave;y. Với CellphoneS, bạn sẽ được hưởng bảo h&agrave;nh thời gian d&agrave;i. Hơn nữa, bạn c&oacute; thể đăng k&yacute; nhận th&ocirc;ng tin khuyến m&atilde;i qua email từ CellphoneS để lu&ocirc;n cập nhật về những ưu đ&atilde;i v&agrave; th&ocirc;ng tin mới nhất về Samsung.</p>\r\n</blockquote>\r\n</div>\r\n</div>', 'uploads/689a432675206_Samsung Galaxy S25 Ultra.webp', 9, 17, '2025-08-05 17:38:51', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>6.9 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera sau</td>\r\n<td>\r\n<p>Camera si&ecirc;u rộng 50MP<br>Camera g&oacute;c rộng 200 MP<br>Camera Tele (5x) 50MP<br>Camera Tele (3x) 10MP\"</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera trước</td>\r\n<td>\r\n<p>12 MP</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Chipset</td>\r\n<td>\r\n<p>Snapdragon 8 Elite d&agrave;nh cho Galaxy (3nm)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ NFC</td>\r\n<td>\r\n<p>C&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>12 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Bộ nhớ trong</td>\r\n<td>\r\n<p>256 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Pin</td>\r\n<td>\r\n<p>5000 mAh</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>Android 15</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>3120 x 1440 pixels (Quad HD+)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(27, 'iPhone 16 Pro Max 256GB | Chính hãng VN/A', 34990000.00, 14.00, '<h2 class=\"ksp-title\">Đặc điểm nổi bật của iPhone 16 Pro Max 256GB | Ch&iacute;nh h&atilde;ng VN/A</h2>\r\n<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<p><strong>iPhone 16 Pro Max&nbsp;</strong>sở hữu chipset A18 Pro mạnh mẽ gi&uacute;p xử l&yacute; nhanh mọi t&aacute;c vụ, camera 48 MP zoom quang 5x cho ảnh n&eacute;t, m&agrave;n h&igrave;nh 6.9 inch sống động. Pin dung lượng cao của m&aacute;y hỗ trợ ph&aacute;t video tới 33 tiếng, đ&aacute;p ứng nhu cầu giải tr&iacute; li&ecirc;n tục suốt ng&agrave;y d&agrave;i. C&ugrave;ng với đ&oacute; l&agrave; thiết kế khung Titanium bền nhẹ, mang lại cảm gi&aacute;c sang trọng v&agrave; chắc chắn khi cầm.</p>\r\n<h2 id=\"gia-iphone-16-pro-max-bao-nhieu-tien-08-2025\"><strong>Gi&aacute; iPhone 16 Pro Max bao nhi&ecirc;u tiền 08/2025?</strong></h2>\r\n<p>Gi&aacute; iPhone 16 Pro Max hiện đang ở mức 30.39 triệu đồng cho phi&ecirc;n bản 256GB, l&agrave; lựa chọn phổ biến với dung lượng lưu trữ đ&aacute;p ứng tốt cho nhu cầu th&ocirc;ng thường. Với những người d&ugrave;ng thường xuy&ecirc;n l&agrave;m việc với dữ liệu lớn hoặc đam m&ecirc; chụp ảnh, quay phim, phi&ecirc;n bản 512GB c&oacute; gi&aacute; 36.79 triệu đồng sẽ l&agrave; lựa chọn hợp l&yacute; hơn.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-1.jpg\" alt=\"Gi&aacute; iPhone 16 Pro Max bao nhi&ecirc;u tiền\" loading=\"lazy\"></p>\r\n<p>Trong khi đ&oacute;, phi&ecirc;n bản cao cấp hơn với dung lượng 1TB hiện đang được b&aacute;n ở mức 42.99 triệu đồng, ph&ugrave; hợp cho những kh&aacute;ch h&agrave;ng muốn lưu trữ thoải m&aacute;i dữ liệu chuy&ecirc;n s&acirc;u. Dưới đ&acirc;y l&agrave; bảng gi&aacute; chi tiết c&aacute;c phi&ecirc;n bản iPhone16 Pro Max tại CellphoneS v&agrave;o 08/2025:</p>\r\n<p>&nbsp;</p>\r\n<div>\r\n<table class=\"seo-table seo-product-price table is-bordered is-narrow is-hoverable is-fullwidth\">\r\n<thead>\r\n<tr>\r\n<td>\r\n<p><strong>T&ecirc;n sản phẩm</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; b&aacute;n</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; thu cũ l&ecirc;n đời</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 256GB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>29.990.000đ</p>\r\n</td>\r\n<td>\r\n<p>27.990.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 512GB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>36.790.000đ</p>\r\n</td>\r\n<td>\r\n<p>34.790.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 1TB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>42.990.000đ</p>\r\n</td>\r\n<td>\r\n<p>40.990.000đ</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<h2 id=\"iphone-16-pro-max-co-nhung-phien-ban-gb-nao\"><strong>iPhone 16 Pro Max c&oacute; những phi&ecirc;n bản GB n&agrave;o?</strong></h2>\r\n<p>Apple giới thiệu iPhone 16 Pro Max với ba phi&ecirc;n bản bộ nhớ trong kh&aacute;c nhau, gi&uacute;p người d&ugrave;ng dễ d&agrave;ng lựa chọn theo đ&uacute;ng nhu cầu sử dụng v&agrave; khả năng t&agrave;i ch&iacute;nh. C&aacute;c phi&ecirc;n bản lần lượt gồm iPhone16 Pro Max 256 GB, phi&ecirc;n bản 512GB v&agrave; phi&ecirc;n bản dung lượng lớn 1TB.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-2_1.jpg\" alt=\"iPhone 16 Pro Max c&oacute; những phi&ecirc;n bản GB n&agrave;o\" loading=\"lazy\"></p>\r\n<p>Với kh&aacute;ch h&agrave;ng th&ocirc;ng thường, phi&ecirc;n bản&nbsp;<a title=\"iPhone 16\" href=\"https://cellphones.com.vn/mobile/apple/iphone-16.html\" target=\"_blank\" rel=\"noopener\"><strong>iPhone16</strong></a>&nbsp;bản Pro Max 256 GB l&agrave; lựa chọn l&yacute; tưởng bởi mức gi&aacute; hợp l&yacute; c&ugrave;ng dung lượng lưu trữ đủ d&ugrave;ng h&agrave;ng ng&agrave;y. Tuy nhi&ecirc;n, những người c&oacute; nhu cầu cao về lưu trữ hoặc ghi nhớ dữ liệu lớn n&ecirc;n c&acirc;n nhắc phi&ecirc;n bản 512GB v&agrave; 1TB để c&oacute; trải nghiệm tốt hơn m&agrave; kh&ocirc;ng gặp giới hạn dung lượng.</p>\r\n<h2 id=\"danh-gia-iphone-16-pro-max-chip-a18-pro-man-hinh-lon\"><strong>Đ&aacute;nh gi&aacute; iPhone 16 Pro Max: Chip A18 Pro, m&agrave;n h&igrave;nh lớn</strong></h2>\r\n<p>iPhone 16 Pro Max kh&ocirc;ng chỉ l&agrave;&nbsp;<a title=\"điện thoại\" href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" rel=\"noopener\"><strong>điện thoại</strong></a>&nbsp;được n&acirc;ng cấp mạnh mẽ về phần cứng m&agrave; c&ograve;n t&iacute;ch hợp h&agrave;ng loạt c&ocirc;ng nghệ mới nhằm tối ưu trải nghiệm người d&ugrave;ng. Từ chip xử l&yacute;, m&agrave;n h&igrave;nh, camera cho đến pin v&agrave; tr&iacute; tuệ nh&acirc;n tạo, tất cả đều g&oacute;p phần tạo n&ecirc;n một thiết bị cao cấp to&agrave;n diện.</p>\r\n<h3 id=\"chip-a18-pro-mang-den-hieu-nang-manh-me\"><strong>Chip A18 Pro mang đến hiệu năng mạnh mẽ</strong></h3>\r\n<p>Với chip A18 Pro, iPhone16 Pro Max dễ d&agrave;ng xử l&yacute; c&aacute;c t&aacute;c vụ nặng nhờ CPU 6 l&otilde;i với 2 l&otilde;i hiệu năng cao v&agrave; 4 l&otilde;i tiết kiệm năng lượng. GPU 6 l&otilde;i mạnh mẽ, gi&uacute;p người d&ugrave;ng thao t&aacute;c mượt m&agrave; với c&aacute;c tựa game đồ họa cao v&agrave; chỉnh sửa video 4K nhanh ch&oacute;ng.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-3_1.jpg\" alt=\"Cấu h&igrave;nh iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, Neural Engine 16 l&otilde;i c&ograve;n gi&uacute;p tăng cường đ&aacute;ng kể hiệu suất xử l&yacute; AI, n&acirc;ng cao trải nghiệm người d&ugrave;ng. Nhờ chip A18 Pro, iPhone 16 Pro Max tiết kiệm điện hiệu quả hơn, hỗ trợ thiết bị hoạt động m&aacute;t v&agrave; ổn định trong thời gian d&agrave;i.</p>\r\n<blockquote>\r\n<p>Trong c&ugrave;ng series, điện thoại&nbsp;<a title=\"iPhone 16 thường\" href=\"https://cellphones.com.vn/iphone-16.html\" target=\"_blank\" rel=\"noopener\"><strong>iPhone 16 thường</strong></a>&nbsp;(bản ti&ecirc;u chuẩn) v&agrave; iPhone 16 Plus c&oacute; sự&nbsp;<strong>kh&aacute;c biệt về con chip</strong>&nbsp;so với bản Pro v&agrave; Pro Max. Xem chi tiết th&ocirc;ng số v&agrave; gi&aacute; b&aacute;n của iPhone 16 thường 128GB ngay tại CellphoneS!</p>\r\n</blockquote>\r\n<h3 id=\"camera-sac-net-zoom-quang-hoc-den-5x\"><strong>Camera sắc n&eacute;t, zoom quang học đến 5x</strong></h3>\r\n<p>Hệ thống camera tr&ecirc;n iPhone16 Pro Max với cảm biến ch&iacute;nh 48MP c&ugrave;ng c&ocirc;ng nghệ OIS gi&uacute;p ghi lại từng chi tiết sắc n&eacute;t trong mọi điều kiện &aacute;nh s&aacute;ng. Đặc biệt, camera Telephoto 5x (12MP) c&ograve;n hỗ trợ người d&ugrave;ng chụp được chủ thể r&otilde; n&eacute;t từ khoảng c&aacute;ch xa m&agrave; kh&ocirc;ng giảm chất lượng h&igrave;nh ảnh.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-4_1.jpg\" alt=\"Camera iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, iPhone 16 Pro Max c&ograve;n sở hữu camera g&oacute;c si&ecirc;u rộng 48MP cung cấp khả năng bắt trọn khung cảnh rộng lớn với g&oacute;c nh&igrave;n 120 độ. Qua đ&oacute;, kh&aacute;ch h&agrave;ng c&ograve;n c&oacute; thể quay video chuy&ecirc;n nghiệp chuẩn 4K Dolby Vision l&ecirc;n tới 120FPS, tạo n&ecirc;n những thước phim đỉnh cao ngay tr&ecirc;n Smartphone.</p>\r\n<h3 id=\"man-hinh-lon-6-9-inch-tan-so-quet-120hz\"><strong>M&agrave;n h&igrave;nh lớn 6.9 inch, tần số qu&eacute;t 120Hz</strong></h3>\r\n<p>iPhone 16 PRM sở hữu m&agrave;n h&igrave;nh lớn hơn so với c&aacute;c phi&ecirc;n bản tiền nhiệm với k&iacute;ch thước 6.9 inch, sử dụng c&ocirc;ng nghệ Super Retina XDR OLED cho độ ph&acirc;n giải 2868 x 1320 pixel. M&agrave;n h&igrave;nh của m&aacute;y hỗ trợ tần số qu&eacute;t ProMotion 120Hz gi&uacute;p mọi thao t&aacute;c cuộn trang, chuyển cảnh diễn ra mượt m&agrave;, kh&ocirc;ng độ trễ.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-5.jpg\" alt=\"M&agrave;n h&igrave;nh iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>Ấn tượng hơn, độ s&aacute;ng tối đa tr&ecirc;n iPhone 16 Pro Max c&ograve;n l&ecirc;n tới 2000 nits, hỗ trợ hiển thị r&otilde; n&eacute;t ngay cả dưới &aacute;nh nắng trực tiếp ngo&agrave;i trời. Với m&agrave;n h&igrave;nh chất lượng cao n&agrave;y, người d&ugrave;ng dễ d&agrave;ng thưởng thức nội dung HDR sống động với độ tương phản ấn tượng 2,000,000:1.</p>\r\n<h3 id=\"thiet-ke-chat-lieu-titan-cao-cap\"><strong>Thiết kế chất liệu titan cao cấp</strong></h3>\r\n<p>Thiết kế l&agrave; điểm nổi bật tiếp theo của iPhone 16 PRM với khung viền từ chất liệu Titanium nhẹ nhưng bền chắc, vừa gi&uacute;p giảm trọng lượng vừa tăng độ bền cho m&aacute;y. Mặt sau của m&aacute;y ho&agrave;n thiện từ vật liệu k&iacute;nh mờ nh&aacute;m, gi&uacute;p hạn chế b&aacute;m bẩn v&agrave; vết v&acirc;n tay, giữ thiết bị lu&ocirc;n sang trọng, sạch sẽ.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-6_2.jpg\" alt=\"Thiết kế chất liệu titan cao cấp\" loading=\"lazy\"></p>\r\n<p>Ở ph&iacute;a trước mặt trước, iPhone 16 PRM được trang bị k&iacute;nh Ceramic Shield thế hệ mới tăng khả năng chống va đập, trầy xước cực hiệu quả. Sự kết hợp giữa khung Titan v&agrave; c&aacute;c m&agrave;u sắc như Black Titanium, White Titanium, Natural Titanium, Desert Titanium sẽ tạo n&ecirc;n vẻ ngo&agrave;i cao cấp, thời thượng cho iPhone 16 Pro Max.</p>\r\n<h3 id=\"thoi-luong-pin-den-33-tieng\"><strong>Thời lượng pin đến 33 tiếng</strong></h3>\r\n<p>Thời lượng pin vượt trội l&ecirc;n tới 33 giờ xem video li&ecirc;n tục l&agrave; một lợi thế lớn của iPhone16 Pro Max, gi&uacute;p người d&ugrave;ng thoải m&aacute;i giải tr&iacute; cả ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng lo hết pin. Thiết bị cũng hỗ trợ sạc nhanh c&ocirc;ng suất 20W, chỉ trong 30 ph&uacute;t đ&atilde; c&oacute; thể sạc đầy 50% pin.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-7.jpg\" alt=\"Thời lượng pin đến 33 tiếng\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, khả năng sạc kh&ocirc;ng d&acirc;y MagSafe l&ecirc;n tới 25W gi&uacute;p tăng tốc độ sạc tiện lợi hơn. Người d&ugrave;ng c&oacute; thể y&ecirc;n t&acirc;m mang theo iPhone 16 Pro Max cả ng&agrave;y m&agrave; kh&ocirc;ng cần lo lắng về vấn đề năng lượng.</p>\r\n<h3 id=\"apple-intelligence-thong-minh\"><strong>Apple Intelligence th&ocirc;ng minh</strong></h3>\r\n<p>T&iacute;ch hợp Apple Intelligence, iPhone 16 PRM mang tới trải nghiệm th&ocirc;ng minh v&agrave; c&aacute; nh&acirc;n h&oacute;a tối ưu. Nhờ AI, thiết bị c&oacute; khả năng tự động tối ưu hiệu suất, quản l&yacute; pin hiệu quả v&agrave; bảo vệ dữ liệu c&aacute; nh&acirc;n tốt hơn.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-8.jpg\" alt=\"Apple Intelligence th&ocirc;ng minh\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, AI cũng hỗ trợ iPhone16 Pro Max tối đa trong việc chụp ảnh, quay video với t&iacute;nh năng nhận diện cảnh vật, chỉnh m&agrave;u sắc tự nhi&ecirc;n v&agrave; sống động. Đồng thời, Apple Intelligence c&ograve;n gi&uacute;p người d&ugrave;ng thực hiện c&aacute;c t&aacute;c vụ thường xuy&ecirc;n nhanh ch&oacute;ng, n&acirc;ng cao hiệu quả c&ocirc;ng việc mỗi ng&agrave;y.</p>\r\n<h2 id=\"mua-iphone-16-pro-max-phu-hop-phong-thuy\"><strong>Mua iPhone 16 Pro Max ph&ugrave; hợp phong thủy</strong></h2>\r\n<p>Lựa chọn m&agrave;u sắc iPhone 16 Pro Max 256 GB ph&ugrave; hợp phong thủy gi&uacute;p kh&aacute;ch h&agrave;ng gia tăng may mắn, t&agrave;i lộc v&agrave; tạo năng lượng t&iacute;ch cực trong c&ocirc;ng việc, cuộc sống. Mỗi phi&ecirc;n bản m&agrave;u sắc của điện thoại đều mang &yacute; nghĩa ri&ecirc;ng biệt, đại diện cho c&aacute;c yếu tố phong thủy đặc trưng ph&ugrave; hợp với từng c&aacute; t&iacute;nh v&agrave; mệnh người d&ugrave;ng.</p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;u sắc</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>M&ocirc; tả chi tiết v&agrave; gợi &yacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Mệnh hợp phong thủy</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Đen</p>\r\n</td>\r\n<td>\r\n<p>Sang trọng, chuy&ecirc;n nghiệp, tối giản, ph&ugrave; hợp người th&iacute;ch vẻ đẹp cổ điển v&agrave; mạnh mẽ.</p>\r\n</td>\r\n<td>\r\n<p>Thủy, Mộc (biểu trưng cho sự vững ch&atilde;i, ổn định).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Trắng</p>\r\n</td>\r\n<td>\r\n<p>Tinh khiết, thanh lịch, hiện đại, mang lại cảm gi&aacute;c sạch sẽ v&agrave; tươi mới.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thủy (tượng trưng cho sự trong s&aacute;ng, may mắn).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Tự Nhi&ecirc;n</p>\r\n</td>\r\n<td>\r\n<p>Trung t&iacute;nh, độc đ&aacute;o, dễ phối, vẻ đẹp nguy&ecirc;n bản của titanium, kh&ocirc;ng qu&aacute; ph&ocirc; trương.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thủy (gi&uacute;p c&acirc;n bằng, tạo sự h&agrave;i h&ograve;a).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Sa Mạc</p>\r\n</td>\r\n<td>\r\n<p>Độc đ&aacute;o, nổi bật, c&aacute; t&iacute;nh, m&agrave;u v&agrave;ng nhạt độc đ&aacute;o, ấm &aacute;p, ph&ugrave; hợp người th&iacute;ch sự kh&aacute;c biệt.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thổ, Hỏa (biểu thị sự vững chắc, t&agrave;i lộc, năng lượng t&iacute;ch cực).</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Từ việc lựa chọn đ&uacute;ng m&agrave;u sắc, kh&aacute;ch h&agrave;ng kh&ocirc;ng chỉ thể hiện c&aacute; t&iacute;nh m&agrave; c&ograve;n tạo sự c&acirc;n bằng, thu h&uacute;t năng lượng t&iacute;ch cực theo bản mệnh. iPhone 16 Pro Max v&igrave; thế trở th&agrave;nh một m&oacute;n đồ c&ocirc;ng nghệ vừa tinh tế, vừa mang &yacute; nghĩa phong thủy ph&ugrave; hợp với từng người d&ugrave;ng.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-9.jpg\" alt=\"Mua iPhone 16 Pro Max ph&ugrave; hợp phong thủy\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-iphone-16-promax-tra-gop-0-lai-tai-cellphones-ngay\"><strong>Mua iPhone 16 Promax trả g&oacute;p 0% l&atilde;i tại CellphoneS ngay</strong></h2>\r\n<p>Kh&aacute;ch h&agrave;ng muốn sở hữu iPhone 16 Pro Max nhưng ngại vấn đề t&agrave;i ch&iacute;nh c&oacute; thể dễ d&agrave;ng mua trả g&oacute;p 0% l&atilde;i tại CellphoneS. Với hơn 100 cửa h&agrave;ng tr&ecirc;n to&agrave;n quốc, CellphoneS cam kết cung cấp sản phẩm ch&iacute;nh h&atilde;ng, bảo h&agrave;nh minh bạch. Ch&iacute;nh s&aacute;ch trả g&oacute;p linh hoạt, duyệt nhanh trong ng&agrave;y gi&uacute;p kh&aacute;ch h&agrave;ng sở hữu sản phẩm dễ d&agrave;ng, kh&ocirc;ng &aacute;p lực t&agrave;i ch&iacute;nh. Gh&eacute; tới CellphoneS ngay để trải nghiệm mua sắm thuận tiện khi chọn mua iPhone 16 PRM!&nbsp;</p>\r\n</div>\r\n</div>', 'uploads/689a4116be517_iPhone 16 Pro Max 256GB.webp', 9, 13, '2025-08-05 17:47:20', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>6.9 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera sau</td>\r\n<td>\r\n<p>Camera ch&iacute;nh: 48MP</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera trước</td>\r\n<td>\r\n<p>12MP, &fnof;/1.9, Tự động lấy n&eacute;t theo pha Focus Pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Chipset</td>\r\n<td>\r\n<p>Apple A18 Pro</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ NFC</td>\r\n<td>\r\n<p>C&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Bộ nhớ trong</td>\r\n<td>\r\n<p>256 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Thẻ SIM</td>\r\n<td>\r\n<p>Sim k&eacute;p (nano-Sim v&agrave; e-Sim) - Hỗ trợ 2 e-Sim</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>iOS 18</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>2868 x 1320 pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>T&iacute;nh năng m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Dynamic Island<br>M&agrave;n h&igrave;nh HDR<br>True Tone<br>Dải m&agrave;u rộng (P3)<br>Haptic Touch<br>Tỷ lệ tương phản 2.000.000:1</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>CPU 6 l&otilde;i mới với 2 l&otilde;i hiệu năng v&agrave; 4 l&otilde;i hiệu suất</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0);
INSERT INTO `products` (`id`, `name`, `price`, `discount`, `description`, `image_url`, `category_id`, `supplier_id`, `created_at`, `content`, `isDeleted`) VALUES
(30, 'Laptop Dell Gaming G15 5530 i7 13650HX', 35290000.00, 16.00, '<div class=\"ProductContent_description-container__miT3z\">\r\n<p class=\"MsoNormal\">Một chiếc laptop chơi game 15 inch thời trang v&agrave; s&agrave;nh điệu, <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/dell-gaming-g15-5530-71053700\"><strong>Dell Gaming G15 5530</strong></a> được thiết kế để mang lại hiệu suất c&ugrave;ng phong c&aacute;ch ấn tượng. Sức mạnh từ bộ vi xử l&yacute; Intel Core i7 13650HX, card đồ họa RTX 3050 v&agrave; c&aacute;c t&iacute;nh năng tối ưu cho game độc quyền từ Dell sẽ gi&uacute;p bạn khai ph&aacute; hết sức mạnh, tập trung tối đa năng lượng cho c&ocirc;ng việc cũng như chơi game.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_6_8010ea238d.jpg\" alt=\"Dell-Gaming-G15-6.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Bộ vi xử l&yacute; i7-13650HX mạnh mẽ, sẵn s&agrave;ng chiến game</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 sở hữu Intel&reg; Core&trade; i7-13650HX thế hệ 13, con chip mạnh mẽ đủ để gi&uacute;p bạn l&agrave;m mọi thứ ưng &yacute;. Với 14 nh&acirc;n, 20 luồng, tốc độ tối đa 4.9GHz, CPU n&agrave;y xử l&yacute; mượt m&agrave; c&aacute;c game nặng như Cyberpunk 2077 hoặc Far Cry 6 ở thiết lập đồ họa trung b&igrave;nh đến cao. Game thủ sẽ thấy mọi cảnh trong game h&agrave;nh động đều diễn ra trơn tru, kh&ocirc;ng lo giật lag. Nếu bạn l&agrave;m s&aacute;ng tạo, i7-13650HX chạy tốt c&aacute;c phần mềm như Adobe After Effects để dựng video hoặc Blender để l&agrave;m m&ocirc; h&igrave;nh 3D. D&acirc;n văn ph&ograve;ng c&oacute; thể thoải m&aacute;i mở nhiều ứng dụng, từ Excel với bảng t&iacute;nh lớn, Zoom họp trực tuyến, đến Chrome với h&agrave;ng chục tab m&agrave; m&aacute;y vẫn chạy &ecirc;m &aacute;i.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_4_01ffe0861e.jpg\" alt=\"Dell-Gaming-G15-4.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Tận hưởng game đồ họa cao v&agrave; l&agrave;m nội dung chuy&ecirc;n nghiệp với card RTX 3050</strong></h2>\r\n<p class=\"MsoNormal\">Card đồ họa NVIDIA&reg; GeForce RTX&trade; 3050 6GB GDDR6 l&agrave; điểm nhấn quan trọng tr&ecirc;n Laptop Dell Gaming G15 5530. C&ocirc;ng nghệ Ray Tracing mang đến &aacute;nh s&aacute;ng, b&oacute;ng đổ sống động, khiến c&aacute;c game như Battlefield V hoặc God of War đẹp như phim. C&ocirc;ng nghệ DLSS 2.0 tăng khung h&igrave;nh mỗi gi&acirc;y, gi&uacute;p bạn chơi c&aacute;c game fps như Call of Duty: Warzone mượt m&agrave; ở thiết lập đồ họa tương đối cao. Ngo&agrave;i chơi game, RTX 3050 c&ograve;n hỗ trợ tốt c&aacute;c c&ocirc;ng việc s&aacute;ng tạo, từ chỉnh sửa video tr&ecirc;n Premiere Pro, l&agrave;m ảnh tr&ecirc;n Photoshop, Lightroom cho đến render đồ họa cơ bản. Với sức mạnh n&agrave;y, Laptop Dell Gaming G15 5530 đ&aacute;p ứng tốt cả nhu cầu giải tr&iacute; lẫn c&ocirc;ng việc chuy&ecirc;n s&acirc;u.</p>\r\n<h2 class=\"MsoNormal\"><strong>RAM 16GB DDR5 v&agrave; SSD 512GB tăng tốc to&agrave;n diện</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 sở hữu 16GB RAM DDR5 4800MHz v&agrave; 512GB M.2 PCIe NVMe SSD, mang đến hiệu suất mượt m&agrave; v&agrave; khả năng lưu trữ thoải m&aacute;i. RAM DDR5 nhanh hơn nhiều so với DDR4, gi&uacute;p bạn chơi Valorant, stream tr&ecirc;n OBS Studio, đồng thời chỉnh sửa ảnh tr&ecirc;n Lightroom m&agrave; m&aacute;y vẫn chạy ổn. SSD 512GB cho tốc độ khởi động Windows, tải game nhanh ch&oacute;ng chỉ trong v&agrave;i gi&acirc;y, c&ugrave;ng kh&ocirc;ng gian đủ để lưu game, video, t&agrave;i liệu c&ocirc;ng việc. Game thủ, nh&agrave; s&aacute;ng tạo, d&acirc;n văn ph&ograve;ng đều được sẽ được hưởng lợi từ tốc độ, khiến Laptop Dell Gaming G15 5530 trở th&agrave;nh cỗ m&aacute;y đa nhiệm l&yacute; tưởng.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_2_e32fba41dc.jpg\" alt=\"Dell-Gaming-G15-2.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Thiết kế gaming c&aacute; t&iacute;nh, dễ d&agrave;ng mang theo</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 phi&ecirc;n bản m&agrave;u Dark Shadow Grey với logo Dell nổi bật, đậm chất gaming. Kiểu d&aacute;ng đặc trưng từ d&ograve;ng Dell Gaming tạo n&ecirc;n điểm nhấn ấn tượng khiến Dell G15 kh&ocirc;ng bị nh&agrave;m ch&aacute;n như hầu hết đối thủ tr&ecirc;n thị trường. <a href=\"https://fptshop.com.vn/phu-kien/ban-phim\">B&agrave;n ph&iacute;m</a> RGB 4 v&ugrave;ng đẹp mắt, g&otilde; thoải m&aacute;i, t&iacute;ch hợp b&agrave;n ph&iacute;m số tiện cho c&ocirc;ng việc t&iacute;nh to&aacute;n. Hệ thống tản nhiệt lấy cảm hứng từ Alienware giữ m&aacute;y m&aacute;t khi chơi game nặng. Touchpad rộng, mượt m&agrave;, hỗ trợ thao t&aacute;c nhanh. Thiết kế n&agrave;y gi&uacute;p Laptop Dell Gaming G15 5530 vừa đẹp, vừa thực dụng, lại kh&ocirc;ng k&eacute;m phần phong c&aacute;ch.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_5_0cb9d659f3.jpg\" alt=\"Dell-Gaming-G15-5.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Tăng tốc lập tức chỉ bằng một ph&iacute;m bấm</strong></h2>\r\n<p class=\"MsoNormal\">Khi cần sức mạnh ngay tức th&igrave; để giải quyết những pha combat căng thẳng hoặc xử l&yacute; t&aacute;c vụ nặng, chỉ một lần nhấn ph&iacute;m F9 tr&ecirc;n Dell Gaming G15 l&agrave; đủ. Đ&acirc;y kh&ocirc;ng chỉ l&agrave; một ph&iacute;m chức năng th&ocirc;ng thường m&agrave; c&ograve;n l&agrave; ph&iacute;m macro Game Shift, cho ph&eacute;p đẩy quạt l&ecirc;n tốc độ tối đa. Khi đ&oacute;, hệ thống sẽ tự động k&iacute;ch hoạt chế độ Dynamic Performance Mode, CPU chuyển sang trạng th&aacute;i hiệu năng cao để gi&uacute;p bạn vượt qua c&aacute;c ph&acirc;n cảnh game nặng hoặc xử l&yacute; những c&ocirc;ng việc đ&ograve;i hỏi hiệu suất t&iacute;nh to&aacute;n khắt khe. Kh&ocirc;ng cần tho&aacute;t game, kh&ocirc;ng cần mở menu phụ, mọi thứ chỉ g&oacute;i gọn trong một thao t&aacute;c.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_3_7595134139.jpg\" alt=\"Dell-Gaming-G15-3.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Hệ thống tản nhiệt lấy cảm hứng từ Alienware</strong></h2>\r\n<p class=\"MsoNormal\">Thiết kế tản nhiệt tr&ecirc;n d&ograve;ng Dell G15 được kế thừa từ c&aacute;c d&ograve;ng m&aacute;y Alienware cao cấp. Với bốn ống đồng dẫn nhiệt, hệ thống quạt được tinh chỉnh lại bằng c&aacute;c c&aacute;nh si&ecirc;u mỏng, diện t&iacute;ch trao đổi nhiệt sẽ được mở rộng đ&aacute;ng kể. Tản nhiệt tốt kh&ocirc;ng chỉ gi&uacute;p m&aacute;y bền bỉ qua thời gian m&agrave; c&ograve;n đảm bảo hiệu năng lu&ocirc;n được duy tr&igrave; ổn định.</p>\r\n<h2 class=\"MsoNormal\"><strong>T&ugrave;y chỉnh mọi thứ nhờ Alienware Command Center</strong></h2>\r\n<p class=\"MsoNormal\">Với Alienware Command Center phi&ecirc;n bản mới, bạn c&oacute; to&agrave;n quyền kiểm so&aacute;t chiếc <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/dell-gaming-g-series\">laptop Dell Gaming</a> của m&igrave;nh. Những preset hiệu năng c&oacute; sẵn gi&uacute;p tối ưu tr&ograve; chơi theo phong c&aacute;ch bạn muốn, trong khi khả năng &eacute;p xung mở ra lựa chọn để đẩy hệ thống l&ecirc;n mức tốc độ cao hơn nữa. Bạn cũng c&oacute; thể bật lớp hiển thị th&ocirc;ng tin trực tiếp tr&ecirc;n <a href=\"https://fptshop.com.vn/man-hinh\">m&agrave;n h&igrave;nh</a>, bao gồm hiệu suất CPU, GPU, bộ nhớ hay nhiệt độ m&agrave; kh&ocirc;ng cần tho&aacute;t khỏi game. Đ&egrave;n LED RGB c&oacute; thể t&ugrave;y chỉnh linh hoạt theo từng v&ugrave;ng hoặc đồng bộ với c&aacute;c thiết bị ngoại vi Alienware kh&aacute;c. Với Vision Engine, c&aacute;c lớp hiển thị hỗ trợ sẽ xuất hiện đ&uacute;ng l&uacute;c, gi&uacute;p bạn giữ được sự tập trung tối đa trong c&aacute;c pha xử l&yacute;.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_1_34c804a365.jpg\" alt=\"Dell-Gaming-G15-1.jpg\" loading=\"lazy\"></p>\r\n</div>', 'uploads/68989b54badd9_Laptop Dell Gaming G15 5530 i7 13650HX.webp', 1, 2, '2025-08-06 04:52:20', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>NVIDIA GeForce RTX 4060, 8GB GDDR6</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại RAM</td>\r\n<td>\r\n<p>DDR5 4800MHz</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Số khe ram</td>\r\n<td>\r\n<p>2 khe (2x 8GB, n&acirc;ng cấp tối đa 32GB)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>1TB M.2 PCIe NVMe SSD</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>15.6 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>ComfortViewPlus <br>NVIDIA GSYNC+ DDS Display</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Pin</td>\r\n<td>\r\n<p>Pin liền,6-Cell Battery, 86WHr (Integrated), 330W</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>Windows 11 Home + Office Home &amp; Student 2021</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>1920 x 1080 pixels (FullHD)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Intel Core i7-13650HX (24MB Cache, Turbo Boost 4.7 GHz)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(31, 'Apple Watch Ultra 2 2024 49mm 4G Viền Titan', 25990000.00, 1.00, '<div id=\"cpsContentSEO\">\r\n<h2 id=\"apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-ngoai-hinh-sang-trong-cong-nghe-dinh-cao\"><strong> Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan - Ngoại h&igrave;nh sang trọng, c&ocirc;ng nghệ đỉnh cao </strong></h2>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan l&agrave; phi&ecirc;n bản cao cấp trong d&ograve;ng smartwatch của Apple với h&agrave;ng hoạt điểm ấn tượng. Sở hữu khung viền titan v&agrave; c&aacute;c c&ocirc;ng nghệ vượt bậc, đồng hồ <a title=\"Apple Watch Ultra 2\" href=\"https://cellphones.com.vn/do-choi-cong-nghe/apple-watch/ultra-2.html\" target=\"_blank\" rel=\"noopener\"><strong>Apple Watch Ultra 2</strong></a> kh&ocirc;ng những đem đến sự tiện lợi m&agrave; c&ograve;n l&agrave; biểu tượng của vẻ đẹp sang trọng.</p>\r\n<h3 id=\"duong-kinh-mat-lon-49mm-man-hinh-retina-ltpo2-oled\"><strong> Đường k&iacute;nh mặt lớn 49mm, m&agrave;n h&igrave;nh Retina LTPO2 OLED </strong></h3>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan sở hữu đường k&iacute;nh mặt đồng hồ 49mm, đem đến trải nghiệm sử dụng ấn tượng. Thiết bị n&agrave;y sử dụng m&agrave;n h&igrave;nh Retina LTPO2 OLED, hiển thị sắc n&eacute;t 410 x 502 pixels c&ugrave;ng độ s&aacute;ng l&ecirc;n tới 3000 nits. Mặt k&iacute;nh được ho&agrave;n thiện từ Sapphire cứng c&aacute;p, ngăn trầy xước v&agrave; tăng độ bền cho sản phẩm khi sử dụng trong c&aacute;c m&ocirc;i trường khắc nghiệt.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Watch/Apple/Ultra-2/apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-3.jpg\" alt=\"M&agrave;n h&igrave;nh Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan\" loading=\"lazy\"></p>\r\n<h3 id=\"vien-va-day-deo-titan-manh-me-hang-loat-tinh-nang-uu-viet\"><strong> Viền v&agrave; d&acirc;y đeo Titan mạnh mẽ, h&agrave;ng loạt t&iacute;nh năng ưu việt </strong></h3>\r\n<p>Khung viền của Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan được l&agrave;m từ Titanium - chất liệu si&ecirc;u nhẹ nhưng cực kỳ bền. B&ecirc;n cạnh đ&oacute; l&agrave; d&acirc;y đeo Titan của đồng hồ kh&ocirc;ng những nổi bật về độ bền m&agrave; c&ograve;n mang lại vẻ ngo&agrave;i mạnh mẽ v&agrave; hiện đại. Đồng hồ cũng g&acirc;y ấn tượng với lượng pin lớn v&agrave; h&agrave;ng loạt t&iacute;nh năng, từ theo d&otilde;i chỉ số cơ thể,...</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Watch/Apple/Ultra-2/apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-2.jpg\" alt=\"D&acirc;y đeo Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-ngay-apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-chinh-hang-voi-gia-sieu-uu-dai-tai-cellphones\"><strong> Mua ngay Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan ch&iacute;nh h&atilde;ng với gi&aacute; si&ecirc;u ưu đ&atilde;i tại CellphoneS </strong></h2>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan l&agrave; chiếc smartwatch mang vẻ đẹp mạnh mẽ, đ&aacute;ng đầu tư cho c&aacute;c t&iacute;n đồ c&ocirc;ng nghệ. Hiện nay, chiếc đồng hồ đẳng cấp n&agrave;y đang được ph&acirc;n phối ch&iacute;nh h&atilde;ng tại CellphoneS - hệ thống b&aacute;n lẻ h&agrave;ng đầu thị trường Việt. Tại đ&acirc;y, CellphoneS sẽ cung cấp Apple Watch Ultra 2 2024 49mm với chất lượng đảm bảo, gi&aacute; si&ecirc;u hấp dẫn nhờ &aacute;p dụng nhiều ưu đ&atilde;i.</p>\r\n</div>', 'uploads/689897bd3addf_Apple Watch Ultra 2 2024 49mm 4G Viền Titan.webp', 7, 13, '2025-08-06 13:43:52', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Retina LTPO2 OLED<br>Độ s&aacute;ng 3000 nit</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>1185 mm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Đường k&iacute;nh mặt</td>\r\n<td>\r\n<p>49 mm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước cổ tay ph&ugrave; hợp</td>\r\n<td>\r\n<p>15.5 &ndash; 18.5 cm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Thời lượng pin</td>\r\n<td>\r\n<p>L&ecirc;n đến 36 giờ khi sử dụng b&igrave;nh thường<br>L&ecirc;n đến 72 giờ ở Chế Độ Nguồn Điện Thấp</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>H&atilde;ng sản xuất</td>\r\n<td>\r\n<p>Apple Ch&iacute;nh h&atilde;ng</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(32, 'iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB', 39990000.00, 1.00, '<div id=\"cpsContentSEO\">\r\n<h2 id=\"imac-m4-2024-10gpu-16gb-256gb-thiet-ke-sieu-mong-hieu-nang-manh-me\"><strong> iMac M4 2024 10GPU 16GB 256GB - Thiết kế si&ecirc;u mỏng, hiệu năng mạnh mẽ </strong></h2>\r\n<p>iMac M4 2024 10GPU 16GB 256GB mang đến ngoại h&igrave;nh bắt mắt c&ugrave;ng hiệu năng vượt trội khi t&iacute;ch hợp chip M4 ti&ecirc;n tiến. Đặc biệt hơn, d&ograve;ng <a title=\"iMac ch&iacute;nh h&atilde;ng\" href=\"https://cellphones.com.vn/laptop/mac/imac.html\" target=\"_blank\" rel=\"noopener\"><strong>iMac</strong></a> của nh&agrave; Apple c&ograve;n nổi bật với c&ocirc;ng nghệ Apple Intelligence sở hữu nhiều tiện &iacute;ch độc quyền. Với camera chất lượng cao, iMac hỗ trợ người d&ugrave;ng họp trực tuyến v&ocirc; c&ugrave;ng hiệu quả.&nbsp;</p>\r\n<h3 id=\"tich-hop-chip-m4-tien-tien-cung-cong-nghe-apple-intelligence-doc-quyen\"><strong> T&iacute;ch hợp chip M4 ti&ecirc;n tiến c&ugrave;ng c&ocirc;ng nghệ Apple Intelligence độc quyền </strong></h3>\r\n<p>Đi k&egrave;m với con chip M4 ti&ecirc;n tiến, d&ograve;ng sản phẩm iMac của thương hiệu Apple sở hữu sức mạnh nhanh hơn đến 2,1 lần so với iMac d&ugrave;ng chip M1 trước đ&oacute;. Cấu tr&uacute;c của con chip gồm 10 l&otilde;i CPU v&agrave; 10 l&otilde;i GPU đảm bảo mọi t&aacute;c vụ đồ họa của bạn đều được xử l&yacute; mượt m&agrave;.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-3.jpg\" alt=\"Cấu h&igrave;nh iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, iMac c&ograve;n t&iacute;ch hợp c&ocirc;ng nghệ Apple Intelligence mang đến nhiều tiện &iacute;ch như hiệu đ&iacute;nh văn bản, hỗ trợ viết l&aacute;ch, tạo những h&igrave;nh ảnh vui nhộn,... Ưu điểm nổi bật của Apple Intelligence l&agrave; bảo vệ quyền ri&ecirc;ng tư của người d&ugrave;ng tối đa n&ecirc;n bạn c&oacute; thể y&ecirc;n t&acirc;m về những th&ocirc;ng tin c&aacute; nh&acirc;n của m&igrave;nh.</p>\r\n<p>B&ecirc;n trong của <strong><a href=\"https://cellphones.com.vn/bo-loc/imac-m4\" target=\"_blank\" rel=\"noopener\">iMac M4</a></strong> l&agrave; bộ nhớ RAM đạt đến 16GB hỗ trợ đa nhiệm nhiều t&aacute;c vụ mượt m&agrave;. Đi k&egrave;m với iMac l&agrave; ổ cứng SSD với khả năng lưu trữ dung lượng đến 256GB. Với ổ cứng dung lượng lớn, bạn c&oacute; thể thoải m&aacute;i lưu trữ mọi thiết kế đồ họa của m&igrave;nh m&agrave; kh&ocirc;ng bị tr&agrave;n bộ nhớ.&nbsp;</p>\r\n<h3 id=\"man-hinh-retina-sac-net-voi-hon-nhieu-gam-mau-song-dong\"><strong> M&agrave;n h&igrave;nh Retina sắc n&eacute;t với hơn nhiều gam m&agrave;u sống động </strong></h3>\r\n<p>iMac của nh&agrave; Apple sở hữu m&agrave;n h&igrave;nh Retina bắt mắt với khung h&igrave;nh 4,5K sắc n&eacute;t. Kết hợp với đ&oacute; l&agrave; dải m&agrave;u rộng P3 đảm bảo mọi nội dung hiển thị tr&ecirc;n m&agrave;n h&igrave;nh trở n&ecirc;n sống động v&agrave; rực rỡ với hơn 1 tỷ gam m&agrave;u.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-1.jpg\" alt=\"M&agrave;n h&igrave;nh iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Đặc biệt hơn, m&agrave;n h&igrave;nh của iMac M4 c&ograve;n mang đến độ s&aacute;ng đạt đến 500nits gi&uacute;p bạn c&oacute; thể quan s&aacute;t r&otilde; mọi chi tiết tr&ecirc;n khung h&igrave;nh trong mọi điều kiện &aacute;nh s&aacute;ng. C&ocirc;ng nghệ True Tone c&oacute; tr&ecirc;n m&agrave;n h&igrave;nh hỗ trợ tự động điều chỉnh độ s&aacute;ng ph&ugrave; hợp với m&ocirc;i trường xung quanh đảm bảo người d&ugrave;ng kh&ocirc;ng bị mỏi mắt khi sử dụng.&nbsp;</p>\r\n<h3 id=\"kieu-dang-sieu-mong-nhieu-gam-mau-ruc-ro\"><strong> Kiểu d&aacute;ng si&ecirc;u mỏng, nhiều gam m&agrave;u rực rỡ </strong></h3>\r\n<p>D&ograve;ng iMac của thương hiệu Apple được ưa chuộng ở kiểu d&aacute;ng si&ecirc;u mỏng n&ecirc;n bạn c&oacute; thể lắp đặt trong mọi kh&ocirc;ng gian l&agrave;m việc. Chiếc iMac cũng mang đến nhiều phi&ecirc;n bản m&agrave;u đa dạng bao gồm cam, bạc, xanh dương, t&iacute;m, xanh l&aacute;, hồng v&agrave; v&agrave;ng. Mặt trước của iMac được bao phủ bởi mặt k&iacute;nh Nano‑texture cao cấp hỗ trợ duy tr&igrave; chất lượng h&igrave;nh ảnh sắc n&eacute;t.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-2.jpg\" alt=\"Thiết kế iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Phần tr&ecirc;n của chiếc iMac được trang bị camera 12MP với t&iacute;nh năng tập trung v&agrave;o người d&ugrave;ng l&agrave;m t&acirc;m điểm. Nhờ v&agrave;o đ&oacute;, mọi khung h&igrave;nh của bạn lu&ocirc;n được sắc n&eacute;t v&agrave; n&acirc;ng cao hiệu quả c&aacute;c cuộc gọi video hay họp trực tuyến.&nbsp;</p>\r\n<p>&gt;&gt;&gt; Xem th&ecirc;m mẫu&nbsp;<a href=\"https://cellphones.com.vn/imac-m4-2024-24-inch-10cpu-10gpu-16gb-512gb.html\" target=\"_blank\" rel=\"noopener\">iMac M4 2024 24 inch 10CPU 10GPU 16GB 512GB</a> mới gi&aacute; cực tốt c&ugrave;ng nhiều ưu đ&atilde;i hấp dẫn.</p>\r\n<h3 id=\"ho-tro-lien-ket-nhieu-thiet-bi-linh-hoat-va-truyen-tai-noi-dung-nhanh-chong\"><strong> Hỗ trợ li&ecirc;n kết nhiều thiết bị linh hoạt v&agrave; truyền tải nội dung nhanh ch&oacute;ng </strong></h3>\r\n<p>Thế hệ iMac M4 nổi bật với t&iacute;nh năng truyền tải nội dung từ iPhone l&ecirc;n m&agrave;n h&igrave;nh 24 inch gi&uacute;p bạn quan s&aacute;t khung h&igrave;nh của m&igrave;nh r&otilde; hơn. Đi k&egrave;m theo đ&oacute; l&agrave; cổng Thunderbolt 4 hỗ trợ sao ch&eacute;p dữ liệu nhanh ch&oacute;ng giữa c&aacute;c thiết bị c&ocirc;ng nghệ. C&ocirc;ng nghệ Wifi 6E c&ograve;n mang đến tốc độ truyền tệp tin mượt m&agrave; v&agrave; ổn định.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-4.jpg\" alt=\"Kết nối iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, bạn c&ograve;n c&oacute; thể tận dụng c&aacute;c cổng Thunderbolt 4 để li&ecirc;n kết với 2 m&agrave;n h&igrave;nh nhằm mở rộng kh&ocirc;ng gian l&agrave;m việc của m&igrave;nh. iMac c&ograve;n đi k&egrave;m với b&agrave;n ph&iacute;m Magic v&agrave; chuột với c&aacute;c t&iacute;nh năng như mở kh&oacute;a Touch ID nhanh ch&oacute;ng, sử dụng Apple Pay tiện lợi,...</p>\r\n<h2 id=\"mua-ngay-imac-m4-2024-10gpu-16gb-256gb-chinh-hang-tai-cellphones\"><strong> Mua ngay iMac M4 2024 10GPU 16GB 256GB ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>iMac M4 2024 10GPU 16GB 256GB nổi bật với kiểu d&aacute;ng bắt mắt c&ugrave;ng hiệu năng mạnh mẽ hỗ trợ xử l&yacute; mọi t&aacute;c vụ đồ họa nhanh ch&oacute;ng. Khi đặt mua iMac M4 ch&iacute;nh h&atilde;ng tại CellphoneS, bạn sẽ được khuyến m&atilde;i v&ocirc; c&ugrave;ng hấp dẫn d&agrave;nh cho Smember. Chọn mua ngay iMac M4 tại CellphoneS bạn nh&eacute;.&nbsp;</p>\r\n</div>', 'uploads/6898945290456_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB.webp', 6, 13, '2025-08-06 13:44:47', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>GPU 10 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>256GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>24 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>M&agrave;n h&igrave;nh Retina 4.5K<br>1 tỷ m&agrave;u<br>Độ s&aacute;ng 500 nit<br>Dải m&agrave;u rộng (P3)<br>C&ocirc;ng nghệ True Tone</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>4480 x 2520 (4.5K)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Apple M4 10 l&otilde;i với 4 l&otilde;i hiệu năng v&agrave; 6 l&otilde;i tiết kiệm điện<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(34, 'Mac mini M4 2024 10CPU 10GPU 16GB 256GB', 14990000.00, 1.00, '<p>Mac mini M4 2024 16GB 256GB sở hữu thiết kế nhỏ gọn với c&aacute;c cổng thiết kế mặt trước v&agrave; sau sử dụng tiện lợi. Về cấu h&igrave;nh, d&ograve;ng <a title=\"Mac mini ch&iacute;nh h&atilde;ng\" href=\"https://cellphones.com.vn/laptop/mac/mini.html\" target=\"_blank\" rel=\"noopener\"><strong>Mac mini</strong></a> n&agrave;y sở hữu cấu h&igrave;nh mạnh với chip M4 c&ugrave;ng với đ&oacute; l&agrave; sự hỗ trợ bởi Apple Intelligence th&ocirc;ng minh.</p>\r\n<div id=\"cpsContentSEO\">\r\n<h2 id=\"mac-mini-m4-2024-16gb-256gb--cau-hinh-vuot-troi-dap-ung-da-dang-nhu-cau\"><strong> Mac mini M4 2024 16GB 256GB &ndash; Cấu h&igrave;nh vượt trội, đ&aacute;p ứng đa dạng nhu cầu </strong></h2>\r\n<p>Mac mini M4 2024 16GB 256GB l&agrave; thế hệ mac mini mới với thiết kế c&ugrave;ng cấu h&igrave;nh được cải tiến. Thế hệ Mac n&agrave;y c&ograve;n được t&iacute;ch hợp AI th&ocirc;ng minh, n&acirc;ng cao hiệu năng sử dụng, vậy ch&iacute;nh x&aacute;c sản phẩm ra sao th&igrave; h&atilde;y c&ugrave;ng t&igrave;m hiểu sau đ&acirc;y.</p>\r\n<h3 id=\"thiet-ke-nho-cong-ket-noi-hai-mat-truoc-va-sau\"><strong> Thiết kế nhỏ, cổng kết nối hai mặt trước v&agrave; sau </strong></h3>\r\n<p>Mac mini M4 2024 16GB 256GB dược trang bị một thiết kế mới với vẻ ngo&agrave;i nhỏ gọn một c&aacute;ch ấn tượng. Với k&iacute;ch thước 5x5 inch, sản phẩm chỉ bằng 1/20 k&iacute;ch thước c&aacute;c d&ograve;ng m&aacute;y t&iacute;nh để b&agrave;n c&ugrave;ng tầm gi&aacute; nhưng lại cho hiệu năng đến 6x.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-2.jpg\" alt=\"Thiết kế Mac mini M4 2024 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Tuy nhỏ gọn những sản phẩm <strong><a title=\"Mac Mini M4\" href=\"https://cellphones.com.vn/bo-loc/mac-mini-m4-series\" target=\"_blank\" rel=\"noopener\">Mac Mini M4</a></strong> n&agrave;y vẫn được trang bị c&aacute;c cổng kết nối để tối ưu qu&aacute; tr&igrave;nh sử dụng của người sử dụng ở cả hai mặt trước v&agrave; sau. Cụ thể, ở ph&iacute;a trước imac sở hữu 2 cổng USB-C v&agrave; jack tai nghe trong khi đ&oacute; mặt sau l&agrave; cổng Ethernet, cổng thunderbolt 4 v&agrave; cổng HDMI. Người d&ugrave;ng c&oacute; thể kết nối iMac với nhiều phụ kiện như b&agrave;n ph&iacute;m, tai nghe, chuột, m&agrave;n h&igrave;nh để đảm bảo hiệu suất c&ocirc;ng việc.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-1.jpg\" alt=\"Thiết kế Mac mini M4 2024 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>C&ugrave;ng với đ&oacute;, b&ecirc;n trong một thiết kế nhỏ gọn n&agrave;y, Apple c&ograve;n trang bị cho thiết bị hệ thống tản nhiệt chất lượng. Nhờ hệ thống n&agrave;y, kh&ocirc;ng kh&iacute; được dẫn qua nhiều tầng v&agrave; tho&aacute;t qua phần đầy gi&uacute;p giải tỏa nhiệt lượng hiệu quả.</p>\r\n<h3 id=\"hoat-dong-manh-me-voi-chip-m4-cung-ai\"><strong> Hoạt động mạnh mẽ với chip M4 c&ugrave;ng AI </strong></h3>\r\n<p>Mac mini M4 2024 16GB 256GB với phần cứng từ con chip M4 mạnh mẽ nhờ đ&oacute; mang lại một hiệu năng vượt trội. C&ugrave;ng với AI th&ocirc;ng minh, người d&ugrave;ng c&oacute; thể sử dụng iMac M4 để thực hiện c&aacute;c c&ocirc;ng việc s&aacute;ng tạo như chỉnh sửa video Final&nbsp;Cut&nbsp;Pro hay thiết kế với Adobe Photoshop. Hay c&aacute;c c&ocirc;ng việc lập tr&igrave;nh với imac mini m4 n&agrave;y cũng được thực hiện với khả năng bi&ecirc;n dịch m&atilde; nhanh. C&ugrave;ng với đ&oacute; sản phẩm cũng tối ưu cho c&aacute;c tr&ograve; chơi như Prince of Persia: The Lost Crown. Đặc biệt c&ocirc;ng nghệ d&ograve; tia phần cứng với tốc độ cao c&ograve;n tối ưu c&aacute;c hiệu năng &aacute;nh s&aacute;ng, h&igrave;nh ảnh phản chiếu,&hellip;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-3.jpg\" alt=\"Hoạt động mạnh mẽ với chip M4 c&ugrave;ng AI\" loading=\"lazy\"></p>\r\n<p>Đặc biệt tr&ecirc;n th&ecirc; hệ Mac mini M4 2024 16GB 256GB đ&oacute; ch&iacute;nh l&agrave; Apple Intelligence. Đ&acirc;y l&agrave; hệ thống tr&iacute; tuệ nh&acirc;n tạo hỗ trợ người d&ugrave;ng viết l&aacute;ch hay sắp xếp thứ tự c&ocirc;ng việc. Nhờ đ&oacute; tối ưu hiệu suất l&agrave;m việc, gi&uacute;p người d&ugrave;ng sử dụng c&oacute; thể ho&agrave;n th&agrave;nh được c&ocirc;ng việc một c&aacute;ch dễ d&agrave;ng hơn.</p>\r\n<h2 id=\"mua-mac-mini-m4-2024-16gb-256gb-chinh-hang-tai-cellphones\"><strong> Mua Mac mini M4 2024 16GB 256GB ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>Mac mini M4 2024 16GB 256GB sở hữu một cấu h&igrave;nh mạnh b&ecirc;n trong một thiết kế nhỏ gọn. Đ&acirc;y l&agrave; một thiết bị đ&aacute;ng để sở hữu nhờ hiệu năng vượt trội cũng như AI th&iacute;ch hợp. Nếu quan t&acirc;m đến d&ograve;ng Mac mini mới của Apple n&agrave;y, h&atilde;y đến v&agrave; mua tại CellphoneS. Tại đ&acirc;y, kh&aacute;ch h&agrave;ng sẽ được mua trả g&oacute;p với ưu đ&atilde;i hấp dẫn cũng như đa dạng chương tr&igrave;nh thanh to&aacute;n lựa chọn.</p>\r\n</div>', 'uploads/68989327e3c4f_Mac mini M4 2024 10CPU 10GPU 16GB 256GB.webp', 1, 13, '2025-08-06 13:46:36', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>GPU 10 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>256GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Hỗ trợ đồng thời đến ba m&agrave;n h&igrave;nh<br>Đầu ra video kỹ thuật số Thunderbolt 4</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Apple M4 10 l&otilde;i với 4 l&otilde;i hiệu năng v&agrave; 6 l&otilde;i tiết kiệm điện<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Cổng giao tiếp</td>\r\n<td>\r\n<p>Mặt trước:<br>Hai cổng USB‑C hỗ trợ cho USB 3 (l&ecirc;n đến 10Gb/s) <br>Jack cắm tai nghe 3,5 mm<br>Mặt sau (M4): <br>Cổng Gigabit Ethernet (c&oacute; thể lựa chọn cấu h&igrave;nh Ethernet 10Gb)<br>Cổng HDMI<br>Thunderbolt 4 (l&ecirc;n đến 40Gb/s) <br>USB 4 (l&ecirc;n đến 40Gb/s)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(36, 'MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB ', 93790000.00, 2.00, '<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<p><strong>MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong>&nbsp;l&agrave; si&ecirc;u phẩm c&ocirc;ng nghệ cao cấp nổi bật với chip Apple M4 Max 14 nh&acirc;n CPU v&agrave; 32 nh&acirc;n GPU mạnh mẽ. M&aacute;y được trang bị RAM 36GB, ổ cứng SSD 1TB v&agrave; m&agrave;n h&igrave;nh Liquid Retina XDR 16.2 inch. Thiết kế tinh tế với hệ thống loa trung thực cao, kết nối hiện đại v&agrave; thời lượng pin ấn tượng l&ecirc;n đến 21 giờ. M&aacute;y trang bị hệ điều h&agrave;nh macOS Sequoia v&agrave; t&iacute;ch hợp c&ocirc;ng nghệ AI th&ocirc;ng minh.</p>\r\n</div>\r\n</div>\r\n<div id=\"cpsContentSEO\">\r\n<h2 id=\"macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano--chinh-phuc-moi-tac-vu\"><strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano &ndash; Chinh phục mọi t&aacute;c vụ </strong></h2>\r\n<p>Với <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> , Apple đ&atilde; tạo ra một chiếc m&aacute;y t&iacute;nh x&aacute;ch tay đ&aacute;p ứng mọi nhu cầu c&ocirc;ng việc v&agrave; giải tr&iacute;. M&aacute;y kh&ocirc;ng chỉ sở hữu sức mạnh với chip M4 m&agrave; c&ograve;n c&oacute; thiết kế đẹp mắt v&agrave; thời lượng pin d&agrave;i, đ&aacute;p ứng mọi y&ecirc;u cầu của người d&ugrave;ng.</p>\r\n<h3 id=\"nen-tang-vung-chac-cho-hieu-suat-cao\"><strong> Nền tảng vững chắc cho hiệu suất cao </strong></h3>\r\n<p>MacBook Pro M4 Max trang bị 36GB RAM, một con số đ&aacute;ng kinh ngạc ngay cả đối với c&aacute;c d&ograve;ng m&aacute;y cao cấp. Dung lượng RAM lớn n&agrave;y cho ph&eacute;p <a title=\"Macbook Pro\" href=\"https://cellphones.com.vn/laptop/mac/macbook-pro.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro</strong></a> mở đồng thời h&agrave;ng chục ứng dụng chuy&ecirc;n s&acirc;u m&agrave; kh&ocirc;ng hề gặp phải hiện tượng giật lag. Kh&ocirc;ng chỉ dừng lại ở đa nhiệm, bộ nhớ RAM n&agrave;y c&ograve;n đảm bảo khả năng xử l&yacute; c&aacute;c dự &aacute;n y&ecirc;u cầu t&agrave;i nguy&ecirc;n lớn.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-1.jpg\" alt=\"Cấu h&igrave;nh MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Dung lượng 1TB SSD mang đến kh&ocirc;ng gian rộng r&atilde;i để bạn thoải m&aacute;i lưu trữ dữ liệu. Tuy nhi&ecirc;n, điểm nổi bật kh&ocirc;ng chỉ nằm ở dung lượng. Ổ cứng SSD của chiếc <a title=\"Macbook M4\" href=\"https://cellphones.com.vn/laptop/mac/m4-series.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook M4</strong></a> được thiết kế với tốc độ truy xuất si&ecirc;u nhanh, gi&uacute;p bạn mở c&aacute;c tệp tin lớn trong t&iacute;ch tắc, khởi động ứng dụng nhanh v&agrave; trải nghiệm hiệu suất kh&ocirc;ng độ trễ.</p>\r\n<h3 id=\"su-tinh-te-cham-den-dinh-cao-hoan-thien-den-tung-chi-tiet\"><strong> Sự tinh tế chạm đến đỉnh cao, ho&agrave;n thiện đến từng chi tiết </strong></h3>\r\n<p><strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> c&oacute; th&acirc;n m&aacute;y được chế t&aacute;c tỉ mỉ với c&aacute;c g&oacute;c bo tr&ograve;n mềm mại, h&agrave;i h&ograve;a với viền mỏng quanh m&agrave;n h&igrave;nh, tạo n&ecirc;n tỷ lệ c&acirc;n đối. Độ d&agrave;y chỉ 1.68 cm v&agrave; trọng lượng 2.15 kg mang lại sự c&acirc;n bằng l&yacute; tưởng giữa t&iacute;nh di động v&agrave; sức mạnh.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-3.jpg\" alt=\"Thiết kế MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>B&agrave;n ph&iacute;m Magic Keyboard với h&agrave;nh tr&igrave;nh ph&iacute;m tối ưu mang đến trải nghiệm g&otilde; thoải m&aacute;i, ch&iacute;nh x&aacute;c. Đ&egrave;n nền ph&iacute;m của <a title=\"Macbook Pro M4\" href=\"https://cellphones.com.vn/laptop/mac/macbook-pro/macbook-pro-2024.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro M4</strong></a> tự điều chỉnh theo &aacute;nh s&aacute;ng m&ocirc;i trường, kh&ocirc;ng chỉ tiện dụng m&agrave; c&ograve;n tạo n&ecirc;n một vẻ đẹp c&ocirc;ng nghệ hiện đại.&nbsp;</p>\r\n<h3 id=\"hieu-nang-dot-pha-voi-chip-m4-max-tien-tien\"><strong> Hiệu năng đột ph&aacute; với chip M4 Max ti&ecirc;n tiến </strong></h3>\r\n<p>MacBook Pro M4 Max 16 inch g&acirc;y ấn tượng mạnh mẽ nhờ bộ vi xử l&yacute; Apple M4 Max, kết hợp giữa hiệu suất mạnh mẽ v&agrave; tối ưu năng lượng. Với 14 nh&acirc;n CPU, bao gồm 10 nh&acirc;n hiệu năng cao v&agrave; 4 nh&acirc;n tiết kiệm điện, kh&ocirc;ng chỉ xử l&yacute; mượt m&agrave; c&aacute;c t&aacute;c vụ nặng m&agrave; c&ograve;n tiết kiệm năng lượng khi thực hiện c&aacute;c c&ocirc;ng việc nhẹ nh&agrave;ng hơn.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-2.jpg\" alt=\"Hiệu năng MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Về đồ họa, 32 nh&acirc;n GPU trong M4 Max đưa hiệu suất xử l&yacute; h&igrave;nh ảnh của <a title=\"Macbook Pro 16\" href=\"https://cellphones.com.vn/bo-loc/macbook-pro-16-inch\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro 16</strong></a>&nbsp;l&ecirc;n một tầm cao mới. Kết hợp với Neural Engine 16 l&otilde;i, MacBook Pro M4 Max kh&ocirc;ng chỉ mạnh mẽ m&agrave; c&ograve;n th&ocirc;ng minh, tối ưu h&oacute;a c&aacute;c t&aacute;c vụ tr&iacute; tuệ nh&acirc;n tạo. Điều n&agrave;y tạo n&ecirc;n một cỗ m&aacute;y to&agrave;n diện, kh&ocirc;ng chỉ mạnh ở hiện tại m&agrave; c&ograve;n sẵn s&agrave;ng cho tương lai của c&ocirc;ng nghệ.</p>\r\n<h3 id=\"giai-tri-lien-mach-voi-vien-pin-lon-va-man-hinh-sac-net\"><strong> Giải tr&iacute; liền mạch với vi&ecirc;n pin lớn v&agrave; m&agrave;n h&igrave;nh sắc n&eacute;t </strong></h3>\r\n<p>Pin của <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> thực sự l&agrave; một điểm s&aacute;ng nổi bật. Với khả năng l&ecirc;n đến 21 giờ xem video li&ecirc;n tục v&agrave; 14 giờ duyệt web kh&ocirc;ng d&acirc;y, hỗ trợ tối đa cho c&ocirc;ng việc v&agrave; giải tr&iacute; cả ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng cần t&igrave;m đến ổ cắm sạc.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-4.jpg\" alt=\"M&agrave;n h&igrave;nh MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Điểm ấn tượng của&nbsp;<a title=\"Macbook Pro M4 16 inch\" href=\"https://cellphones.com.vn/bo-loc/macbook-pro-m4-16-inch\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro M4 16 inch</strong></a> l&agrave; m&agrave;n h&igrave;nh Liquid Retina XDR, mặc d&ugrave; sở hữu độ ph&acirc;n giải cao v&agrave; độ s&aacute;ng cao l&ecirc;n đến 1.600 nits. Nhưng nhờ c&ocirc;ng nghệ tối ưu năng lượng của Apple, vẫn duy tr&igrave; được thời gian sử dụng l&acirc;u d&agrave;i.</p>\r\n<h2 id=\"mua-ngay-macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-chinh-hang-tai-cellphones\"><strong> Mua ngay MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>Sở hữu sức mạnh với <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong>&nbsp;ngay h&ocirc;m nay tại CellphoneS! Khi mua h&agrave;ng tại đ&acirc;y, bạn sẽ được hưởng ch&iacute;nh s&aacute;ch 1 đổi 1 trong 30 ng&agrave;y nếu ph&aacute;t sinh lỗi phần cứng do nh&agrave; sản xuất. Sản phẩm cũng đi k&egrave;m bảo h&agrave;nh 12 th&aacute;ng ch&iacute;nh h&atilde;ng Apple tại trung t&acirc;m bảo h&agrave;nh ủy quyền CareS.vn. Đừng bỏ lỡ cơ hội sở hữu si&ecirc;u phẩm c&ocirc;ng nghệ n&agrave;y ngay h&ocirc;m nay!</p>\r\n</div>', 'uploads/689891e52e07b_MacBook Pro 16 M4 Max 2024 16CPU.webp', 1, 13, '2025-08-06 13:56:05', '<table class=\"technical-content\" style=\"width: 81.1765%; height: 847.6px;\">\r\n<tbody>\r\n<tr class=\"technical-content-item\" style=\"height: 90.4px;\">\r\n<td style=\"width: 19.4581%;\">Loại card đồ họa</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>32 l&otilde;i<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Dung lượng RAM</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>36GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Ổ cứng</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>1TB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>16.2 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Hệ điều h&agrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>3456 x 2234 pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Loại CPU</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>Apple M4 Max 14 l&otilde;i với 10 l&otilde;i hiệu năng v&agrave; 4 l&otilde;i tiết kiệm điện</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(37, 'MacBook Air 15 inch M2 2023 8CPU 10GPU ', 37890000.00, 18.00, '<div class=\"ProductContent_description-container__miT3z\">\r\n<p><strong>Ngo&agrave;i việc sở hữu m&agrave;n h&igrave;nh Liquid Retina 15 inch rộng lớn v&agrave; chip M2 mạnh mẽ, phi&ecirc;n bản MacBook Air 2023 m&agrave; bạn đang theo d&otilde;i c&ograve;n ghi điểm nhờ được t&iacute;ch hợp sẵn bộ sạc 70W - gấp đ&ocirc;i c&ocirc;ng suất sạc so với bản ti&ecirc;u chuẩn. Nhờ vậy, qu&aacute; tr&igrave;nh chờ đợi thiết bị nạp năng lượng sẽ được r&uacute;t ngắn đi rất nhiều.</strong></p>\r\n<h3><strong>Chế t&aacute;c tỉ mỉ, bền bỉ v&agrave; cao cấp</strong></h3>\r\n<p>Kh&ocirc;ng chỉ kế thừa phong c&aacute;ch thiết kế tinh xảo v&agrave; chất lượng ho&agrave;n thiện cao cấp của d&ograve;ng MacBook Air, phi&ecirc;n bản MacBook Air 15 M2 2023 c&ograve;n g&acirc;y ấn tượng khi nới rộng k&iacute;ch cỡ <a href=\"https://fptshop.com.vn/man-hinh\">m&agrave;n h&igrave;nh</a> l&ecirc;n ngưỡng 15 inch, từ đ&oacute; mở rộng trải nghiệm hiển thị để bạn quan s&aacute;t c&aacute;c nội dung r&otilde; n&eacute;t hơn.</p>\r\n<p>To&agrave;n bộ th&acirc;n m&aacute;y đều được ho&agrave;n thiện chỉn chu từ nh&ocirc;m chất lượng cao. Lợi thế về chất liệu khung vỏ khiến thiết bị cứng c&aacute;p, chắc chắn m&agrave; vẫn nhẹ nh&agrave;ng linh hoạt. Nhờ chip xử l&yacute; M2 mạnh mẽ v&agrave; &ecirc;m &aacute;i, sản phẩm kh&ocirc;ng tỏa nhiều nhiệt khi vận h&agrave;nh, duy tr&igrave; hiệu năng ấn tượng d&ugrave; kh&ocirc;ng cần t&iacute;ch hợp bộ tản nhiệt chuy&ecirc;n dụng.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-1(1).jpg\" alt=\"Chế t&aacute;c tỉ mỉ, bền bỉ v&agrave; cao cấp\" loading=\"lazy\"></p>\r\n<h3><strong>Đột ph&aacute; về sức mạnh v&agrave; trải nghiệm pin</strong></h3>\r\n<p>Chip xử l&yacute; Apple M2 với sự tăng tiến mạnh mẽ về CPU, GPU v&agrave; khả năng vận h&agrave;nh tiết kiệm pin đem lại trải nghiệm cực kỳ ấn tượng khi sử dụng MacBook Air 15 M2 2023. Con chip n&agrave;y được sản xuất tr&ecirc;n tiến tr&igrave;nh 5nm, quy tụ 20 tỷ b&oacute;ng b&aacute;n dẫn - nhiều hơn 25% so với chip M1. Với khả năng thực hiện 15,8 ng&agrave;n tỷ ph&eacute;p t&iacute;nh mỗi gi&acirc;y, bộ vi xử l&yacute; mới đem tới sự thăng tiến vượt bậc về sức mạnh cho MacBook Air 2023.</p>\r\n<p>Ngo&agrave;i ra, điểm mạnh của chip M2 l&agrave; khả năng vận h&agrave;nh hiệu quả m&agrave; vẫn tiết kiệm pin, gi&uacute;p k&eacute;o d&agrave;i thời lượng trải nghiệm giữa mỗi lần sạc với thế hệ cũ. Theo th&ocirc;ng số do Apple cung cấp, MacBook Air 15 M2 2023 c&oacute; thể vận h&agrave;nh tối đa trong 18 tiếng li&ecirc;n tục.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-2(1).jpg\" alt=\"Đột ph&aacute; về sức mạnh v&agrave; trải nghiệm pin\" loading=\"lazy\"></p>\r\n<h3><strong>Sạc 70W, r&uacute;t ngắn thời gian chờ đợi</strong></h3>\r\n<p>Phi&ecirc;n bản MacBook Air 15 M2 2023 m&agrave; bạn đang theo d&otilde;i được trang bị k&egrave;m bộ sạc 70W đi k&egrave;m trong hộp đựng. C&ocirc;ng suất của bộ sạc n&agrave;y gấp đ&ocirc;i so với chuẩn sạc 35W của phi&ecirc;n bản th&ocirc;ng thường. Điều n&agrave;y sẽ khiến cho qu&aacute; tr&igrave;nh chờ đợi mỗi khi nạp năng lượng cho thiết bị được r&uacute;t ngắn hơn nhiều. Từ đ&oacute;, trải nghiệm giải tr&iacute;, học tập v&agrave; l&agrave;m việc của bạn sẽ trở n&ecirc;n xuy&ecirc;n suốt hơn, trọn vẹn hơn.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-3(2).jpg\" alt=\"Sạc 70W, r&uacute;t ngắn thời gian chờ đợi\" loading=\"lazy\"></p>\r\n<h3><strong>M&agrave;n h&igrave;nh Liquid Retina 15 inch rộng mở</strong></h3>\r\n<p>So với thế hệ cũ, MacBook Air M2 2023 g&acirc;y ấn tượng mạnh về trải nghiệm h&igrave;nh ảnh khi sở hữu m&agrave;n h&igrave;nh lớn tới 15 inch. C&ocirc;ng nghệ Liquid Retina sẽ đảm bảo mỗi khu&ocirc;n h&igrave;nh tr&igrave;nh diễn trước mắt bạn đều cực kỳ trung thực, tươi s&aacute;ng v&agrave; chi tiết. <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/macbook-air\">MacBook Air</a> thế hệ mới c&oacute; thể đ&aacute;p ứng tốt nhu cầu khắt khe về m&agrave;u sắc của những người l&agrave;m c&ocirc;ng việc s&aacute;ng tạo nội dung, dựng phim, chỉnh sửa h&igrave;nh ảnh v&agrave; l&agrave;m đồ họa chuy&ecirc;n nghiệp.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-4(1).jpg\" alt=\"M&agrave;n h&igrave;nh Liquid Retina 15 inch rộng mở\" loading=\"lazy\"></p>\r\n<h3><strong>Trải nghiệm video call sống động v&agrave; đa chiều</strong></h3>\r\n<p>MacBook Air M2 2023 mang tới trải nghiệm li&ecirc;n lạc sống động với sự hỗ trợ của camera 1080p chất lượng cao, việc gọi video call v&agrave; chuyện tr&ograve; th&ocirc;ng qua FaceTime hoặc c&aacute;c phần mềm hỗ trợ chuy&ecirc;n dụng sẽ trở n&ecirc;n r&otilde; r&agrave;ng, sắc n&eacute;t v&agrave; chi tiết hơn bao giờ hết.</p>\r\n<p>Kh&ocirc;ng chỉ vậy, hệ thống loa ngo&agrave;i ch&acirc;n thực với sự kết hợp của 2 loa trầm khử lực c&ugrave;ng 2 loa bổng tần số cao sẽ khiến cho việc diễn đạt c&aacute;c tiết tấu trở n&ecirc;n sống động hơn, s&acirc;u lắng hơn. C&ocirc;ng nghệ Dolby Atmos sẽ đưa bạn v&agrave;o thế giới của &acirc;m thanh đa chiều khi đắm ch&igrave;m trong kh&ocirc;ng gian &acirc;m nhạc v&agrave; phim ảnh chất lượng cao.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-5.jpg\" alt=\"Trải nghiệm video call sống động v&agrave; đa chiều\" loading=\"lazy\"></p>\r\n<h3><strong>Kết hợp cảm biến v&acirc;n tay v&agrave;o Magic Keyboard</strong></h3>\r\n<p>MacBook Air M2 2023 sẽ hỗ trợ bạn đắc lực trong c&ocirc;ng việc với hệ thống b&agrave;n ph&iacute;m Magic Keyboard cao cấp. Trải nghiệm g&otilde; &ecirc;m &aacute;i v&agrave; tốc độ phản hồi nhanh ch&oacute;ng sẽ khiến cho qu&aacute; tr&igrave;nh soạn thảo văn bản của bạn trở n&ecirc;n dễ d&agrave;ng hơn. Ngo&agrave;i ra, Apple c&ograve;n t&iacute;ch hợp th&ecirc;m cơ chế nhận diện v&acirc;n tay Touch ID ở g&oacute;c b&agrave;n ph&iacute;m để r&uacute;t gọn qu&aacute; tr&igrave;nh đăng nhập khi mở m&aacute;y hoặc x&aacute;c thực danh t&iacute;nh khi thanh to&aacute;n.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-6.jpg\" alt=\"Kết hợp cảm biến v&acirc;n tay v&agrave;o Magic Keyboard\" loading=\"lazy\"></p>\r\n</div>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754667067/products/main/uwjtpkebw3kkttjkefdl.webp', 1, 13, '2025-08-08 15:31:09', '<div id=\"spec-item-0\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Bộ xử l&yacute;: </strong>H&atilde;ng CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple; </span>C&ocirc;ng nghệ CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">M2; </span>Loại CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">8 - Core</span></div>\r\n</div>\r\n<div id=\"spec-item-1\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Đồ họa: </strong>H&atilde;ng (Card Oboard): <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple; </span>T&ecirc;n đầy đủ (Card onbroad): <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple M2 GPU 10 nh&acirc;n</span></div>\r\n</div>\r\n<div id=\"spec-item-2\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>RAM: </strong>Dung lượng RAM: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">8 GB; </span>Hỗ trợ RAM tối đa: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">24 GB</span></div>\r\n</div>\r\n<div id=\"spec-item-3\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Lưu trữ: </strong>Kiểu ổ cứng:&nbsp;SSD;&nbsp;Dung lượng SSD: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">512 GB</span></div>\r\n</div>\r\n<div id=\"spec-item-4\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>M&agrave;n h&igrave;nh: </strong>K&iacute;ch thước m&agrave;n h&igrave;nh: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">15.3 inch; </span>C&ocirc;ng nghệ m&agrave;n h&igrave;nh: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Liquid Retina; </span>Độ ph&acirc;n giải:&nbsp;2880 x 1864 Pixels</div>\r\n<div class=\"flex gap-2 border-b border-dashed border-b-iconDividerOnWhite py-1.5\">\r\n<div class=\"flex flex-1 flex-col py-0.5\">&nbsp;</div>\r\n</div>\r\n</div>', 0);
INSERT INTO `products` (`id`, `name`, `price`, `discount`, `description`, `image_url`, `category_id`, `supplier_id`, `created_at`, `content`, `isDeleted`) VALUES
(39, 'Tai nghe chống ồn không dây Sony 1000X The Collexion', 16990000.00, 0.00, '<h2 id=\"tai-nghe-chup-tai-sony-wh-1000x-am-thanh-vom-song-dong-chan-thuc\"><strong>Tai nghe chụp tai Sony WH-1000X - &Acirc;m thanh v&ograve;m sống động, ch&acirc;n thực</strong></h2>\r\n<p>Tai nghe Sony WH-1000X l&agrave; thiết bị &acirc;m thanh kh&ocirc;ng d&acirc;y cao cấp với khả năng tối ưu h&oacute;a m&ocirc;i trường nghe hiệu quả. Sản phẩm tập trung n&acirc;ng cao chất lượng ph&aacute;t nhạc, hứa hẹn sẽ mang lại sự tập trung xuy&ecirc;n suốt cho người sử dụng.</p>\r\n<h3 id=\"cong-nghe-am-thanh-cao-cap-va-khu-on-vuot-troi\"><strong>C&ocirc;ng nghệ &acirc;m thanh cao cấp v&agrave; khử ồn vượt trội</strong></h3>\r\n<p>Tai nghe chụp tai Sony WH-1000X sử dụng bộ m&agrave;ng loa mới c&oacute; v&ograve;m carbon composite để cải thiện biểu đạt tần số cao. Thiết bị hỗ trợ DSEE Ultimate để n&acirc;ng cấp c&aacute;c tệp nhạc n&eacute;n kỹ thuật số, gi&uacute;p cải thiện chất lượng &acirc;m thanh khi ph&aacute;t nhạc.</p>\r\n<p>Chất &acirc;m của thiết bị được tinh chỉnh bởi c&aacute;c kỹ sư mastering chuy&ecirc;n nghiệp, nhằm t&aacute;i tạo dải trầm c&acirc;n bằng v&agrave; dải cao r&otilde; r&agrave;ng. C&ugrave;ng với đ&oacute; l&agrave; bộ xử l&yacute; khử ồn HD QN3 mang lại tốc độ xử l&yacute; nhanh, hỗ trợ tinh chỉnh hệ thống micro nhằm loại bỏ tiếng ồn m&ocirc;i trường.</p>\r\n<p><img title=\"\" src=\"https://media-asset.cellphones.com.vn/dashboard-v2/uploads/content-uploads/tai-nghe-chong-on-khong-day-sony-1000x-the-collexion-879050.jpg\" alt=\"Kiểu d&aacute;ng sang trọng mang lại trải nghiệm nghe sống động\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, c&ocirc;ng nghệ khử ồn th&iacute;ch ứng của thiết bị c&oacute; thể tự động điều chỉnh linh hoạt theo &aacute;p suất kh&ocirc;ng kh&iacute; xung quanh v&agrave; độ vừa vặn thực tế khi người d&ugrave;ng đeo. Nhờ chuẩn LDAC, sản phẩm c&oacute; khả năng truyền tải lượng dữ liệu nhiều hơn gấp 3 lần so với Bluetooth, duy tr&igrave; tốt chất lượng &acirc;m thanh độ ph&acirc;n giải cao ổn định.</p>\r\n<h3 id=\"kieu-dang-toi-gian-sang-trong-ket-hop-chat-lieu-ben-bi\"><strong>Kiểu d&aacute;ng tối giản sang trọng kết hợp chất liệu bền bỉ</strong></h3>\r\n<p>Về mặt ngoại h&igrave;nh, tai nghe chụp tai Sony WH-1000X tập trung v&agrave;o phong c&aacute;ch tối giản th&ocirc;ng qua sự kết hợp giữa kim loại v&agrave; da nh&acirc;n tạo. Phần th&eacute;p kh&ocirc;ng gỉ được chế t&aacute;c tỉ mỉ với bề mặt nh&aacute;m mờ, tạo n&ecirc;n độ bền bỉ v&agrave; cảm gi&aacute;c chắc chắn.</p>\r\n<p><img title=\"\" src=\"https://media-asset.cellphones.com.vn/dashboard-v2/uploads/content-uploads/tai-nghe-chong-on-khong-day-sony-1000x-the-collexion-649085.jpg\" alt=\"Đệm tai &ecirc;m &aacute;i tạo sự thoải m&aacute;i khi sử dụng l&acirc;u\" loading=\"lazy\"></p>\r\n<p>V&agrave;nh tai nghe được thiết kế rộng r&atilde;i kết hợp lớp đệm &ecirc;m &aacute;i nhằm ph&acirc;n bổ đều &aacute;p lực, mang lại sự thoải m&aacute;i khi đeo l&acirc;u. Đai cho&agrave;ng đầu c&oacute; k&iacute;ch thước lớn hơn, phối hợp c&ugrave;ng chất liệu da mềm gi&uacute;p thiết bị &ocirc;m s&aacute;t đầu tự nhi&ecirc;n v&agrave; hỗ trợ c&aacute;ch &acirc;m tốt.</p>\r\n<p>Hệ thống điều khiển cảm ứng v&agrave; c&aacute;c ph&iacute;m vật l&yacute; tr&ecirc;n thiết bị được bố tr&iacute; trực quan, gi&uacute;p người d&ugrave;ng dễ d&agrave;ng nhận diện v&agrave; thao t&aacute;c chuẩn x&aacute;c th&ocirc;ng qua cảm gi&aacute;c chạm. Bao đựng đi k&egrave;m thiết bị mang h&igrave;nh d&aacute;ng t&uacute;i x&aacute;ch nhỏ gọn, t&iacute;ch hợp tay cầm dễ nắm c&ugrave;ng cơ chế kh&oacute;a từ t&iacute;nh gi&uacute;p thao t&aacute;c nhanh ch&oacute;ng.</p>\r\n<h3 id=\"he-thong-micro-dieu-huong-chum-song-giup-goi-thoai-ro-rang\"><strong>Hệ thống micro điều hướng ch&ugrave;m s&oacute;ng gi&uacute;p gọi thoại r&otilde; r&agrave;ng</strong></h3>\r\n<p>Khả năng đ&agrave;m thoại tr&ecirc;n tai nghe chụp tai Sony WH-1000X được tối ưu h&oacute;a th&ocirc;ng qua hệ thống AI c&ugrave;ng 6 micro điều hướng ch&ugrave;m s&oacute;ng. Thuật to&aacute;n xử l&yacute; kết hợp c&ocirc;ng nghệ thu giọng n&oacute;i ch&iacute;nh x&aacute;c gi&uacute;p thiết bị lọc bỏ tạp &acirc;m để duy tr&igrave; độ trong trẻo.</p>\r\n<p><img title=\"\" src=\"https://media-asset.cellphones.com.vn/dashboard-v2/uploads/content-uploads/tai-nghe-chong-on-khong-day-sony-1000x-the-collexion-556419.jpg\" alt=\"Micro lọc tạp &acirc;m hiệu quả phục vụ tối ưu c&ocirc;ng việc\" loading=\"lazy\"></p>\r\n<p>Cấu tr&uacute;c micro của thế hệ tai nghe Sony n&agrave;y được tinh chỉnh vị tr&iacute; hợp l&yacute; nhằm giảm thiểu nhiễu gi&oacute;, hỗ trợ gọi thoại ổn định trong m&ocirc;i trường ồn &agrave;o. Nhờ t&iacute;nh năng Speak-to-Chat tự động hạ &acirc;m lượng nhạc khi nhận diện giọng n&oacute;i, người d&ugrave;ng c&oacute; thể thoải m&aacute;i tr&ograve; chuyện m&agrave; kh&ocirc;ng cần th&aacute;o tai nghe.</p>\r\n<h3 id=\"thoi-luong-pin-an-tuong-ket-hop-cong-nghe-sac-nhanh\"><strong>Thời lượng pin ấn tượng kết hợp c&ocirc;ng nghệ sạc nhanh</strong></h3>\r\n<p>Tai nghe chụp tai Sony WH-1000X đ&aacute;p ứng thời gian ph&aacute;t nhạc li&ecirc;n tục tối đa 24 giờ khi bật chế độ khử ồn. Mức thời lượng sử dụng n&agrave;y c&oacute; thể thay đổi t&ugrave;y thuộc v&agrave;o nhiều điều kiện thiết lập thực tế v&agrave; th&oacute;i quen nghe nhạc của từng người d&ugrave;ng.</p>\r\n<p>Th&ocirc;ng tin tham chiếu cho biết thiết bị sạc qua USB với thời gian sạc xấp xỉ 3,5 giờ. Cơ chế sạc n&agrave;y gi&uacute;p người d&ugrave;ng kh&ocirc;ng bị gi&aacute;n đoạn trải nghiệm qu&aacute; l&acirc;u, nhanh ch&oacute;ng quay lại với thế giới &acirc;m nhạc.</p>\r\n<p><img title=\"\" src=\"https://media-asset.cellphones.com.vn/dashboard-v2/uploads/content-uploads/tai-nghe-chong-on-khong-day-sony-1000x-the-collexion-707562.jpg\" alt=\"Thời lượng pin bền bỉ đồng h&agrave;nh c&ugrave;ng mọi chuyến đi\" loading=\"lazy\"></p>\r\n<p>Ấn tượng hơn, với cảm biến tiệm cận, Sony WH-1000X c&oacute; thể tự động tạm dừng ph&aacute;t nhạc khi người d&ugrave;ng th&aacute;o thiết bị ra nhằm tối ưu h&oacute;a mức ti&ecirc;u thụ năng lượng. Khi người d&ugrave;ng đeo thiết bị trở lại, &acirc;m nhạc sẽ tiếp tục ph&aacute;t ngay tại vị tr&iacute; đ&atilde; dừng trước đ&oacute; m&agrave; kh&ocirc;ng cần thao t&aacute;c tr&ecirc;n điện thoại.</p>\r\n<h2 id=\"so-sanh-tai-nghe-chup-tai-sony-wh-1000x-va-sony-wh-1000xm6\"><strong>So s&aacute;nh tai nghe chụp tai Sony WH-1000X v&agrave; Sony WH-1000XM6</strong></h2>\r\n<p>Tai nghe chụp tai Sony WH-1000X v&agrave; Sony WH-1000XM6 đều sở hữu c&ocirc;ng nghệ khử ồn ti&ecirc;n tiến c&ugrave;ng chất &acirc;m nổi bật. Người d&ugrave;ng c&oacute; thể đối chiếu c&aacute;c th&ocirc;ng số dưới đ&acirc;y để t&igrave;m ra sản phẩm ph&ugrave; hợp với nhu cầu giải tr&iacute; c&aacute; nh&acirc;n.</p>\r\n<p>&nbsp;</p>\r\n<div class=\"table-container\">\r\n<table class=\"seo-table table is-bordered is-hoverable\">\r\n<thead>\r\n<tr>\r\n<td>\r\n<p><strong>Th&ocirc;ng số</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Tai nghe Bluetooth chụp tai Sony WH-1000XM6</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><strong>K&iacute;ch thước</strong></p>\r\n</td>\r\n<td>\r\n<p>D&agrave;i 20 cm - Rộng 7.83 cm - Cao 25.69 cm</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Trọng lượng</strong></p>\r\n</td>\r\n<td>\r\n<p>254g</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>C&ocirc;ng nghệ &acirc;m thanh</strong></p>\r\n</td>\r\n<td>\r\n<p>C&ocirc;ng nghệ Adaptive NC Optimizer<br>DSEE Extreme (Cơ chế tăng cường &acirc;m thanh kỹ thuật số)<br>Hi-Res Audio<br>360 Reality Audio<br>Equalizer</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Micro</strong></p>\r\n</td>\r\n<td>\r\n<p>C&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Cổng kết nối</strong></p>\r\n</td>\r\n<td>\r\n<p>3.5mm</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Thời lượng sử dụng Pin</strong></p>\r\n</td>\r\n<td>\r\n<p>Tắt chống ồn: 40 giờ<br>Bật chống ồn: 30 giờ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Phương thức điều khiển</strong></p>\r\n</td>\r\n<td>\r\n<p>N&uacute;t bấm vật l&yacute;<br>Cảm ứng</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>T&iacute;nh năng kh&aacute;c</strong></p>\r\n</td>\r\n<td>\r\n<p>Chế độ &acirc;m thanh xung quanh<br>Fast pair<br>Dual connect<br>Cảm biến tiệm cận<br>Tương th&iacute;ch trợ l&yacute; ảo<br>Sạc nhanh<br>Micro chống ồn, lọc gi&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>H&atilde;ng sản xuất</strong></p>\r\n</td>\r\n<td>\r\n<p>Sony</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p><img title=\"\" src=\"https://media-asset.cellphones.com.vn/dashboard-v2/uploads/content-uploads/tai-nghe-chong-on-khong-day-sony-1000x-the-collexion-473671.jpg\" alt=\"So s&aacute;nh thiết kế v&agrave; t&iacute;nh năng giữa hai thế hệ\" loading=\"lazy\"></p>\r\n<p>Nh&igrave;n chung, mỗi d&ograve;ng sản phẩm đều mang lại lợi thế ri&ecirc;ng về khả năng xử l&yacute; &acirc;m thanh cũng như dung lượng pin. Quyết định chọn mua d&ograve;ng sản phẩm n&agrave;o t&ugrave;y thuộc ho&agrave;n to&agrave;n v&agrave;o khả năng t&agrave;i ch&iacute;nh cũng như th&oacute;i quen giải tr&iacute; c&aacute; nh&acirc;n.</p>\r\n<h2 id=\"mua-tai-nghe-chup-tai-sony-wh-1000x-chinh-hang-tai-cellphones\"><strong>Mua tai nghe chụp tai Sony WH-1000X ch&iacute;nh h&atilde;ng tại CellphoneS</strong></h2>\r\n<p>Kh&aacute;ch h&agrave;ng c&oacute; thể mua tai nghe chụp tai Sony WH-1000X ch&iacute;nh h&atilde;ng tại CellphoneS k&egrave;m theo ch&iacute;nh s&aacute;ch bảo h&agrave;nh uy t&iacute;n. Tại đ&acirc;y, hệ thống cung cấp khu vực d&ugrave;ng thử để kh&aacute;ch h&agrave;ng trực tiếp trải nghiệm thiết bị trước khi quyết định mua sắm.</p>\r\n<p>Đại l&yacute; &aacute;p dụng ch&iacute;nh s&aacute;ch mua trả g&oacute;p 0% thủ tục đơn giản c&ugrave;ng v&ocirc; v&agrave;n đặc quyền giảm gi&aacute; cho kh&aacute;ch h&agrave;ng Smember. Ngo&agrave;i ra, ch&iacute;nh s&aacute;ch thu cũ đổi mới, mức trợ gi&aacute; hấp dẫn sẽ gi&uacute;p kh&aacute;ch h&agrave;ng tối ưu chi ph&iacute; khi n&acirc;ng cấp sản phẩm.</p>', 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1789937687/products/main/ox9dt87dqdx5gplgcbmp.webp', 8, 13, '2026-09-20 20:54:48', '<p><strong>Tai nghe chụp tai Sony WH-1000X</strong> mang tới kh&ocirc;ng gian &acirc;m thanh nổi ch&acirc;n thực c&ugrave;ng thiết kế sang trọng, tối ưu cho nhu cầu giải tr&iacute; hiện đại của người d&ugrave;ng. Thiết bị sử dụng bộ m&agrave;ng loa 30 mm&nbsp;hỗ trợ t&aacute;i tạo dải &acirc;m rộng. Tai nghe c&oacute; thể hoạt động li&ecirc;n tục tới 24 tiếng l&uacute;c mở khử ồn, đảm bảo trải nghiệm th&ocirc;ng suốt.</p>', 0),
(40, 'Điện thoại iPhone 18 Pro 2TB', 77990000.00, 0.00, '<p class=\"text-article-seo\"><em><strong><a href=\"https://www.thegioididong.com/dtdd/iphone-18-pro\" target=\"_blank\" rel=\"noopener\">iPhone 18 Pro</a> ra mắt v&agrave;o 10 th&aacute;ng 9 năm 2026, l&agrave; phi&ecirc;n bản Pro trong d&ograve;ng <a href=\"https://www.thegioididong.com/dtdd-apple-iphone-18-series\" target=\"_blank\" rel=\"noopener\">iPhone 18</a>. Sản phẩm nổi bật với thiết kế nguy&ecirc;n khối nh&ocirc;m, m&agrave;n h&igrave;nh Super Retina XDR 6.3 inch, chip A20 Pro, camera ch&iacute;nh Fusion 48 MP với khẩu độ t&ugrave;y chỉnh (&fnof;/1.48, &fnof;/1.8, &fnof;/2.8, &fnof;/4.0)</strong></em><em><strong>, thời lượng xem video 34 giờ. B&agrave;i viết dưới đ&acirc;y tổng hợp iPhone 18 Pro c&oacute; g&igrave; mới, ph&ugrave; hợp với ai, th&ocirc;ng số ra sao v&agrave; kh&aacute;c biệt thế n&agrave;o so với iPhone 17 Pro.</strong></em></p>\r\n<h3>1. iPhone 18 Pro ra mắt khi n&agrave;o?</h3>\r\n<p>iPhone 18 Pro ch&iacute;nh thức ra mắt v&agrave;o ng&agrave;y 10/09/2026 (theo giờ Việt Nam) trong sự kiện c&ocirc;ng bố sản phẩm mới của Apple. Đ&acirc;y l&agrave; phi&ecirc;n bản thuộc nh&oacute;m Pro trong d&ograve;ng iPhone 18 Pro (series), b&ecirc;n cạnh phi&ecirc;n bản <a href=\"https://www.thegioididong.com/dtdd/iphone-18-pro-max\" rel=\"\">iPhone 18 Pro Max</a>. Cũng trong sự kiện lần n&agrave;y, Apple đ&atilde; giới thiệu <a href=\"https://www.thegioididong.com/dtdd-apple-iphone-duo\" rel=\"\">iPhone Duo Series</a>, mẫu <a href=\"https://www.thegioididong.com/dtdd-apple-iphone\" rel=\"\">iPhone</a> m&agrave;n h&igrave;nh gập đầu ti&ecirc;n của h&atilde;ng.</p>\r\n<h3>2. iPhone 18 Pro c&oacute; g&igrave; mới?</h3>\r\n<p>iPhone 18 Pro l&agrave; phi&ecirc;n bản Pro c&oacute; k&iacute;ch thước gọn hơn Pro Max nhưng vẫn tập trung v&agrave;o hiệu năng cao, camera chuy&ecirc;n nghiệp v&agrave; m&agrave;n h&igrave;nh cao cấp. Đ&acirc;y l&agrave; lựa chọn d&agrave;nh cho người muốn trải nghiệm d&ograve;ng Pro, cần 1 chiếc <a title=\"Tất cả điện thoại ch&iacute;nh h&atilde;ng đang kinh doanh tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd\" target=\"_blank\" rel=\"noopener\">điện thoại</a> mạnh để chụp ảnh, quay video, l&agrave;m việc hằng ng&agrave;y nhưng vẫn ưu ti&ecirc;n cảm gi&aacute;c cầm nắm gọn g&agrave;ng.</p>\r\n<p>So với phi&ecirc;n bản tiền nhiệm, iPhone 18 Pro tập trung v&agrave;o m&agrave;n h&igrave;nh 6.3 inch, độ ph&acirc;n giải 2622 x 1206 pixel, chip A20 Pro, camera ch&iacute;nh Fusion 48MP, thời lượng xem video tối đa 34 giờ, 5G, Wi‑Fi 7, Bluetooth 6, modem C2, dung lượng phổ biến từ 256 GB đến 2TB, với c&aacute;c m&agrave;u Đen, Bạc, Băng Thanh, Đỏ Burgundy c&ugrave;ng Apple Intelligence thế hệ mới.</p>\r\n<p><a class=\"preventdefault\" href=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/apple-iphone-18-pro-color-1-639247267867325090.jpg\" rel=\"nofollow noopener\"><img class=\"lazyloaded\" title=\"iPhone 18 Pro - Thiết kế (Nguồn: Apple.com)\" src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/apple-iphone-18-pro-color-1-639247267867325090.jpg\" alt=\"iPhone 18 Pro - Thiết kế (Nguồn: Apple.com)\" data-src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/apple-iphone-18-pro-color-1-639247267867325090.jpg\"></a></p>\r\n<h4><strong>2.1. Thiết kế</strong></h4>\r\n<p>iPhone 18 Pro c&oacute; thiết kế nguy&ecirc;n khối nh&ocirc;m, tương tự với thế hệ tiền nhiệm</p>\r\n<p>Mặt trước sử dụng Ceramic Shield 2, c&ograve;n mặt lưng sử dụng Ceramic Shield. Thiết bị c&oacute; Action Button v&agrave; Camera Control, gi&uacute;p mở nhanh t&iacute;nh năng quen thuộc hoặc thao t&aacute;c với camera thuận tiện hơn. M&aacute;y d&ugrave;ng cổng USB‑C v&agrave; đạt chuẩn kh&aacute;ng nước, bụi IP68.</p>\r\n<p>Buồng hơi tản nhiệt thế hệ tiếp theo gi&uacute;p mang đến hiệu năng đỉnh k&eacute;o d&agrave;i đến 40% so với iPhone 17 Pro.</p>\r\n<h4><strong>2.2. M&agrave;n h&igrave;nh</strong></h4>\r\n<p>iPhone 18 Pro sử dụng m&agrave;n h&igrave;nh Super Retina XDR 6.3 inch, độ ph&acirc;n giải 2622 x 1206 pixel, c&ugrave;ng ProMotion đến 120Hz, M&agrave;n h&igrave;nh Lu&ocirc;n Bật, True Tone, HDR v&agrave; độ s&aacute;ng tối đa 1000 nit; 1600 nit HDR; 3000 nit ngo&agrave;i trời.</p>\r\n<p>Dynamic Island tr&ecirc;n iPhone 18 Pro được tinh chỉnh nhỏ hơn, hiển thị tối đa 3 Hoạt Động Trực Tiếp, gi&uacute;p kh&ocirc;ng gian hiển thị liền mạch hơn nhưng vẫn hỗ trợ theo d&otilde;i cuộc gọi, nhạc, hẹn giờ, điều hướng v&agrave; Hoạt Động Trực Tiếp.</p>\r\n<h4><strong>2.3. Chip xử l&yacute;</strong></h4>\r\n<p>iPhone 18 Pro d&ugrave;ng chip A20 Pro - thế hệ mới hơn so với A19 Pro tr&ecirc;n iPhone 17 Pro 256GB - với CPU 6 l&otilde;i, GPU 7 l&otilde;i v&agrave; Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i, tổng 32 l&otilde;i.</p>\r\n<p>Con chip n&agrave;y gồm CPU 6 l&otilde;i, GPU 7 l&otilde;i t&iacute;ch hợp Neural Accelerators nhanh hơn đến 40% so với A19 Pro, băng th&ocirc;ng bộ nhớ cao hơn 50% so với A19 Pro, buồng hơi thế hệ mới v&agrave; Apple Intelligence. Với nền tảng n&agrave;y, m&aacute;y hỗ trợ c&aacute;c t&aacute;c vụ AI c&aacute; nh&acirc;n như viết, chỉnh sửa nội dung, xử l&yacute; ảnh, dịch trực tiếp v&agrave; tương t&aacute;c với Siri.</p>\r\n<p><a class=\"preventdefault\" href=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-6-639246094742155382.jpg\" rel=\"nofollow noopener\"><img class=\"lazyloaded\" title=\"iPhone 18 Pro 256GB - chip A20 (Ảnh: Apple.com)\" src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-6-639246094742155382.jpg\" alt=\"iPhone 18 Pro 256GB - chip A20 (Ảnh: Apple.com)\" data-src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-6-639246094742155382.jpg\"></a></p>\r\n<h4><strong>2.4. Camera</strong></h4>\r\n<p>iPhone 18 Pro được trang bị camera ch&iacute;nh Fusion 48MP với khẩu độ t&ugrave;y chỉnh (&fnof;/1.48, &fnof;/1.8, &fnof;/2.8, &fnof;/4.0). Camera n&agrave;y hướng đến nhu cầu chụp ảnh chi tiết, quay video chất lượng cao v&agrave; xử l&yacute; linh hoạt nhiều bối cảnh từ đời thường đến s&aacute;ng tạo nội dung.</p>\r\n<p>Ở camera sau, điểm nhấn của iPhone 18 Pro nằm ở khẩu độ t&ugrave;y chỉnh với s&aacute;u lưỡi cắt laser v&agrave; cơ chế r&ocirc;-to mới, gi&uacute;p tối ưu khả năng thu s&aacute;ng, kiểm so&aacute;t độ s&acirc;u trường ảnh v&agrave; giữ chi tiết tốt hơn trong v&ugrave;ng tối. Đ&acirc;y l&agrave; nh&oacute;m n&acirc;ng cấp quan trọng với người thường chụp ch&acirc;n dung, phong cảnh, ảnh thiếu s&aacute;ng hoặc quay video trong nhiều điều kiện &aacute;nh s&aacute;ng kh&aacute;c nhau.</p>\r\n<p><a class=\"preventdefault\" href=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-4-639246090175378614.jpg\" rel=\"nofollow noopener\"><img class=\"lazyloaded\" title=\"iPhone 18 Pro 256GB - camera 48 MP (Ảnh: Apple.com)\" src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-4-639246090175378614.jpg\" alt=\"iPhone 18 Pro 256GB - camera 48 MP (Ảnh: Apple.com)\" data-src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-4-639246090175378614.jpg\"></a></p>\r\n<p>C&ocirc;ng cụ điều khiển Pro cho ph&eacute;p t&ugrave;y chỉnh c&aacute;c th&ocirc;ng số chụp như khẩu độ, tốc độ m&agrave;n trập, c&acirc;n bằng trắng v&agrave; theo d&otilde;i qua biểu đồ. Photographic Styles 3 gi&uacute;p hỗ trợ c&aacute; nh&acirc;n h&oacute;a ảnh với c&aacute;c t&ugrave;y chỉnh về kết cấu, độ nhiễu hạt v&agrave; hiệu ứng phim.</p>\r\n<p>Về video, iPhone 18 Pro hỗ trợ Time-lapse 4K Dolby Vision HDR, &aacute;p dụng hiệu ứng Điện Ảnh sau khi quay video ở tốc độ l&ecirc;n đến 60 fps, Action mode, Spatial Video, Log/ACES, Ghi H&igrave;nh K&eacute;p v&agrave; H&ograve;a &Acirc;m, đ&aacute;p ứng tốt nhu cầu quay video gia đ&igrave;nh, vlog, nội dung mạng x&atilde; hội v&agrave; c&aacute;c t&aacute;c vụ s&aacute;ng tạo chuy&ecirc;n s&acirc;u.</p>\r\n<h4><strong>2.5. Dung lượng khởi điểm 256 GB</strong></h4>\r\n<p>Dung lượng của iPhone 18 Pro khởi điểm từ 256 GB, ph&ugrave; hợp với người muốn trải nghiệm d&ograve;ng Pro nhưng vẫn giữ lựa chọn bộ nhớ dễ tiếp cận hơn c&aacute;c bản dung lượng cao. C&aacute;c t&ugrave;y chọn kh&aacute;c gồm 512 GB, 1 TB v&agrave; 2 TB.</p>\r\n<h4><strong>2.6. Pin, sạc v&agrave; tản nhiệt</strong></h4>\r\n<p>iPhone 18 Pro cho thời lượng xem video tối đa 34 giờ, tăng 3 giờ so với iPhone 17 Pro 256 GB, nhờ A20 Pro, buồng hơi thế hệ mới v&agrave; iOS 27.</p>\r\n<p>M&aacute;y sử dụng cổng USB‑C, hỗ trợ sạc c&oacute; d&acirc;y, MagSafe v&agrave; Qi2 đến 25W. Với sạc nhanh, iPhone 18 Pro c&oacute; thể sạc đến 50% trong khoảng 15 ph&uacute;t khi d&ugrave;ng c&aacute;p USB‑C v&agrave; bộ tiếp hợp 60W trở l&ecirc;n. C&aacute;c phi&ecirc;n bản cao cấp được tối ưu bằng buồng hơi thế hệ mới để duy tr&igrave; hiệu năng ổn định hơn.</p>\r\n<p><a class=\"preventdefault\" href=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-5-639246094729345447.jpg\" rel=\"nofollow noopener\"><img class=\"lazyloaded\" title=\"iPhone 18 Pro 256GB - dung lượng pin v&agrave; sạc (Ảnh: Apple.com)\" src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-5-639246094729345447.jpg\" alt=\"iPhone 18 Pro 256GB - dung lượng pin v&agrave; sạc (Ảnh: Apple.com)\" data-src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-burgundy-5-639246094729345447.jpg\"></a></p>\r\n<h4><strong>2.7. Kết nối, SIM v&agrave; eSIM</strong></h4>\r\n<p>iPhone 18 Pro hỗ trợ kết nối 5G, Wi‑Fi 7, Bluetooth 6 v&agrave; modem C2. Nhờ đ&oacute;, c&aacute;c t&aacute;c vụ như gọi video, tải dữ liệu, chia sẻ Điểm Truy Cập C&aacute; Nh&acirc;n, d&ugrave;ng bản đồ hoặc truy cập dịch vụ trực tuyến diễn ra mượt m&agrave; hơn.</p>\r\n<p>Về SIM, iPhone 18 Pro hỗ trợ SIM k&eacute;p nano‑SIM v&agrave; eSIM. H&igrave;nh thức n&agrave;y gi&uacute;p người d&ugrave;ng k&iacute;ch hoạt g&oacute;i cước, quản l&yacute; thu&ecirc; bao v&agrave; chuyển đổi giữa số c&aacute; nh&acirc;n, số c&ocirc;ng việc hoặc g&oacute;i cước du lịch thuận tiện hơn ngay tr&ecirc;n thiết bị.</p>\r\n<h4><strong>2.8. Apple Intelligence</strong></h4>\r\n<p>iPhone 18 Pro được tối ưu cho Apple Intelligence th&ocirc;ng qua chip A20 Pro, Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i, tổng 32 l&otilde;i v&agrave; băng th&ocirc;ng bộ nhớ cao hơn 50% so với A19 Pro. Nhờ đ&oacute;, thiết bị hỗ trợ c&aacute;c t&iacute;nh năng th&ocirc;ng minh như Định Lại Khung Kh&ocirc;ng Gian, Mở Rộng, Dọn Dẹp n&acirc;ng cấp, Image Playground v&agrave; Th&ocirc;ng B&aacute;o cho T&ocirc;i trong Safari ngay tr&ecirc;n iOS 27.</p>\r\n<p>Với Apple Intelligence, người d&ugrave;ng c&oacute; thể viết v&agrave; chỉnh sửa nội dung, tạo h&igrave;nh ảnh, xử l&yacute; ảnh, dịch trực tiếp, tra cứu th&ocirc;ng tin trực quan v&agrave; tương t&aacute;c với Siri theo c&aacute;ch tự nhi&ecirc;n hơn. C&aacute;c t&iacute;nh năng n&agrave;y được Apple triển khai theo hướng c&aacute; nh&acirc;n h&oacute;a trải nghiệm, đồng thời ch&uacute; trọng quyền ri&ecirc;ng tư v&agrave; khả năng xử l&yacute; tr&ecirc;n thiết bị.</p>\r\n<p>Apple Intelligence hiện c&oacute; hỗ trợ tiếng Việt. Siri AI hiện chỉ hỗ trợ tiếng Anh v&agrave; y&ecirc;u cầu thiết lập ng&ocirc;n ngữ thiết bị v&agrave; Apple Intelligence trong tiếng Anh.</p>\r\n<h3>3. iPhone 18 Pro c&oacute; mấy m&agrave;u?</h3>\r\n<p>iPhone 18 Pro c&oacute; 4 m&agrave;u gồm Đen, Bạc, Băng Thanh v&agrave; Đỏ Burgundy. Trong đ&oacute;, Đỏ Burgundy l&agrave; t&ugrave;y chọn mới nổi bật của thế hệ n&agrave;y, b&ecirc;n cạnh c&aacute;c m&agrave;u Đen, Bạc v&agrave; Băng Thanh.</p>\r\n<p><a class=\"preventdefault\" href=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-9-639246090305388694.jpg\" rel=\"nofollow noopener\"><img class=\"lazyloaded\" title=\"iPhone 18 Pro 256GB - c&aacute;c phi&ecirc;n bản m&agrave;u (Ảnh: Apple.com)\" src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-9-639246090305388694.jpg\" alt=\"iPhone 18 Pro 256GB - c&aacute;c phi&ecirc;n bản m&agrave;u (Ảnh: Apple.com)\" data-src=\"https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/370977/iphone-18-pro-glacier-9-639246090305388694.jpg\"></a></p>\r\n<h3>4. iPhone 18 Pro c&oacute; những dung lượng n&agrave;o?</h3>\r\n<p>iPhone 18 Pro c&oacute; c&aacute;c t&ugrave;y chọn dung lượng 256 GB, 512 GB, 1 TB v&agrave; 2 TB. Với dung lượng 2 TB, người d&ugrave;ng c&oacute; th&ecirc;m kh&ocirc;ng gian để lưu ảnh, video, ứng dụng, t&agrave;i liệu v&agrave; dữ liệu c&aacute; nh&acirc;n trong thời gian d&agrave;i.</p>\r\n<p>C&aacute;c phi&ecirc;n bản dung lượng cao như 512 GB, 1 TB v&agrave; 2 TB ph&ugrave; hợp với người thường quay video độ ph&acirc;n giải cao, lưu nhiều nội dung s&aacute;ng tạo hoặc muốn d&ugrave;ng thiết bị l&acirc;u d&agrave;i m&agrave; &iacute;t phải dọn bộ nhớ.</p>\r\n<h3>5. Bảng th&ocirc;ng số cấu h&igrave;nh iPhone 18 Pro</h3>\r\n<p>Bảng dưới đ&acirc;y tổng hợp nhanh cấu h&igrave;nh iPhone 18 Pro theo Apple c&ocirc;ng bố.</p>\r\n<div>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th>Ti&ecirc;u ch&iacute;</th>\r\n<th>iPhone 18 Pro</th>\r\n</tr>\r\n<tr>\r\n<td>M&agrave;n h&igrave;nh</td>\r\n<td>Super Retina XDR M&agrave;n h&igrave;nh Lu&ocirc;n Bật, True Tone v&agrave; HDR</td>\r\n</tr>\r\n<tr>\r\n<td>K&iacute;ch thước</td>\r\n<td>6.3 inch</td>\r\n</tr>\r\n<tr>\r\n<td>Tần số qu&eacute;t</td>\r\n<td>ProMotion đến 120 Hz</td>\r\n</tr>\r\n<tr>\r\n<td>Dynamic Island</td>\r\n<td>C&oacute;.</td>\r\n</tr>\r\n<tr>\r\n<td>Chất liệu</td>\r\n<td>Viền nh&ocirc;m h&agrave;n nguy&ecirc;n khối, Ceramic Shield 2 ph&iacute;a trước, Ceramic Shield mặt lưng</td>\r\n</tr>\r\n<tr>\r\n<td>Chip xử l&yacute;</td>\r\n<td>A20 Pro; CPU 6 l&otilde;i, GPU 7 l&otilde;i v&agrave; Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i.</td>\r\n</tr>\r\n<tr>\r\n<td>Camera</td>\r\n<td>\r\n<p>- Camera trước 18 MP Center Stage<br>- Camera ch&iacute;nh Fusion 48 MP với khẩu độ t&ugrave;y chỉnh (&fnof;/1.48, &fnof;/1.8, &fnof;/2.8, &fnof;/4.0).<br>- Camera Ultra Wide 48 MP<br>- Camera Telephoto Fusion hỗ trợ zoom 4x/8x</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>Video</td>\r\n<td>Time-lapse 4K Dolby Vision HDR, Điện Ảnh đến 60 fps, Action mode, Spatial Video, Log/ACES, Ghi H&igrave;nh K&eacute;p v&agrave; H&ograve;a &Acirc;m.</td>\r\n</tr>\r\n<tr>\r\n<td>Pin</td>\r\n<td>Xem video đến 34 giờ; sạc c&oacute; d&acirc;y đến 50% trong khoảng 15 ph&uacute;t.</td>\r\n</tr>\r\n<tr>\r\n<td>Kết nối</td>\r\n<td>5G, Wi‑Fi 7, Bluetooth 6, modem C2 v&agrave; Thread.</td>\r\n</tr>\r\n<tr>\r\n<td>Cổng/sạc</td>\r\n<td>USB‑C, USB 3 đến 10Gb/s; MagSafe v&agrave; Qi2 đến 25W.</td>\r\n</tr>\r\n<tr>\r\n<td>SIM/eSIM</td>\r\n<td>SIM k&eacute;p nano‑SIM v&agrave; eSIM.</td>\r\n</tr>\r\n<tr>\r\n<td>Dung lượng</td>\r\n<td>256 GB, 512 GB, 1 TB v&agrave; 2 TB.</td>\r\n</tr>\r\n<tr>\r\n<td>M&agrave;u sắc</td>\r\n<td>Đen, Bạc, Băng Thanh v&agrave; Đỏ Burgundy.</td>\r\n</tr>\r\n<tr>\r\n<td>Kh&aacute;ng nước, bụi</td>\r\n<td>IP68, chống nước ở độ s&acirc;u tối đa 6 m&eacute;t trong tối đa 30 ph&uacute;t theo IEC 60529.</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<h3>6. iPhone 18 Pro c&oacute; gi&aacute; bao nhi&ecirc;u?</h3>\r\n<p>iPhone 18 Pro c&oacute; gi&aacute; khởi điểm từ 38.990.000đ cho phi&ecirc;n bản 256 GB. C&aacute;c phi&ecirc;n bản dung lượng cao hơn gồm 512 GB từ 45.490.000đ, 1 TB từ 58.490.000đ v&agrave; 2 TB từ 77.990.000đ. <em>(Theo gi&aacute; b&aacute;n tại Thế giới di động)</em></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th>Phi&ecirc;n bản</th>\r\n<th>Gi&aacute; b&aacute;n tại Apple Việt Nam</th>\r\n<th>Gi&aacute; b&aacute;n tại TGDĐ</th>\r\n</tr>\r\n<tr>\r\n<td>iPhone 18 Pro 256GB</td>\r\n<td>Từ 38.999.000đ</td>\r\n<td>Từ 38.990.000đ</td>\r\n</tr>\r\n<tr>\r\n<td><a title=\"iPhone 18 Pro 512 GB tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd/iphone-18-pro-512gb\" target=\"_blank\" rel=\"noopener\">iPhone 18 Pro 512GB</a></td>\r\n<td>Từ 45.499.000đ</td>\r\n<td>Từ 45.490.000đ</td>\r\n</tr>\r\n<tr>\r\n<td><a title=\"iPhone 18 Pro 1 TB tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd/iphone-18-pro-1tb\" target=\"_blank\" rel=\"noopener\">iPhone 18 Pro 1TB</a></td>\r\n<td>Từ 58.499.000đ</td>\r\n<td>Từ 58.490.000đ</td>\r\n</tr>\r\n<tr>\r\n<td><a title=\"iPhone 18 Pro 2 TB tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd/iphone-18-pro-2tb\" target=\"_blank\" rel=\"noopener\">iPhone 18 Pro 2TB</a></td>\r\n<td>Từ 77.999.000đ</td>\r\n<td>Từ 77.990.000đ</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div>\r\n<p><em>Gi&aacute; b&aacute;n được cập nhật ng&agrave;y 10/09/2026, th&ocirc;ng tin gi&aacute; c&oacute; thể thay đổi theo thời gian</em></p>\r\n</div>\r\n<h3>7. So s&aacute;nh iPhone 18 Pro với iPhone 17 Pro v&agrave; iPhone 16 Pro</h3>\r\n<table>\r\n<thead>\r\n<tr>\r\n<th>Ti&ecirc;u ch&iacute;</th>\r\n<th>iPhone 18 Pro</th>\r\n<th><a title=\"Điện thoại iPhone 17 Pro tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd/iphone-17-pro\" target=\"_blank\" rel=\"noopener\">iPhone 17 Pro</a></th>\r\n<th><a title=\"Điện thoại iPhone 16 Pro tại Thegioididong\" href=\"https://www.thegioididong.com/dtdd/iphone-16-pro\" target=\"_blank\" rel=\"noopener\">iPhone 16 Pro</a></th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>Thời điểm ra mắt</td>\r\n<td>10/09/2026</td>\r\n<td>10/09/2025</td>\r\n<td>09/09/2024</td>\r\n</tr>\r\n<tr>\r\n<td>M&agrave;n h&igrave;nh</td>\r\n<td>Super Retina XDR OLED 6.3 inch, ProMotion 120 Hz, Dynamic Island nhỏ gọn hơn, đỉnh 3.000 nit ngo&agrave;i trời</td>\r\n<td>Super Retina XDR OLED 6.3 inch, ProMotion 120 Hz, Dynamic Island, đỉnh 3.000 nit ngo&agrave;i trời</td>\r\n<td>Super Retina XDR OLED 6.3 inch, ProMotion 120 Hz, Dynamic Island, đỉnh 2.000 nit ngo&agrave;i trời</td>\r\n</tr>\r\n<tr>\r\n<td>Chất liệu &amp; Mặt k&iacute;nh</td>\r\n<td>Nh&ocirc;m nguy&ecirc;n khối; Mặt trước Ceramic Shield 2, mặt sau Ceramic Shield</td>\r\n<td>Nh&ocirc;m nguy&ecirc;n khối; Mặt trước Ceramic Shield 2, mặt sau Ceramic Shield</td>\r\n<td>Khung titan; Mặt trước Ceramic Shield</td>\r\n</tr>\r\n<tr>\r\n<td>Chip xử l&yacute;</td>\r\n<td>A20 Pro (2 nm), CPU 6 l&otilde;i (2 l&otilde;i si&ecirc;u xử l&yacute;), GPU 7 l&otilde;i với Neural Accelerators, Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i</td>\r\n<td>A19 Pro, CPU 6 l&otilde;i (2 l&otilde;i hiệu năng), GPU 6 l&otilde;i với Neural Accelerators, Neural Engine 16 l&otilde;i</td>\r\n<td>A18 Pro, CPU 6 l&otilde;i (2 l&otilde;i hiệu năng), GPU 6 l&otilde;i, Neural Engine 16 l&otilde;i</td>\r\n</tr>\r\n<tr>\r\n<td>Tản nhiệt</td>\r\n<td>Buồng hơi thế hệ mới (diện t&iacute;ch bề mặt lớn gấp 3 lần)</td>\r\n<td>Buồng hơi thế hệ trước</td>\r\n<td>Cấu tr&uacute;c khung nh&ocirc;m tản nhiệt qua tấm graphite</td>\r\n</tr>\r\n<tr>\r\n<td>Camera ch&iacute;nh</td>\r\n<td>48 MP Fusion Main với khẩu độ thay đổi (&fnof;/1.48, &fnof;/1.8, &fnof;/2.8, &fnof;/4.0), OIS Sensor-shift Gen 2</td>\r\n<td>48 MP Fusion Main, OIS Sensor-shift Gen 2</td>\r\n<td>48 MP Fusion Main, OIS Sensor-shift Gen 2</td>\r\n</tr>\r\n<tr>\r\n<td>Camera Telephoto</td>\r\n<td>48 MP Fusion Telephoto, zoom quang 4x (100 mm) v&agrave; 8x quang học chất lượng cao (200 mm)</td>\r\n<td>48 MP Fusion Telephoto, zoom quang 4x (100 mm) v&agrave; 8x quang học chất lượng cao (200 mm)</td>\r\n<td>12 MP Telephoto, zoom quang 5x (120 mm)</td>\r\n</tr>\r\n<tr>\r\n<td>Camera trước</td>\r\n<td>18 MP Center Stage (chạm để thu ph&oacute;ng v&agrave; xoay, Ghi H&igrave;nh K&eacute;p)</td>\r\n<td>18 MP Center Stage (chạm để thu ph&oacute;ng v&agrave; xoay, Ghi H&igrave;nh K&eacute;p)</td>\r\n<td>12 MP TrueDepth (chạm để thu ph&oacute;ng)</td>\r\n</tr>\r\n<tr>\r\n<td>Thời lượng xem video</td>\r\n<td>L&ecirc;n đến 34 giờ (trực tuyến 31 giờ, m&ocirc; phỏng 23 giờ)</td>\r\n<td>L&ecirc;n đến 31 giờ (trực tuyến 28 giờ)</td>\r\n<td>L&ecirc;n đến 27 giờ (trực tuyến 22 giờ)</td>\r\n</tr>\r\n<tr>\r\n<td>Tốc độ sạc c&oacute; d&acirc;y</td>\r\n<td>50% trong ~15 ph&uacute;t (với củ sạc 60 W hỗ trợ AVS)</td>\r\n<td>50% trong 20 ph&uacute;t (với củ sạc 40 W)</td>\r\n<td>50% trong 30 ph&uacute;t (với củ sạc 20 W)</td>\r\n</tr>\r\n<tr>\r\n<td>Kết nối kh&ocirc;ng d&acirc;y</td>\r\n<td>Wi‑Fi 7, Bluetooth 6, Thread, chip Apple N1, modem Apple C2</td>\r\n<td>Wi‑Fi 7, Bluetooth 6, Thread</td>\r\n<td>Wi‑Fi 7, Bluetooth 5.3, Thread</td>\r\n</tr>\r\n<tr>\r\n<td>SIM</td>\r\n<td>SIM k&eacute;p (nano‑SIM v&agrave; eSIM)</td>\r\n<td>SIM k&eacute;p (nano‑SIM v&agrave; eSIM)</td>\r\n<td>SIM k&eacute;p (nano‑SIM v&agrave; eSIM)</td>\r\n</tr>\r\n<tr>\r\n<td>Dung lượng lưu trữ</td>\r\n<td>256 GB (t&ugrave;y chọn 512 GB, 1 TB, 2 TB)</td>\r\n<td>256 GB (t&ugrave;y chọn 512 GB, 1 TB)</td>\r\n<td>256 GB (t&ugrave;y chọn 128 GB, 512 GB, 1 TB)</td>\r\n</tr>\r\n<tr>\r\n<td>M&agrave;u sắc</td>\r\n<td>Đen, Bạc, Băng Thanh, Đỏ Burgundy</td>\r\n<td>Cam Vũ Trụ, Xanh Đậm, Bạc</td>\r\n<td>Titan Sa Mạc, Titan Tự Nhi&ecirc;n, Titan Trắng, Titan Đen</td>\r\n</tr>\r\n<tr>\r\n<td>Kh&aacute;ng nước, bụi</td>\r\n<td>IP68 (6 m trong 30 ph&uacute;t)</td>\r\n<td>IP68 (6 m trong 30 ph&uacute;t)</td>\r\n<td>IP68</td>\r\n</tr>\r\n<tr>\r\n<td>K&iacute;ch thước &amp; Trọng lượng</td>\r\n<td>150.0 x 71.9 x 8.75 mm; 211 g</td>\r\n<td>150.0 x 71.9 x 8.75 mm; 204 g</td>\r\n<td>149.6 x 71.5 x 8.25 mm; 199 g</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<h3>8. So s&aacute;nh iPhone 18 Pro vs iPhone 18 Pro Max</h3>\r\n<h3>&nbsp;</h3>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th>Ti&ecirc;u ch&iacute;</th>\r\n<th>iPhone 18 Pro</th>\r\n<th>iPhone 18 Pro Max</th>\r\n</tr>\r\n<tr>\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>Super Retina XDR 6.3 inch</td>\r\n<td>Super Retina XDR 6.9 inch</td>\r\n</tr>\r\n<tr>\r\n<td>Độ ph&acirc;n giải</td>\r\n<td>2622 x 1206 pixel, 460 ppi</td>\r\n<td>2868 x 1320 pixel, 460 ppi</td>\r\n</tr>\r\n<tr>\r\n<td>Độ s&aacute;ng &amp; c&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td colspan=\"2\">ProMotion 120Hz, Lu&ocirc;n Bật, Dynamic Island, 1000 nit (thường), 1600 nit (HDR), 3000 nit (ngo&agrave;i trời), lớp phủ chống phản chiếu mới</td>\r\n</tr>\r\n<tr>\r\n<td>K&iacute;ch thước m&aacute;y</td>\r\n<td>71.9 x 150.0 x 8.75 mm</td>\r\n<td>78.0 x 163.4 x 8.75 mm</td>\r\n</tr>\r\n<tr>\r\n<td>Khối lượng</td>\r\n<td>211 gram</td>\r\n<td>249 gram</td>\r\n</tr>\r\n<tr>\r\n<td>Chip xử l&yacute;</td>\r\n<td colspan=\"2\">A20 Pro (2nm); CPU 6 l&otilde;i, GPU 7 l&otilde;i (Neural Accelerators), Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i, dựng h&igrave;nh tia s&aacute;ng (ray tracing) phần cứng</td>\r\n</tr>\r\n<tr>\r\n<td>Camera sau</td>\r\n<td colspan=\"2\">Fusion 48MP ch&iacute;nh (khẩu độ t&ugrave;y chỉnh &fnof;/1,48&ndash;&fnof;/4,0), Ultra Wide 48MP (&fnof;/2,2), Telephoto 48MP 4x/100mm (k&egrave;m tele quang học 8x/200mm), zoom quang học 16x &mdash; <em>lần đầu ti&ecirc;n 2 bản Pro c&oacute; camera giống hệt nhau</em></td>\r\n</tr>\r\n<tr>\r\n<td>Camera trước</td>\r\n<td colspan=\"2\">18MP Center Stage, &fnof;/1,9</td>\r\n</tr>\r\n<tr>\r\n<td>Pin &ndash; Xem video</td>\r\n<td>Đến 34 giờ</td>\r\n<td>Đến 43 giờ</td>\r\n</tr>\r\n<tr>\r\n<td>Sạc</td>\r\n<td colspan=\"2\">MagSafe &amp; Qi2 đến 25W, sạc d&acirc;y 50% trong ~15 ph&uacute;t (bộ sạc 60W+ c&oacute; AVS), MagSafe 50% trong ~30 ph&uacute;t</td>\r\n</tr>\r\n<tr>\r\n<td>Kết nối</td>\r\n<td colspan=\"2\">5G, chip N1 (Wi‑Fi 7, Bluetooth 6, Thread), modem C2, Ultra Wideband thế hệ 2</td>\r\n</tr>\r\n<tr>\r\n<td>SIM/eSIM (bản Việt Nam)</td>\r\n<td colspan=\"2\">1 Nano‑SIM + 1 eSIM</td>\r\n</tr>\r\n<tr>\r\n<td>Dung lượng lưu trữ</td>\r\n<td colspan=\"2\">256 GB, 512 GB, 1 TB, 2 TB</td>\r\n</tr>\r\n<tr>\r\n<td>M&agrave;u sắc</td>\r\n<td colspan=\"2\">Đen, Bạc, Băng Thanh, Đỏ Burgundy</td>\r\n</tr>\r\n<tr>\r\n<td>Kh&aacute;ng nước, bụi</td>\r\n<td colspan=\"2\">IP68</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<h3>9. C&acirc;u hỏi thường gặp về iPhone 18 Pro</h3>\r\n<h4><strong>iPhone 18 Pro d&ugrave;ng chip g&igrave;?</strong></h4>\r\n<p>iPhone 18 Pro sử dụng chip A20 Pro. Về cấu h&igrave;nh, chip n&agrave;y gồm CPU 6 l&otilde;i, GPU 7 l&otilde;i t&iacute;ch hợp Neural Accelerators v&agrave; Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i, hỗ trợ hiệu năng xử l&yacute;, đồ họa v&agrave; Apple Intelligence.</p>\r\n<h4><strong>iPhone 18 Pro c&oacute; đủ d&ugrave;ng kh&ocirc;ng?</strong></h4>\r\n<p>iPhone 18 Pro ph&ugrave; hợp với người d&ugrave;ng cần một mẫu iPhone c&oacute; hiệu năng mạnh, m&agrave;n h&igrave;nh cao cấp v&agrave; dung lượng lưu trữ linh hoạt. Với dung lượng 256 GB, m&aacute;y đ&aacute;p ứng tốt nhu cầu lưu ảnh, video, ứng dụng, t&agrave;i liệu v&agrave; dữ liệu c&aacute; nh&acirc;n; người d&ugrave;ng c&oacute; thể chọn th&ecirc;m c&aacute;c mức 512 GB, 1 TB hoặc 2 TB.</p>\r\n<h4><strong>iPhone 18 Pro c&oacute; m&agrave;u g&igrave; mới?</strong></h4>\r\n<p>iPhone 18 Pro c&oacute; c&aacute;c m&agrave;u Đen, Bạc, Băng Thanh v&agrave; Đỏ Burgundy. Đỏ Burgundy l&agrave; t&ugrave;y chọn nổi bật của thế hệ n&agrave;y, b&ecirc;n cạnh c&aacute;c m&agrave;u Đen, Bạc v&agrave; Băng Thanh.</p>\r\n<h4><strong>Camera iPhone 18 Pro c&oacute; g&igrave; mới?</strong></h4>\r\n<p>Camera iPhone 18 Pro nổi bật với camera ch&iacute;nh Fusion 48MP, cảm biến mới v&agrave; khẩu độ t&ugrave;y chỉnh với s&aacute;u lưỡi cắt laser c&ugrave;ng cơ chế r&ocirc;-to mới, gi&uacute;p cải thiện khả năng kiểm so&aacute;t &aacute;nh s&aacute;ng, độ s&acirc;u trường ảnh, chi tiết v&ugrave;ng tối v&agrave; chất lượng h&igrave;nh ảnh trong nhiều điều kiện chụp/quay kh&aacute;c nhau.</p>\r\n<h4><strong>Thời lượng pin của iPhone 18 Pro l&agrave; bao l&acirc;u?</strong></h4>\r\n<p>iPhone 18 Pro cho thời lượng xem video tối đa 34 giờ - tăng 3 giờ so với iPhone 17 Pro 256GB - đồng thời hỗ trợ sạc c&oacute; d&acirc;y đến 50% trong khoảng 15 ph&uacute;t, MagSafe đến 50% trong 30 ph&uacute;t v&agrave; MagSafe v&agrave; Qi2 đến 25W.</p>\r\n<h4><strong>iPhone 18 Pro d&ugrave;ng cổng sạc g&igrave;?</strong></h4>\r\n<p>iPhone 18 Pro sử dụng cổng USB‑C, hỗ trợ sạc v&agrave; DisplayPort, đồng thời tương th&iacute;ch với c&aacute;p sạc USB‑C, bộ tiếp hợp 60W trở l&ecirc;n v&agrave; Bộ Sạc MagSafe.</p>\r\n<h4><strong>iPhone 18 Pro c&oacute; eSIM kh&ocirc;ng?</strong></h4>\r\n<p>iPhone 18 Pro hỗ trợ SIM k&eacute;p nano‑SIM v&agrave; eSIM tại thị trường Việt Nam.</p>\r\n<h4><strong>iPhone 18 Pro c&oacute; Dynamic Island kh&ocirc;ng?</strong></h4>\r\n<p>iPhone 18 Pro hỗ trợ Dynamic Island, hiển thị c&ugrave;ng l&uacute;c tối đa 3 Hoạt Động Trực Tiếp. Dynamic Island gi&uacute;p theo d&otilde;i cuộc gọi, nhạc, hẹn giờ, điều hướng v&agrave; Hoạt Động Trực Tiếp ngay tr&ecirc;n m&agrave;n h&igrave;nh.</p>\r\n<p><em>iPhone 18 Pro mang đến nhiều n&acirc;ng cấp đ&aacute;ng ch&uacute; &yacute; về thiết kế nguy&ecirc;n khối nh&ocirc;m, m&agrave;n h&igrave;nh 6,3 inch, độ ph&acirc;n giải 2622 x 1206 pixel, chip A20 Pro, camera ch&iacute;nh Fusion 48MP, 5G, Wi‑Fi 7, Bluetooth 6, modem C2, m&agrave;u Đen, Bạc, Băng Thanh v&agrave; Đỏ Burgundy c&ugrave;ng dung lượng 256GB, 512GB, 1TB v&agrave; 2TB theo c&ocirc;ng bố của Apple. Đ&acirc;y l&agrave; lựa chọn đ&aacute;ng ch&uacute; &yacute; với người d&ugrave;ng đang quan t&acirc;m đến một mẫu iPhone Pro c&oacute; hiệu năng mạnh, camera linh hoạt v&agrave; kh&ocirc;ng gian lưu trữ ph&ugrave; hợp nhu cầu sử dụng l&acirc;u d&agrave;i.</em></p>', 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1790023153/products/main/xd8r5pfh4egb7tqyi5h7.jpg', 9, 13, '2026-09-21 20:39:15', '<table style=\"border-collapse: collapse; width: 99.9807%;\" border=\"1\"><colgroup><col style=\"width: 99.9034%;\"></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: center;\"><strong>Th&ocirc;ng tin sản phẩm</strong></td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<ul>\r\n<li>M&agrave;n h&igrave;nh Super Retina XDR 6.3 inch, hỗ trợ ProMotion 120Hz, Always-On, HDR v&agrave; Dynamic Island.</li>\r\n<li>Chip A20 Pro với CPU 6 l&otilde;i, GPU 7 l&otilde;i v&agrave; Bộ Đ&ocirc;i Neural Engine 16 l&otilde;i, tối ưu cho Apple Intelligence.</li>\r\n<li>Camera ch&iacute;nh Fusion 48MP với khẩu độ t&ugrave;y chỉnh &fnof;/1.48 - &fnof;/4.0, hỗ trợ quay chụp linh hoạt.</li>\r\n<li>Bộ nhớ từ 256GB đến 2TB, đ&aacute;p ứng đa dạng nhu cầu lưu ảnh, video, ứng dụng v&agrave; dữ liệu.</li>\r\n<li>Thời lượng xem video đến 34 giờ, hỗ trợ sạc nhanh, MagSafe v&agrave; Qi2.</li>\r\n<li>Hỗ trợ nano-SIM, eSIM, modem C2, Wi-Fi 7 v&agrave; Bluetooth 6.</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reason_text` varchar(255) NOT NULL,
  `ban_days` int(11) DEFAULT 0,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reports`
--

INSERT INTO `reports` (`id`, `reason_text`, `ban_days`, `isDeleted`) VALUES
(1, 'Spam', 1, 0),
(2, 'Hành vi thù địch', 7, 0),
(3, 'Lạm dụng tính năng', 3, 0),
(4, 'Vi phạm nội quy nghiêm trọng', 30, 0),
(5, 'Spam', 1, 0),
(6, 'Hành vi thù địch', 7, 0),
(7, 'Lạm dụng tính năng', 3, 0),
(8, 'Vi phạm nội quy nghiêm trọng', 30, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `comment`, `user_id`, `product_id`, `isDeleted`, `created_at`) VALUES
(5, 4, '<p>Giao h&agrave;ng nhanh 🚚. Đ&oacute;ng g&oacute;i cẩn thận 🎁. Tư vấn nhiệt t&igrave;nh 💬. Sản phẩm chất lượng ⭐. Gi&aacute; cả hợp l&yacute; 💰</p>', 6, 36, 0, '2026-09-23 18:59:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `isDeleted`, `created_at`) VALUES
(1, 'Quản lý đơn hàng', 0, '2025-07-26 12:01:16'),
(2, 'Quản lý giao hàng', 0, '2025-08-12 12:43:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_employee`
--

CREATE TABLE `role_employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role_employee`
--

INSERT INTO `role_employee` (`id`, `employee_id`, `role_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:06:42'),
(8, 3, 2, 0, '2025-08-12 18:53:22'),
(9, 3, 1, 0, '2025-08-12 18:53:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role_menu`
--

INSERT INTO `role_menu` (`id`, `menu_id`, `role_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:01:16'),
(2, 2, 1, 0, '2025-08-12 12:37:24'),
(3, 3, 2, 0, '2025-08-12 12:43:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `shipping_at` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shipping`
--

INSERT INTO `shipping` (`id`, `address`, `method`, `status`, `shipping_at`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:21:14', '2025-07-19 14:21:14'),
(2, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:24:55', '2025-07-19 14:24:55'),
(3, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:27:49', '2025-07-19 14:27:49'),
(4, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:40:31', '2025-07-19 14:40:31'),
(5, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:42:09', '2025-07-19 14:42:09'),
(6, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-19 07:42:54', '2025-07-19 14:42:54'),
(7, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 04:36:23', '2025-07-20 11:36:23'),
(8, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 04:36:51', '2025-07-20 11:36:51'),
(9, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 04:44:42', '2025-07-20 11:44:42'),
(10, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 04:52:35', '2025-07-20 11:52:35'),
(11, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:05:18', '2025-07-20 12:05:18'),
(12, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:20:44', '2025-07-20 12:20:44'),
(13, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:20:50', '2025-07-20 12:20:50'),
(14, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:21:16', '2025-07-20 12:21:16'),
(15, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:21:34', '2025-07-20 12:21:34'),
(16, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:24:06', '2025-07-20 12:24:06'),
(17, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:24:11', '2025-07-20 12:24:11'),
(18, NULL, 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-20 05:24:18', '2025-07-20 12:24:18'),
(19, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-22 18:13:02', '2025-07-23 01:13:02'),
(20, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-22 18:13:09', '2025-07-23 01:13:09'),
(22, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-26 12:23:34', '2025-08-12 02:48:55'),
(23, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-07-26 12:24:47', '2025-08-10 00:22:04'),
(24, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-08-09 15:06:47', '2025-08-09 22:06:47'),
(27, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-08-12 12:54:09', '2025-08-12 19:54:51'),
(30, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-12-16 15:33:28', '2025-12-16 22:33:28'),
(31, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-12-16 15:33:48', '2025-12-16 22:33:48'),
(41, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:18:43', '2026-09-21 04:24:39'),
(42, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:19:26', '2026-09-21 04:24:36'),
(43, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:20:41', '2026-09-21 04:24:33'),
(44, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:21:09', '2026-09-21 04:24:31'),
(45, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:24:53', '2026-09-21 04:26:23'),
(46, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:28:24', '2026-09-21 04:34:22'),
(47, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2026-09-20 21:34:39', '2026-09-21 04:34:39'),
(48, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-20 21:38:44', '2026-09-21 04:45:20'),
(49, '296/GS, ấp Giồng Sao, xã An Hiệp, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2026-09-20 21:45:32', '2026-09-24 01:44:13'),
(50, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-21 12:31:16', '2026-09-21 19:40:40'),
(51, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 1, '2026-09-21 12:32:14', '2026-09-21 19:40:44'),
(52, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2026-09-23 19:30:19', '2026-09-24 02:30:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`id`, `name`, `isDeleted`) VALUES
(1, 'Chờ xử lý', 0),
(2, 'Đã xác nhận', 0),
(3, 'Đang chuyển hàng', 0),
(4, 'Đang giao hàng', 0),
(5, 'Đã hủy', 0),
(6, 'Giao hàng thành công', 0),
(7, 'Đã xác nhận chuyển khoản (Chờ đối soát)', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `Phone`, `Email`, `Address`, `image_url`, `isDeleted`) VALUES
(2, 'Dell', 'Mai Chí Vĩnh', '0795906808', 'vinh092004@gmail.com', 'Xã An Hiệp, tỉnh Vĩnh Long', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766947/suppliers/sg7z2pnyn1pdrfzwmkvj.png', 0),
(3, 'MSI', 'BìnB', '(+84) 394 529 044', 'lephuocbinh@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766923/suppliers/wtyzzpa7f0otlq0lpybs.png', 0),
(4, 'Lenovo', 'BìnB', '0394529044', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766979/suppliers/nzw4ipqfsjmdfskazffr.png', 0),
(7, 'Asus', 'Mai Chí Vĩnh', '0775906808', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766881/suppliers/zcwbqvd2caxuxqddfcos.svg', 0),
(8, 'HP', 'Mai Chí Vĩnh', '0394529044', 'vinh092004@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752767520/suppliers/obfs1i458ad2pyyqqgjo.png', 0),
(13, 'Apple', 'Chí Vĩnh', '0123456789', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752818631/products/main/temvdmmnwzoztrtslrqm.png', 0),
(14, 'Watch', 'Mai Chí Vĩnh', '0394529044', 'vinh.watch@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830127/products/main/bfcmjywvnwus141gg5si.png', 1),
(17, 'SamSung', 'testing', '987654321', 'testing@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1754939954/suppliers/qvybuusbsq9ubordc60n.jpg', 0),
(18, 'HUAWEI', 'Nguyễn Văn Khánh', '0987654321', 'ngvkhanh@huawei.com', 'Tháp Mười', 'https://res.cloudinary.com/dukqsdc4b/image/upload/v1783184719/products/main/qg82wadynbvzutmjx8ro.png', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `PasswordHash` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `UpdateAt` datetime DEFAULT NULL,
  `deleted_by_id` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `deleted_by_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `FullName`, `Email`, `Phone`, `Address`, `PasswordHash`, `CreatedAt`, `isDeleted`, `UpdateAt`, `deleted_by_id`, `deleted_at`, `reason`, `deleted_by_type`) VALUES
(6, 'Mai Chí Vĩnh', 'chivinh260904@gmail.com', '0399999999', 'xã An Hiệp, tỉnh Vĩnh Long', '$2y$10$rXwysmPklQYJHi0n4eZ9yu.DH.6.ESOFAC8LN3MkXJ4NYs0HYqoe6', '2026-09-21 01:31:38', 0, '2026-09-24 02:43:20', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_reports`
--

CREATE TABLE `user_reports` (
  `id` int(11) NOT NULL,
  `reported_user_id` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `banned_by_user_id` int(11) DEFAULT NULL,
  `banned_by_role` varchar(50) DEFAULT NULL,
  `banned_from` datetime DEFAULT NULL,
  `banned_until` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ai_chat_logs`
--
ALTER TABLE `ai_chat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ai_knowledge_base`
--
ALTER TABLE `ai_knowledge_base`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `competitor_prices`
--
ALTER TABLE `competitor_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Chỉ mục cho bảng `employee_menu`
--
ALTER TABLE `employee_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Chỉ mục cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Chỉ mục cho bảng `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_id` (`shipping_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role_employee`
--
ALTER TABLE `role_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `user_reports`
--
ALTER TABLE `user_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reported_user_id` (`reported_user_id`),
  ADD KEY `reason_id` (`reason_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `ai_chat_logs`
--
ALTER TABLE `ai_chat_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ai_knowledge_base`
--
ALTER TABLE `ai_knowledge_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT cho bảng `competitor_prices`
--
ALTER TABLE `competitor_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `employee_menu`
--
ALTER TABLE `employee_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT cho bảng `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `role_employee`
--
ALTER TABLE `role_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user_reports`
--
ALTER TABLE `user_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `competitor_prices`
--
ALTER TABLE `competitor_prices`
  ADD CONSTRAINT `competitor_prices_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Các ràng buộc cho bảng `employee_menu`
--
ALTER TABLE `employee_menu`
  ADD CONSTRAINT `employee_menu_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `role_employee`
--
ALTER TABLE `role_employee`
  ADD CONSTRAINT `role_employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `role_employee_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Các ràng buộc cho bảng `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `role_menu_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Các ràng buộc cho bảng `user_reports`
--
ALTER TABLE `user_reports`
  ADD CONSTRAINT `user_reports_ibfk_1` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_reports_ibfk_2` FOREIGN KEY (`reason_id`) REFERENCES `reports` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
