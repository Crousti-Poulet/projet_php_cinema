-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 18 avr. 2018 à 09:58
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

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `title`, `length`, `date_release`, `genre`, `country`, `director`, `actors`, `storyline`, `poster_img_path`, `date_created`, `date_updated`) VALUES
(1, 'Transit', 98, '2018-04-25', '', '', 'Christian Petzold', NULL, '\r\nTransit\r\n25 avril 2018 / 1h 41min / Drame\r\nDe Christian Petzold\r\nAvec Franz Rogowski, Paula Beer, Godehard Giese\r\n​De nos jours, à Marseille, des réfugiés de l\'Europe entière rêvent d\'embarquer pour l\'Amérique, fuyant les forces d\'occupation fascistes. Parmi eux, l\'Allemand Georg prend l\'identité d\'un écrivain mort pour profiter de son visa. Il tombe amoureux de Marie, en quête désespérée de l\'homme qu\'elle aime et sans lequel elle ne partira pas...', 'uploads/transit.jpg', '2018-04-18 09:33:01', '2018-04-18 09:33:01'),
(2, 'Escobar', 123, '2018-04-18', '', '', 'Fernando León de Aranoa', NULL, 'Impitoyable et cruel chef du cartel de Medellin, Pablo Escobar est le criminel le plus riche de l’Histoire avec une fortune de plus de 30 milliards de dollars. \"L’empereur de la cocaïne\" met la Colombie à feu et à sang dans les années 80 en introduisant un niveau de violence sans précédent dans le commerce de la drogue.', 'uploads/escobar.jpg', '2018-04-18 09:42:38', '2018-04-18 09:42:38'),
(3, 'Allons Enfants', 59, '2018-04-18', 'Comédie', 'France', 'Stéphane Demoustier', 'Cléo Demoustier, Paul Demoustier, Vimala Pons', 'Dans les jardins de la Villette, Cléo (3 ans et demi) joue avec son frère jumeau Paul. Cléo s’éloigne et se perd. Puis c’est au tour de Paul de se retrouver seul.  Perdus dans Paris, Cléo cherche Paul et Paul cherche Cléo. Comment les enfants vont-ils vivre ces quelques heures buissonnières ? ', 'uploads/allonsenfants.jpg', '2018-04-18 09:44:51', '2018-04-18 09:44:51'),
(4, 'Game Night', 99, '2018-04-18', 'Comédie, Policier, Action', 'USA', 'Jonathan Goldstein (XII), John Francis Daley', 'Jason Bateman, Rachel McAdams, Kyle Chandler', 'Pour pimenter leur vie de couple, Max et Annie animent un jeu une nuit par semaine. Cette fois ils comptent sur Brooks, le frère charismatique de Max, pour organiser une super soirée à thème autour du polar, avec vrais faux malfrats et agents fédéraux ! Brooks a même prévu de se faire enlever…. sauf qu\'il reste introuvable. En tentant de résoudre l\'énigme, nos joueurs invétérés commencent à comprendre qu\'ils se sont peut-être trompés sur toute la ligne. De fausse piste en rebondissement, ils n\'ont plus aucun point de repère et ne savent plus s\'il s\'agit encore d\'un jeu… ou pas. Cette nuit risque bien d\'être la plus délirante – et la plus dangereuse – de toute leur carrière de joueurs…', 'uploads/gamenight.jpg', '2018-04-18 09:57:10', '2018-04-18 09:57:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
