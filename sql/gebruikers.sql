-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 01:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xxl_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `geregistreerd_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('werkgever','werknemer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `email`, `wachtwoord`, `geregistreerd_op`, `rol`) VALUES
(3, 'fastracist', 'racist@gmail.com', '$2y$10$SJQgEKt5bDeiVfxz68LqouO0ZPd99CPCACPjg0HbLxCcCRSBlFpve', '2024-11-12 08:48:04', 'werknemer'),
(4, 'jannes', 'jannes@gmail.com', '$2y$10$kp4lFFAj826G6wqae5Ukd.8IMu9SIrHcN08WM9noT0mYt6jE7ynUe', '2024-11-12 09:53:15', 'werknemer'),
(5, 'sharkman', 'sharkman@shark.nl', '$2y$10$L8er.05XM93MBex09jh7YeePsHV7V9xfr/uYhtA24g//OT/oE7mce', '2024-11-13 10:44:57', 'werknemer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
