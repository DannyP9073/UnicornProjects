-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 07, 2021 at 09:33 AM
-- Server version: 5.7.32
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `GuchuSys`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aID` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aID`, `f_name`, `s_name`, `username`, `email`, `role`, `address`, `password`) VALUES
(1, 'My', 'User', 'Myuser', 'myuser@test.com', 'admin', '', 'SA1@123'),
(2, 'Daniel', 'Dos Santos', 'Daxon', 'danielfernandossantos@gmail.com', 'user', '41 Jersey Road Dinwiddie', 'D0sS@nt0s');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `remedies` varchar(1000) NOT NULL,
  `Order_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oID`, `User_ID`, `remedies`, `Order_date`, `delivery_date`, `total`, `status`) VALUES
(2, 2, 'a:3:{i:0;a:4:{s:3:\"rID\";s:1:\"3\";s:5:\"rName\";s:14:\"Cayenne Pepper\";s:6:\"rPrice\";s:5:\"23.99\";s:6:\"rImage\";s:29:\"2cayenne_powder_white_web.jpg\";}i:1;a:4:{s:3:\"rID\";s:1:\"4\";s:5:\"rName\";s:9:\"Raw Honey\";s:6:\"rPrice\";s:5:\"52.99\";s:6:\"rImage\";s:11:\"1-honey.jpg\";}i:2;a:4:{s:3:\"rID\";s:1:\"5\";s:5:\"rName\";s:6:\"Garlic\";s:6:\"rPrice\";s:5:\"18.99\";s:6:\"rImage\";s:30:\"photodune-7269783-garlic-l.jpg\";}}', '2021/06/02', '2021/06/07', 195.97, 'out for delivery'),
(3, 2, 'a:1:{i:0;a:4:{s:3:\"rID\";s:1:\"3\";s:5:\"rName\";s:14:\"Cayenne Pepper\";s:6:\"rPrice\";s:5:\"23.99\";s:6:\"rImage\";s:29:\"2cayenne_powder_white_web.jpg\";}}', '2021/06/02', '2021/06/07', 123.99, 'cancelled'),
(5, 2, 'a:2:{i:1;a:4:{s:3:\"rID\";s:1:\"3\";s:5:\"rName\";s:14:\"Cayenne Pepper\";s:6:\"rPrice\";s:5:\"23.99\";s:6:\"rImage\";s:29:\"2cayenne_powder_white_web.jpg\";}i:2;a:4:{s:3:\"rID\";s:1:\"4\";s:5:\"rName\";s:9:\"Raw Honey\";s:6:\"rPrice\";s:5:\"52.99\";s:6:\"rImage\";s:11:\"1-honey.jpg\";}}', '2021/06/02', '2021/06/07', 176.98, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `remedies`
--

CREATE TABLE `remedies` (
  `rID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `picture` varchar(1000) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `remedies`
--

INSERT INTO `remedies` (`rID`, `name`, `description`, `picture`, `tag`, `price`) VALUES
(3, 'Cayenne Pepper', 'Boost Your Metabolism, Can Help Reduce Hunger, Lower Blood Pressure, Aid Digestive Health, Help Relieve Pain & May Improve Psoriasis', '2cayenne_powder_white_web.jpg', 'blood', 23.99),
(4, 'Raw Honey', 'A good source of antioxidants, Antibacterial and antifungal properties, Help for digestive issues & Soothe a sore throat', '1-honey.jpg', 'pain', 52.99),
(5, 'Garlic', 'Highly Nutritious But Has Very Few Calories, Garlic Can Combat Sickness, Including the Common Cold, Reduce Blood Pressure & Improves Cholesterol Levels', 'photodune-7269783-garlic-l.jpg', 'blood', 18.99),
(6, 'Tumeric', 'Natural Anti-Inflammatory Compound, Increases the Antioxidant Capacity of the Body, Improved Brain Function and a Lower Risk of Brain Diseases', 'tumeric_adobe.jpg', 'pain', 16.99),
(7, 'Ginger', 'Can treat many forms of nausea, especially morning sickness, help with weight loss, help with osteoarthritis & lower blood sugars', 'ginger-benefits-scaled-735x1102.jpg', 'blood', 18.99),
(8, 'Lemon', 'Support Heart Health, Control Weight, Prevent Kidney Stones, Protect Against Anemia & Improve Digestive Health.', '8569832158_3a20b9b4f4.jpg', 'digestive', 25.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oID`);

--
-- Indexes for table `remedies`
--
ALTER TABLE `remedies`
  ADD PRIMARY KEY (`rID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `remedies`
--
ALTER TABLE `remedies`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
