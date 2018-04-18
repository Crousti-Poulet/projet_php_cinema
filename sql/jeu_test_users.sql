-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 18 avr. 2018 à 12:48
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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `role`, `date_created`, `date_updated`) VALUES
(2, 'Melina', 'BOUBAY', 'melina@hotmail.fr', '$2y$10$OYL/H9A0F6wWqAFB3Tt8a.uSEa6XVcdAp1cbpenSmN0R39dzw0XU2', 'Admin', '2018-04-18 12:37:23', '2018-04-18 12:37:23'),
(3, 'Crousti', 'Crousti', 'crousti@hotmail.fr', '$2y$10$LdBBmHqywbDJGvpO/0L95OYL7DTTdkJEHKr9IZNyf3v8D1QmkaLF.', 'Admin', '2018-04-18 12:46:10', '2018-04-18 12:46:10'),
(4, 'Crousti', 'Crousti', 'crousti2@hotmail.fr', '$2y$10$io0L9OCnm76QhmdiToDzpOuTbgial33ErfDsQDSyetdXgocP0H1Iy', 'Editeur', '2018-04-18 12:46:26', '2018-04-18 12:46:26'),
(5, 'Julien', 'Julien', 'julien@hotmail.fr', '$2y$10$V8OD6YSayrYcRhATfjETjexpHUGSUihDA3cQNvHBCzVot3iK/ECia', 'Admin', '2018-04-18 12:46:42', '2018-04-18 12:46:42'),
(6, 'Julien', 'Julien', 'julien2@hotmail.fr', '$2y$10$9v2VoKVqsJ6IuSaF19HS8espWG8wQEYlDOrlACZ5Ae0ilbqx9DaXC', 'Editeur', '2018-04-18 12:46:49', '2018-04-18 12:46:49'),
(7, 'Mamitiana', 'Mamitiana', 'mamitiana@hotmail.fr', '$2y$10$RnTuhi3BPSzdCSfyt8lRiOM5KPgFwkOkJqZ2p5ZeAn9/ud19OycPm', 'Admin', '2018-04-18 12:47:12', '2018-04-18 12:47:12'),
(8, 'Mamitiana', 'Mamitiana', 'mamitiana2@hotmail.fr', '$2y$10$rjTlInKAzRx2DXxnc76wf.bvpogkam6VS2p8.XyV91HAaCZ3VngxK', 'Editeur', '2018-04-18 12:47:19', '2018-04-18 12:47:19'),
(9, 'Mélina', 'Boubay', 'melina2@hotmail.fr', '$2y$10$lc67rjzqvem6u/JdGhzVMejsMq9Uks5LBXQDixdl9YamIHCjKnlp2', 'Editeur', '2018-04-18 12:47:53', '2018-04-18 12:47:53');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
