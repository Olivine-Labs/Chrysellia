-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `channelId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `motd` text NOT NULL,
  `defaultAccessRead` tinyint(1) NOT NULL DEFAULT '0',
  `defaultAccessWrite` tinyint(1) NOT NULL DEFAULT '0',
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`channelId`),
  UNIQUE KEY `name` (`name`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`channelId`, `name`, `motd`, `defaultAccessRead`, `defaultAccessWrite`, `createdOn`) VALUES
('CHAN_00000000000000000000001', 'General', 'Welcome to Chrysellia!', 1, 1, '2011-01-06 15:35:42'),
('CHAN_00000000000000000000002', 'Trade', 'Trade chat.', 1, 1, '2011-01-06 15:35:42');