-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 02:26 PM
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
-- Database: `wastebin`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'we', 'e', 'e', 'ee'),
(2, 'yu', 'himaliwimansa@gmail.', 'fgdgf', 'ghj'),
(3, 'Himali Wimansa', 'himaliwimansa@gmail.', 'rtrdt', 'we'),
(4, 'sdf', 'abc@gmalidkjf', 'df', 'fs'),
(5, 'sdf', 'abc@gmalidkjf', 'df', 'fs'),
(6, 'sdf', 'abc@gmalidkjf', 'df', 'fs'),
(7, 'Himali Wimansa', 'himaliwimansa@gmail.', 'rtrdtt', 'yuuiikkloooooo');

-- --------------------------------------------------------

--
-- Table structure for table `request_pickup`
--

CREATE TABLE `request_pickup` (
  `request_id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `contact_No` varchar(20) NOT NULL,
  `waste_type` varchar(20) NOT NULL,
  `Quentity` varchar(10) NOT NULL,
  `pickup_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_pickup`
--

INSERT INTO `request_pickup` (`request_id`, `name`, `email`, `contact_No`, `waste_type`, `Quentity`, `pickup_address`) VALUES
(1, 'Himali Wimansa', 'himaliwimansa@gmail.', '+947527518', 'organic', '1', '93/E 5th mile post\r\nParanapattiya');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`) VALUES
(6, 'Himali Wimansa', 'himaliwimansa@gmail.com', '$2y$10$FcMt33cUrxvfIzx8.uoLWOqa5QZPo392mIU5TTSLJcD5vr6wOiEHa'),
(7, 'Wimansa', 'Wima@gmail.com', '$2y$10$r8d19OV.XfkFPfRzOqcJ/e5wP6h0uNpXrOJiFuSRs/qQvsflA6mKC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `request_pickup`
--
ALTER TABLE `request_pickup`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `request_pickup`
--
ALTER TABLE `request_pickup`
  MODIFY `request_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
