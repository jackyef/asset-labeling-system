-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2017 at 09:15 AM
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
-- Table structure for table `assembled_items`
--

CREATE TABLE `assembled_items` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `operating_system_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `first_sub_location_id` int(11) DEFAULT '0',
  `second_sub_location_id` int(11) DEFAULT '0',
  `employee_id` int(11) NOT NULL,
  `is_used` tinyint(4) NOT NULL,
  `note` text NOT NULL,
  `date_of_purchase` date NOT NULL,
  `warranty_expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assembled_items`
--

INSERT INTO `assembled_items` (`id`, `brand_id`, `product_name`, `supplier_id`, `company_id`, `operating_system_id`, `location_id`, `first_sub_location_id`, `second_sub_location_id`, `employee_id`, `is_used`, `note`, `date_of_purchase`, `warranty_expiry_date`) VALUES
(7, 7, 'Rakitan', 1, 3, 4, 2, 4, 0, 5, 1, '', '2016-03-29', '2016-04-29');

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
(7, 'Rakitan', 2),
(8, 'Dell', 2),
(9, 'Patriot', 9),
(10, 'Canon', 3),
(11, 'Seagate', 1),
(12, 'Canon', 10),
(13, 'Test Brand Edit', 1),
(14, 'Xiaomi', 13),
(15, 'Intel', 14),
(16, 'Razer', 7);

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
(3, 'PT. Panca Eka Bina Plywood Industry'),
(4, 'Test PT Edit 2'),
(5, 'Test 2 edit'),
(6, 'PT. Baruu');

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
(3, 'Budi', 2, 0, 1, 5, 4),
(4, 'Fired Employee', 1, 0, 0, 0, 0),
(5, 'Jacky Efendi', 3, 1, 2, 4, 0),
(6, 'Testing Employee w/ 1st sub location', 1, 0, 2, 1, 0),
(7, 'Testing Employee w/ 2nd sub location', 2, 0, 2, 1, 3),
(8, 'Testing Employee w/ no unknown location', 2, 0, 0, 0, 0),
(9, 'Testing not working employee', 1, 0, 0, 0, 0),
(10, 'Edit jadi company agro abadi2', 1, 1, 2, 2, 0),
(11, 'Chris Paul', 2, 1, 1, 5, 0),
(12, 'Test Karyawan Edit', 2, 0, 1, 5, 4),
(13, 'Test Karyawan 2 Edit', 5, 1, 1, 0, 0),
(14, 'Dhani Aditya', 3, 0, 2, 4, 0),
(15, 'Benny', 3, 1, 2, 4, 0),
(16, 'Gudang IT', 3, 1, 2, 4, 0);

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
(5, 'Gudang', 1),
(6, 'Test 1 Sub Edit', 3),
(7, 'Gudang Barang', 4),
(8, 'Lantai 5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `operating_system_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `first_sub_location_id` int(11) DEFAULT '0',
  `second_sub_location_id` int(11) DEFAULT '0',
  `assembled_item_id` int(11) DEFAULT '0',
  `employee_id` int(11) NOT NULL,
  `is_used` tinyint(4) NOT NULL,
  `note` text NOT NULL,
  `date_of_purchase` date NOT NULL,
  `warranty_expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `model_id`, `supplier_id`, `company_id`, `operating_system_id`, `location_id`, `first_sub_location_id`, `second_sub_location_id`, `assembled_item_id`, `employee_id`, `is_used`, `note`, `date_of_purchase`, `warranty_expiry_date`) VALUES
(1, 5, 2, 1, 0, 1, 5, 0, 0, 15, 1, '', '2017-03-29', '2017-03-29'),
(2, 7, 3, 3, 2, 2, 4, 0, 0, 5, 1, '', '2017-03-29', '2018-03-29'),
(3, 9, 6, 3, 0, 2, 4, 0, 0, 5, 1, '', '2017-03-29', '2018-03-29'),
(4, 1, 2, 1, 0, 2, 4, 0, 0, 16, 0, 'Stok', '2017-03-29', '2018-03-29'),
(5, 4, 7, 1, 0, 4, 7, 0, 0, 11, 1, 'HDD dibeli karena kebanyakan uang', '2016-03-08', '2018-04-08'),
(6, 5, 2, 2, 0, 2, 1, 0, 0, 3, 1, 'asdasdas', '2017-01-28', '2018-01-28'),
(8, 8, 1, 3, 0, 2, 4, 0, 7, 5, 1, '', '2016-03-29', '2016-04-29'),
(9, 3, 1, 3, 0, 2, 4, 0, 7, 5, 1, '', '2016-03-29', '2016-04-29'),
(10, 6, 1, 3, 0, 2, 4, 0, 7, 5, 1, '', '2016-03-29', '2016-04-29'),
(11, 2, 1, 3, 0, 2, 4, 0, 7, 5, 1, '', '2016-03-29', '2016-04-29');

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
(11, 'SSD', 0),
(12, 'Power Supply for CCTV', 0),
(13, 'Smartphone', 0),
(14, 'Processor', 0),
(15, 'CCTV', 0);

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
(2, 'HQ'),
(3, 'Test Lokasi Edit'),
(4, 'PT. Kampar Palma Utama');

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
(5, 'MG2570 Printer', '', '', 12),
(6, 'Test Model Edit', '256', 'GB', 11),
(7, 'Redmi 3 Pro 3GB/32GB', '5', 'Inch', 14),
(8, 'i7 2600k', '3.7', 'GHz', 15),
(9, 'Blackwidow RX', '', '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `mutations`
--

CREATE TABLE `mutations` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL COMMENT 'item_id that is shared between items and assembled_items',
  `prev_employee_id` int(11) DEFAULT '0' COMMENT 'allow 0 for first item assignment',
  `employee_id` int(11) NOT NULL,
  `prev_location_id` int(11) DEFAULT '0',
  `prev_first_sub_location_id` int(11) DEFAULT '0',
  `prev_second_sub_location_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `first_sub_location_id` int(11) DEFAULT '0',
  `second_sub_location_id` int(11) DEFAULT '0',
  `note` text NOT NULL,
  `mutation_status_id` int(11) NOT NULL,
  `mutation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mutations`
--

INSERT INTO `mutations` (`id`, `item_id`, `prev_employee_id`, `employee_id`, `prev_location_id`, `prev_first_sub_location_id`, `prev_second_sub_location_id`, `location_id`, `first_sub_location_id`, `second_sub_location_id`, `note`, `mutation_status_id`, `mutation_date`) VALUES
(1, 1, 0, 15, 0, 0, 0, 1, 5, 0, 'First item assignment', 0, '2017-03-29'),
(2, 2, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment', 0, '2017-03-29'),
(3, 3, 0, 14, 0, 0, 0, 1, 5, 0, 'First item assignment', 0, '2017-03-29'),
(4, 4, 0, 16, 0, 0, 0, 2, 4, 0, 'First item assignment', 0, '2017-03-29'),
(5, 5, 0, 11, 0, 0, 0, 4, 7, 0, 'First item assignment', 0, '2016-03-08'),
(6, 6, 0, 3, 0, 0, 0, 2, 1, 0, 'First item assignment', 0, '2017-01-28'),
(7, 3, 14, 5, 1, 5, 0, 2, 4, 0, 'Mutate ke jacky karena dhani resign', 2, '2017-03-29'),
(8, 7, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment', 0, '2016-03-29'),
(9, 8, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment. Part of assembled item [''Rakitan'']. id: 7', 0, '2016-03-29'),
(10, 9, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment. Part of assembled item [''Rakitan'']. id: 7', 0, '2016-03-29'),
(11, 10, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment. Part of assembled item [''Rakitan'']. id: 7', 0, '2016-03-29'),
(12, 11, 0, 5, 0, 0, 0, 2, 4, 0, 'First item assignment. Part of assembled item [''Rakitan'']. id: 7', 0, '2016-03-29'),
(13, 8, 5, 5, 2, 4, 0, 2, 4, 0, 'Removed from the assembled item with id: 7.', 0, '2017-03-29'),
(14, 8, 5, 5, 2, 4, 0, 2, 4, 0, 'Mutated to assemble the assembled item with id: 7.', 0, '2017-03-29');

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
-- Table structure for table `operating_systems`
--

CREATE TABLE `operating_systems` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operating_systems`
--

INSERT INTO `operating_systems` (`id`, `name`) VALUES
(1, 'Windows 7'),
(2, 'Android 5.0'),
(3, 'Android 6.0'),
(4, 'Windows 10 Enterprise'),
(5, 'Windows 8'),
(6, 'Windows XP'),
(7, 'Windows Vista');

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
(4, 'Section A', 5),
(5, 'Test 2 Sub Edit', 5),
(6, 'Section A', 7);

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
(3, 'Duta Ponsel'),
(4, 'Test Supplier Edit 123'),
(5, 'Test 2 edit'),
(6, 'Super Electronic'),
(7, 'Batam Elektronik');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'md5 hash',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(1, 'jacky', '923cfc18c91b6bb77f3c049ee98b6c44', 1),
(38, 'jacky2', '923cfc18c91b6bb77f3c049ee98b6c44', 1),
(39, 'jacky3', '923cfc18c91b6bb77f3c049ee98b6c44', 0),
(40, 'asdasd', 'a3dcb4d229de6fde0db5686dee47145d', 0),
(41, 'user123edit', 'f5bb0c8de146c67b44babbf4e6584cc0', 0),
(42, 'bukanadmin', '992baf4879618dbfb66e5786ebb3a923', 0),
(43, 'admin', '0192023a7bbd73250516f069df18b500', 1),
(44, 'jacky4', '923cfc18c91b6bb77f3c049ee98b6c44', 0),
(45, 'benny', 'a1c2de1cf95710041ddca199739f19da', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assembled_items`
--
ALTER TABLE `assembled_items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `items`
--
ALTER TABLE `items`
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
-- Indexes for table `mutations`
--
ALTER TABLE `mutations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mutation_statuses`
--
ALTER TABLE `mutation_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operating_systems`
--
ALTER TABLE `operating_systems`
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `first_sub_locations`
--
ALTER TABLE `first_sub_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `mutations`
--
ALTER TABLE `mutations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `mutation_statuses`
--
ALTER TABLE `mutation_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `operating_systems`
--
ALTER TABLE `operating_systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `second_sub_locations`
--
ALTER TABLE `second_sub_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
