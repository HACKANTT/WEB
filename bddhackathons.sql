-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  lun. 11 oct. 2021 à 18:09
-- Version du serveur :  10.3.14-MariaDB
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bddhackathons`
--

-- --------------------------------------------------------

--
-- Structure de la table `hackathon`
--

DROP TABLE IF EXISTS `hackathon`;
CREATE TABLE IF NOT EXISTS `hackathon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `heureDebut` time DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `heureFin` time DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `codePostal` char(5) DEFAULT NULL,
  `theme` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) NULL,
  `dateLimite` date DEFAULT NULL,
  `nbPlaces` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hackathon`
--

INSERT INTO `hackathon` (`id`, `dateDebut`, `heureDebut`, `dateFin`, `heureFin`, `lieu`, `rue`, `ville`, `codePostal`, `theme`, `description`, `image`,`dateLimite`, `nbPlaces`) VALUES
(1, '2021-10-15', '18:00:00', '2021-10-17', '18:00:00', 'Talent Garden', '100 Avenue Willy Brandt', 'Lille', '59777', 'La nuit du code citoyen', 'La Nuit du Code Citoyen est un hackathon open source qui a pour but d\’accélérer des projets numériques d\’intérêt général sur le thème Transitions.','https://cdn.pixabay.com/photo/2020/05/30/17/18/wind-power-plant-5239642__480.jpg', NULL, 50),
(2, '2021-12-08', '09:30:00', '2021-12-22', '18:00:00', 'Loco Numérique', '123 Bd Louis Blanc', 'La Roche Sur Yon', '85000', 'Hackathon sur le changement climatique et la protection de la biodiversité','Un hackathon pour mieux connaître et protéger la biodiversité', 'https://cdn.pixabay.com/photo/2020/03/19/21/25/laptop-4948837__480.jpg','2021-11-08', NULL, 20),
(3, '2022-01-27', '18:30:00', '2022-01-30', '20:30:00', 'Lelaptop: atelier modulable', '7 rue Geoffroy Langevin', 'Paris', '75004', 'DefInSpace', '24H pour imaginer la défense spatiale de demain', 'https://media.istockphoto.com/photos/laser-cannon-incapacitates-enemy-satellite-in-space-picture-id1265211446?b=1&k=20&m=1265211446&s=170667a&w=0&h=3oeJG_wzOus3Vn_08d61PpcEkTYFiiquxpghRTvcdWU=',NULL, 40),
(4, '2022-03-19', '07:00:00', '2022-03-20', '23:30:00', 'Tour Franklin', '100-101 Terrasse Boieldieu', 'Puteaux', '92800', 'TadHack','Vous avez la fibre tech et l\'esprit innovateur? TADhack vous donnera les clefs pour une expérience unique, travaillez avec des experts de la voice tech et de l\'IA', NULL, NULL, NULL),
(5, '2023-06-28', NULL, '2023-06-30', NULL, 'Euratechnologies', '165 Avenue de Bretagne ', 'Lille', '59000', 'Hackathon Summer Space Festival',null,'https://cdn.pixabay.com/photo/2016/10/20/18/35/earth-1756274__340.jpg', NULL, 150),
(6, '2023-11-05', '08:00:00', '2023-11-06', '08:00:00', 'Le palace', '4 rue Voltaire', 'Nantes', '44000', 'InnovHathon', null, null, null, 25),
(7, '2023-04-09', NULL, '2023-04-11', NULL, 'La Cantine', '11 Rue La Noue', 'Nantes', '44200', 'Hacking Health',' Un marathon d\'innovation en santé','https://cdn.pixabay.com/photo/2016/11/09/15/27/dna-1811955__340.jpg', '2022-03-09', 250);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
