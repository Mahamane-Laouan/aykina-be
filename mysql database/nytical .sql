-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 09:57 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nytical`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(1, 'primocys@gmail.com', '$2y$10$p33Mz91SmaupCS32QBaxJOL0uMfiaZCv.MV43crq64Jqz1C5Gb/PO', 'Primocys', 'Company', 'primocys@gmail.com', '9998887770', 'nylitical.png', NULL, '2024-02-06 04:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `available_payment_mode`
--

CREATE TABLE `available_payment_mode` (
  `id` int(11) NOT NULL,
  `publish_key` text DEFAULT '',
  `secret_key` text DEFAULT '',
  `payment_mode` text DEFAULT '\'\'',
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `available_payment_mode`
--

INSERT INTO `available_payment_mode` (`id`, `publish_key`, `secret_key`, `payment_mode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pawan', '#weerrrerereree', 'stripe', 1, '2024-02-05 23:41:39', '2024-02-07 00:37:59'),
(2, 'HAR DEWS', 'ededdss', 'razor', 0, '2024-02-05 23:48:46', '2024-02-06 00:38:28'),
(3, 'helo DONE', 'red', 'flutterwave', 1, '2024-02-06 00:19:55', '2024-02-07 00:38:24'),
(4, 'hello', 'samsung', 'paypal', 0, '2024-02-06 00:30:52', '2024-02-06 00:31:14'),
(5, 'pawan', '#weerrrerereree', 'cheque', 1, '2024-02-05 23:41:39', '2024-02-07 00:38:11'),
(6, 'pawan', '#weerrrerereree', 'cod', 1, '2024-02-05 23:41:39', '2024-02-06 00:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `banners_name` text NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banners_name`, `image`, `created_at`, `updated_at`) VALUES
(8, 'parle G', '60193cbe7411e.jpg', NULL, NULL),
(9, 'Narol', '60193cbe7411e.jpg', NULL, NULL),
(12, 'kargil', '1706792561.jpg', '2024-02-01 07:01:14', '2024-02-01 07:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `book_table`
--

CREATE TABLE `book_table` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_table`
--

INSERT INTO `book_table` (`id`, `res_id`, `user_id`, `username`, `date`, `time`, `description`, `email`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 75, 32, 'BQC', '23-08-20 01-02-54', '', 'Available', '', 0, NULL, NULL),
(2, 75, 2, 'BQC', '23-08-20 01-02-54', '', 'Available', '', 0, NULL, NULL),
(3, 75, 3, 'AAABC', '23-08-20 01-02-54', '', 'Available', '', 0, NULL, NULL),
(4, 75, 2, 'Aarush', '07-02-24 03-02-45', '', 'Busy', '', 0, NULL, NULL),
(5, 74, 21, 'Ankit', '07-02-24 03-02-45', '', 'Busy', '', 0, NULL, NULL),
(7, 78, 212, 'Ankit', '07-02-24 03-02-45', '', 'Busy', '', 0, NULL, NULL),
(8, 78, 212, 'Ankit', '07-02-24 03-02-45', '', 'Busy', '', 0, NULL, NULL),
(9, 79, 212, 'Ankit', '07-02-24 03-02-45', '', 'Busy', '', 0, NULL, NULL),
(10, 74, 28, 'Ankit', '07-02-24 03-02-45', '', 'Busy', 'shahrudro@gmail.com', 0, NULL, NULL),
(11, 78, 29, 'Ankit', '07-02-24 03-02-45', '', 'Busy', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(12, 78, 30, 'Ankit', '07-02-24 03-02-45', '', 'Busy', 'michaeljopling20@gmail.com', 0, NULL, NULL),
(13, 79, 30, 'Ankit', '07-02-24 03-02-45', '', 'iuy', 'michaeljopling20@gmail.com', 0, NULL, NULL),
(14, 81, 30, 'Ankit', '07-02-24 03-02-45', '', 'iuy', 'michaeljopling20@gmail.com', 0, NULL, NULL),
(15, 81, 31, 'Ankit', '07-02-24 03-02-45', '', 'iuy', 'defuj@bigtek.co.id', 0, NULL, NULL),
(17, 81, 31, 'Ankit', '07-02-24 03-02-45', '', 'iuy', 'defuj@bigtek.co.id', 0, NULL, NULL),
(19, 79, 29, 'Ankit', '07-02-24 03-02-45', '', 'jhb', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(20, 79, 29, 'Ankit', '02-24-2007', '08:30', 'jhb', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(21, 79, 29, 'Ankit', '01-01-1970', '08:30', 'jhb', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(25, 37, 35, 'Ankit', '03-02-2009', '08:45', 'jhb', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(26, 35, 34, 'rishi', '03-02-2010', '10:02', 'jhb', 'satbirsahni2000@yahoo.com', 0, NULL, NULL),
(31, 34, 33, 'karan', '03-02-2011', '10:02', 'jhbrtth', 'satbirsahni2000@yahoo.com', 1, NULL, NULL),
(32, 33, 32, 'karan', '10-01-2024', '12:34', 'jhbrtth', 'satbirsahni2000@yahoo.com', 4, NULL, NULL),
(44, 3, 33, 'rishi', '03-02-2015', '10:03', 'jhb', '760764687@qq.com', 3, NULL, NULL),
(45, 4, 33, 'rishi', '03-02-2015', '1:00 - 2:00', 'jhb', '760764687@qq.com', 2, NULL, NULL),
(46, 35, 34, 'rishi', '03-02-2015', '1:00 - 2:00', 'jhb', 'pandian.subram@gmail.com', 1, NULL, NULL),
(47, 6, 35, 'rishi', '03-02-2015', '1:00 - 2:00', 'jhb', 'aarango1018@gmail.com', 0, NULL, NULL),
(48, 6, 35, 'rishi', '05-02-2015', '1:00 - 2:00', 'jhb', 'aarango1018@gmail.com', 0, NULL, NULL),
(49, 6, 35, 'rishi', '05-02-2015', '4:00 - 5:00', 'jhb', 'aarango1018@gmail.com', 0, NULL, NULL),
(51, 5, 33, 'kk', '19-02-2024', '4:00 - 5:00', 'abcd', '760764687@qq.com', 0, NULL, NULL),
(53, 21, 35, 'rishi', '05-02-2015', '4:00 - 5:00', 'jhb', 'aarango1018@gmail.com', 0, NULL, NULL),
(54, 44, 33, 'kk', '19-02-2024', '17:00 - 18:00', 'abcd', '760764687@qq.com', 0, NULL, NULL),
(55, 43, 33, 'kk', '19-02-2024', '17:00 - 18:00', 'abcd', '760764687@qq.com', 0, NULL, NULL),
(56, 36, 33, 'kk', '19-02-2024', '17:00 - 18:00', 'abcd', '760764687@qq.com', 0, NULL, NULL),
(57, 34, 277, 'rishi', '05-02-2015', '4:00 - 5:00', 'jhb', 'kk@gmail.com', 0, NULL, NULL),
(58, 44, 277, 'kk', '26-01-2024', '2:00 - 3:00', 'abcd', 'kk@gmail.com', 0, NULL, NULL),
(61, 36, 32, 'arman', '05-02-2015', '4:00 - 5:00', 'jhb', 'dionfs2@gmail.com', 0, NULL, NULL),
(62, 44, 277, 'kk', '22-03-2024', '8:00 - 9:00', 'abcd', 'kk@gmail.com', 0, NULL, NULL),
(64, 44, 277, 'kk', '24-01-2024', '2:00 - 3:00', 'abcd', 'kk@gmail.com', 0, NULL, NULL),
(65, 36, 277, 'kk', '19-02-2024', '18:00 - 19:00', 'abcd', 'kk@gmail.com', 0, NULL, NULL),
(66, 44, 277, 'kk', '25-01-2024', '3:00 - 4:00', 'abcd', 'kk@gmail.com', 0, NULL, NULL),
(67, 44, 277, 'kk', '31-01-2024', '5:00 - 6:00', 'abcd', 'kk@gmail.com', 2, NULL, NULL),
(69, 44, 277, 'kk', '23-01-2024', '11:00 - 12:00', 'abcd', 'kk@gmail.com', 6, NULL, NULL),
(70, 40, 277, 'kk', '23-01-2024', '8:00 - 9:00', 'abcd', 'kk@gmail.com', 6, NULL, NULL),
(71, 37, 277, 'kk', '23-01-2024', '6:00 - 7:00', 'abcd', 'kk@gmail.com', 5, NULL, NULL),
(72, 35, 277, 'kk', '31-01-2024', '5:00 - 6:00', 'abcd', 'kk@gmail.com', 4, NULL, NULL),
(73, 34, 277, 'kk', '31-01-2024', '5:00 - 6:00', 'abcd', 'kk@gmail.com', 3, NULL, NULL),
(74, 37, 277, 'kk', '30-01-2024', '11:00 - 12:00', 'abcd', 'kk@gmail.com', 2, NULL, NULL),
(75, 36, 277, 'kk', '24-01-2024', '3:00 - 4:00', 'abcd', 'kk@gmail.com', 1, NULL, NULL),
(79, 36, 34, 'kk', '19-12-2024', '18:00 - 19:00', 'abcd', 'pandian.subram@gmail.com', 2, NULL, NULL),
(81, 34, 277, 'kk', '31-01-2024', '11:00 - 12:00', 'abcd', 'kk@gmail.com', 1, NULL, NULL),
(82, 34, 277, 'kk', '28-01-2024', '10:00 - 11:00', 'abcd', 'kk@gmail.com', 1, NULL, NULL),
(83, 43, 277, 'kk', '30-01-2024', '3:00 - 4:00', 'abcd', 'kk@gmail.com', 6, NULL, NULL),
(84, 42, 277, 'kk', '23-01-2024', '8:00 - 9:00', 'abcd', 'kk@gmail.com', 5, NULL, NULL),
(85, 36, 277, 'kk', '31-01-2024', '24:00 - 25:00', 'abcd', 'kk@gmail.com', 4, NULL, NULL),
(86, 40, 277, 'kk', '23-01-2024', '17:00 - 18:00', 'abcd', 'kk@gmail.com', 3, NULL, NULL),
(87, 40, 277, 'kk', '29-01-2024', '17:00 - 18:00', 'abcd', 'kk@gmail.com', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_name_a` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `img` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `c_name`, `c_name_a`, `icon`, `img`, `type`, `created_at`, `updated_at`) VALUES
(4, 'Restaurants', 'مطعم', '5f478a3dc36d9.png', '60193bee890f6.jpg', 'non_vip', NULL, NULL),
(5, 'Plumbing', 'سباك', '5f478ab680768.png', '60193c845d1e4.jpg', 'vip', NULL, NULL),
(7, 'Electrical', 'حلويات', '5f478b33d79b9.png', '60193c845fdd2.png', 'vip', NULL, NULL),
(8, 'Remodeling', 'أثاث', '5f478c6cd6aee.png', '60193c8462b69.jpeg', 'vip', NULL, NULL),
(9, 'Heating & A/C', 'المبرمجون', '5f4789d0af916.png', '60193b6338d6b.jpg', 'vip', NULL, NULL),
(10, 'Housecleaning', 'Housecleaning', '65a917d76c0ec.png', '60193bee8a9b3.jpg', 'vip', NULL, NULL),
(15, 'Camopfire Available', '', '65a9186dddf5c.jpeg', '60193cbe7411e.jpg', '', NULL, NULL),
(16, 'werter', '', '60193bee8a9b3.jpg', '60193cbe7411e.jpg', '', NULL, NULL),
(18, 'AwS', '', '65b8e694e8f90.png', '65b8e694e4aec.png', '', NULL, NULL),
(20, 'Hello Moto', '', '', '1706787802.jpg', '', '2024-02-01 04:39:33', '2024-02-01 06:13:22'),
(22, 'Switfeee', '', '', '1706785858.jpg', '', '2024-02-01 05:40:58', '2024-02-01 05:40:58'),
(24, 'werter js', '', '', '1707113888.jpg', '', '2024-02-05 00:48:08', '2024-02-05 00:48:08'),
(25, 'werter', '', '', '1707113900.jpg', '', '2024-02-05 00:48:20', '2024-02-05 00:48:20'),
(26, 'pawan', '', '', '1707115740.jpg', '', '2024-02-05 01:19:00', '2024-02-05 01:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `res_id`, `user_id`, `date`, `created_at`, `updated_at`) VALUES
(497, 21, 32, '1695726070', NULL, NULL),
(496, 36, 32, '1695725898', NULL, NULL),
(495, 33, 33, '1695647193', NULL, NULL),
(494, 33, 33, '1695646200', NULL, NULL),
(493, 33, 37, '1695643703', NULL, NULL),
(492, 8, 37, '1695643682', NULL, NULL),
(491, 8, 36, '1695643675', NULL, NULL),
(490, 2, 36, '1695643656', NULL, NULL),
(489, 3, 36, '1695641540', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` text NOT NULL,
  `payment_mode` int(11) DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `amount` text NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `res_id`, `user_id`, `transaction_id`, `payment_mode`, `payment_status`, `amount`, `date`, `time`, `created_at`, `updated_at`) VALUES
(2, 1, 33, 'Abc', 1, 0, '500', '19-01-2024', '09:44:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `res_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `res_name` text NOT NULL,
  `res_desc` text NOT NULL,
  `res_website` text NOT NULL,
  `res_image` text NOT NULL,
  `logo` text DEFAULT '',
  `res_phone` text NOT NULL,
  `res_address` text NOT NULL,
  `res_isOpen` text NOT NULL,
  `res_status` text NOT NULL,
  `res_create_date` text NOT NULL,
  `res_ratings` text DEFAULT '',
  `status` text NOT NULL,
  `res_video` text DEFAULT '',
  `res_url` varchar(255) NOT NULL DEFAULT '',
  `mfo` text NOT NULL,
  `monday_from` text NOT NULL DEFAULT '',
  `monday_to` text NOT NULL DEFAULT '',
  `tuesday_from` text DEFAULT '',
  `tuesday_to` text NOT NULL DEFAULT '',
  `wednesday_from` text NOT NULL DEFAULT '',
  `wednesday_to` text NOT NULL DEFAULT '',
  `thursday_from` text NOT NULL DEFAULT '',
  `thursday_to` text NOT NULL DEFAULT '',
  `friday_from` text DEFAULT '',
  `friday_to` text NOT NULL DEFAULT '',
  `saturday_from` text NOT NULL DEFAULT '',
  `saturday_to` text NOT NULL DEFAULT '',
  `sunday_from` text NOT NULL DEFAULT '',
  `sunday_to` text NOT NULL DEFAULT '',
  `ofm` varchar(255) NOT NULL DEFAULT '',
  `lat` text NOT NULL,
  `lon` text NOT NULL,
  `vid` int(10) NOT NULL,
  `approved` int(11) DEFAULT NULL,
  `open_time` text NOT NULL,
  `close_time` text NOT NULL,
  `slot_book` text NOT NULL,
  `promo_offer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`res_id`, `cat_id`, `res_name`, `res_desc`, `res_website`, `res_image`, `logo`, `res_phone`, `res_address`, `res_isOpen`, `res_status`, `res_create_date`, `res_ratings`, `status`, `res_video`, `res_url`, `mfo`, `monday_from`, `monday_to`, `tuesday_from`, `tuesday_to`, `wednesday_from`, `wednesday_to`, `thursday_from`, `thursday_to`, `friday_from`, `friday_to`, `saturday_from`, `saturday_to`, `sunday_from`, `sunday_to`, `ofm`, `lat`, `lon`, `vid`, `approved`, `open_time`, `close_time`, `slot_book`, `promo_offer`, `created_at`, `updated_at`) VALUES
(21, 21, 'Food Store', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'www.test.com', '618594336e6c1.jpg', '5f41095abba50.jpg', '0612220022', 'Amsterdam', 'open', 'active', '1588749717', '2.5', '2', '5f5f2a4fe5260.mp4', '6512d16e9a885.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '52.3675734', '4.9041389', 5, 1, '10:00', '19:00', '', '', NULL, NULL),
(36, 4, 'SweetGreen ', 'Stock Your Entire Food Service Establishment Without Sacrificing Quality For Price! Weekly Email Discounts. Largest Selection Online. Food Service Guides.', 'www.primocys.com', '60193c8462b69.jpeg', '5f4f44cfdfd6c.jpg', '9824614016', '+1961+High+House+Rd,+Cary,+NC+27519-8452', 'open', 'active', '1599030479', '3.9', '', '', '6512d1299b8cb.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '11:00 AM', '10:00 PM', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '35.7889599', '-78.8487339', 10, 1, '10:00', '19:00', '', '', NULL, NULL),
(33, 5, 'Flexteriors - Offering Plumbing Work', 'Plumbers work in both commercial and residential settings to repair, install, and maintain plumbing fixtures and systems for drainage, heating, drinking, venting, and sewage. A large part of the job involves the ability to work with building blueprints to assess layouts of plumbing systems and the water supply. \"Wet-only plumbers\" handle piping systems in bathrooms and radiators. \"Gas-only plumbers\" focus on industrial work.', 'www.primocys.com', '60193c8463e69.jpg', '5f4f3f42bbe9c.png', '9824614016', 'New+York', 'open', 'active', '1599029058', '4.5', '2', '', '6512d1614f461.mp4', 'Mon,Tue,Wed,Thu,Fri', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '40.7127753', '-74.0059728', 9, 1, '10:00', '19:00', '', '', NULL, NULL),
(34, 5, 'Hamza Store', 'Plumbers work in both commercial and residential settings to repair, install, and maintain plumbing fixtures and systems for drainage, heating, drinking, venting, and sewage. A large part of the job involves the ability to work with building blueprints to assess layouts of plumbing systems and the water supply. \"Wet-only plumbers\" handle piping systems in bathrooms and radiators. \"Gas-only plumbers\" focus on industrial work.', 'www.primocys.com', '60193d2913984.jpg', '5f4f41794bf10.png', '9824614016', 'Science,city,Ahmedabad', 'open', 'active', '1599029625', '3.8', '2', '', '6512a6f9ae570.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '23.0714235', '72.5167854', 11, 1, '10:00', '19:00', '', '', NULL, NULL),
(35, 5, 'Red Dog plumbing', 'Plumbers work in both commercial and residential settings to repair, install, and maintain plumbing fixtures and systems for drainage, heating, drinking, venting, and sewage. A large part of the job involves the ability to work with building blueprints to assess layouts of plumbing systems and the water supply. \"Wet-only plumbers\" handle piping systems in bathrooms and radiators. \"Gas-only plumbers\" focus on industrial work.', 'www.primocys.com', '60193d2915427.jpg', '5f4f4282cfb63.png', '9824614016', '71+Ramblewood+Lane+Bronx,+NY+10467', 'open', 'active', '1599029890', '3.5', '2', '', '6512d159ed04c.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '40.8466186', '-73.9173704', 13, 1, '10:00', '19:00', '', '', NULL, NULL),
(37, 4, 'Applebee\'s Neighborhood Grill + Bar ', 'Stock Your Entire Food Service Establishment Without Sacrificing Quality For Price! Weekly Email Discounts. Largest Selection Online. Food Service Guides.', 'https://www.primocys.com/', '6019392b40ce4.jpg', '5f4f46165705a.jpg', '9824614016', '2160+Haines+Ave.+Rapid+City,+SD+57701', 'open', 'active', '1599030806', '3.3', '', '', '6512d1224657d.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '44.1061646', '-103.2210392', 10, 1, '10:00', '19:00', '', '', NULL, NULL),
(38, 4, 'Canalside Restaurant, Inn & Kitchen Store', 'Canalside Studio Suites overlooking the canal. Seven full service suites. Room includes all amenities of home including kitchen facilities. Daily and weekly rates.', 'www.primocys.com', '6019392b45c9f.jpg', '5f4f474a33e77.jpg', '982461401', '232+West+St,+Port+Colborne,+Ontario+L3K+4E3+Canada', 'open', 'active', '1599031114', '5', '2', '', '6512d11c0c801.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '42.8858748', '-79.2503349', 9, 1, '10:00', '19:00', '', '', NULL, NULL),
(39, 7, 'The Saturn Electrical Goods store', 'An electrical store is a shop focused on selling different electrical supplies (cable, cable channels, electric sockets etc) and electrical devices (electric meters, junction boxes, fuse boxes etc). ... Apart from shop = electronics such shops do not sell consumer electronics.', 'www.primocys.com', '6019392b45c9f.jpg', '5f4f483ae60c8.png', '9824614016', 'Pawia+5,+Krakow+31-154,+Poland', 'open', 'active', '1599031354', '1.2', '2', '', '6512d0dfe107d.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '50.067477', '19.9460244', 5, 1, '10:00', '19:00', '', '', NULL, NULL),
(40, 7, 'media markt ', 'Whether it\'s a tablet or smartphone, coffee machine or large screen TV: customers will always find brand new, innovative brand name products from the world of technology at Media Markt. Media Markt claims that it is always the first to have the latest developments and trends in its product range. Every Media Markt is therefore practically a permanent innovation fair.', 'www.mediamarkt.de', '6019392b42856.jpeg', '5f4f498253fbf.png', '09879595948', '용인시', 'open', 'active', '1599031682', '5', '2', '', '6512d0e57bd06.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '37.2214872', '127.2218612', 11, 1, '10:00', '19:00', '', '', NULL, NULL),
(41, 8, 'Cleveland Home Remodeling & Improvement | Hurst Remodel', 'When Pat and Dan Hurst founded Hurst Design-Build Remodeling in 1997, they set out with a simple goal: to be the best home remodeler in the Cleveland area.\r\n\r\nTo achieve their goal, the brothers knew that quality, creativity and client care were the keys to success. “Is there a better way to do this?” became their guiding principle. Even today, they are constantly seeking ways to improve Hurst’s level of quality from top to bottom.\r\n\r\nWhen adding members to their team, the Hursts followed the same principle, ensuring that every new member had the same drive. Together, the entire Hurst team has developed a set of core values that maintain Dan and Pat’s pursuit of excellence.', 'www.primocys.com', '6019392b44696.jpg', '5f4f4a6b26061.png', '982461401', '1+Deerfield+Ave.+Brooklyn,+NY+11210', 'open', 'active', '1599031915', '3.4', '2', '', '6512cff3e33b7.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '40.6285158', '-73.9447994', 13, 1, '10:00', '19:00', '', '', NULL, NULL),
(42, 8, 'Kitchen Remodeling Store', 'When Pat and Dan Hurst founded Hurst Design-Build Remodeling in 1997, they set out with a simple goal: to be the best home remodeler in the Cleveland area.\r\n\r\nTo achieve their goal, the brothers knew that quality, creativity and client care were the keys to success. “Is there a better way to do this?” became their guiding principle. Even today, they are constantly seeking ways to improve Hurst’s level of quality from top to bottom.\r\n\r\nWhen adding members to their team, the Hursts followed the same principle, ensuring that every new member had the same drive. Together, the entire Hurst team has developed a set of core values that maintain Dan and Pat’s pursuit of excellence.', 'www.primocys.com', '6110159cf234e.jpg', '5f4f4add3a6c0.png', '56165156516', '7455+Cactus+St.+Brooklyn,+NY+11237', 'open', 'active', '1599032029', '4.8', '2', '', '6512d096ae483.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '40.7043156', '-73.9212858', 10, 1, '10:00', '19:00', '', '', NULL, NULL),
(43, 8, 'Whole House Renovations', 'Do you love the location of your Northern Virginia home, but dream of an updated kitchen, a master bathroom, and a rock fireplace? When you find the perfect neighborhood, school district, yard, or all of the above, you don’t want to move. Thankfully, there’s a solution—whole-house renovation!\r\n\r\nWhen it comes to home remodeling, you should never have to settle for less than the best. At Ideal Construction & Remodeling, we can help you achieve the home of your dreams with our whole-house renovation process. We can help you design a home that is functional and aesthetically pleasing by renovating the rooms in your home that need it most!', 'www.primocys.com', '60193892a74ef.jpg', '5f4f4b7817194.png', '65165156', '8200+Greensboro+Drive+Suite+900+McLean,+VA+22102', 'open', 'active', '1599032184', '3', '2', '', '6512cfc156744.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '38.9223105', '-77.2272484', 9, 1, '10:00', '19:00', '', '', NULL, NULL),
(44, 8, 'Whole House Remodeling Making Old Houses into New Homes', 'When our contractor retired last year, we were nervous and apprehensive about starting our next large renovation, a Kitchen and 3 Bathrooms. John and his team were just great to work with. The quality of his work and his communication with us during this process (of remodeling) was just fantastic. Certainly way beyond our expectations', 'www.primocys.com', '60193892a668f.jpg', '5f4f4c145b3e8.png', '4779003', '25+Oyster+Way+Mashpee,+MA+02649', 'open', 'active', '1599032340', '4.1', '2', '', '6512cf44ba8d9.mp4', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10:00-7:00', '41.6062837', '-70.4770575', 5, 1, '10:00', '19:00', '', '', NULL, NULL),
(131, 4, 'Kitchen Remodeling Store', 'ARman', 'arman@fer.com', '60193892a963f.jpg', '', '9856320147', 'Akshardham+temple,+North+Main+Street,+Robbinsville+Township,+NJ,+USA', 'open', 'active', '1705993428', '', '', '', '', 'Mon,Tue,Wed,Thu,Fri,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.2536885', '-74.5796987', 10, 0, '01:00 PM', '10:00 AM', '3 Hours', 'Arman78', NULL, NULL),
(132, 7, 'Canalside Restaurant, Inn & Kitchen Store', 'Heyuuuuu', 'Heeko@gni.com', '65b8960e02c5c.jpg::::65b8960e11bc3.jpg::::65b8960e14ccc.jpg', '', '98563210475', 'Hello!+Bangladesh+Restaurant+(Halal),+36th+Avenue,+Queens,+NY,+USA\r\n', 'open', 'active', '1706595854', '', '2', '', '', 'Mon,Tue,Wed,Thu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.7569943', '-73.9302644', 9, 0, '01:00 PM', '12:00 AM', '3 Hours', 'HSDE324', NULL, NULL),
(133, 5, 'SweetGreen ', 'rfrfcc', '8gtrg', '65b8c6154e4c0.jpg', '', '6886863', 'RFR+Picture+Framing,+Main+Street,+West+Newbury,+MA,+USA', 'open', 'active', '2024-01-30 09:49:09', '', '2', '', '', 'Tue,Thu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '42.7959662', '-70.9961209', 5, NULL, '2:00 AM', '6:00 AM', '1 Hours', 'trgfrf', '2024-01-30 04:19:09', '2024-01-30 04:19:09'),
(134, 5, '', 'rfrfcc', '8gtrg', '65b8c62f56ada.jpg', '', '6886863', 'RFR+Picture+Framing,+Main+Street,+West+Newbury,+MA,+USA', 'open', 'active', '2024-01-30 09:49:35', '', '2', '', '', 'Tue,Thu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '42.7959662', '-70.9961209', 5, NULL, '2:00 AM', '6:00 AM', '1 Hours', 'trgfrf', '2024-01-30 04:19:35', '2024-01-30 04:19:35'),
(135, 5, '', 'rfrfcc', '8gtrg', '65b8c642df5c6.jpg', '', '6886863', 'RFR+Picture+Framing,+Main+Street,+West+Newbury,+MA,+USA', 'open', 'active', '2024-01-30 09:49:54', '', '2', '', '', 'Tue,Thu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '42.7959662', '-70.9961209', 5, NULL, '2:00 AM', '6:00 AM', '1 Hours', 'trgfrf', '2024-01-30 04:19:54', '2024-01-30 04:19:54'),
(136, 8, '', 'deeded', 'dewdewd@svg.com', '65b8c7d77f432.jpg::::65b8c7d77f6ef.jpg::::65b8c7d77f881.jpg', '', '1511516516515', 'Eddie+V\'s+Prime+Seafood,+Garden+State+Plaza+Boulevard,+Paramus,+NJ,+USA', 'open', 'active', '2024-01-30 09:56:39', '', '2', '', '', 'Tue,Thu,Fri', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.9160704', '-74.0750778', 5, NULL, '4:00 AM', '7:00 AM', '5 Hours', 'WES5434125', '2024-01-30 04:26:39', '2024-01-30 04:26:39'),
(137, 7, '', 'rfrf', 'dewdewd@svg.com', '65b8c93b79e0a.png', '', '989769696', 'Edison,+NJ,+USA', 'open', 'active', '2024-01-30 10:02:35', '', '2', '', '', 'Thu,Fri', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.5187154', '-74.4120953', 5, NULL, '5:00 AM', '5:00 AM', '5 Hours', 'WES54845', '2024-01-30 04:32:35', '2024-01-30 04:32:35'),
(138, 9, '', 'erf', '', '65b8cad848a02.jpg', '', '868898969689', 'Yhum+Yhum+Kitchen,+East+Jericho+Turnpike,+Huntington,+NY,+USA', 'open', 'active', '2024-01-30 10:09:28', '', '', '', '', 'Wed', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.832993', '-73.3639686', 11, NULL, '4:00 AM', '4:00 AM', '5 Hours', '', '2024-01-30 04:39:28', '2024-01-30 04:39:28'),
(139, 5, '', 'ded', 'dewdewd@svg.com', '65b8cd7954ee2.png', '', '8767676', 'GTG+Gems,+Broadway,+Jackson+Heights,+NY,+USA', 'open', 'active', '2024-01-30 10:20:41', '', '2', '', '', 'Tue', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.7470199', '-73.8927794', 5, NULL, '5:00 AM', '4:00 AM', '5 Hours', 'WES5434125', '2024-01-30 04:50:41', '2024-01-30 04:50:41'),
(140, 8, '', 'gttg', 'dewdewd', '65b8cda6b81a9.png::::65b8cda6b83ce.png::::65b8cda6b8595.png', '', '8587577', 'Rye+Free+Reading+Room,+Boston+Post+Road,+Rye,+NY,+USA', 'open', 'active', '2024-01-30 10:21:26', '', '0', '', '', 'Fri', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.9814503', '-73.6848989', 5, NULL, '4:00 AM', '4:00 AM', '2 Hours', 'WES54845', '2024-01-30 04:51:26', '2024-01-30 04:51:26'),
(141, 15, '', 'Available busy', 'ar@gmail.com', '65b8d47661037.png', '', '9313852343', 'Bhavnagar+Bus+Station,+Panwadi,+Bhavnagar,+Gujarat,+India', 'open', 'active', '2024-01-30 10:50:30', '', '2', '', '', 'Mon,Tue,Wed,Sun', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '21.7701736', '72.1367867', 9, NULL, '12:00 AM', '9:00 AM', 'Full Day Hours', 'AU&6', '2024-01-30 05:20:30', '2024-01-30 05:20:30'),
(142, 7, '', '<p>yyyyyyyyyyyyyyyyyy</p>', 'ar@gmail.com', '65b8e1aa94781.png', '', '8545454585', 'Okinawa+Karate+Kobudo+Kai,+Dutch+Broadway,+Elmont,+NY,+USA', 'open', 'active', '2024-01-30 11:46:50', '', '2', '', '', 'Wed', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '40.6873338', '-73.7029877', 10, NULL, '2:00 AM', '1:00 AM', '3 Hours', '552SD', '2024-01-30 06:16:50', '2024-01-30 06:16:50'),
(143, 5, '', '<p>A so<strong>ftware development company</strong></p>', 'prim@gmail.com', '65b8e3edb66d4.png', '', '9852147012', 'Primocys,+Science+City+Road,+Sola,+Ahmedabad,+Gujarat,+India', 'open', 'active', '2024-01-30 11:56:29', '', '2', '', '', 'Wed,Thu,Sun', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '23.0766465', '72.5177906', 10, NULL, '4:00 AM', '9:00 PM', '8 Hours', 'PRIM21', '2024-01-30 06:26:29', '2024-01-30 06:26:29'),
(145, 7, '', 'Hetqewe', '3435@gmail.com', '65b8e633a045c.png::::65b8e633a0685.png::::65b8e633a0838.png', '', '985425555', 'Primocys,+Science+City+Road,+Sola,+Ahmedabad,+Gujarat,+India', 'open', 'active', '2024-01-30 12:06:11', '', '2', '', '', 'Wed', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '23.0766465', '72.5177906', 9, NULL, '2:00 AM', '2:00 AM', '3 Hours', 'Kaps24', '2024-01-30 06:36:11', '2024-01-30 06:36:11'),
(146, 4, '', 'Stored junction At Karachi in venom', 'pawan@gmail.com', '65ba2050ed039.jpg::::65ba2050ed241.jpg::::65ba2050ed6e3.jpg', '', '9313852343', 'Primocys, Science City Road, Sola, Ahmedabad, Gujarat, India', 'open', 'active', '2024-01-31 06:53:18', '', '0', '', '', 'Mon,Tue,Wed,Sat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '23.0766465', '72.5177906', 9, NULL, '6:00 AM', '10:00 PM', '4 Hours', 'PAw54', '2024-01-31 01:23:18', '2024-02-01 23:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rev_id` int(11) NOT NULL,
  `rev_user` int(11) NOT NULL,
  `rev_res` int(11) NOT NULL,
  `rev_stars` float NOT NULL,
  `rev_text` mediumtext NOT NULL,
  `rev_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rev_id`, `rev_user`, `rev_res`, `rev_stars`, `rev_text`, `rev_date`, `created_at`, `updated_at`) VALUES
(241, 37, 21, 2.5, 'Hey its a lovely food', '2024-02-02 05:36:46', NULL, NULL),
(240, 50, 36, 1, 'sweet and caring', '2024-02-02 07:26:08', NULL, NULL),
(250, 41, 21, 1, 'delicious', '2024-02-02 07:26:17', NULL, NULL),
(238, 45, 21, 2.2, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:07:49', NULL, NULL),
(237, 45, 36, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:07:53', NULL, NULL),
(236, 44, 21, 2.5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:07:57', NULL, NULL),
(235, 43, 36, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:08:01', NULL, NULL),
(234, 42, 21, 4.5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:08:04', NULL, NULL),
(233, 41, 36, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-01-20 13:08:10', NULL, NULL),
(226, 35, 33, 4.5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:45:27', NULL, NULL),
(227, 36, 34, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:45:35', NULL, NULL),
(228, 36, 35, 3.5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:45:44', NULL, NULL),
(229, 37, 37, 1.6, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:45:54', NULL, NULL),
(230, 38, 38, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:45:58', NULL, NULL),
(231, 39, 39, 1.5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:00', NULL, NULL),
(232, 40, 40, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:15', NULL, NULL),
(225, 34, 41, 1.8, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:18', NULL, NULL),
(224, 34, 42, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:21', NULL, NULL),
(223, 33, 43, 4.9, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:29', NULL, NULL),
(222, 34, 44, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:32', NULL, NULL),
(242, 40, 37, 2.5, 'awesome', '2024-02-02 08:46:38', NULL, NULL),
(243, 33, 44, 3.5, 'awesome', '2024-02-02 07:26:37', NULL, NULL),
(244, 32, 44, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:42', NULL, NULL),
(246, 35, 41, 5, 'Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 08:46:49', NULL, NULL),
(253, 42, 34, 2.5, 'nice service', '2024-02-02 07:26:55', NULL, NULL),
(252, 42, 37, 2.5, 'nice', '2024-02-02 07:26:58', NULL, NULL),
(276, 57, 43, 2, 'as good as expected', '2024-01-23 07:17:22', NULL, NULL),
(255, 52, 36, 3.5, 'awesome service ', '2024-02-02 07:27:10', NULL, NULL),
(256, 36, 44, 4.5, 'Nice Place to Eat and really Enjoy that place..!! Nice Place to Eat and really Enjoy that place..!! Nice Place to Eat and really Enjoy that place..!! Nice Place to Eat and really Enjoy that place..!! Nice Place to Eat and really Enjoy that place..!!', '2024-02-02 09:18:47', NULL, NULL),
(257, 52, 44, 2.5, 'delicious and ammzing', '2024-02-02 08:49:05', NULL, NULL),
(263, 57, 40, 5, 'Nice service and easy to fix...!!!', '2024-02-02 08:46:56', NULL, NULL),
(264, 57, 39, 1, 'sweet food', '2024-02-02 05:37:36', NULL, NULL),
(265, 57, 39, 1, 'tasty ', '2024-02-02 05:37:41', NULL, NULL),
(269, 57, 43, 1, 'good as expected', '2024-02-02 05:37:49', NULL, NULL),
(271, 57, 37, 5, 'It\'s good, ambience is very cool ', '2023-09-20 12:16:45', NULL, NULL),
(272, 36, 42, 4.5, 'Very Good…!!!', '2024-02-02 07:27:22', NULL, NULL),
(273, 52, 43, 4, 'Awesome service provider.', '2024-02-02 07:27:25', NULL, NULL),
(274, 37, 37, 5, 'Good Food Quality…!!!', '2024-02-02 07:27:29', NULL, NULL),
(281, 37, 43, 4.5, 'all done', '2024-02-02 12:52:16', NULL, NULL),
(277, 37, 21, 2.5, 'Hey its a lovely food', '2024-02-02 05:36:46', NULL, NULL),
(279, 37, 21, 2.5, 'Grab Food quick', '2024-02-02 09:52:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` mediumtext NOT NULL,
  `profile_pic` mediumtext NOT NULL,
  `isGold` int(11) NOT NULL DEFAULT 0,
  `login_type` int(255) NOT NULL,
  `date` varchar(200) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`, `profile_pic`, `isGold`, `login_type`, `date`, `mobile`, `device_token`, `fullname`, `create_date`, `created_at`, `updated_at`) VALUES
(32, 'dionfs2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'nyam', '', 0, 0, '1600208339', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(33, '760764687@qq.com', 'f57ba9e0440cedd083db02aefc8d6b30', 'hedywstylz', '', 0, 0, '1600234750', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(34, 'pandian.subram@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'spanraj', '', 0, 0, '1600234917', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(35, 'aarango1018@gmail.com', 'cd831effe9c8ed8b516744b78be6032d', 'marangor', '', 0, 0, '1600242241', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(36, 'cht@cht.com', 'e10adc3949ba59abbe56e057f20f883e', 'chtdrn', '', 0, 0, '1600245850', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(37, 'tarradayoussef@gmail.com', 'fa58f01ba409e4db54aac529f2af79b6', 'yousseg', '', 0, 0, '1600251555', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(38, 'bribin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'bribin', '', 0, 0, '1600253994', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(40, 'gmoghekar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Govind', '', 0, 0, '1600261024', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(41, 'test@test.com', 'e10adc3949ba59abbe56e057f20f883e', '1234', '', 0, 0, '1600261728', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(42, 'aliveli@hotmail.com', '3415362c0ebd341a39786db583d7f1bd', 'Ali veli', '', 0, 0, '1600277600', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(43, 'mail@rfg.com', 'e10adc3949ba59abbe56e057f20f883e', 'mail', '', 0, 0, '1600292487', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(44, 'Yes@yes.com', 'e10adc3949ba59abbe56e057f20f883e', 'Yes', '', 0, 0, '1600292560', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(45, 'sai05@yahoo.com', 'f407fc38614206b09abc60ea4de763a5', 'sai', '', 0, 0, '1600328242', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(46, 'updateurtrend@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'update', '', 0, 0, '1600337346', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(47, 'gtek.tn@gmail.com', '5fe1fff9c82e9720628f450e34c7f9d8', 'greentek', '', 0, 0, '1600342268', '', '', '', '2023-08-20 09:28:00', NULL, NULL),
(48, 'dj897@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'dj897', '', 0, 0, '1600348926', '', '', '', '2023-07-20 09:28:00', NULL, NULL),
(49, 'd.alzahrani@gmail.com', '1a29a03365d394457f8234a6e77f45d4', 'daif', '', 0, 0, '1600367783', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(50, 'tester@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', 'testerdemo', '', 0, 0, '1600369198', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(51, 'sheu@me.com', 'e10adc3949ba59abbe56e057f20f883e', 'sheu', '', 0, 0, '1600374756', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(52, 'worktiti95@gmail.com', '320d21956bbcbb5b87c4ea44d02065e4', 'tsawadog', '', 0, 0, '1600400937', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(53, 'info@izleoyna.com', 'e10adc3949ba59abbe56e057f20f883e', 'ali', '', 0, 0, '1600419484', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(54, 'anil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'anil', '', 0, 0, '1600451055', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(55, 'daratep0404@gmail.com', 'bf532f19dc1576fdacb00ae21cf3cdcc', 'Dara', '', 0, 0, '1600454861', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(56, 'hhm@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'nitin', '', 0, 0, '1600468303', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(57, 'primocys@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Primocys', 'https://lh3.googleusercontent.com/a/ACg8ocLi8HOfgP3Q5fDj0Uynrbl-hezAd2V_pbAtn7q8wJ2iaD4=s96-c', 0, 0, '1695721107', NULL, 'd9U_8xCRS3qdjaBIoqpd4A:APA91bG4bNBgnH0MJT2k2NGq-gqu9pHFbMtXdAGRdojFrMpUr4CIYb1q_4Aa7ki5HZHu5-O7Q2pfx6isc0zZIm9XEUeI4cFS5mu2HJngS8taI2hozWZwE2J5kt2Y4diLoO4WUAIXZOxG', '', '2023-09-26 09:38:27', NULL, NULL),
(58, 'asd@asd.com', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'asd', '', 0, 0, '1600515012', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(59, 'nmahmud0928@gmail.com', '22d7fe8c185003c98f97e5d6ced420c7', 'mahmud', '', 0, 0, '1600519838', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(60, 'dijitalfirtina@gmail.com', '5c8198e579b5250f0065c4a43a6c19cb', 'hop', '', 0, 0, '1600554523', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(61, 'recebi@email.com', '587682f521365a88875bd356c25f9ef5', 'damiloaqui', '', 0, 0, '1600564085', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(62, 'amarnath123456789@yahoo.com', 'd09e711ba5fe0b9bcf6f397f627b6478', 'yahooamar', '', 0, 0, '1600571684', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(63, 'kumarrlohith@gmail.com', '578da0abf6733d8e1160a2debd3e91de', 'Lohithkumar', '', 0, 0, '1600621339', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(64, 'poomlg61@gmail.com', 'd5c6ae391654be95a8199919d63b34a2', 'Ahmed', '', 0, 0, '1600634585', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(65, 'ada@ada.com', '0df68fe44d69a5894dec0ecf45760165', 'ada', '', 0, 0, '1600652095', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(66, 'zee@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 'zeemuse', '', 0, 0, '1600670972', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(67, 'pk@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'pk@gmail.com', '', 0, 0, '1600691601', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(68, 'boburbakhodirov@gmail.com', 'ef268e7efd089739afc426dd21822ed6', 'Bobur', '', 0, 0, '1600704369', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(69, 'rishabhchoudhary700@gmail.com', '71e41a17623713bb12ee0b3c3b9cd96c', 'Rishi', '', 0, 0, '1600745057', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(70, 'peyman.zeroone@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'peyman', '', 0, 0, '1600776045', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(71, 'vikrant241993@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'demi', '', 0, 0, '1600784380', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(72, 'caafinetit@gmail.com', '59ecee2fa992f0562f9ea657c93a22a1', 'caafinet', '', 0, 0, '1600816090', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(73, 'ke@vik.cc', 'c718b077ea57fd77956ca234f566e944', 'kevinzwpeda', '', 0, 0, '1600819011', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(74, 'chandra22121@gamil.com', 'e807f1fcf82d132f9bb018ca6738a19f', 'chandra', '', 0, 0, '1600830153', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(76, 'abdokubo@gmail.com', 'e19d5cd5af0378da05f63f891c7467af', 'abd', '', 0, 0, '1600831522', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(77, 'prospertinarwo@gmail.com', '6a5be123feeca3a96347a5d131194ba9', 'prosper', '', 0, 0, '1600887853', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(78, 'test@email.com', 'e10adc3949ba59abbe56e057f20f883e', 'test', '', 0, 0, '1600932076', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(79, 'chauhanajay1812@gmail.com', 'a8ca2d2385e638ef3b2c237d0a62ae04', 'Ajay1812', '', 0, 0, '1600937891', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(80, 'tes@gmail.com', 'de09f21565d494e0883acfd1cc030a5a', 'tes', '', 0, 0, '1600939624', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(81, 'vrushigunjal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'vrushali', '', 0, 0, '1600948747', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(82, 'azar.developer@gmail.com', 'cc3798c61187e02a062b47c416ecaf72', 'manatech', '', 0, 0, '1600974205', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(83, 'jt.mchs@mail.ru', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'Eugene', '5f6d0efb44ab4.jpg', 0, 0, '1600982192', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(84, 'm@hotmail.com', 'f1d9be51880dd631aee0c1b54d406443', 'leo', '', 0, 0, '1601031711', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(85, 'mayurdhande012345@gmail.com', 'fedd5a126bd8f361b5a2e390e7f6ca8d', 'msdhande', '', 0, 0, '1601041340', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(86, 'satyajit9830@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'satyajit', '', 0, 0, '1601113810', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(87, 'chayad@gmail.com', 'c7d01b027d4369c845d6e41269807dc4', 'chandan', '', 0, 0, '1601113885', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(88, 'test124@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'test124', '', 0, 0, '1601260308', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(89, 'a@a.com', '827ccb0eea8a706c4c34a16891f84e7b', 'aaaa', '', 0, 0, '1601285961', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(90, 'golu88rathod@gmail.com', 'cfb80286f431e1cd72f94ae1fe50cca7', 'golurat', '', 0, 0, '1601294006', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(91, 'chavhansamar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Samar chavhan', '', 0, 0, '1601297038', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(92, 'officialfatehsinghh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'fateh', '', 0, 0, '1601308409', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(93, 'chenguballavinodkumar@gmail.com', 'abd718b6986c65c3271c9684700e4caf', 'techvinu', '', 0, 0, '1601326539', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(94, 'tsecheng@gmail.com', 'f150f3bec5617dc6f2e208e978593be8', 'Luke', '', 0, 0, '1601329219', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(95, 'madani.id@gmail.com', 'b93939873fd4923043b9dec975811f66', 'tes', '', 0, 0, '1601381377', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(96, 'mohammedomar@outlook.sa', '4281324ed4ed0fdf07bbb0cdabb70182', 'mohammed', '', 0, 0, '1601394650', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(97, 'demo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'demo', '', 0, 0, '1601445916', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(98, 'a@a.com', '4188bd9ad1e2c2f2d6a429c29ec28532', 'sadek', '', 0, 0, '1601447389', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(99, 'test@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'esy', '', 0, 0, '1601461015', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(100, 'taufiqwebsite@gmail.com', 'd66eccc1d22b11a48bc70e2d7f74ced5', 'anta2019', '', 0, 0, '1601462352', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(101, 'al_mughairi@hotmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', 'sam', '', 0, 0, '1601468753', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(102, 'moh.esmail@gmail.com', '17358c32a7441c6679a1a4b8aa5cda43', 'mohammad Esmail ', '', 0, 0, '1601474579', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(103, 'saiedislamshuvo308@gmail.com', '9ca9154ef4ef3cfa6790113c02e27ede', 'shuvo', '', 0, 0, '1601479417', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(104, 'maprasad2018@gmail.com', 'a434a3fc19597d3f6738bee07b5b751e', 'prasad', '', 0, 0, '1601650468', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(105, 'demo@user.com', '827ccb0eea8a706c4c34a16891f84e7b', 'demo@user.com', '', 0, 0, '1601656151', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(106, 'dj123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'deval123', '', 0, 0, '1601717700', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(107, 'mohamed.yahya@almaha-iq.com', '25d55ad283aa400af464c76d713c07ad', 'mohamed', '', 0, 0, '1601884245', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(108, 'saiedislam.shuvo1124@gmail.com', '9ca9154ef4ef3cfa6790113c02e27ede', 'shuvo', '', 0, 0, '1601894510', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(109, 'xicayi1405@zuperholo.com', 'dc05bd6d00828b311c20340d9c524305', 'testessa', '', 0, 0, '1601919178', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(110, 'nemzaa1312@gmail.com', '1309ffb2386be57fca27ee59c75d1fde', 'nemo123', '', 0, 0, '1601931002', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(111, 'htheanh@gmail.com', 'd1535f6d6223a1b91b7c5054c861a8b7', 'htheanh@gmail.com', '', 0, 0, '1601965630', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(112, 'trendingnaveen@gmail.com', 'd4395a5856617fa4afe8c5cd2eed3912', 'naveen', '', 0, 0, '1602044063', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(113, 'arpan.prio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'arpanprimo', '5f7d72b4e8d07.jpg', 0, 0, '1602056774', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(114, 'abeesh4uall@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'abcd', '', 0, 0, '1602132286', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(115, 'test@yopmail.com', 'd2a219abf4f9c86aa97c9cb9005dee7a', 'test', '', 0, 0, '1602133022', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(116, 'alfonsinmoi2@hotmail.com', '226039d954722f6b25f2bab26f6a30d9', 'alfonsinmoi2 ', '', 0, 0, '1602173119', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(117, 'ismailak@gmail.com', '64c1a11e5c628071c475a5d1eeec4337', 'ismailak', '', 0, 0, '1602176421', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(118, 'byaskar@gmail.com', 'f1282c55d3a6d4be69e7d015eb137f25', 'askar', '', 0, 0, '1602188362', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(119, 'rakesh@yopmail.com', 'dc06698f0e2e75751545455899adccc3', 'Rakesh', '', 0, 0, '1602237987', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(120, 'sreeyeshk08@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sreeyesh', '', 0, 0, '1602251312', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(121, 'gotest@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'tesy', '', 0, 0, '1602251905', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(122, 'admsgs@gmail.com', 'b078b4a5f97eefecec40bd02e49b8358', 'cok', '', 0, 0, '1602268578', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(123, 'topeng@gmail.com', 'b078b4a5f97eefecec40bd02e49b8358', 'asu', '', 0, 0, '1602268629', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(124, 'sk@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sk', '', 0, 0, '1602268754', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(125, 'eng.mohamedmega@gmail.com', 'cdf74e8a5687f51da319044af011e2aa', 'hot', '', 0, 0, '1602285908', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(126, 'norvintfranklin@gmail.com', '7376af05357e0e3839f20a6debf0a02c', 'norvin', '', 0, 0, '1602300893', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(127, 'abeesh4uall@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Abish', '', 0, 0, '1602303423', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(128, '@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'me', '', 0, 0, '1602319686', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(129, 'seoinetru@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Seoinet', '', 0, 0, '1602361733', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(130, 'randyigualguana@gmail.com', '951e25236c5feecf7e3b5ffb919c9107', 'randy', '', 0, 0, '1602387516', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(131, 'aaaa@gmail.com', '594f803b380a41396ed63dca39503542', 'aa', '', 0, 0, '1602407665', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(132, 'you@you.com', 'e10adc3949ba59abbe56e057f20f883e', 'you', '', 0, 0, '1602448231', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(133, '01ankush.singh@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'ankushsingh', '', 0, 0, '1602564347', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(134, 'guebeplasti@gmail.com', 'c629a1e014e2c0daa88dcf597d0ce319', 'hola', '5f853213c6061.jpg', 0, 0, '1602564567', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(135, 'sachin.jkesindia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sachin', '', 0, 0, '1602567329', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(136, 'atish.net@gmail.com', '4e8c6080ccea68b11d765bfe8e81cc8f', 'atish', '', 0, 0, '1602603503', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(137, 'loknath@yopmail.com', 'dc06698f0e2e75751545455899adccc3', 'loknath', '', 0, 0, '1602663459', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(138, 'gautammanral910@gmail.com', '8d25678e57d29f7ea940fba2f84daf04', 'gautam singh', '', 0, 0, '1602665093', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(139, 'ted@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'yay', '', 0, 0, '1602713866', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(140, 'yidogeb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'yido', '', 0, 0, '1602755198', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(141, 'thanks@gmail.com', '8d2d815105ef54785902a68dd7655c2a', 'thanks ', '', 0, 0, '1602758105', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(142, 'murtada.altaee@gmail.com', '3347a705e7ab944a2c5fad5fd68a2eca', 'murtada', '', 0, 0, '1602838026', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(143, 'test@gmaul.com', 'e10adc3949ba59abbe56e057f20f883e', 'test', '', 0, 0, '1602855526', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(144, 'efsr.colombia@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'hola', '', 0, 0, '1602857075', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(145, 'vvfff@bbb.cc', '25f9e794323b453885f5181f1b624d0b', 'hgggg', '', 0, 0, '1602884835', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(146, 'vvyvcfhc@hbvv.com', '75042742b4e054112cfabb26fa1914a2', 'nvfgggccf', '', 0, 0, '1602884864', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(147, 'ranjeetamaheshkano@gmail.com', '53977e83cd84ac70272e98c611bb736e', 'Anukriti kanojiya', '', 0, 0, '1602946276', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(148, 'tarradayoussef@gmail.com', 'db238271a08094970a75728e63b11a98', 'youssef', '', 0, 0, '1602951079', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(149, 'fadimansours@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'fadimansours@gmail.com', '', 0, 0, '1603038118', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(150, 'mixkeyperia@gmail.com', '6af4231a6f6c9405160ad8308eb0841e', 'mixkey23', '', 0, 0, '1603061102', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(151, 'neerajagrawal1994@gmail.com', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'neeraj', '', 0, 0, '1603115176', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(152, 'vineet@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'vinni', '', 0, 0, '1603178382', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(153, 'hasawibowo@gmail.com', '0060656f68f47974634d0c80b548c43e', 'hasa', '', 0, 0, '1603199785', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(154, 'fotonetcafe@hotmail.com', '8f6dc552e21053d23cbac069cda8ec24', 'peppe', '', 0, 0, '1603213725', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(155, 'didu@vhjgi.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'bhfhbj', '', 0, 0, '1603226287', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(156, 'user@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'hhguj hugj', '', 0, 0, '1603226318', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(157, 'dudu@gmail.com', '7e9d294b3f235d869f542024bee8c6ed', 'dudu', '', 0, 0, '1603226365', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(158, 'deval.primocys@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'dev', '5f905227f21e9.jpg', 0, 0, '1603291957', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(159, 'maiux39@hotmail.com', '46d1a1fdac205c940195e0903c4826a7', 'renzo', '', 0, 0, '1603302775', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(160, 'faisalmaaz161@gmail.com', '76419026d994f489336f264c4c835f46', 'faisal', '', 0, 0, '1603305117', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(162, 'idea@gmail.com', '021bd32a43cbd0a5326d1ed9464ebed9', 'name', '', 0, 0, '1603430486', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(163, 'kadal@gmail.com', '9b4a99200cda0e320795c93086a05ac4', 'kadal', '', 0, 0, '1603470609', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(164, 'karwankhalid@yandex.com', '66c03d3ed785ed74169981e8d88e5697', 'karwan', '', 0, 0, '1603625855', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(165, 'suthesan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'suthesan', '', 0, 0, '1603719819', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(166, 'infantinfant06@gmail.com', '9fc69181377e2a6dd972b994f4c131c3', 'infant', '', 0, 0, '1603737861', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(167, 'cortescesar@yahoo.com', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'cesar', '', 0, 0, '1603739560', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(168, 'mdbcentre@gmail.com', '4db43302ada091529d4c43deb0799c34', 'Misterf', '', 0, 0, '1603796810', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(169, 'tecnosotf@gmail.com', 'ce3aed380451ae0e5c6acfaecb9eb67b', 'tecnosotf', '', 0, 0, '1603830811', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(170, 'regg@gmail.com', '45aa454c710d8897a67d320ec1b246ce', 'regggg', '', 0, 0, '1603856377', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(171, 'abhi9721sunny@gmail.com', '36a10e3f7d137f42b3c2811a27441897', 'abhi9721', '', 0, 0, '1603879139', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(172, 'jsalvadormarin@hotmail.com', '4e45dd90c4c78fdb7d6daa7cbcc63d00', 'pepe', '', 0, 0, '1603891265', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(173, 'cocumarin@gmail.com', '28fe0d7adf514a7b109677794c5fef62', 'pepe', '', 0, 0, '1603894877', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(174, 'hellow@gmail.com', '6d40b152275c6a1803396184b99737cc', 'hellow', '', 0, 0, '1603917189', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(175, 'sulaimanbaba18@gmail.com', '319eb3bee6674045f45db6e0fd0b6a58', 'sulaiman', '', 0, 0, '1603920978', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(176, 'lamissrenek@yopmail.com', '25f9e794323b453885f5181f1b624d0b', 'prueba', '', 0, 0, '1603936035', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(177, 'dev.murtada@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'murtada', '', 0, 0, '1603961953', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(178, 'biyohnefabrice@gmail.com', 'ab4f63f9ac65152575886860dde480a1', 'fab', '', 0, 0, '1604013340', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(179, 'amkar.karim@gmail.com', '4c86370b292c15652c88df5bae338856', 'karim', '', 0, 0, '1604053092', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(180, 'kndkr011@gmail.com', '2809ac08e23386bbe504456d0b36f5a0', 'kdn', '', 0, 0, '1604053181', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(181, 'webfrez@gmail.com', '02d47286cc850aaf8a78f321c44177e5', 'webfrez', '', 0, 0, '1604057153', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(182, 'aliounesakho1@gmail.com', '3baf07a5ed9bc013e55a8afa8f9123c6', 'sakho', '', 0, 0, '1604057199', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(183, 'skooldev@gmail.com', '889555ebfd38702305b252f56d3ba174', 'jack', '', 0, 0, '1604098906', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(184, 'arpan.prime@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'arpan.prime@gmail.com', '', 0, 0, '1604129500', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(185, 'patelparth654321@gmail.com', '9acc5ed7cda90c08ff3cae490e470690', 'Parth', '', 0, 0, '1604129629', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(186, 'rony01712651412@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'rony', '', 0, 0, '1604168727', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(187, 'ahomadun.ali@gmail.com', 'c0dce2b49a50c9806d5205258ac7ca18', 'Spartan300', '', 0, 0, '1604173003', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(188, 'nssmohlan@gmail.com', '2d43bc8af7643171f96713f935ada791', 'narinder ', '', 0, 0, '1604174500', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(189, 'marsapille@gmail.com', '8756eb7181fb4cd7c5d98ad6d8e9d7e7', 'oscer', '', 0, 0, '1604191057', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(190, 'marsapille@gmail.com', '8756eb7181fb4cd7c5d98ad6d8e9d7e7', 'oscar', '', 0, 0, '1604191218', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(191, 'richardjmarquezf@gmail.com', 'e615fbab59b060df5ca3e1c471de35e0', 'Richard', '', 0, 0, '1604200766', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(192, 'matriks27@gmail.com', '7e07d5084295fa29580b903fc91f08eb', 'matriks27', '', 0, 0, '1604240775', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(193, 'an3websolutions@gmail.com', 'd1d58bb7272cb141acc16424869ba6f0', 'an3web', '', 0, 0, '1604250272', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(194, 'eivazy1376@yahoo.com', '25f9e794323b453885f5181f1b624d0b', 'Farzaddd', '', 0, 0, '1604354269', '', '', '', '2023-09-20 09:28:00', NULL, NULL),
(195, 'amit.primocys@gmail.com', '', '', '', 0, 0, '1694518005', NULL, '', '', '2023-09-20 09:28:00', NULL, NULL),
(196, 'karankabir@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Karan19', '', 0, 0, '1692874743', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(197, 'karankabir@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Karan', '', 0, 0, '1692877005', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(198, 'Karan.primocys@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Karan', '', 0, 0, '1692878975', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(199, 'gdydy?hdugjgj', 'e04755387e5b5968ec213e41f70c1d46', 'jcuc', '', 0, 0, '1693299458', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(200, 'kugjg', 'e10adc3949ba59abbe56e057f20f883e', 'karan', '', 0, 0, '1693459569', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(201, 'abc123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'karan', '', 0, 0, '1693550726', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(202, '123asd@gmail.com', 'e14c05f0dc27e6be1fc127abaf474a59', 'hdjr', '', 0, 0, '1693550843', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(203, 'karan@gmail.com ', 'c3c74d3c5fb95107499ceaee39a00fd5', 'karan', '', 0, 0, '1693550925', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(204, 'jshshdh@gmail.com ', '96565a223f2eab39fef2041cf5d774a7', 'hshshd', '', 0, 0, '1693552047', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(205, 'ka@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1693559315', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(206, 'gg@gmail.com', 'e14c05f0dc27e6be1fc127abaf474a59', 'gg', '', 0, 0, '1693559790', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(207, 'kk@gmail.com ', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1693560113', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(208, 'karank@gmail.com', '923a242cc314b0aef5aea2df31036c77', 'karan', '', 0, 0, '1693807914', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(209, 'abc@gmail.com', '', '', '', 0, 0, '1694524145', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(210, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Rahul', '', 0, 0, '1693910164', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(211, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1693999110', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(212, 'kanika.banvet@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'kanika', '', 0, 0, '1694167058', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(213, 'amit.primocys@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'amit', '650076ed57484.png', 0, 0, '1694518005', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(222, 'primocysarpan@gmail.com', '', 'arpan primocys', 'https://lh3.googleusercontent.com/a/ACg8ocJW32OHMYvrbbORG5lgNAmF7CLboTiJ-4PZPgq51evl=s96-c', 0, 0, '1695721403', NULL, 'd9U_8xCRS3qdjaBIoqpd4A:APA91bG4bNBgnH0MJT2k2NGq-gqu9pHFbMtXdAGRdojFrMpUr4CIYb1q_4Aa7ki5HZHu5-O7Q2pfx6isc0zZIm9XEUeI4cFS5mu2HJngS8taI2hozWZwE2J5kt2Y4diLoO4WUAIXZOxG', NULL, '2023-09-26 09:43:23', NULL, NULL),
(223, 'tirath.primocys@gmail.com', '', 'tirath primocys', 'https://lh3.googleusercontent.com/a/ACg8ocKfEQu_PGqijOovcveK0Nk362vuUdpTJy1b9iqd3oyP=s96-c', 0, 0, '1694610369', NULL, 'd3Hons9KQuyGWo4LssgjLc:APA91bGVxRMILRw1sQXk3sITiEqeXT9roUqpIXOwBwGbWCMYrurFtoL9b2cDYXEYfufMF9gEd3zahOnNi_myj8EGcxJ5617eKx_z954PmTSJlRpJV4TrlgNxa5nUaR30D69dMDVeHcx9', NULL, '2023-09-20 09:28:00', NULL, NULL),
(224, 'irvinlee.68306@gmail.com', '', 'Irvin Lee', 'https://lh3.googleusercontent.com/a/ACg8ocJHHmBx-ChOG3jXOyLr5W6ym3wIHI6zQhzQfHG-5fz4=s96-c', 0, 0, '1694612030', NULL, 'BLACKLISTED', NULL, '2023-09-20 09:28:00', NULL, NULL),
(225, 'guillermogeorge.68003@gmail.com', '', 'Guillermo George', 'https://lh3.googleusercontent.com/a/ACg8ocKqEXKMvrGMgSyFVcqTHKgOdbIYGFAX3E7BGO6OKOvQ=s96-c', 0, 0, '1694612093', NULL, 'BLACKLISTED', NULL, '2023-09-20 09:28:00', NULL, NULL),
(226, 'rubyflowers.77614@gmail.com', '', 'Ruby Flowers', 'https://lh3.googleusercontent.com/a/ACg8ocJygqsprbDSCxW804rCBp7qongyw7Yn4pMW0qIZ7N7o=s96-c', 0, 0, '1694777090', NULL, 'BLACKLISTED', NULL, '2023-09-20 09:28:00', NULL, NULL),
(227, 'kk@gmail.com', '75e2d24ddfabfa60dbbcdc08333c5148', 'Karan', '', 0, 0, '1695027056', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(228, 'kk@gmail.com', '75e2d24ddfabfa60dbbcdc08333c5148', 'Karan', '', 0, 0, '1695027397', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(229, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695030689', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(230, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695031570', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(231, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695032372', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(232, 'karan@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695032945', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(233, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695033351', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(234, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695033669', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(235, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695033683', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(236, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695034296', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(237, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695035283', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(238, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695035342', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(239, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695035439', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(240, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695036005', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(241, '', '3011e4fb6f5e0b0657a95e9212e9070e', '', '', 0, 0, '1695036108', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(243, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695036697', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(244, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695037079', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(245, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695037553', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(246, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695037679', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(247, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695038890', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(248, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695039163', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(249, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695039272', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(250, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695039419', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(251, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695039601', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(252, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695039924', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(253, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695039959', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(254, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695040049', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(255, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695040466', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(256, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695040589', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(257, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695040736', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(258, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695040837', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(259, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695041780', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(260, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695041878', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(261, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695042383', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(262, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695042448', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(263, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695042866', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(265, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695043199', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(266, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695044714', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(267, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695044879', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(268, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695045913', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(269, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695045947', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(270, '', 'a3dc6bebf8a9a97523cbba0eb4897e88', '', '', 0, 0, '1695046022', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(275, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695046703', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(277, 'kk@gmail.com', 'a3dc6bebf8a9a97523cbba0eb4897e88', 'Karan', '', 0, 0, '1695105279', NULL, '', NULL, '2023-09-20 09:28:00', NULL, NULL),
(279, 'arpan.primo@gmail.com', '', 'ArpanPrimo', 'https://lh3.googleusercontent.com/a/ACg8ocISRU374LptipUtgJTEqqbo_6zE4ij8bOJZszMijp7C=s96-c', 0, 0, '1695716711', NULL, '', NULL, '2023-09-26 08:25:11', NULL, NULL),
(280, 'pavan.primocys@gmail.com', '', 'pavanprimocys', 'https://lh3.googleusercontent.com/a/ACg8ocKjIhZ31eUqlcYXGmFu_TzHC4PjT8o1m0DHHLhrGtZaZQ=s96-c', 0, 0, '1695717228', NULL, '', NULL, '2023-09-26 08:33:48', NULL, NULL),
(281, 'kanika@demo.com', 'e10adc3949ba59abbe56e057f20f883e', 'kanika451', '65ba2050ed6e3.jpg', 0, 0, '1695721337', NULL, '', NULL, '2024-02-07 05:23:45', NULL, NULL),
(286, 'chauhanajay1812@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Ajay1812', '65bb6d4e5b533.jpg', 0, 0, '1695727928', NULL, '', NULL, '2024-02-07 05:23:36', NULL, NULL),
(287, 'pawan.primocys@gmail.com', '', 'pawanprimocys', '65b9ee5e92206.jpg', 0, 0, '1705709825', NULL, '', NULL, '2024-02-07 05:23:22', NULL, NULL),
(288, 'armanvaraiya1112@hn.com', '123456', 'arman', '65b8ca6a9b253.jpg', 0, 0, '1705709825', NULL, '', NULL, '2024-02-07 05:23:11', NULL, NULL),
(289, 'armanvaraiya1112@hn.com', '123456', 'arman', '65a9186dddf5c.jpeg', 0, 0, '1705709825', NULL, '', NULL, '2024-02-07 05:23:03', NULL, NULL),
(290, 'armanvaraiya1112@hn.com', '123456', 'arman', '65a916bc3c654.png', 0, 0, '1705709825', NULL, '', NULL, '2024-02-07 05:22:55', NULL, NULL),
(292, 'armanvaraiya1112@hn.com', '123456', 'arman', '65a914c07fa40.jpg', 0, 0, '1705709825', NULL, '', NULL, '2024-02-07 05:22:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `fname`, `lname`, `email`, `uname`, `password`, `profile_image`, `created_at`, `updated_at`) VALUES
(10, 'ters', 'term', 'primocys98@gmail.com', 'prim', '827ccb0eea8a706c4c34a16891f84e7b', '65a914c07fa40.jpg', NULL, NULL),
(5, 'Kanika', 'Primo', 'vendor2@demo.com', 'vendor2', 'e10adc3949ba59abbe56e057f20f883e', '60e0670a11cbd.jpg', NULL, NULL),
(9, 'Arman', 'vr', 'primocys95@gmail.com', 'Aruuu', '827ccb0eea8a706c4c34a16891f84e7b', '65a916bc3c654.png', NULL, NULL),
(11, 'UMang', 'prim', 'primocys98@gmail.com', 'umnd', '4607e782c4d86fd5364d7e4508bb10d9', '60e057a7c10eb.jpeg', NULL, NULL),
(13, 'Sheetal', 'was', 'primocys95@gmail.com', 'Aruuu', '827ccb0eea8a706c4c34a16891f84e7b', '60e057a7c10eb.jpeg', NULL, NULL),
(16, 'Karachi', 'Kem', 'kae@gmail.com', 'kar', '123456', '1706771053.jpg', '2024-02-01 01:34:13', '2024-02-01 01:34:13'),
(17, 'Arman', 'prim', 'primocys123@gmail.com', 'sheetu', '123456', '1706771440.jpg', '2024-02-01 01:40:40', '2024-02-01 01:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `view_store`
--

CREATE TABLE `view_store` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `vid` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `view_store`
--

INSERT INTO `view_store` (`id`, `user_id`, `store_id`, `vid`, `created_at`, `updated_at`) VALUES
(1, 16, 31, 1, NULL, NULL),
(2, 16, 17, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `available_payment_mode`
--
ALTER TABLE `available_payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_table`
--
ALTER TABLE `book_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_mode_id` (`payment_mode`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`rev_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `view_store`
--
ALTER TABLE `view_store`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `available_payment_mode`
--
ALTER TABLE `available_payment_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `book_table`
--
ALTER TABLE `book_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `rev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `view_store`
--
ALTER TABLE `view_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_mode_id` FOREIGN KEY (`payment_mode`) REFERENCES `available_payment_mode` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
