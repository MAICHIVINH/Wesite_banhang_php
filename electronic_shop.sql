-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 08:38 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electronic_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
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
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password_hash`, `email`, `role`, `created_at`, `isDeleted`) VALUES
(1, 'Vĩnh', '123456', 'vinh092004@gmail.com', 'admin', '2025-07-18 07:09:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
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
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `email`, `isDeleted`, `created_at`, `updated_at`) VALUES
(1, 'HOÀNG VĂN THỤ', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'hoangvanthu1234@gmail.com', 0, '2025-07-19 07:19:46', '2025-07-19 14:19:46'),
(2, 'NGUYỄN VĂN CỪ', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'nguyenvancu@gmail.com', 0, '2025-07-20 13:39:03', '2025-07-20 20:39:03'),
(3, 'BÙI THỊ XUÂN', '123 đường 456, xã 789, tỉnh 8910', '0123456789', 'vinh092004@gmail.com', 0, '2025-08-09 15:29:05', '2025-08-09 22:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `created_at`, `isDeleted`, `status`) VALUES
(1, 'Laptop', 'https://res.cloudinary.com/direvsslz/image/upload/v1754847890/products/main/kgzdzktmrpnwqg4dt4et.webp', '2025-06-22 02:55:58', 0, 0),
(3, 'Tai nghe', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766513/products/main/bdrsuzg7o5r73xsloznv.png', '2025-07-17 15:35:14', 1, 1),
(4, 'Tai nghe', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766584/products/main/mpizy1yrqqxmgvsk8hpk.png', '2025-07-17 15:36:26', 1, 1),
(6, 'Màn hình', 'https://res.cloudinary.com/direvsslz/image/upload/v1754829759/products/main/xkseimkyevdivj3bgh6t.webp', '2025-08-10 12:42:40', 0, 0),
(7, 'Đồng hồ', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830309/products/main/hxsq5y2dzanq3bggurxe.webp', '2025-08-10 12:51:49', 0, 0),
(8, 'Tai nghe', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830485/products/main/tyuzwsgpzdg7cuo5z3xp.jpg', '2025-08-10 12:54:46', 0, 0),
(9, 'Điện thoại', 'https://res.cloudinary.com/direvsslz/image/upload/v1754832618/products/main/rjsz8z4wkzebegoxekik.webp', '2025-08-10 13:30:19', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
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
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `sender_id`, `sender_role`, `message`, `created_at`, `isDeleted`) VALUES
(1, 1, NULL, 'user', '4', '2025-07-18 22:16:30', 0),
(2, 1, NULL, 'user', 'alooooo', '2025-07-18 22:16:46', 0),
(3, 1, NULL, 'user', 'alooooo', '2025-07-18 22:18:52', 0),
(4, 1, NULL, 'user', 'alooooo', '2025-07-18 22:18:57', 0),
(5, 1, NULL, 'user', 'Hello', '2025-07-18 22:19:19', 0),
(6, 1, 1, 'admin', 'lo cc', '2025-07-18 22:19:49', 0),
(7, 1, NULL, 'user', 'Hello', '2025-07-18 22:19:57', 0),
(8, 1, NULL, 'user', 'Hello', '2025-07-18 22:24:22', 0),
(9, 1, NULL, 'user', 'Hello', '2025-07-18 22:24:43', 0),
(10, 1, NULL, 'user', 'Hello', '2025-07-18 22:24:52', 0),
(11, 1, NULL, 'user', 'llllllllllll', '2025-07-18 22:25:02', 0),
(12, 1, 1, 'admin', '123', '2025-07-18 22:25:15', 0),
(13, 1, NULL, 'user', 'llllllllllll', '2025-07-18 22:25:22', 0),
(14, 1, NULL, 'user', 'llllllllllll', '2025-07-18 22:26:37', 0),
(15, 1, NULL, 'user', 'llllllllllll', '2025-07-18 22:31:40', 0),
(16, 1, NULL, 'user', '5', '2025-07-18 22:38:49', 0),
(17, 1, NULL, 'user', '5', '2025-07-18 22:39:05', 0),
(18, 1, NULL, 'user', '123', '2025-07-18 22:39:29', 0),
(19, 1, NULL, 'user', '123', '2025-07-18 22:41:07', 0),
(20, 1, NULL, 'user', '123', '2025-07-18 22:41:14', 0),
(21, 1, NULL, 'user', '123', '2025-07-18 22:41:29', 0),
(22, 1, NULL, 'user', '123', '2025-07-18 22:43:10', 0),
(23, 1, NULL, 'user', '654', '2025-07-18 22:43:27', 0),
(24, 1, NULL, 'user', '654', '2025-07-18 22:44:20', 0),
(25, 1, NULL, 'user', '789456123', '2025-07-18 22:44:27', 0),
(26, 1, 1, 'admin', 'phải hong', '2025-07-18 22:44:36', 0),
(27, 1, NULL, 'user', '789456123', '2025-07-18 22:44:41', 0),
(28, 1, NULL, 'user', '789456123', '2025-07-18 22:45:08', 0),
(29, 1, NULL, 'user', '789456123', '2025-07-18 22:46:46', 0),
(30, 1, NULL, 'user', '789456123', '2025-07-18 22:49:50', 0),
(31, 1, NULL, 'user', '789456123', '2025-07-18 22:50:09', 0),
(32, 1, NULL, 'user', '123', '2025-07-18 22:50:34', 0),
(33, 1, NULL, 'user', 'Hello', '2025-07-18 22:57:42', 0),
(34, 1, NULL, 'user', 'Hello', '2025-07-18 22:58:04', 0),
(35, 1, NULL, 'user', '3', '2025-07-18 22:58:13', 0),
(36, 1, NULL, 'user', '3', '2025-07-18 22:58:48', 0),
(37, 1, NULL, 'user', '3', '2025-07-18 22:59:02', 0),
(38, 1, NULL, 'user', '5', '2025-07-18 23:01:58', 0),
(39, 1, NULL, 'user', '8', '2025-07-18 23:02:08', 0),
(40, 1, NULL, 'user', '8', '2025-07-18 23:03:01', 0),
(41, 1, NULL, 'user', 'Hello', '2025-07-18 23:03:07', 0),
(42, 1, NULL, 'user', 'Hello', '2025-07-18 23:03:21', 0),
(43, 1, NULL, 'user', 'Hello', '2025-07-18 23:03:29', 0),
(44, 1, NULL, 'user', '777', '2025-07-18 23:05:47', 0),
(45, 1, NULL, 'user', '777', '2025-07-18 23:06:40', 0),
(46, 1, NULL, 'user', '777777', '2025-07-18 23:06:51', 0),
(47, 1, NULL, 'user', '777777', '2025-07-18 23:07:28', 0),
(48, 1, NULL, 'user', '8888', '2025-07-18 23:07:32', 0),
(49, 1, NULL, 'user', '8888', '2025-07-18 23:07:41', 0),
(50, 1, NULL, 'user', '123456789', '2025-07-18 23:09:46', 0),
(51, 1, NULL, 'user', '123456789', '2025-07-18 23:10:35', 0),
(52, 1, NULL, 'user', 'helo', '2025-07-18 23:10:40', 0),
(53, 1, NULL, 'user', '999', '2025-07-18 23:12:37', 0),
(54, 1, NULL, 'user', 'nàm sao', '2025-07-19 00:18:07', 0),
(55, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:18:17', 0),
(56, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:19:20', 0),
(57, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:23:22', 0),
(58, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:24:33', 0),
(59, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:24:46', 0),
(60, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:24:55', 0),
(61, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:25:05', 0),
(62, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:25:12', 0),
(63, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:25:36', 0),
(64, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:25:52', 0),
(65, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:25:58', 0),
(66, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:26:18', 0),
(67, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:28:10', 0),
(68, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:30:12', 0),
(69, 1, NULL, 'user', 'saoooooo', '2025-07-19 00:45:20', 0),
(70, 1, NULL, 'user', '111', '2025-07-19 00:45:26', 0),
(71, 1, NULL, 'user', 'alo', '2025-07-19 01:02:04', 0),
(72, 1, 1, 'admin', 'ơi nghe', '2025-07-19 01:08:10', 0),
(73, 1, NULL, 'user', 'helo', '2025-07-19 01:08:33', 0),
(74, 1, NULL, 'user', 'helo', '2025-07-19 01:09:52', 0),
(75, 1, NULL, 'user', 'helo', '2025-07-19 01:10:41', 0),
(76, 1, NULL, 'user', 'có gì hong', '2025-07-19 01:11:11', 0),
(77, 1, NULL, 'user', 'nghe hong', '2025-07-19 01:11:21', 0),
(78, 1, NULL, 'user', 'sao kì v', '2025-07-19 01:11:34', 0),
(79, 1, NULL, 'user', 'má', '2025-07-19 01:12:10', 0),
(80, 1, NULL, 'user', 'Nản dữ bây', '2025-07-19 01:12:18', 0),
(81, 1, 1, 'admin', 'cc', '2025-07-19 01:12:29', 0),
(82, 1, NULL, 'user', 'Nản dữ bây', '2025-07-19 01:12:37', 0),
(83, 1, NULL, 'user', 'Nản dữ bây', '2025-07-19 01:13:17', 0),
(84, 1, NULL, 'user', 'mmm', '2025-07-19 01:13:27', 0),
(85, 1, 1, 'admin', 'sao', '2025-07-19 01:15:06', 0),
(86, 1, NULL, 'user', 'mẹ m', '2025-07-19 01:15:47', 0),
(87, 1, 1, 'admin', 'chán dữ bây', '2025-07-19 01:16:00', 0),
(88, 1, 1, 'admin', 'đúng chưa cha', '2025-07-19 01:17:07', 0),
(89, 1, 1, 'admin', 'xong chưa', '2025-07-19 01:18:40', 0),
(90, 1, 1, 'admin', 'có scroll đâu', '2025-07-19 01:18:52', 0),
(91, 1, 1, 'admin', 'sao', '2025-07-19 01:19:28', 0),
(92, 1, 1, 'admin', 'eee', '2025-07-19 01:21:02', 0),
(93, 1, NULL, 'user', '123456', '2025-07-19 01:21:10', 0),
(94, 1, 1, 'admin', 'qưertyu', '2025-07-19 01:21:30', 0),
(95, 1, NULL, 'user', '123456789', '2025-07-19 01:21:40', 0),
(96, 1, 1, 'admin', 'helo', '2025-07-19 01:23:09', 0),
(97, 1, 1, 'admin', 'oonr ko', '2025-07-19 01:24:43', 0),
(98, 1, 1, 'admin', 'llllllllllll', '2025-07-19 01:25:21', 0),
(99, 1, 1, 'admin', '3', '2025-07-19 01:26:34', 0),
(100, 1, 1, 'admin', 'llllllllllll', '2025-07-19 01:28:18', 0),
(101, 1, 1, 'admin', '77', '2025-07-19 01:28:26', 0),
(102, 1, NULL, 'user', '123456789', '2025-07-19 01:28:35', 0),
(103, 1, NULL, 'user', '123456789', '2025-07-19 01:31:54', 0),
(104, 1, NULL, 'user', 'ai', '2025-07-19 11:44:55', 0),
(105, 1, NULL, 'user', '123', '2025-07-19 11:46:43', 0),
(106, 1, NULL, 'user', '3', '2025-07-19 11:47:35', 0),
(107, 1, NULL, 'user', '5', '2025-07-19 11:47:40', 0),
(108, 1, 1, 'admin', '123', '2025-07-19 11:49:29', 0),
(109, 1, NULL, 'user', '3', '2025-07-19 12:06:39', 0),
(110, 1, NULL, 'user', '112', '2025-07-19 12:06:48', 0),
(111, 3, NULL, 'user', '123', '2025-08-09 22:12:46', 0),
(112, 3, NULL, 'user', 'Hello', '2025-08-09 22:12:51', 0),
(113, 3, 1, 'admin', 'okeeee', '2025-08-10 15:35:18', 0),
(114, 3, 1, 'admin', '123 456 789 101 102 103 104 105 106 107 108 109', '2025-08-10 15:35:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
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
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `email`, `position`, `address`, `isDeleted`, `created_at`, `branch_id`, `password_hash`, `is_first_login`) VALUES
(1, 'Vĩnh', '0394529044', 'vinh23861@gmail.com', 'Nhân viên', 'Bến Tre', 0, '2025-07-26 12:06:42', 2, '$2y$10$a512FIfDMYhk3a7fHDn9zeOhlFGU1GPpdk6A1vLTL34MgtFf7Ei4q', 1),
(3, 'Mai Chí Dĩnh', '0394529044', 'maivinh2609@gmail.com', 'Nhân viên', 'Ba Tri, Bến Tre', 0, '2025-08-10 08:05:57', 1, '$2y$10$ILDCUagaqIb.2iD1UbKoO.On3VCB9AWYOLDUDHnN6SBg6nvtcSxIm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_menu`
--

CREATE TABLE `employee_menu` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_menu`
--

INSERT INTO `employee_menu` (`id`, `employee_id`, `menu_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:06:42'),
(11, 3, 3, 0, '2025-08-12 18:53:22'),
(12, 3, 1, 0, '2025-08-12 18:53:22'),
(13, 3, 2, 0, '2025-08-12 18:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_url`, `product_id`, `isDeleted`, `created_at`) VALUES
(25, 'https://res.cloudinary.com/direvsslz/image/upload/v1752294337/products/extra/vl0swjyzbkwkyxjbr0bh.jpg', 8, 0, '2025-07-12 04:25:39'),
(26, 'https://res.cloudinary.com/direvsslz/image/upload/v1752294339/products/extra/nfrxhqewhfzxuxa2zmza.jpg', 8, 0, '2025-07-12 04:25:41'),
(27, 'https://res.cloudinary.com/direvsslz/image/upload/v1752294341/products/extra/l0m9eqkrqefowhlcqk6v.jpg', 8, 0, '2025-07-12 04:25:43'),
(28, 'https://res.cloudinary.com/direvsslz/image/upload/v1752294344/products/extra/vdq26fznzq80d2qnc6pi.png', 8, 0, '2025-07-12 04:25:46'),
(37, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409174/products/extra/hvg9p582qhajzut545wq.webp', 9, 0, '2025-08-05 15:52:54'),
(38, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409176/products/extra/mcjdj124nmkbsbqxwroc.webp', 9, 0, '2025-08-05 15:52:57'),
(39, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409178/products/extra/r23ir5cfznpo9vrzty30.webp', 9, 0, '2025-08-05 15:52:59'),
(40, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409180/products/extra/ssbh4ew7dac3lpp88rjf.webp', 9, 0, '2025-08-05 15:53:01'),
(41, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409244/products/extra/y9jlqvv6kneas12ttcps.webp', 10, 0, '2025-08-05 15:54:05'),
(42, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409247/products/extra/sqgsgeyupwjjaik7izd2.webp', 10, 0, '2025-08-05 15:54:07'),
(43, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409248/products/extra/yix80ohtn93iih2saall.webp', 10, 0, '2025-08-05 15:54:09'),
(44, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409251/products/extra/l95kqwnqlyfblnxzjvix.webp', 10, 0, '2025-08-05 15:54:12'),
(45, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409314/products/extra/fydwzwnejn1lmeg6ofq8.webp', 11, 0, '2025-08-05 15:55:14'),
(46, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409316/products/extra/c9hjmywguhkenzdjpydq.webp', 11, 0, '2025-08-05 15:55:16'),
(47, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409318/products/extra/zmngjf1p3fh4ysbyc3dx.webp', 11, 0, '2025-08-05 15:55:18'),
(48, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409320/products/extra/qn9pceip00jrovwp8l9q.webp', 11, 0, '2025-08-05 15:55:21'),
(49, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409391/products/extra/enebyww479h54bptqtsh.webp', 12, 0, '2025-08-05 15:56:32'),
(50, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409394/products/extra/xpws4duyouda9l6okqid.webp', 12, 0, '2025-08-05 15:56:34'),
(51, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409396/products/extra/szw8ls97yxumyxfgcuii.webp', 12, 0, '2025-08-05 15:56:36'),
(52, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409398/products/extra/ircuxun8lvdbro1borwo.webp', 12, 0, '2025-08-05 15:56:39'),
(53, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409601/products/extra/jb6rvcnnyskcqreb4bo9.webp', 13, 0, '2025-08-05 16:00:02'),
(54, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409603/products/extra/lp3jq1edg4xtiq27tfjh.webp', 13, 0, '2025-08-05 16:00:04'),
(55, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409606/products/extra/zkzvaioxn9xl5avyotbk.webp', 13, 0, '2025-08-05 16:00:06'),
(56, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409608/products/extra/xbj2mq1khn7zm2wzgntu.webp', 13, 0, '2025-08-05 16:00:09'),
(57, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409753/products/extra/vxmiz2gffm7iuqprckjq.webp', 14, 0, '2025-08-05 16:02:34'),
(58, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409755/products/extra/lnvyxtzanqnh9pcbgbwp.webp', 14, 0, '2025-08-05 16:02:36'),
(59, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409758/products/extra/gojvihlvxahk8yy6d1rl.webp', 14, 0, '2025-08-05 16:02:38'),
(60, 'https://res.cloudinary.com/direvsslz/image/upload/v1754409760/products/extra/avctblxqrlawpufdjrwv.webp', 14, 0, '2025-08-05 16:02:40'),
(61, 'https://res.cloudinary.com/direvsslz/image/upload/v1754410939/products/extra/lllgkmdlyyyabph1tf1l.webp', 15, 0, '2025-08-05 16:22:20'),
(62, 'https://res.cloudinary.com/direvsslz/image/upload/v1754410941/products/extra/bltaygple4boc7jjfsbe.webp', 15, 0, '2025-08-05 16:22:22'),
(63, 'https://res.cloudinary.com/direvsslz/image/upload/v1754410944/products/extra/bcqonbmizgi9btz3nezj.webp', 15, 0, '2025-08-05 16:22:24'),
(64, 'https://res.cloudinary.com/direvsslz/image/upload/v1754410946/products/extra/c32opgd0xpqaf8tk4cpf.webp', 15, 0, '2025-08-05 16:22:27'),
(65, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411164/products/extra/aq9fl1m7mzgjjh3vre4z.webp', 16, 0, '2025-08-05 16:26:06'),
(66, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411167/products/extra/mttyq5bzfl2svreujdkf.webp', 16, 0, '2025-08-05 16:26:08'),
(67, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411169/products/extra/ajmf2s1wlrvelbhdf0wf.webp', 16, 0, '2025-08-05 16:26:10'),
(68, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411171/products/extra/dqpjkqqtakoapvxfjfiw.webp', 16, 0, '2025-08-05 16:26:12'),
(69, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411294/products/extra/svnk764xy9j8xituvnuh.webp', 17, 0, '2025-08-05 16:28:14'),
(70, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411296/products/extra/ydmrwlw9t7ykkmwqyet8.webp', 17, 0, '2025-08-05 16:28:17'),
(71, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411298/products/extra/ruja2qvznep2phbx6qms.webp', 17, 0, '2025-08-05 16:28:19'),
(72, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411300/products/extra/lqqxyshxa8ihwznaaf0n.webp', 17, 0, '2025-08-05 16:28:21'),
(73, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411441/products/extra/vk2lmf022iwz3cok2yf5.webp', 18, 0, '2025-08-05 16:30:41'),
(74, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411443/products/extra/uplibbs9mttektg0vedb.webp', 18, 0, '2025-08-05 16:30:44'),
(75, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411445/products/extra/pumkere2ifnvniwow6er.webp', 18, 0, '2025-08-05 16:30:46'),
(76, 'https://res.cloudinary.com/direvsslz/image/upload/v1754411447/products/extra/g6tgik8uehzy73br5plt.webp', 18, 0, '2025-08-05 16:30:48'),
(77, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412369/products/extra/zxccmj5edb45v7r0mr89.webp', 19, 0, '2025-08-05 16:46:09'),
(78, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412371/products/extra/vetbbz50cukjm6r06j7s.webp', 19, 0, '2025-08-05 16:46:12'),
(79, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412373/products/extra/zrthk6ugsz7ieotw3aoo.webp', 19, 0, '2025-08-05 16:46:14'),
(80, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412375/products/extra/iihulvts5a0zqo4z6bbp.webp', 19, 0, '2025-08-05 16:46:16'),
(81, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412548/products/extra/dow4cd4v67c0uvx5l4g7.webp', 20, 0, '2025-08-05 16:49:09'),
(82, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412550/products/extra/sadkguhlezgcqlz1pdce.webp', 20, 0, '2025-08-05 16:49:11'),
(83, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412552/products/extra/b0ebumbbxgdhvm40ujcp.webp', 20, 0, '2025-08-05 16:49:13'),
(84, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412554/products/extra/vfykshnqzpsieersj2ne.webp', 20, 0, '2025-08-05 16:49:15'),
(85, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412588/products/extra/rj4lh1puelnpmz6gcubc.webp', 21, 0, '2025-08-05 16:49:48'),
(86, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412590/products/extra/iisxcu1us0tt0sptqi9g.webp', 21, 0, '2025-08-05 16:49:51'),
(87, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412592/products/extra/qwji1pyjd6ttrxviuavd.webp', 21, 0, '2025-08-05 16:49:53'),
(88, 'https://res.cloudinary.com/direvsslz/image/upload/v1754412594/products/extra/obicpcvoejwzkxhhd1gx.webp', 21, 0, '2025-08-05 16:49:55'),
(89, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413509/products/extra/suywpupe7uu8pr54kjng.webp', 22, 0, '2025-08-05 17:05:10'),
(90, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413511/products/extra/teaqmpq4tienzr49paos.webp', 22, 0, '2025-08-05 17:05:13'),
(91, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413514/products/extra/bwjztgwlnsy9gmn3ifg0.webp', 22, 0, '2025-08-05 17:05:15'),
(92, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413517/products/extra/dysilvhpvbti6zvnde0j.webp', 22, 0, '2025-08-05 17:05:18'),
(97, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413835/products/extra/ugvt0f0iqbauu5rmd6xq.webp', 24, 0, '2025-08-05 17:10:36'),
(98, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413837/products/extra/iwj5rsgwqn8ffhs5it40.webp', 24, 0, '2025-08-05 17:10:38'),
(99, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413839/products/extra/yacaeb8zdpn55v0fdgpp.webp', 24, 0, '2025-08-05 17:10:40'),
(100, 'https://res.cloudinary.com/direvsslz/image/upload/v1754413841/products/extra/qqy4qwt5ejubmoewqya6.webp', 24, 0, '2025-08-05 17:10:42'),
(101, 'https://res.cloudinary.com/direvsslz/image/upload/v1754415455/products/extra/y7mnrildtwuucux0kprr.webp', 25, 0, '2025-08-05 17:37:36'),
(102, 'https://res.cloudinary.com/direvsslz/image/upload/v1754415458/products/extra/ww7ippgc6ckjpxvutgea.webp', 25, 0, '2025-08-05 17:37:39'),
(103, 'https://res.cloudinary.com/direvsslz/image/upload/v1754415460/products/extra/xcnfz5f5un8qzrw63btl.webp', 25, 0, '2025-08-05 17:37:41'),
(104, 'https://res.cloudinary.com/direvsslz/image/upload/v1754415462/products/extra/kfhpyj23qie8v30tpc3t.webp', 25, 0, '2025-08-05 17:37:43'),
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
(180, 'uploads/689a43267d92a_Samsung Galaxy S25 Ultra 4.webp', 26, 0, '2025-08-11 19:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
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
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `stock_quantity`, `last_update`, `product_id`, `isDeleted`, `branch_id`) VALUES
(6, 120, '2025-07-12 11:25:46', 8, 0, NULL),
(8, 99, '2025-07-21 20:51:33', 8, 1, 1),
(9, 38, '2025-07-25 18:37:17', 8, 0, 2),
(12, 117, '2025-08-12 19:22:14', 36, 0, 1),
(13, 119, '2025-08-12 19:22:23', 27, 0, 1),
(14, 120, '2025-08-12 19:22:31', 26, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `menu_url`, `isDeleted`, `created_at`) VALUES
(1, 'Chuyển trạng thái đơn hàng', 'modules/Admin/Orders/ChangeStatusOrder.php', 0, '2025-07-26 12:00:58'),
(2, 'Sửa đơn hàng', 'modules/Admin/Orders/UpdateOrder.php', 0, '2025-08-12 12:37:08'),
(3, 'Chuyển đơn shipper', 'modules/Admin/Shipping/OrderTransfer.php', 0, '2025-08-12 12:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_amount`, `payment_id`, `shipping_id`, `user_id`, `create_at`, `note`, `status_id`, `isDeleted`, `code`, `cancel_reason`, `cancel_at`, `cancel_by`, `branch_id`, `employee_id`) VALUES
(26, 11400000.00, 33, 21, 1, '2025-07-26 11:52:18', '', 4, 0, '25FF2318', NULL, NULL, NULL, 2, 1),
(29, 91914200.00, 37, 25, 1, '2025-08-12 12:24:21', 'Giao vào buổi chiều', 2, 0, 'B1C01DE1', NULL, NULL, NULL, 1, 1),
(30, 91914200.00, 38, 26, 1, '2025-08-12 12:35:52', 'Giao nhanh nhanh', 6, 0, '8BB01E92', NULL, NULL, NULL, 1, 3),
(32, 91914200.00, 40, 28, 1, '2025-08-12 18:52:08', 'Test', 6, 0, '28FE598A', NULL, NULL, NULL, 1, 3),
(33, 30091400.00, 41, 29, 1, '2025-08-13 07:58:38', '', 6, 0, '5ACFC6D1', NULL, NULL, NULL, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
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
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `quantity`, `unit_price`, `product_id`, `order_id`, `isDeleted`) VALUES
(11, 1, 11400000.00, 8, 14, 0),
(12, NULL, 11400000.00, 8, 15, 0),
(13, NULL, 11400000.00, 8, 16, 0),
(14, NULL, 11400000.00, 8, 17, 0),
(15, NULL, 11400000.00, 8, 18, 0),
(16, NULL, 11400000.00, 8, 19, 0),
(17, 1, 11400000.00, 8, 20, 0),
(18, 1, 11400000.00, 8, 21, 0),
(19, 1, 11400000.00, 8, 22, 0),
(20, 1, 11400000.00, 8, 23, 0),
(21, 1, 11400000.00, 8, 24, 0),
(22, 1, 11400000.00, 8, 25, 0),
(23, 1, 11400000.00, 8, 26, 0),
(26, 1, 91914200.00, 36, 29, 0),
(27, 1, 91914200.00, 36, 30, 0),
(29, 1, 91914200.00, 36, 32, 0),
(30, 1, 30091400.00, 27, 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_tokens`
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
(32, 1, '147519', '2025-08-13 15:13:14', '2025-08-13 15:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
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
(41, 'Thanh toán khi nhận hàng', 'Chưa thanh toán', '2025-08-13 14:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `discount`, `description`, `image_url`, `category_id`, `supplier_id`, `created_at`, `content`, `isDeleted`) VALUES
(8, 'SP1', 12000000.00, 5.00, '<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>\r\n<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1752294334/products/main/ds1vm1ajvhe1zlulfkzl.png', 1, 2, '2025-07-12 04:25:36', '<p>ASUS Vivobook E1404FA-NK186W thuộc d&ograve;ng Vivobook Go 14, d&ograve;ng laptop hiệu năng cao gi&aacute; rẻ gi&uacute;p bạn l&agrave;m việc hiệu quả mọi l&uacute;c mọi nơi. Với bộ vi xử l&yacute; AMD 7000 series mạnh mẽ, trang bị sẵn tới 16GB RAM, 512GB SSD, Vivobook E1404FA sẽ mang đến trải nghiệm l&agrave;m việc thoải m&aacute;i, v&ocirc; c&ugrave;ng mượt m&agrave;.</p>', 0),
(9, 'Mai Chí Vĩnh', 1234567.00, 12.00, '<p>1234567uyh</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409172/products/main/nyasv4fswjy511uj9tqw.webp', 1, 2, '2025-08-05 15:52:52', '<p>1234567890sdfg</p>', 0),
(10, 'Lê Phước Bình', 1234567890.00, 12.00, '<p>1234567890</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409242/products/main/oi2dfx6hxocbawsuqung.webp', 1, 2, '2025-08-05 15:54:03', '<p>1234567890</p>', 0),
(11, 'Kinh tế - Luật', 1234567890.00, 12.00, '<p>1234567890</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409311/products/main/mx2gkouhyyhqfbrhvrlt.webp', 1, 2, '2025-08-05 15:55:12', '<p>1234567890</p>', 0),
(12, '1234567890', 1234567890.00, 12.00, '<p>1234567890</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409389/products/main/vlvzz4j0wdoivf5ixo3f.webp', 1, 2, '2025-08-05 15:56:30', '<p>1234567890</p>', 0),
(13, 'Chat', 1234567890.00, 12.00, '<p>123456789</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409599/products/main/ejkwiihom6hsc6h0aflq.webp', 1, 2, '2025-08-05 16:00:00', '<p>1234567890</p>', 0),
(14, 'Kinh tế ', 1234567890.00, 12.00, '<p>134</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754409751/products/main/cginu8dq7yzi9ik1lwvz.webp', 1, 2, '2025-08-05 16:02:32', '<p>12345</p>', 0),
(15, 'Chat 123456', 123456789.00, 12.00, '<p>qwertyu</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754410937/products/main/uri9pney014ob7stgzlx.webp', 1, 2, '2025-08-05 16:22:18', '<p>qwertyuio</p>', 0),
(16, '12345', 1234567.00, 12.00, '<p>12345</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754411161/products/main/ndqcfqm3crqsn7c8qz6c.webp', 1, 2, '2025-08-05 16:26:02', '<p>12345</p>', 0),
(17, '1234567890987654', 1234567890.00, 12.00, '<p>12345678</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754411291/products/main/la4umzhmn4ogi8xlqngm.webp', 1, 2, '2025-08-05 16:28:12', '<p>123456789</p>', 0),
(18, 'Chat123456789', 123456789.00, 12.00, '<p>1234567</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754411439/products/main/cetb3qi5yslwngjeivkv.webp', 1, 2, '2025-08-05 16:30:39', '<p>1234567</p>', 0),
(19, '1qwertyujbv', 1234567890.00, 12.00, '<p>123456789</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754412366/products/main/zyeuxmxbmcjscmxycobb.webp', 1, 2, '2025-08-05 16:46:07', '<p>123456789</p>', 0),
(20, 'Mai Chí Vĩnh123456', 123456789.00, 12.00, '<p>12345678</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754412545/products/main/jnnjsilgkf1o31wteg8c.webp', 1, 2, '2025-08-05 16:49:07', '<p>12345678</p>', 0),
(21, 'Mai Chí Vỉnhewqwer', 123456789.00, 12.00, '<p>&aacute;dfgh</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754412585/products/main/ifs0zqphvqp8grgoowxs.webp', 1, 2, '2025-08-05 16:49:46', '<p>12345</p>', 0),
(22, 'Mai Chí Vĩnh123456789221212121', 1234567.00, 12.00, '<p>gfdsa</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754413507/products/main/g4xaxblmsudxkmbfdtpm.webp', 1, 2, '2025-08-05 17:05:08', '<p>hgfdsa</p>', 0),
(24, 'Kinh tế - Luật123456', 123456789.00, 12.00, '<p>qưertyu</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754413833/products/main/fbbnftnorvxf5gs3c4yw.webp', 1, 2, '2025-08-05 17:10:33', '<p>qưerty</p>', 0),
(25, 'Mai Chí Vĩnh 12qwertyuiop', 1234567890.00, 12.00, '<p>12345678</p>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754415453/products/main/am2fv5num06szyz3vzrh.webp', 1, 2, '2025-08-05 17:37:34', '<p>123456789</p>', 0),
(26, 'Samsung Galaxy S25 Ultra 12GB 256GB', 33380000.00, 15.00, '<h2 class=\"ksp-title\">Đặc điểm nổi bật của Samsung Galaxy S25 Ultra 12GB 256GB</h2>\r\n<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<blockquote>\r\n<p><a title=\"Samsung Galaxy S25 Ultra\" href=\"https://cellphones.com.vn/dien-thoai-samsung-galaxy-s25-ultra.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung Galaxy S25 Ultra</strong></a>&nbsp;mạnh mẽ với chip&nbsp;<strong>Snapdragon 8 Elite For Galaxy</strong>&nbsp;mới nhất,&nbsp;RAM 12GB&nbsp;v&agrave; bộ nhớ trong&nbsp;256GB-1TB. Hệ thống&nbsp;<strong>3 camera sau</strong>&nbsp;chất lượng gồm&nbsp;camera ch&iacute;nh 200MP, camera tele 50MP v&agrave; camera g&oacute;c si&ecirc;u rộng 50MP. Thiết kế&nbsp;k&iacute;nh cường lực&nbsp;<strong>Corning Gorilla Armor 2</strong>&nbsp;v&agrave; khung&nbsp;<strong>viền&nbsp;Titanium</strong>,&nbsp;m&agrave;n h&igrave;nh&nbsp;Dynamic AMOLED 6.9 inch. Điện thoại n&agrave;y c&ograve;n c&oacute; vi&ecirc;n pin&nbsp;<strong>5000mAh</strong>,&nbsp;hỗ trợ&nbsp;<strong>5G</strong>&nbsp;v&agrave;&nbsp;<strong>Galaxy AI</strong> ấn tượng, n&acirc;ng cao trải nghiệm người d&ugrave;ng!</p>\r\n<h2 id=\"samsung-galaxy-s25-ultra-gia-bao-nhieu\"><strong>Samsung Galaxy S25 Ultra gi&aacute; bao nhi&ecirc;u?</strong></h2>\r\n<p><strong>Bảng gi&aacute; S25 Ultra 5G ch&iacute;nh h&atilde;ng</strong>&nbsp;mới nhất:</p>\r\n<p>&nbsp;</p>\r\n<div>\r\n<table class=\"seo-table seo-product-price table is-bordered is-narrow is-hoverable is-fullwidth\">\r\n<thead>\r\n<tr>\r\n<td>\r\n<p><strong>T&ecirc;n sản phẩm</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; b&aacute;n</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; thu cũ l&ecirc;n đời</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 12GB 256GB</p>\r\n</td>\r\n<td>\r\n<p>26.980.000đ</p>\r\n</td>\r\n<td>\r\n<p>24.980.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 512GB</p>\r\n</td>\r\n<td>\r\n<p>29.490.000đ</p>\r\n</td>\r\n<td>\r\n<p>26.490.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Samsung Galaxy S25 Ultra 1TB</p>\r\n</td>\r\n<td>\r\n<p>35.490.000đ</p>\r\n</td>\r\n<td>\r\n<p>34.490.000đ</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<p>Tại thị trường Việt Nam,&nbsp;<strong>gi&aacute; Samsung Galaxy S25 Ultra</strong>&nbsp;khởi điểm&nbsp;<strong>từ 33.38 triệu đồng</strong>&nbsp;cho bản&nbsp;<strong>12GB/256GB</strong>. Mua tại CellphoneS giảm thẳng đến 5 triệu.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-gia-bao-nhieu_1.jpg\" alt=\"Gi&aacute; Samsung Galaxy S25 Ultra rẻ nhất \" loading=\"lazy\"></p>\r\n<h2 id=\"danh-gia-s25-ultra-5g-chinh-hang-moi-nhat\"><strong>Đ&aacute;nh gi&aacute; S25 Ultra 5G ch&iacute;nh h&atilde;ng mới nhất</strong></h2>\r\n<p>C&aacute;c th&ocirc;ng số kh&aacute;c như dung lượng pin v&agrave; c&aacute;c t&iacute;nh năng kh&aacute;c được cho l&agrave; kh&ocirc;ng c&oacute; nhiều thay đổi đ&aacute;ng kể. Tuy nhi&ecirc;n, với những cải tiến đ&aacute;ng ch&uacute; &yacute; về kiểu d&aacute;ng v&agrave; camera, Galaxy S25 Ultra vẫn l&agrave; một lựa chọn n&acirc;ng cấp hấp dẫn so với tiền nhiệm.</p>\r\n<p>M&aacute;y mới&nbsp;lần n&agrave;y&nbsp;kh&ocirc;ng chỉ l&agrave; một chiếc điện thoại th&ocirc;ng minh, m&agrave; c&ograve;n l&agrave; biểu tượng của sự đẳng cấp v&agrave; c&ocirc;ng nghệ ti&ecirc;n tiến. T&igrave;m hiểu ngay qua c&aacute;c nội dung ch&iacute;nh sau:</p>\r\n<h3 id=\"thiet-ke-goc-vien-bo-cong-tinh-te\"><strong>Thiết kế g&oacute;c viền bo cong tinh tế</strong></h3>\r\n<p>Samsung tiếp tục duy tr&igrave;&nbsp;<strong>ng&ocirc;n ngữ thiết kế đặc trưng</strong>&nbsp;cho d&ograve;ng<strong>&nbsp;S25 Ultra</strong>. Thay đổi lớn nhất về thiết kế nằm ở&nbsp;<strong>c&aacute;c g&oacute;c bo tr&ograve;n v&agrave; mỏng hơn, với trọng lượng giảm 14g so với trước</strong>, điều n&agrave;y gi&uacute;p người d&ugrave;ng thoải m&aacute;i hơn khi cầm nắm thiết bị.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-thiet-ke.jpg\" alt=\"Điện thoại S25 Ultra bo cong tinh tế\" loading=\"lazy\"></p>\r\n<p>Camera vẫn được xếp&nbsp;<strong>theo h&agrave;ng dọc</strong>&nbsp;ở mặt lưng, với c&aacute;c ống k&iacute;nh nh&ocirc; ra tương tự phi&ecirc;n bản tiền nhiệm. Điều n&agrave;y mang lại vẻ ngo&agrave;i hiện đại, tối ưu h&oacute;a t&iacute;nh thẩm mỹ v&agrave; cảm gi&aacute;c cầm nắm.</p>\r\n<p>Về chất liệu, Samsung duy tr&igrave;&nbsp;<strong>khung titan cao cấp</strong>, đ&acirc;y l&agrave; sự lựa chọn l&yacute; tưởng khi vừa đảm bảo độ bền vừa giảm trọng lượng thiết bị. S25 Ultra sẽ c&oacute; c&aacute;c t&ugrave;y chọn m&agrave;u sắc đa dạng như Xanh Titan, Bạc Titan, X&aacute;m Titan, Đen Titan. Ngo&agrave;i ra, một số phi&ecirc;n bản m&agrave;u chỉ c&oacute; tại Samsung.com như V&agrave;ng Hồng, Đen Tuyền, v&agrave; Xanh Ngọc.&nbsp;</p>\r\n<h3 id=\"man-hinh-dynamic-amoled-2x-6-9-inch-hien-thi-ruc-ro\"><strong>M&agrave;n h&igrave;nh Dynamic AMOLED 2x 6.9 inch, hiển thị rực rỡ</strong></h3>\r\n<p><strong>S25 Ultra trang bị tấm nền&nbsp;Dynamic AMOLED 2x k&iacute;ch thước</strong>&nbsp;<strong>6,9 inch độ ph&acirc;n giải QHD+&nbsp;</strong>mang đến trải nghiệm h&igrave;nh ảnh sống động. Điểm nhấn đ&aacute;ng ch&uacute; &yacute; nằm ở viền bezel si&ecirc;u mỏng, kh&ocirc;ng chỉ mang lại trải nghiệm hiển thị rộng r&atilde;i m&agrave; c&ograve;n l&agrave;m nổi bật vẻ đẹp sang trọng của m&aacute;y.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-man-hinh.jpg\" alt=\"Dynamic AMOLED 2x lớn sắc n&eacute;t\" loading=\"lazy\"></p>\r\n<h3 id=\"chiset-snapdragon-8-elite-for-galaxy-moi-va-manh-me\"><strong>Chiset Snapdragon 8 Elite for Galaxy mới v&agrave; mạnh mẽ</strong></h3>\r\n<p><strong>Với tầm gi&aacute; Samsung Galaxy S25 Ultra</strong>&nbsp;hiện nay được kỳ vọng sẽ đạt&nbsp;<strong>đỉnh cao mới về hiệu năng</strong>&nbsp;nhờ sức mạnh của chipset&nbsp;<strong>Snapdragon 8 Elite for Galaxy</strong>&nbsp;(hay Snap 8 Elite). Đ&acirc;y l&agrave; vi xử l&yacute; mới từ Qualcomm, mang lại cải tiến ấn tượng cả về tốc độ xử l&yacute; v&agrave; khả năng đồ họa. Snapdragon 8 Elite cho thấy hiệu suất l&otilde;i đơn&nbsp;<strong>NPU&nbsp;tăng đến 40%</strong>, gi&uacute;p xử l&yacute; nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c c&aacute;c t&aacute;c vụ AI. Kh&ocirc;ng chỉ vậy, hiệu suất&nbsp;<strong>CPU tăng hơn 37%</strong>&nbsp;gi&uacute;p tối ưu hiệu năng sử dụng, đồng thời&nbsp;<strong>cải tiến GPU đến 30%</strong>.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-hieu-nang.jpg\" alt=\"Snapdragon 8 Elite mạnh mẽ tr&ecirc;n Samsung S25 Ultra 5G\" loading=\"lazy\"></p>\r\n<p>Với&nbsp;<strong>điện thoại Samsung S25 Ultra</strong>, điểm Benchmark lần lượt:</p>\r\n<ul>\r\n<li>\r\n<p><strong>CPU: 560.967</strong>&nbsp;-&gt; Cho ph&eacute;p m&aacute;y chạy đa nhiệm mượt m&agrave;, xử l&yacute; c&aacute;c t&aacute;c vụ nặng như chơi game 3D, chỉnh sửa video một c&aacute;ch dễ d&agrave;ng</p>\r\n</li>\r\n<li>\r\n<p><strong>GPU: 889.301</strong>&nbsp;-&gt;&nbsp;&nbsp;Khả năng xử l&yacute; đồ họa của m&aacute;y rất tốt</p>\r\n</li>\r\n<li>\r\n<p><strong>MEM: 444.565</strong>&nbsp;-&gt;&nbsp;Hiệu năng truy xuất dữ liệu của m&aacute;y rất nhanh,&nbsp;gi&uacute;p m&aacute;y chạy c&aacute;c ứng dụng một c&aacute;ch mượt m&agrave; v&agrave; kh&ocirc;ng bị giật lag</p>\r\n</li>\r\n<li>\r\n<p><strong>UX: 349.427</strong>&nbsp;-&gt; Hiệu năng tổng thể của m&aacute;y rất tốt, bao gồm cả tốc độ phản hồi, thời gian mở ứng dụng v&agrave; khả năng đa nhiệm</p>\r\n</li>\r\n</ul>\r\n<p>Với những điểm số Benchmark tr&ecirc;n, c&oacute; thể thấy rằng&nbsp;<a title=\"điện thoại\" href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" rel=\"noopener\"><strong>điện thoại</strong></a>&nbsp;S25 Ultra lần n&agrave;y l&agrave; một chiếc smartphone c&oacute; hiệu năng cực kỳ mạnh mẽ. M&aacute;y ho&agrave;n to&agrave;n c&oacute; thể đ&aacute;p ứng được mọi nhu cầu sử dụng của người d&ugrave;ng, từ những t&aacute;c vụ cơ bản đến những t&aacute;c vụ nặng.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-benchmark.jpg\" alt=\"Điểm Antutu Samsung S25 Ultra 5G\" loading=\"lazy\"></p>\r\n<p>Hiệu năng ấn tượng kết hợp với t&iacute;nh năng ti&ecirc;n tiến như chế độ&nbsp;<strong>Khả năng AI tối ưu h&oacute;a</strong>, S25 Ultra 5G kh&ocirc;ng chỉ đ&aacute;p ứng nhu cầu của người d&ugrave;ng m&agrave; c&ograve;n định h&igrave;nh lại chuẩn mực hiệu suất cho smartphone cao cấp năm 2025.</p>\r\n<h3 id=\"camera-200mp-sac-net-zoom-xa-100x-cuc-chi-tiet\"><strong>Camera 200MP sắc n&eacute;t, zoom xa 100x cực chi tiết</strong></h3>\r\n<p><strong>Camera Samsung S25 Ultra</strong>&nbsp;tiếp tục khẳng định vị thế dẫn đầu về c&ocirc;ng nghệ camera với những n&acirc;ng cấp đ&aacute;ng ch&uacute; &yacute;. Điểm nhấn của&nbsp;<a title=\"Samsung S series\" href=\"https://cellphones.com.vn/mobile/samsung/galaxy-s.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung S series</strong></a>&nbsp;lần n&agrave;y nằm ở cảm biến ch&iacute;nh&nbsp;<strong>200MP</strong>, mang đến độ chi tiết ấn tượng v&agrave; khả năng chụp ảnh chất lượng cao trong nhiều điều kiện &aacute;nh s&aacute;ng. Đi k&egrave;m với đ&oacute; l&agrave; t&iacute;nh năng&nbsp;<strong>Space Zoom 100x</strong>, cho ph&eacute;p người d&ugrave;ng kh&aacute;m ph&aacute; những chi tiết nhỏ nhất từ xa.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-camera.jpg\" alt=\"camera Samsung S25 Ultra 5G 200MP\" loading=\"lazy\"></p>\r\n<p>Một trong những n&acirc;ng cấp đ&aacute;ng ch&uacute; &yacute; l&agrave; cảm biến g&oacute;c si&ecirc;u rộng, được n&acirc;ng cấp từ 12MP l&ecirc;n 50MP.&nbsp;Camera g&oacute;c si&ecirc;u rộng n&agrave;y c&oacute; khẩu độ f/1.9, hỗ trợ ổn định h&igrave;nh ảnh v&agrave; độ ph&acirc;n giải cao, hứa hẹn mang lại trải nghiệm chụp phong cảnh v&agrave; ảnh nh&oacute;m xuất sắc.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-camera-1.jpg\" alt=\"Camera Galaxy S25 Ultra 5G zoom 100X\" loading=\"lazy\"></p>\r\n<p>Ống k&iacute;nh tele hỗ trợ zoom quang học 3x với độ ph&acirc;n giải 10MP, 5x với độ ph&acirc;n giải 50MP mang lại sự linh hoạt đ&aacute;ng kể, đặc biệt khi quay video. Ngo&agrave;i ra, ống k&iacute;nh c&ograve;n hỗ trợ zoom chuẩn quang học 2x, 10x. Nhờ c&ocirc;ng nghệ ti&ecirc;n tiến tr&ecirc;n cụm camera m&agrave; &aacute;nh macro si&ecirc;u chi tiết tăng đ&aacute;ng kể v&ugrave;ng ph&acirc;n giải, v&ugrave;ng s&aacute;ng, cho ảnh tốt hơn ở điều kiện s&aacute;ng kh&aacute;c nhau. Kh&ocirc;ng chỉ vậy, ảnh macro c&ograve;n chi tiết hơn 4 lần so với S24 Ultra.</p>\r\n<h3 id=\"ss-s25-ultra-dung-luong-pin-5000mah\"><strong>SS S25 Ultra dung lượng pin 5000mAh</strong></h3>\r\n<p>Samsung&nbsp;S25&nbsp;Ultra 5G tiếp tục giữ vi&ecirc;n&nbsp;<strong>pin dung lượng 5.000 mAh</strong>, hỗ trợ sạc nhanh 45W, đảm bảo hiệu suất sử dụng d&agrave;i l&acirc;u. Tuy nhi&ecirc;n, sự kh&aacute;c biệt đ&aacute;ng ch&uacute; &yacute; nằm ở c&aacute;c cải tiến tối ưu h&oacute;a năng lượng từ chipset Snapdragon 8 Elite, với hiệu suất CPU v&agrave; NPU được cải thiện lần lượt&nbsp;<strong>37% v&agrave; 40%</strong>, g&oacute;p phần&nbsp;<strong>k&eacute;o d&agrave;i thời gian sử dụng</strong>&nbsp;d&ugrave; dung lượng pin kh&ocirc;ng đổi.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-pin.jpg\" alt=\"Pin SS S25 Ultra dung lượng lớn 5000mAh\" loading=\"lazy\"></p>\r\n<h2 id=\"nen-mua-samsung-s25-ultra-5g-hay-s24-ultra\"><strong>N&ecirc;n mua Samsung S25 Ultra 5G hay S24 Ultra?</strong></h2>\r\n<p>H&atilde;y c&ugrave;ng&nbsp;<strong>so s&aacute;nh Samsung S25 Ultra v&agrave;&nbsp;<a href=\"https://cellphones.com.vn/samsung-galaxy-s24-ultra.html\" target=\"_blank\" rel=\"noopener\">S24 Ultra</a></strong>&nbsp;xem thế hệ Galaxy S mới nhất đ&atilde; được thay đổi những g&igrave; v&agrave; đưa ra quyết định n&ecirc;n mua phi&ecirc;n bản mới hay thế hệ tiền nhiệm!</p>\r\n<table border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><strong>Ti&ecirc;u ch&iacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>S25 Ultra</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>S24 Ultra</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Thiết kế</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Viền bo cong,</strong>&nbsp;khung titan</p>\r\n</td>\r\n<td>\r\n<p>Viền vu&ocirc;ng vức, khung titan</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;u sắc</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Xanh Titan,</strong>&nbsp;X&aacute;m Titan,&nbsp;<strong>Bạc Titan</strong>&nbsp;v&agrave; Đen Titan</p>\r\n</td>\r\n<td>\r\n<p>V&agrave;ng,&nbsp; X&aacute;m , T&iacute;m, Đen</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;n h&igrave;nh</strong></p>\r\n</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X,&nbsp;<strong>6.9 inch</strong></p>\r\n</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X, 6.8 inch</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Vi xử l&yacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Snapdragon 8 Elite for Galaxy</strong></p>\r\n</td>\r\n<td>\r\n<p>Snapdragon 8 Gen 3 for Galaxy</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>RAM</strong></p>\r\n</td>\r\n<td>\r\n<p>12GB</p>\r\n</td>\r\n<td>\r\n<p>12GB</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Bộ nhớ trong</strong></p>\r\n</td>\r\n<td>\r\n<p>256GB - 512GB - 1TB</p>\r\n</td>\r\n<td>\r\n<p>256GB - 512GB - 1TB</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Camera trước</strong></p>\r\n</td>\r\n<td>\r\n<p>12MP</p>\r\n</td>\r\n<td>\r\n<p>12MP</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Camera sau</strong></p>\r\n</td>\r\n<td>\r\n<p>200MP (ch&iacute;nh) +&nbsp;<strong>50MP (si&ecirc;u rộng)</strong>&nbsp;+ 10MP (tele 3x)&nbsp;+ 50MP (tele 5x)</p>\r\n</td>\r\n<td>\r\n<p>200MP (ch&iacute;nh) + 12MP (si&ecirc;u rộng) + 10MP (tele 3x) + 50MP (tele 5x)</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><strong>Pin</strong></p>\r\n</td>\r\n<td>\r\n<p>5.000 mAh</p>\r\n</td>\r\n<td>\r\n<p>5.000 mAh</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Như vậy,&nbsp;<strong>kh&aacute;c biệt ch&iacute;nh của S25 Ultra v&agrave; S24 Ultra</strong>&nbsp;nằm ở&nbsp;<strong>diện mạo, hiệu năng, m&agrave;n h&igrave;nh</strong>&nbsp;v&agrave;&nbsp;<strong>hệ thống camera</strong>&nbsp;n&acirc;ng cấp. Về diện mạo, m&aacute;y S25 Ultra c&oacute; vẻ ngo&agrave;i được bo tr&ograve;n mềm mại hơn, mang lại cảm gi&aacute;c cầm nắm dễ chịu hơn, viền mỏng hơn gia tăng kh&ocirc;ng gian hiển thị. Về khả năng chụp ảnh, camera&nbsp;<a title=\"Samsung\" href=\"https://cellphones.com.vn/mobile/samsung.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung</strong></a>&nbsp;g&oacute;c si&ecirc;u rộng của d&ograve;ng điện thoại mới được n&acirc;ng cấp l&ecirc;n độ ph&acirc;n giải 50MP, hứa hẹn chất lượng ảnh chụp ấn tượng hơn.</p>\r\n<h2 id=\"mot-vai-cau-hoi-khi-mua-s25-ultra-5g-chinh-hang\"><strong>Một v&agrave;i c&acirc;u hỏi khi mua S25 Ultra 5G ch&iacute;nh h&atilde;ng</strong></h2>\r\n<p>Việc lựa chọn một chiếc flagship đi đ&ocirc;i với tầm gi&aacute; S25 Ultra 5G mang đến sẽ đ&ograve;i hỏi sự c&acirc;n nhắc kỹ lưỡng về hiệu năng, c&ocirc;ng nghệ v&agrave; trải nghiệm thực tế. Người d&ugrave;ng thường đặt ra nhiều c&acirc;u hỏi li&ecirc;n quan đến cấu h&igrave;nh, t&iacute;nh năng v&agrave; gi&aacute; trị sử dụng trước khi đưa ra quyết định. Dưới đ&acirc;y l&agrave; những vấn đề quan trọng cần xem x&eacute;t để đảm bảo m&aacute;y đ&aacute;p ứng đ&uacute;ng nhu cầu của bạn.</p>\r\n<h3 id=\"samsung-s25-ultra-khi-nao-ra-mat\"><strong>Samsung S25 Ultra khi n&agrave;o ra mắt?</strong></h3>\r\n<p><strong>Samsung S25 Ultra</strong>&nbsp;ra mắt Việt Nam v&agrave;o&nbsp;<strong>1:00 s&aacute;ng ng&agrave;y 23/1/2025</strong>&nbsp;tại sự kiện&nbsp;<strong>Galaxy Unpacked 2025</strong>&nbsp;diễn ra ở&nbsp;<strong>San Jose, Hoa Kỳ</strong>.</p>\r\n<p>Điểm nhấn từ thư mời của Samsung l&agrave; biểu tượng ng&ocirc;i sao 4 c&aacute;nh, gợi nhắc đến logo&nbsp;<strong>Galaxy AI</strong>&nbsp;&ndash; t&iacute;nh năng tr&iacute; tuệ nh&acirc;n tạo đột ph&aacute;. Điện thoại lần n&agrave;y hứa hẹn sẽ thiết lập ti&ecirc;u chuẩn mới cho c&ocirc;ng nghệ di động năm 2025.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-khi-nao-ra-mat.jpg\" alt=\"Samsung S25 Ultra ra mắt Việt Nam ng&agrave;y 23/01/2025\" loading=\"lazy\"></p>\r\n<h3 id=\"samsung-s25-ultra-co-gi-cai-tien-hon-truoc\"><strong>Samsung S25 Ultra c&oacute; g&igrave; cải tiến hơn trước?</strong></h3>\r\n<p><strong>C&ocirc;ng nghệ AI</strong>&nbsp;l&agrave; một trong những điểm&nbsp;<strong>quan trọng nhất</strong>&nbsp;tr&ecirc;n d&ograve;ng&nbsp;<strong>Samsung&nbsp;S&nbsp;Series</strong>&nbsp;n&oacute;i chung, với c&aacute;c t&iacute;nh năng&nbsp;<strong>Galaxy AI</strong>&nbsp;được n&acirc;ng cấp mạnh mẽ, bao gồm:</p>\r\n<ul>\r\n<li>\r\n<p>Human-like AI Agents</p>\r\n</li>\r\n<li>\r\n<p>Nền tảng AI t&iacute;ch hợp</p>\r\n</li>\r\n<li>\r\n<p>AI C&aacute; nh&acirc;n ho&aacute;</p>\r\n</li>\r\n</ul>\r\n<h3 id=\"samsung-s25-ultra-co-may-mau-mau-nao-moi-xuat-hien\"><strong>Samsung S25 Ultra c&oacute; mấy m&agrave;u? M&agrave;u n&agrave;o mới xuất hiện?</strong></h3>\r\n<p><strong>S25 Ultra</strong>&nbsp;<strong>Samsung&nbsp;</strong>sở hữu&nbsp;<strong>4 m&agrave;u sắc</strong>&nbsp;tinh tế v&agrave; hiện đại gồm:&nbsp;<strong>Xanh Titan, X&aacute;m Titan, Bạc Titan v&agrave; Đen Titan</strong>. C&oacute; thể thấy m&agrave;u sắc mới xuất hiện l&agrave;<strong>&nbsp;Bạc Titan</strong>&nbsp;v&agrave; Xanh Titan thay thế cho T&iacute;m v&agrave; V&agrave;ng của đời trước. Ngo&agrave;i ra c&oacute; 1 số m&agrave;u sắc kh&aacute;c chỉ c&oacute; tại Samsung.com như V&agrave;ng Hồng, Đen Tuyền, Xanh Ngọc Titan. Với nhiều tuỳ chọn n&agrave;y, người d&ugrave;ng dễ d&agrave;ng lựa chọn phi&ecirc;n bản ph&ugrave; hợp với phong c&aacute;ch c&aacute; nh&acirc;n.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-co-may-mau_1.jpg\" alt=\"Samsung S25 Ultra c&oacute; 4 m&agrave;u n&ecirc;n mua\" loading=\"lazy\"></p>\r\n<h3 id=\"samsung-s25-ultra-co-chong-nuoc-khong\"><strong>Samsung S25 Ultra c&oacute; chống nước kh&ocirc;ng?</strong></h3>\r\n<p><strong>Samsung Galaxy S25 Ultra</strong>&nbsp;được thiết kế chống nước vượt trội&nbsp;<strong>đạt chuẩn IP68</strong>, cho ph&eacute;p thiết bị hoạt động ổn định trong nhiều điều kiện. Khung titan chắc chắn c&ugrave;ng&nbsp;<strong>k&iacute;nh Corning&reg; Gorilla&reg; Armor 2</strong>&nbsp;mang lại sự bảo vệ to&agrave;n diện trước những t&aacute;c động h&agrave;ng ng&agrave;y như trầy xước, bụi bẩn v&agrave; va đập. Đ&acirc;y l&agrave; chiếc smartphone l&yacute; tưởng cho những ai t&igrave;m kiếm sự bền bỉ, mạnh mẽ m&agrave; kh&ocirc;ng l&agrave;m mất đi sự tinh tế v&agrave; sang trọng trong thiết kế.</p>\r\n<p>B&ecirc;n cạnh đ&oacute;, bạn c&oacute; thể kh&aacute;m ph&aacute; ngay tổng hợp c&aacute;c mẫu&nbsp;<a title=\"Samsung S25\" href=\"https://cellphones.com.vn/mobile/samsung/galaxy-s/s25-series.html\" target=\"_blank\" rel=\"noopener\"><strong>Samsung S25</strong></a>&nbsp;ch&iacute;nh h&atilde;ng để c&oacute; th&ecirc;m nhiều lựa chọn đa dạng hơn với mức ưu đ&atilde;i sốc hơn 10 triệu khi mua tại CellphoneS. C&ugrave;ng kh&aacute;m ph&aacute; ngay để kh&ocirc;ng bỏ qua cơ hội chọn mua sản phẩm ph&ugrave; hợp ngay nh&eacute;!</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Samsung/samsung_s/S25/dien-thoai-samsung-galaxy-s25-ultra-co-chong-nuoc-khong.jpg\" alt=\"Samsung Galaxy S25 5G Ultra chống nước chuẩn IP68\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-samsung-s25-ultra-gia-re-chinh-hang-tai-cellphones\"><strong>Mua Samsung S25 Ultra gi&aacute; rẻ, ch&iacute;nh h&atilde;ng tại CellphoneS&nbsp;</strong></h2>\r\n<p>Sở hữu si&ecirc;u phẩm flagship hiệu năng đỉnh cao v&agrave; thiết kế thời thượng chỉ trong tầm tay tại CellphoneS.&nbsp;<strong>Mua ngay Samsung Galaxy S25 Ultra</strong>&nbsp;gi&aacute; rẻ, ch&iacute;nh h&atilde;ng&nbsp;<strong>tại CellphoneS</strong> để trải nghiệm sự tuyệt vời của chiếc điện thoại n&agrave;y. Với CellphoneS, bạn sẽ được hưởng bảo h&agrave;nh thời gian d&agrave;i. Hơn nữa, bạn c&oacute; thể đăng k&yacute; nhận th&ocirc;ng tin khuyến m&atilde;i qua email từ CellphoneS để lu&ocirc;n cập nhật về những ưu đ&atilde;i v&agrave; th&ocirc;ng tin mới nhất về Samsung.</p>\r\n</blockquote>\r\n</div>\r\n</div>', 'uploads/689a432675206_Samsung Galaxy S25 Ultra.webp', 9, 17, '2025-08-05 17:38:51', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>6.9 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Dynamic AMOLED 2X</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera sau</td>\r\n<td>\r\n<p>Camera si&ecirc;u rộng 50MP<br>Camera g&oacute;c rộng 200 MP<br>Camera Tele (5x) 50MP<br>Camera Tele (3x) 10MP\"</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera trước</td>\r\n<td>\r\n<p>12 MP</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Chipset</td>\r\n<td>\r\n<p>Snapdragon 8 Elite d&agrave;nh cho Galaxy (3nm)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ NFC</td>\r\n<td>\r\n<p>C&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>12 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Bộ nhớ trong</td>\r\n<td>\r\n<p>256 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Pin</td>\r\n<td>\r\n<p>5000 mAh</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>Android 15</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>3120 x 1440 pixels (Quad HD+)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(27, 'iPhone 16 Pro Max 256GB | Chính hãng VN/A', 34990000.00, 14.00, '<h2 class=\"ksp-title\">Đặc điểm nổi bật của iPhone 16 Pro Max 256GB | Ch&iacute;nh h&atilde;ng VN/A</h2>\r\n<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<p><strong>iPhone 16 Pro Max&nbsp;</strong>sở hữu chipset A18 Pro mạnh mẽ gi&uacute;p xử l&yacute; nhanh mọi t&aacute;c vụ, camera 48 MP zoom quang 5x cho ảnh n&eacute;t, m&agrave;n h&igrave;nh 6.9 inch sống động. Pin dung lượng cao của m&aacute;y hỗ trợ ph&aacute;t video tới 33 tiếng, đ&aacute;p ứng nhu cầu giải tr&iacute; li&ecirc;n tục suốt ng&agrave;y d&agrave;i. C&ugrave;ng với đ&oacute; l&agrave; thiết kế khung Titanium bền nhẹ, mang lại cảm gi&aacute;c sang trọng v&agrave; chắc chắn khi cầm.</p>\r\n<h2 id=\"gia-iphone-16-pro-max-bao-nhieu-tien-08-2025\"><strong>Gi&aacute; iPhone 16 Pro Max bao nhi&ecirc;u tiền 08/2025?</strong></h2>\r\n<p>Gi&aacute; iPhone 16 Pro Max hiện đang ở mức 30.39 triệu đồng cho phi&ecirc;n bản 256GB, l&agrave; lựa chọn phổ biến với dung lượng lưu trữ đ&aacute;p ứng tốt cho nhu cầu th&ocirc;ng thường. Với những người d&ugrave;ng thường xuy&ecirc;n l&agrave;m việc với dữ liệu lớn hoặc đam m&ecirc; chụp ảnh, quay phim, phi&ecirc;n bản 512GB c&oacute; gi&aacute; 36.79 triệu đồng sẽ l&agrave; lựa chọn hợp l&yacute; hơn.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-1.jpg\" alt=\"Gi&aacute; iPhone 16 Pro Max bao nhi&ecirc;u tiền\" loading=\"lazy\"></p>\r\n<p>Trong khi đ&oacute;, phi&ecirc;n bản cao cấp hơn với dung lượng 1TB hiện đang được b&aacute;n ở mức 42.99 triệu đồng, ph&ugrave; hợp cho những kh&aacute;ch h&agrave;ng muốn lưu trữ thoải m&aacute;i dữ liệu chuy&ecirc;n s&acirc;u. Dưới đ&acirc;y l&agrave; bảng gi&aacute; chi tiết c&aacute;c phi&ecirc;n bản iPhone16 Pro Max tại CellphoneS v&agrave;o 08/2025:</p>\r\n<p>&nbsp;</p>\r\n<div>\r\n<table class=\"seo-table seo-product-price table is-bordered is-narrow is-hoverable is-fullwidth\">\r\n<thead>\r\n<tr>\r\n<td>\r\n<p><strong>T&ecirc;n sản phẩm</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; b&aacute;n</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Gi&aacute; thu cũ l&ecirc;n đời</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 256GB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>29.990.000đ</p>\r\n</td>\r\n<td>\r\n<p>27.990.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 512GB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>36.790.000đ</p>\r\n</td>\r\n<td>\r\n<p>34.790.000đ</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>iPhone 16 Pro Max 1TB | Ch&iacute;nh h&atilde;ng VN/A</p>\r\n</td>\r\n<td>\r\n<p>42.990.000đ</p>\r\n</td>\r\n<td>\r\n<p>40.990.000đ</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p>&nbsp;</p>\r\n<h2 id=\"iphone-16-pro-max-co-nhung-phien-ban-gb-nao\"><strong>iPhone 16 Pro Max c&oacute; những phi&ecirc;n bản GB n&agrave;o?</strong></h2>\r\n<p>Apple giới thiệu iPhone 16 Pro Max với ba phi&ecirc;n bản bộ nhớ trong kh&aacute;c nhau, gi&uacute;p người d&ugrave;ng dễ d&agrave;ng lựa chọn theo đ&uacute;ng nhu cầu sử dụng v&agrave; khả năng t&agrave;i ch&iacute;nh. C&aacute;c phi&ecirc;n bản lần lượt gồm iPhone16 Pro Max 256 GB, phi&ecirc;n bản 512GB v&agrave; phi&ecirc;n bản dung lượng lớn 1TB.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-2_1.jpg\" alt=\"iPhone 16 Pro Max c&oacute; những phi&ecirc;n bản GB n&agrave;o\" loading=\"lazy\"></p>\r\n<p>Với kh&aacute;ch h&agrave;ng th&ocirc;ng thường, phi&ecirc;n bản&nbsp;<a title=\"iPhone 16\" href=\"https://cellphones.com.vn/mobile/apple/iphone-16.html\" target=\"_blank\" rel=\"noopener\"><strong>iPhone16</strong></a>&nbsp;bản Pro Max 256 GB l&agrave; lựa chọn l&yacute; tưởng bởi mức gi&aacute; hợp l&yacute; c&ugrave;ng dung lượng lưu trữ đủ d&ugrave;ng h&agrave;ng ng&agrave;y. Tuy nhi&ecirc;n, những người c&oacute; nhu cầu cao về lưu trữ hoặc ghi nhớ dữ liệu lớn n&ecirc;n c&acirc;n nhắc phi&ecirc;n bản 512GB v&agrave; 1TB để c&oacute; trải nghiệm tốt hơn m&agrave; kh&ocirc;ng gặp giới hạn dung lượng.</p>\r\n<h2 id=\"danh-gia-iphone-16-pro-max-chip-a18-pro-man-hinh-lon\"><strong>Đ&aacute;nh gi&aacute; iPhone 16 Pro Max: Chip A18 Pro, m&agrave;n h&igrave;nh lớn</strong></h2>\r\n<p>iPhone 16 Pro Max kh&ocirc;ng chỉ l&agrave;&nbsp;<a title=\"điện thoại\" href=\"https://cellphones.com.vn/mobile.html\" target=\"_blank\" rel=\"noopener\"><strong>điện thoại</strong></a>&nbsp;được n&acirc;ng cấp mạnh mẽ về phần cứng m&agrave; c&ograve;n t&iacute;ch hợp h&agrave;ng loạt c&ocirc;ng nghệ mới nhằm tối ưu trải nghiệm người d&ugrave;ng. Từ chip xử l&yacute;, m&agrave;n h&igrave;nh, camera cho đến pin v&agrave; tr&iacute; tuệ nh&acirc;n tạo, tất cả đều g&oacute;p phần tạo n&ecirc;n một thiết bị cao cấp to&agrave;n diện.</p>\r\n<h3 id=\"chip-a18-pro-mang-den-hieu-nang-manh-me\"><strong>Chip A18 Pro mang đến hiệu năng mạnh mẽ</strong></h3>\r\n<p>Với chip A18 Pro, iPhone16 Pro Max dễ d&agrave;ng xử l&yacute; c&aacute;c t&aacute;c vụ nặng nhờ CPU 6 l&otilde;i với 2 l&otilde;i hiệu năng cao v&agrave; 4 l&otilde;i tiết kiệm năng lượng. GPU 6 l&otilde;i mạnh mẽ, gi&uacute;p người d&ugrave;ng thao t&aacute;c mượt m&agrave; với c&aacute;c tựa game đồ họa cao v&agrave; chỉnh sửa video 4K nhanh ch&oacute;ng.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-3_1.jpg\" alt=\"Cấu h&igrave;nh iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, Neural Engine 16 l&otilde;i c&ograve;n gi&uacute;p tăng cường đ&aacute;ng kể hiệu suất xử l&yacute; AI, n&acirc;ng cao trải nghiệm người d&ugrave;ng. Nhờ chip A18 Pro, iPhone 16 Pro Max tiết kiệm điện hiệu quả hơn, hỗ trợ thiết bị hoạt động m&aacute;t v&agrave; ổn định trong thời gian d&agrave;i.</p>\r\n<blockquote>\r\n<p>Trong c&ugrave;ng series, điện thoại&nbsp;<a title=\"iPhone 16 thường\" href=\"https://cellphones.com.vn/iphone-16.html\" target=\"_blank\" rel=\"noopener\"><strong>iPhone 16 thường</strong></a>&nbsp;(bản ti&ecirc;u chuẩn) v&agrave; iPhone 16 Plus c&oacute; sự&nbsp;<strong>kh&aacute;c biệt về con chip</strong>&nbsp;so với bản Pro v&agrave; Pro Max. Xem chi tiết th&ocirc;ng số v&agrave; gi&aacute; b&aacute;n của iPhone 16 thường 128GB ngay tại CellphoneS!</p>\r\n</blockquote>\r\n<h3 id=\"camera-sac-net-zoom-quang-hoc-den-5x\"><strong>Camera sắc n&eacute;t, zoom quang học đến 5x</strong></h3>\r\n<p>Hệ thống camera tr&ecirc;n iPhone16 Pro Max với cảm biến ch&iacute;nh 48MP c&ugrave;ng c&ocirc;ng nghệ OIS gi&uacute;p ghi lại từng chi tiết sắc n&eacute;t trong mọi điều kiện &aacute;nh s&aacute;ng. Đặc biệt, camera Telephoto 5x (12MP) c&ograve;n hỗ trợ người d&ugrave;ng chụp được chủ thể r&otilde; n&eacute;t từ khoảng c&aacute;ch xa m&agrave; kh&ocirc;ng giảm chất lượng h&igrave;nh ảnh.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-4_1.jpg\" alt=\"Camera iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, iPhone 16 Pro Max c&ograve;n sở hữu camera g&oacute;c si&ecirc;u rộng 48MP cung cấp khả năng bắt trọn khung cảnh rộng lớn với g&oacute;c nh&igrave;n 120 độ. Qua đ&oacute;, kh&aacute;ch h&agrave;ng c&ograve;n c&oacute; thể quay video chuy&ecirc;n nghiệp chuẩn 4K Dolby Vision l&ecirc;n tới 120FPS, tạo n&ecirc;n những thước phim đỉnh cao ngay tr&ecirc;n Smartphone.</p>\r\n<h3 id=\"man-hinh-lon-6-9-inch-tan-so-quet-120hz\"><strong>M&agrave;n h&igrave;nh lớn 6.9 inch, tần số qu&eacute;t 120Hz</strong></h3>\r\n<p>iPhone 16 PRM sở hữu m&agrave;n h&igrave;nh lớn hơn so với c&aacute;c phi&ecirc;n bản tiền nhiệm với k&iacute;ch thước 6.9 inch, sử dụng c&ocirc;ng nghệ Super Retina XDR OLED cho độ ph&acirc;n giải 2868 x 1320 pixel. M&agrave;n h&igrave;nh của m&aacute;y hỗ trợ tần số qu&eacute;t ProMotion 120Hz gi&uacute;p mọi thao t&aacute;c cuộn trang, chuyển cảnh diễn ra mượt m&agrave;, kh&ocirc;ng độ trễ.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-5.jpg\" alt=\"M&agrave;n h&igrave;nh iPhone16 Pro Max\" loading=\"lazy\"></p>\r\n<p>Ấn tượng hơn, độ s&aacute;ng tối đa tr&ecirc;n iPhone 16 Pro Max c&ograve;n l&ecirc;n tới 2000 nits, hỗ trợ hiển thị r&otilde; n&eacute;t ngay cả dưới &aacute;nh nắng trực tiếp ngo&agrave;i trời. Với m&agrave;n h&igrave;nh chất lượng cao n&agrave;y, người d&ugrave;ng dễ d&agrave;ng thưởng thức nội dung HDR sống động với độ tương phản ấn tượng 2,000,000:1.</p>\r\n<h3 id=\"thiet-ke-chat-lieu-titan-cao-cap\"><strong>Thiết kế chất liệu titan cao cấp</strong></h3>\r\n<p>Thiết kế l&agrave; điểm nổi bật tiếp theo của iPhone 16 PRM với khung viền từ chất liệu Titanium nhẹ nhưng bền chắc, vừa gi&uacute;p giảm trọng lượng vừa tăng độ bền cho m&aacute;y. Mặt sau của m&aacute;y ho&agrave;n thiện từ vật liệu k&iacute;nh mờ nh&aacute;m, gi&uacute;p hạn chế b&aacute;m bẩn v&agrave; vết v&acirc;n tay, giữ thiết bị lu&ocirc;n sang trọng, sạch sẽ.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-6_2.jpg\" alt=\"Thiết kế chất liệu titan cao cấp\" loading=\"lazy\"></p>\r\n<p>Ở ph&iacute;a trước mặt trước, iPhone 16 PRM được trang bị k&iacute;nh Ceramic Shield thế hệ mới tăng khả năng chống va đập, trầy xước cực hiệu quả. Sự kết hợp giữa khung Titan v&agrave; c&aacute;c m&agrave;u sắc như Black Titanium, White Titanium, Natural Titanium, Desert Titanium sẽ tạo n&ecirc;n vẻ ngo&agrave;i cao cấp, thời thượng cho iPhone 16 Pro Max.</p>\r\n<h3 id=\"thoi-luong-pin-den-33-tieng\"><strong>Thời lượng pin đến 33 tiếng</strong></h3>\r\n<p>Thời lượng pin vượt trội l&ecirc;n tới 33 giờ xem video li&ecirc;n tục l&agrave; một lợi thế lớn của iPhone16 Pro Max, gi&uacute;p người d&ugrave;ng thoải m&aacute;i giải tr&iacute; cả ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng lo hết pin. Thiết bị cũng hỗ trợ sạc nhanh c&ocirc;ng suất 20W, chỉ trong 30 ph&uacute;t đ&atilde; c&oacute; thể sạc đầy 50% pin.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-7.jpg\" alt=\"Thời lượng pin đến 33 tiếng\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, khả năng sạc kh&ocirc;ng d&acirc;y MagSafe l&ecirc;n tới 25W gi&uacute;p tăng tốc độ sạc tiện lợi hơn. Người d&ugrave;ng c&oacute; thể y&ecirc;n t&acirc;m mang theo iPhone 16 Pro Max cả ng&agrave;y m&agrave; kh&ocirc;ng cần lo lắng về vấn đề năng lượng.</p>\r\n<h3 id=\"apple-intelligence-thong-minh\"><strong>Apple Intelligence th&ocirc;ng minh</strong></h3>\r\n<p>T&iacute;ch hợp Apple Intelligence, iPhone 16 PRM mang tới trải nghiệm th&ocirc;ng minh v&agrave; c&aacute; nh&acirc;n h&oacute;a tối ưu. Nhờ AI, thiết bị c&oacute; khả năng tự động tối ưu hiệu suất, quản l&yacute; pin hiệu quả v&agrave; bảo vệ dữ liệu c&aacute; nh&acirc;n tốt hơn.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-8.jpg\" alt=\"Apple Intelligence th&ocirc;ng minh\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, AI cũng hỗ trợ iPhone16 Pro Max tối đa trong việc chụp ảnh, quay video với t&iacute;nh năng nhận diện cảnh vật, chỉnh m&agrave;u sắc tự nhi&ecirc;n v&agrave; sống động. Đồng thời, Apple Intelligence c&ograve;n gi&uacute;p người d&ugrave;ng thực hiện c&aacute;c t&aacute;c vụ thường xuy&ecirc;n nhanh ch&oacute;ng, n&acirc;ng cao hiệu quả c&ocirc;ng việc mỗi ng&agrave;y.</p>\r\n<h2 id=\"mua-iphone-16-pro-max-phu-hop-phong-thuy\"><strong>Mua iPhone 16 Pro Max ph&ugrave; hợp phong thủy</strong></h2>\r\n<p>Lựa chọn m&agrave;u sắc iPhone 16 Pro Max 256 GB ph&ugrave; hợp phong thủy gi&uacute;p kh&aacute;ch h&agrave;ng gia tăng may mắn, t&agrave;i lộc v&agrave; tạo năng lượng t&iacute;ch cực trong c&ocirc;ng việc, cuộc sống. Mỗi phi&ecirc;n bản m&agrave;u sắc của điện thoại đều mang &yacute; nghĩa ri&ecirc;ng biệt, đại diện cho c&aacute;c yếu tố phong thủy đặc trưng ph&ugrave; hợp với từng c&aacute; t&iacute;nh v&agrave; mệnh người d&ugrave;ng.</p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><strong>M&agrave;u sắc</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>M&ocirc; tả chi tiết v&agrave; gợi &yacute;</strong></p>\r\n</td>\r\n<td>\r\n<p><strong>Mệnh hợp phong thủy</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Đen</p>\r\n</td>\r\n<td>\r\n<p>Sang trọng, chuy&ecirc;n nghiệp, tối giản, ph&ugrave; hợp người th&iacute;ch vẻ đẹp cổ điển v&agrave; mạnh mẽ.</p>\r\n</td>\r\n<td>\r\n<p>Thủy, Mộc (biểu trưng cho sự vững ch&atilde;i, ổn định).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Trắng</p>\r\n</td>\r\n<td>\r\n<p>Tinh khiết, thanh lịch, hiện đại, mang lại cảm gi&aacute;c sạch sẽ v&agrave; tươi mới.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thủy (tượng trưng cho sự trong s&aacute;ng, may mắn).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Tự Nhi&ecirc;n</p>\r\n</td>\r\n<td>\r\n<p>Trung t&iacute;nh, độc đ&aacute;o, dễ phối, vẻ đẹp nguy&ecirc;n bản của titanium, kh&ocirc;ng qu&aacute; ph&ocirc; trương.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thủy (gi&uacute;p c&acirc;n bằng, tạo sự h&agrave;i h&ograve;a).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Titanium Sa Mạc</p>\r\n</td>\r\n<td>\r\n<p>Độc đ&aacute;o, nổi bật, c&aacute; t&iacute;nh, m&agrave;u v&agrave;ng nhạt độc đ&aacute;o, ấm &aacute;p, ph&ugrave; hợp người th&iacute;ch sự kh&aacute;c biệt.</p>\r\n</td>\r\n<td>\r\n<p>Kim, Thổ, Hỏa (biểu thị sự vững chắc, t&agrave;i lộc, năng lượng t&iacute;ch cực).</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Từ việc lựa chọn đ&uacute;ng m&agrave;u sắc, kh&aacute;ch h&agrave;ng kh&ocirc;ng chỉ thể hiện c&aacute; t&iacute;nh m&agrave; c&ograve;n tạo sự c&acirc;n bằng, thu h&uacute;t năng lượng t&iacute;ch cực theo bản mệnh. iPhone 16 Pro Max v&igrave; thế trở th&agrave;nh một m&oacute;n đồ c&ocirc;ng nghệ vừa tinh tế, vừa mang &yacute; nghĩa phong thủy ph&ugrave; hợp với từng người d&ugrave;ng.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-max-9.jpg\" alt=\"Mua iPhone 16 Pro Max ph&ugrave; hợp phong thủy\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-iphone-16-promax-tra-gop-0-lai-tai-cellphones-ngay\"><strong>Mua iPhone 16 Promax trả g&oacute;p 0% l&atilde;i tại CellphoneS ngay</strong></h2>\r\n<p>Kh&aacute;ch h&agrave;ng muốn sở hữu iPhone 16 Pro Max nhưng ngại vấn đề t&agrave;i ch&iacute;nh c&oacute; thể dễ d&agrave;ng mua trả g&oacute;p 0% l&atilde;i tại CellphoneS. Với hơn 100 cửa h&agrave;ng tr&ecirc;n to&agrave;n quốc, CellphoneS cam kết cung cấp sản phẩm ch&iacute;nh h&atilde;ng, bảo h&agrave;nh minh bạch. Ch&iacute;nh s&aacute;ch trả g&oacute;p linh hoạt, duyệt nhanh trong ng&agrave;y gi&uacute;p kh&aacute;ch h&agrave;ng sở hữu sản phẩm dễ d&agrave;ng, kh&ocirc;ng &aacute;p lực t&agrave;i ch&iacute;nh. Gh&eacute; tới CellphoneS ngay để trải nghiệm mua sắm thuận tiện khi chọn mua iPhone 16 PRM!&nbsp;</p>\r\n</div>\r\n</div>', 'uploads/689a4116be517_iPhone 16 Pro Max 256GB.webp', 9, 13, '2025-08-05 17:47:20', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>6.9 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera sau</td>\r\n<td>\r\n<p>Camera ch&iacute;nh: 48MP</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Camera trước</td>\r\n<td>\r\n<p>12MP, &fnof;/1.9, Tự động lấy n&eacute;t theo pha Focus Pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Chipset</td>\r\n<td>\r\n<p>Apple A18 Pro</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ NFC</td>\r\n<td>\r\n<p>C&oacute;</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Bộ nhớ trong</td>\r\n<td>\r\n<p>256 GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Thẻ SIM</td>\r\n<td>\r\n<p>Sim k&eacute;p (nano-Sim v&agrave; e-Sim) - Hỗ trợ 2 e-Sim</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>iOS 18</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>2868 x 1320 pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>T&iacute;nh năng m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Dynamic Island<br>M&agrave;n h&igrave;nh HDR<br>True Tone<br>Dải m&agrave;u rộng (P3)<br>Haptic Touch<br>Tỷ lệ tương phản 2.000.000:1</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>CPU 6 l&otilde;i mới với 2 l&otilde;i hiệu năng v&agrave; 4 l&otilde;i hiệu suất</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0);
INSERT INTO `products` (`id`, `name`, `price`, `discount`, `description`, `image_url`, `category_id`, `supplier_id`, `created_at`, `content`, `isDeleted`) VALUES
(30, 'Laptop Dell Gaming G15 5530 i7 13650HX', 35290000.00, 16.00, '<div class=\"ProductContent_description-container__miT3z\">\r\n<p class=\"MsoNormal\">Một chiếc laptop chơi game 15 inch thời trang v&agrave; s&agrave;nh điệu, <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/dell-gaming-g15-5530-71053700\"><strong>Dell Gaming G15 5530</strong></a> được thiết kế để mang lại hiệu suất c&ugrave;ng phong c&aacute;ch ấn tượng. Sức mạnh từ bộ vi xử l&yacute; Intel Core i7 13650HX, card đồ họa RTX 3050 v&agrave; c&aacute;c t&iacute;nh năng tối ưu cho game độc quyền từ Dell sẽ gi&uacute;p bạn khai ph&aacute; hết sức mạnh, tập trung tối đa năng lượng cho c&ocirc;ng việc cũng như chơi game.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_6_8010ea238d.jpg\" alt=\"Dell-Gaming-G15-6.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Bộ vi xử l&yacute; i7-13650HX mạnh mẽ, sẵn s&agrave;ng chiến game</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 sở hữu Intel&reg; Core&trade; i7-13650HX thế hệ 13, con chip mạnh mẽ đủ để gi&uacute;p bạn l&agrave;m mọi thứ ưng &yacute;. Với 14 nh&acirc;n, 20 luồng, tốc độ tối đa 4.9GHz, CPU n&agrave;y xử l&yacute; mượt m&agrave; c&aacute;c game nặng như Cyberpunk 2077 hoặc Far Cry 6 ở thiết lập đồ họa trung b&igrave;nh đến cao. Game thủ sẽ thấy mọi cảnh trong game h&agrave;nh động đều diễn ra trơn tru, kh&ocirc;ng lo giật lag. Nếu bạn l&agrave;m s&aacute;ng tạo, i7-13650HX chạy tốt c&aacute;c phần mềm như Adobe After Effects để dựng video hoặc Blender để l&agrave;m m&ocirc; h&igrave;nh 3D. D&acirc;n văn ph&ograve;ng c&oacute; thể thoải m&aacute;i mở nhiều ứng dụng, từ Excel với bảng t&iacute;nh lớn, Zoom họp trực tuyến, đến Chrome với h&agrave;ng chục tab m&agrave; m&aacute;y vẫn chạy &ecirc;m &aacute;i.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_4_01ffe0861e.jpg\" alt=\"Dell-Gaming-G15-4.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Tận hưởng game đồ họa cao v&agrave; l&agrave;m nội dung chuy&ecirc;n nghiệp với card RTX 3050</strong></h2>\r\n<p class=\"MsoNormal\">Card đồ họa NVIDIA&reg; GeForce RTX&trade; 3050 6GB GDDR6 l&agrave; điểm nhấn quan trọng tr&ecirc;n Laptop Dell Gaming G15 5530. C&ocirc;ng nghệ Ray Tracing mang đến &aacute;nh s&aacute;ng, b&oacute;ng đổ sống động, khiến c&aacute;c game như Battlefield V hoặc God of War đẹp như phim. C&ocirc;ng nghệ DLSS 2.0 tăng khung h&igrave;nh mỗi gi&acirc;y, gi&uacute;p bạn chơi c&aacute;c game fps như Call of Duty: Warzone mượt m&agrave; ở thiết lập đồ họa tương đối cao. Ngo&agrave;i chơi game, RTX 3050 c&ograve;n hỗ trợ tốt c&aacute;c c&ocirc;ng việc s&aacute;ng tạo, từ chỉnh sửa video tr&ecirc;n Premiere Pro, l&agrave;m ảnh tr&ecirc;n Photoshop, Lightroom cho đến render đồ họa cơ bản. Với sức mạnh n&agrave;y, Laptop Dell Gaming G15 5530 đ&aacute;p ứng tốt cả nhu cầu giải tr&iacute; lẫn c&ocirc;ng việc chuy&ecirc;n s&acirc;u.</p>\r\n<h2 class=\"MsoNormal\"><strong>RAM 16GB DDR5 v&agrave; SSD 512GB tăng tốc to&agrave;n diện</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 sở hữu 16GB RAM DDR5 4800MHz v&agrave; 512GB M.2 PCIe NVMe SSD, mang đến hiệu suất mượt m&agrave; v&agrave; khả năng lưu trữ thoải m&aacute;i. RAM DDR5 nhanh hơn nhiều so với DDR4, gi&uacute;p bạn chơi Valorant, stream tr&ecirc;n OBS Studio, đồng thời chỉnh sửa ảnh tr&ecirc;n Lightroom m&agrave; m&aacute;y vẫn chạy ổn. SSD 512GB cho tốc độ khởi động Windows, tải game nhanh ch&oacute;ng chỉ trong v&agrave;i gi&acirc;y, c&ugrave;ng kh&ocirc;ng gian đủ để lưu game, video, t&agrave;i liệu c&ocirc;ng việc. Game thủ, nh&agrave; s&aacute;ng tạo, d&acirc;n văn ph&ograve;ng đều được sẽ được hưởng lợi từ tốc độ, khiến Laptop Dell Gaming G15 5530 trở th&agrave;nh cỗ m&aacute;y đa nhiệm l&yacute; tưởng.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_2_e32fba41dc.jpg\" alt=\"Dell-Gaming-G15-2.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Thiết kế gaming c&aacute; t&iacute;nh, dễ d&agrave;ng mang theo</strong></h2>\r\n<p class=\"MsoNormal\">Laptop Dell Gaming G15 5530 phi&ecirc;n bản m&agrave;u Dark Shadow Grey với logo Dell nổi bật, đậm chất gaming. Kiểu d&aacute;ng đặc trưng từ d&ograve;ng Dell Gaming tạo n&ecirc;n điểm nhấn ấn tượng khiến Dell G15 kh&ocirc;ng bị nh&agrave;m ch&aacute;n như hầu hết đối thủ tr&ecirc;n thị trường. <a href=\"https://fptshop.com.vn/phu-kien/ban-phim\">B&agrave;n ph&iacute;m</a> RGB 4 v&ugrave;ng đẹp mắt, g&otilde; thoải m&aacute;i, t&iacute;ch hợp b&agrave;n ph&iacute;m số tiện cho c&ocirc;ng việc t&iacute;nh to&aacute;n. Hệ thống tản nhiệt lấy cảm hứng từ Alienware giữ m&aacute;y m&aacute;t khi chơi game nặng. Touchpad rộng, mượt m&agrave;, hỗ trợ thao t&aacute;c nhanh. Thiết kế n&agrave;y gi&uacute;p Laptop Dell Gaming G15 5530 vừa đẹp, vừa thực dụng, lại kh&ocirc;ng k&eacute;m phần phong c&aacute;ch.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_5_0cb9d659f3.jpg\" alt=\"Dell-Gaming-G15-5.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Tăng tốc lập tức chỉ bằng một ph&iacute;m bấm</strong></h2>\r\n<p class=\"MsoNormal\">Khi cần sức mạnh ngay tức th&igrave; để giải quyết những pha combat căng thẳng hoặc xử l&yacute; t&aacute;c vụ nặng, chỉ một lần nhấn ph&iacute;m F9 tr&ecirc;n Dell Gaming G15 l&agrave; đủ. Đ&acirc;y kh&ocirc;ng chỉ l&agrave; một ph&iacute;m chức năng th&ocirc;ng thường m&agrave; c&ograve;n l&agrave; ph&iacute;m macro Game Shift, cho ph&eacute;p đẩy quạt l&ecirc;n tốc độ tối đa. Khi đ&oacute;, hệ thống sẽ tự động k&iacute;ch hoạt chế độ Dynamic Performance Mode, CPU chuyển sang trạng th&aacute;i hiệu năng cao để gi&uacute;p bạn vượt qua c&aacute;c ph&acirc;n cảnh game nặng hoặc xử l&yacute; những c&ocirc;ng việc đ&ograve;i hỏi hiệu suất t&iacute;nh to&aacute;n khắt khe. Kh&ocirc;ng cần tho&aacute;t game, kh&ocirc;ng cần mở menu phụ, mọi thứ chỉ g&oacute;i gọn trong một thao t&aacute;c.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_3_7595134139.jpg\" alt=\"Dell-Gaming-G15-3.jpg\" loading=\"lazy\"></p>\r\n<h2 class=\"MsoNormal\"><strong>Hệ thống tản nhiệt lấy cảm hứng từ Alienware</strong></h2>\r\n<p class=\"MsoNormal\">Thiết kế tản nhiệt tr&ecirc;n d&ograve;ng Dell G15 được kế thừa từ c&aacute;c d&ograve;ng m&aacute;y Alienware cao cấp. Với bốn ống đồng dẫn nhiệt, hệ thống quạt được tinh chỉnh lại bằng c&aacute;c c&aacute;nh si&ecirc;u mỏng, diện t&iacute;ch trao đổi nhiệt sẽ được mở rộng đ&aacute;ng kể. Tản nhiệt tốt kh&ocirc;ng chỉ gi&uacute;p m&aacute;y bền bỉ qua thời gian m&agrave; c&ograve;n đảm bảo hiệu năng lu&ocirc;n được duy tr&igrave; ổn định.</p>\r\n<h2 class=\"MsoNormal\"><strong>T&ugrave;y chỉnh mọi thứ nhờ Alienware Command Center</strong></h2>\r\n<p class=\"MsoNormal\">Với Alienware Command Center phi&ecirc;n bản mới, bạn c&oacute; to&agrave;n quyền kiểm so&aacute;t chiếc <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/dell-gaming-g-series\">laptop Dell Gaming</a> của m&igrave;nh. Những preset hiệu năng c&oacute; sẵn gi&uacute;p tối ưu tr&ograve; chơi theo phong c&aacute;ch bạn muốn, trong khi khả năng &eacute;p xung mở ra lựa chọn để đẩy hệ thống l&ecirc;n mức tốc độ cao hơn nữa. Bạn cũng c&oacute; thể bật lớp hiển thị th&ocirc;ng tin trực tiếp tr&ecirc;n <a href=\"https://fptshop.com.vn/man-hinh\">m&agrave;n h&igrave;nh</a>, bao gồm hiệu suất CPU, GPU, bộ nhớ hay nhiệt độ m&agrave; kh&ocirc;ng cần tho&aacute;t khỏi game. Đ&egrave;n LED RGB c&oacute; thể t&ugrave;y chỉnh linh hoạt theo từng v&ugrave;ng hoặc đồng bộ với c&aacute;c thiết bị ngoại vi Alienware kh&aacute;c. Với Vision Engine, c&aacute;c lớp hiển thị hỗ trợ sẽ xuất hiện đ&uacute;ng l&uacute;c, gi&uacute;p bạn giữ được sự tập trung tối đa trong c&aacute;c pha xử l&yacute;.</p>\r\n<p class=\"MsoNormal\"><img src=\"https://cdn2.fptshop.com.vn/unsafe/800x0/Dell_Gaming_G15_1_34c804a365.jpg\" alt=\"Dell-Gaming-G15-1.jpg\" loading=\"lazy\"></p>\r\n</div>', 'uploads/68989b54badd9_Laptop Dell Gaming G15 5530 i7 13650HX.webp', 1, 2, '2025-08-06 04:52:20', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>NVIDIA GeForce RTX 4060, 8GB GDDR6</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại RAM</td>\r\n<td>\r\n<p>DDR5 4800MHz</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Số khe ram</td>\r\n<td>\r\n<p>2 khe (2x 8GB, n&acirc;ng cấp tối đa 32GB)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>1TB M.2 PCIe NVMe SSD</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>15.6 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>ComfortViewPlus <br>NVIDIA GSYNC+ DDS Display</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Pin</td>\r\n<td>\r\n<p>Pin liền,6-Cell Battery, 86WHr (Integrated), 330W</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>Windows 11 Home + Office Home &amp; Student 2021</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>1920 x 1080 pixels (FullHD)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Intel Core i7-13650HX (24MB Cache, Turbo Boost 4.7 GHz)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(31, 'Apple Watch Ultra 2 2024 49mm 4G Viền Titan', 25990000.00, 1.00, '<div id=\"cpsContentSEO\">\r\n<h2 id=\"apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-ngoai-hinh-sang-trong-cong-nghe-dinh-cao\"><strong> Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan - Ngoại h&igrave;nh sang trọng, c&ocirc;ng nghệ đỉnh cao </strong></h2>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan l&agrave; phi&ecirc;n bản cao cấp trong d&ograve;ng smartwatch của Apple với h&agrave;ng hoạt điểm ấn tượng. Sở hữu khung viền titan v&agrave; c&aacute;c c&ocirc;ng nghệ vượt bậc, đồng hồ <a title=\"Apple Watch Ultra 2\" href=\"https://cellphones.com.vn/do-choi-cong-nghe/apple-watch/ultra-2.html\" target=\"_blank\" rel=\"noopener\"><strong>Apple Watch Ultra 2</strong></a> kh&ocirc;ng những đem đến sự tiện lợi m&agrave; c&ograve;n l&agrave; biểu tượng của vẻ đẹp sang trọng.</p>\r\n<h3 id=\"duong-kinh-mat-lon-49mm-man-hinh-retina-ltpo2-oled\"><strong> Đường k&iacute;nh mặt lớn 49mm, m&agrave;n h&igrave;nh Retina LTPO2 OLED </strong></h3>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan sở hữu đường k&iacute;nh mặt đồng hồ 49mm, đem đến trải nghiệm sử dụng ấn tượng. Thiết bị n&agrave;y sử dụng m&agrave;n h&igrave;nh Retina LTPO2 OLED, hiển thị sắc n&eacute;t 410 x 502 pixels c&ugrave;ng độ s&aacute;ng l&ecirc;n tới 3000 nits. Mặt k&iacute;nh được ho&agrave;n thiện từ Sapphire cứng c&aacute;p, ngăn trầy xước v&agrave; tăng độ bền cho sản phẩm khi sử dụng trong c&aacute;c m&ocirc;i trường khắc nghiệt.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Watch/Apple/Ultra-2/apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-3.jpg\" alt=\"M&agrave;n h&igrave;nh Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan\" loading=\"lazy\"></p>\r\n<h3 id=\"vien-va-day-deo-titan-manh-me-hang-loat-tinh-nang-uu-viet\"><strong> Viền v&agrave; d&acirc;y đeo Titan mạnh mẽ, h&agrave;ng loạt t&iacute;nh năng ưu việt </strong></h3>\r\n<p>Khung viền của Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan được l&agrave;m từ Titanium - chất liệu si&ecirc;u nhẹ nhưng cực kỳ bền. B&ecirc;n cạnh đ&oacute; l&agrave; d&acirc;y đeo Titan của đồng hồ kh&ocirc;ng những nổi bật về độ bền m&agrave; c&ograve;n mang lại vẻ ngo&agrave;i mạnh mẽ v&agrave; hiện đại. Đồng hồ cũng g&acirc;y ấn tượng với lượng pin lớn v&agrave; h&agrave;ng loạt t&iacute;nh năng, từ theo d&otilde;i chỉ số cơ thể,...</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Watch/Apple/Ultra-2/apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-2.jpg\" alt=\"D&acirc;y đeo Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan\" loading=\"lazy\"></p>\r\n<h2 id=\"mua-ngay-apple-watch-ultra-2-2024-49mm-4g-vien-titan-den-day-titan-chinh-hang-voi-gia-sieu-uu-dai-tai-cellphones\"><strong> Mua ngay Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan ch&iacute;nh h&atilde;ng với gi&aacute; si&ecirc;u ưu đ&atilde;i tại CellphoneS </strong></h2>\r\n<p>Apple Watch Ultra 2 2024 49mm 4G viền titan đen d&acirc;y titan l&agrave; chiếc smartwatch mang vẻ đẹp mạnh mẽ, đ&aacute;ng đầu tư cho c&aacute;c t&iacute;n đồ c&ocirc;ng nghệ. Hiện nay, chiếc đồng hồ đẳng cấp n&agrave;y đang được ph&acirc;n phối ch&iacute;nh h&atilde;ng tại CellphoneS - hệ thống b&aacute;n lẻ h&agrave;ng đầu thị trường Việt. Tại đ&acirc;y, CellphoneS sẽ cung cấp Apple Watch Ultra 2 2024 49mm với chất lượng đảm bảo, gi&aacute; si&ecirc;u hấp dẫn nhờ &aacute;p dụng nhiều ưu đ&atilde;i.</p>\r\n</div>', 'uploads/689897bd3addf_Apple Watch Ultra 2 2024 49mm 4G Viền Titan.webp', 7, 13, '2025-08-06 13:43:52', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Retina LTPO2 OLED<br>Độ s&aacute;ng 3000 nit</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>1185 mm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Đường k&iacute;nh mặt</td>\r\n<td>\r\n<p>49 mm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước cổ tay ph&ugrave; hợp</td>\r\n<td>\r\n<p>15.5 &ndash; 18.5 cm</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Thời lượng pin</td>\r\n<td>\r\n<p>L&ecirc;n đến 36 giờ khi sử dụng b&igrave;nh thường<br>L&ecirc;n đến 72 giờ ở Chế Độ Nguồn Điện Thấp</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>H&atilde;ng sản xuất</td>\r\n<td>\r\n<p>Apple Ch&iacute;nh h&atilde;ng</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(32, 'iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB', 39990000.00, 1.00, '<div id=\"cpsContentSEO\">\r\n<h2 id=\"imac-m4-2024-10gpu-16gb-256gb-thiet-ke-sieu-mong-hieu-nang-manh-me\"><strong> iMac M4 2024 10GPU 16GB 256GB - Thiết kế si&ecirc;u mỏng, hiệu năng mạnh mẽ </strong></h2>\r\n<p>iMac M4 2024 10GPU 16GB 256GB mang đến ngoại h&igrave;nh bắt mắt c&ugrave;ng hiệu năng vượt trội khi t&iacute;ch hợp chip M4 ti&ecirc;n tiến. Đặc biệt hơn, d&ograve;ng <a title=\"iMac ch&iacute;nh h&atilde;ng\" href=\"https://cellphones.com.vn/laptop/mac/imac.html\" target=\"_blank\" rel=\"noopener\"><strong>iMac</strong></a> của nh&agrave; Apple c&ograve;n nổi bật với c&ocirc;ng nghệ Apple Intelligence sở hữu nhiều tiện &iacute;ch độc quyền. Với camera chất lượng cao, iMac hỗ trợ người d&ugrave;ng họp trực tuyến v&ocirc; c&ugrave;ng hiệu quả.&nbsp;</p>\r\n<h3 id=\"tich-hop-chip-m4-tien-tien-cung-cong-nghe-apple-intelligence-doc-quyen\"><strong> T&iacute;ch hợp chip M4 ti&ecirc;n tiến c&ugrave;ng c&ocirc;ng nghệ Apple Intelligence độc quyền </strong></h3>\r\n<p>Đi k&egrave;m với con chip M4 ti&ecirc;n tiến, d&ograve;ng sản phẩm iMac của thương hiệu Apple sở hữu sức mạnh nhanh hơn đến 2,1 lần so với iMac d&ugrave;ng chip M1 trước đ&oacute;. Cấu tr&uacute;c của con chip gồm 10 l&otilde;i CPU v&agrave; 10 l&otilde;i GPU đảm bảo mọi t&aacute;c vụ đồ họa của bạn đều được xử l&yacute; mượt m&agrave;.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-3.jpg\" alt=\"Cấu h&igrave;nh iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>B&ecirc;n cạnh đ&oacute;, iMac c&ograve;n t&iacute;ch hợp c&ocirc;ng nghệ Apple Intelligence mang đến nhiều tiện &iacute;ch như hiệu đ&iacute;nh văn bản, hỗ trợ viết l&aacute;ch, tạo những h&igrave;nh ảnh vui nhộn,... Ưu điểm nổi bật của Apple Intelligence l&agrave; bảo vệ quyền ri&ecirc;ng tư của người d&ugrave;ng tối đa n&ecirc;n bạn c&oacute; thể y&ecirc;n t&acirc;m về những th&ocirc;ng tin c&aacute; nh&acirc;n của m&igrave;nh.</p>\r\n<p>B&ecirc;n trong của <strong><a href=\"https://cellphones.com.vn/bo-loc/imac-m4\" target=\"_blank\" rel=\"noopener\">iMac M4</a></strong> l&agrave; bộ nhớ RAM đạt đến 16GB hỗ trợ đa nhiệm nhiều t&aacute;c vụ mượt m&agrave;. Đi k&egrave;m với iMac l&agrave; ổ cứng SSD với khả năng lưu trữ dung lượng đến 256GB. Với ổ cứng dung lượng lớn, bạn c&oacute; thể thoải m&aacute;i lưu trữ mọi thiết kế đồ họa của m&igrave;nh m&agrave; kh&ocirc;ng bị tr&agrave;n bộ nhớ.&nbsp;</p>\r\n<h3 id=\"man-hinh-retina-sac-net-voi-hon-nhieu-gam-mau-song-dong\"><strong> M&agrave;n h&igrave;nh Retina sắc n&eacute;t với hơn nhiều gam m&agrave;u sống động </strong></h3>\r\n<p>iMac của nh&agrave; Apple sở hữu m&agrave;n h&igrave;nh Retina bắt mắt với khung h&igrave;nh 4,5K sắc n&eacute;t. Kết hợp với đ&oacute; l&agrave; dải m&agrave;u rộng P3 đảm bảo mọi nội dung hiển thị tr&ecirc;n m&agrave;n h&igrave;nh trở n&ecirc;n sống động v&agrave; rực rỡ với hơn 1 tỷ gam m&agrave;u.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-1.jpg\" alt=\"M&agrave;n h&igrave;nh iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Đặc biệt hơn, m&agrave;n h&igrave;nh của iMac M4 c&ograve;n mang đến độ s&aacute;ng đạt đến 500nits gi&uacute;p bạn c&oacute; thể quan s&aacute;t r&otilde; mọi chi tiết tr&ecirc;n khung h&igrave;nh trong mọi điều kiện &aacute;nh s&aacute;ng. C&ocirc;ng nghệ True Tone c&oacute; tr&ecirc;n m&agrave;n h&igrave;nh hỗ trợ tự động điều chỉnh độ s&aacute;ng ph&ugrave; hợp với m&ocirc;i trường xung quanh đảm bảo người d&ugrave;ng kh&ocirc;ng bị mỏi mắt khi sử dụng.&nbsp;</p>\r\n<h3 id=\"kieu-dang-sieu-mong-nhieu-gam-mau-ruc-ro\"><strong> Kiểu d&aacute;ng si&ecirc;u mỏng, nhiều gam m&agrave;u rực rỡ </strong></h3>\r\n<p>D&ograve;ng iMac của thương hiệu Apple được ưa chuộng ở kiểu d&aacute;ng si&ecirc;u mỏng n&ecirc;n bạn c&oacute; thể lắp đặt trong mọi kh&ocirc;ng gian l&agrave;m việc. Chiếc iMac cũng mang đến nhiều phi&ecirc;n bản m&agrave;u đa dạng bao gồm cam, bạc, xanh dương, t&iacute;m, xanh l&aacute;, hồng v&agrave; v&agrave;ng. Mặt trước của iMac được bao phủ bởi mặt k&iacute;nh Nano‑texture cao cấp hỗ trợ duy tr&igrave; chất lượng h&igrave;nh ảnh sắc n&eacute;t.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-2.jpg\" alt=\"Thiết kế iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Phần tr&ecirc;n của chiếc iMac được trang bị camera 12MP với t&iacute;nh năng tập trung v&agrave;o người d&ugrave;ng l&agrave;m t&acirc;m điểm. Nhờ v&agrave;o đ&oacute;, mọi khung h&igrave;nh của bạn lu&ocirc;n được sắc n&eacute;t v&agrave; n&acirc;ng cao hiệu quả c&aacute;c cuộc gọi video hay họp trực tuyến.&nbsp;</p>\r\n<p>&gt;&gt;&gt; Xem th&ecirc;m mẫu&nbsp;<a href=\"https://cellphones.com.vn/imac-m4-2024-24-inch-10cpu-10gpu-16gb-512gb.html\" target=\"_blank\" rel=\"noopener\">iMac M4 2024 24 inch 10CPU 10GPU 16GB 512GB</a> mới gi&aacute; cực tốt c&ugrave;ng nhiều ưu đ&atilde;i hấp dẫn.</p>\r\n<h3 id=\"ho-tro-lien-ket-nhieu-thiet-bi-linh-hoat-va-truyen-tai-noi-dung-nhanh-chong\"><strong> Hỗ trợ li&ecirc;n kết nhiều thiết bị linh hoạt v&agrave; truyền tải nội dung nhanh ch&oacute;ng </strong></h3>\r\n<p>Thế hệ iMac M4 nổi bật với t&iacute;nh năng truyền tải nội dung từ iPhone l&ecirc;n m&agrave;n h&igrave;nh 24 inch gi&uacute;p bạn quan s&aacute;t khung h&igrave;nh của m&igrave;nh r&otilde; hơn. Đi k&egrave;m theo đ&oacute; l&agrave; cổng Thunderbolt 4 hỗ trợ sao ch&eacute;p dữ liệu nhanh ch&oacute;ng giữa c&aacute;c thiết bị c&ocirc;ng nghệ. C&ocirc;ng nghệ Wifi 6E c&ograve;n mang đến tốc độ truyền tệp tin mượt m&agrave; v&agrave; ổn định.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/iMac/M4/imac-m4-2024-24-inch-10cpu-10gpu-16gb-256gb-4.jpg\" alt=\"Kết nối iMac M4 2024 10GPU 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Ngo&agrave;i ra, bạn c&ograve;n c&oacute; thể tận dụng c&aacute;c cổng Thunderbolt 4 để li&ecirc;n kết với 2 m&agrave;n h&igrave;nh nhằm mở rộng kh&ocirc;ng gian l&agrave;m việc của m&igrave;nh. iMac c&ograve;n đi k&egrave;m với b&agrave;n ph&iacute;m Magic v&agrave; chuột với c&aacute;c t&iacute;nh năng như mở kh&oacute;a Touch ID nhanh ch&oacute;ng, sử dụng Apple Pay tiện lợi,...</p>\r\n<h2 id=\"mua-ngay-imac-m4-2024-10gpu-16gb-256gb-chinh-hang-tai-cellphones\"><strong> Mua ngay iMac M4 2024 10GPU 16GB 256GB ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>iMac M4 2024 10GPU 16GB 256GB nổi bật với kiểu d&aacute;ng bắt mắt c&ugrave;ng hiệu năng mạnh mẽ hỗ trợ xử l&yacute; mọi t&aacute;c vụ đồ họa nhanh ch&oacute;ng. Khi đặt mua iMac M4 ch&iacute;nh h&atilde;ng tại CellphoneS, bạn sẽ được khuyến m&atilde;i v&ocirc; c&ugrave;ng hấp dẫn d&agrave;nh cho Smember. Chọn mua ngay iMac M4 tại CellphoneS bạn nh&eacute;.&nbsp;</p>\r\n</div>', 'uploads/6898945290456_iMac M4 2024 24 inch 10CPU 10GPU 16GB 256GB.webp', 6, 13, '2025-08-06 13:44:47', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>GPU 10 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>256GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>24 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>M&agrave;n h&igrave;nh Retina 4.5K<br>1 tỷ m&agrave;u<br>Độ s&aacute;ng 500 nit<br>Dải m&agrave;u rộng (P3)<br>C&ocirc;ng nghệ True Tone</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>4480 x 2520 (4.5K)</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Apple M4 10 l&otilde;i với 4 l&otilde;i hiệu năng v&agrave; 6 l&otilde;i tiết kiệm điện<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(34, 'Mac mini M4 2024 10CPU 10GPU 16GB 256GB', 14990000.00, 1.00, '<p>Mac mini M4 2024 16GB 256GB sở hữu thiết kế nhỏ gọn với c&aacute;c cổng thiết kế mặt trước v&agrave; sau sử dụng tiện lợi. Về cấu h&igrave;nh, d&ograve;ng <a title=\"Mac mini ch&iacute;nh h&atilde;ng\" href=\"https://cellphones.com.vn/laptop/mac/mini.html\" target=\"_blank\" rel=\"noopener\"><strong>Mac mini</strong></a> n&agrave;y sở hữu cấu h&igrave;nh mạnh với chip M4 c&ugrave;ng với đ&oacute; l&agrave; sự hỗ trợ bởi Apple Intelligence th&ocirc;ng minh.</p>\r\n<div id=\"cpsContentSEO\">\r\n<h2 id=\"mac-mini-m4-2024-16gb-256gb--cau-hinh-vuot-troi-dap-ung-da-dang-nhu-cau\"><strong> Mac mini M4 2024 16GB 256GB &ndash; Cấu h&igrave;nh vượt trội, đ&aacute;p ứng đa dạng nhu cầu </strong></h2>\r\n<p>Mac mini M4 2024 16GB 256GB l&agrave; thế hệ mac mini mới với thiết kế c&ugrave;ng cấu h&igrave;nh được cải tiến. Thế hệ Mac n&agrave;y c&ograve;n được t&iacute;ch hợp AI th&ocirc;ng minh, n&acirc;ng cao hiệu năng sử dụng, vậy ch&iacute;nh x&aacute;c sản phẩm ra sao th&igrave; h&atilde;y c&ugrave;ng t&igrave;m hiểu sau đ&acirc;y.</p>\r\n<h3 id=\"thiet-ke-nho-cong-ket-noi-hai-mat-truoc-va-sau\"><strong> Thiết kế nhỏ, cổng kết nối hai mặt trước v&agrave; sau </strong></h3>\r\n<p>Mac mini M4 2024 16GB 256GB dược trang bị một thiết kế mới với vẻ ngo&agrave;i nhỏ gọn một c&aacute;ch ấn tượng. Với k&iacute;ch thước 5x5 inch, sản phẩm chỉ bằng 1/20 k&iacute;ch thước c&aacute;c d&ograve;ng m&aacute;y t&iacute;nh để b&agrave;n c&ugrave;ng tầm gi&aacute; nhưng lại cho hiệu năng đến 6x.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-2.jpg\" alt=\"Thiết kế Mac mini M4 2024 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>Tuy nhỏ gọn những sản phẩm <strong><a title=\"Mac Mini M4\" href=\"https://cellphones.com.vn/bo-loc/mac-mini-m4-series\" target=\"_blank\" rel=\"noopener\">Mac Mini M4</a></strong> n&agrave;y vẫn được trang bị c&aacute;c cổng kết nối để tối ưu qu&aacute; tr&igrave;nh sử dụng của người sử dụng ở cả hai mặt trước v&agrave; sau. Cụ thể, ở ph&iacute;a trước imac sở hữu 2 cổng USB-C v&agrave; jack tai nghe trong khi đ&oacute; mặt sau l&agrave; cổng Ethernet, cổng thunderbolt 4 v&agrave; cổng HDMI. Người d&ugrave;ng c&oacute; thể kết nối iMac với nhiều phụ kiện như b&agrave;n ph&iacute;m, tai nghe, chuột, m&agrave;n h&igrave;nh để đảm bảo hiệu suất c&ocirc;ng việc.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-1.jpg\" alt=\"Thiết kế Mac mini M4 2024 16GB 256GB\" loading=\"lazy\"></p>\r\n<p>C&ugrave;ng với đ&oacute;, b&ecirc;n trong một thiết kế nhỏ gọn n&agrave;y, Apple c&ograve;n trang bị cho thiết bị hệ thống tản nhiệt chất lượng. Nhờ hệ thống n&agrave;y, kh&ocirc;ng kh&iacute; được dẫn qua nhiều tầng v&agrave; tho&aacute;t qua phần đầy gi&uacute;p giải tỏa nhiệt lượng hiệu quả.</p>\r\n<h3 id=\"hoat-dong-manh-me-voi-chip-m4-cung-ai\"><strong> Hoạt động mạnh mẽ với chip M4 c&ugrave;ng AI </strong></h3>\r\n<p>Mac mini M4 2024 16GB 256GB với phần cứng từ con chip M4 mạnh mẽ nhờ đ&oacute; mang lại một hiệu năng vượt trội. C&ugrave;ng với AI th&ocirc;ng minh, người d&ugrave;ng c&oacute; thể sử dụng iMac M4 để thực hiện c&aacute;c c&ocirc;ng việc s&aacute;ng tạo như chỉnh sửa video Final&nbsp;Cut&nbsp;Pro hay thiết kế với Adobe Photoshop. Hay c&aacute;c c&ocirc;ng việc lập tr&igrave;nh với imac mini m4 n&agrave;y cũng được thực hiện với khả năng bi&ecirc;n dịch m&atilde; nhanh. C&ugrave;ng với đ&oacute; sản phẩm cũng tối ưu cho c&aacute;c tr&ograve; chơi như Prince of Persia: The Lost Crown. Đặc biệt c&ocirc;ng nghệ d&ograve; tia phần cứng với tốc độ cao c&ograve;n tối ưu c&aacute;c hiệu năng &aacute;nh s&aacute;ng, h&igrave;nh ảnh phản chiếu,&hellip;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Mac/Mac-mini/M4/mac-mini-m4-2024-16gb-256gb-3.jpg\" alt=\"Hoạt động mạnh mẽ với chip M4 c&ugrave;ng AI\" loading=\"lazy\"></p>\r\n<p>Đặc biệt tr&ecirc;n th&ecirc; hệ Mac mini M4 2024 16GB 256GB đ&oacute; ch&iacute;nh l&agrave; Apple Intelligence. Đ&acirc;y l&agrave; hệ thống tr&iacute; tuệ nh&acirc;n tạo hỗ trợ người d&ugrave;ng viết l&aacute;ch hay sắp xếp thứ tự c&ocirc;ng việc. Nhờ đ&oacute; tối ưu hiệu suất l&agrave;m việc, gi&uacute;p người d&ugrave;ng sử dụng c&oacute; thể ho&agrave;n th&agrave;nh được c&ocirc;ng việc một c&aacute;ch dễ d&agrave;ng hơn.</p>\r\n<h2 id=\"mua-mac-mini-m4-2024-16gb-256gb-chinh-hang-tai-cellphones\"><strong> Mua Mac mini M4 2024 16GB 256GB ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>Mac mini M4 2024 16GB 256GB sở hữu một cấu h&igrave;nh mạnh b&ecirc;n trong một thiết kế nhỏ gọn. Đ&acirc;y l&agrave; một thiết bị đ&aacute;ng để sở hữu nhờ hiệu năng vượt trội cũng như AI th&iacute;ch hợp. Nếu quan t&acirc;m đến d&ograve;ng Mac mini mới của Apple n&agrave;y, h&atilde;y đến v&agrave; mua tại CellphoneS. Tại đ&acirc;y, kh&aacute;ch h&agrave;ng sẽ được mua trả g&oacute;p với ưu đ&atilde;i hấp dẫn cũng như đa dạng chương tr&igrave;nh thanh to&aacute;n lựa chọn.</p>\r\n</div>', 'uploads/68989327e3c4f_Mac mini M4 2024 10CPU 10GPU 16GB 256GB.webp', 1, 13, '2025-08-06 13:46:36', '<table class=\"technical-content\">\r\n<tbody>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại card đồ họa</td>\r\n<td>\r\n<p>GPU 10 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Dung lượng RAM</td>\r\n<td>\r\n<p>16GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Ổ cứng</td>\r\n<td>\r\n<p>256GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>C&ocirc;ng nghệ m&agrave;n h&igrave;nh</td>\r\n<td>\r\n<p>Hỗ trợ đồng thời đến ba m&agrave;n h&igrave;nh<br>Đầu ra video kỹ thuật số Thunderbolt 4</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Hệ điều h&agrave;nh</td>\r\n<td>\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Loại CPU</td>\r\n<td>\r\n<p>Apple M4 10 l&otilde;i với 4 l&otilde;i hiệu năng v&agrave; 6 l&otilde;i tiết kiệm điện<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\">\r\n<td>Cổng giao tiếp</td>\r\n<td>\r\n<p>Mặt trước:<br>Hai cổng USB‑C hỗ trợ cho USB 3 (l&ecirc;n đến 10Gb/s) <br>Jack cắm tai nghe 3,5 mm<br>Mặt sau (M4): <br>Cổng Gigabit Ethernet (c&oacute; thể lựa chọn cấu h&igrave;nh Ethernet 10Gb)<br>Cổng HDMI<br>Thunderbolt 4 (l&ecirc;n đến 40Gb/s) <br>USB 4 (l&ecirc;n đến 40Gb/s)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(36, 'MacBook Pro 16 M4 Max 14CPU 32GPU 36GB 1TB ', 93790000.00, 2.00, '<div class=\"ksp-content p-2 mb-4\">\r\n<div class=\"cps-content-introduction\">\r\n<p><strong>MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong>&nbsp;l&agrave; si&ecirc;u phẩm c&ocirc;ng nghệ cao cấp nổi bật với chip Apple M4 Max 14 nh&acirc;n CPU v&agrave; 32 nh&acirc;n GPU mạnh mẽ. M&aacute;y được trang bị RAM 36GB, ổ cứng SSD 1TB v&agrave; m&agrave;n h&igrave;nh Liquid Retina XDR 16.2 inch. Thiết kế tinh tế với hệ thống loa trung thực cao, kết nối hiện đại v&agrave; thời lượng pin ấn tượng l&ecirc;n đến 21 giờ. M&aacute;y trang bị hệ điều h&agrave;nh macOS Sequoia v&agrave; t&iacute;ch hợp c&ocirc;ng nghệ AI th&ocirc;ng minh.</p>\r\n</div>\r\n</div>\r\n<div id=\"cpsContentSEO\">\r\n<h2 id=\"macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano--chinh-phuc-moi-tac-vu\"><strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano &ndash; Chinh phục mọi t&aacute;c vụ </strong></h2>\r\n<p>Với <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> , Apple đ&atilde; tạo ra một chiếc m&aacute;y t&iacute;nh x&aacute;ch tay đ&aacute;p ứng mọi nhu cầu c&ocirc;ng việc v&agrave; giải tr&iacute;. M&aacute;y kh&ocirc;ng chỉ sở hữu sức mạnh với chip M4 m&agrave; c&ograve;n c&oacute; thiết kế đẹp mắt v&agrave; thời lượng pin d&agrave;i, đ&aacute;p ứng mọi y&ecirc;u cầu của người d&ugrave;ng.</p>\r\n<h3 id=\"nen-tang-vung-chac-cho-hieu-suat-cao\"><strong> Nền tảng vững chắc cho hiệu suất cao </strong></h3>\r\n<p>MacBook Pro M4 Max trang bị 36GB RAM, một con số đ&aacute;ng kinh ngạc ngay cả đối với c&aacute;c d&ograve;ng m&aacute;y cao cấp. Dung lượng RAM lớn n&agrave;y cho ph&eacute;p <a title=\"Macbook Pro\" href=\"https://cellphones.com.vn/laptop/mac/macbook-pro.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro</strong></a> mở đồng thời h&agrave;ng chục ứng dụng chuy&ecirc;n s&acirc;u m&agrave; kh&ocirc;ng hề gặp phải hiện tượng giật lag. Kh&ocirc;ng chỉ dừng lại ở đa nhiệm, bộ nhớ RAM n&agrave;y c&ograve;n đảm bảo khả năng xử l&yacute; c&aacute;c dự &aacute;n y&ecirc;u cầu t&agrave;i nguy&ecirc;n lớn.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-1.jpg\" alt=\"Cấu h&igrave;nh MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Dung lượng 1TB SSD mang đến kh&ocirc;ng gian rộng r&atilde;i để bạn thoải m&aacute;i lưu trữ dữ liệu. Tuy nhi&ecirc;n, điểm nổi bật kh&ocirc;ng chỉ nằm ở dung lượng. Ổ cứng SSD của chiếc <a title=\"Macbook M4\" href=\"https://cellphones.com.vn/laptop/mac/m4-series.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook M4</strong></a> được thiết kế với tốc độ truy xuất si&ecirc;u nhanh, gi&uacute;p bạn mở c&aacute;c tệp tin lớn trong t&iacute;ch tắc, khởi động ứng dụng nhanh v&agrave; trải nghiệm hiệu suất kh&ocirc;ng độ trễ.</p>\r\n<h3 id=\"su-tinh-te-cham-den-dinh-cao-hoan-thien-den-tung-chi-tiet\"><strong> Sự tinh tế chạm đến đỉnh cao, ho&agrave;n thiện đến từng chi tiết </strong></h3>\r\n<p><strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> c&oacute; th&acirc;n m&aacute;y được chế t&aacute;c tỉ mỉ với c&aacute;c g&oacute;c bo tr&ograve;n mềm mại, h&agrave;i h&ograve;a với viền mỏng quanh m&agrave;n h&igrave;nh, tạo n&ecirc;n tỷ lệ c&acirc;n đối. Độ d&agrave;y chỉ 1.68 cm v&agrave; trọng lượng 2.15 kg mang lại sự c&acirc;n bằng l&yacute; tưởng giữa t&iacute;nh di động v&agrave; sức mạnh.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-3.jpg\" alt=\"Thiết kế MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>B&agrave;n ph&iacute;m Magic Keyboard với h&agrave;nh tr&igrave;nh ph&iacute;m tối ưu mang đến trải nghiệm g&otilde; thoải m&aacute;i, ch&iacute;nh x&aacute;c. Đ&egrave;n nền ph&iacute;m của <a title=\"Macbook Pro M4\" href=\"https://cellphones.com.vn/laptop/mac/macbook-pro/macbook-pro-2024.html\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro M4</strong></a> tự điều chỉnh theo &aacute;nh s&aacute;ng m&ocirc;i trường, kh&ocirc;ng chỉ tiện dụng m&agrave; c&ograve;n tạo n&ecirc;n một vẻ đẹp c&ocirc;ng nghệ hiện đại.&nbsp;</p>\r\n<h3 id=\"hieu-nang-dot-pha-voi-chip-m4-max-tien-tien\"><strong> Hiệu năng đột ph&aacute; với chip M4 Max ti&ecirc;n tiến </strong></h3>\r\n<p>MacBook Pro M4 Max 16 inch g&acirc;y ấn tượng mạnh mẽ nhờ bộ vi xử l&yacute; Apple M4 Max, kết hợp giữa hiệu suất mạnh mẽ v&agrave; tối ưu năng lượng. Với 14 nh&acirc;n CPU, bao gồm 10 nh&acirc;n hiệu năng cao v&agrave; 4 nh&acirc;n tiết kiệm điện, kh&ocirc;ng chỉ xử l&yacute; mượt m&agrave; c&aacute;c t&aacute;c vụ nặng m&agrave; c&ograve;n tiết kiệm năng lượng khi thực hiện c&aacute;c c&ocirc;ng việc nhẹ nh&agrave;ng hơn.</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-2.jpg\" alt=\"Hiệu năng MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Về đồ họa, 32 nh&acirc;n GPU trong M4 Max đưa hiệu suất xử l&yacute; h&igrave;nh ảnh của <a title=\"Macbook Pro 16\" href=\"https://cellphones.com.vn/bo-loc/macbook-pro-16-inch\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro 16</strong></a>&nbsp;l&ecirc;n một tầm cao mới. Kết hợp với Neural Engine 16 l&otilde;i, MacBook Pro M4 Max kh&ocirc;ng chỉ mạnh mẽ m&agrave; c&ograve;n th&ocirc;ng minh, tối ưu h&oacute;a c&aacute;c t&aacute;c vụ tr&iacute; tuệ nh&acirc;n tạo. Điều n&agrave;y tạo n&ecirc;n một cỗ m&aacute;y to&agrave;n diện, kh&ocirc;ng chỉ mạnh ở hiện tại m&agrave; c&ograve;n sẵn s&agrave;ng cho tương lai của c&ocirc;ng nghệ.</p>\r\n<h3 id=\"giai-tri-lien-mach-voi-vien-pin-lon-va-man-hinh-sac-net\"><strong> Giải tr&iacute; liền mạch với vi&ecirc;n pin lớn v&agrave; m&agrave;n h&igrave;nh sắc n&eacute;t </strong></h3>\r\n<p>Pin của <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong> thực sự l&agrave; một điểm s&aacute;ng nổi bật. Với khả năng l&ecirc;n đến 21 giờ xem video li&ecirc;n tục v&agrave; 14 giờ duyệt web kh&ocirc;ng d&acirc;y, hỗ trợ tối đa cho c&ocirc;ng việc v&agrave; giải tr&iacute; cả ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng cần t&igrave;m đến ổ cắm sạc.&nbsp;</p>\r\n<p><img src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/laptop/macbook/macbook-pro/M4/macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-4.jpg\" alt=\"M&agrave;n h&igrave;nh MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano\" loading=\"lazy\"></p>\r\n<p>Điểm ấn tượng của&nbsp;<a title=\"Macbook Pro M4 16 inch\" href=\"https://cellphones.com.vn/bo-loc/macbook-pro-m4-16-inch\" target=\"_blank\" rel=\"noopener\"><strong>Macbook Pro M4 16 inch</strong></a> l&agrave; m&agrave;n h&igrave;nh Liquid Retina XDR, mặc d&ugrave; sở hữu độ ph&acirc;n giải cao v&agrave; độ s&aacute;ng cao l&ecirc;n đến 1.600 nits. Nhưng nhờ c&ocirc;ng nghệ tối ưu năng lượng của Apple, vẫn duy tr&igrave; được thời gian sử dụng l&acirc;u d&agrave;i.</p>\r\n<h2 id=\"mua-ngay-macbook-pro-m4-max-16-inch-14cpu-32gpu-36gb-1tb-nano-chinh-hang-tai-cellphones\"><strong> Mua ngay MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano ch&iacute;nh h&atilde;ng tại CellphoneS </strong></h2>\r\n<p>Sở hữu sức mạnh với <strong> MacBook Pro M4 Max 16 inch 14CPU 32GPU 36GB 1TB Nano </strong>&nbsp;ngay h&ocirc;m nay tại CellphoneS! Khi mua h&agrave;ng tại đ&acirc;y, bạn sẽ được hưởng ch&iacute;nh s&aacute;ch 1 đổi 1 trong 30 ng&agrave;y nếu ph&aacute;t sinh lỗi phần cứng do nh&agrave; sản xuất. Sản phẩm cũng đi k&egrave;m bảo h&agrave;nh 12 th&aacute;ng ch&iacute;nh h&atilde;ng Apple tại trung t&acirc;m bảo h&agrave;nh ủy quyền CareS.vn. Đừng bỏ lỡ cơ hội sở hữu si&ecirc;u phẩm c&ocirc;ng nghệ n&agrave;y ngay h&ocirc;m nay!</p>\r\n</div>', 'uploads/689891e52e07b_MacBook Pro 16 M4 Max 2024 16CPU.webp', 1, 13, '2025-08-06 13:56:05', '<table class=\"technical-content\" style=\"width: 81.1765%; height: 847.6px;\">\r\n<tbody>\r\n<tr class=\"technical-content-item\" style=\"height: 90.4px;\">\r\n<td style=\"width: 19.4581%;\">Loại card đồ họa</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>32 l&otilde;i<br>Neural Engine 16 l&otilde;i</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Dung lượng RAM</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>36GB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Ổ cứng</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>1TB</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">K&iacute;ch thước m&agrave;n h&igrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>16.2 inches</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Hệ điều h&agrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>macOS</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Độ ph&acirc;n giải m&agrave;n h&igrave;nh</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>3456 x 2234 pixels</p>\r\n</td>\r\n</tr>\r\n<tr class=\"technical-content-item\" style=\"height: 68px;\">\r\n<td style=\"width: 19.4581%;\">Loại CPU</td>\r\n<td style=\"width: 77.2041%;\">\r\n<p>Apple M4 Max 14 l&otilde;i với 10 l&otilde;i hiệu năng v&agrave; 4 l&otilde;i tiết kiệm điện</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0),
(37, 'MacBook Air 15 inch M2 2023 8CPU 10GPU ', 37890000.00, 18.00, '<div class=\"ProductContent_description-container__miT3z\">\r\n<p><strong>Ngo&agrave;i việc sở hữu m&agrave;n h&igrave;nh Liquid Retina 15 inch rộng lớn v&agrave; chip M2 mạnh mẽ, phi&ecirc;n bản MacBook Air 2023 m&agrave; bạn đang theo d&otilde;i c&ograve;n ghi điểm nhờ được t&iacute;ch hợp sẵn bộ sạc 70W - gấp đ&ocirc;i c&ocirc;ng suất sạc so với bản ti&ecirc;u chuẩn. Nhờ vậy, qu&aacute; tr&igrave;nh chờ đợi thiết bị nạp năng lượng sẽ được r&uacute;t ngắn đi rất nhiều.</strong></p>\r\n<h3><strong>Chế t&aacute;c tỉ mỉ, bền bỉ v&agrave; cao cấp</strong></h3>\r\n<p>Kh&ocirc;ng chỉ kế thừa phong c&aacute;ch thiết kế tinh xảo v&agrave; chất lượng ho&agrave;n thiện cao cấp của d&ograve;ng MacBook Air, phi&ecirc;n bản MacBook Air 15 M2 2023 c&ograve;n g&acirc;y ấn tượng khi nới rộng k&iacute;ch cỡ <a href=\"https://fptshop.com.vn/man-hinh\">m&agrave;n h&igrave;nh</a> l&ecirc;n ngưỡng 15 inch, từ đ&oacute; mở rộng trải nghiệm hiển thị để bạn quan s&aacute;t c&aacute;c nội dung r&otilde; n&eacute;t hơn.</p>\r\n<p>To&agrave;n bộ th&acirc;n m&aacute;y đều được ho&agrave;n thiện chỉn chu từ nh&ocirc;m chất lượng cao. Lợi thế về chất liệu khung vỏ khiến thiết bị cứng c&aacute;p, chắc chắn m&agrave; vẫn nhẹ nh&agrave;ng linh hoạt. Nhờ chip xử l&yacute; M2 mạnh mẽ v&agrave; &ecirc;m &aacute;i, sản phẩm kh&ocirc;ng tỏa nhiều nhiệt khi vận h&agrave;nh, duy tr&igrave; hiệu năng ấn tượng d&ugrave; kh&ocirc;ng cần t&iacute;ch hợp bộ tản nhiệt chuy&ecirc;n dụng.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-1(1).jpg\" alt=\"Chế t&aacute;c tỉ mỉ, bền bỉ v&agrave; cao cấp\" loading=\"lazy\"></p>\r\n<h3><strong>Đột ph&aacute; về sức mạnh v&agrave; trải nghiệm pin</strong></h3>\r\n<p>Chip xử l&yacute; Apple M2 với sự tăng tiến mạnh mẽ về CPU, GPU v&agrave; khả năng vận h&agrave;nh tiết kiệm pin đem lại trải nghiệm cực kỳ ấn tượng khi sử dụng MacBook Air 15 M2 2023. Con chip n&agrave;y được sản xuất tr&ecirc;n tiến tr&igrave;nh 5nm, quy tụ 20 tỷ b&oacute;ng b&aacute;n dẫn - nhiều hơn 25% so với chip M1. Với khả năng thực hiện 15,8 ng&agrave;n tỷ ph&eacute;p t&iacute;nh mỗi gi&acirc;y, bộ vi xử l&yacute; mới đem tới sự thăng tiến vượt bậc về sức mạnh cho MacBook Air 2023.</p>\r\n<p>Ngo&agrave;i ra, điểm mạnh của chip M2 l&agrave; khả năng vận h&agrave;nh hiệu quả m&agrave; vẫn tiết kiệm pin, gi&uacute;p k&eacute;o d&agrave;i thời lượng trải nghiệm giữa mỗi lần sạc với thế hệ cũ. Theo th&ocirc;ng số do Apple cung cấp, MacBook Air 15 M2 2023 c&oacute; thể vận h&agrave;nh tối đa trong 18 tiếng li&ecirc;n tục.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-2(1).jpg\" alt=\"Đột ph&aacute; về sức mạnh v&agrave; trải nghiệm pin\" loading=\"lazy\"></p>\r\n<h3><strong>Sạc 70W, r&uacute;t ngắn thời gian chờ đợi</strong></h3>\r\n<p>Phi&ecirc;n bản MacBook Air 15 M2 2023 m&agrave; bạn đang theo d&otilde;i được trang bị k&egrave;m bộ sạc 70W đi k&egrave;m trong hộp đựng. C&ocirc;ng suất của bộ sạc n&agrave;y gấp đ&ocirc;i so với chuẩn sạc 35W của phi&ecirc;n bản th&ocirc;ng thường. Điều n&agrave;y sẽ khiến cho qu&aacute; tr&igrave;nh chờ đợi mỗi khi nạp năng lượng cho thiết bị được r&uacute;t ngắn hơn nhiều. Từ đ&oacute;, trải nghiệm giải tr&iacute;, học tập v&agrave; l&agrave;m việc của bạn sẽ trở n&ecirc;n xuy&ecirc;n suốt hơn, trọn vẹn hơn.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-3(2).jpg\" alt=\"Sạc 70W, r&uacute;t ngắn thời gian chờ đợi\" loading=\"lazy\"></p>\r\n<h3><strong>M&agrave;n h&igrave;nh Liquid Retina 15 inch rộng mở</strong></h3>\r\n<p>So với thế hệ cũ, MacBook Air M2 2023 g&acirc;y ấn tượng mạnh về trải nghiệm h&igrave;nh ảnh khi sở hữu m&agrave;n h&igrave;nh lớn tới 15 inch. C&ocirc;ng nghệ Liquid Retina sẽ đảm bảo mỗi khu&ocirc;n h&igrave;nh tr&igrave;nh diễn trước mắt bạn đều cực kỳ trung thực, tươi s&aacute;ng v&agrave; chi tiết. <a href=\"https://fptshop.com.vn/may-tinh-xach-tay/macbook-air\">MacBook Air</a> thế hệ mới c&oacute; thể đ&aacute;p ứng tốt nhu cầu khắt khe về m&agrave;u sắc của những người l&agrave;m c&ocirc;ng việc s&aacute;ng tạo nội dung, dựng phim, chỉnh sửa h&igrave;nh ảnh v&agrave; l&agrave;m đồ họa chuy&ecirc;n nghiệp.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-4(1).jpg\" alt=\"M&agrave;n h&igrave;nh Liquid Retina 15 inch rộng mở\" loading=\"lazy\"></p>\r\n<h3><strong>Trải nghiệm video call sống động v&agrave; đa chiều</strong></h3>\r\n<p>MacBook Air M2 2023 mang tới trải nghiệm li&ecirc;n lạc sống động với sự hỗ trợ của camera 1080p chất lượng cao, việc gọi video call v&agrave; chuyện tr&ograve; th&ocirc;ng qua FaceTime hoặc c&aacute;c phần mềm hỗ trợ chuy&ecirc;n dụng sẽ trở n&ecirc;n r&otilde; r&agrave;ng, sắc n&eacute;t v&agrave; chi tiết hơn bao giờ hết.</p>\r\n<p>Kh&ocirc;ng chỉ vậy, hệ thống loa ngo&agrave;i ch&acirc;n thực với sự kết hợp của 2 loa trầm khử lực c&ugrave;ng 2 loa bổng tần số cao sẽ khiến cho việc diễn đạt c&aacute;c tiết tấu trở n&ecirc;n sống động hơn, s&acirc;u lắng hơn. C&ocirc;ng nghệ Dolby Atmos sẽ đưa bạn v&agrave;o thế giới của &acirc;m thanh đa chiều khi đắm ch&igrave;m trong kh&ocirc;ng gian &acirc;m nhạc v&agrave; phim ảnh chất lượng cao.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-5.jpg\" alt=\"Trải nghiệm video call sống động v&agrave; đa chiều\" loading=\"lazy\"></p>\r\n<h3><strong>Kết hợp cảm biến v&acirc;n tay v&agrave;o Magic Keyboard</strong></h3>\r\n<p>MacBook Air M2 2023 sẽ hỗ trợ bạn đắc lực trong c&ocirc;ng việc với hệ thống b&agrave;n ph&iacute;m Magic Keyboard cao cấp. Trải nghiệm g&otilde; &ecirc;m &aacute;i v&agrave; tốc độ phản hồi nhanh ch&oacute;ng sẽ khiến cho qu&aacute; tr&igrave;nh soạn thảo văn bản của bạn trở n&ecirc;n dễ d&agrave;ng hơn. Ngo&agrave;i ra, Apple c&ograve;n t&iacute;ch hợp th&ecirc;m cơ chế nhận diện v&acirc;n tay Touch ID ở g&oacute;c b&agrave;n ph&iacute;m để r&uacute;t gọn qu&aacute; tr&igrave;nh đăng nhập khi mở m&aacute;y hoặc x&aacute;c thực danh t&iacute;nh khi thanh to&aacute;n.</p>\r\n<p><img src=\"https://cdn2.fptshop.com.vn/unsafe/564x0/filters:quality(80)/Uploads/images/2015/Tin-Tuc/hongtt34/macbook-air-15-m2-2023-8cpu-10gpu-sac-70w-6.jpg\" alt=\"Kết hợp cảm biến v&acirc;n tay v&agrave;o Magic Keyboard\" loading=\"lazy\"></p>\r\n</div>', 'https://res.cloudinary.com/direvsslz/image/upload/v1754667067/products/main/uwjtpkebw3kkttjkefdl.webp', 1, 13, '2025-08-08 15:31:09', '<div id=\"spec-item-0\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Bộ xử l&yacute;: </strong>H&atilde;ng CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple; </span>C&ocirc;ng nghệ CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">M2; </span>Loại CPU: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">8 - Core</span></div>\r\n</div>\r\n<div id=\"spec-item-1\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Đồ họa: </strong>H&atilde;ng (Card Oboard): <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple; </span>T&ecirc;n đầy đủ (Card onbroad): <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Apple M2 GPU 10 nh&acirc;n</span></div>\r\n</div>\r\n<div id=\"spec-item-2\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>RAM: </strong>Dung lượng RAM: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">8 GB; </span>Hỗ trợ RAM tối đa: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">24 GB</span></div>\r\n</div>\r\n<div id=\"spec-item-3\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>Lưu trữ: </strong>Kiểu ổ cứng:&nbsp;SSD;&nbsp;Dung lượng SSD: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">512 GB</span></div>\r\n</div>\r\n<div id=\"spec-item-4\" class=\"tab-content flex flex-col pt-5\">\r\n<div class=\"mb-1 flex items-center gap-2 text-textOnWhitePrimary b2-semibold\"><strong>M&agrave;n h&igrave;nh: </strong>K&iacute;ch thước m&agrave;n h&igrave;nh: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">15.3 inch; </span>C&ocirc;ng nghệ m&agrave;n h&igrave;nh: <span class=\"flex-1 text-textOnWhitePrimary b2-regular\">Liquid Retina; </span>Độ ph&acirc;n giải:&nbsp;2880 x 1864 Pixels</div>\r\n<div class=\"flex gap-2 border-b border-dashed border-b-iconDividerOnWhite py-1.5\">\r\n<div class=\"flex flex-1 flex-col py-0.5\">&nbsp;</div>\r\n</div>\r\n</div>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reason_text` varchar(255) NOT NULL,
  `ban_days` int(11) DEFAULT 0,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
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
-- Table structure for table `reviews`
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
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rating`, `comment`, `user_id`, `product_id`, `isDeleted`, `created_at`) VALUES
(1, 5, '<p>Giao h&agrave;ng nhanh, shipper nhiệt t&igrave;nh</p>', 1, 36, 0, '2025-08-12 12:50:09'),
(3, 4, '<p>H&agrave;ng tốt</p>', 1, 36, 0, '2025-08-12 18:56:50'),
(4, 5, '<p>Sản phẩm qu&aacute; ok</p>', 1, 27, 0, '2025-08-13 08:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `isDeleted`, `created_at`) VALUES
(1, 'Quản lý đơn hàng', 0, '2025-07-26 12:01:16'),
(2, 'Quản lý giao hàng', 0, '2025-08-12 12:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `role_employee`
--

CREATE TABLE `role_employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_employee`
--

INSERT INTO `role_employee` (`id`, `employee_id`, `role_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:06:42'),
(8, 3, 2, 0, '2025-08-12 18:53:22'),
(9, 3, 1, 0, '2025-08-12 18:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id`, `menu_id`, `role_id`, `isDeleted`, `created_at`) VALUES
(1, 1, 1, 0, '2025-07-26 12:01:16'),
(2, 2, 1, 0, '2025-08-12 12:37:24'),
(3, 3, 2, 0, '2025-08-12 12:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
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
-- Dumping data for table `shipping`
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
(21, 'Bến Tre', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-26 11:52:18', '2025-07-26 18:59:32'),
(22, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-07-26 12:23:34', '2025-08-12 02:48:55'),
(23, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-07-26 12:24:47', '2025-08-10 00:22:04'),
(24, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-08-09 15:06:47', '2025-08-09 22:06:47'),
(25, '123 đường 456, xã 789, tỉnh 8910', 'Chưa có', 'Chờ giao', NULL, 0, '2025-08-12 12:24:21', '2025-08-12 19:24:21'),
(26, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-08-12 12:35:52', '2025-08-12 19:44:25'),
(27, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-08-12 12:54:09', '2025-08-12 19:54:51'),
(28, 'xã An Ngãi Tây, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-08-12 18:52:08', '2025-08-13 01:54:30'),
(29, 'xã An Hiệp, tỉnh Vĩnh Long', 'Đã nhận hàng', 'Hoàn thành', NULL, 0, '2025-08-13 07:58:38', '2025-08-13 15:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `isDeleted`) VALUES
(1, 'Chờ xử lý', 0),
(2, 'Đã xác nhận', 0),
(3, 'Đang chuyển hàng', 0),
(4, 'Đang giao hàng', 0),
(5, 'Đã hủy', 0),
(6, 'Giao hàng thành công', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
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
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `Phone`, `Email`, `Address`, `image_url`, `isDeleted`) VALUES
(2, 'Dell', 'Mai Chí Vĩnh', '0795906808', 'vinh092004@gmail.com', 'Xã An Hiệp, tỉnh Vĩnh Long', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766947/suppliers/sg7z2pnyn1pdrfzwmkvj.png', 0),
(3, 'MSI', 'BìnB', '(+84) 394 529 044', 'lephuocbinh@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766923/suppliers/wtyzzpa7f0otlq0lpybs.png', 0),
(4, 'Lenovo', 'BìnB', '0394529044', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766979/suppliers/nzw4ipqfsjmdfskazffr.png', 0),
(7, 'Asus', 'Mai Chí Vĩnh', '0775906808', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752766881/suppliers/zcwbqvd2caxuxqddfcos.svg', 0),
(8, 'HP', 'Mai Chí Vĩnh', '0394529044', 'vinh092004@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752767520/suppliers/obfs1i458ad2pyyqqgjo.png', 0),
(13, 'Apple', 'Chí Vĩnh', '0123456789', 'vinh23861@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1752818631/products/main/temvdmmnwzoztrtslrqm.png', 0),
(14, 'Watch', 'Mai Chí Vĩnh', '0394529044', 'vinh.watch@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1754830127/products/main/bfcmjywvnwus141gg5si.png', 1),
(17, 'SamSung', 'testing', '987654321', 'testing@gmail.com', 'Ba Tri, Bến Tre', 'https://res.cloudinary.com/direvsslz/image/upload/v1754939954/suppliers/qvybuusbsq9ubordc60n.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FullName`, `Email`, `Phone`, `Address`, `PasswordHash`, `CreatedAt`, `isDeleted`, `UpdateAt`, `deleted_by_id`, `deleted_at`, `reason`, `deleted_by_type`) VALUES
(1, 'Mai Chi Vinh', 'vinh092004@gmail.com', '0394529044', 'xã An Hiệp, tỉnh Vĩnh Long', '$2y$10$HCVHK5.yvG6T21dgR45IIOnHAO6Rb0maGPUw7bBQFtJkoK4jF8oSq', '2025-06-24 02:15:10', 0, '2025-08-13 14:58:09', NULL, NULL, NULL, NULL),
(3, 'Chí Vĩnh', 'vinh23861@gmail.com', '0123456789', 'Ba Tri', '$2y$10$RTJ/dwtkZoVXDiU4zP/Vt.JMuort3l6FuFkZdzXWSirRi4cVRSggq', '2025-07-18 14:14:47', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'Chí Vĩnh', 'thach0392376685@gmail.com', '0987654321', 'Ba Tri, Bến Tre', '$2y$10$PQG1JzDIBL0.Yrmri0NADe.aLD0TZnRo0IK89Q/iMMKb5elRZZc12', '2025-08-02 19:55:42', 0, '2025-08-02 19:56:24', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_reports`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `employee_menu`
--
ALTER TABLE `employee_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_id` (`shipping_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_employee`
--
ALTER TABLE `role_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reported_user_id` (`reported_user_id`),
  ADD KEY `reason_id` (`reason_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_menu`
--
ALTER TABLE `employee_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_employee`
--
ALTER TABLE `role_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_reports`
--
ALTER TABLE `user_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `employee_menu`
--
ALTER TABLE `employee_menu`
  ADD CONSTRAINT `employee_menu_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `role_employee`
--
ALTER TABLE `role_employee`
  ADD CONSTRAINT `role_employee_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `role_employee_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `role_menu_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_reports`
--
ALTER TABLE `user_reports`
  ADD CONSTRAINT `user_reports_ibfk_1` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_reports_ibfk_2` FOREIGN KEY (`reason_id`) REFERENCES `reports` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
