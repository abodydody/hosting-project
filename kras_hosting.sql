-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 20 mrt 2025 om 10:48
-- Serverversie: 8.2.0
-- PHP-versie: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kras_hosting`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'r@gmail.com', '$2y$10$27ak8w6QpQv.yPnyQJWGL.Diewb3x9rDJJMNwkI87xH3bOMlfSda.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `disk_space` varchar(20) NOT NULL,
  `bandwidth` varchar(20) NOT NULL,
  `websites` varchar(20) NOT NULL,
  `email_accounts` varchar(20) NOT NULL,
  `databases` varchar(20) NOT NULL,
  `free_domain` tinyint(1) NOT NULL DEFAULT '0',
  `has_ssl` tinyint(1) NOT NULL DEFAULT '1',
  `has_backups` tinyint(1) NOT NULL DEFAULT '1',
  `has_support` tinyint(1) NOT NULL DEFAULT '1',
  `priority_support` tinyint(1) NOT NULL DEFAULT '0',
  `dedicated_ip` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `price`, `disk_space`, `bandwidth`, `websites`, `email_accounts`, `databases`, `free_domain`, `has_ssl`, `has_backups`, `has_support`, `priority_support`, `dedicated_ip`) VALUES
(1, 'Easy', 'Basic hosting package for small websites', 2.99, '5 GB', '50 GB/maand', '1', '5', '1', 0, 1, 1, 1, 0, 0),
(2, 'Functionals', 'Medium hosting package for business websites', 5.99, '20 GB', '200 GB/maand', '3', '20', '5', 1, 1, 1, 1, 0, 0),
(3, 'Pro', 'Advanced hosting for professional websites', 9.99, '50 GB', '500 GB/maand', '10', '50', '20', 1, 1, 1, 1, 0, 1),
(4, 'Heavy user', 'Premium hosting for high-traffic websites', 14.99, '100 GB', 'Onbeperkt', 'Onbeperkt', 'Onbeperkt', 'Onbeperkt', 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `package_id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `domain` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` enum('pending','active','cancelled') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `display_location` enum('today','yesterday') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `date`, `display_location`) VALUES
(1, 'Vandaag', 'Nieuwe servers geïnstalleerd voor nog betere prestaties.', '2025-03-20', 'today'),
(2, 'Gisteren', 'Verbeterde beveiliging uitgerold voor alle hosting pakketten.', '2025-03-19', 'yesterday');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `order_number` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `order_number`) VALUES
(1, 'Wat is webhosting en waarom heb ik het nodig?', 'Webhosting is een service die ruimte biedt op een server om uw website op het internet te publiceren. U heeft het nodig om uw website toegankelijk te maken voor bezoekers op het internet.', 1),
(2, 'Wat is het verschil tussen shared hosting, VPS en dedicated hosting?', 'Bij shared hosting deelt u serverruimte met andere websites, wat goedkoper is maar minder prestaties biedt. Een VPS biedt toegewijde resources binnen een gedeelde omgeving. Dedicated hosting biedt een volledige server exclusief voor uw gebruik, wat de beste prestaties levert maar duurder is.', 2),
(3, 'Hoe kies ik de juiste hostingprovider?', 'Let op betrouwbaarheid, uptime garanties, klantenservice, prijs-kwaliteitverhouding, schaalbaarheid en de specifieke functies die u nodig heeft voor uw website.', 3),
(4, 'Wat betekent bandbreedte en hoeveel heb ik nodig?', 'Bandbreedte is de hoeveelheid data die tussen uw website en bezoekers wordt overgedragen. De benodigde hoeveelheid hangt af van uw verwachte verkeer en type content (afbeeldingen, video''s, downloads).', 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `activities`
--

INSERT INTO `activities` (`id`, `description`, `date`, `type`) VALUES
(1, 'Website gelanceerd', '2025-03-23', 'system'),
(2, 'Nieuwe pakketten toegevoegd', '2025-03-22', 'package'),
(3, 'FAQ bijgewerkt', '2025-03-20', 'content'),
(4, 'Nieuwe server toegevoegd', '2025-03-18', 'system'),
(5, 'Beveiligingsupdate uitgevoerd', '2025-03-15', 'system');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;