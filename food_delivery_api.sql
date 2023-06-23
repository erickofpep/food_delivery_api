-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2023 at 11:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_delivery_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `menu_item` varchar(150) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_price` float(25,2) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `restaurant_id`, `menu_item`, `menu_description`, `menu_price`, `created_date`, `updated_date`) VALUES
(1, 5, 'Chicken and Chipps', 'xxxxxxxxxxx', 25.00, '2023-06-22 00:37:47', '0000-00-00 00:00:00'),
(2, 2, 'Fried Rice and Fish', 'Fried Rice and Fish', 55.00, '2023-06-22 00:57:42', '0000-00-00 00:00:00'),
(3, 3, 'Plain Rice and Palava Sauce', 'Plain Rice and Palava Sauce', 60.00, '2023-06-22 00:58:25', '0000-00-00 00:00:00'),
(4, 4, 'Noodles and Gravy with Chicken', 'Noodles and Gravy with Chicken', 60.00, '2023-06-22 00:59:09', '0000-00-00 00:00:00'),
(5, 1, 'Goat Light soup with Fufu', 'Noodles and Gravy with Chicken', 70.00, '2023-06-22 01:00:16', '0000-00-00 00:00:00'),
(6, 1, 'Curry Rice and Beef Stew', 'Curry Rice and Beef Stew', 55.00, '2023-06-22 01:00:42', '0000-00-00 00:00:00'),
(7, 1, 'Curry Rice with Fish stew', 'Curry Rice with Fish stew', 60.00, '2023-06-22 01:01:21', '0000-00-00 00:00:00'),
(8, 1, 'Banku and Okro stew with Fish', 'Banku and Okro stew with Fish', 60.00, '2023-06-22 13:46:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `fullname` varchar(80) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `location_address` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_price` float(10,2) NOT NULL,
  `delivery_amount` float(10,2) NOT NULL,
  `total_amount` float(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `fullname`, `contact_number`, `email_address`, `location_address`, `city`, `country`, `menu_id`, `menu_price`, `delivery_amount`, `total_amount`, `order_date`) VALUES
(1, 'Kelvin Boako', '0206100233', 'kelvinbk@yahoo.com', 'Kaokudi street, Nima', 'Nima, Accra', 'Ghana', 3, 60.00, 15.00, 75.00, '2023-06-22 21:27:24'),
(2, 'Kofi Amankwah', '0201000222', 'kamankwah@yahoo.com', '28th Dzormor street, Ofankor', 'Accra', 'Ghana', 8, 60.00, 13.50, 73.50, '2023-06-22 22:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `rest_id` int(11) NOT NULL,
  `restaurant_name` varchar(100) NOT NULL,
  `restaurant_address` varchar(100) NOT NULL,
  `restaurant_city` varchar(100) NOT NULL,
  `restaurant_country` varchar(50) NOT NULL,
  `restaurant_phonenumber` varchar(50) NOT NULL,
  `restaurant_email` varchar(80) NOT NULL,
  `further_info` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`rest_id`, `restaurant_name`, `restaurant_address`, `restaurant_city`, `restaurant_country`, `restaurant_phonenumber`, `restaurant_email`, `further_info`, `created_date`, `updated_date`) VALUES
(1, 'Carrot Corner Restaurant', 'Otswe street, Osu', 'Accra', 'Ghana', '0245000102', 'carrotrestaurant@gmail.com', '', '2023-06-21 17:27:28', '0000-00-00 00:00:00'),
(2, 'Erickof Restaurant', 'Campus breakfast street, Taifa', 'Accra', 'Ghana', '0266100001', 'erickofrest@gmail.com', '', '2023-06-21 19:34:29', '0000-00-00 00:00:00'),
(3, 'Micky Jay Restaurant', 'Dansoman', 'Accra', 'Ghana', '0547100200', 'mickyjay@hotmail.com', '', '2023-06-21 23:22:54', '0000-00-00 00:00:00'),
(4, 'Jazzi Bay Restaurant', 'East Legon', 'Accra', 'Ghana', '0201200110', 'jazzibay@gmail.com', '', '2023-06-21 23:23:02', '0000-00-00 00:00:00'),
(5, 'Mikassa Midorro', 'Nana krom, East Legon', 'Accra', 'Ghana', '0244322100', 'mmidorro@memail.com', '', '2023-06-21 23:54:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`rest_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `rest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
