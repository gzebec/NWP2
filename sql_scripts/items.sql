-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2022 at 09:49 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: nwp
--

-- --------------------------------------------------------

--
-- Table structure for table items
--

CREATE TABLE items (
  id int(10) NOT NULL,
  code varchar(20) NOT NULL,
  name varchar(100) NOT NULL,
  description varchar(1000) NOT NULL,
  link varchar(200) NOT NULL,
  image_link varchar(200) NOT NULL,
  item_condition varchar(50) NOT NULL,
  item_availability varchar(50) NOT NULL,
  price double(10,2) NOT NULL,
  currency varchar(5) NOT NULL,
  gtin int(11) NOT NULL,
  brand varchar(50) NOT NULL,
  product_type varchar(50) NOT NULL,
  google_product_category int(11) NOT NULL,
  fb_product_category int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table items
--
ALTER TABLE items
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table items
--
ALTER TABLE items
  MODIFY id int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2812;
COMMIT;
