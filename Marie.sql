-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 02, 2024 at 10:45 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Marie`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `state` varchar(15) NOT NULL,
  `state_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `description`, `state`, `state_id`) VALUES
(4, 'Fennec Fox', 'with large ears for heat dissipation.', 'Kébili', NULL),
(5, 'Dromedary Camel', 'A single-humped camel adapted to desert life.', 'Tataouine', NULL),
(9, 'Desert Hedgehog', 'A small, spiny mammal living in dry habitats.', 'Médenine', NULL),
(10, 'Barbary Macaque', 'A tailless monkey, found in forests and mountains.', 'Béja', NULL),
(11, 'African Wildcatt', 'A small wild feline, ancestor of domestic cats.', 'Jendouba', NULL),
(15, 'Marbled Teal', 'A rare duck species with marbled plumage.', 'Sfax', NULL),
(17, 'Lanner Falcon', 'A medium-sized falcon, a skilled hunter.', 'Kassérine', NULL),
(20, 'Barn Owl', 'A nocturnal bird with a heart-shaped face.', 'Le Kef', NULL),
(21, 'White Stork', 'A migratory bird that nests in Tunisia’s wetlands.', 'Béja', NULL),
(23, 'European Bee-Eater', 'A colorful bird that feeds on flying insects.', 'Kairouan', NULL),
(24, 'Atlas Mountain Viper', 'A venomous snake found in rocky habitats.', 'Zaghouan', NULL),
(26, 'Spiny-Tailed Lizard', 'A herbivorous lizard with a spiny tail.', 'Gafsa', NULL),
(27, 'Mediterranean Chameleon', 'A tree-dwelling lizard with color-changing skin.', 'Gabès', NULL),
(28, 'Saharan Horned Viper', 'A venomous snake with horn-like scales above its eyes.', 'Tataouine', NULL),
(29, 'Moorish Gecko', 'A nocturnal gecko with a rough, warty skin.', 'Médenine', NULL),
(30, 'Levant Skink', 'A small, smooth-scaled lizard.', 'Gabès', NULL),
(31, 'Berber Toad', 'A common amphibian found near water bodies.', 'Jendouba', NULL),
(32, 'North African Green Frog', 'A bright green frog inhabiting wetlands.', 'Béja', NULL),
(33, 'Mediterranean Monk Seal', 'An endangered seal species seen along Tunisia\'s coast.', 'Bizerte', NULL),
(34, 'Loggerhead Sea Turtle', 'A large marine turtle nesting on Tunisia’s beaches.', 'Gabès', NULL),
(35, 'Common Bottlenose Dolphin', 'A playful dolphin species in coastal waters.', 'Monastir', NULL),
(38, 'Atlas Swallowtail Butterfly', 'A large butterfly with striking colors.', 'Béja', NULL),
(41, 'Barbary Ground Squirrel', 'A rodent with striped fur, living in rocky areas.', 'Kassérine', NULL),
(90, 'Dromedary Cameljjj', 'A single-humped camel adapted to desert life.', 'Bizerte', NULL),
(104, 'Barbary Sheep', 'A wild sheep species found in North Africa, often seen in mountainous regions.', 'L\'Ariana', NULL),
(105, 'European Bee-Eater', 'A colorful bird that feeds on flying insects, common in southern Europe and North Africa.', 'La Manouba', NULL),
(106, 'Mediterranean Chameleon', 'A tree-dwelling lizard with color-changing skin, found in Mediterranean regions.', 'La Manouba', NULL),
(107, 'Barn Owl', 'A nocturnal bird with a heart-shaped face, often found in agricultural fields.', 'Ben Arous', NULL),
(108, 'Levant Skink', 'A small, smooth-scaled lizard found in arid and semi-arid regions of North Africa.', 'Ben Arous', NULL),
(109, 'Loggerhead Sea Turtle', 'A large marine turtle nesting on Tunisia’s beaches, known for its distinctive large head.', 'Mahdia', NULL),
(110, 'Common Bottlenose Dolphin', 'A playful dolphin species found in coastal waters, often seen in groups.', 'Mahdia', NULL),
(111, 'Desert Hedgehog', 'A small, spiny mammal that thrives in arid, dry environments.', 'Sousse', NULL),
(112, 'Marbled Teal', 'A rare duck species with distinctive marbled plumage, found in wetlands.', 'Sousse', NULL),
(113, 'Atlas Mountain Viper', 'A venomous snake found in rocky habitats, known for its beautiful patterns.', 'Siliana', NULL),
(114, 'Moorish Gecko', 'A nocturnal gecko with rough, warty skin, commonly found in dry regions.', 'Siliana', NULL),
(115, 'Saharan Horned Viper', 'A venomous snake characterized by horn-like scales above its eyes.', 'Sidi Bouzid', NULL),
(116, 'Barbary Ground Squirrel', 'A small rodent with striped fur, often found in rocky areas.', 'Sidi Bouzid', NULL),
(117, 'White Stork', 'A migratory bird that nests in Tunisia’s wetlands, known for its large size and striking white plumage.', 'Nabeul', NULL),
(118, 'Atlas Swallowtail Butterfly', 'A large butterfly with striking colors, found in Mediterranean regions.', 'Nabeul', NULL),
(119, 'Mediterranean Monk Seal', 'An endangered seal species seen along Tunisia\'s coast, often found in caves or rocky shorelines.', 'Tunis', NULL),
(120, 'North African Green Frog', 'A bright green frog inhabiting wetlands, known for its distinctive coloration.', 'Tunis', NULL),
(121, 'European Bee-Eater', 'A colorful bird that feeds on flying insects, common in southern Europe and North Africa.', 'La_Manouba', NULL),
(122, 'Mediterranean Chameleon', 'A tree-dwelling lizard with color-changing skin, found in Mediterranean regions.', 'La_Manouba', NULL),
(123, 'Dromedary Camel', 'A single-humped camel adapted to desert life, well-suited to hot, arid climates.', 'Tozeur', NULL),
(125, 'Fennec Fox', 'A small nocturnal fox with large ears for heat dissipation, native to the Sahara desert.', 'Ariana', NULL),
(133, 'vvvv', 'vv', 'Tunis', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `animal` varchar(255) DEFAULT NULL,
  `plant` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `ido` int NOT NULL,
  `namep` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descriptionp` varchar(104) NOT NULL,
  `statep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `state_idp` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`ido`, `namep`, `descriptionp`, `statep`, `state_idp`) VALUES
(222, 'Carob Tree', 'Used in food and animal feed.', 'Kairouan', NULL),
(223, 'Date Palm', 'Famous for dates, used in local food.', 'Sousse', NULL),
(224, 'Olive Tree', 'Major olive oil producing region.', 'Monastir', NULL),
(225, 'Moringa', 'Known for health benefits and nutrition.', 'Gabès', NULL),
(226, 'Citrus Trees', 'Famous for oranges and lemons.', 'Nabeul', NULL),
(228, 'Lavender', 'Grows in cool, hilly regions.', 'Zaghouan', NULL),
(229, 'Eucalyptus', 'Fragrant tree, used medicinally.', 'Bizerte', NULL),
(231, 'Cactus', 'Known for prickly pear fruit.', 'Mahares', NULL),
(232, 'Aleppo Pine', 'Common in Mediterranean forests.', 'L\'Ariana', NULL),
(233, 'Chestnut Tree', 'Common in mountainous regions.', 'Le Kef', NULL),
(234, 'Pistachio Tree', 'Grows well in semi-arid climate.', 'Siliana', NULL),
(236, 'Pine', 'Common in coastal forest areas.', 'Ben Arous', NULL),
(237, 'Cypress Tree', 'Tall, often planted in cemeteries.', 'La Manouba', NULL),
(238, 'Thyme', 'Aromatic herb used in cooking.', 'Kassérine', NULL),
(240, 'Cactus', 'Known for prickly pear fruit.', 'Tataouine', NULL),
(241, 'Cypress Tree', 'Tall, often planted in cemeteries.', 'Mahdia', NULL),
(252, 'Lavender', 'Grows in cool, hilly regions, known for its fragrant purple flowers.', 'Ariana', NULL),
(253, 'Cactus', 'Known for prickly pear fruit, this plant thrives in arid desert regions.', 'Sidi Bouzid', NULL),
(255, 'Pine', 'Common in coastal forests, used in timber and for reforestation efforts.', 'Ben Arous', NULL),
(261, 'Jasmine', 'Known for its fragrant flowers, commonly grown in Sfax.', 'Sfax', NULL),
(262, 'Acacia', 'A tree commonly found in desert regions like Kébili.', 'Kébili', NULL),
(263, 'Bougainvillea', 'Popular ornamental plant known for its vibrant colors.', 'Tunis', NULL),
(264, 'Cedar of Lebanon', 'Majestic evergreen tree found in the mountains of Jendouba.', 'Jendouba', NULL),
(265, 'Fennel', 'A Mediterranean herb, commonly found in fertile regions like Béja.', 'Béja', NULL),
(266, 'Cactus', 'A hardy plant suited for dry, desert climates, found in Médenine.', 'Médenine', NULL),
(267, 'Geranium', 'Ornamental plant, often grown in gardens, commonly found in La Manouba.', 'La Manouba', NULL),
(269, 'Rosemary', 'A fragrant herb used in cooking, known for its resilience in dry conditions, found in Kassérine.', 'Kassérine', NULL),
(270, 'Eucalyptus camaldulensis', 'A species of eucalyptus tree native to Australia', 'Gafsa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1111, 'Kébili'),
(1112, 'Tataouine'),
(1113, 'Médenine'),
(1114, 'Béja'),
(1115, 'Jendouba'),
(1116, 'Sfax'),
(1117, 'Kassérine'),
(1118, 'Le Kef'),
(1119, 'Kairouan'),
(1120, 'Zaghouan'),
(1121, 'Gafsa'),
(1122, 'Gabès'),
(1123, 'Sidi Bouzid'),
(1124, 'Nabeul'),
(1125, 'Tunis'),
(1126, 'La Manouba'),
(1127, 'L\'Ariana'),
(1128, 'Mahdia'),
(1129, 'Ben Arous'),
(1130, 'Sousse'),
(1131, 'Siliana');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_state` (`state_id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`ido`),
  ADD KEY `fk_state_idp` (`state_idp`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `ido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1132;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `fk_state` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `plants`
--
ALTER TABLE `plants`
  ADD CONSTRAINT `fk_state_idp` FOREIGN KEY (`state_idp`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
