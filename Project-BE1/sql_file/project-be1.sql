-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 24, 2022 at 08:59 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-be1`
--

CREATE DATABASE IF NOT EXISTS `project-be1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `project-be1`;
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_parent` int(3) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_parent`) VALUES
(1, 'Rồng nam mỹ', 0),
(2, 'Rồng úc', 0),
(3, 'Kỳ đà', 0),
(4, 'Tắc kè', 0),
(5, 'Rắn', 0),
(6, 'Rùa', 0),
(7, 'Cá sấu', 0),
(8, 'Ếch', 0),
(11, 'Green Iguana', 1),
(12, 'Red Iguana', 1),
(13, 'Albino Iguana', 1),
(14, 'Blue Iguana', 1),
(15, 'Rhino Iguana', 1),
(16, 'Rock Iguana', 1),
(17, 'Bearded Normal', 2),
(18, 'Bearded Leatherback', 2),
(19, 'Bearded Silkback', 2),
(20, 'Bearded Hypo', 2),
(21, 'Bearded Dunner', 2),
(22, 'Bearded Striped', 2),
(23, 'Bearded Trans', 2),
(24, 'Bearded Paradox', 2),
(25, 'Bearded Zero', 2),
(26, 'Bearded Witblit', 2),
(27, 'Ackie Monitor', 3),
(28, 'Argus Monitor', 3),
(29, 'Tree Monitor', 3),
(30, 'Black Throat Monitor', 3),
(31, 'Lace Monitor', 3),
(32, 'Nile Monitor', 3),
(33, 'Savannah Monitor', 3),
(34, 'Carpet Chameleon', 4),
(35, 'Fischer’s Chameleon', 4),
(36, 'Flapneck Chameleon', 4),
(37, 'Graceful Chameleon', 4),
(38, 'Jackson’s Chameleon', 4),
(39, 'Meller’s Chameleon', 4),
(40, 'Panther Chameleon', 4),
(41, 'Parson’s Chameleon', 4),
(42, 'Pygmy Chameleon', 4),
(43, 'Senegal Chameleon', 4);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

DROP TABLE IF EXISTS `pets`;
CREATE TABLE IF NOT EXISTS `pets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pet_price` int(11) NOT NULL,
  `pet_photo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pet_description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pet_view` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `time_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `pet_name`, `pet_price`, `pet_photo`, `pet_description`, `pet_view`, `category_id`, `time_create`) VALUES
(1, 'Rồng Nam Mỹ Xanh – Green Iguana Hàng Nhập Thái Lan Chuẩn Đẹp', 800000, 'green-iguana-1.jpg', 'Rồng Nam Mỹ – Green Iguana là một loài bò sát cảnh đang được nhiều người ưa chuộng nhất hiện nay. Với ngoại hình đặc biệt, tính cách dễ gần, hiền lành, chúng xứng đáng trở thành người bạn đáng yêu để nuôi trong nhà.', 8, 11, '2022-12-24 15:51:03'),
(2, 'Rồng Nam Mỹ Đỏ – Red Iguana Thuần Chủng Nhập Thái Siêu Đẹp', 1000000, 'red-iguana-1.jpg', 'Rồng Nam Mỹ – Red Iguana là một loài bò sát cảnh đang được nhiều người ưa chuộng nhất hiện nay. Với ngoại hình đặc biệt, tính cách dễ gần, hiền lành, chúng xứng đáng trở thành người bạn đáng yêu để nuôi trong nhà.', 0, 12, '2022-12-24 15:51:03'),
(3, 'Rồng Úc Bearded Dragon Dòng Normal', 900000, 'bearded-dragon-normal-1.jpg', 'Rồng Úc là một trong những dòng bò sát cảnh được yêu thích nhất, chúng phổ biến ở nhiều nơi trên thế giới, nhất là ở Mỹ. Trải qua thời gian dài, Rồng Úc đã được các nhà lai tạo nhân giống thành nhiều dòng với màu sắc khác lạ, đa dạng. Trong đó Rồng Úc Bearded Dragon màu Normal nguyên bản là dòng tiêu chuẩn nhất của loài Rồng này,', 0, 17, '2022-12-24 15:51:03'),
(4, 'Rồng Úc Leatherback – Bearded Dragon Lưng Trơn Đẹp Lạ ', 1500000, 'leatherback-bearded-dragon-1.jpg', 'Rồng Úc Leatherback / Bearded Dragon Lưng Trơn là một dòng đột biến rất độc đáo. Chúng sở hữu phần lưng trơn không có gai mềm mịn và khá mỏng. Điều này sẽ khiến màu sắc của chúng trông tươi và sặc sỡ hơn bình thường. Với vẻ đẹp độc đáo và tính cách hiền lành, Rồng Úc Leatherback hiện nay được rất nhiều người ưa chuộng.', 0, 18, '2022-12-24 15:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `pets_users_like`
--

DROP TABLE IF EXISTS `pets_users_like`;
CREATE TABLE IF NOT EXISTS `pets_users_like` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`pet_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Không',
  `role_id` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `phone`, `address`, `role_id`) VALUES
(1, 'user1', '$2y$10$I5PxOdfWF3lDHytJgzg2e.rYUWAT/n5HhtLvK10bi6I1JX0clP6li', '0346644210', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`) VALUES
(0, 'admin'),
(1, 'nomal user'),
(2, 'vip user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
