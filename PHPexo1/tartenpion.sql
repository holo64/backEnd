-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2020 at 08:18 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tartenpion`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresses`
--

CREATE TABLE `adresses` (
  `id_adresse` int(11) NOT NULL,
  `intitule` varchar(20) NOT NULL,
  `ligne1` varchar(50) NOT NULL,
  `ligne2` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `defaut` tinyint(1) NOT NULL DEFAULT '0',
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adresses`
--

INSERT INTO `adresses` (`id_adresse`, `intitule`, `ligne1`, `ligne2`, `cp`, `ville`, `defaut`, `id_client`) VALUES
(40, 'Adresse Montagne', 'trtrtrtrt', 'rtereet', 14789, 'Pau', 0, 20),
(41, 'testAdresse2', 'Bd du brouillard', 'fdghfdgdjdfjg', 69874, 'Barcelone', 1, 20),
(43, 'Adresse Plage', 'Avenue Des Zoou', 'fhjfghj', 96321, 'Londres', 0, 20),
(44, 'Adresse 1', 'hgfhfdghdfghfg', 'dghdfhdfgh', 45678, 'Biarritz', 1, 22),
(45, 'Adresse 2', 'ghjkhlkjlklioolij', 'hjkhglhjlkhjk', 13620, 'CARRY', 0, 22),
(46, 'test adresse Mer', 'Rue des Mouettes', 'dfghfdgjgfhkhjjljkl', 65412, 'Toulouse', 0, 25),
(47, 'TipTop', 'Tue du soleil', 'sfdsfhfdhgj', 98741, 'Poop', 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `tel` int(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `tel`, `email`) VALUES
(20, 'BUBLE', 'Elina', 777777777, 'tt@tt.fr'),
(22, 'BLUE', 'Evan', 666666666, 'bip@mm.fr'),
(25, 'YELLOW', 'Marine', 789456123, 'fdgf@wsd.fr');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresses`
--
ALTER TABLE `adresses`
  ADD PRIMARY KEY (`id_adresse`),
  ADD KEY `adresse_ibfk_1` (`id_client`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresses`
--
ALTER TABLE `adresses`
  MODIFY `id_adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `adresses_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
