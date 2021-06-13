-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Gegenereerd op: 14 mei 2019 om 08:51
-- Serverversie: 5.6.37
-- PHP-versie: 7.1.8

-- Verwijder de database
drop database if exists `manege`;
-- Maak de database aan als deze nog niet bestaat.
create database if not exists `manege`;
-- Gebruik de database voor de volgende queries.
use `manege`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

create TABLE IF NOT EXISTS `visitors` (
	`id` int not null unique primary key auto_increment,
	`name` varchar(255) not null,
	`address` varchar(255) not null,
	`telephone_number` varchar(12) not null
) engine = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int not null unique primary key auto_increment,
  `visitor` int not null,
  `animal` int not null,
  `date_reservation` DATETIME(0) not NULL,
  `time_duration` int not NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- CREATE TABLE IF NOT EXISTS `horses` (
--   `id` int not null unique primary key auto_increment,
--   `name` varchar(255) not NULL,
--   `race` varchar(255) not NULL,
--   `age` TINYINT(3) not NULL,
--   `show_jumping` TINYTEXT not NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- CREATE TABLE IF NOT EXISTS `ponys` (
--   `id` int not null unique primary key auto_increment,
--   `name` varchar(255) not NULL,
--   `race` varchar(255) not NULL,
--   `age` TINYINT(3) not NULL,
--   `height` TINYINT(3) not NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `animals` (
  `id` int not null unique primary key auto_increment,
  `name` varchar(255) not NULL,
  `race` varchar(255) not NULL,
  `age` TINYINT(3) not NULL,
  `height` DECIMAL(6, 1) not NULL, 
  `show_jumping` TINYTEXT not NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;




