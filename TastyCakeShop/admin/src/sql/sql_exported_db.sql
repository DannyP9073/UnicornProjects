-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 01, 2021 at 12:42 PM
-- Server version: 5.7.32
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Cakes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Order_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `p_quantity` int(11) DEFAULT NULL,
  `Order_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Order_ID`, `User_ID`, `Product_ID`, `p_quantity`, `Order_date`, `delivery_date`, `total`, `status`) VALUES
(13, 4, 1, 4, '2021/06/01', '2021/06/06', 211.96, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `picture` varchar(1000) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `name`, `description`, `picture`, `quantity`, `price`) VALUES
(1, 'Chocolate Cake', 'Rich chocolate cake stacked with a thick layer of rich chocolate icing coat inbetween stacks & covering the outside.', 'triple-chocolate-cake-4.jpg', 61, 52.99),
(2, 'Red Velvet Cake', 'Redvelvet cake with vanilla icing covering the outside and in between to cake stacks.', 'Red-Velvet-Cake-IMAGE-43.jpg', 52, 55.99),
(3, 'Chocolate Molten Cake', 'Mini-chocolate cake with a molten chocolate inside.', 'images.jpeg', 46, 62.9),
(4, 'Easter Bunny Cake', 'A cake for the one season of the year that hs a rainbow icing coat and multiple cake stacks.', 'easter-bunny-mini-cakes-1200-featured-735x735.jpg', 74, 43.99),
(5, 'Wedding Cake', 'A special cake for the most special day of a peoples lives.', 'b8161e2c9a7c95d9221d053bbf52a235.jpg', 15, 104.99),
(6, 'New Year Cake', 'Concept party cake for the event that comes around once a year.', '6ee02a8922c21b2833d0a067f404afb9.jpg', 34, 83.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uID` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uID`, `f_name`, `s_name`, `username`, `email`, `role`, `address`, `password`) VALUES
(1, 'My', 'User', 'Myuser', 'myuser@test.com', 'admin', '', 'SA1@123'),
(4, 'Daniel', 'Dos Santos', 'Daxon', '1004230@myboston.co.za', 'user', '41 Jersey Road Dinwiddie', 'D0sS@nt0s');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `FK_users` (`User_ID`),
  ADD KEY `FK_Products` (`Product_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_Products` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`User_ID`) REFERENCES `users` (`uID`);
