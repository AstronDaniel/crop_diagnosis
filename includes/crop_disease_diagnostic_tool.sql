-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2024 at 08:54 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crop_disease_diagnostic_tool`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

DROP TABLE IF EXISTS `crops`;
CREATE TABLE IF NOT EXISTS `crops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `scientific_name` varchar(255) DEFAULT NULL,
  `description` text,
  `common_varieties` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `name`, `scientific_name`, `description`, `common_varieties`, `created_at`) VALUES
(1, 'Rice', 'Oryza sativa', 'Common cereal grain', 'Basmati, Jasmine, Arborio', '2024-11-25 22:03:40'),
(2, 'Wheat', 'Triticum aestivum', 'Cereal grain crop', 'Durum, Hard Red, Soft White', '2024-11-25 22:03:40'),
(3, 'Corn', 'Zea mays', 'Maize crop', 'Dent, Flint, Sweet', '2024-11-25 22:03:40'),
(4, 'Potato', 'Solanum tuberosum', 'Root vegetable', 'Russet, Yukon Gold, Red Pontiac', '2024-11-25 22:03:40'),
(5, 'Tomato', 'Solanum lycopersicum', 'Fruit vegetable', 'Roma, Cherry, Heirloom', '2024-11-25 22:03:40'),
(6, 'Apple', 'Malus domestica', 'Sweet fruit tree', 'Gala, Fuji, Honeycrisp', '2024-11-25 22:03:40'),
(7, 'Banana', 'Musa acuminata', 'Tropical fruit plant', 'Cavendish, Lady Finger', '2024-11-25 22:03:40'),
(8, 'Strawberry', 'Fragaria × ananassa', 'Berry fruit', 'Albion, Seascape', '2024-11-25 22:03:40'),
(9, 'Soybean', 'Glycine max', 'Leguminous crop', 'Clark, Forrest', '2024-11-25 22:03:40'),
(10, 'Barley', 'Hordeum vulgare', 'Cereal crop', 'Malting, Feed', '2024-11-25 22:03:40'),
(11, 'Sugarcane', 'Saccharum officinarum', 'Tropical perennial grass', 'Co 86032, BO91', '2024-11-25 22:03:40'),
(12, 'Coffee', 'Coffea arabica', 'Tropical shrub for coffee production', 'Arabica, Robusta', '2024-11-25 22:03:40'),
(13, 'Cocoa', 'Theobroma cacao', 'Tropical tree for chocolate production', 'Criollo, Forastero', '2024-11-25 22:03:40'),
(14, 'Peanut', 'Arachis hypogaea', 'Oilseed crop', 'Valencia, Spanish', '2024-11-25 22:03:40'),
(15, 'Onion', 'Allium cepa', 'Bulb vegetable', 'Red, White, Yellow', '2024-11-25 22:03:40'),
(16, 'Pepper', 'Capsicum annuum', 'Hot or sweet peppers', 'Bell, Cayenne, Jalapeno', '2024-11-25 22:03:40'),
(17, 'Carrot', 'Daucus carota', 'Root vegetable', 'Nantes, Imperator, Danvers', '2024-11-25 22:03:40'),
(18, 'Mango', 'Mangifera indica', 'Tropical fruit tree', 'Alphonso, Haden, Tommy Atkins', '2024-11-25 22:03:40'),
(19, 'Pineapple', 'Ananas comosus', 'Tropical fruit', 'MD-2, Smooth Cayenne', '2024-11-25 22:03:40'),
(20, 'Lettuce', 'Lactuca sativa', 'Leafy vegetable', 'Iceberg, Romaine, Butterhead', '2024-11-25 22:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `crop_diseases`
--

DROP TABLE IF EXISTS `crop_diseases`;
CREATE TABLE IF NOT EXISTS `crop_diseases` (
  `crop_id` int NOT NULL,
  `disease_id` int NOT NULL,
  `common_growth_stages` varchar(255) DEFAULT NULL,
  `prevalence_rate` int DEFAULT '50',
  PRIMARY KEY (`crop_id`,`disease_id`),
  KEY `disease_id` (`disease_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `crop_diseases`
--

INSERT INTO `crop_diseases` (`crop_id`, `disease_id`, `common_growth_stages`, `prevalence_rate`) VALUES
(1, 1, 'Seedling, Vegetative', 70),
(1, 2, 'Flowering, Fruiting', 60),
(1, 3, 'Vegetative, Fruiting', 80),
(1, 4, 'Seedling, Mature', 50),
(2, 1, 'Seedling, Vegetative', 70),
(2, 2, 'Flowering, Fruiting', 60),
(2, 3, 'Vegetative, Fruiting', 80),
(2, 4, 'Seedling, Mature', 50),
(3, 1, 'Seedling, Vegetative', 70),
(3, 2, 'Flowering, Fruiting', 60),
(3, 3, 'Vegetative, Fruiting', 80),
(3, 4, 'Seedling, Mature', 50),
(4, 1, 'Seedling, Vegetative', 70),
(4, 2, 'Flowering, Fruiting', 60),
(4, 3, 'Vegetative, Fruiting', 80),
(4, 4, 'Seedling, Mature', 50),
(5, 1, 'Seedling, Vegetative', 70),
(5, 2, 'Flowering, Fruiting', 60),
(5, 3, 'Vegetative, Fruiting', 80),
(5, 4, 'Seedling, Mature', 50),
(6, 1, 'Seedling, Vegetative', 70),
(6, 2, 'Flowering, Fruiting', 60),
(6, 3, 'Vegetative, Fruiting', 80),
(6, 4, 'Seedling, Mature', 50),
(7, 1, 'Seedling, Vegetative', 70),
(7, 2, 'Flowering, Fruiting', 60),
(7, 3, 'Vegetative, Fruiting', 80),
(7, 4, 'Seedling, Mature', 50),
(8, 1, 'Seedling, Vegetative', 70),
(8, 2, 'Flowering, Fruiting', 60),
(8, 3, 'Vegetative, Fruiting', 80),
(8, 4, 'Seedling, Mature', 50),
(9, 1, 'Seedling, Vegetative', 70),
(9, 2, 'Flowering, Fruiting', 60),
(9, 3, 'Vegetative, Fruiting', 80),
(9, 4, 'Seedling, Mature', 50),
(10, 1, 'Seedling, Vegetative', 70),
(10, 2, 'Flowering, Fruiting', 60),
(10, 3, 'Vegetative, Fruiting', 80),
(10, 4, 'Seedling, Mature', 50),
(11, 1, 'Seedling, Vegetative', 70),
(11, 2, 'Flowering, Fruiting', 60),
(11, 3, 'Vegetative, Fruiting', 80),
(11, 4, 'Seedling, Mature', 50),
(12, 1, 'Seedling, Vegetative', 70),
(12, 2, 'Flowering, Fruiting', 60),
(12, 3, 'Vegetative, Fruiting', 80),
(12, 4, 'Seedling, Mature', 50),
(13, 1, 'Seedling, Vegetative', 70),
(13, 2, 'Flowering, Fruiting', 60),
(13, 3, 'Vegetative, Fruiting', 80),
(13, 4, 'Seedling, Mature', 50),
(14, 1, 'Seedling, Vegetative', 70),
(14, 2, 'Flowering, Fruiting', 60),
(14, 3, 'Vegetative, Fruiting', 80),
(14, 4, 'Seedling, Mature', 50),
(15, 1, 'Seedling, Vegetative', 70),
(15, 2, 'Flowering, Fruiting', 60),
(15, 3, 'Vegetative, Fruiting', 80),
(15, 4, 'Seedling, Mature', 50),
(16, 1, 'Seedling, Vegetative', 70),
(16, 2, 'Flowering, Fruiting', 60),
(16, 3, 'Vegetative, Fruiting', 80),
(16, 4, 'Seedling, Mature', 50),
(17, 1, 'Seedling, Vegetative', 70),
(17, 2, 'Flowering, Fruiting', 60),
(17, 3, 'Vegetative, Fruiting', 80),
(17, 4, 'Seedling, Mature', 50),
(18, 1, 'Seedling, Vegetative', 70),
(18, 2, 'Flowering, Fruiting', 60),
(18, 3, 'Vegetative, Fruiting', 80),
(18, 4, 'Seedling, Mature', 50),
(19, 1, 'Seedling, Vegetative', 70),
(19, 2, 'Flowering, Fruiting', 60),
(19, 3, 'Vegetative, Fruiting', 80),
(19, 4, 'Seedling, Mature', 50),
(20, 1, 'Seedling, Vegetative', 70),
(20, 2, 'Flowering, Fruiting', 60),
(20, 3, 'Vegetative, Fruiting', 80),
(20, 4, 'Seedling, Mature', 50);

-- --------------------------------------------------------

--
-- Table structure for table `diagnoses`
--

DROP TABLE IF EXISTS `diagnoses`;
CREATE TABLE IF NOT EXISTS `diagnoses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `crop_id` int NOT NULL,
  `disease_id` int NOT NULL,
  `growth_stage` varchar(50) NOT NULL,
  `confidence` int NOT NULL,
  `additional_details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('identified','unidentified') DEFAULT 'identified',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `crop_id` (`crop_id`),
  KEY `disease_id` (`disease_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `user_id`, `crop_id`, `disease_id`, `growth_stage`, `confidence`, `additional_details`, `created_at`, `status`) VALUES
(1, 1, 6, 5, '6', 85, '', '2024-11-25 23:19:37', 'identified'),
(2, 1, 6, 5, '6', 85, '', '2024-11-25 23:19:37', 'identified'),
(3, 1, 6, 5, '6', 85, '', '2024-11-25 23:20:14', 'identified'),
(4, 1, 6, 5, '6', 85, '', '2024-11-25 23:20:14', 'identified'),
(5, 1, 6, 5, '6', 85, '', '2024-11-25 23:21:36', 'identified'),
(6, 1, 6, 5, '6', 85, '', '2024-11-25 23:21:36', 'identified'),
(7, 1, 6, 5, '6', 50, '', '2024-11-25 23:21:51', 'identified'),
(8, 1, 6, 5, '6', 50, '', '2024-11-25 23:21:51', 'identified'),
(9, 1, 6, 16, '15', 85, '', '2024-11-25 23:22:39', 'identified'),
(10, 1, 6, 16, '15', 85, '', '2024-11-25 23:22:39', 'identified'),
(11, 1, 7, 1, '6', 50, '', '2024-11-25 23:36:35', 'identified'),
(12, 1, 7, 1, '6', 50, '', '2024-11-25 23:36:35', 'identified'),
(13, 1, 7, 1, '6', 85, '', '2024-11-25 23:37:07', 'identified'),
(14, 1, 7, 1, '6', 85, '', '2024-11-25 23:37:07', 'identified'),
(15, 1, 7, 1, '6', 50, '', '2024-11-25 23:38:12', 'identified'),
(16, 1, 7, 1, '6', 50, '', '2024-11-25 23:38:12', 'identified'),
(17, 1, 6, 1, '6', 50, '', '2024-11-25 23:46:34', 'identified'),
(18, 1, 6, 1, '6', 50, '', '2024-11-25 23:46:34', 'identified'),
(19, 1, 12, 1, '1', 50, '', '2024-11-25 23:48:03', 'identified'),
(20, 1, 12, 1, '1', 50, '', '2024-11-25 23:48:03', 'identified'),
(21, 1, 12, 1, '1', 50, '', '2024-11-25 23:49:27', 'identified'),
(22, 1, 12, 1, '1', 50, '', '2024-11-25 23:49:27', 'identified'),
(23, 1, 12, 1, '1', 50, '', '2024-11-25 23:49:41', 'identified'),
(24, 1, 12, 1, '1', 50, '', '2024-11-25 23:49:41', 'identified'),
(25, 1, 19, 3, '5', 50, '', '2024-11-25 23:50:34', 'identified'),
(26, 1, 19, 3, '5', 50, '', '2024-11-25 23:50:34', 'identified'),
(27, 1, 4, 3, '20', 50, '', '2024-11-25 23:51:38', 'identified'),
(28, 1, 4, 3, '20', 50, '', '2024-11-25 23:51:38', 'identified'),
(29, 1, 6, 1, '15', 50, '', '2024-11-25 23:52:04', 'identified'),
(30, 1, 6, 1, '15', 50, '', '2024-11-25 23:52:04', 'identified'),
(31, 1, 7, 1, '6', 50, '', '2024-11-25 23:57:09', 'identified'),
(32, 1, 7, 1, '6', 50, '', '2024-11-25 23:57:09', 'identified'),
(33, 1, 6, 1, '6', 50, '', '2024-11-26 00:00:24', 'identified'),
(34, 1, 6, 1, '6', 50, '', '2024-11-26 00:00:24', 'identified'),
(35, 1, 4, 1, '5', 50, '', '2024-11-26 00:00:57', 'identified'),
(36, 1, 4, 1, '5', 50, '', '2024-11-26 00:00:57', 'identified'),
(37, 1, 4, 1, '5', 50, '', '2024-11-26 00:01:29', 'identified'),
(38, 1, 4, 1, '5', 50, '', '2024-11-26 00:01:29', 'identified'),
(39, 1, 7, 1, '18', 50, '', '2024-11-26 00:03:59', 'identified'),
(40, 1, 7, 1, '18', 50, '', '2024-11-26 00:03:59', 'identified'),
(41, 1, 7, 1, '6', 50, '', '2024-11-26 00:09:53', 'identified'),
(42, 1, 7, 1, '6', 50, '', '2024-11-26 00:09:53', 'identified'),
(43, 1, 10, 1, '6', 50, '', '2024-11-26 00:11:36', 'identified'),
(44, 1, 10, 1, '6', 50, '', '2024-11-26 00:11:36', 'identified'),
(45, 1, 6, 1, '6', 50, '', '2024-11-26 06:54:59', 'identified'),
(46, 1, 6, 1, '6', 50, '', '2024-11-26 06:54:59', 'identified'),
(47, 1, 10, 21, '1', 0, '', '2024-11-26 07:00:59', 'identified'),
(48, 1, 10, 21, '1', 0, '', '2024-11-26 07:00:59', 'identified'),
(49, 1, 3, 1, '6', 50, '', '2024-11-26 07:02:49', 'identified'),
(50, 1, 3, 1, '6', 50, '', '2024-11-26 07:02:49', 'identified'),
(51, 1, 20, 21, '18', 0, '', '2024-11-26 07:03:45', 'identified'),
(52, 1, 20, 21, '18', 0, '', '2024-11-26 07:03:45', 'identified'),
(53, 1, 6, 1, '9', 50, '', '2024-11-26 07:04:38', 'identified'),
(54, 1, 6, 1, '9', 50, '', '2024-11-26 07:04:38', 'identified'),
(55, 1, 9, 21, '10', 0, '', '2024-11-26 07:09:45', 'identified'),
(56, 1, 9, 21, '10', 0, '', '2024-11-26 07:09:45', 'identified'),
(57, 1, 6, 21, '12', 0, '', '2024-11-26 07:10:48', 'identified'),
(58, 1, 6, 21, '12', 0, '', '2024-11-26 07:10:48', 'identified'),
(59, 1, 6, 1, '12', 50, '', '2024-11-26 07:10:56', 'identified'),
(60, 1, 6, 1, '12', 50, '', '2024-11-26 07:10:56', 'identified'),
(61, 2, 4, 1, '10', 50, '', '2024-11-26 07:28:40', 'identified'),
(62, 2, 4, 1, '10', 50, '', '2024-11-26 07:28:40', 'identified'),
(63, 1, 18, 21, '10', 0, '', '2024-11-26 08:15:40', 'identified'),
(64, 1, 18, 21, '10', 0, '', '2024-11-26 08:15:40', 'identified'),
(65, 1, 18, 21, '10', 0, '', '2024-11-26 08:20:04', 'identified'),
(66, 1, 18, 21, '10', 0, '', '2024-11-26 08:20:04', 'identified');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_symptoms`
--

DROP TABLE IF EXISTS `diagnosis_symptoms`;
CREATE TABLE IF NOT EXISTS `diagnosis_symptoms` (
  `diagnosis_id` int NOT NULL,
  `symptom_id` int NOT NULL,
  `severity_level` int DEFAULT '1',
  PRIMARY KEY (`diagnosis_id`,`symptom_id`),
  KEY `symptom_id` (`symptom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diagnosis_symptoms`
--

INSERT INTO `diagnosis_symptoms` (`diagnosis_id`, `symptom_id`, `severity_level`) VALUES
(1, 2, 1),
(2, 2, 1),
(3, 2, 1),
(4, 2, 1),
(5, 2, 1),
(6, 2, 1),
(7, 2, 1),
(7, 20, 1),
(8, 2, 1),
(8, 20, 1),
(9, 8, 1),
(10, 8, 1),
(11, 1, 1),
(11, 13, 1),
(12, 1, 1),
(12, 13, 1),
(13, 1, 1),
(14, 1, 1),
(15, 1, 1),
(15, 13, 1),
(16, 1, 1),
(16, 13, 1),
(17, 2, 1),
(18, 2, 1),
(19, 2, 1),
(19, 8, 1),
(20, 2, 1),
(20, 8, 1),
(21, 2, 1),
(21, 20, 1),
(22, 2, 1),
(22, 20, 1),
(23, 2, 1),
(23, 7, 1),
(23, 20, 1),
(24, 2, 1),
(24, 7, 1),
(24, 20, 1),
(25, 3, 1),
(26, 3, 1),
(27, 10, 1),
(27, 17, 1),
(28, 10, 1),
(28, 17, 1),
(29, 2, 1),
(30, 2, 1),
(31, 2, 1),
(32, 2, 1),
(33, 2, 1),
(34, 2, 1),
(35, 1, 1),
(36, 1, 1),
(37, 1, 1),
(37, 3, 1),
(38, 1, 1),
(38, 3, 1),
(39, 1, 1),
(40, 1, 1),
(41, 2, 1),
(42, 2, 1),
(43, 2, 1),
(44, 2, 1),
(45, 2, 1),
(46, 2, 1),
(47, 8, 1),
(47, 20, 1),
(48, 8, 1),
(48, 20, 1),
(49, 1, 1),
(49, 4, 1),
(50, 1, 1),
(50, 4, 1),
(51, 20, 1),
(52, 20, 1),
(53, 2, 1),
(54, 2, 1),
(55, 18, 1),
(56, 18, 1),
(57, 18, 1),
(58, 18, 1),
(59, 2, 1),
(59, 18, 1),
(60, 2, 1),
(60, 18, 1),
(61, 1, 1),
(62, 1, 1),
(63, 20, 1),
(64, 20, 1),
(65, 13, 1),
(65, 15, 1),
(65, 20, 1),
(66, 13, 1),
(66, 15, 1),
(66, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

DROP TABLE IF EXISTS `diseases`;
CREATE TABLE IF NOT EXISTS `diseases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `scientific_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `severity_level` enum('Low','Moderate','High') DEFAULT 'Moderate',
  `treatment_info` text,
  `prevention_info` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`id`, `name`, `scientific_name`, `description`, `severity_level`, `treatment_info`, `prevention_info`, `created_at`) VALUES
(1, 'Leaf Blight', 'Magnaporthe oryzae', 'Fungal disease affecting leaves', 'High', 'Apply fungicides', 'Plant resistant varieties', '2024-11-25 22:03:40'),
(2, 'Powdery Mildew', 'Erysiphe graminis', 'White powdery fungal growth', 'Moderate', 'Use sulfur sprays', 'Ensure proper air circulation', '2024-11-25 22:03:40'),
(3, 'Root Rot', 'Fusarium sp.', 'Disease affecting plant roots', 'High', 'Improve drainage', 'Avoid overwatering', '2024-11-25 22:03:40'),
(4, 'Bacterial Spot', 'Xanthomonas sp.', 'Bacterial infection causing spots', 'Moderate', 'Use copper-based sprays', 'Sanitize tools', '2024-11-25 22:03:40'),
(5, 'Rust', 'Puccinia sp.', 'Fungal disease causing rust-colored spots', 'Moderate', 'Apply systemic fungicides', 'Rotate crops', '2024-11-25 22:03:40'),
(6, 'Black Rot', 'Xanthomonas campestris', 'Bacterial disease affecting leaves', 'High', 'Remove infected plants', 'Use certified seeds', '2024-11-25 22:03:40'),
(7, 'Downy Mildew', 'Plasmopara viticola', 'Gray fungal growth on undersides of leaves', 'Moderate', 'Apply fungicides', 'Improve ventilation', '2024-11-25 22:03:40'),
(8, 'Anthracnose', 'Colletotrichum sp.', 'Fungal disease causing dark lesions', 'High', 'Apply appropriate fungicides', 'Avoid overhead irrigation', '2024-11-25 22:03:40'),
(9, 'Wilt', 'Ralstonia solanacearum', 'Bacterial disease causing wilting', 'High', 'Improve soil drainage', 'Sterilize soil', '2024-11-25 22:03:40'),
(10, 'Scab', 'Venturia inaequalis', 'Fungal disease causing scabs on fruits', 'Low', 'Prune infected areas', 'Use resistant varieties', '2024-11-25 22:03:40'),
(11, 'Smut', 'Ustilago maydis', 'Fungal disease affecting grains', 'Moderate', 'Apply fungicides', 'Rotate crops', '2024-11-25 22:03:40'),
(12, 'Blossom End Rot', 'Physiological Disorder', 'Calcium deficiency causing rot', 'Low', 'Add calcium to soil', 'Water consistently', '2024-11-25 22:03:40'),
(13, 'Early Blight', 'Alternaria solani', 'Fungal disease causing leaf spots', 'Moderate', 'Apply fungicides', 'Remove plant debris', '2024-11-25 22:03:40'),
(14, 'Late Blight', 'Phytophthora infestans', 'Fungal disease causing plant death', 'High', 'Use fungicides', 'Plant resistant varieties', '2024-11-25 22:03:40'),
(15, 'Clubroot', 'Plasmodiophora brassicae', 'Soilborne disease affecting roots', 'High', 'Apply lime to soil', 'Use resistant cultivars', '2024-11-25 22:03:40'),
(16, 'Fire Blight', 'Erwinia amylovora', 'Bacterial disease causing blackened shoots', 'High', 'Prune infected branches', 'Sanitize tools', '2024-11-25 22:03:40'),
(17, 'Leaf Curl', 'Taphrina deformans', 'Fungal disease causing curled leaves', 'Moderate', 'Apply dormant sprays', 'Remove infected leaves', '2024-11-25 22:03:40'),
(18, 'Mosaic Virus', 'Virus', 'Viral disease causing mottled leaves', 'Moderate', 'Remove infected plants', 'Control vector insects', '2024-11-25 22:03:40'),
(19, 'Gray Mold', 'Botrytis cinerea', 'Fungal disease causing grayish decay', 'High', 'Use fungicides', 'Avoid overcrowding', '2024-11-25 22:03:40'),
(20, 'Phytophthora Root Rot', 'Phytophthora sp.', 'Disease affecting roots and stems', 'High', 'Improve soil drainage', 'Avoid waterlogging', '2024-11-25 22:03:40'),
(21, 'Unknown Condition', NULL, 'Condition that could not be definitively diagnosed', 'Moderate', NULL, NULL, '2024-11-26 07:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `disease_symptoms`
--

DROP TABLE IF EXISTS `disease_symptoms`;
CREATE TABLE IF NOT EXISTS `disease_symptoms` (
  `disease_id` int NOT NULL,
  `symptom_id` int NOT NULL,
  `weight` int DEFAULT '1',
  PRIMARY KEY (`disease_id`,`symptom_id`),
  KEY `symptom_id` (`symptom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disease_symptoms`
--

INSERT INTO `disease_symptoms` (`disease_id`, `symptom_id`, `weight`) VALUES
(1, 1, 3),
(1, 2, 4),
(2, 2, 3),
(2, 12, 5),
(3, 3, 5),
(3, 10, 4),
(4, 2, 3),
(4, 11, 4),
(5, 2, 4),
(5, 7, 3),
(6, 8, 4),
(6, 12, 5),
(7, 5, 4),
(7, 9, 3),
(8, 10, 3),
(8, 13, 4),
(9, 2, 4),
(9, 14, 3),
(10, 2, 4),
(10, 15, 3),
(11, 3, 5),
(11, 16, 3),
(12, 3, 5),
(12, 17, 3),
(13, 3, 5),
(13, 18, 4),
(14, 13, 3),
(14, 19, 5),
(15, 10, 4),
(15, 20, 2),
(16, 5, 4),
(16, 14, 3),
(17, 8, 4),
(17, 12, 5),
(18, 9, 3),
(18, 10, 4),
(19, 2, 4),
(19, 11, 4),
(20, 7, 3),
(20, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `growth_stages`
--

DROP TABLE IF EXISTS `growth_stages`;
CREATE TABLE IF NOT EXISTS `growth_stages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `duration_days` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `growth_stages`
--

INSERT INTO `growth_stages` (`id`, `name`, `description`, `duration_days`, `created_at`) VALUES
(1, 'Seedling', 'Initial growth stage', 14, '2024-11-25 22:03:40'),
(2, 'Vegetative', 'Main growth period', 30, '2024-11-25 22:03:40'),
(3, 'Flowering', 'Reproductive stage', 20, '2024-11-25 22:03:40'),
(4, 'Fruiting', 'Fruit development', 40, '2024-11-25 22:03:40'),
(5, 'Mature', 'Ready for harvest', 15, '2024-11-25 22:03:40'),
(6, 'Germination', 'Process of sprouting', 7, '2024-11-25 22:03:40'),
(7, 'Tillering', 'Stem elongation stage', 20, '2024-11-25 22:03:40'),
(8, 'Booting', 'Pre-flowering stage', 15, '2024-11-25 22:03:40'),
(9, 'Ripening', 'Final maturity stage', 10, '2024-11-25 22:03:40'),
(10, 'Leaf Development', 'Growth of new leaves', 14, '2024-11-25 22:03:40'),
(11, 'Root Development', 'Formation of root systems', 25, '2024-11-25 22:03:40'),
(12, 'Early Growth', 'Initial plant growth', 10, '2024-11-25 22:03:40'),
(13, 'Mid Growth', 'Rapid vegetative growth phase', 35, '2024-11-25 22:03:40'),
(14, 'Pollination', 'Transfer of pollen', 5, '2024-11-25 22:03:40'),
(15, 'Seed Development', 'Formation of seeds', 25, '2024-11-25 22:03:40'),
(16, 'Stem Elongation', 'Significant height increase', 20, '2024-11-25 22:03:40'),
(17, 'Foliage Maturity', 'Leaves reach maximum size', 18, '2024-11-25 22:03:40'),
(18, 'Flower Initiation', 'Early flower bud formation', 12, '2024-11-25 22:03:40'),
(19, 'Reproductive Maturity', 'Plant is ready for reproduction', 22, '2024-11-25 22:03:40'),
(20, 'Dormancy', 'Growth slows or halts', 60, '2024-11-25 22:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

DROP TABLE IF EXISTS `recommendations`;
CREATE TABLE IF NOT EXISTS `recommendations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disease_id` int NOT NULL,
  `recommendation` text NOT NULL,
  `type` enum('Prevention','Treatment','Management') DEFAULT 'Treatment',
  `priority` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `disease_id` (`disease_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`id`, `disease_id`, `recommendation`, `type`, `priority`) VALUES
(1, 1, 'Use resistant rice varieties such as IR64 or Swarna.', 'Prevention', 1),
(2, 1, 'Apply fungicides like azoxystrobin or tricyclazole during early infection.', 'Treatment', 2),
(3, 1, 'Ensure proper spacing between plants to improve air circulation.', 'Management', 3),
(4, 2, 'Ensure good air circulation by pruning dense foliage.', 'Prevention', 1),
(5, 2, 'Spray sulfur-based or potassium bicarbonate fungicides.', 'Treatment', 2),
(6, 2, 'Water plants in the morning to allow leaves to dry quickly.', 'Management', 3),
(7, 3, 'Avoid overwatering and ensure proper soil drainage.', 'Prevention', 1),
(8, 3, 'Treat with soil fumigants like methyl bromide or biological fungicides.', 'Treatment', 2),
(9, 3, 'Rotate crops to avoid pathogen buildup in the soil.', 'Management', 3),
(10, 4, 'Plant certified disease-free seeds and transplants.', 'Prevention', 1),
(11, 4, 'Apply copper-based bactericides at regular intervals.', 'Treatment', 2),
(12, 4, 'Remove and destroy infected plant debris to reduce pathogen spread.', 'Management', 3),
(13, 5, 'Use rust-resistant varieties of wheat like PBW 343 or DBW 88.', 'Prevention', 1),
(14, 5, 'Apply fungicides such as tebuconazole or triadimefon.', 'Treatment', 2),
(15, 5, 'Avoid planting wheat close to barberry bushes, which host rust spores.', 'Management', 3),
(16, 6, 'Plant mildew-resistant cultivars where available.', 'Prevention', 1),
(17, 6, 'Apply metalaxyl-based fungicides when symptoms appear.', 'Treatment', 2),
(18, 6, 'Reduce humidity levels in greenhouses by proper ventilation.', 'Management', 3),
(19, 7, 'Avoid overhead irrigation to minimize leaf wetness.', 'Prevention', 1),
(20, 7, 'Use fungicides like chlorothalonil or mancozeb.', 'Treatment', 2),
(21, 7, 'Remove infected plant parts to reduce spore sources.', 'Management', 3),
(22, 16, 'Plant resistant apple cultivars like Enterprise or Liberty.', 'Prevention', 1),
(23, 16, 'Spray streptomycin during the bloom phase.', 'Treatment', 2),
(24, 16, 'Prune infected branches at least 12 inches below the visible symptoms.', 'Management', 3),
(25, 6, 'Apply lime sulfur sprays during the dormant season.', 'Prevention', 1),
(26, 6, 'Use fungicides containing captan during the growing season.', 'Treatment', 2),
(27, 6, 'Remove mummified fruits and infected leaves.', 'Management', 3),
(28, 20, 'Ensure good airflow in dense crops like strawberries.', 'Prevention', 1),
(29, 20, 'Apply fungicides such as iprodione or boscalid.', 'Treatment', 2),
(30, 20, 'Harvest ripe fruits promptly to minimize disease spread.', 'Management', 3);

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

DROP TABLE IF EXISTS `symptoms`;
CREATE TABLE IF NOT EXISTS `symptoms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `severity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `symptoms`
--

INSERT INTO `symptoms` (`id`, `name`, `description`, `severity`, `created_at`) VALUES
(1, 'Yellowing of leaves', 'Leaves turning yellow', 2, '2024-11-25 22:03:40'),
(2, 'Brown spots', 'Brown/Black spots on leaves', 3, '2024-11-25 22:03:40'),
(3, 'Wilting', 'Plant drooping or wilting', 4, '2024-11-25 22:03:40'),
(4, 'Stunted growth', 'Reduced plant growth', 3, '2024-11-25 22:03:40'),
(5, 'Lesions', 'Open wounds on plant', 4, '2024-11-25 22:03:40'),
(6, 'Visible mold', 'Fungal growth visible', 5, '2024-11-25 22:03:40'),
(7, 'Curled leaves', 'Leaves curling or deforming', 2, '2024-11-25 22:03:40'),
(8, 'Blackened stems', 'Stem discoloration', 4, '2024-11-25 22:03:40'),
(9, 'Rotting fruits', 'Fruits decaying on plant', 5, '2024-11-25 22:03:40'),
(10, 'Discolored roots', 'Unhealthy root appearance', 3, '2024-11-25 22:03:40'),
(11, 'Water-soaked lesions', 'Wet patches on leaves', 4, '2024-11-25 22:03:40'),
(12, 'White powdery growth', 'Fungal patches on leaves', 5, '2024-11-25 22:03:40'),
(13, 'Mottled leaves', 'Uneven coloration', 3, '2024-11-25 22:03:40'),
(14, 'Premature fruit drop', 'Fruits falling off early', 4, '2024-11-25 22:03:40'),
(15, 'Sticky residues', 'Sticky sap on surfaces', 3, '2024-11-25 22:03:40'),
(16, 'Cracking fruits', 'Fruits split open', 2, '2024-11-25 22:03:40'),
(17, 'Deformed fruits', 'Misshapen fruit development', 3, '2024-11-25 22:03:40'),
(18, 'Blisters', 'Raised bumps on leaves', 4, '2024-11-25 22:03:40'),
(19, 'Necrotic tissue', 'Dead plant areas', 5, '2024-11-25 22:03:40'),
(20, 'Chlorosis', 'Loss of green pigment in leaves', 2, '2024-11-25 22:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Astrav', 'danielsempala6@gmail.com', '$2y$10$dLuuZj8quuksJtHrMwiFPui0YRE287/Tk7mk9JVwBXpEBZOw26t56', '2024-11-25 22:05:22'),
(2, 'Zed', 'zed@gmail.com', '$2y$10$Rt0FBFMga5RnnnsGwBEaSuafJcaGCJGcOQIBwWBmPfLioP3BBwfCC', '2024-11-26 07:28:07');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crop_diseases`
--
ALTER TABLE `crop_diseases`
  ADD CONSTRAINT `crop_diseases_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crop_diseases_ibfk_2` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD CONSTRAINT `diagnoses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diagnoses_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crops` (`id`),
  ADD CONSTRAINT `diagnoses_ibfk_3` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`);

--
-- Constraints for table `diagnosis_symptoms`
--
ALTER TABLE `diagnosis_symptoms`
  ADD CONSTRAINT `diagnosis_symptoms_ibfk_1` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diagnosis_symptoms_ibfk_2` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disease_symptoms`
--
ALTER TABLE `disease_symptoms`
  ADD CONSTRAINT `disease_symptoms_ibfk_1` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disease_symptoms_ibfk_2` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
