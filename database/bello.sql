-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2017 at 09:31 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bello`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyrequests`
--

CREATE TABLE `buyrequests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_purchase` int(11) NOT NULL,
  `is_cancel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cancelation_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reminder_schedule` date NOT NULL,
  `is_read` int(11) NOT NULL,
  `is_delete` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `buyrequests`
--

INSERT INTO `buyrequests` (`id`, `user_id`, `keyword`, `is_purchase`, `is_cancel`, `cancelation_reason`, `reminder_schedule`, `is_read`, `is_delete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 31040836, 'piano', 0, '', '', '2017-05-29', 0, '', '2017-05-27 04:39:42', '2017-05-27 04:39:42', NULL),
(2, 31040836, 'Iphone', 0, '', '', '2017-05-27', 0, '', '2017-04-27 05:13:39', '2017-04-27 05:13:39', NULL),
(3, 31040836, 'iphone', 0, '', '', '2017-05-27', 0, '', '2017-05-27 07:44:31', '2017-05-27 07:44:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2017_05_16_143512_create_users_table', 1),
('2017_05_16_145039_create_buyrequests_table', 1),
('2017_05_16_145723_create_products_table', 1),
('2017_05_16_150030_create_productviews_table', 1),
('2017_05_27_122408_create_userbuyrequests_table 	', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `for_sale` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `for_sale`, `created_at`, `updated_at`, `deleted_at`) VALUES
('8fw3eo', 31040836, 1, '2017-05-28 09:58:14', '2017-05-21 09:58:14', NULL),
('8fx0ka', 31040836, 1, '2017-05-21 10:00:42', '2017-05-21 10:31:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productviews`
--

CREATE TABLE `productviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interested_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userbuyrequests`
--

CREATE TABLE `userbuyrequests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userbuyrequests`
--

INSERT INTO `userbuyrequests` (`id`, `user_id`, `keyword`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 31040836, 'iphone', '2017-05-27 12:51:50', '2017-05-27 12:51:50', NULL),
(2, 31040836, 'piano', '2017-05-27 13:00:28', '2017-05-27 13:00:28', NULL),
(3, 1, 'sepatu', '2017-05-28 01:39:21', '2017-05-28 01:39:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `onesignal_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `token`, `phone`, `gender`, `onesignal_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(31040836, 'fandy8811', 'Fandy Limardi', 'fandy_limardi@yahoo.com', '23pfzt8jT0u8tfuhw85', '0818910171', 'Laki-laki', '37c0f82c-2b2d-42f7-a3da-a87e5c607f4e', '2017-05-21 09:58:13', '2017-05-21 09:58:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyrequests`
--
ALTER TABLE `buyrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productviews`
--
ALTER TABLE `productviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userbuyrequests`
--
ALTER TABLE `userbuyrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyrequests`
--
ALTER TABLE `buyrequests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `productviews`
--
ALTER TABLE `productviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `userbuyrequests`
--
ALTER TABLE `userbuyrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
