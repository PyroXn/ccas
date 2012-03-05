-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 05 Mars 2012 à 17:10
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `ccas`
--

-- --------------------------------------------------------

--
-- Structure de la table `aideexterne`
--

CREATE TABLE IF NOT EXISTS `aideexterne` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idindividu` bigint(20) DEFAULT NULL,
  `datedemande` bigint(20) DEFAULT NULL,
  `idorganisme` bigint(20) DEFAULT NULL,
  `idnature` bigint(20) DEFAULT NULL,
  `aideurgente` tinyint(4) DEFAULT NULL,
  `idaidedemandee` bigint(20) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `idetat` bigint(20) DEFAULT NULL,
  `proposition` varchar(250) DEFAULT NULL,
  `idavis` bigint(20) DEFAULT NULL,
  `iddecideur` bigint(20) DEFAULT NULL,
  `datedecision` bigint(20) DEFAULT NULL,
  `montant` float(18,2) DEFAULT NULL,
  `quantite` bigint(20) DEFAULT NULL,
  `montanttotal` float(18,2) DEFAULT NULL,
  `vigilance` varchar(50) DEFAULT NULL,
  `idaideaccordee` bigint(20) DEFAULT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `aideinterne`
--

CREATE TABLE IF NOT EXISTS `aideinterne` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idindividu` bigint(20) DEFAULT NULL,
  `datedemande` bigint(20) DEFAULT NULL,
  `idorigine` bigint(20) DEFAULT NULL,
  `idnature` bigint(20) DEFAULT NULL,
  `aideurgente` tinyint(4) DEFAULT NULL,
  `idaidedemandee` bigint(20) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `idetat` bigint(20) DEFAULT NULL,
  `proposition` varchar(250) DEFAULT NULL,
  `idavis` bigint(20) DEFAULT NULL,
  `iddecideur` bigint(20) DEFAULT NULL,
  `datedecision` bigint(20) DEFAULT NULL,
  `montant` float(18,2) DEFAULT NULL,
  `quantite` bigint(20) DEFAULT NULL,
  `montanttotal` float(18,2) DEFAULT NULL,
  `vigilance` varchar(50) DEFAULT NULL,
  `idaideaccordee` bigint(20) DEFAULT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `bailleur`
--

CREATE TABLE IF NOT EXISTS `bailleur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombailleur` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `idville` bigint(20) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `credit`
--

CREATE TABLE IF NOT EXISTS `credit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `organisme` varchar(50) DEFAULT NULL,
  `mensualite` float(18,2) DEFAULT NULL,
  `dureemois` bigint(20) DEFAULT NULL,
  `totalrestant` float(18,2) DEFAULT NULL,
  `idIndividu` bigint(20) DEFAULT NULL,
  `dateajout` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `credit`
--

INSERT INTO `credit` (`id`, `organisme`, `mensualite`, `dureemois`, `totalrestant`, `idIndividu`, `dateajout`) VALUES
(1, 'Sofinco', 350.00, 12, 520.00, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `decideur`
--

CREATE TABLE IF NOT EXISTS `decideur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `decideur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE IF NOT EXISTS `depense` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `impotrevenu` float(18,2) DEFAULT NULL,
  `impotlocaux` float(18,2) DEFAULT NULL,
  `pensionalim` float(18,2) DEFAULT NULL,
  `mutuelle` float(18,2) DEFAULT NULL,
  `electricite` float(18,2) DEFAULT NULL,
  `gaz` float(18,2) DEFAULT NULL,
  `eau` float(18,2) DEFAULT NULL,
  `chauffage` float(18,2) DEFAULT NULL,
  `telephonie` float(18,2) DEFAULT NULL,
  `internet` float(18,2) DEFAULT NULL,
  `television` float(18,2) DEFAULT NULL,
  `assurance` float(18,2) DEFAULT NULL,
  `credit` float(18,2) DEFAULT NULL,
  `autredepense` float(18,2) DEFAULT NULL,
  `loyer` float(18,2) DEFAULT NULL,
  `idindividu` bigint(20) DEFAULT NULL,
  `datecreation` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `depense`
--

INSERT INTO `depense` (`id`, `impotrevenu`, `impotlocaux`, `pensionalim`, `mutuelle`, `electricite`, `gaz`, `eau`, `chauffage`, `telephonie`, `internet`, `television`, `assurance`, `credit`, `autredepense`, `loyer`, `idindividu`, `datecreation`) VALUES
(1, 520.00, 430.00, 150.00, 20.00, 45.00, 80.00, 35.00, 125.00, 30.00, 30.00, 20.00, 80.00, 120.00, 60.00, 420.00, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dette`
--

CREATE TABLE IF NOT EXISTS `dette` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `arrierelocatif` float(18,2) DEFAULT NULL,
  `fraishuissier` float(18,2) DEFAULT NULL,
  `arriereelectricite` float(18,2) DEFAULT NULL,
  `arrieregaz` float(18,2) DEFAULT NULL,
  `autredette` float(18,2) DEFAULT NULL,
  `noteautredette` varchar(255) DEFAULT NULL,
  `idprestaelec` bigint(20) DEFAULT NULL,
  `idprestagaz` bigint(20) DEFAULT NULL,
  `idIndividu` bigint(20) DEFAULT NULL,
  `datecreation` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `dette`
--

INSERT INTO `dette` (`id`, `arrierelocatif`, `fraishuissier`, `arriereelectricite`, `arrieregaz`, `autredette`, `noteautredette`, `idprestaelec`, `idprestagaz`, `idIndividu`, `datecreation`) VALUES
(1, 320.00, 200.00, 120.00, 110.00, 120.00, NULL, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etude`
--

CREATE TABLE IF NOT EXISTS `etude` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `etude` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `foyer`
--

CREATE TABLE IF NOT EXISTS `foyer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numrue` bigint(20) DEFAULT NULL,
  `idrue` bigint(20) DEFAULT NULL,
  `idsecteur` bigint(20) DEFAULT NULL,
  `idville` bigint(20) DEFAULT NULL,
  `idbailleur` bigint(20) DEFAULT NULL,
  `dateinscription` bigint(20) DEFAULT NULL,
  `typelogement` bigint(20) DEFAULT NULL,
  `typeappartenance` bigint(20) DEFAULT NULL,
  `logdatearrive` bigint(20) DEFAULT NULL,
  `logsurface` float(18,2) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `foyer`
--

INSERT INTO `foyer` (`id`, `numrue`, `idrue`, `idsecteur`, `idville`, `idbailleur`, `dateinscription`, `typelogement`, `typeappartenance`, `logdatearrive`, `logsurface`, `idinstruct`, `notes`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `individu`
--

CREATE TABLE IF NOT EXISTS `individu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `civilite` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nommarital` varchar(50) DEFAULT NULL,
  `nomusage` varchar(50) DEFAULT NULL,
  `chefdefamille` tinyint(1) DEFAULT NULL,
  `datenaissance` bigint(20) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `portable` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `assure` tinyint(1) DEFAULT NULL,
  `numsecu` bigint(20) DEFAULT NULL,
  `clefsecu` bigint(20) DEFAULT NULL,
  `regime` bigint(20) DEFAULT NULL,
  `cmu` tinyint(1) DEFAULT NULL,
  `datedebutcouvsecu` bigint(20) DEFAULT NULL,
  `datefincouvsecu` bigint(20) DEFAULT NULL,
  `numadherentmut` varchar(50) DEFAULT NULL,
  `datedebutcouvmut` bigint(20) DEFAULT NULL,
  `datefincouvmut` bigint(20) DEFAULT NULL,
  `cmuc` tinyint(1) DEFAULT NULL,
  `employeur` varchar(50) DEFAULT NULL,
  `dateinscriptionpe` bigint(20) DEFAULT NULL,
  `datedebutdroitpe` bigint(20) DEFAULT NULL,
  `datefindroitpe` bigint(20) DEFAULT NULL,
  `numdossierpe` varchar(20) DEFAULT NULL,
  `numallocatairecaf` varchar(20) DEFAULT NULL,
  `idlienfamille` bigint(20) DEFAULT NULL,
  `idcaissecaf` bigint(20) DEFAULT NULL,
  `idniveauetude` bigint(20) DEFAULT NULL,
  `idprofession` bigint(20) DEFAULT NULL,
  `idcaissemut` bigint(20) DEFAULT NULL,
  `idcaissesecu` bigint(20) DEFAULT NULL,
  `idsitfam` bigint(20) DEFAULT NULL,
  `idnationalite` bigint(20) DEFAULT NULL,
  `idvillenaissance` bigint(20) DEFAULT NULL,
  `idfoyer` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `individu`
--

INSERT INTO `individu` (`id`, `civilite`, `nom`, `prenom`, `nommarital`, `nomusage`, `chefdefamille`, `datenaissance`, `sexe`, `telephone`, `portable`, `email`, `assure`, `numsecu`, `clefsecu`, `regime`, `cmu`, `datedebutcouvsecu`, `datefincouvsecu`, `numadherentmut`, `datedebutcouvmut`, `datefincouvmut`, `cmuc`, `employeur`, `dateinscriptionpe`, `datedebutdroitpe`, `datefindroitpe`, `numdossierpe`, `numallocatairecaf`, `idlienfamille`, `idcaissecaf`, `idniveauetude`, `idprofession`, `idcaissemut`, `idcaissesecu`, `idsitfam`, `idnationalite`, `idvillenaissance`, `idfoyer`) VALUES
(1, 'Madame', 'Osef', 'Lapraline', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Monsieur', 'Pupu', 'Coco', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Monsieur', 'Perlin', 'Pinpin', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Monsieur', 'test', 'test', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `instruct`
--

CREATE TABLE IF NOT EXISTS `instruct` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `interne` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `libelleorganisme`
--

CREATE TABLE IF NOT EXISTS `libelleorganisme` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `lienfamille`
--

CREATE TABLE IF NOT EXISTS `lienfamille` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lien` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nationalite`
--

CREATE TABLE IF NOT EXISTS `nationalite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nationalite` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `organisme`
--

CREATE TABLE IF NOT EXISTS `organisme` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idtypeorganisme` bigint(20) DEFAULT NULL,
  `appelation` varchar(50) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `note` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `profession`
--

CREATE TABLE IF NOT EXISTS `profession` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profession` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `revenu`
--

CREATE TABLE IF NOT EXISTS `revenu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `salaire` float(18,2) DEFAULT NULL,
  `chomage` float(18,2) DEFAULT NULL,
  `revenualloc` float(18,2) DEFAULT NULL,
  `ass` float(18,2) DEFAULT NULL,
  `aah` float(18,2) DEFAULT NULL,
  `rsasocle` float(18,2) DEFAULT NULL,
  `rsaactivite` float(18,2) DEFAULT NULL,
  `pensionalim` float(18,2) DEFAULT NULL,
  `pensionretraite` float(18,2) DEFAULT NULL,
  `retraitcomp` float(18,2) DEFAULT NULL,
  `autrerevenu` float(18,2) DEFAULT NULL,
  `natureautre` varchar(150) DEFAULT NULL,
  `idindividu` bigint(20) DEFAULT NULL,
  `aidelogement` float(18,2) DEFAULT NULL,
  `datecreation` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `revenu`
--

INSERT INTO `revenu` (`id`, `salaire`, `chomage`, `revenualloc`, `ass`, `aah`, `rsasocle`, `rsaactivite`, `pensionalim`, `pensionretraite`, `retraitcomp`, `autrerevenu`, `natureautre`, `idindividu`, `aidelogement`, `datecreation`) VALUES
(1, 520.00, 56.00, 8.00, 26.00, 47.00, 58.00, 92.00, 30.00, 147.00, 963.00, 120.00, '0', 1, 0.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rue`
--

CREATE TABLE IF NOT EXISTS `rue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

CREATE TABLE IF NOT EXISTS `secteur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `secteur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `situationmatri`
--

CREATE TABLE IF NOT EXISTS `situationmatri` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `situation` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categorie` bigint(20) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL,
  `nomcomplet` varchar(200) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `level` varchar(5) DEFAULT NULL,
  `actif` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `nomcomplet`, `idinstruct`, `level`, `actif`) VALUES
(1, 'Florian', '56910c52ed70539e3ce0391edeb6d339', 'Janson Florian', 0, '1111', 0),
(2, 'Test', '098f6bcd4621d373cade4e832627b4f6', 'test test', NULL, NULL, NULL),
(3, 'Zozor', 'adb130c4af647b45230274c3a3e0c450', 'zozor zozor', NULL, NULL, NULL),
(4, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', NULL, NULL, NULL),
(5, 'w', 'f1290186a5d0b1ceab27f4e77c0c5d68', 'w', NULL, NULL, NULL),
(6, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test test', NULL, NULL, NULL),
(7, 'Zozor', 'ced839fb1acaa0d4113070aa7443b613', 'zozor zozor', NULL, NULL, 0),
(8, 'tutu', 'bdb8c008fa551ba75f8481963f2201da', 'tutu tutu', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cp` varchar(10) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
