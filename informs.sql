-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2021 at 07:20 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecollege`
--

-- --------------------------------------------------------

--
-- Table structure for table `informs`
--

CREATE TABLE `informs` (
  `inf_id` int(11) NOT NULL,
  `inf_date` varchar(255) NOT NULL,
  `inf_text` longtext NOT NULL,
  `inf_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `informs`
--

INSERT INTO `informs` (`inf_id`, `inf_date`, `inf_text`, `inf_title`) VALUES
(1, '2021-03-26 1:44 PM', 'Type Someting...', 'hi'),
(2, '2021/03/26 1:48 PM', 'Type Someting...', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `informs`
--
ALTER TABLE `informs`
  ADD PRIMARY KEY (`inf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `informs`
--
ALTER TABLE `informs`
  MODIFY `inf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
