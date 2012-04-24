-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 23 Avril 2012 à 11:42
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.5-1ubuntu7.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE user "admin"@"localhost";
SET password FOR "admin"@"localhost" = password('admin');
GRANT ALL ON Allocine.* TO "admin"@"localhost";

--
-- Base de données: `Allocine`
--

CREATE DATABASE `Allocine`;
USE `Allocine`;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nom` varchar(40) NOT NULL,
  `user_prenom` varchar(40) NOT NULL,
  `user_num_rue` int(11) DEFAULT NULL,
  `user_lib_rue` varchar(120) DEFAULT NULL,
  `user_cp` int(11) DEFAULT NULL,
  `user_ville` varchar(120) DEFAULT NULL,
  `user_telephone` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_mdp` varchar(40) NOT NULL,
  `user_level` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `User`
--
INSERT INTO `User` (`user_id`, `user_nom`, `user_prenom`, `user_email`, `user_mdp`, `user_level`) VALUES
(1, 'admin', 'istrator', 'admin@allocine.fr', '21232f297a57a5a743894a0e4a801fc3', 2),
(2, 'simple', 'user', 'user@allocine.fr', 'ee11cbb19052e40b07aac0ca060c23ee', 1);

