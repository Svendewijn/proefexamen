-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 nov 2024 om 09:23
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
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `vacature_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `reactie` text NOT NULL,
  `datum_geplaatst` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `comments`
--

INSERT INTO `comments` (`id`, `vacature_id`, `naam`, `reactie`, `datum_geplaatst`) VALUES
(1, 1, 'bert', 'hoi. ja ik wil hier werken', '2024-11-12 10:07:37'),
(2, 1, 'angelien', 'bert hou ff je bek dicht', '2024-11-12 10:08:11'),
(3, 3, 'bert', 'KONTBEDRIJF', '2024-11-12 10:51:32'),
(4, 5, 'bert', 'hoi', '2024-11-12 12:48:21'),
(5, 4, 'Legends_of_Gaming_NL', 'wajoo', '2024-11-12 12:57:01'),
(6, 5, 'bert', 'nee toch niet', '2024-11-13 08:20:33'),
(7, 7, 'jip', 'dat ben ik', '2024-11-13 09:27:45'),
(8, 7, 'jip', 'oi oi oi\r\n', '2024-11-13 09:28:06'),
(9, 7, 'jip', 'lalala', '2024-11-13 09:33:50'),
(10, 7, 'jip', 'aa', '2024-11-13 09:35:13'),
(11, 7, 'jip', '@jip hou je tyfus smoel', '2024-11-13 09:35:54'),
(12, 8, 'jip', 'is goed G', '2024-11-13 09:47:36'),
(13, 8, 'jip', 'lalala', '2024-11-13 09:56:10'),
(15, 13, 'jannes', 'kinderarts', '2024-11-14 09:32:40'),
(16, 13, 'kaki', 'oke\r\n', '2024-11-14 12:26:36');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacature_id` (`vacature_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
