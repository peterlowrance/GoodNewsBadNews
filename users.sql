-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2019 at 07:53 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `happysadnews`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `HappyOrSad` int(1) NOT NULL DEFAULT 0,
  `FavoriteTone` varchar(20) DEFAULT NULL,
  `blacklist` varchar(100) DEFAULT NULL,
  `securityQuestion` varchar(50) NOT NULL,
  `securityAnswer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `HappyOrSad`, `FavoriteTone`, `blacklist`, `securityQuestion`, `securityAnswer`) VALUES
('dani', 'smeltzer', 0, NULL, NULL, '', ''),
('danielle', 'smeltzer', 0, NULL, NULL, '', ''),
('phoenix', 'wright', 0, NULL, NULL, '', ''),
('phoenix', 'wright', 0, NULL, NULL, '', ''),
('flalk', 'kjalkd', 0, NULL, NULL, '', ''),
('hey', 'man', 0, NULL, NULL, '', ''),
('good', 'bad', 0, NULL, NULL, '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
