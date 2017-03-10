-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2017 at 10:13 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `als_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `item_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `item_type_id`) VALUES
(1, 'Samsung', 1),
(2, 'Western Digital', 1),
(3, 'MSI', 4),
(4, 'Genius', 5),
(5, 'Logitech', 5),
(6, 'Logitech', 7),
(7, 'RAKITAN', 2),
(8, 'Dell', 2),
(9, 'Patriot', 9),
(10, 'Canon', 3),
(11, 'Seagate', 1),
(12, 'Canon', 10);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'PT. Agro Abadi'),
(2, 'PT. Aulia Seraya'),
(3, 'PT. Panca Eka Bina Plywood Industry');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `is_working` tinyint(4) NOT NULL,
  `location_id` int(11) DEFAULT '0',
  `first_sub_location_id` int(11) DEFAULT '0',
  `second_sub_location_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `company_id`, `is_working`, `location_id`, `first_sub_location_id`, `second_sub_location_id`) VALUES
(1, 'Jackson Vito W.', 2, 0, 2, 0, 0),
(3, 'Budi', 1, 1, 2, 3, 0),
(4, 'Fired Employee', 1, 0, 0, 0, 0),
(5, 'Jacky Efendi', 3, 0, 2, 0, 0),
(6, 'Testing Employee w/ 1st sub location', 1, 0, 2, 1, 0),
(7, 'Testing Employee w/ 2nd sub location', 2, 0, 2, 1, 3),
(8, 'Testing Employee w/ no unknown location', 2, 0, 0, 0, 0),
(9, 'Testing not working employee', 1, 0, 0, 0, 0),
(10, 'Testing working employee', 2, 1, 2, 4, 2),
(11, 'Chris Paul', 2, 1, 1, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `first_sub_locations`
--

CREATE TABLE `first_sub_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `first_sub_locations`
--

INSERT INTO `first_sub_locations` (`id`, `name`, `location_id`) VALUES
(1, 'Lantai 1', 2),
(2, 'Lantai 2', 2),
(3, 'Lantai 3', 2),
(4, 'Lantai 4', 2),
(5, 'Gudang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_assembled` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`id`, `name`, `is_assembled`) VALUES
(1, 'HDD', 0),
(2, 'Desktop', 1),
(3, 'Printer', 1),
(4, 'VGA', 0),
(5, 'Mouse', 0),
(6, 'Wireless Mouse', 0),
(7, 'Keyboard', 0),
(8, 'Wireless Keyboard', 0),
(9, 'Memory', 0),
(10, 'Device Driver', 0),
(11, 'SSD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'PKS Agro Abadi'),
(2, 'HQ');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity_size` varchar(20) NOT NULL DEFAULT 'N/A',
  `units` varchar(255) NOT NULL DEFAULT 'N/A',
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `capacity_size`, `units`, `brand_id`) VALUES
(1, 'P7XL-995', '500', 'GB', 1),
(2, '830', '512', 'GB', 1),
(3, 'Viper-DDR3', '8', 'GB', 9),
(4, 'My Passport Green', '4', 'TB', 2),
(5, 'MG2570 Printer', '', '', 12);

-- --------------------------------------------------------

--
-- Table structure for table `mutation_statuses`
--

CREATE TABLE `mutation_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutation_statuses`
--

INSERT INTO `mutation_statuses` (`id`, `name`) VALUES
(1, 'On Delivery'),
(2, 'Received'),
(3, 'Service');

-- --------------------------------------------------------

--
-- Table structure for table `second_sub_locations`
--

CREATE TABLE `second_sub_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_sub_location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `second_sub_locations`
--

INSERT INTO `second_sub_locations` (`id`, `name`, `first_sub_location_id`) VALUES
(1, 'Divisi IT', 4),
(2, 'Divisi Accounting', 4),
(3, 'Resepsionis', 1),
(4, 'Section A', 5);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`) VALUES
(1, 'Flazz Computer'),
(2, 'CV. Disney Komp'),
(3, 'Duta Ponsel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `first_sub_locations`
--
ALTER TABLE `first_sub_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutation_statuses`
--
ALTER TABLE `mutation_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `second_sub_locations`
--
ALTER TABLE `second_sub_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `first_sub_locations`
--
ALTER TABLE `first_sub_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mutation_statuses`
--
ALTER TABLE `mutation_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `second_sub_locations`
--
ALTER TABLE `second_sub_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
