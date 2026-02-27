-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 04:41 AM
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
-- Database: `ddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `quis`
--

CREATE TABLE `quis` (
  `id` int(60) NOT NULL,
  `img` varchar(60) NOT NULL,
  `country_name` varchar(60) NOT NULL,
  `capital` varchar(60) NOT NULL,
  `question` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quis`
--

INSERT INTO `quis` (`id`, `img`, `country_name`, `capital`, `question`) VALUES
(1, 'albania.png', 'Albania', 'Tirana', 'nana'),
(2, 'getmany.png', 'Germany', 'Vien', 'nana'),
(3, 'kosbo.png', 'Kosovo', 'Tirina', 'nana'),
(4, 'italy.png', 'Italy', 'uei uei', 'nana');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quis`
--
ALTER TABLE `quis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quis`
--
ALTER TABLE `quis`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
