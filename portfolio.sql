-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3334
-- Généré le : jeu. 31 oct. 2024 à 17:56
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cvs`
--

CREATE TABLE `cvs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `current_job` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passions` text COLLATE utf8mb4_general_ci,
  `career` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Déchargement des données de la table `cvs`
--

INSERT INTO `cvs` (`id`, `user_id`, `title`, `description`, `profile_picture`, `first_name`, `last_name`, `birth_date`, `phone`, `email`, `current_job`, `passions`, `career`, `education`, `skills`, `created_at`) VALUES
(3, 3, 'Test cv', 'Je test mon premier cv', 'https://e1.pxfuel.com/desktop-wallpaper/138/941/desktop-wallpaper-anime-xbox-profile-xbox-pfp.jpg', 'Chloé ', 'Bercher', '2002-07-21', '0604505180', 'bercherchloe@gmail.com', NULL, 'Elle m\'aime moi (Thomas)', '\"{carriere pro en infra}\"', '\"{Harvard , ynov}\"', '\"{CPP ; Java ; Golang}\"', '2024-10-23 20:46:10'),
(5, 2, 'Mon CV INFRA', 'JE fais mon cv pour aller en infra', 'https://desenio.fr/p/affiches/marques/batman/batman-portrait-affiche/', 'Thomas', 'Laucournett', '2004-05-30', '0604505180', 'tlaucournet@gmail.com', NULL, 'J\'aime chloé et aussi les jeux video mais surtout l\'infra !!', '\"\\\"\\\\\\\"STI2D ; Ynov B1 ; Ynov B2\\\\\\\"\\\"\"', '\"\\\"\\\\\\\"Lycee des arenes\\\\\\\\Dodat de severac \\\\\\\"\\\"\"', '\"\\\"\\\\\\\"C++ ; Java ; GOlang ; C\\\\\\\"\\\"\"', '2024-10-24 07:00:17');

-- --------------------------------------------------------

--
-- Structure de la table `educations`
--

CREATE TABLE `educations` (
  `id` int NOT NULL,
  `cv_id` int DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `experiences`
--

CREATE TABLE `experiences` (
  `id` int NOT NULL,
  `cv_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_favorite` tinyint(1) DEFAULT '0',
  `is_validated` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `title`, `description`, `image`, `is_favorite`, `is_validated`, `created_at`) VALUES
(2, 2, 'Projet Faker', 'Un gosse sur LoL a 9 ans = Faker a 16 ans', NULL, 1, 1, '2024-10-22 08:55:51'),
(3, 2, 'Projet Zenin', 'Projet Faker mais avec une fille', NULL, 1, 0, '2024-10-23 22:17:40'),
(4, 3, 'Super Project', 'I created a super duper project', NULL, 0, 1, '2024-10-24 07:23:50'),
(5, 3, 'This project is favorite even', 'Nice its a good good project', NULL, 1, 0, '2024-10-24 07:24:17'),
(6, 3, 'Last test B4', 'This project is the best one here ', NULL, 1, 0, '2024-10-24 08:05:07');

-- --------------------------------------------------------

--
-- Structure de la table `skills`
--

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `cv_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `years_of_experience` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `role`, `created_at`, `user_level`) VALUES
(2, 'thomas@gmail.com', 'Thomas', 'Laucournet', '$2y$10$5DTag2R5Zud0VXD4KgfaGe6/UHghl2eU8S9jRO5KkjDvXMbsOf.6C', 'user', '2024-10-22 08:49:35', NULL),
(3, 'bigthomas@admin.ynov', 'Thomas', 'Nathan', '$2y$10$5DTag2R5Zud0VXD4KgfaGe6/UHghl2eU8S9jRO5KkjDvXMbsOf.6C', 'admin', '2024-10-22 08:49:35', 1),
(4, 'tommyx@gmail.com', 'tommyx', 'tommyx', '$2y$10$UNJLe4.ZehqvxwI.epVF2evGdFUXEsue/VsIsw0QFfAaKlKC/8ouS', 'user', '2024-10-31 17:35:14', NULL),
(6, 'chloebercher@gmail.com', 'Chloaia', 'Bercher', '$2y$10$j7mSNuATxWOSv7FzgsQ9eupYXaCGEWAFazPD6MoZC4OjyVqHnt99q', 'user', '2024-10-31 17:38:03', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cvs_ibfk_1` (`user_id`);

--
-- Index pour la table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Index pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cvs`
--
ALTER TABLE `cvs`
  ADD CONSTRAINT `cvs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cvs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cvs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cvs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
