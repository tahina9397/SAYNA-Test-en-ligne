-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 14 Janvier 2021 à 12:53
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `id_taille` int(11) DEFAULT NULL,
  `uniqid` varchar(8) NOT NULL,
  `nom_article` varchar(150) NOT NULL,
  `date_article` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codebarre_article` varchar(50) DEFAULT NULL,
  `prix_article` tinytext NOT NULL,
  `prix_achat` tinytext NOT NULL,
  `pourcentage` int(4) NOT NULL,
  `nbre_stock_article` int(11) NOT NULL DEFAULT '1',
  `article_commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id_article`, `id_categorie`, `id_taille`, `uniqid`, `nom_article`, `date_article`, `codebarre_article`, `prix_article`, `prix_achat`, `pourcentage`, `nbre_stock_article`, `article_commentaire`) VALUES
(2, 2, 1, 'CD3410EN', 'Ensemble spiderman', '2021-01-14 12:45:01', '8901117021051', '9000', '4500', 100, 115, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(4, 3, NULL, 'N56AJ92E', 'Ballon de basket', '2021-01-14 19:48:42', '8901157105056', '5000', '4000', 25, 5, ''),
(5, 1, NULL, 'NC6IJ90E', 'Lettres magnétiques', '2021-01-13 21:02:15', '4051528143867', '12500', '10000', 25, 25, ''),
(6, 5, NULL, '92E85LA4', 'Barbie', '2021-01-14 12:43:07', '9434927012128', '93750', '75000', 25, 18, ''),
(7, 5, NULL, 'H7NKLAB1', 'Barbie et sa Fiat 500', '2021-01-14 15:53:39', '1109054503655', '22500', '18000', 25, 43, ''),
(8, 6, NULL, 'AJ12EFC6', 'Une batterie de cuisine et ses ustensiles', '2021-01-14 12:43:45', '1109054270564', '25000', '20000', 25, 9, ''),
(9, 6, NULL, 'E85LIBG2', 'Des fruits à couper Melissa & Doug ', '2021-01-14 12:43:30', '1109054901017', '16250', '13000', 25, 4, ''),
(11, 1, NULL, 'NKDA4GHM', 'Des légo Duplo ', '2021-01-13 22:16:14', '1109054525091', '20000', '10000', 100, 1, ''),
(12, 1, NULL, 'CDAJ92MF', 'Marionnettes à doigts', '2021-01-14 12:43:23', '9434927707437', '90000', '45000', 100, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `uniqid` varchar(8) NOT NULL,
  `nom_categorie` varchar(150) NOT NULL,
  `commentaire_categorie` text NOT NULL,
  `ordre_categorie` int(11) NOT NULL,
  `date_categorie` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `uniqid`, `nom_categorie`, `commentaire_categorie`, `ordre_categorie`, `date_categorie`) VALUES
(1, '07F563B1', 'Jouets', 'Jouets\r\n', 1, '2021-01-14 11:50:27'),
(2, 'B12M85LI', 'Habillement', 'Habillement pour enfant(s)', 2, '2021-01-14 11:50:33'),
(3, 'F5DABGH7', 'Accessoires', 'Accessoire pour enfant(s)', 3, '2021-01-14 11:50:36'),
(4, 'LI4G278C', 'Divers', 'Divers', 4, '2021-01-14 11:50:40'),
(5, 'I410MF56', 'Poupée', 'Tous les types de poupées', 5, '2021-01-14 11:50:44'),
(6, 'EFK6IB12', 'Dinette', 'Cuisine', 6, '2021-01-14 12:27:55'),
(7, '2EF5L3J1', 'Figurine', 'Figurine', 7, '2021-01-14 19:46:02');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id_facture` int(11) NOT NULL,
  `mode_paiement` int(11) NOT NULL,
  `facture_numero` varchar(15) NOT NULL,
  `facture_details` text NOT NULL,
  `facture_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facture_montant` int(11) DEFAULT NULL,
  `montant_recu` int(11) DEFAULT NULL,
  `rr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `factures`
--

INSERT INTO `factures` (`id_facture`, `mode_paiement`, `facture_numero`, `facture_details`, `facture_date`, `facture_montant`, `montant_recu`, `rr`) VALUES
(1, 1, '1', 'Essai', '2018-03-30 22:03:27', 13955, 15000, '1045'),
(2, 1, '2', 'Essai', '2018-03-30 22:03:17', 5000, 5000, '0'),
(3, 1, '3', 'Essai', '2018-03-30 22:03:54', 8955, 10000, '1045'),
(4, 1, '4', 'Essai', '2018-03-30 22:03:16', 8955, 9000, '45'),
(5, 1, '5', 'Essai', '2018-03-30 22:03:39', 8955, 9000, '45');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(11) UNSIGNED NOT NULL,
  `article_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `type` enum('ajout','vente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ajout',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`id`, `article_id`, `quantite`, `facture_id`, `type`, `create_time`) VALUES
(1, 4, 1, 1, 'vente', '2021-01-14 19:47:27'),
(2, 2, 1, 1, 'vente', '2021-01-14 19:47:27'),
(3, 4, 1, 2, 'vente', '2021-01-14 19:48:18'),
(4, 2, 1, 3, 'vente', '2021-01-14 19:48:54'),
(5, 2, 1, 4, 'vente', '2021-01-14 19:51:16'),
(6, 2, 1, 5, 'vente', '2021-01-14 19:51:39'),
(8, 8, 5, NULL, 'ajout', '2021-01-14 12:43:45'),
(9, 2, 3, NULL, 'ajout', '2021-01-14 12:44:55'),
(10, 2, 110, NULL, 'ajout', '2021-01-14 12:45:01');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `options`
--

INSERT INTO `options` (`meta_key`, `meta_value`) VALUES
('codebarre', '9434927'),
('version', '1.0');

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

CREATE TABLE `taille` (
  `id_taille` int(11) NOT NULL,
  `nom_taille` varchar(150) NOT NULL,
  `date_taille` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `taille`
--

INSERT INTO `taille` (`id_taille`, `nom_taille`, `date_taille`) VALUES
(1, 'L', '2021-01-14 12:39:54'),
(2, 'XS', '2021-01-14 12:40:06'),
(3, 'XXL', '2021-01-13 22:17:09'),
(4, 'M', '2021-01-14 19:45:37');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `activate` tinyint(1) DEFAULT '0',
  `profile_picture` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `activate`, `profile_picture`, `token`, `last_activity`, `create_time`, `update_time`, `role`) VALUES
(1, 'tahina', 'admin@bazar.com', '21232f297a57a5a743894a0e4a801fc3', 1, 'profile_1_8abadf2d25dba5c3bad58d3bf0de41e3023b6ff1-source.jpg', 'a3417653af1dd614f8f8fa6d001502b3b272af29', '2021-01-14 12:07:55', '2021-01-14 10:41:00', '2021-01-14 15:15:35', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id_vente` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `vente_quantite` int(11) NOT NULL,
  `vente_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`id_vente`, `article_id`, `vente_quantite`, `vente_date`, `facture_id`) VALUES
(1, 4, 1, '2018-03-30 22:03:27', 1),
(2, 2, 1, '2018-03-30 22:03:27', 1),
(3, 4, 1, '2018-03-30 22:03:17', 2),
(4, 2, 1, '2018-03-30 22:03:54', 3),
(5, 2, 1, '2018-03-30 22:03:16', 4),
(6, 2, 1, '2018-03-30 22:03:39', 5);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `articles_codebarre_article` (`codebarre_article`) USING BTREE,
  ADD KEY `articles_id_categorie` (`id_categorie`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `factures_modePaiement` (`mode_paiement`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historique_article_id` (`article_id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`meta_key`),
  ADD KEY `key` (`meta_key`);

--
-- Index pour la table `taille`
--
ALTER TABLE `taille`
  ADD PRIMARY KEY (`id_taille`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id_vente`),
  ADD KEY `ventes_article_id` (`article_id`),
  ADD KEY `ventes_facture_id` (`facture_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `taille`
--
ALTER TABLE `taille`
  MODIFY `id_taille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventes_facture_id` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
