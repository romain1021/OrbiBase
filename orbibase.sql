-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2025 at 10:53 AM
-- Server version: 8.4.6
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orbibase`
--

-- --------------------------------------------------------

--
-- Table structure for table `Notification`
--

CREATE TABLE `Notification` (
  `id` int NOT NULL,
  `idUser` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Notification`
--

INSERT INTO `Notification` (`id`, `idUser`, `message`, `dateTime`) VALUES
(1, 1, 'COUCOU', '2025-11-06 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `Resources`
--

CREATE TABLE `Resources` (
  `id` int NOT NULL,
  `oxygene` tinyint UNSIGNED DEFAULT NULL,
  `nourriture` tinyint UNSIGNED DEFAULT NULL,
  `eau` tinyint UNSIGNED DEFAULT NULL,
  `energie` tinyint UNSIGNED DEFAULT NULL,
  `date_heure` datetime DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `Resources`
--

INSERT INTO `Resources` (`id`, `oxygene`, `nourriture`, `eau`, `energie`, `date_heure`) VALUES
(1, 85, 67, 74, 92, '2025-10-23 10:15:00'),
(2, 78, 52, 68, 87, '2025-10-24 11:20:00'),
(3, 65, 70, 59, 81, '2025-10-25 09:45:00'),
(4, 72, 60, 63, 79, '2025-10-26 13:30:00'),
(5, 69, 58, 61, 75, '2025-10-27 08:10:00'),
(6, 58, 54, 57, 70, '2025-10-28 14:50:00'),
(7, 55, 48, 53, 65, '2025-10-29 10:05:00'),
(8, 49, 44, 48, 60, '2025-10-30 15:15:00'),
(9, 43, 38, 41, 55, '2025-10-31 11:25:00'),
(10, 10, 35, 37, 50, '2025-11-01 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Secteur`
--

CREATE TABLE `Secteur` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Secteur`
--

INSERT INTO `Secteur` (`id`, `nom`) VALUES
(1, 'Recherche'),
(2, 'Agriculture'),
(3, 'Maintenance'),
(4, 'Médecine'),
(5, 'Commandement');

-- --------------------------------------------------------

--
-- Table structure for table `Specialite`
--

CREATE TABLE `Specialite` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Specialite`
--

INSERT INTO `Specialite` (`id`, `nom`) VALUES
(1, 'Médecine générale'),
(2, 'Informatique médicale'),
(3, 'Infirmier'),
(4, 'Pharmacien'),
(5, 'Technicien de laboratoire');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `idSpecialite` int DEFAULT NULL,
  `idSecteur` int DEFAULT NULL,
  `statut` enum('Actif','Repos','Malade','Danger') DEFAULT 'Actif',
  `lienPDP` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `identifiant`, `mdp`, `nom`, `prenom`, `idSpecialite`, `idSecteur`, `statut`, `lienPDP`) VALUES
(1, 'Romain', '$2y$12$waUDJ0Kd2eD.TPfVuR5TzOTIccQYf6.2LI54Oeud2ASSvYuv/KRfu', 'Lombard', 'Romain', 2, 4, 'Actif', 'photo/user_1_1763469581.jpeg'),
(2, 'roro', '$2y$12$YAodCyz9lydFjsMxsTKlg.rMPtSpRvHJS6.dD8srCaUfaVD.hh0vW', 'Lombard', 'Romain', 3, 5, 'Actif', NULL),
(6, 'jules.bernard', 'azerty123', 'Bernard', 'Jules', 2, 5, 'Actif', NULL),
(28, 'stephan.moret', 'azerty123', 'Moret', 'Stephan', 2, 5, 'Actif', NULL),
(29, 'robert.morin', 'azerty123', 'Morin', 'Robert', 3, 1, 'Actif', 'images/.jpg'),
(30, 'pierre.masson', 'azerty123', 'Masson', 'Pierre', 2, 2, 'Actif', 'images/#surrealnature#etherealviews#fantasticlandscapes#otherworldlyscenery#natureaesthetic#sublimenature.jpg'),
(31, 'john.leroy', 'azerty123', 'Leroy', 'John', 2, 3, 'Actif', 'images/champ-de-lavande-au-coucher-du-soleil-pres-de-valensole.jpg'),
(32, 'lucas.dubois', 'azerty123', 'Dubois', 'Lucas', 3, 4, 'Actif', 'images/profile.jpg'),
(33, 'marc.leclerc', 'azerty123', 'Leclerc', 'Marc', 4, 5, 'Actif', 'images/santa-maddalena-dolomites-rangesouth-tyrol.jpg'),
(34, 'nathan.roux', 'azerty123', 'Roux', 'Nathan', 5, 1, 'Actif', 'images/zqddqzdqzdzqdqzdzqdqzd.jpg'),
(35, 'hugo.marchand', 'azerty123', 'Marchand', 'Hugo', 1, 2, 'Actif', 'images/zqdqd .jpg'),
(36, 'leo.garnier', 'azerty123', 'Garnier', 'Léo', 2, 3, 'Actif', 'images/zqdqzdqdzqdqzdzdqzddqzdzqdzqdz.jpg'),
(37, 'mathis.collet', 'azerty123', 'Collet', 'Mathis', 3, 4, 'Actif', 'images/zqdqzdqzdqzdqzdqzdqzdqzd.jpg'),
(38, 'adrien.perrin', 'azerty123', 'Perrin', 'Adrien', 4, 5, 'Actif', 'images/zqdqzdzdqzzdqzdq.jpg'),
(39, 'dorian.malot', 'azerty123', 'Malot', 'Dorian', 5, 1, 'Actif', 'images/Зелёный хлопковый фон.jpg'),
(40, 'stephan ', '$2y$12$3pJIIgRTuuTKvB9DJH7MVeppyEuPhLah0jCCXn5TIQ.sVad9Wz7ua', 'dupon', 'ealzndlzk', 2, 5, 'Actif', NULL),
(41, 'bobita', '$2y$12$x4tHauUhmhjeeo4mjf/zkeZaE2U9W17Gvp3arERvgwn63yJ/am2GO', 'Romain', 'Romain', NULL, NULL, 'Actif', NULL),
(43, 'rorolegeek', '$2y$12$IF//zBEP1tYWtpU5EcrjueZCxPQnvNolcCSE//TjyhVQU1xiszl1e', 'Lombard', 'Romain', 2, 5, 'Actif', 'photo/user_43_1763630782.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Notification`
--
ALTER TABLE `Notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Resources`
--
ALTER TABLE `Resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Secteur`
--
ALTER TABLE `Secteur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Specialite`
--
ALTER TABLE `Specialite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifiant` (`identifiant`),
  ADD KEY `idSpecialite` (`idSpecialite`),
  ADD KEY `idSecteur` (`idSecteur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Notification`
--
ALTER TABLE `Notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Resources`
--
ALTER TABLE `Resources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Secteur`
--
ALTER TABLE `Secteur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Specialite`
--
ALTER TABLE `Specialite`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idSpecialite`) REFERENCES `Specialite` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`idSecteur`) REFERENCES `Secteur` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
