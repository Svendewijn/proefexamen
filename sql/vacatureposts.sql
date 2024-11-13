-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 nov 2024 om 15:21
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
-- Tabelstructuur voor tabel `vacatureposts`
--

CREATE TABLE `vacatureposts` (
  `id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `beschrijving` text NOT NULL,
  `locatie` varchar(255) NOT NULL,
  `salaris` decimal(10,2) DEFAULT NULL,
  `datum_geplaatst` timestamp NOT NULL DEFAULT current_timestamp(),
  `gebruiker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `vacatureposts`
--

INSERT INTO `vacatureposts` (`id`, `titel`, `beschrijving`, `locatie`, `salaris`, `datum_geplaatst`, `gebruiker_id`) VALUES
(13, 'derakkersbv', 'wij zijn de rakkers kleine tyfus aap', 'delly', 2.00, '2024-11-13 14:17:56', 6);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `vacatureposts`
--
ALTER TABLE `vacatureposts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `vacatureposts`
--
ALTER TABLE `vacatureposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
