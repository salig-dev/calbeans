-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 11:28 AM
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
-- Database: `rposystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `rpos_admin`
--

CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_admin`
--

INSERT INTO `rpos_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'System Admin', 'admin@mail.com', '036d0ef7567a20b5a4ad24a354ea4a945ddab676');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_customers`
--

CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_customers`
--

INSERT INTO `rpos_customers` (`customer_id`, `customer_name`, `customer_phoneno`, `customer_email`, `customer_password`, `created_at`) VALUES
('044bdfae8bed', 'Sample Customer', '09123456788', 'customer@mail.com', 'c2878c9008b74f48f39c702251c1f00c802e3f11', '2023-05-31 09:24:32.492437');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_orders`
--

CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_orders`
--

INSERT INTO `rpos_orders` (`order_id`, `order_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`, `order_status`, `created_at`) VALUES
('a6394af5f9', 'XKTS-4253', '044bdfae8bed', 'Sample Customer', '108933eeb7                      ', 'Tea (Green or Black) 12oz|Hot                      ', '50.00', '1', '', '2023-05-31 09:24:59.138920');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_pass_resets`
--

CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rpos_payments`
--

CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rpos_products`
--

CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_code` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `prod_category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_products`
--

INSERT INTO `rpos_products` (`prod_id`, `prod_code`, `prod_name`, `prod_img`, `prod_desc`, `prod_price`, `created_at`, `prod_category`) VALUES
('066614cccc', 'FEIP-2710', 'Carbonara', '', 'Creamy sauce infused with bacon, a luscious Italian pasta favorite.', '100.00', '2023-05-29 12:30:52.071873', 'Pasta'),
('06dc36c1be', 'FCWU-5762', 'Americano (8oz|Hot/Cold)', '', 'Bold, robust Americano: a classic black coffee with a kick.', '69.00', '2023-05-29 12:52:02.188823', 'Espresso'),
('0acceb7064', 'OECH-1420', 'Sausage Sandwich', '', 'Juicy, flavorful sausage in a toasted bun—satisfying and savory.', '80.00', '2023-05-29 12:24:34.503281', 'Sandwich'),
('0c0a277431', 'ZLDP-0946', '500g Unconditional Sweetness of Mocha (arabica, robusta)', '', 'A harmonious blend of rich chocolate and aromatic coffee beans.', '290.00', '2023-05-29 12:36:29.327879', 'Coffee Beans / Ground'),
('0c4b5c0604', 'JRZN-9518', 'Cortado (12oz|Hot)', '', 'Smooth, balanced cortado: a harmonious blend of espresso and milk.', '95.00', '2023-05-29 12:53:02.343827', 'Espresso'),
('108933eeb7', 'MNZX-2768', 'Tea (Green or Black) 12oz|Hot', '', 'Aromatic and soothing brew for moments of relaxation and refreshment.', '50.00', '2023-05-29 13:01:32.607979', 'Non-Coffee Drinks\n'),
('14c7b6370e', 'QZHM-0391', 'Mocha (12oz|Hot)', '', 'Indulgent mocha magic: espresso meets chocolate for pure bliss.', '95.00', '2023-05-29 12:53:46.394941', 'Espresso'),
('194d986f01', 'PBEV-1456', 'Pesto', '', 'Fragrant basil, garlic, and pine nut sauce elevate any pasta.', '100.00', '2023-05-29 12:30:36.946584', 'Pasta'),
('1e0fa41eee', 'ICFU-1406', 'Mocha (16oz|Cold)', '', 'Indulgent mocha magic: espresso meets chocolate for pure bliss.', '100.00', '2023-05-29 12:53:48.759629', 'Espresso'),
('26a71f2775', 'EWIC-4967', '1000g Total Dark roast Barako (excelsa)', '', 'Intensely flavorful barako coffee grounds for a bold morning brew.', '290.00', '2023-05-29 12:35:18.024442', 'Coffee Beans / Ground'),
('27ab65b2b4', 'LVCB-1093', 'Tuna Sandwich', '', 'Savor our irresistible tuna sandwich: Fresh, flavorful, and satisfying.', '80.00', '2023-05-29 12:23:58.243563', 'Sandwich'),
('2b976e49a0', 'CEWV-9438', 'Caramel Macchiato * (12oz|Hot)', '', 'Caramel Macchiato: luscious espresso delight with a caramel swirl.', '100.00', '2023-05-29 12:52:33.179212', 'Espresso'),
('2fdec9bdfb', 'UJAK-9614', 'Caramel Macchiato * (16oz|Cold)', '', 'Caramel Macchiato: luscious espresso delight with a caramel swirl.', '120.00', '2023-05-29 12:52:35.330160', 'Espresso'),
('31dfcc94cf', 'SYQP-3710', 'Latte (12oz|Hot)', '', 'Creamy, velvety latte: espresso perfection with a frothy milk embrace.', '89.00', '2023-05-29 12:53:27.007230', 'Espresso'),
('3757db9c24', 'IXKM-2594', '500g Limited Premium Sagado Besao (arabica)', '', 'Distinctively smooth and earthy coffee from the highlands of Sagada.', '650.00', '2023-05-29 12:35:10.043815', 'Coffee Beans / Ground'),
('3adfdee116', 'HIPF-5346', 'Latte (16oz|Cold)', '', 'Creamy, velvety latte: espresso perfection with a frothy milk embrace.', '95.00', '2023-05-29 12:53:24.481136', 'Espresso'),
('3d19e0bf27', 'EMBH-6714', 'Affogato (8oz|Hot/Cold)', '', 'Decadent affogato: espresso poured over creamy gelato for pure indulgence.', '90.00', '2023-05-29 12:51:56.830592', 'Espresso'),
('3ea71f32b6', 'SKPY-7285', '1000g Irresistible taste of Vanilla (arabica, robusta)', '', 'Smooth and aromatic vanilla-infused coffee grounds for a delightful cup.', '580.00', '2023-05-29 12:35:14.915577', 'Coffee Beans / Ground'),
('4c15f296c2', 'KRJC-3085', '500g Total Dark roast Barako (excelsa)', '', 'Intensely flavorful barako coffee grounds for a bold morning brew.', '250.00', '2023-05-29 12:36:24.749901', 'Coffee Beans / Ground'),
('4e68e0dd49', 'QLKW-0914', 'Choco Macchiato * (12oz|Hot)', '', 'Decadent chocolate-infused espresso topped with velvety milk foam.', '100.00', '2023-05-29 12:52:47.788299', 'Espresso'),
('5d374a39a5', 'AHUF-0428', 'Choco Bun', '', 'Decadent chocolate-filled bun, a blissful treat for chocolate enthusiasts.', '70.00', '2023-05-29 12:24:23.362790', 'Sandwich'),
('5d66c79953', 'GOEW-9248', 'Choco Macchiato * (16oz|Cold)', '', 'Decadent chocolate-infused espresso topped with velvety milk foam.', '120.00', '2023-05-29 12:52:50.235127', 'Espresso'),
('6728b551b6', 'CWXN-6734', '250g Limited Premium Sagado Besao (arabica)', '', 'Distinctively smooth and earthy coffee from the highlands of Sagada.', '330.00', '2023-05-29 12:35:06.635083', 'Coffee Beans / Ground'),
('6b9f4855d7', 'QPJX-1679', 'Choco (16oz|Cold)', '', 'Decadent and rich cocoa indulgence, crafted to satisfy chocolate lovers.', '95.00', '2023-05-29 12:33:14.952418', 'Espresso'),
('6d24e7448b', 'YMEJ-7285', 'Calbeans\' Cookie', '', 'Freshly baked cookies: warm, gooey perfection with every delicious bite.', '40.00', '2023-05-29 12:28:31.661888', 'Pastries'),
('6dfccfd66c', 'EDZK-5394', 'Choco (12oz|Hot)', '', 'Decadent and rich cocoa indulgence, crafted to satisfy chocolate lovers.', '65.00', '2023-05-29 12:33:13.006755', 'Espresso'),
('7d19b156ab', 'ZGSD-7918', 'Cream Cheese Bun', '', 'Creamy, indulgent, and irresistible cream cheese filling in a soft bun.', '80.00', '2023-05-29 12:24:12.138586', 'Sandwich'),
('8149a695a0', 'MDQV-0921', 'Matcha Cream (12oz|Hot)', '', 'A satisfying blend of milky cream goodness and Matcha powder.', '90.00', '2023-05-29 12:33:26.055228', 'Non-Coffee Drinks'),
('826e6f687f', 'AYFW-2683', 'Matcha Macchiato * (12oz|Hot)', '', 'A pleasing combination of Matcha and local espresso latte.', '120.00', '2023-05-29 12:32:19.124802', 'Espresso'),
('86176db9d7', 'NQKP-6857', '500g Perseverance of the aromatic Hazelnut (arabica, robusta)', '', 'Rich and nutty hazelnut-infused coffee grounds for a delightful brew.', '290.00', '2023-05-29 12:35:03.523215', 'Coffee Beans / Ground'),
('9049286d19', 'GSFJ-2017', 'Nachos', '', 'Savory nacho delight: crispy chips layered with cheesy goodness.', '65.00', '2023-05-29 12:31:06.620599', 'Starters'),
('91bd273ef5', 'WZPV-7930', 'Matcha Cream (16oz|Cold)', '', 'A satisfying blend of milky cream goodness and Matcha powder.', '105.00', '2023-05-29 12:53:33.721270', 'Espresso'),
('97972e8d63', 'CVWJ-6492', 'Matcha Macchiato * (16oz|Cold)', '', 'A pleasing combination of Matcha and local espresso latte.', '120.00', '2023-05-29 12:32:21.766721', 'Espresso'),
('9ab8f0ffe9', 'IDRZ-9401', '1000g Limited Premium Sagado Besao (arabica)', '', 'Distinctively smooth and earthy coffee from the highlands of Sagada.', '1,300.00', '2023-05-29 12:34:55.764572', 'Coffee Beans / Ground'),
('a419f2ef1c', 'EPNX-3728', 'Vanilla (12oz|Hot)', '', 'Smooth and aromatic vanilla blend that delights the senses.', '69.00', '2023-05-29 12:14:48.751530', 'Fresh Black Coffee/Cold Brew'),
('a585503287', 'AHSN-0879', '1000g Unconditional Sweetness of Mocha (arabica, robusta)', '', 'A harmonious blend of rich chocolate and aromatic coffee beans.', '580.00', '2023-05-29 12:34:58.898326', 'Coffee Beans / Ground'),
('a5931158fe', 'ELQN-5204', 'Vanilla (16oz|Cold)', '', 'Smooth and aromatic vanilla blend that delights the senses.', '100.00', '2023-05-29 12:14:45.573342', 'Fresh Black Coffee/Cold Brew'),
('a64b338943', 'TYFA-1628', 'Red Pasta', '', 'Rich tomato sauce with perfectly cooked noodles—a flavorful delight', '100.00', '2023-05-29 12:30:15.782260', 'Pasta'),
('b2f9c250fd', 'XNWR-2768', 'Hazelnut * (12oz|Hot)', '', 'Rich and nutty indulgence with a hint of toasted sweetness.', '69.00', '2023-05-29 12:15:34.690251', 'Fresh Black Coffee/Cold Brew'),
('b431559811', 'ENTZ-1567', 'Banana Cake', '', 'Moist banana bliss: a slice of tropical sweetness awaits you.', '45.00', '2023-05-29 12:29:39.171508', 'Pastries'),
('bb9c2e17a4', 'EQOG-4531', '250g Unconditional Sweetness of Mocha (arabica, robusta)', '', 'A harmonious blend of rich chocolate and aromatic coffee beans.', '150.00', '2023-05-29 12:34:53.226143', 'Coffee Beans / Ground'),
('bd200ef837', 'HEIY-6034', 'Hazelnut * (16oz|Cold)', '', 'Rich and nutty indulgence with a hint of toasted sweetness.', '100.00', '2023-05-29 12:15:32.821034', 'Fresh Black Coffee/Cold Brew'),
('cc992bce1e', 'HOFR-6492', '250g Irresistible taste of Vanilla (arabica, robusta)', '', 'Smooth and aromatic vanilla-infused coffee grounds for a delightful cup.', '150.00', '2023-05-29 12:35:20.885536', 'Coffee Beans / Ground'),
('cfe50ed94d', 'FEAZ-9625', 'Matcha Banana Smoothie (16oz|Cold)', '', 'A refreshing fusion of fresh banana and milky matcha.', '115.00', '2023-05-29 12:54:10.621889', 'Non-Coffee Drinks'),
('cff0cb495a', 'ZOBW-2640', 'Vietnamese (12oz|Hot)', '', 'Bold and vibrant blend with a touch of exotic flair.', '69.00', '2023-05-29 12:14:39.411636', 'Fresh Black Coffee/Cold Brew'),
('d186da4199', 'JPOK-7139', '250g Total Dark roast Barako (excelsa)', '', 'Intensely flavorful barako coffee grounds for a bold morning brew.', '130.00', '2023-05-29 12:35:22.479663', 'Coffee Beans / Ground'),
('d217b0f20f', 'FTGL-9651', '500g Irresistible taste of Vanilla (arabica, robusta)', '', 'Smooth and aromatic vanilla-infused coffee grounds for a delightful cup.', '290.00', '2023-05-29 12:35:25.562290', 'Coffee Beans / Ground'),
('d57cd89073', 'ZGQW-9480', 'Vietnamese (16oz|Cold)', '', 'Bold and vibrant blend with a touch of exotic flair.', '100.00', '2023-05-29 12:14:34.522752', 'Fresh Black Coffee/Cold Brew'),
('d9aed17627', 'FIKD-9703', 'Irish Cream (12oz|Hot)', '', 'Velvety smooth blend with the enchanting flavors of Irish cream.', '69.00', '2023-05-29 12:15:08.695029', 'Fresh Black Coffee/Cold Brew'),
('db5206ee2c', 'HNQD-0987', 'Cheesecake', '', 'Sinfully smooth cheesecake: a divine treat for coffee enthusiasts.', '110.00', '2023-05-29 12:28:21.423241', 'Pastries'),
('e2195f8190', 'HKCR-2178', 'Irish Cream (16oz|Cold)', '', 'Velvety smooth blend with the enchanting flavors of Irish cream.', '100.00', '2023-05-29 12:15:06.153980', 'Fresh Black Coffee/Cold Brew'),
('e241704b97', 'BFWL-2704', 'Cheeseburger', '', 'Juicy beef patty, melted cheese, and fresh toppings in toasted bun.', '120.00', '2023-05-29 12:27:58.849945', 'Sandwich'),
('e2af35d095', 'IDLC-7819', 'Black (12oz|Hot)', '', 'Bold and intense brew with a rich, robust flavor profile.', '55.00', '2023-05-29 12:52:20.222888', 'Fresh Black Coffee/Cold Brew\n'),
('e769e274a3', 'AHRW-3894', 'Black (16oz|Cold)', '', 'Bold and intense brew with a rich, robust flavor profile.', '60.00', '2023-05-29 12:14:11.484567', 'Fresh Black Coffee/Cold Brew'),
('ea557bdf5c', 'JQZY-4623', '250g Perseverance of the aromatic Hazelnut (arabica, robusta)', '', 'Rich and nutty hazelnut-infused coffee grounds for a delightful brew.', '150.00', '2023-05-29 12:34:46.223243', 'Coffee Beans / Ground'),
('ec18c5a4f0', 'PQFV-7049', 'Flat White (16oz|Cold)', '', 'Creamy and velvety espresso with a delicate milk micro foam layer.', '80.00', '2023-05-29 12:15:04.173678', 'Fresh Black Coffee/Cold Brew'),
('f4ce3927bf', 'EAHD-1980', 'Caramel (12oz|Hot)', '', 'Smooth and luscious blend infused with irresistible caramel sweetness. Smooth and luscious blend infused with irresistible caramel sweetness.', '69.00', '2023-05-29 12:16:09.356163', 'Fresh Black Coffee/Cold Brew'),
('f9c2770a32', 'YXLA-2603', 'Caramel (16oz|Cold)', '', 'Smooth and luscious blend infused with irresistible caramel sweetness.', '100.00', '2023-05-29 12:16:03.413172', 'Fresh Black Coffee/Cold Brew'),
('fc814cd29e', 'QFEO-0589', '1000g Perseverance of the aromatic Hazelnut (arabica, robusta)', '', 'Rich and nutty hazelnut-infused coffee grounds for a delightful brew.', '580.00', '2023-05-29 12:34:43.884392', 'Coffee Beans / Ground');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff`
--

CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_staff`
--

INSERT INTO `rpos_staff` (`staff_id`, `staff_name`, `staff_number`, `staff_email`, `staff_password`, `created_at`) VALUES
(1, 'Calbeans Staff', 'QEUY-9042', 'cashier@mail.com', '036d0ef7567a20b5a4ad24a354ea4a945ddab676036d0ef7567a20b5a4ad24a354ea4a945ddab676', '2023-05-31 09:21:50.286252');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `rpos_customers`
--
ALTER TABLE `rpos_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerOrder` (`customer_id`),
  ADD KEY `ProductOrder` (`prod_id`);

--
-- Indexes for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `rpos_payments`
--
ALTER TABLE `rpos_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `order` (`order_code`);

--
-- Indexes for table `rpos_products`
--
ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
