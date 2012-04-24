-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 24 Avril 2012 à 16:47
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.5-1ubuntu7.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Administrateur de `Allocine`
--

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
-- Structure de la table `Acteur`
--

CREATE TABLE IF NOT EXISTS `Acteur` (
  `acteur_id` int(11) NOT NULL AUTO_INCREMENT,
  `acteur_nom` varchar(80) DEFAULT NULL,
  `acteur_prenom` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`acteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Acteur`
--


-- --------------------------------------------------------

--
-- Structure de la table `CategorieFilm`
--

CREATE TABLE IF NOT EXISTS `CategorieFilm` (
  `catFilm_id` int(11) NOT NULL AUTO_INCREMENT,
  `catFilm_libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`catFilm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `CategorieFilm`
--


-- --------------------------------------------------------

--
-- Structure de la table `Film`
--

CREATE TABLE IF NOT EXISTS `Film` (
  `film_id` int(11) NOT NULL AUTO_INCREMENT,
  `film_titre` varchar(120) DEFAULT NULL,
  `film_date` date DEFAULT NULL,
  `film_resume` text NOT NULL,
  `film_image_id` int(11) DEFAULT NULL,
  `film_realisateur_id` int(11) DEFAULT NULL,
  `film_site_id` int(11) DEFAULT NULL,
  `film_site_note` int(11) DEFAULT NULL,
  PRIMARY KEY (`film_id`),
  KEY `film_realisateur_id` (`film_realisateur_id`),
  KEY `film_site_id` (`film_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Film`
--


-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE IF NOT EXISTS `Groupe` (
  `groupe_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe_lib` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`groupe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Groupe`
--


-- --------------------------------------------------------

--
-- Structure de la table `ListeActeur`
--

CREATE TABLE IF NOT EXISTS `ListeActeur` (
  `listeActeur_id` int(11) NOT NULL AUTO_INCREMENT,
  `listeActeur_film_id` int(11) DEFAULT NULL,
  `listeActeur_acteur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`listeActeur_id`),
  KEY `listeActeur_film_id` (`listeActeur_film_id`),
  KEY `listeActeur_acteur_id` (`listeActeur_acteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ListeActeur`
--


-- --------------------------------------------------------

--
-- Structure de la table `ListeCategoriesFilm`
--

CREATE TABLE IF NOT EXISTS `ListeCategoriesFilm` (
  `listeCategoriesFilms_id` int(11) NOT NULL AUTO_INCREMENT,
  `listeCategoriesFilms_film_id` int(11) DEFAULT NULL,
  `listeCategoriesFilms_categorie_film` int(11) DEFAULT NULL,
  PRIMARY KEY (`listeCategoriesFilms_id`),
  KEY `listeCategoriesFilms_film_id` (`listeCategoriesFilms_film_id`),
  KEY `listeCategoriesFilms_categorie_film` (`listeCategoriesFilms_categorie_film`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ListeCategoriesFilm`
--


-- --------------------------------------------------------

--
-- Structure de la table `ListeRecompenses`
--

CREATE TABLE IF NOT EXISTS `ListeRecompenses` (
  `listeRecompense_id` int(11) NOT NULL AUTO_INCREMENT,
  `listeRecompense_film_id` int(11) DEFAULT NULL,
  `listeRecompense_recompense_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`listeRecompense_id`),
  KEY `listeRecompense_film_id` (`listeRecompense_film_id`),
  KEY `listeRecompense_recompense_id` (`listeRecompense_recompense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ListeRecompenses`
--


-- --------------------------------------------------------

--
-- Structure de la table `Note`
--

CREATE TABLE IF NOT EXISTS `Note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `film_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note_val` int(11) DEFAULT NULL,
  `note_commentaire` text NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `film_id` (`film_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Note`
--


-- --------------------------------------------------------

--
-- Structure de la table `Realisateur`
--

CREATE TABLE IF NOT EXISTS `Realisateur` (
  `realisateur_id` int(11) NOT NULL AUTO_INCREMENT,
  `realisateur_nom` varchar(80) DEFAULT NULL,
  `realisateur_prenom` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`realisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Realisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `Recompense`
--

CREATE TABLE IF NOT EXISTS `Recompense` (
  `recompense_id` int(11) NOT NULL AUTO_INCREMENT,
  `recompense_lib` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`recompense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Recompense`
--


-- --------------------------------------------------------

--
-- Structure de la table `Site`
--

CREATE TABLE IF NOT EXISTS `Site` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_lib` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Site`
--


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
  `user_groupe_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_groupe_id` (`user_groupe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`user_id`, `user_nom`, `user_prenom`, `user_num_rue`, `user_lib_rue`, `user_cp`, `user_ville`, `user_telephone`, `user_email`, `user_mdp`, `user_level`, `user_groupe_id`) VALUES
(1, 'admin', 'istrator', NULL, NULL, NULL, NULL, NULL, 'admin@allocine.fr', '21232f297a57a5a743894a0e4a801fc3', 2, NULL),
(2, 'simple', 'user', NULL, NULL, NULL, NULL, NULL, 'user@allocine.fr', 'ee11cbb19052e40b07aac0ca060c23ee', 1, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Film`
--
ALTER TABLE `Film`
  ADD CONSTRAINT `Film_ibfk_1` FOREIGN KEY (`film_realisateur_id`) REFERENCES `Realisateur` (`realisateur_id`),
  ADD CONSTRAINT `Film_ibfk_2` FOREIGN KEY (`film_site_id`) REFERENCES `Site` (`site_id`);

--
-- Contraintes pour la table `ListeActeur`
--
ALTER TABLE `ListeActeur`
  ADD CONSTRAINT `ListeActeur_ibfk_1` FOREIGN KEY (`listeActeur_film_id`) REFERENCES `Film` (`film_id`),
  ADD CONSTRAINT `ListeActeur_ibfk_2` FOREIGN KEY (`listeActeur_acteur_id`) REFERENCES `Acteur` (`acteur_id`);

--
-- Contraintes pour la table `ListeCategoriesFilm`
--
ALTER TABLE `ListeCategoriesFilm`
  ADD CONSTRAINT `ListeCategoriesFilm_ibfk_1` FOREIGN KEY (`listeCategoriesFilms_film_id`) REFERENCES `Film` (`film_id`),
  ADD CONSTRAINT `ListeCategoriesFilm_ibfk_2` FOREIGN KEY (`listeCategoriesFilms_categorie_film`) REFERENCES `CategorieFilm` (`catFilm_id`);

--
-- Contraintes pour la table `ListeRecompenses`
--
ALTER TABLE `ListeRecompenses`
  ADD CONSTRAINT `ListeRecompenses_ibfk_2` FOREIGN KEY (`listeRecompense_recompense_id`) REFERENCES `Recompense` (`recompense_id`),
  ADD CONSTRAINT `ListeRecompenses_ibfk_1` FOREIGN KEY (`listeRecompense_film_id`) REFERENCES `Film` (`film_id`);

--
-- Contraintes pour la table `Note`
--
ALTER TABLE `Note`
  ADD CONSTRAINT `Note_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `Film` (`film_id`),
  ADD CONSTRAINT `Note_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`user_groupe_id`) REFERENCES `Groupe` (`groupe_id`);
