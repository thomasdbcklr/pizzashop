-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2013 at 01:44 PM
-- Server version: 5.5.32-31.0-log
-- PHP Version: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `deb76872_pizzashop`
--
CREATE DATABASE IF NOT EXISTS `deb76872_pizzashop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `deb76872_pizzashop`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `voornaam` varchar(45) NOT NULL,
  `straat` varchar(45) NOT NULL,
  `huisnummer` varchar(45) NOT NULL,
  `postcode` int(4) unsigned NOT NULL,
  `woonplaats` varchar(45) NOT NULL,
  `telefoon` int(10) unsigned NOT NULL,
  `email` varchar(45) NOT NULL,
  `wachtwoord` varchar(40) NOT NULL,
  `promo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `naam`, `voornaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `telefoon`, `email`, `wachtwoord`, `promo`) VALUES
(28, 'admin', 'admin', 'admin', '5', 2000, 'admin', 5, 'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bestelinfo`
--

CREATE TABLE IF NOT EXISTS `bestelinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `klant_id` int(10) unsigned DEFAULT NULL,
  `straat` varchar(45) NOT NULL,
  `huisnummer` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `woonplaats` varchar(45) NOT NULL,
  `telefoon` int(10) unsigned NOT NULL,
  `besteldatum` datetime NOT NULL,
  `totaalprijs` int(10) unsigned NOT NULL,
  `extra_info` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_bestelinfo_1` (`klant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `bestelinfo`
--

INSERT INTO `bestelinfo` (`id`, `klant_id`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `telefoon`, `besteldatum`, `totaalprijs`, `extra_info`) VALUES
(38, NULL, 'straat', '30', '2990', 'woonplaats', 4545, '2013-07-08 13:30:58', 5, 'hey'),
(39, NULL, 'dzqd', '50', '50', 'gooreind', 50, '2013-07-08 14:53:16', 10, 'hallo'),
(41, NULL, 'dzqd', '50', '2990', 'dzqdq', 181, '2013-07-08 15:32:59', 45450, 'hallo'),
(43, NULL, 'Grotstraat', '28', '2000', 'Wuustwezel', 4728291, '2013-07-10 08:27:20', 50, ''),
(101, NULL, 'blastraat', '45', '2000', 'blabla', 23203, '2013-11-21 15:31:30', 70, 'ja');

-- --------------------------------------------------------

--
-- Table structure for table `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pizza_id` int(10) unsigned NOT NULL,
  `bestelinfo_id` int(10) unsigned NOT NULL,
  `aantal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_bestelling_1` (`pizza_id`),
  KEY `FK_bestelling_2` (`bestelinfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `bestelling`
--

INSERT INTO `bestelling` (`id`, `pizza_id`, `bestelinfo_id`, `aantal`) VALUES
(52, 1, 39, 1),
(54, 1, 41, 4545),
(62, 1, 43, 5),
(85, 1, 101, 1),
(86, 2, 101, 2),
(87, 3, 101, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pizza`
--

CREATE TABLE IF NOT EXISTS `pizza` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `prijs` int(10) unsigned NOT NULL,
  `samenstelling` varchar(100) NOT NULL,
  `promoprijs` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `naam`, `prijs`, `samenstelling`, `promoprijs`) VALUES
(1, 'Margarita', 10, 'kaas, tomatensaus', 9),
(2, 'Calzone', 12, 'kaas, tomatensaus, hesp, ui', 10),
(3, 'Al polo', 12, 'kaas, tomatensaus, kip, ui', 10);

-- --------------------------------------------------------

--
-- Table structure for table `postcode`
--

CREATE TABLE IF NOT EXISTS `postcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postcode` int(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `postcode`
--

INSERT INTO `postcode` (`id`, `postcode`) VALUES
(1, 2000),
(2, 2018),
(3, 2020),
(4, 2030),
(5, 2050),
(6, 2060);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bestelinfo`
--
ALTER TABLE `bestelinfo`
  ADD CONSTRAINT `FK_bestelinfo_1` FOREIGN KEY (`klant_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `FK_bestelling_1` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_bestelling_2` FOREIGN KEY (`bestelinfo_id`) REFERENCES `bestelinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
