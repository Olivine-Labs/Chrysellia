-- --------------------------------------------------------

--
-- Table structure for table `map_place_types`
--

CREATE TABLE IF NOT EXISTS `map_place_types` (
  `placeId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`placeId`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_place_types`
--

INSERT INTO `map_place_types` (`placeId`, `name`) VALUES
('PLAC_00000000000000000000005', 'Enterance'),
('PLAC_00000000000000000000004', 'Exit'),
('PLAC_00000000000000000000003', 'Bank'),
('PLAC_00000000000000000000002', 'Shrine'),
('PLAC_00000000000000000000001', 'Store'),
('PLAC_00000000001297393164799', 'Bar'),
('PLAC_00000000001297393088971', 'Coliseum'),
('PLAC_00000000001297393036550', 'Graveyard');