-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2025 at 05:28 AM
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
-- Database: `arvina_clothing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@arvina.com', '2025-11-02 11:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Men'),
(2, 'Women');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_users`
--

CREATE TABLE `customer_users` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_users`
--

INSERT INTO `customer_users` (`customer_id`, `username`, `password`, `email`, `full_name`, `phone`, `address`, `city`, `postal_code`, `created_at`, `last_login`) VALUES
(1, 'user1', 'user123', 'user1@demo.com', 'Demo User', '+94777123456', NULL, NULL, NULL, '2025-11-02 17:38:31', '2025-11-02 17:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `selected_color` varchar(50) DEFAULT NULL,
  `selected_size` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `available_colors` text DEFAULT NULL,
  `available_sizes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `subcategory_id`, `description`, `price`, `discount_price`, `image_url`, `stock_quantity`, `available_colors`, `available_sizes`, `created_at`, `updated_at`) VALUES
(53, 'Classic Dress Shirt', 1, 1, 'Elegant dress shirt perfect for formal occasions', 5450.00, 4900.00, '../assest/men/shirts/(1).jpeg', 60, 'White,Blue,Gray', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(54, 'Casual Button-Down', 1, 1, 'Comfortable casual shirt for everyday wear', 4500.00, 4050.00, '../assest/men/shirts/(2).jpeg', 70, 'Blue,Green,White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(55, 'Premium Cotton Shirt', 1, 1, 'High-quality cotton shirt with modern design', 6700.00, 6030.00, '../assest/men/shirts/(3).jpeg', 50, 'White,Black,Gray', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(56, 'Oxford Shirt', 1, 1, 'Classic Oxford weave for professional look', 5200.00, 4700.00, '../assest/men/shirts/(4).jpeg', 40, 'Blue,White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(57, 'Slim Fit Shirt', 1, 1, 'Contemporary slim fit design', 5800.00, 5200.00, '../assest/men/shirts/(5).jpeg', 45, 'Gray,Black', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(58, 'Linen Blend Shirt', 1, 1, 'Breathable linen blend for warm weather', 6200.00, 5400.00, '../assest/men/shirts/(6).jpeg', 55, 'Beige,White,Gray', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(59, 'Check Pattern Shirt', 1, 1, 'Stylish check pattern casual shirt', 4900.00, 4400.00, '../assest/men/shirts/(7).jpeg', 65, 'Red,Blue,Green', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(60, 'Striped Formal Shirt', 1, 1, 'Professional striped shirt', 5600.00, 5000.00, '../assest/men/shirts/(8).jpeg', 50, 'Blue,White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(61, 'Denim Shirt', 1, 1, 'Classic denim shirt for casual occasions', 5300.00, 4600.00, '../assest/men/shirts/(9).jpeg', 40, 'Blue,Dark Blue', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(62, 'White Dress Shirt', 1, 1, 'Timeless white dress shirt', 4800.00, 4300.00, '../assest/men/shirts/(10).jpeg', 55, 'White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(63, 'Printed Casual Shirt', 1, 1, 'Trendy printed design for weekends', 5100.00, 4600.00, '../assest/men/shirts/(11).jpeg', 38, 'Navy,White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(64, 'Smart Casual Shirt', 1, 1, 'Versatile shirt for any occasion', 5500.00, 4850.00, '../assest/men/shirts/(12).jpeg', 42, 'Blue,Gray,White', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(65, 'Classic Black Suit', 1, 2, 'Elegant black suit for formal occasions', 35000.00, 30000.00, '../assest/men/suits/(1).jpg', 25, 'Black,Gray', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(66, 'Navy Blue Suit', 1, 2, 'Professional navy blue business suit', 38000.00, 31000.00, '../assest/men/suits/(2).jpg', 30, 'Navy,Blue', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(67, 'Charcoal Grey Suit', 1, 2, 'Sophisticated charcoal grey suit', 36500.00, 30000.00, '../assest/men/suits/(3).jpg', 40, 'Gray,Black', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(68, 'Three-Piece Suit', 1, 2, 'Complete three-piece suit with vest', 42000.00, 34000.00, '../assest/men/suits/(4).jpg', 20, 'Black,Navy', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(69, 'Slim Fit Suit', 1, 2, 'Contemporary slim fit design', 34000.00, 28000.00, '../assest/men/suits/(5).jpg', 35, 'Gray,Black', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(70, 'Double-Breasted Suit', 1, 2, 'Timeless double-breasted style', 40000.00, 32500.00, '../assest/men/suits/(6).jpg', 18, 'Black,Gray,Navy', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(71, 'Pinstripe Suit', 1, 2, 'Classic pinstripe pattern', 37500.00, 31000.00, '../assest/men/suits/(7).jpg', 22, 'Blue,Gray', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(72, 'Linen Suit', 1, 2, 'Breathable linen suit for warm weather', 32000.00, 27000.00, '../assest/men/suits/(8).jpg', 40, 'Beige,White', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(73, 'Tuxedo', 1, 2, 'Premium tuxedo for special occasions', 45000.00, 35000.00, '../assest/men/suits/(9).jpg', 15, 'Black,White', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(74, 'Brown Tweed Suit', 1, 2, 'Traditional tweed suit', 39000.00, 32000.00, '../assest/men/suits/(10).jpg', 25, 'Brown,Gray', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(75, 'Light Grey Suit', 1, 2, 'Fresh light grey suit', 33500.00, 28000.00, '../assest/men/suits/(11).jpg', 28, 'Light Gray', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(76, 'Check Pattern Suit', 1, 2, 'Modern check pattern suit', 36000.00, 30000.00, '../assest/men/suits/(12).jpg', 33, 'Gray,Black', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(77, 'Velvet Blazer Suit', 1, 2, 'Premium velvet blazer suit', 41000.00, 33000.00, '../assest/men/suits/(13).jpg', 12, 'Maroon,Black', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(78, 'Beige Suit', 1, 2, 'Versatile beige suit', 31000.00, 26000.00, '../assest/men/suits/(14).jpg', 35, 'Beige,Cream', 'S,M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(79, 'Burgundy Suit', 1, 2, 'Bold burgundy statement suit', 38500.00, 31000.00, '../assest/men/suits/(15).jpg', 20, 'Burgundy,Black', 'M,L,XL', '2025-11-02 14:31:20', '2025-11-03 03:30:59'),
(80, 'Leather Belt', 1, 5, 'Classic leather belt for formal and casual wear', 3500.00, 3000.00, '../assest/men/accessories/(1).jpg', 20, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(81, 'Silk Tie', 1, 5, 'Premium silk tie', 2800.00, 2400.00, '../assest/men/accessories/(2).jpg', 30, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(82, 'Leather Wallet', 1, 5, 'Genuine leather bifold wallet', 4200.00, 3600.00, '../assest/men/accessories/(3).jpg', 25, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(83, 'Bow Tie', 1, 5, 'Elegant bow tie for special occasions', 2200.00, 1900.00, '../assest/men/accessories/(4).jpg', 40, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(84, 'Cufflinks Set', 1, 5, 'Stylish cufflinks set', 3800.00, 3300.00, '../assest/men/accessories/(5).jpg', 30, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(85, 'Pocket Square', 1, 5, 'Designer pocket square', 1500.00, 1300.00, '../assest/men/accessories/(6).jpg', 40, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(86, 'Suspenders', 1, 5, 'Adjustable suspenders', 2500.00, 2150.00, '../assest/men/accessories/(7).jpg', 30, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(87, 'Leather Gloves', 1, 5, 'Premium leather gloves', 4500.00, 3800.00, '../assest/men/accessories/(8).jpg', 25, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(88, 'Wool Scarf', 1, 5, 'Warm wool scarf', 3200.00, 2750.00, '../assest/men/accessories/(9).jpg', 30, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(89, 'Fedora Hat', 1, 5, 'Classic fedora hat', 5500.00, 4700.00, '../assest/men/accessories/(10).jpg', 20, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(90, 'Sunglasses', 1, 5, 'Designer sunglasses', 6800.00, 5800.00, '../assest/men/accessories/(11).jpg', 25, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(91, 'Watch', 1, 5, 'Premium wristwatch', 15000.00, 12500.00, '../assest/men/accessories/(12).jpg', 15, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(92, 'Messenger Bag', 1, 5, 'Leather messenger bag', 8500.00, 7300.00, '../assest/men/accessories/(13).jpg', 20, NULL, NULL, '2025-11-02 14:50:24', '2025-11-03 03:31:00'),
(93, 'Classic Dress Pants', 1, 3, 'Professional dress pants for formal occasions', 6500.00, 5500.00, '../assest/men/pants/(1).jpg', 30, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(94, 'Slim Fit Chinos', 1, 3, 'Modern slim fit chino pants', 5800.00, 5000.00, '../assest/men/pants/(2).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(95, 'Cargo Pants', 1, 3, 'Functional cargo pants with multiple pockets', 5200.00, 4500.00, '../assest/men/pants/(3).jpg', 30, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(96, 'Pleated Trousers', 1, 3, 'Classic pleated trousers', 7200.00, 6000.00, '../assest/men/pants/(4).jpg', 20, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(97, 'Khaki Pants', 1, 3, 'Versatile khaki casual pants', 4900.00, 4300.00, '../assest/men/pants/(5).jpg', 35, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(98, 'Corduroy Pants', 1, 3, 'Stylish corduroy pants', 6800.00, 5900.00, '../assest/men/pants/(6).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(99, 'Flat Front Pants', 1, 3, 'Modern flat front design', 6300.00, 5500.00, '../assest/men/pants/(7).jpg', 30, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(100, 'Linen Pants', 1, 3, 'Breathable linen pants', 5500.00, 4800.00, '../assest/men/pants/(8).jpg', 40, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(101, 'Jogger Pants', 1, 3, 'Comfortable jogger style pants', 4500.00, 4000.00, '../assest/men/pants/(9).jpg', 35, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(102, 'Check Pattern Pants', 1, 3, 'Trendy check pattern pants', 6000.00, 5200.00, '../assest/men/pants/(10).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(103, 'Leather Jacket', 1, 4, 'Classic leather jacket for stylish look', 18500.00, 15500.00, '../assest/men/jackets/(1).jpg', 20, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(104, 'Denim Jacket', 1, 4, 'Timeless denim jacket', 8900.00, 7400.00, '../assest/men/jackets/(2).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(105, 'Bomber Jacket', 1, 4, 'Trendy bomber style jacket', 12500.00, 10500.00, '../assest/men/jackets/(3).jpg', 30, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(106, 'Puffer Jacket', 1, 4, 'Warm puffer jacket for cold weather', 15800.00, 13300.00, '../assest/men/jackets/(4).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(107, 'Windbreaker', 1, 4, 'Lightweight windbreaker jacket', 7500.00, 6300.00, '../assest/men/jackets/(5).jpg', 30, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(108, 'Blazer Jacket', 1, 4, 'Smart blazer jacket', 14000.00, 11800.00, '../assest/men/jackets/(6).jpg', 20, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(109, 'Field Jacket', 1, 4, 'Functional field jacket with pockets', 11500.00, 9700.00, '../assest/men/jackets/(7).jpg', 20, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(110, 'Varsity Jacket', 1, 4, 'Classic varsity style jacket', 10800.00, 9100.00, '../assest/men/jackets/(8).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(111, 'Parka Jacket', 1, 4, 'Heavy-duty parka for extreme cold', 16500.00, 13700.00, '../assest/men/jackets/(9).jpg', 15, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(112, 'Track Jacket', 1, 4, 'Sporty track jacket', 6900.00, 5900.00, '../assest/men/jackets/(10).jpg', 35, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(113, 'Suede Jacket', 1, 4, 'Premium suede jacket', 17200.00, 14300.00, '../assest/men/jackets/(11).jpg', 20, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(114, 'Harrington Jacket', 1, 4, 'Iconic Harrington style jacket', 9500.00, 8000.00, '../assest/men/jackets/(12).jpg', 25, NULL, NULL, '2025-11-02 14:52:06', '2025-11-03 03:30:59'),
(115, 'DAEGU COTTON COLLAR T-SHIRT', 2, 9, 'A stylish cotton t-shirt with a buttoned collar for everyday comfort.', 11794.92, 8460.00, '../assest/women/tops/(1).jpg', 50, 'Black,White,Beige', 'S,M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(116, 'SEOUL FLORAL SUMMER DRESS', 2, 9, 'Lightweight floral dress perfect for sunny days and vacations.', 9499.50, 7499.50, '../assest/women/tops/(2).jpg', 45, 'Blue,White,Pink', 'S,M,L', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(117, 'BUSAN LINEN WRAP DRESS', 2, 9, 'A breezy linen wrap dress that blends comfort with elegance.', 10999.00, 8499.00, '../assest/women/tops/(3).jpg', 40, 'Beige,Brown,White', 'M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(118, 'JEJU PRINTED MAXI', 2, 9, 'Printed maxi dress inspired by the coastal beauty of Jeju Island.', 13250.00, 9500.00, '../assest/women/tops/(4).jpg', 30, 'Green,Yellow,White', 'S,M,L', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(119, 'INCHEON CHECKED MIDI', 2, 9, 'Midi dress with a checked pattern — classic and professional.', 7950.00, 5950.00, '../assest/women/tops/(5).jpg', 60, 'Gray,Black', 'M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(120, 'BUSAN LINEN WRAP DRESS', 2, 9, 'Elegant wrap design with natural linen texture for breathable comfort.', 10999.00, 8499.00, '../assest/women/tops/(6).jpg', 55, 'Beige,Olive,White', 'S,M,L', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(121, 'BUSAN LINEN WRAP DRESS', 2, 9, 'Refined version of the wrap dress, featuring premium stitching.', 10999.00, 8499.00, '../assest/women/tops/(7).jpg', 50, 'Beige,Black', 'S,M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(122, 'DAEGU COTTON COLLAR T-SHIRT', 2, 9, 'A stylish cotton t-shirt with a buttoned collar for everyday comfort.', 11794.92, 8460.00, '../assest/women/tops/(8).jpg', 50, 'Black,White,Beige', 'S,M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(123, 'SEOUL FLORAL SUMMER DRESS', 2, 9, 'Lightweight floral dress perfect for sunny days and vacations.', 9499.50, 7499.50, '../assest/women/tops/(9).jpg', 45, 'Blue,White,Pink', 'S,M,L', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(124, 'BUSAN LINEN WRAP DRESS', 2, 9, 'A breezy linen wrap dress that blends comfort with elegance.', 10999.00, 8499.00, '../assest/women/tops/(10).jpg', 40, 'Beige,Brown,White', 'M,L,XL', '2025-11-03 02:35:27', '2025-11-03 03:27:40'),
(125, 'DAEGU COTTON COLLAR T-SHIRT', 2, 6, 'A stylish cotton t-shirt with a buttoned collar for everyday comfort.', 11794.92, 8460.00, '../assest/women/dresses/dress1.webp', 50, 'Black,White,Beige', 'S,M,L,XL', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(126, 'SEOUL FLORAL SUMMER DRESS', 2, 6, 'Lightweight floral dress perfect for sunny days and vacations.', 9499.50, 7499.50, '../assest/women/dresses/dress2.webp', 45, 'Blue,White,Pink', 'S,M,L', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(127, 'BUSAN LINEN WRAP DRESS', 2, 6, 'A breezy linen wrap dress that blends comfort with elegance.', 10999.00, 8499.00, '../assest/women/dresses/dress3.jpg', 40, 'Beige,Brown,White', 'M,L,XL', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(128, 'JEJU PRINTED MAXI', 2, 6, 'Printed maxi dress inspired by the coastal beauty of Jeju Island.', 13250.00, 9500.00, '../assest/women/dresses/dress4.avif', 30, 'Green,Yellow,White', 'S,M,L', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(129, 'INCHEON CHECKED MIDI', 2, 6, 'Midi dress with a checked pattern — classic and professional.', 7950.00, 5950.00, '../assest/women/dresses/dress6.jpg', 60, 'Gray,Black', 'M,L,XL', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(130, 'BUSAN LINEN WRAP DRESS', 2, 6, 'Elegant wrap design with natural linen texture for breathable comfort.', 10999.00, 8499.00, '../assest/women/dresses/dress8.jpg', 55, 'Beige,Olive,White', 'S,M,L', '2025-11-03 02:54:12', '2025-11-03 03:27:40'),
(131, 'CLASSIC LINEN TROUSERS', 2, 7, 'Lightweight linen trousers perfect for warm weather.', 8250.00, 7200.00, '../assest/women/bottoms/bottom (1).jpg', 50, 'Beige,White,Gray', 'S,M,L,XL', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(132, 'HIGH-WAISTED JEANS', 2, 7, 'Stylish high-waisted denim jeans.', 9900.00, 8400.00, '../assest/women/bottoms/bottom (1).jpeg', 60, 'Blue,Black,Light Blue', 'S,M,L', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(133, 'PLEATED SKIRT', 2, 7, 'Elegant pleated skirt suitable for work and casual wear.', 7200.00, 5900.00, '../assest/women/bottoms/bottom (5).jpg', 40, 'Pink,Gray,White', 'S,M,L', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(134, 'FLARED TROUSERS', 2, 7, 'Retro-inspired flared trousers.', 8750.00, 7500.00, '../assest/women/bottoms/bottom (6).webp', 35, 'Black,Brown,Beige', 'M,L,XL', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(135, 'WIDE LEG PANTS', 2, 7, 'Comfortable wide-leg pants for all-day wear.', 9550.00, 8200.00, '../assest/women/bottoms/bottom (5).webp', 45, 'Beige,Gray,White', 'S,M,L,XL', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(136, 'COTTON SHORTS', 2, 7, 'Casual cotton shorts perfect for summer.', 6200.00, 5400.00, '../assest/women/bottoms/bottom (8).webp', 55, 'White,Blue,Black', 'S,M,L', '2025-11-03 02:54:22', '2025-11-03 03:27:40'),
(137, 'TRENCH COAT', 2, 8, 'Classic trench coat for timeless elegance.', 18999.00, 15999.00, '../assest/women/outerware/(1).avif', 25, 'Beige,Black,Navy', 'S,M,L,XL', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(138, 'BOMBER JACKET', 2, 8, 'Trendy bomber jacket for casual wear.', 12499.00, 10800.00, '../assest/women/outerware/(1).jpg', 40, 'Black,Green,Gray', 'S,M,L', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(139, 'DENIM JACKET', 2, 8, 'Classic denim jacket perfect for layering.', 8800.00, 7600.00, '../assest/women/outerware/(1).webp', 35, 'Blue,Light Blue', 'S,M,L,XL', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(140, 'LONG OVERCOAT', 2, 8, 'Stylish long overcoat for formal occasions.', 21500.00, 18200.00, '../assest/women/outerware/(2).jpg', 20, 'Gray,Black,Beige', 'M,L,XL', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(141, 'CROP JACKET', 2, 8, 'Fashion-forward cropped jacket for a modern look.', 9900.00, 8500.00, '../assest/women/outerware/(3).jpg', 30, 'Pink,White,Black', 'S,M,L', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(142, 'PUFFER JACKET', 2, 8, 'Warm puffer jacket for winter seasons.', 14200.00, 11900.00, '../assest/women/outerware/(4).jpg', 20, 'Black,Beige,Olive', 'M,L,XL', '2025-11-03 02:54:31', '2025-11-03 03:27:40'),
(143, 'STYLISH SUNGLASSES', 2, 10, 'Trendy UV-protected sunglasses.', 6800.00, 5800.00, '../assest/women/accessories/accessories1.jpg', 25, 'Black,Brown', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40'),
(144, 'ELEGANT HANDBAG', 2, 10, 'Premium leather handbag for daily use.', 12500.00, 10800.00, '../assest/women/accessories/accessories2.jpg', 20, 'Black,Beige,White', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40'),
(145, 'GOLD NECKLACE', 2, 10, 'Beautiful gold-plated necklace.', 8900.00, 7500.00, '../assest/women/accessories/accessories3.jpg', 30, 'Gold', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40'),
(146, 'FASHIONABLE WATCH', 2, 10, 'Stylish wristwatch for women.', 15900.00, 13500.00, '../assest/women/accessories/accessories4.jpg', 15, 'Gold,Silver', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40'),
(147, 'TRENDY CAP', 2, 10, 'Casual cotton cap.', 4800.00, 4000.00, '../assest/women/accessories/accessories5.jpg', 40, 'White,Black', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40'),
(148, 'HAIR CLIP SET', 2, 10, 'Elegant hair clip set.', 3200.00, 2700.00, '../assest/women/accessories/accessories6.jpg', 45, 'Gold,Silver', NULL, '2025-11-03 02:54:43', '2025-11-03 03:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `subcategory_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`subcategory_id`, `subcategory_name`, `category_id`, `thumbnail`, `link`) VALUES
(1, 'Shirts', 1, '../assest/men/shirts/(1).jpeg', './shirts.php'),
(2, 'Suits', 1, '../assest/men/suits/(1).jpg', './suits.php'),
(3, 'Pants', 1, '../assest/men/pants/(1).jpg', './pants.php'),
(4, 'Jackets', 1, '../assest/men/jackets/(1).jpg', './jackets.php'),
(5, 'Accessories', 1, '../assest/men/accessories/(1).jpg', './accessories.php'),
(6, 'Dresses', 2, '../assest/women/dresses/dress1.webp', './dresses.php'),
(7, 'Bottoms', 2, '../assest/women/category/bottom.jpg', './bottoms.php'),
(8, 'Outerwear', 2, '../assest/women/category/(9).jpg', './outerwear.php'),
(9, 'Tops', 2, '../assest/women/category/(8).jpg', './tops.php'),
(10, 'Accessories', 2, '../assest/women/category/accessories7.jpg', './accessories.php');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date` (`created_at`);

--
-- Indexes for table `customer_users`
--
ALTER TABLE `customer_users`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_status` (`order_status`),
  ADD KEY `idx_date` (`order_date`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `idx_order` (`order_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_subcategory` (`subcategory_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_users`
--
ALTER TABLE `customer_users`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_users` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`subcategory_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
