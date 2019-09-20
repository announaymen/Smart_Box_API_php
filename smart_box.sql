-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 20 sep. 2019 à 17:34
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `smart_box`
--

-- --------------------------------------------------------

--
-- Structure de la table `box`
--

CREATE TABLE `box` (
  `idBox` int(11) NOT NULL,
  `idCasier` int(11) NOT NULL,
  `etat` varchar(20) NOT NULL,
  `longeur` int(11) NOT NULL,
  `largeur` int(11) NOT NULL,
  `hauteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `box`
--

INSERT INTO `box` (`idBox`, `idCasier`, `etat`, `longeur`, `largeur`, `hauteur`) VALUES
(0, 1, 'actif', 400, 80, 200),
(2, 1, 'inactif', 400, 80, 200);

-- --------------------------------------------------------

--
-- Structure de la table `box_contient_colis`
--

CREATE TABLE `box_contient_colis` (
  `idCasier` int(11) NOT NULL,
  `idBox` int(11) NOT NULL,
  `idColis` int(11) NOT NULL,
  `idVendeur` int(11) NOT NULL,
  `idLivreur` int(11) NOT NULL,
  `dateDepot` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateRecuperation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `box_contient_colis`
--

INSERT INTO `box_contient_colis` (`idCasier`, `idBox`, `idColis`, `idVendeur`, `idLivreur`, `dateDepot`, `dateRecuperation`) VALUES
(1, 0, 545, 1, 1, '2019-09-20 14:29:30', '2019-09-20 14:29:30'),
(1, 2, 113, 1, 1, '2019-09-20 15:14:54', '2019-09-20 15:14:54');

-- --------------------------------------------------------

--
-- Structure de la table `casier`
--

CREATE TABLE `casier` (
  `idcasier` int(20) NOT NULL,
  `code_commune` int(4) NOT NULL,
  `adress` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `casier`
--

INSERT INTO `casier` (`idcasier`, `code_commune`, `adress`) VALUES
(1, 16, 'bab zouar'),
(2, 17, 'el_harrach'),
(3, 18, 'grande poste'),
(4, 19, 'el hamma');

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

CREATE TABLE `livreur` (
  `idLivreur` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `salaire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `livreur`
--

INSERT INTO `livreur` (`idLivreur`, `nom`, `prenom`, `numero`, `salaire`) VALUES
(1, 'announ', 'aymen', '0656257769', 80000);

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

CREATE TABLE `vendeur` (
  `idVendeur` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `numero` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vendeur`
--

INSERT INTO `vendeur` (`idVendeur`, `nom`, `email`, `numero`) VALUES
(1, 'jumia', 'jumia@gmail.com', '0656257769');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`idBox`,`idCasier`),
  ADD KEY `contraint1` (`idCasier`);

--
-- Index pour la table `box_contient_colis`
--
ALTER TABLE `box_contient_colis`
  ADD PRIMARY KEY (`idBox`,`idColis`,`dateDepot`,`dateRecuperation`),
  ADD KEY `box_contient_colis_ibfk_2` (`idLivreur`),
  ADD KEY `box_contient_colis_ibfk_3` (`idVendeur`),
  ADD KEY `box_contient_colis_ibfk_4` (`idCasier`);

--
-- Index pour la table `casier`
--
ALTER TABLE `casier`
  ADD PRIMARY KEY (`idcasier`);

--
-- Index pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD PRIMARY KEY (`idLivreur`);

--
-- Index pour la table `vendeur`
--
ALTER TABLE `vendeur`
  ADD PRIMARY KEY (`idVendeur`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `box`
--
ALTER TABLE `box`
  ADD CONSTRAINT `contraint1` FOREIGN KEY (`idCasier`) REFERENCES `casier` (`idcasier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `box_contient_colis`
--
ALTER TABLE `box_contient_colis`
  ADD CONSTRAINT `box_contient_colis_ibfk_1` FOREIGN KEY (`idBox`) REFERENCES `box` (`idBox`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `box_contient_colis_ibfk_2` FOREIGN KEY (`idLivreur`) REFERENCES `livreur` (`idLivreur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `box_contient_colis_ibfk_3` FOREIGN KEY (`idVendeur`) REFERENCES `vendeur` (`idVendeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `box_contient_colis_ibfk_4` FOREIGN KEY (`idCasier`) REFERENCES `box` (`idCasier`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
