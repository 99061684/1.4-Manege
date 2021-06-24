-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 24 jun 2021 om 09:58
-- Serverversie: 8.0.18
-- PHP-versie: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manege`
--

--
-- Gegevens worden geëxporteerd voor tabel `animals`
--

INSERT INTO `animals` (`id`, `name`, `race`, `age`, `height`, `show_jumping`) VALUES
(4, 'Dewi', 'Pony', 19, '130.0', 'NO'),
(5, 'Frank', 'Paard', 11, '160.0', 'YES'),
(8, 'Remmie', 'Paard', 13, '150.0', 'YES'),
(14, 'Woefer', 'Hond', 11, '120.0', 'NO'),
(21, 'Henk', 'Hond', 11, '150.0', 'NO');

--
-- Gegevens worden geëxporteerd voor tabel `reservations`
--

INSERT INTO `reservations` (`id`, `visitor`, `animal`, `date_reservation`, `time_duration`, `costs`) VALUES
(1, 1, 21, '2021-06-16 11:25:00', 1, 55),
(2, 2, 8, '2021-06-16 12:12:00', 2, 110);

--
-- Gegevens worden geëxporteerd voor tabel `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `address`, `telephone_number`) VALUES
(1, 'Bas Verdoorn', 'laan 8', '06 12345678'),
(2, 'Remmie', 'laan 4', '06 12345678');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
