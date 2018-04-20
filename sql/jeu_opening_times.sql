-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 20 avr. 2018 à 09:41
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cinema`
--

-- --------------------------------------------------------

--
-- Structure de la table `opening_times`
--

CREATE TABLE `opening_times` (
  `id` int(11) NOT NULL,
  `day` varchar(100) NOT NULL,
  `times` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opening_times`
--

INSERT INTO `opening_times` (`id`, `day`, `times`) VALUES
(2, 'Lundi', '10 h 00 ~ 23 h 00'),
(3, 'Mardi', '10 h 00 ~ 23 h 00'),
(4, 'Mercredi', '10 h 00 ~ 23 h 00'),
(5, 'Jeudi', '10 h 00 ~ 23 h 00'),
(6, 'Vendredi', '10 h 00 ~ 23 h 00'),
(7, 'Samedi', '9 h 00 ~ 1 h 00'),
(8, 'Dimanche', '8 h 00 ~ 23 h 00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `opening_times`
--
ALTER TABLE `opening_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `opening_times`
--
ALTER TABLE `opening_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
