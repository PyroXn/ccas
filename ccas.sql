-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 14 Mars 2012 à 15:56
-- Version du serveur: 5.1.61
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
-- Structure de la table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` bigint(20) DEFAULT '0',
  `idaction` bigint(20) DEFAULT '0',
  `motif` varchar(150) DEFAULT ' ',
  `suiteadonner` varchar(150) DEFAULT ' ',
  `suitedonnee` varchar(150) DEFAULT ' ',
  `idinstruct` bigint(20) DEFAULT '0',
  `idindividu` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `action`
--

INSERT INTO `action` (`id`, `date`, `idaction`, `motif`, `suiteadonner`, `suitedonnee`, `idinstruct`, `idindividu`) VALUES
(1, 0, 5, ' Osef', 'Definir pénitence', 'Coup de fouet sur place publique', 1, 1),
(2, 1331679600, 5, 'Ta race', 'TG', 'TG', 30, 1),
(3, 946681200, 5, 'a', 'a', 'a', 28, 1);

-- --------------------------------------------------------

--
-- Structure de la table `aideexterne`
--

CREATE TABLE IF NOT EXISTS `aideexterne` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idindividu` bigint(20) DEFAULT NULL,
  `datedemande` bigint(20) DEFAULT '0',
  `idorganisme` bigint(20) DEFAULT NULL,
  `idnature` bigint(20) DEFAULT NULL,
  `aideurgente` tinyint(4) DEFAULT '0',
  `idaidedemandee` bigint(20) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `idetat` bigint(20) DEFAULT NULL,
  `proposition` varchar(250) DEFAULT ' ',
  `idavis` bigint(20) DEFAULT NULL,
  `iddecideur` bigint(20) DEFAULT NULL,
  `datedecision` bigint(20) DEFAULT '0',
  `montant` float(18,2) DEFAULT '0.00',
  `quantite` bigint(20) DEFAULT '0',
  `montanttotal` float(18,2) DEFAULT '0.00',
  `vigilance` varchar(50) DEFAULT ' ',
  `idaideaccordee` bigint(20) DEFAULT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  `rapport` varchar(250) DEFAULT NULL,
  `daterevision` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `aideinterne`
--

CREATE TABLE IF NOT EXISTS `aideinterne` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idindividu` bigint(20) DEFAULT NULL,
  `datedemande` bigint(20) DEFAULT '0',
  `idorigine` bigint(20) DEFAULT NULL,
  `idnature` bigint(20) DEFAULT NULL,
  `aideurgente` tinyint(4) DEFAULT '0',
  `idaidedemandee` bigint(20) DEFAULT NULL,
  `idinstruct` bigint(20) DEFAULT NULL,
  `idetat` bigint(20) DEFAULT NULL,
  `proposition` varchar(250) DEFAULT ' ',
  `idavis` bigint(20) DEFAULT NULL,
  `iddecideur` bigint(20) DEFAULT NULL,
  `datedecision` bigint(20) DEFAULT '0',
  `montant` float(18,2) DEFAULT '0.00',
  `quantite` bigint(20) DEFAULT '0',
  `montanttotal` float(18,2) DEFAULT '0.00',
  `vigilance` varchar(50) DEFAULT ' ',
  `idaideaccordee` bigint(20) DEFAULT NULL,
  `commentaire` varchar(250) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `bailleur`
--

CREATE TABLE IF NOT EXISTS `bailleur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombailleur` varchar(100) DEFAULT ' ',
  `adresse` varchar(255) DEFAULT ' ',
  `idville` bigint(20) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT ' ',
  `fax` varchar(30) DEFAULT ' ',
  `email` varchar(30) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `bailleur`
--

INSERT INTO `bailleur` (`id`, `nombailleur`, `adresse`, `idville`, `telephone`, `fax`, `email`) VALUES
(1, 'MOSELIS', '', 0, '', '', ''),
(2, 'LOGIEST', '', 0, '', '', ''),
(3, 'BATIGERE', '', 0, '', '', ''),
(4, 'MASSON', '', 0, '', '', ''),
(5, 'Privé', '', 0, '', '', ''),
(6, 'ADOMA', '', 0, '', '', ''),
(7, 'HABITER agence immobilière', '', 0, '', '', ''),
(8, 'EST HABITAT', '', 0, '', '', ''),
(9, 'GESTIMMO', '', 0, '', '', ''),
(10, 'ACER Gazi', '', 0, '', '', ''),
(11, 'Propriétaire', '', 0, '', '', ''),
(12, 'FONCIA SOLOGAT', '', 0, '', '', ''),
(13, 'Présence Habitat', '', 0, '', '', ''),
(14, 'TRIACCA', '', 0, '', '', ''),
(15, 'Accession à la propriété', '', 0, '', '', ''),
(16, 'KAYA Erdogan', '', 0, '', '', ''),
(17, 'FENGHOUR Fatima', '', 0, '', '', ''),
(18, 'OPHLM', '', 0, '', '', ''),
(19, 'BAILLY', '', 0, '', '', ''),
(20, 'YILDIRIM Turan', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `credit`
--

CREATE TABLE IF NOT EXISTS `credit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `organisme` varchar(50) DEFAULT ' ',
  `mensualite` float(18,2) DEFAULT '0.00',
  `dureemois` bigint(20) DEFAULT '0',
  `totalrestant` float(18,2) DEFAULT '0.00',
  `idindividu` bigint(20) DEFAULT '0',
  `dateajout` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `credit`
--

INSERT INTO `credit` (`id`, `organisme`, `mensualite`, `dureemois`, `totalrestant`, `idindividu`, `dateajout`) VALUES
(2, 'Test', 20.00, 20, 20.00, 1, 1331634954);

-- --------------------------------------------------------

--
-- Structure de la table `decideur`
--

CREATE TABLE IF NOT EXISTS `decideur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `decideur` varchar(255) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE IF NOT EXISTS `depense` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `impotrevenu` float(18,2) DEFAULT '0.00',
  `impotlocaux` float(18,2) DEFAULT '0.00',
  `pensionalim` float(18,2) DEFAULT '0.00',
  `mutuelle` float(18,2) DEFAULT '0.00',
  `electricite` float(18,2) DEFAULT '0.00',
  `gaz` float(18,2) DEFAULT '0.00',
  `eau` float(18,2) DEFAULT '0.00',
  `chauffage` float(18,2) DEFAULT '0.00',
  `telephonie` float(18,2) DEFAULT '0.00',
  `internet` float(18,2) DEFAULT '0.00',
  `television` float(18,2) DEFAULT '0.00',
  `assurance` float(18,2) DEFAULT '0.00',
  `credit` float(18,2) DEFAULT '0.00',
  `autredepense` float(18,2) DEFAULT '0.00',
  `naturedepense` varchar(150) DEFAULT ' ',
  `loyer` float(18,2) DEFAULT '0.00',
  `idindividu` bigint(20) DEFAULT NULL,
  `datecreation` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `depense`
--

INSERT INTO `depense` (`id`, `impotrevenu`, `impotlocaux`, `pensionalim`, `mutuelle`, `electricite`, `gaz`, `eau`, `chauffage`, `telephonie`, `internet`, `television`, `assurance`, `credit`, `autredepense`, `naturedepense`, `loyer`, `idindividu`, `datecreation`) VALUES
(1, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 10.00, 1, 1331136605),
(2, 0.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1.00, ' test', 540.00, 1, 1331566099),
(3, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 4, 1331569012),
(4, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 2, 1331569613),
(5, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 3, 1331569619),
(6, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 5, 1331648671),
(7, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 6, 1331648780),
(8, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', 0.00, 7, 1331661060);

-- --------------------------------------------------------

--
-- Structure de la table `dette`
--

CREATE TABLE IF NOT EXISTS `dette` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `arrierelocatif` float(18,2) DEFAULT '0.00',
  `fraishuissier` float(18,2) DEFAULT '0.00',
  `arriereelectricite` float(18,2) DEFAULT '0.00',
  `arrieregaz` float(18,2) DEFAULT '0.00',
  `autredette` float(18,2) DEFAULT '0.00',
  `naturedette` varchar(255) DEFAULT ' ',
  `prestaelec` varchar(50) DEFAULT NULL,
  `prestagaz` varchar(50) DEFAULT NULL,
  `idindividu` bigint(20) DEFAULT NULL,
  `datecreation` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `dette`
--

INSERT INTO `dette` (`id`, `arrierelocatif`, `fraishuissier`, `arriereelectricite`, `arrieregaz`, `autredette`, `naturedette`, `prestaelec`, `prestagaz`, `idindividu`, `datecreation`) VALUES
(1, 35.00, 0.00, 0.00, 0.00, 0.00, ' ', 'EDF', 'GDF', 1, 1331136828),
(2, 1.00, 0.00, 0.00, 0.00, 0.00, ' ', '', '', 1, 1331566110),
(3, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 4, 1331569014),
(4, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 2, 1331569614),
(5, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 3, 1331569620),
(6, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 5, 1331648671),
(7, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 6, 1331648780),
(8, 0.00, 0.00, 0.00, 0.00, 0.00, ' ', NULL, NULL, 7, 1331661060);

-- --------------------------------------------------------

--
-- Structure de la table `etude`
--

CREATE TABLE IF NOT EXISTS `etude` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `etude` varchar(90) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `etude`
--

INSERT INTO `etude` (`id`, `etude`) VALUES
(1, 'BAC Général'),
(2, 'Bac Technologique'),
(3, 'Bac Professionnel'),
(4, 'BEP'),
(5, 'CAP'),
(6, '3ème'),
(7, '5ème'),
(8, 'maternelle'),
(9, 'BTS Comptabilité'),
(10, 'CAP vendeuse'),
(11, 'université Metz'),
(12, 'CAP vente'),
(13, 'CAP Maçonnerie'),
(14, 'CAP Mécanicien ajust'),
(15, 'Niveau V'),
(16, 'CAP Boulangerie'),
(17, '3ème SEGPA'),
(18, 'Niveau Vbis'),
(19, 'CAP Employé bureau'),
(20, 'CAP vente relation c'),
(21, 'BTS A'),
(22, 'V'),
(23, 'Année supérieure BAC'),
(24, 'Niveau V bis'),
(25, 'CAP peintre en bâtim'),
(26, 'CAP Menuisier');

-- --------------------------------------------------------

--
-- Structure de la table `foyer`
--

CREATE TABLE IF NOT EXISTS `foyer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numrue` bigint(20) DEFAULT '0',
  `idrue` bigint(20) DEFAULT NULL,
  `idsecteur` bigint(20) DEFAULT NULL,
  `idville` bigint(20) DEFAULT NULL,
  `idbailleur` bigint(20) DEFAULT NULL,
  `dateinscription` bigint(20) DEFAULT '0',
  `typelogement` bigint(20) DEFAULT NULL,
  `typeappartenance` bigint(20) DEFAULT NULL,
  `logdatearrive` bigint(20) DEFAULT '0',
  `logsurface` float(18,2) DEFAULT '0.00',
  `idinstruct` bigint(20) DEFAULT NULL,
  `notes` varchar(255) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `foyer`
--

INSERT INTO `foyer` (`id`, `numrue`, `idrue`, `idsecteur`, `idville`, `idbailleur`, `dateinscription`, `typelogement`, `typeappartenance`, `logdatearrive`, `logsurface`, `idinstruct`, `notes`) VALUES
(1, 12, 69, 4, 218, 15, NULL, 2, 4, 978303600, 105.00, 1, 'Je note.'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, NULL, NULL, NULL, NULL, 1331648671, NULL, NULL, 0, 0.00, NULL, ' '),
(4, 0, NULL, NULL, NULL, NULL, 1331648779, NULL, NULL, 0, 0.00, NULL, ' '),
(5, 0, NULL, NULL, NULL, NULL, 1331661060, NULL, NULL, 0, 0.00, NULL, ' ');

-- --------------------------------------------------------

--
-- Structure de la table `individu`
--

CREATE TABLE IF NOT EXISTS `individu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `civilite` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nommarital` varchar(50) DEFAULT ' ',
  `nomusage` varchar(50) DEFAULT ' ',
  `chefdefamille` tinyint(1) DEFAULT '0',
  `datenaissance` bigint(20) DEFAULT '0',
  `sexe` varchar(10) DEFAULT ' ',
  `telephone` varchar(50) DEFAULT ' ',
  `portable` varchar(50) DEFAULT ' ',
  `email` varchar(50) DEFAULT ' ',
  `assure` tinyint(1) DEFAULT '0',
  `numsecu` bigint(20) DEFAULT '0',
  `clefsecu` bigint(20) DEFAULT '0',
  `regime` varchar(50) DEFAULT ' ',
  `cmu` tinyint(1) DEFAULT '0',
  `datedebutcouvsecu` bigint(20) DEFAULT '0',
  `datefincouvsecu` bigint(20) DEFAULT '0',
  `numadherentmut` varchar(50) DEFAULT NULL,
  `datedebutcouvmut` bigint(20) DEFAULT '0',
  `datefincouvmut` bigint(20) DEFAULT '0',
  `cmuc` tinyint(1) DEFAULT '0',
  `employeur` varchar(50) DEFAULT NULL,
  `dateinscriptionpe` bigint(20) DEFAULT '0',
  `datedebutdroitpe` bigint(20) DEFAULT '0',
  `datefindroitpe` bigint(20) DEFAULT '0',
  `numdossierpe` varchar(20) DEFAULT ' ',
  `numallocatairecaf` varchar(20) DEFAULT ' ',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `individu`
--

INSERT INTO `individu` (`id`, `civilite`, `nom`, `prenom`, `nommarital`, `nomusage`, `chefdefamille`, `datenaissance`, `sexe`, `telephone`, `portable`, `email`, `assure`, `numsecu`, `clefsecu`, `regime`, `cmu`, `datedebutcouvsecu`, `datefincouvsecu`, `numadherentmut`, `datedebutcouvmut`, `datefincouvmut`, `cmuc`, `employeur`, `dateinscriptionpe`, `datedebutdroitpe`, `datefindroitpe`, `numdossierpe`, `numallocatairecaf`, `idlienfamille`, `idcaissecaf`, `idniveauetude`, `idprofession`, `idcaissemut`, `idcaissesecu`, `idsitfam`, `idnationalite`, `idvillenaissance`, `idfoyer`) VALUES
(1, 'Madame', 'Osef', 'Lapraline', NULL, NULL, 0, 626396400, 'Homme', '0383828113', '0679809964', 'florian.janson@mydevhouse.com', 0, 0, 0, 'Local', 1, 0, 943916400, '00000001', 0, 0, 1, 'Moi même', 1304719200, 1312754400, 1344376800, '5425365254', '', 18, 1, 9, 7, 12, 2, 4, 1, 168, 1),
(2, 'Monsieur', 'Pupu', 'Coco', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Monsieur', 'Perlin', 'Pinpin', NULL, NULL, 0, 0, 'Femme', 'test', 'test', 'test', 0, 0, 0, 'Général', 0, 943916400, 943916400, '', 943916400, 943916400, 1, NULL, NULL, NULL, NULL, NULL, '0001', 37, 1, NULL, NULL, 12, 2, 8, 4, 0, 1),
(4, 'Monsieur', 'test', 'test', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(7, 'Madame', 'w', 'w', ' ', ' ', 1, 0, ' ', ' ', ' ', ' ', 0, 0, 0, ' ', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, ' ', ' ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `instruct`
--

CREATE TABLE IF NOT EXISTS `instruct` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT ' ',
  `adresse` varchar(255) DEFAULT ' ',
  `telephone` varchar(15) DEFAULT ' ',
  `interne` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `instruct`
--

INSERT INTO `instruct` (`id`, `nom`, `adresse`, `telephone`, `interne`) VALUES
(1, 'HERMANN Catherine', '', '', 0),
(2, 'PIERRE PICCININNO Carine', '', '', 0),
(3, 'BAUDIN Isabelle', '', '', 0),
(4, 'PIGNON Valérie', 'CMS', '', 0),
(5, 'GENTILHOMME', '', '', 0),
(6, 'HOUAR Rachida', 'Mission Locale', '', 0),
(7, 'GERNE Laurence', 'CMS', '', 0),
(8, 'GEHAY', 'CPAM', '', 0),
(9, 'SIEJA Nadine', '', '', 0),
(10, 'TOSCANO Angèle', '', '', 0),
(11, 'BOHÊME Céline', '', '', 0),
(12, 'SCHEIDT Karine', '', '', 0),
(13, 'TRIBOUT Mélanie', '', '', 0),
(14, 'BOUCHER Anne Valérie', '', '', 0),
(15, 'DIESLER Catherine', 'CMS, Esplanade de la Liberté - HAYANGE', '0387350160', 0),
(16, 'Mme DOUILLET', '', '', 0),
(17, 'CMS Thionville', '', '', 0),
(18, 'ILHE Julie', '', '', 0),
(19, 'SCHEED Sophie', '', '', 0),
(20, 'BARTHELEMY Noémie', 'UDAF', '', 0),
(21, 'Armée du Salut', '', '', 0),
(22, 'HOUPERT PETIT Catherine', '', '', 0),
(23, 'MACALUSO Lidia', '', '', 0),
(24, 'Chantal VILLEMIN', '', '', 0),
(25, 'AUBURTIN Chantal', '', '', 0),
(26, 'FRANK Laurence', '', '', 0),
(27, 'PIERRE-PICCININNO Carine', '', '', 1),
(28, 'PIMENTEL Véronique', '', '', 1),
(29, 'BOHEME Céline', '', '', 1),
(30, 'IGEL Sabine', '', '', 1),
(31, 'LAVARONE Lorella', '', '', 1),
(32, 'SCHEED Sophie', '', '', 1),
(33, 'MARCONATO Jeanne', '', '', 1),
(34, 'TRIBOUT Mélanie', '', '', 1),
(35, 'BOUCHER Anne Valérie', '', '', 1),
(37, 'UWERA Helga', '', '', 1),
(38, 'Stagiaire', '', '', 1),
(39, 'LISPI Benoit', '', '', 1),
(40, 'Stagiaire CESF', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `libelleorganisme`
--

CREATE TABLE IF NOT EXISTS `libelleorganisme` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `libelleorganisme`
--

INSERT INTO `libelleorganisme` (`id`, `libelle`) VALUES
(1, 'Caisse CAF'),
(2, 'Caisse SECU'),
(3, 'Distributeur'),
(4, 'Mutuelle'),
(5, 'Organisme d''aide externe');

-- --------------------------------------------------------

--
-- Structure de la table `lienfamille`
--

CREATE TABLE IF NOT EXISTS `lienfamille` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lien` varchar(100) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Contenu de la table `lienfamille`
--

INSERT INTO `lienfamille` (`id`, `lien`) VALUES
(1, 'Enfant du couple'),
(2, 'Chef lui même'),
(3, 'Epouse'),
(5, 'Compagne'),
(6, 'Beau-fils'),
(7, 'Belle-fille'),
(8, 'Gendre'),
(9, 'Grand-mère'),
(10, 'Grand-père'),
(11, 'Soeur'),
(12, 'Epoux'),
(13, 'Enfant de Mme'),
(14, 'Enfant de Mr'),
(15, 'Chef elle même'),
(16, 'Compagnon'),
(17, 'Hébergé(e)'),
(18, 'Ami'),
(19, 'Belle-soeur'),
(20, 'Décédée'),
(21, 'Fille'),
(22, 'Fils'),
(23, 'Frère'),
(24, 'Mère Mme'),
(25, 'Mère Mr'),
(26, 'Père Mme'),
(27, 'Père Mr'),
(28, 'Neuveu'),
(29, 'Nièce'),
(30, 'Parti'),
(31, 'Petit fils'),
(32, 'Petite fille'),
(33, 'Fille de Mme'),
(34, 'Fils de Mme'),
(35, 'Mère'),
(36, 'Partie'),
(37, 'Décédé'),
(38, 'Ex compagnon'),
(39, 'Père');

-- --------------------------------------------------------

--
-- Structure de la table `nationalite`
--

CREATE TABLE IF NOT EXISTS `nationalite` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nationalite` varchar(90) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `nationalite`
--

INSERT INTO `nationalite` (`id`, `nationalite`) VALUES
(1, 'Française'),
(2, 'marocaine'),
(3, 'algérienne'),
(4, 'Arménienne'),
(5, 'Congolaise'),
(6, 'luxembourgeoise'),
(7, 'turque'),
(8, 'Yougoslave');

-- --------------------------------------------------------

--
-- Structure de la table `organisme`
--

CREATE TABLE IF NOT EXISTS `organisme` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idlibelleorganisme` bigint(20) DEFAULT NULL,
  `appelation` varchar(50) DEFAULT ' ',
  `adresse` varchar(200) DEFAULT ' ',
  `cp` varchar(10) DEFAULT ' ',
  `ville` varchar(50) DEFAULT ' ',
  `telephone` varchar(50) DEFAULT ' ',
  `fax` varchar(50) DEFAULT ' ',
  `email` varchar(50) DEFAULT ' ',
  `note` varchar(200) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `organisme`
--

INSERT INTO `organisme` (`id`, `idlibelleorganisme`, `appelation`, `adresse`, `cp`, `ville`, `telephone`, `fax`, `email`, `note`) VALUES
(1, 1, 'Metz', '1', '57774', 'Metz', '', '', '', ''),
(2, 2, 'CPAM de Thionville', '0', '', '', '', '', '', ''),
(3, 2, 'LUXEMBOURG', '0', '', '', '', '', '', ''),
(4, 3, 'GDF', '0', '22308', 'LANNION CEDEX', '09 69 324 324', '', '', ''),
(5, 3, 'Syndicat Intercommunal Eau et Assainissement de Fo', '1', '57650', 'FONTOY', '03 82 59 10 10', '03 82 84 93 97', '', ''),
(6, 3, 'EDF Bleu Ciel', '0', '93733', 'BOBIGNY CEDEX 9', '09 69 39 33 04', '', '', ''),
(7, 3, 'BATIGERE', '1', '57100', 'THIONVILLE', '03 82 88 01 56', '', '', ''),
(8, 3, 'MOSELIS', '1', '57106', 'THIONVILLE', '08 82 88 12 13', '03 82 34 47 06', '', ''),
(9, 3, 'LOGIEST', '1', '57290', 'FAMECK', '03 82 59 59 80', '03 82 59 59 88', 'service.locatif@logiest.fr', ''),
(10, 3, 'ADOMA', '1', '57700', 'HAYANGE', '03.82.84.14.12', '', '', 'Portable de Mme CLEMENT 06.26.38.73.26'),
(11, 4, 'PREVIADES', '0', '', '', '', '', '', ''),
(12, 4, 'CREDI MUTUEL WOIPPY', '0', '', '', '', '', '', ''),
(13, 4, 'BERGER SIMON METZ', '0', '', '', '', '', '', ''),
(14, 5, 'FSL', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 5, 'Caisse de retraite', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 5, 'Fondation AbbÃ© Pierre', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `profession`
--

CREATE TABLE IF NOT EXISTS `profession` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profession` varchar(100) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `profession`
--

INSERT INTO `profession` (`id`, `profession`) VALUES
(1, 'Secrétaire'),
(2, 'Chauffagiste'),
(3, 'Gestionnaire pocheur'),
(4, 'Opérateur de production'),
(5, 'Sans activité'),
(6, 'restauration'),
(7, 'apprenti peintre'),
(8, 'vendeuse'),
(9, 'Ouvrier polyvalent'),
(10, 'retraitée'),
(11, 'Maçon'),
(12, 'agent d''entretien'),
(13, 'téléconseiller'),
(14, 'Congé parental'),
(15, 'Chômage'),
(16, 'Retraité'),
(17, 'Chômage- ASS'),
(18, 'peintre en batiment'),
(19, 'Chomage'),
(20, 'Salarié'),
(21, 'Factrice'),
(22, 'agent de tri'),
(23, 'AAH'),
(24, 'Assistante Maternelle');

-- --------------------------------------------------------

--
-- Structure de la table `revenu`
--

CREATE TABLE IF NOT EXISTS `revenu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `salaire` float(18,2) DEFAULT '0.00',
  `chomage` float(18,2) DEFAULT '0.00',
  `revenualloc` float(18,2) DEFAULT '0.00',
  `ass` float(18,2) DEFAULT '0.00',
  `aah` float(18,2) DEFAULT '0.00',
  `rsasocle` float(18,2) DEFAULT '0.00',
  `rsaactivite` float(18,2) DEFAULT '0.00',
  `pensionalim` float(18,2) DEFAULT '0.00',
  `pensionretraite` float(18,2) DEFAULT '0.00',
  `retraitcomp` float(18,2) DEFAULT '0.00',
  `autrerevenu` float(18,2) DEFAULT '0.00',
  `natureautre` varchar(150) DEFAULT NULL,
  `idindividu` bigint(20) DEFAULT '0',
  `aidelogement` float(18,2) DEFAULT '0.00',
  `datecreation` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `revenu`
--

INSERT INTO `revenu` (`id`, `salaire`, `chomage`, `revenualloc`, `ass`, `aah`, `rsasocle`, `rsaactivite`, `pensionalim`, `pensionretraite`, `retraitcomp`, `autrerevenu`, `natureautre`, `idindividu`, `aidelogement`, `datecreation`) VALUES
(2, 96.00, 0.00, 0.00, 0.00, 18.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 1, 0.00, 1331136849),
(3, 10006.00, 0.00, 0.00, 0.00, 18.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 1, 0.00, 1331137203),
(4, 1.78, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1.00, 0.00, 0.00, 0.00, '', 1, 0.00, 1331571992),
(5, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 4, 0.00, 1331569011),
(6, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 2, 0.00, 1331569612),
(7, 0.00, 0.00, 0.00, 0.00, 520.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 3, 0.00, 1331569618),
(8, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 5, 0.00, 1331648671),
(9, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 6, 0.00, 1331648779),
(10, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', 7, 0.00, 1331661060);

-- --------------------------------------------------------

--
-- Structure de la table `rue`
--

CREATE TABLE IF NOT EXISTS `rue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rue` varchar(255) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=258 ;

--
-- Contenu de la table `rue`
--

INSERT INTO `rue` (`id`, `rue`) VALUES
(1, 'Rue des Ardennes'),
(2, 'Rue d''Artois'),
(3, 'Impasse Bellevue'),
(4, 'Rue Bellevue'),
(5, 'Rue de Beuvange'),
(6, 'Rue de Bourgogne'),
(7, 'Rue de Bretagne'),
(8, 'Rue des Capucines'),
(10, 'Rue de la Ceca'),
(11, 'Impasse du Cèdre'),
(12, 'Impasse du Charme'),
(13, 'Rue du Chêne'),
(14, 'Rue Ambroise-Croizat'),
(15, 'Rue des Dahlias'),
(16, 'Rue d''Elange'),
(17, 'Rue de l''Etang'),
(18, 'Impasse Yves-Farges'),
(19, 'Rue Yves-Farges'),
(20, 'Impasse de la Fôret'),
(21, 'Rue de la Fôret'),
(22, 'Hameau des trois sources'),
(23, 'Rue du Konacker'),
(24, 'Rue des Lilas'),
(25, 'Impasse du Merisier'),
(26, 'Avenue de la Métropole'),
(27, 'Rue de Metzange'),
(28, 'Rue du Mimosa'),
(29, 'Rue du Muguet'),
(30, 'Rue Pablo Néruda'),
(31, 'Impasse du Nordmann'),
(32, 'Rue d'' Oeutrange'),
(33, 'Impasse de l''Orme'),
(34, 'Avenue des Peupliers'),
(35, 'Place Saint-Jean'),
(36, 'Rue de Provence'),
(37, 'Rue des Roses'),
(38, 'Avenue Saint-Jean'),
(39, 'Rue Saint-Michel'),
(40, 'Rue de la Sapinette'),
(41, 'Rue de Savoie'),
(42, 'Rue du Stand'),
(43, 'Rue de Touraine'),
(44, 'Rue des Tulipes'),
(45, 'Rue de Veymerange'),
(47, 'Rue du Bouvreuil'),
(48, 'Rue G.-Brassens'),
(49, 'Rue du Bruhl'),
(50, 'Cité du Bruhl'),
(51, 'Rue du Canal'),
(52, 'Rue du Chardonneret'),
(53, 'Impasse André-Chenier'),
(54, 'Rue du Cimetière'),
(55, 'Rue de la Côte'),
(56, 'Rue Pierre et Marie Curie'),
(57, 'Place du Dix-Neuf-Mars-1962'),
(58, 'Rue de l''Ecole'),
(59, 'Rue de L''Eglise'),
(60, 'Rue de L''Europe'),
(61, 'Rue de la Fauvette'),
(62, 'Rue de la Fenderie'),
(63, 'Rue du Duc de Fleury'),
(64, 'Rue du Docteur Gillard'),
(65, 'Rue de la Hardt'),
(66, 'Rue Victor-Hugo'),
(67, 'Rue du Docteur Jacobs'),
(68, 'Rue des Jardins'),
(69, 'Rue Alphonse de Lamartine'),
(70, 'Rue du Lavoir'),
(71, 'Rue de Leyrange'),
(72, 'Rue de Liaison'),
(73, 'Rue de la Libération'),
(74, 'Rue Louise Michel'),
(75, 'Rue Pierre-Mendès-France'),
(76, 'Rue du Merle'),
(77, 'Impasse de la Minière'),
(78, 'Rue de Nilvange'),
(79, 'Rue des Pommiers'),
(80, 'Rue Marcel Pagnol'),
(81, 'Rue du Réservoir'),
(82, 'Rue Arthur-Rimbaud'),
(83, 'Rue Claude-Robbe'),
(84, 'Rue du Roitelet'),
(85, 'Impasse Pierre de Ronsard'),
(86, 'Impasse Jean-Jacques-Rousseau'),
(87, 'Rue en Ruelle'),
(88, 'Rue du Ruisseau'),
(89, 'Rue Saint-Martin'),
(90, 'Rue Saint-Sixte'),
(91, 'Rue du Six Juin 1944'),
(92, 'Rue des Sources'),
(93, 'Rue du Thal'),
(94, 'Rue du Theilesch'),
(95, 'Rue du Tivoli'),
(96, 'Rue de la Tourterelle'),
(97, 'Rue Paul Verlaine'),
(98, 'Impasse Alfred de Vigny'),
(99, 'Impasse de Volkrange'),
(100, 'Rue du Docteur Wonner'),
(101, 'Rue Roi Albert 1er'),
(102, 'Rue des Alizés'),
(103, 'Rue de l''Aquillon'),
(104, 'Rue Jeanne D''Arc'),
(105, 'Rue d''Argonne'),
(106, 'Impasse de l''Autan'),
(107, 'Rue Casimir de Balthasard'),
(108, 'Place Francois-Joseph-Barba'),
(109, 'Rue Maryse Bastié'),
(110, 'Cité Bellevue'),
(111, 'Rue Anthime Bosment'),
(112, 'Rue des Brebis'),
(113, 'Place Jean Burger'),
(116, 'Impasse Gustave Charpentier'),
(117, 'Rue Général de Castelnau'),
(118, 'Rue du Collège'),
(119, 'Sentier Côte-Fêche'),
(120, 'Chemin Creux'),
(121, 'Rue G-Clémenceau'),
(122, 'Boulevard Eole'),
(123, 'Impasse Gabriel Faure'),
(124, 'Rue de la Fensch'),
(125, 'Rue de la Flatte'),
(126, 'Rue Maréchal Foch'),
(127, 'Rue de la Fontaine'),
(128, 'Rue Marie Gabrielle'),
(129, 'Rue de la Galerne'),
(130, 'Impasse Louis-Ganne'),
(131, 'Rue du Général de Gaulle'),
(132, 'Rue de la Gendarmerie'),
(133, 'Rue des Grands-Bois'),
(134, 'Boulevard de l''Harmattan'),
(135, 'Rue de l''Hôtel de Ville'),
(136, 'Rue Jean-Jaurès'),
(137, 'Impasse du Joran'),
(138, 'Rue Maréchal-Joffre'),
(139, 'Rue Général-Leclerc'),
(140, 'Esplanade de la Liberté'),
(141, 'Rue Théophile-Maire'),
(142, 'Rue Général Mangin'),
(143, 'Rue de la Marne'),
(144, 'Rue de la Matinière'),
(145, 'Rue Pierre-Mendès-France'),
(146, 'Rue de la Mine'),
(147, 'Rue du Mistral'),
(148, 'Rue Maréchal Molitor'),
(149, 'Rue Jean-Moulin'),
(150, 'Rue Abbé-Pierre-Nicolay'),
(151, 'Rue Notre Dame'),
(152, 'Allée Jacques Offenbach'),
(153, 'Rue du 11 Novembre'),
(154, 'Place de la Paix'),
(155, 'Rue Pasteur'),
(156, 'Impasse Marcel-Paul'),
(157, 'Impasse Gabriel Pierne'),
(158, 'Rue de la Platinerie'),
(159, 'Rue Raymond Poincaré'),
(160, 'Place de la Résistance et de la Déportation'),
(162, 'Rue Saint Antoine'),
(163, 'Rue Saint Charles'),
(164, 'Rue Sainte Alice'),
(165, 'Rue Sainte Andrée'),
(166, 'Faubourg Sainte Berthe'),
(167, 'Rue Sainte Caroline'),
(168, 'Faubourg Sainte Catherine'),
(169, 'Rue Sainte Eulalie'),
(170, 'Rue Sainte Hélène'),
(171, 'Rue Sainte Odette'),
(172, 'Rue Sainte Sophie'),
(173, 'Rue Saint François'),
(174, 'Rue Saint Henri'),
(175, 'Place Saint Martin'),
(176, 'Faubourg Saint Maurice'),
(177, 'Rue Saint Robert'),
(178, 'Rue Saint Théodore'),
(179, 'Impasse Florent  Schmitt'),
(180, 'Place Nicolas Schneider'),
(181, 'Rue Albert Schweitzer'),
(182, 'Rue du Sirocco'),
(183, 'Impasse Ambroise Thomas'),
(184, 'Rue Jacques Tourneur'),
(185, 'Rue de la Tramontane'),
(186, 'Rue de Verdun'),
(187, 'Rue de la Mine Victor'),
(188, 'Rue des Vignes'),
(189, 'Rue De Wendel'),
(190, 'Impasse du Zéphyr'),
(191, 'Rue de la Biche'),
(192, 'Place Edith et Hervé Bonnet'),
(193, 'Rue du Boucher'),
(194, 'Rue des Bouleaux'),
(195, 'Place du Bout des Terres'),
(196, 'Rue des Buissons'),
(197, 'Place du Chêne'),
(198, 'Rue de la Clairière'),
(200, 'Rue de la Combe'),
(201, 'Rue du Coq de Bruyère'),
(202, 'Rue de Douaumont'),
(203, 'Place de Fameck'),
(204, 'Rue Jules Ferry'),
(205, 'Rue de la Fontaine'),
(206, 'Rue Charles Gambier'),
(207, 'Place des Genêts'),
(208, 'Allée des Hêtres'),
(209, 'Rue de l''Ill'),
(210, 'Boulevard du Jura'),
(211, 'Rue du Lapin'),
(212, 'Place du Lièvre'),
(213, 'Rue de Lorraine'),
(214, 'Allée des Mélèzes'),
(215, 'Place de Metz'),
(216, 'Rue de la Meuse'),
(217, 'Rue de la Moselle'),
(218, 'Place des Pâquerettes'),
(219, 'Rue Pablo Picasso'),
(220, 'Place de Ranguevaux'),
(221, 'Rue du Renard'),
(222, 'Rue du Rhin'),
(223, 'Rue du Saloir'),
(224, 'Rue du Sanglier'),
(225, 'Allée des Sapins'),
(226, 'Rue de la Seine'),
(227, 'Allée de Toul'),
(228, 'Boulevard de la Tour Neuve'),
(229, 'Allée des Trois Evéchés'),
(230, 'Rue des Trois Petits Enfants'),
(231, 'Rue des Troënes'),
(232, 'Rue du Vallon'),
(233, 'Boulevard des Vosges'),
(235, 'Site Sainte-Neige'),
(236, 'Rue Poincaré'),
(238, 'Place de la Comédie'),
(239, 'Impasse A.Thomas'),
(240, 'Impasse Normann'),
(242, 'Parking Foch'),
(243, 'Route de Volkrange'),
(244, 'Parking Foch'),
(245, 'Passage Foch'),
(248, 'Collège MONOD'),
(249, 'Impasse Alfred de Vigny'),
(250, 'Rue du Joran'),
(251, 'Rue Leclerc'),
(252, 'des bergeronnettes'),
(253, 'Impasse du Meunier'),
(254, 'd''oeutrange'),
(255, 'georges clemenceau'),
(256, 'General de Castelnau'),
(257, 'impasse diekirch');

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

CREATE TABLE IF NOT EXISTS `secteur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `secteur` varchar(255) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `secteur`
--

INSERT INTO `secteur` (`id`, `secteur`) VALUES
(1, 'Hayange Centre'),
(2, 'Konacker'),
(3, 'Marspich'),
(4, 'St-Nicolas-en-Forêt'),
(5, 'Grands Bois');

-- --------------------------------------------------------

--
-- Structure de la table `situationmatri`
--

CREATE TABLE IF NOT EXISTS `situationmatri` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `situation` varchar(100) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `situationmatri`
--

INSERT INTO `situationmatri` (`id`, `situation`) VALUES
(1, 'Marié(e)'),
(2, 'Divorcé(e)'),
(3, 'Séparé(e)'),
(4, 'Célibataire'),
(5, 'Vie maritale'),
(6, 'Veuf'),
(7, 'Veuve'),
(8, 'Décédé');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categorie` bigint(20) DEFAULT '0',
  `libelle` varchar(50) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id`, `categorie`, `libelle`) VALUES
(1, 2, ' F1'),
(2, 2, ' F2'),
(3, 3, 'Locataire'),
(4, 3, 'Propriétaire'),
(5, 4, ' Visite à domicile'),
(6, 4, ' Courrier');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT ' ',
  `password` varchar(80) DEFAULT NULL,
  `nomcomplet` varchar(200) DEFAULT ' ',
  `idinstruct` bigint(20) DEFAULT NULL,
  `level` varchar(5) DEFAULT ' ',
  `actif` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `nomcomplet`, `idinstruct`, `level`, `actif`) VALUES
(1, 'Florian', '56910c52ed70539e3ce0391edeb6d339', 'Janson Florian', 0, '1111', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cp` varchar(10) DEFAULT ' ',
  `libelle` varchar(255) DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=272 ;

--
-- Contenu de la table `ville`
--

INSERT INTO `ville` (`id`, `cp`, `libelle`) VALUES
(1, '57970', 'YUTZ'),
(2, '57100', 'THIONVILLE'),
(3, '57440', 'ALGRANGE'),
(4, '57360', 'AMNEVILLE'),
(5, '57330', 'HETTANGE GRANDE'),
(6, '57110', 'KUNTZIG'),
(7, '57000', 'METZ'),
(8, '57300', 'MONDELANGE'),
(9, '57158', 'MONTIGNY LES METZ'),
(10, '57270', 'UCKANGE'),
(11, '57140', 'WOIPPY'),
(12, '57134', 'DISTROFF'),
(13, '57180', 'TERVILLE'),
(14, '57480', 'SIERCK LES BAINS'),
(15, '57480', 'RUSTROFF'),
(16, '93150', 'LE BLANC MESNIL'),
(17, '57365', 'ENNERY'),
(18, '54000', 'NANCY'),
(19, '57310', 'GUENANGE'),
(20, '57700', 'HAYANGE'),
(21, '57190', 'FLORANGE'),
(22, '57570', 'CATTENOM'),
(23, '57650', 'FONTOY'),
(24, '57840', 'OTTANGE'),
(25, '57970', 'STUCKANGE'),
(26, '57780', 'ROSSELANGE'),
(27, '57970', 'ILLANGE'),
(28, '57290', 'FAMECK'),
(29, '67000', 'STRASBOURG'),
(30, '54300', 'MARAINVILLER'),
(31, '57150', 'CREUTZWALD'),
(32, '57940', 'METZERVISSE'),
(33, '57970', 'BASSE-HAM'),
(34, '57480', 'HUNTING'),
(35, '57640', 'BETTELAINVILLE'),
(36, '57185', 'VITRY/ORNE'),
(37, '57480', 'MALLING'),
(38, '57300', 'HAGONDANGE'),
(39, '', 'WALDWISSE'),
(40, '57185', 'CLOUANGE'),
(41, '57970', 'ELZANGE'),
(42, '57000', 'LORRY LES METZ'),
(43, '52600', 'CHALINDREY'),
(44, '88100', 'SAINT DIE'),
(45, '88008', 'EPINAL'),
(46, '57860', 'MONTOIS LA MONTAGNE'),
(47, '57480', 'HALSTROFF'),
(48, '57240', 'KNUTANGE'),
(49, '57920', 'KEDANGE SUR CANNER'),
(50, '57803', 'FREYMING MERLEBACH'),
(51, '57570', 'BOUST'),
(52, '57150', 'CREUTZWALD'),
(53, '57940', 'VOLSTROFF'),
(54, '70220', 'FOUGEROLLES'),
(55, '70200', 'ROYE'),
(56, '57220', 'TETERCHEN'),
(57, '', 'TRIER'),
(58, '57655', 'BOULANGE'),
(59, '57590', 'AULNOIS SUR SEILLE'),
(60, '', 'SARREBOURG'),
(61, '57440', 'ANGEVILLERS'),
(62, '54150', 'BRIEY'),
(63, '57970', 'METRICH'),
(64, '57480', 'APACH'),
(65, 'L7410', 'ANGELSBERG'),
(66, '67760', 'GAMBSHEIM'),
(67, '57100', 'KOEKING'),
(68, '57100', 'GUENTRANGE'),
(69, '57100', 'BERTRANGE'),
(70, '57070', 'SAINT JULIEN LES METZ'),
(71, '59620', 'AULNOYE'),
(72, '13000', 'MARSEILLE'),
(73, '57130', 'ARS / MOSELLE'),
(74, '57570', 'PUTTELANGE LES THIONVILLE'),
(75, '57100', 'MANOM'),
(76, '54860', 'HAUCOURT MOULAINE'),
(77, '83570', 'CARCES'),
(78, '57480', 'HAUTE SIERCK'),
(79, '57920', 'VECKRING'),
(80, '57480', 'REMELING'),
(81, '54310', 'HOMECOURT'),
(82, '57340', 'MORHANGE'),
(83, '62400', 'BETHUNES'),
(84, '62920', 'CHOCQUES'),
(85, '56330', 'PLUVIGNER'),
(86, '08000', 'CHARLEVILLE MEZIERES'),
(87, '54390', 'FROUARD'),
(88, '54300', 'LUNEVILLE'),
(89, '57310', 'BOUSSE'),
(90, '57290', 'SEREMANGE'),
(91, '57175', 'GANDRANGE'),
(92, '26780', 'CHATEAUNEUF du Rhône'),
(93, '57330', 'ENTRANGE'),
(94, '54200', 'TOUL'),
(95, '55310', 'TRONVILLE EN BARROIS'),
(96, '57300', 'AY SUR MOSELLE'),
(97, '57280', 'SEMECOURT'),
(98, '', 'HOUDEMONT'),
(99, '57390', 'AUDUN LE TICHE'),
(100, '57690', 'ZIMMING'),
(101, '57530', 'PANGE'),
(102, '57920', 'METZERESCHE'),
(103, '57970', 'KOENIGSMACKER'),
(104, '57330', 'ROUSSY LE BOURG'),
(105, '57700', 'MARSPICH'),
(106, '57240', 'NILVANGE'),
(107, '57970', 'VALMESTROFF'),
(108, '57280', 'MAIZIERES LES METZ'),
(109, '57320', 'FERANGE'),
(110, '57570', 'EVRANGE'),
(111, '57200', 'SARREGUEMINES'),
(112, '81370', 'RICQUEBOURG'),
(113, '81370', 'Saint SULPICE'),
(114, '57920', 'BUDING'),
(115, '54580', 'MOINEVILLE'),
(116, '57525', 'TALANGE'),
(117, '57480', 'KIRSCHNAUMEN'),
(118, '75545', 'PARIS'),
(119, '68140', 'ESCHBACH AU VAL'),
(120, '54135', 'MEXY'),
(121, '69780', 'MIONS'),
(122, '69200', 'VENISSIEUX'),
(123, '69140', 'RILLIEUX LA PAPE'),
(124, '57480', 'RETTEL'),
(125, '79000', 'NIORT'),
(126, '57970', 'BUDLING'),
(127, '57310', 'RURANGE LES THIONVILLE'),
(128, '57645', 'NOUILLY'),
(129, '54800', 'JARNY'),
(130, '57320', 'EBERSVILLER'),
(131, '54150', 'MANCE'),
(132, '54970', 'LANDRES'),
(133, '94350', 'VILLIERS SUR MARNE'),
(134, '54560', 'AUDUN LE ROMAN'),
(135, '57270', 'RICHEMONT'),
(136, '57120', 'ROMBAS'),
(137, '57250', 'MOYEUVRE GRANDE'),
(138, '57100', 'THIONVILLE - BEUVANGE'),
(139, '88800', 'VITTEL'),
(140, '54140', 'JARVILLE'),
(141, '54350', 'MONT SAINT MARTIN'),
(142, '57645', 'RETONFEY'),
(143, '04200', 'SISTERON'),
(144, '57100', 'THIONVILLE VEYMERANGE'),
(145, '57535', 'MARANGE SILVANGE'),
(146, '57570', 'GAVISSE'),
(147, '54560', 'BOUDREZY'),
(148, '57640', 'VIGY'),
(149, '57700', 'NEUFCHEF'),
(150, '55500', 'LIGNY EN BARROIS'),
(151, '52100', 'BETTANCOURT LA Ferrée'),
(152, '57600', 'FORBACH'),
(153, '57860', 'MONTOIS LA MONTAGNE'),
(154, '31250', 'REVEL'),
(155, '31080', 'TOULOUSE'),
(156, '54560', 'FILLIERES'),
(157, '', 'vandoeuvre les Nancy'),
(158, '54000', 'VANDOEUVRE'),
(159, '94550', 'CHEVILLY LARUE'),
(160, '59760', 'GRANDE SYNTHE'),
(161, '62219', 'LONGUENESSE'),
(162, '54490', 'JOUDREVILLE'),
(163, '54490', 'JOUDREVILLE'),
(164, '57350', 'STIRING WINDEL'),
(165, '57920', 'HOMBOURG BUDANGE'),
(166, '57330', 'KANFEN'),
(168, '', 'PONT A MOUSSON'),
(169, '57320', 'BOUZONVILLE'),
(170, '72016', 'LE MANS'),
(171, '57970', 'OUDRENNE'),
(172, '', 'RODEMACK'),
(173, '57380', 'FAULQUEMONT'),
(174, '57504', 'SAINT AVOLD'),
(175, '54750', 'TRIEUX'),
(176, '57480', 'MERSCHWEILLER'),
(177, '54440', 'HERSERANGE'),
(178, '54190', 'VILLERUPT'),
(179, '88520', 'WISEMBACH'),
(180, '57710', 'AUMETZ'),
(181, '55130', 'DELOUZE'),
(182, '06320', 'CAP D''AIL'),
(183, '57330', 'VOLMERANGE LES MINES'),
(184, '52300', 'VAUX-SUR-ST-URBAIN'),
(185, '57480', 'KIRCH LES SIERCK'),
(186, '57185', 'VITRY SUR ORNE'),
(187, '54500', 'VANDOEUVRE LES NANCY'),
(188, '54400', 'LONGWY'),
(189, '33510', 'ANDERNOS LES BAINS'),
(190, '54130', 'SAINT MAX'),
(191, '67140', 'MAUVES SUR HUINE'),
(192, '57480', 'KIRSCHNAUMEN'),
(193, '93800', 'EPINAY SUR SEINE'),
(194, '57390', 'RUSSANGE'),
(195, '57430', 'SARRALBE'),
(196, '52000', 'CHAUMONT'),
(197, '17300', 'ROCHEFORT SUR MER'),
(198, '57490', 'L''HOPITAL'),
(199, '94270', 'LE KREMLIN-BICETRE'),
(200, '57300', 'TREMERY'),
(201, '93120', 'LA COURNEUVE'),
(202, '57330', 'ROUSSY LE VILLAGE'),
(203, '57570', 'FIXEM'),
(204, '57100', 'VOLKRANGE'),
(205, '57100', 'GARCHE'),
(206, '54400', 'LONGWY'),
(207, '57320', 'WALDWEISTROFF'),
(208, '82370', 'LABASTIDE St Pierre'),
(209, '57330', 'ZOUFFTGEN'),
(210, '57480', 'PETITE HETTANGE'),
(211, '52000', 'Villiers le Sec'),
(212, '52000', 'VILLIERS-LE-SEC'),
(213, '', 'PORT LA NOUVELLE'),
(214, '27100', 'VAL DE REUIL'),
(215, '57330', 'ESCHERANGE'),
(216, '67500', 'HAGUENAU'),
(217, '54470', 'SAINT JULIEN LES GORZE'),
(218, '57740', 'Longeville les St Avold'),
(219, '57450', 'HENRIVILLE'),
(220, '57650', 'HAVANGE'),
(221, '57320', 'CHEMERY LES DEUX'),
(222, '57480', 'CONTZ LES BAINS'),
(223, '57160', 'SCY-CHAZELLES'),
(224, '55400', 'ETAIN'),
(225, '30120', 'LE VIGAN'),
(226, '30120', 'LE VIGAN'),
(227, '54590', 'HUSSIGNY'),
(228, '57480', 'BIZING'),
(229, '54260', 'VILLANCY'),
(230, '', 'LUXEMBOURG'),
(231, 'L5810', 'HESPERANGE'),
(233, '55400', 'WARCQ'),
(234, '55600', 'MONTMEDY'),
(235, '57050', 'PLAPEVILLE'),
(236, '57100', 'TRESSANGE'),
(237, '60570', 'ANDEVILLE'),
(238, '54260', 'LONGUYON'),
(239, '27460', 'LE MANOIR'),
(240, '27460', 'AMFREVILLE LA CAMPAGNE'),
(241, '38260', 'LA COTE SAINT ANDRE'),
(242, '57630', 'VIC SUR SEILLE'),
(243, '54520', 'LAXOU'),
(244, '57320', 'DALSTEIN'),
(245, '57700', 'Hayange'),
(246, '62', 'BIACHE ST VAAST'),
(247, '89', 'AVALLON'),
(248, '', 'MAROC'),
(249, '', 'ARMENIE'),
(250, '', 'FORT DE FRANCE'),
(251, '', 'ALGERIE'),
(252, '', 'KINSHASA'),
(253, '', 'THIERS'),
(254, '', 'LIBARCOURT'),
(255, '', 'VILLERVE 54'),
(256, '', 'ETTELBRUCK'),
(257, 'PARIS', 'FONTAINEBLEAU'),
(258, '', 'TURQUIE'),
(259, '', 'BOULAY'),
(260, '92000', 'GENNEVILLIERS'),
(261, 'ALGER', 'BOUIRA'),
(262, '', 'YOUGOSLAVIE'),
(263, '', 'ALLEMAGNE'),
(264, '', 'SAINT DIZIER'),
(265, '54240', 'JOEUF'),
(266, '', 'KOSOVO'),
(267, '', 'EX URSS'),
(268, '', 'ROUMANIE'),
(269, '', 'SOMME'),
(270, '', 'LE HAVRE'),
(271, '66000', 'PERPIGNAN');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
