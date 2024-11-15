-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 nov 2024 om 09:22
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.0.30

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
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `geregistreerd_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('werkgever','werknemer','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `email`, `wachtwoord`, `geregistreerd_op`, `rol`) VALUES
(3, 'fastracist', 'racist@gmail.com', '$2y$10$SJQgEKt5bDeiVfxz68LqouO0ZPd99CPCACPjg0HbLxCcCRSBlFpve', '2024-11-12 08:48:04', 'werknemer'),
(5, 'sharkman', 'sharkman@shark.nl', '$2y$10$L8er.05XM93MBex09jh7YeePsHV7V9xfr/uYhtA24g//OT/oE7mce', '2024-11-13 10:44:57', 'werknemer'),
(6, 'kanjer', 'kanjer@kanjer.kanjer', '$2y$10$Xvh95oRCpmm3HdLkslihB.jnPi0e8pwMW1ZObs4FVN7V0e5JSPIe2', '2024-11-13 13:10:55', 'admin'),
(7, 'jip', 'jip@jip.jip', '$2y$10$0/PnMOjzfHhPQ2xMHDalFed5A/W2gzfsIjldXozMUyD5VamMLg2Qy', '2024-11-14 10:08:47', 'werkgever'),
(8, 'kaki', 'ka@ki.k', '$2y$10$53611Ls4GM.htO1TN6JIN.Ma79lP19KW7URQVkNEftPyVfEFWaj4W', '2024-11-14 11:02:13', 'werkgever'),
(9, 'kaki', 'ka@ki.k', '$2y$10$Y0Vz/O4H6aYL629CixjaYuS9VJq26DTzxsPHgpya3.8i7sYvqocDC', '2024-11-14 11:02:27', 'werkgever');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
