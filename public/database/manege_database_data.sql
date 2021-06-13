-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 13 jun 2021 om 12:05
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
(1, 'Henk', 'Paard', 16, '160.0', 'YES'),
(4, 'Dewi', 'Pony', 19, '130.0', 'NO'),
(5, 'Frank', 'Paard', 11, '160.0', 'YES'),
(6, 'Frankie', 'Paard', 11, '160.0', 'NO'),
(7, 'Jan', 'Paard', 11, '160.0', 'YES');

--
-- Gegevens worden geëxporteerd voor tabel `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `address`, `telephone_number`) VALUES
(1, 'Bas Verdoorn', 'laan 2', '06 12345678');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
