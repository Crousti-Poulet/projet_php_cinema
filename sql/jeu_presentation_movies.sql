-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 19 avr. 2018 à 17:06
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
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `length` smallint(6) NOT NULL COMMENT 'en minutes',
  `date_release` date NOT NULL,
  `genre` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `director` varchar(100) NOT NULL,
  `actors` varchar(255) DEFAULT NULL,
  `storyline` text NOT NULL,
  `poster_img_path` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `title`, `length`, `date_release`, `genre`, `country`, `director`, `actors`, `storyline`, `poster_img_path`, `date_created`, `date_updated`) VALUES
(2, 'Escobar', 123, '2018-04-18', 'Drame', 'Espagne', 'Fernando León de Aranoa', 'Javier Bardem, Penélope Cruz, Peter Sarsgaard', 'Impitoyable et cruel chef du cartel de Medellin, Pablo Escobar est le criminel le plus riche de l’Histoire avec une fortune de plus de 30 milliards de dollars. \"L’empereur de la cocaïne\" met la Colombie à feu et à sang dans les années 80 en introduisant un niveau de violence sans précédent dans le commerce de la drogue.', 'uploads/escobar.jpg', '2018-04-18 09:42:38', '2018-04-18 09:42:38'),
(3, 'Drive', 100, '2011-10-05', 'Action', 'Etats-Unis', 'Nicolas Winding Refn', 'Ryan Gosling', 'Un jeune homme solitaire, \"The Driver\", conduit le jour à Hollywood pour le cinéma en tant que cascadeur et la nuit pour des truands. Ultra professionnel et peu bavard, il a son propre code de conduite. Jamais il n’a pris part aux crimes de ses employeurs autrement qu’en conduisant - et au volant, il est le meilleur !\r\nShannon, le manager qui lui décroche tous ses contrats, propose à Bernie Rose, un malfrat notoire, d’investir dans un véhicule pour que son poulain puisse affronter les circuits de stock-car professionnels. Celui-ci accepte mais impose son associé, Nino, dans le projet. \r\nC’est alors que la route du pilote croise celle d’Irene et de son jeune fils. Pour la première fois de sa vie, il n’est plus seul.\r\nLorsque le mari d’Irene sort de prison et se retrouve enrôlé de force dans un braquage pour s’acquitter d’une dette, il décide pourtant de lui venir en aide. L’expédition tourne mal…', 'uploads/1524149654-drive1.jpg', '2018-04-19 16:54:15', '2018-04-19 16:54:15'),
(4, 'Forest Gump', 140, '1994-10-05', 'Drame', 'Etats-Unis', 'Robert Zemeckis', 'Tom Hanks, Gary Sinise, Robin Wright', 'Quelques décennies d\'histoire américaine, des années 1940 à la fin du XXème siècle, à travers le regard et l\'étrange odyssée d\'un homme simple et pur, Forrest Gump.', 'uploads/1524149833-Forest.jpg', '2018-04-19 16:57:13', '2018-04-19 16:57:13'),
(5, 'La grande aventure Lego', 100, '2014-02-19', 'Animation', 'Etats-Unis', 'Phil Lord, Christopher Miller', 'Arnaud Ducret, Tal, Chris Pratt', 'Emmet est un petit personnage banal et conventionnel que l\'on prend par erreur pour un être extraordinaire, capable de sauver le monde. Il se retrouve entraîné, parmi d\'autres, dans un périple des plus mouvementés, dans le but de mettre hors d\'état de nuire un redoutable despote. Mais le pauvre Emmet n\'est absolument pas prêt à relever un tel défi !', 'uploads/1524150115-lego.jpg', '2018-04-19 17:01:55', '2018-04-19 17:01:55'),
(6, 'Rox et Rouky', 83, '1981-11-25', 'Comédie', 'Etats-Unis', 'Richard Rich, Ted Berman', 'Paule Emanuele, Jacques Deschamps, Janine Fornet', 'Rox le renard et Rouky le chien sont les meilleurs amis du monde. Mais cette amitié est menacée lorsque le maître de Rouky devient chasseur...', 'uploads/1524150280-rox.jpg', '2018-04-19 17:04:40', '2018-04-19 17:04:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
