-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 05 nov. 2023 à 11:56
-- Version du serveur : 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Version de PHP : 8.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `geekcollection`
--

-- --------------------------------------------------------

--
-- Structure de la table `box`
--

CREATE TABLE `box` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `box`
--

INSERT INTO `box` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'simple', '2023-10-27 21:23:45', '2023-10-27 21:23:45'),
(2, 'double', '2023-10-27 21:23:51', '2023-10-27 21:23:51'),
(3, 'no information', '2023-11-01 21:54:52', '2023-11-01 21:54:52');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231027191202', '2023-10-27 21:12:06', 5380),
('DoctrineMigrations\\Version20231027202044', '2023-10-27 22:20:49', 208),
('DoctrineMigrations\\Version20231029081019', '2023-10-29 09:10:27', 270),
('DoctrineMigrations\\Version20231102180709', '2023-11-02 19:07:15', 478);

-- --------------------------------------------------------

--
-- Structure de la table `edition`
--

CREATE TABLE `edition` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `edition`
--

INSERT INTO `edition` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Simple', '2023-10-27 21:24:03', '2023-10-27 21:24:03'),
(2, 'Collector', '2023-10-27 21:24:12', '2023-10-27 21:24:12'),
(3, 'Premium', '2023-10-27 21:24:16', '2023-10-27 21:24:16'),
(4, 'no information', '2023-11-01 21:55:03', '2023-11-01 21:55:03');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `support_id` int(11) DEFAULT NULL,
  `box_id` int(11) DEFAULT NULL,
  `edition_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `objectlink` varchar(255) NOT NULL,
  `oeuvrelink` varchar(255) NOT NULL,
  `gencode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `media_id`, `support_id`, `box_id`, `edition_id`, `title`, `created_at`, `updated_at`, `objectlink`, `oeuvrelink`, `gencode`) VALUES
(2, 1, 2, 1, 1, 'la la land', '2023-11-01 22:07:46', '2023-11-01 22:07:46', 'dvdfr:300093', 'themoviedb:381083', '3475001053022'),
(3, 1, 1, 1, 1, 'New-York 1997', '2023-11-01 22:19:15', '2023-11-01 22:19:15', 'dvdfr:7700', 'themoviedb:1103', 'na'),
(4, 1, 1, 1, 1, 'Opération Dragon', '2023-10-29 16:14:22', '2023-10-29 16:14:22', 'dvdfr:1085', 'na', 'na'),
(5, 1, 1, 1, 1, 'tenet', '2023-11-01 22:41:29', '2023-11-01 22:41:29', 'dvdfr:167943', 'themoviedb:577922', 'na'),
(6, 1, 1, 1, 1, 'Phenomena', '2023-10-29 16:46:46', '2023-10-29 16:46:46', 'dvdfr:3767', 'na', 'na'),
(7, 1, 1, 1, 1, 'Dragon rouge', '2023-11-03 20:44:08', '2023-11-03 20:44:08', 'na', 'na', 'na');

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `information` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`id`, `created_at`, `updated_at`, `information`, `description`) VALUES
(4, '2023-11-03 21:50:38', '2023-11-03 21:50:38', 'Leclerc', 'sdfsdfs'),
(5, '2023-11-03 21:33:19', '2023-11-03 21:33:19', 'ddddddddddddddd', 'ddd'),
(6, '2023-11-03 22:03:15', '2023-11-03 22:03:15', 'comédie musique', 'Beaucoffret'),
(7, '2023-11-02 19:09:48', '2023-11-02 19:09:48', 'sdf', 'sdfsdf'),
(15, '2023-11-03 22:02:04', '2023-11-03 22:02:04', 'sdffdsfdfdfd', 'sdfdfddf'),
(25, '2023-11-05 11:27:21', '2023-11-05 11:27:21', 'ssdsdf', 'sdfsdssss');

-- --------------------------------------------------------

--
-- Structure de la table `library_item`
--

CREATE TABLE `library_item` (
  `library_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library_item`
--

INSERT INTO `library_item` (`library_id`, `item_id`) VALUES
(4, 3),
(5, 4),
(6, 2),
(7, 3),
(15, 4),
(25, 7);

-- --------------------------------------------------------

--
-- Structure de la table `library_user`
--

CREATE TABLE `library_user` (
  `library_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library_user`
--

INSERT INTO `library_user` (`library_id`, `user_id`) VALUES
(4, 1),
(5, 1),
(6, 1),
(7, 2),
(15, 1),
(25, 2);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'movie', '2023-10-27 21:23:34', '2023-10-27 21:23:34'),
(2, 'music', '2023-10-27 21:23:37', '2023-10-27 21:23:37');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `support`
--

INSERT INTO `support` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'dvd', '2023-10-27 21:23:20', '2023-10-27 21:23:20'),
(2, 'bluray', '2023-10-27 21:23:25', '2023-10-27 21:23:25'),
(3, 'paper', '2023-11-01 21:53:47', '2023-11-01 21:53:47'),
(4, 'digital', '2023-11-01 21:53:59', '2023-11-01 21:53:59'),
(5, 'no information', '2023-11-01 21:54:24', '2023-11-01 21:54:24'),
(6, 'bluray 4k', '2023-11-01 22:46:08', '2023-11-01 22:46:08');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `created_at`, `updated_at`) VALUES
(1, 'lesanglierdesardennes@gmail.com', '[]', '$2y$13$4oIJnSc4U.UF1Yixd27j8OJvU.QfJPnhExg1xIQbTcrZa6.d9mY9e', '2023-10-27 21:13:24', '2023-10-27 21:13:24'),
(2, 'chloe@gmail.com', '[]', '$2y$13$m/2/3gE7Z6woV1Q1c2Un/.pWhBFUDAb4lBoshCvOzO8cPuV1nVOF.', '2023-11-01 23:19:41', '2023-11-01 23:19:41');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `edition`
--
ALTER TABLE `edition`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251EEA9FDD75` (`media_id`),
  ADD KEY `IDX_1F1B251E315B405` (`support_id`),
  ADD KEY `IDX_1F1B251ED8177B3F` (`box_id`),
  ADD KEY `IDX_1F1B251E74281A5E` (`edition_id`);

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `library_item`
--
ALTER TABLE `library_item`
  ADD PRIMARY KEY (`library_id`,`item_id`),
  ADD KEY `IDX_B9D4EF73FE2541D7` (`library_id`),
  ADD KEY `IDX_B9D4EF73126F525E` (`item_id`);

--
-- Index pour la table `library_user`
--
ALTER TABLE `library_user`
  ADD PRIMARY KEY (`library_id`,`user_id`),
  ADD KEY `IDX_2B5C1C24FE2541D7` (`library_id`),
  ADD KEY `IDX_2B5C1C24A76ED395` (`user_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `box`
--
ALTER TABLE `box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `edition`
--
ALTER TABLE `edition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E315B405` FOREIGN KEY (`support_id`) REFERENCES `support` (`id`),
  ADD CONSTRAINT `FK_1F1B251E74281A5E` FOREIGN KEY (`edition_id`) REFERENCES `edition` (`id`),
  ADD CONSTRAINT `FK_1F1B251ED8177B3F` FOREIGN KEY (`box_id`) REFERENCES `box` (`id`),
  ADD CONSTRAINT `FK_1F1B251EEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `library_item`
--
ALTER TABLE `library_item`
  ADD CONSTRAINT `FK_B9D4EF73126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B9D4EF73FE2541D7` FOREIGN KEY (`library_id`) REFERENCES `library` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `library_user`
--
ALTER TABLE `library_user`
  ADD CONSTRAINT `FK_2B5C1C24A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2B5C1C24FE2541D7` FOREIGN KEY (`library_id`) REFERENCES `library` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
