-- --------------------------------------------------------

--
-- Table structure for table `mastery_types`
--

CREATE TABLE IF NOT EXISTS `mastery_types` (
  `masteryId` tinyint(1) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`masteryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mastery_types`
--

INSERT INTO `mastery_types` (`masteryId`, `name`) VALUES
(0, 'Armor'),
(1, 'Sword'),
(2, 'Axe'),
(3, 'Mace'),
(4, 'Staff'),
(5, 'Bow'),
(6, 'Fire'),
(7, 'Air'),
(8, 'Cold'),
(9, 'Earth'),
(10, 'Shadow'),
(11, 'Arcane');
