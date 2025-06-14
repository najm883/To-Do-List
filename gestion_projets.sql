-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 07:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_projets`
--

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL COMMENT 'Identifiant du cours',
  `titre` varchar(255) NOT NULL COMMENT 'Titre du cours',
  `description` text DEFAULT NULL COMMENT 'Description du cours',
  `date_creation` date NOT NULL COMMENT 'Date d''ajout',
  `id_etudiant` int(11) NOT NULL COMMENT 'Étudiant concerné'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id`, `titre`, `description`, `date_creation`, `id_etudiant`) VALUES
(8, 'Mathématiques', 'Statistiques et probalbilités', '2025-06-25', 7),
(9, 'RLC RLC forcée electrique', '2025-06-07', '0000-00-00', 8),
(10, 'RLC RLC forcée electrique', '2025-06-07', '0000-00-00', 8),
(11, 'Ph acide base', '2025-06-21', '0000-00-00', 8),
(12, 'avddqvdvdqvz', '2025-06-28', '0000-00-00', 8),
(13, 'PHP,HTML', '2025-06-26', '0000-00-00', 11),
(14, 'Python POO', '2025-06-28', '0000-00-00', 11),
(15, 'proba statis', '2025-06-28', '0000-00-00', 11),
(16, 'matrices', '2025-06-27', '0000-00-00', 11),
(17, 'Mathématiques', 'matrices', '2025-06-27', 12),
(18, 'Chimie', 'ph base', '2025-07-10', 12);

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL COMMENT 'Identifiant unique du projet',
  `nom` varchar(255) NOT NULL COMMENT 'Nom du projet',
  `description` text DEFAULT NULL COMMENT 'Description du projet',
  `date_debut` date NOT NULL COMMENT 'Date de début du projet',
  `date_fin` date NOT NULL COMMENT 'Date de fin du projet',
  `id_utilisateur` int(11) NOT NULL COMMENT 'ID du créateur ',
  `id_stagiaire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projets`
--

INSERT INTO `projets` (`id`, `nom`, `description`, `date_debut`, `date_fin`, `id_utilisateur`, `id_stagiaire`) VALUES
(1, 'To do list', 'Lister des taches a une application web', '2025-06-01', '2025-06-30', 8, NULL),
(2, 'Premiere app', '', '2025-06-21', '2025-07-12', 8, 9),
(3, 'Application timer', 'Calculer les temps des taches', '2025-06-28', '2025-07-12', 11, 13),
(4, 'Application mobile', 'Travailler sur 3 taches', '2025-06-22', '2025-07-06', 11, 14);

-- --------------------------------------------------------

--
-- Table structure for table `taches`
--

CREATE TABLE `taches` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `id_etudiant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Identifiant',
  `nom` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nom d''utlisateur',
  `prenom` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Prénom',
  `mail` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Adresse mail',
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Hash de mot de passe',
  `situation` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Etudiant,Stagiaire,Empolyé',
  `date_creation` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Date d''inscription'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `mail`, `pass`, `situation`, `date_creation`) VALUES
(11, 'ARGOUBI', 'NAJMEDDINE', 'argoubi.contact@gmail.com', '$2y$10$zBUMSWXEeWAK53urjnNhtuRdUAhcUIf5xS3TQaw5tvOjjNHyb1J66', '2', '2025-06-13 07:19:21'),
(12, 'Ben Saleh', 'Foued', 'najmargoubi@gmail.com', '$2y$10$5EdbtNvNVNfnSMN.0ec9nOGHv/i2PshmNagW1a8t8vTPMr4Ltjoqu', '1', '2025-06-13 07:20:26'),
(13, 'Tlili', 'Rabeh', 'najmnajm@outlook.com', '$2y$10$49BrGjj1CiY.zA039VjVT.cI6Hyh70AgLjWSRa.ILZTWMPeiy4IOC', '3', '2025-06-13 07:21:27'),
(14, 'ouerfeli', 'ilef', 'ilefouerfeli@gmail.com', '$2y$10$NG/iG.hQ7DR2a0QNhW/yXO6CM9gZfLzXXWpJoVZCX.DBfOaySragS', '3', '2025-06-13 17:31:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du cours', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du projet', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant', AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
