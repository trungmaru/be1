-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th1 07, 2023 lúc 02:03 PM
-- Phiên bản máy phục vụ: 5.7.36
-- Phiên bản PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project-be1`
--
CREATE DATABASE IF NOT EXISTS `project-be1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `project-be1`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parent_id`) VALUES
(1, 'Rồng nam mỹ', NULL),
(2, 'Rồng úc', NULL),
(3, 'Kỳ đà', NULL),
(4, 'Tắc kè', NULL),
(5, 'Rắn', NULL),
(6, 'Rùa', NULL),
(7, 'Cá sấu', NULL),
(8, 'Ếch', NULL),
(9, 'Green Iguana', 1),
(10, 'Red Iguana', 1),
(11, 'Albino Iguana', 1),
(12, 'Blue Iguana', 1),
(13, 'Bearded Normal', 2),
(14, 'Bearded Leatherback', 2),
(15, 'Bearded Silkback', 2),
(16, 'Bearded Hypo', 2),
(17, 'Ackie Monitor', 3),
(18, 'Argus Monitor', 3),
(19, 'Tree Monitor', 3),
(20, 'Black Throat Monitor', 3),
(21, 'Carpet Chameleon', 4),
(22, 'Fischer’s Chameleon', 4),
(23, 'Flapneck Chameleon', 4),
(24, 'Graceful Chameleon', 4),
(25, 'Hognose Snake', 5),
(26, 'Corn Snake', 5),
(27, 'Milk Snake', 5),
(28, 'Mexican King Snake', 5),
(29, 'Common Snapping Turtle', 6),
(30, 'Hamilton Turtle', 6),
(31, 'Mississippi Turtle', 6),
(32, 'Yellow Belly Slider Turtle', 6),
(37, 'Siamese Crocodile', 7),
(38, 'Black Caiman Crocodile', 7),
(39, 'Saltwater Crocodile', 7),
(40, 'Pacman Frog', 8),
(41, 'Bull Frog', 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `time_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `phone`, `address`, `status`, `time_create`) VALUES
(9, 16, 'phat01', '02324742724', 'aaaa', 2, '2023-01-07 21:02:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `pet_id`, `color`, `size`, `quantity`, `price`) VALUES
(8, 9, 2, 'Nhạt', '1 tháng', 2, 1000000),
(7, 8, 1, 'Nhạt', '1 tháng', 1, 800000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status`
--

INSERT INTO `order_status` (`id`, `status_name`) VALUES
(0, 'Đang chờ xác nhận'),
(1, 'Đã xác nhận'),
(2, 'Đã hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pets`
--

DROP TABLE IF EXISTS `pets`;
CREATE TABLE IF NOT EXISTS `pets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pet_price` int(11) NOT NULL,
  `pet_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `pet_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pet_view` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `time_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pets`
--

INSERT INTO `pets` (`id`, `pet_name`, `pet_price`, `pet_photo`, `pet_description`, `pet_view`, `category_id`, `time_create`) VALUES
(1, 'Rồng Nam Mỹ Xanh – Green Iguana Hàng Nhập Thái Lan Chuẩn Đẹp', 800000, 'green-iguana-1.jpg,green-iguana-2.jpg,green-iguana-3.jpg', 'Rồng Nam Mỹ – Green Iguana là một loài bò sát cảnh đang được nhiều người ưa chuộng nhất hiện nay. Với ngoại hình đặc biệt, tính cách dễ gần, hiền lành, chúng xứng đáng trở thành người bạn đáng yêu để nuôi trong nhà.', 335, 9, '2022-12-24 15:51:03'),
(2, 'Rồng Nam Mỹ Đỏ – Red Iguana Thuần Chủng Nhập Thái Siêu Đẹp', 1000000, 'red-iguana-1.jpg', 'Rồng Nam Mỹ – Red Iguana là một loài bò sát cảnh đang được nhiều người ưa chuộng nhất hiện nay. Với ngoại hình đặc biệt, tính cách dễ gần, hiền lành, chúng xứng đáng trở thành người bạn đáng yêu để nuôi trong nhà.', 28, 10, '2022-12-24 15:51:03'),
(3, 'Rồng Úc Bearded Dragon Dòng Normal', 900000, 'bearded-dragon-normal-1.jpg', 'Rồng Úc là một trong những dòng bò sát cảnh được yêu thích nhất, chúng phổ biến ở nhiều nơi trên thế giới, nhất là ở Mỹ. Trải qua thời gian dài, Rồng Úc đã được các nhà lai tạo nhân giống thành nhiều dòng với màu sắc khác lạ, đa dạng. Trong đó Rồng Úc Bearded Dragon màu Normal nguyên bản là dòng tiêu chuẩn nhất của loài Rồng này,', 39, 13, '2022-12-24 15:51:03'),
(4, 'Rồng Úc Leatherback – Bearded Dragon Lưng Trơn Đẹp Lạ ', 1500000, 'leatherback-bearded-dragon-1.jpg', 'Rồng Úc Leatherback / Bearded Dragon Lưng Trơn là một dòng đột biến rất độc đáo. Chúng sở hữu phần lưng trơn không có gai mềm mịn và khá mỏng. Điều này sẽ khiến màu sắc của chúng trông tươi và sặc sỡ hơn bình thường. Với vẻ đẹp độc đáo và tính cách hiền lành, Rồng Úc Leatherback hiện nay được rất nhiều người ưa chuộng.', 2, 14, '2022-12-24 15:51:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pets_users_like`
--

DROP TABLE IF EXISTS `pets_users_like`;
CREATE TABLE IF NOT EXISTS `pets_users_like` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`pet_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pets_users_like`
--

INSERT INTO `pets_users_like` (`pet_id`, `user_id`) VALUES
(1, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Không',
  `role` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `phone`, `address`, `role`) VALUES
(1, 'root', '$2y$10$3etEeDHpjfPsFruF0pVK.ejIFk6XmVluz7kDsdEtMX3hFflkpd1YS', '9999999999', 'Không', 2),
(16, 'user01', '$2y$10$igBS9b9mp27CGbmcsTCoweVuUxwlJF3125K/Udz2MoNJW84fP1aqK', '01237123664', 'a', 0),
(3, 'admin1', '$2y$10$1N/XiRWHToefJd6XHioH9uBvHgbmzQauXPpwAysBBHrWfd.20cHQC', '09387857365', 'Không', 1),
(15, 'user23', '$2y$10$OwPnlKqL9LaWtcbeUruKdu97/5XM0NZXqR7INRBekFTtkiQuvuUVa', '04837473347', '1', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`) VALUES
(0, 'User'),
(1, 'Admin'),
(2, 'Root');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
