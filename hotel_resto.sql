-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 11:54 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'kenny', '12345'),
(2, 'alpha', '54321');

-- --------------------------------------------------------

--
-- Table structure for table `guest_feedback`
--

CREATE TABLE `guest_feedback` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest_feedback`
--

INSERT INTO `guest_feedback` (`id`, `customer_name`, `rating`, `comments`, `created_at`) VALUES
(1, 'ishimwe kananana', 3, 'improve your service mister ', '2025-12-20 22:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `table_number` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_method` enum('Cash','MoMo') DEFAULT NULL,
  `momo_number` varchar(15) DEFAULT NULL,
  `status` enum('Pending','Confirmed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `table_number`, `total_amount`, `payment_method`, `momo_number`, `status`, `created_at`) VALUES
(1, 2, 14500, 'MoMo', '0795817707', 'Confirmed', '2025-12-20 20:18:07'),
(2, 2, 2500, 'Cash', '', 'Confirmed', '2025-12-20 20:25:36'),
(3, 3, 12000, 'MoMo', '0799999999', 'Confirmed', '2025-12-20 20:33:47'),
(4, 4, 1000, 'MoMo', '0799999999', 'Pending', '2025-12-20 20:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `item_price` int(11) DEFAULT NULL,
  `item_temp` varchar(20) DEFAULT 'Normal',
  `special_notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `item_name`, `item_price`, `item_temp`, `special_notes`) VALUES
(1, 1, 'Brochettes', 2500, 'Normal', NULL),
(2, 1, 'Grilled Tilapia', 12000, 'Normal', NULL),
(3, 2, 'Primus Large', 1500, 'Normal', NULL),
(4, 2, 'Inyange Juice', 1000, 'Normal', NULL),
(5, 3, 'Grilled Tilapia', 12000, 'Normal', NULL),
(6, 4, 'sambaza', 1000, 'Normal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resto_bar_items`
--

CREATE TABLE `resto_bar_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `category` enum('Food','Drink') DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `temp_type` enum('Cold','Warm','None') DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resto_bar_items`
--

INSERT INTO `resto_bar_items` (`id`, `name`, `price`, `category`, `is_available`, `temp_type`) VALUES
(1, 'Brochettes', 2500, 'Food', 0, 'None'),
(2, 'Grilled Tilapia', 12000, 'Food', 1, 'None'),
(3, 'Primus Large', 1500, 'Drink', 1, 'None'),
(4, 'Inyange Juice', 1000, 'Drink', 1, 'Cold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `guest_feedback`
--
ALTER TABLE `guest_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `resto_bar_items`
--
ALTER TABLE `resto_bar_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guest_feedback`
--
ALTER TABLE `guest_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resto_bar_items`
--
ALTER TABLE `resto_bar_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
