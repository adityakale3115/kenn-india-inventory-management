-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 06:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kennindia`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_of_materials`
--

CREATE TABLE `bill_of_materials` (
  `bom_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `item_no` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `part_no` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `moc` varchar(100) NOT NULL,
  `finish_material_size` varchar(100) NOT NULL,
  `finish_material_weight` varchar(50) NOT NULL,
  `total_quantity` varchar(50) NOT NULL,
  `remark_1` varchar(255) DEFAULT NULL,
  `remark_2` varchar(255) DEFAULT NULL,
  `remark_3` varchar(255) DEFAULT NULL,
  `remark_4` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_of_materials`
--

INSERT INTO `bill_of_materials` (`bom_id`, `machine_id`, `item_no`, `quantity`, `part_no`, `description`, `moc`, `finish_material_size`, `finish_material_weight`, `total_quantity`, `remark_1`, `remark_2`, `remark_3`, `remark_4`, `created_at`, `updated_at`) VALUES
(4, 9, 'aasa', 21, '2121', 'sdsadaasdad', 'sdads', '23', '12', '12', 'wd', NULL, NULL, NULL, '2024-12-15 07:51:11', '2024-12-15 07:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

CREATE TABLE `bom` (
  `id` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `part_no` varchar(255) NOT NULL,
  `hierarchy_level` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `finish_material_size` varchar(255) DEFAULT NULL,
  `finish_material_weight` varchar(255) DEFAULT NULL,
  `remark1` varchar(255) DEFAULT NULL,
  `remark2` varchar(255) DEFAULT NULL,
  `remark3` varchar(255) DEFAULT NULL,
  `remark4` varchar(255) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`id`, `item_no`, `quantity`, `part_no`, `hierarchy_level`, `description`, `material`, `finish_material_size`, `finish_material_weight`, `remark1`, `remark2`, `remark3`, `remark4`, `total_quantity`) VALUES
(1, 1, 1, 'KSM010_010', 0, 'djiwdhi', 'MSasst', 'SQ Pipe', '22421', NULL, NULL, NULL, NULL, 0),
(2, 0, 2, 'KSM010_202', 0, 'newin', ',dowkdo', 'mojdom', 'kmwdm', NULL, NULL, NULL, NULL, 0),
(3, 0, 3, ' KSM212_303', 0, 'cmosm', 'msmiow', 'indn', '46', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `boughtout_items`
--

CREATE TABLE `boughtout_items` (
  `item_id` varchar(50) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `vendor_rating` int(11) DEFAULT NULL CHECK (`vendor_rating` between 1 and 5),
  `delivery_time` varchar(50) NOT NULL,
  `specifications` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boughtout_items`
--

INSERT INTO `boughtout_items` (`item_id`, `item_name`, `vendor_rating`, `delivery_time`, `specifications`, `created_at`) VALUES
('AB01', 'Sand', 5, '30 Days', '', '2024-12-13 21:41:17'),
('AB02', 'Rock', 3, '1 Day', 'Good', '2024-12-13 21:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gst_no` varchar(15) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `whatsapp_number` varchar(15) NOT NULL,
  `pan_no` varchar(10) NOT NULL,
  `payment_terms` enum('30 Days','60 Days','90 Days','Customized') NOT NULL,
  `custom_payment_terms` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `company_name`, `address`, `gst_no`, `contact_name`, `designation`, `email`, `whatsapp_number`, `pan_no`, `payment_terms`, `custom_payment_terms`, `created_at`, `updated_at`) VALUES
(6, 'PQR Electronics', 'Testing Address', '123456789456123', 'Contact Name', 'Manager', 'aditya.kale0405@gmail.com', '8766015040', 'AC21453687', '90 Days', '10 Days', '2024-12-07 07:38:31', '2024-12-07 08:37:20'),
(16, 'ABCD', 'Aurangabad,Maharashtra', 'MYGST123456789', 'Aditya , Pranav', 'Employee , Manager', 'aditya.kale23@vit.edu', '8766015040', 'MYPAN09876', '', '25 Days', '2024-12-14 07:41:56', '2024-12-14 07:41:56'),
(17, 'XYZ', 'India', 'GSTIN12321456', 'abc , pqr', 'xyz , lmn', 'customer@email.com', '74563021589', 'PANIN32542', '', '50 Days', '2024-12-14 18:06:22', '2024-12-14 18:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility_name`) VALUES
(5, 'Example'),
(2, 'Hardening'),
(1, 'Melting'),
(3, 'Sample'),
(4, 'Softening');

-- --------------------------------------------------------

--
-- Table structure for table `hardware_items`
--

CREATE TABLE `hardware_items` (
  `item_id` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `vendor_rating` int(11) NOT NULL,
  `delivery_time` varchar(255) NOT NULL,
  `specifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hardware_items`
--

INSERT INTO `hardware_items` (`item_id`, `item_name`, `vendor_rating`, `delivery_time`, `specifications`) VALUES
('0001', 'xyz', 4, '32 min', 'Good'),
('0002', 'abcc', 2, '20 Days', 'Noice');

-- --------------------------------------------------------

--
-- Table structure for table `item_hardware_vendors`
--

CREATE TABLE `item_hardware_vendors` (
  `item_id` varchar(255) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_hardware_vendors`
--

INSERT INTO `item_hardware_vendors` (`item_id`, `vendor_id`, `price`) VALUES
('0001', 2, 70),
('0001', 6, 20),
('0002', 7, 50),
('0002', 8, 100);

-- --------------------------------------------------------

--
-- Table structure for table `item_vendors`
--

CREATE TABLE `item_vendors` (
  `id` int(11) NOT NULL,
  `item_id` varchar(50) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_vendors`
--

INSERT INTO `item_vendors` (`id`, `item_id`, `vendor_id`, `price`) VALUES
(3, 'AB02', 7, 122.00),
(4, 'AB02', 8, 122.00),
(5, 'AB01', 7, 100.00),
(6, 'AB01', 6, 200.00),
(7, 'AB01', 2, 300.00),
(8, 'AB01', 8, 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `machine_id` int(11) NOT NULL,
  `machine_photo` varchar(255) NOT NULL,
  `machine_name` varchar(255) NOT NULL,
  `machine_no` varchar(100) NOT NULL,
  `remark1` varchar(255) DEFAULT NULL,
  `remark2` varchar(255) DEFAULT NULL,
  `remark3` varchar(255) DEFAULT NULL,
  `remark4` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`machine_id`, `machine_photo`, `machine_name`, `machine_no`, `remark1`, `remark2`, `remark3`, `remark4`) VALUES
(9, '../img/Pad-Printing-Machine.webp', 'Machine 1', '010', 'ok', 'ok', 'ok', 'ok'),
(10, '../img/Pad-Printing-Machine.webp', 'Machine 2', '', 'Good', 'good', 'good', 'good'),
(12, '../img/download__5_-removebg-preview.png', 'Machine 3 ', '08', 'test', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `material_type` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `order_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `remark_1` text DEFAULT NULL,
  `remark_2` text DEFAULT NULL,
  `remark_3` text DEFAULT NULL,
  `remark_4` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `material_type`, `section`, `size`, `vendor_name`, `order_date`, `price`, `remark_1`, `remark_2`, `remark_3`, `remark_4`) VALUES
(1, 'Aluminium Pipe', 'Mild Steel - Bright', 'Round Pipe Section', '200x100', 'JVG Digitech', '2024-12-19', 5000.00, 'Good', 'Working', 'Smooth', 'remake'),
(5, 'Steel Rod', 'SS', 'Round Section', '200x100', 'JVG Digitech', '2024-12-12', 100.00, 'Remakr', 'No Remakrk', '', ''),
(8, 'Material 1', 'Material Type Here', 'Sample Section', '100x200', 'Sample Vendor', '2024-12-18', 500.00, '', '', '', ''),
(9, 'hgygyg', 'Mild Steel - Bright', 'Round Pipe Section', '500x300x200', 'Aditya', '2025-01-17', 54654.00, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `part_id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `drawing_number` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `surface_finish` varchar(50) NOT NULL,
  `hardening` varchar(50) NOT NULL,
  `machine` varchar(255) NOT NULL,
  `assembly_date` date NOT NULL,
  `part_weight` float NOT NULL,
  `expected_costing` decimal(10,2) NOT NULL,
  `delivery_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`part_id`, `part_name`, `drawing_number`, `description`, `surface_finish`, `hardening`, `machine`, `assembly_date`, `part_weight`, `expected_costing`, `delivery_time`) VALUES
(3, 'Screws', '14563', 'Heavy-duty gear for industrial machines', 'Plated', 'Harden', 'Lathe machine', '2024-12-17', 20, 1000.00, '2 Weeks'),
(5, 'Sample', '12345', 'desc', 'Painted', 'Toughen', 'Lathe machine', '2024-12-16', 20, 10000.00, '30 Days'),
(6, 'Gear', '1478', 'qqqq', 'Finished', 'ddd', 'Lathe machine', '2024-12-18', 20, 555.00, '23 Days'),
(7, 'a', '147852', 'ggggggg', 'Plated', 'Harden', 'Lathe machine', '2025-01-03', 2, 20.00, '1 Day');

-- --------------------------------------------------------

--
-- Table structure for table `part_materials`
--

CREATE TABLE `part_materials` (
  `part_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `part_materials`
--

INSERT INTO `part_materials` (`part_id`, `material_id`) VALUES
(3, 1),
(5, 5),
(6, 5),
(6, 8),
(7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `part_vendors`
--

CREATE TABLE `part_vendors` (
  `part_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `part_vendors`
--

INSERT INTO `part_vendors` (`part_id`, `vendor_id`, `price`) VALUES
(3, 2, 100.00),
(3, 6, 100.00),
(3, 7, 100.00),
(5, 2, 25.00),
(5, 6, 25.00),
(6, 6, 20.00),
(7, 7, 10.00),
(7, 8, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `project_master`
--

CREATE TABLE `project_master` (
  `project_number` int(11) NOT NULL,
  `machine_name` varchar(255) NOT NULL,
  `machine_specification` text NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `advanced_amount_received` decimal(10,2) NOT NULL,
  `advanced_amount_date` date NOT NULL,
  `packing_forwarding` varchar(255) NOT NULL,
  `freight` varchar(255) NOT NULL,
  `expected_delivery_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_master`
--

INSERT INTO `project_master` (`project_number`, `machine_name`, `machine_specification`, `customer_name`, `order_date`, `advanced_amount_received`, `advanced_amount_date`, `packing_forwarding`, `freight`, `expected_delivery_date`) VALUES
(1, 'Lathe Machine', 'Key: Key, Speed: 200 RPM', 'PQR Electronics', '2024-12-06', 40000.00, '2024-12-05', 'Included - 5%', 'Included', '2024-12-31'),
(5, 'CNC Machine', 'Key: Rotatation, Speed: 200 per min', 'PQR Electronics', '2024-12-14', 10000.00, '2024-12-14', 'Included - 5%', 'Extra (Customer Pays)', '2024-12-20'),
(6, 'Machine 1', 'Key: Motor, Speed: 30 Rotation Per Min', 'PQR Electronics', '2024-12-15', 5000.00, '2024-12-17', 'Extra - 10% Included', 'Extra (Customer Pays)', '2024-12-31'),
(8, 'Machine 3 ', 'Key: Key: This is good, , Speed: 200', 'ABCD', '2024-12-19', 1.00, '2025-01-03', 'Extra - 10% Included', 'Extra (Customer Pays)', '2024-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `vendors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`vendors`)),
  `po_number` varchar(255) NOT NULL,
  `parts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`parts`)),
  `file_path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `vendors`, `po_number`, `parts`, `file_path`, `created_at`) VALUES
(2, '[\"Aditya\"]', 'PO-67775D50D892C', '[\"KSM010_01\",\"    KSM010_01_01\",\"      KSM010_01_01_01\"]', 'E:\\xampp\\htdocs\\kennindia/generated_docs/Purchase_Order_1735875920.docx', '2025-01-03 09:15:20'),
(3, '[\"JVG Digitech\"]', 'PO-67776436BFDA0', '[\"       KSM010_02A_03\",\"       KSM010_02A_03\"]', 'E:\\xampp\\htdocs\\kennindia/generated_docs/Purchase_Order_1735877686.docx', '2025-01-03 09:44:46'),
(4, '[\"Aditya\"]', 'PO-677D2CF4BD455', '[\"KSM010_01\",\"      KSM010_01_01_01\"]', 'E:\\xampp\\htdocs\\kennindia/generated_docs/Purchase_Order_1736256756.docx', '2025-01-07 19:02:36'),
(5, '[\"Aditya\"]', 'PO-678BE98139C77', '[\"KSM010_01\",\"    KSM010_01_01\"]', 'E:\\xampp\\htdocs\\kennindia/generated_docs/Purchase_Order_1737222531.docx', '2025-01-18 23:18:53'),
(6, '[\"Aditya\"]', 'PO-678BE9843224F', '[\"KSM010_01\",\"    KSM010_01_01\"]', 'E:\\xampp\\htdocs\\kennindia/generated_docs/Purchase_Order_1737222532.docx', '2025-01-18 23:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `gst_no` varchar(15) DEFAULT NULL,
  `pan_number` varchar(10) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(15) DEFAULT NULL,
  `facilities` varchar(500) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `custom_payment_terms` varchar(225) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `pricing_rating` decimal(3,2) DEFAULT NULL CHECK (`pricing_rating` between 1 and 5),
  `quality_rating` decimal(3,2) DEFAULT NULL CHECK (`quality_rating` between 1 and 5),
  `delivery_rating` decimal(3,2) DEFAULT NULL CHECK (`delivery_rating` between 1 and 5),
  `precision_rating` decimal(3,2) DEFAULT NULL CHECK (`precision_rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor_name`, `address`, `gst_no`, `pan_number`, `contact_number`, `email`, `whatsapp_number`, `facilities`, `payment_terms`, `custom_payment_terms`, `rating`, `pricing_rating`, `quality_rating`, `delivery_rating`, `precision_rating`, `created_at`) VALUES
(2, 'Kenn India', 'Mumbai,Maharashtra', '1254789630', 'PAN2131415', '100000000', 'aditya@vit', '8766014050', 'Melting,Sample', NULL, '', NULL, 1.00, 1.00, 1.00, 1.00, '2024-12-10 06:37:35'),
(6, 'JVG Digitech', 'Mumbai,Maharashtra', 'UNIQUEGST1234', 'UNIQUEPAN1', '7020036200', 'jvg@email.com', '78786543211', 'Melting,Sample,Softening', '60 Days', '', NULL, 4.00, 5.00, 5.00, 5.00, '2024-12-10 07:53:03'),
(7, 'Aditya', 'Plot No 78 Beed By Pass Aurangabad Maharashtra', 'MYGST31157849', 'MYPAN31157', '8766015040', 'aditya.kale0405@gmail.com', '8766014050', 'Hardening,Sample', '10 Days', '10 Days', NULL, 3.00, 3.00, 3.00, 3.00, '2024-12-11 06:14:48'),
(8, 'Pranav', 'Aurangabad', 'GSTNO2323', 'PANNO98765', '9096321457', 'pranav@sangave.com', '1234567890', 'Melting,Sample', '30 Days', '', NULL, 2.00, 2.00, 2.00, 2.00, '2024-12-13 14:35:52'),
(9, 'Sample Vendor', 'India', 'GST6325522656', 'PAN2131412', '8459697794', 'vendor@email.com', '8459697794', 'Example,Hardening,Melting', '25 Days', '25 Days', NULL, 2.00, 3.00, 1.00, 4.00, '2024-12-14 18:04:47'),
(10, 'Vendor', 'diwsdhi', 'GST4444444', 'PANNO56466', '87453684465', 'aditya.kale23@vit.edu', '8766015040', 'Hardening,Melting', '10 Days', '10 Days', NULL, 1.00, 1.00, 1.00, 1.00, '2024-12-18 17:03:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_of_materials`
--
ALTER TABLE `bill_of_materials`
  ADD PRIMARY KEY (`bom_id`),
  ADD KEY `fk_machine_id` (`machine_id`);

--
-- Indexes for table `bom`
--
ALTER TABLE `bom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boughtout_items`
--
ALTER TABLE `boughtout_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `gst_no` (`gst_no`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pan_no` (`pan_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`),
  ADD UNIQUE KEY `facility_name` (`facility_name`);

--
-- Indexes for table `hardware_items`
--
ALTER TABLE `hardware_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_hardware_vendors`
--
ALTER TABLE `item_hardware_vendors`
  ADD PRIMARY KEY (`item_id`,`vendor_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `item_vendors`
--
ALTER TABLE `item_vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `vendor_name` (`vendor_name`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `part_materials`
--
ALTER TABLE `part_materials`
  ADD PRIMARY KEY (`part_id`,`material_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `part_vendors`
--
ALTER TABLE `part_vendors`
  ADD PRIMARY KEY (`part_id`,`vendor_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `project_master`
--
ALTER TABLE `project_master`
  ADD PRIMARY KEY (`project_number`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`),
  ADD UNIQUE KEY `vendor_name` (`vendor_name`),
  ADD UNIQUE KEY `vendor_name_2` (`vendor_name`),
  ADD UNIQUE KEY `gst_no` (`gst_no`),
  ADD UNIQUE KEY `pan_number` (`pan_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_of_materials`
--
ALTER TABLE `bill_of_materials`
  MODIFY `bom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bom`
--
ALTER TABLE `bom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_vendors`
--
ALTER TABLE `item_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project_master`
--
ALTER TABLE `project_master`
  MODIFY `project_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill_of_materials`
--
ALTER TABLE `bill_of_materials`
  ADD CONSTRAINT `bill_of_materials_ibfk_1` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_machine_id` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_hardware_vendors`
--
ALTER TABLE `item_hardware_vendors`
  ADD CONSTRAINT `item_hardware_vendors_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `hardware_items` (`item_id`),
  ADD CONSTRAINT `item_hardware_vendors_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`);

--
-- Constraints for table `item_vendors`
--
ALTER TABLE `item_vendors`
  ADD CONSTRAINT `item_vendors_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `boughtout_items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_vendors_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`vendor_name`) REFERENCES `vendors` (`vendor_name`) ON DELETE CASCADE;

--
-- Constraints for table `part_materials`
--
ALTER TABLE `part_materials`
  ADD CONSTRAINT `part_materials_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `parts` (`part_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `part_materials_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`) ON DELETE CASCADE;

--
-- Constraints for table `part_vendors`
--
ALTER TABLE `part_vendors`
  ADD CONSTRAINT `part_vendors_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `parts` (`part_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `part_vendors_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
