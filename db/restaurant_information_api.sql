-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 04:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_information_api`
--
CREATE DATABASE IF NOT EXISTS `restaurant_information_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `restaurant_information_api`;

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `amenity_id` int(11) NOT NULL,
  `amenity_name` varchar(75) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`amenity_id`, `amenity_name`, `description`, `icon_name`) VALUES
(1, 'Drive-Thru', 'Location offers drive-thru ordering or pickup.', 'drive-thru'),
(2, 'WiFi', 'Location provides guest wireless internet access.', 'wifi'),
(3, 'Outdoor Seating', 'Location has outdoor tables or patio seating.', 'outdoor-seating'),
(4, 'Curbside Pickup', 'Location supports curbside pickup orders.', 'curbside-pickup'),
(5, 'Delivery', 'Location supports delivery through approved services.', 'delivery');

-- --------------------------------------------------------

--
-- Table structure for table `business_hours`
--

CREATE TABLE `business_hours` (
  `hours_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_hours`
--

INSERT INTO `business_hours` (`hours_id`, `location_id`, `day_of_week`, `open_time`, `close_time`, `is_closed`) VALUES
(1, 1, 'Monday', '10:00:00', '21:00:00', 0),
(2, 1, 'Tuesday', '10:00:00', '21:00:00', 0),
(3, 1, 'Wednesday', '10:00:00', '21:00:00', 0),
(4, 1, 'Thursday', '10:00:00', '22:00:00', 0),
(5, 1, 'Friday', '10:00:00', '23:00:00', 0),
(6, 1, 'Saturday', '11:00:00', '23:00:00', 0),
(7, 1, 'Sunday', '11:00:00', '20:00:00', 0),
(8, 2, 'Monday', '10:30:00', '21:00:00', 0),
(9, 2, 'Tuesday', '10:30:00', '21:00:00', 0),
(10, 2, 'Wednesday', '10:30:00', '21:00:00', 0),
(11, 3, 'Monday', '07:00:00', '18:00:00', 0),
(12, 3, 'Tuesday', '07:00:00', '18:00:00', 0),
(13, 4, 'Friday', '11:00:00', '23:30:00', 0),
(14, 5, 'Sunday', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `chain_id` int(11) NOT NULL,
  `street_address` varchar(150) NOT NULL,
  `city` varchar(80) NOT NULL,
  `state` char(2) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `chain_id`, `street_address`, `city`, `state`, `zip_code`, `phone`) VALUES
(1, 1, '120 Monument Circle', 'Indianapolis', 'IN', '46204', '317-555-1101'),
(2, 1, '8702 Keystone Crossing', 'Indianapolis', 'IN', '46240', '317-555-1102'),
(3, 2, '210 Mass Ave', 'Indianapolis', 'IN', '46204', '317-555-1201'),
(4, 3, '4801 E Washington St', 'Indianapolis', 'IN', '46201', '317-555-1301'),
(5, 4, '1450 E 86th St', 'Indianapolis', 'IN', '46240', '317-555-1401'),
(6, 5, '640 S Main St', 'Greenwood', 'IN', '46143', '317-555-1501');

-- --------------------------------------------------------

--
-- Table structure for table `location_amenities`
--

CREATE TABLE `location_amenities` (
  `location_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_amenities`
--

INSERT INTO `location_amenities` (`location_id`, `amenity_id`) VALUES
(1, 2),
(1, 3),
(1, 5),
(2, 1),
(2, 2),
(2, 4),
(3, 2),
(3, 3),
(4, 1),
(4, 5),
(5, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(75) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Appetizers', 'Small plates and starter items.'),
(2, 'Entrees', 'Main meals and featured dishes.'),
(3, 'Sides', 'Side items and add-ons.'),
(4, 'Drinks', 'Cold and hot beverages.'),
(5, 'Desserts', 'Sweet items served after a meal.');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `base_price` decimal(8,2) NOT NULL,
  `calories` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `category_id`, `item_name`, `description`, `base_price`, `calories`, `is_available`) VALUES
(1, 2, 'Classic Burger', 'Beef burger with lettuce, tomato, onion, and house sauce.', 9.99, 760, 1),
(2, 3, 'Crispy Fries', 'Golden fries seasoned with sea salt.', 3.50, 420, 1),
(3, 4, 'Fresh Lemonade', 'Cold lemonade made with lemon juice and cane sugar.', 2.99, 180, 1),
(4, 2, 'Garden Salad', 'Mixed greens with cucumber, tomato, carrots, and vinaigrette.', 7.50, 310, 1),
(5, 4, 'Iced Coffee', 'Cold brewed coffee served over ice.', 3.25, 90, 1),
(6, 2, 'Pepperoni Pizza', 'Personal pizza with pepperoni, mozzarella, and tomato sauce.', 11.99, 920, 1),
(7, 1, 'Garlic Knots', 'Baked dough knots brushed with garlic butter.', 4.99, 510, 1),
(8, 2, 'Chicken Tacos', 'Three chicken tacos with salsa, cilantro, and lime.', 10.50, 680, 1),
(9, 3, 'Chips and Salsa', 'Tortilla chips served with house salsa.', 3.99, 390, 1),
(10, 2, 'BBQ Chicken Sandwich', 'Grilled chicken sandwich with smoky barbecue sauce.', 11.50, 740, 1),
(11, 5, 'Chocolate Brownie', 'Warm chocolate brownie with chocolate drizzle.', 4.50, 460, 1),
(12, 4, 'Sparkling Water', 'Bottled sparkling water.', 2.25, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_chains`
--

CREATE TABLE `restaurant_chains` (
  `chain_id` int(11) NOT NULL,
  `chain_name` varchar(100) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_chains`
--

INSERT INTO `restaurant_chains` (`chain_id`, `chain_name`, `website_url`, `phone`, `description`) VALUES
(1, 'Crimson Grill', 'https://www.crimsongrill.example', '317-555-0101', 'Casual American grill with burgers, sandwiches, and salads.'),
(2, 'Union Cafe', 'https://www.unioncafe.example', '317-555-0102', 'Coffee shop and cafe serving breakfast, lunch, and drinks.'),
(3, 'Downtown Pizza Co.', 'https://www.downtownpizza.example', '317-555-0103', 'Pizza chain offering personal pizzas, pastas, and sides.'),
(4, 'Circle City Tacos', 'https://www.circlecitytacos.example', '317-555-0104', 'Fast casual taco restaurant with bowls, tacos, and chips.'),
(5, 'Hoosier BBQ House', 'https://www.hoosierbbq.example', '317-555-0105', 'Barbecue restaurant serving smoked meats and comfort sides.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`amenity_id`);

--
-- Indexes for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD PRIMARY KEY (`hours_id`),
  ADD UNIQUE KEY `uq_location_day` (`location_id`,`day_of_week`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `fk_locations_chain` (`chain_id`);

--
-- Indexes for table `location_amenities`
--
ALTER TABLE `location_amenities`
  ADD PRIMARY KEY (`location_id`,`amenity_id`),
  ADD KEY `fk_location_amenities_amenity` (`amenity_id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_menu_items_category` (`category_id`);

--
-- Indexes for table `restaurant_chains`
--
ALTER TABLE `restaurant_chains`
  ADD PRIMARY KEY (`chain_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `amenity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `business_hours`
--
ALTER TABLE `business_hours`
  MODIFY `hours_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `restaurant_chains`
--
ALTER TABLE `restaurant_chains`
  MODIFY `chain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD CONSTRAINT `fk_business_hours_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `fk_locations_chain` FOREIGN KEY (`chain_id`) REFERENCES `restaurant_chains` (`chain_id`) ON UPDATE CASCADE;

--
-- Constraints for table `location_amenities`
--
ALTER TABLE `location_amenities`
  ADD CONSTRAINT `fk_location_amenities_amenity` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`amenity_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_location_amenities_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu_items_category` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`category_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
