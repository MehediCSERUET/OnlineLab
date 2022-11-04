-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2022 at 06:31 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mtecompiler`
--

-- --------------------------------------------------------

--
-- Table structure for table `labdata`
--

CREATE TABLE `labdata` (
  `ID` int(11) NOT NULL,
  `Roll` int(7) NOT NULL,
  `ProblemID` varchar(10) NOT NULL,
  `Verdict` varchar(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `problemset`
--

CREATE TABLE `problemset` (
  `ID` int(11) NOT NULL,
  `Problem_ID` varchar(10) NOT NULL,
  `Input` text NOT NULL,
  `Output` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problemset`
--

INSERT INTO `problemset` (`ID`, `Problem_ID`, `Input`, `Output`) VALUES
(1, 'L4_1', '5 1 32 24 12 99', '99 12 24 32 1'),
(2, 'L4_2', '5\r\n1 3 5 2 5', '16'),
(3, 'L4_3', '5\r\n120 21 0 12 -1', 'Max:120\r\nMin:-1'),
(4, 'L4_4', '5\r\n10 22 10 2 1', '10:2\r\n22:1\r\n2:1\r\n1:1'),
(5, 'L4_5', '6\r\n10 10 20 20 3 1', '2'),
(6, 'L4_6', '10\r\n10 22 3 22 10 -1 2 100 33 65', '3 -1 100 33 65'),
(7, 'L4_7', '5\r\n10 20 30 40 50\r\n3 4 5 1 60', '60 50 40 30 20 10 5 4 3 1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Roll` int(7) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` text NOT NULL,
  `Role` varchar(20) NOT NULL,
  `Approved` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Roll`, `Email`, `Password`, `Role`, `Approved`) VALUES
(1, 'MMH', 143036, 'mehedi@mte.ruet.ac.bd', '00ebea08a854986db3f740d014f7dad01f6566dfd7f6e3f48ea90192f5ea548f568b33ea8fc6109e50bb4b7be3f941e2a1a5c93fae17816f0c713244b3c45a2e', 'teacher', 'yes'),
(2, 'test', 12345, 'm@m.m', 'f14aae6a0e050b74e4b7b9a5b2ef1a60ceccbbca39b132ae3e8bf88d3a946c6d8687f3266fd2b626419d8b67dcf1d8d7c0fe72d4919d9bd05efbd37070cfb41a', 'student', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `labdata`
--
ALTER TABLE `labdata`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `problemset`
--
ALTER TABLE `problemset`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `labdata`
--
ALTER TABLE `labdata`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `problemset`
--
ALTER TABLE `problemset`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
