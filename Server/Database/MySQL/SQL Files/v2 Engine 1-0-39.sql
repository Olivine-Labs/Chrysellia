-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2011 at 04:18 PM
-- Server version: 5.1.51
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `neflaria`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `accountId` char(28) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `validated` bit(1) NOT NULL DEFAULT b'0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`accountId`),
  UNIQUE KEY `userName` (`userName`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `achievement_types`
--

CREATE TABLE IF NOT EXISTS `achievement_types` (
  `achievementId` char(28) NOT NULL,
  `achievementName` varchar(150) NOT NULL,
  PRIMARY KEY (`achievementId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `achievement_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `buddy_requests`
--

CREATE TABLE IF NOT EXISTS `buddy_requests` (
  `characterIdFrom` char(28) NOT NULL,
  `characterIdTo` char(28) NOT NULL,
  `requestedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acceptedOn` timestamp NULL DEFAULT NULL,
  KEY `characterIdFrom` (`characterIdFrom`),
  KEY `characterIdTo` (`characterIdTo`),
  KEY `requestedOn` (`requestedOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buddy_requests`
--


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

-- --------------------------------------------------------

--
-- Table structure for table `channel_permissions`
--

CREATE TABLE IF NOT EXISTS `channel_permissions` (
  `channelId` char(28) NOT NULL,
  `characterId` char(28) NOT NULL,
  `isJoined` bit(1) NOT NULL DEFAULT b'0',
  `accessRead` bit(1) NOT NULL DEFAULT b'0',
  `accessModerator` bit(1) NOT NULL DEFAULT b'0',
  `accessWrite` bit(1) NOT NULL DEFAULT b'0',
  `accessAdmin` bit(1) NOT NULL DEFAULT b'0',
  `givenOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`channelId`,`characterId`),
  KEY `givenOn` (`givenOn`),
  KEY `characterId` (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channel_permissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `characterId` char(28) NOT NULL,
  `accountId` char(28) NOT NULL,
  `name` varchar(50) NOT NULL,
  `clanId` char(28) DEFAULT NULL,
  `pin` int(11) NOT NULL,
  `biography` text,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`characterId`),
  UNIQUE KEY `name` (`name`),
  KEY `accountId` (`accountId`),
  KEY `clanId` (`clanId`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `characters`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_achievements`
--

CREATE TABLE IF NOT EXISTS `character_achievements` (
  `characterId` char(28) NOT NULL,
  `achievementId` char(28) NOT NULL,
  `earnedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`characterId`,`achievementId`),
  KEY `achievementId` (`achievementId`),
  KEY `characterId` (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_achievements`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_equipment`
--

CREATE TABLE IF NOT EXISTS `character_equipment` (
  `characterId` char(28) NOT NULL,
  `itemId` char(28) NOT NULL,
  `slots` int(10) unsigned NOT NULL,
  `slotType` int(10) unsigned NOT NULL,
  `slotNumber` int(10) unsigned NOT NULL,
  KEY `itemId` (`itemId`),
  KEY `slotType` (`slotType`),
  KEY `characterId` (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_equipment`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_locations`
--

CREATE TABLE IF NOT EXISTS `character_locations` (
  `characterId` char(28) NOT NULL,
  `mapId` char(28) NOT NULL,
  `positionX` int(11) unsigned NOT NULL,
  `positionY` int(11) unsigned NOT NULL,
  PRIMARY KEY (`characterId`),
  KEY `mapId` (`mapId`),
  KEY `positionX` (`positionX`,`positionY`,`mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_locations`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_masteries`
--

CREATE TABLE IF NOT EXISTS `character_masteries` (
  `characterId` char(28) NOT NULL,
  `masteryId` tinyint(1) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  `masteryBonus` int(11) NOT NULL DEFAULT '0',
  KEY `masteryId` (`masteryId`),
  KEY `characterId` (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_masteries`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_race_traits`
--

CREATE TABLE IF NOT EXISTS `character_race_traits` (
  `characterId` char(28) NOT NULL,
  `strength` int(11) NOT NULL,
  `dexterity` int(11) NOT NULL,
  `wisdom` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `vitality` int(11) NOT NULL,
  `racialAbility` char(28) DEFAULT NULL,
  `weaponSlots` int(10) unsigned NOT NULL DEFAULT '2',
  `armorSlots` int(10) unsigned NOT NULL DEFAULT '1',
  `accessorySlots` int(10) unsigned NOT NULL DEFAULT '1',
  `spellSlots` int(10) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`characterId`),
  KEY `racialAbility` (`racialAbility`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_race_traits`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_statistics`
--

CREATE TABLE IF NOT EXISTS `character_statistics` (
  `characterId` char(28) NOT NULL,
  `pvekills` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pvedeaths` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pvpkills` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pvpdeaths` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_statistics`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_traits`
--

CREATE TABLE IF NOT EXISTS `character_traits` (
  `characterId` char(28) NOT NULL,
  `raceId` char(28) NOT NULL,
  `gender` bit(1) NOT NULL DEFAULT b'0',
  `alignGood` int(11) NOT NULL DEFAULT '0',
  `alignOrder` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '1',
  `freelevels` int(10) unsigned NOT NULL DEFAULT '0',
  `experience` bigint(20) unsigned NOT NULL DEFAULT '0',
  `strength` int(10) unsigned NOT NULL DEFAULT '0',
  `dexterity` int(10) unsigned NOT NULL DEFAULT '0',
  `intelligence` int(10) unsigned NOT NULL DEFAULT '0',
  `wisdom` int(10) unsigned NOT NULL DEFAULT '0',
  `vitality` int(10) unsigned NOT NULL DEFAULT '0',
  `health` int(10) unsigned NOT NULL DEFAULT '0',
  `experienceBonus` int(11) NOT NULL DEFAULT '0',
  `alignBonus` int(11) NOT NULL DEFAULT '0',
  `strengthBonus` int(11) NOT NULL DEFAULT '0',
  `dexterityBonus` int(11) NOT NULL DEFAULT '0',
  `intelligenceBonus` int(11) NOT NULL DEFAULT '0',
  `wisdomBonus` int(11) NOT NULL DEFAULT '0',
  `vitalityBonus` int(11) NOT NULL DEFAULT '0',
  `weaponClassBonus` float NOT NULL DEFAULT '0',
  `armorClassBonus` float NOT NULL DEFAULT '0',
  `gold` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bank` bigint(20) unsigned NOT NULL DEFAULT '150',
  PRIMARY KEY (`characterId`),
  KEY `race` (`raceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_traits`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `characterIdFrom` char(28) DEFAULT NULL,
  `characterIdTo` char(28) DEFAULT NULL,
  `channelId` char(28) NOT NULL,
  `message` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `fromName` varchar(153) NOT NULL,
  `alignGood` int(11) NOT NULL,
  `alignOrder` int(11) NOT NULL,
  `sentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `characterIdFrom` (`characterIdFrom`),
  KEY `channelId` (`channelId`),
  KEY `sentOn` (`sentOn`),
  KEY `type` (`type`),
  KEY `characterIdTo` (`characterIdTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat`
--


-- --------------------------------------------------------

--
-- Table structure for table `clans`
--

CREATE TABLE IF NOT EXISTS `clans` (
  `clanId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `gold` bigint(20) unsigned NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clanId`),
  KEY `name` (`name`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clans`
--


-- --------------------------------------------------------

--
-- Table structure for table `clan_channel_assoc`
--

CREATE TABLE IF NOT EXISTS `clan_channel_assoc` (
  `channelId` char(28) NOT NULL,
  `clanId` char(28) NOT NULL,
  PRIMARY KEY (`channelId`,`clanId`),
  KEY `channelId` (`channelId`),
  KEY `clanId` (`clanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clan_channel_assoc`
--


-- --------------------------------------------------------

--
-- Table structure for table `clan_character_assoc`
--

CREATE TABLE IF NOT EXISTS `clan_character_assoc` (
  `clanId` char(28) NOT NULL,
  `characterId` char(28) NOT NULL,
  `accessStorage` bit(1) NOT NULL DEFAULT b'0',
  `accessVault` bit(1) NOT NULL DEFAULT b'0',
  `accessInvite` bit(1) NOT NULL DEFAULT b'0',
  `accessGiveRights` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`clanId`,`characterId`),
  KEY `characterId` (`characterId`),
  KEY `clanId` (`clanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clan_character_assoc`
--


-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE IF NOT EXISTS `commands` (
  `commandId` char(28) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`commandId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commands`
--


-- --------------------------------------------------------

--
-- Table structure for table `command_permissions`
--

CREATE TABLE IF NOT EXISTS `command_permissions` (
  `commandId` char(28) NOT NULL,
  `characterId` char(28) NOT NULL,
  `channelId` char(28) NOT NULL,
  `access` int(11) NOT NULL,
  `givenOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `commandId` (`commandId`),
  KEY `characterId` (`characterId`),
  KEY `channelId` (`channelId`),
  KEY `givenOn` (`givenOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `command_permissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE IF NOT EXISTS `inventories` (
  `inventoryId` char(28) NOT NULL,
  `characterId` char(28) DEFAULT NULL,
  `clanId` char(28) DEFAULT NULL,
  `maxSlots` int(10) unsigned NOT NULL DEFAULT '20',
  PRIMARY KEY (`inventoryId`),
  KEY `characterId` (`characterId`),
  KEY `clanId` (`clanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventories`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemId` char(28) NOT NULL,
  `itemTemplateId` char(28) NOT NULL,
  `itemType` int(11) NOT NULL,
  `inventoryId` char(28) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `buyPrice` float NOT NULL,
  `sellPrice` float NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`itemId`),
  KEY `itemTemplateId` (`itemTemplateId`),
  KEY `inventoryId` (`inventoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_consumables`
--

CREATE TABLE IF NOT EXISTS `item_consumables` (
  `itemId` char(28) NOT NULL,
  `onUse` text,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_consumables`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_equippables`
--

CREATE TABLE IF NOT EXISTS `item_equippables` (
  `itemId` char(28) NOT NULL,
  `masteryType` int(10) unsigned NOT NULL,
  `itemClass` int(10) unsigned NOT NULL,
  `sockets` int(11) NOT NULL,
  `slots` int(11) NOT NULL,
  `slotType` int(11) NOT NULL,
  `onEquip` text,
  `onUnequip` text,
  `onAttack` text,
  `onDefend` text,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_equippables`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_socketables`
--

CREATE TABLE IF NOT EXISTS `item_socketables` (
  `itemId` char(28) NOT NULL,
  `socketedIn` char(28) DEFAULT NULL,
  `onSocket` text,
  PRIMARY KEY (`itemId`),
  KEY `socketedIn` (`socketedIn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_socketables`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_templates`
--

CREATE TABLE IF NOT EXISTS `item_templates` (
  `itemTemplateId` char(28) NOT NULL,
  `itemType` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `buyPrice` float NOT NULL,
  `sellPrice` float NOT NULL,
  PRIMARY KEY (`itemTemplateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_templates`
--

INSERT INTO `item_templates` (`itemTemplateId`, `itemType`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES
('ITEM_00000000000000000000000', 2, 'Dagger', 'This is an item class 0 sword with 1 socket.', 50, 25),
('ITEM_00000000000000000000001', 2, 'Short Sword', 'This is an item class 1 sword with 1 socket.', 85, 43),
('ITEM_00000000000000000000002', 2, 'Demon''s Nail', 'This is an item class 2 sword with 1 socket.', 144, 72),
('ITEM_00000000000000000000003', 2, 'Scimitar', 'This is an item class 3 sword with 1 socket.', 246, 123),
('ITEM_00000000000000000000004', 2, 'Lamprey', 'This is an item class 4 sword with 1 socket.', 418, 209),
('ITEM_00000000000000000000005', 2, 'Sabre', 'This is an item class 5 sword with 1 socket.', 710, 355),
('ITEM_00000000000000000000006', 2, 'Falchion', 'This is an item class 6 sword with 1 socket.', 1207, 604),
('ITEM_00000000000000000000007', 2, 'Long Sword', 'This is an item class 7 sword with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000008', 2, 'Gladius', 'This is an item class 8 sword with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000009', 2, 'Cutlass', 'This is an item class 9 sword with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000010', 2, 'Battle Sword', 'This is an item class 10 sword with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000011', 2, 'War Sword', 'This is an item class 11 sword with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000012', 2, 'Broad Sword', 'This is an item class 12 sword with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000013', 2, 'Crystal Sword', 'This is an item class 13 sword with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000014', 2, 'Rune Sword', 'This is an item class 14 sword with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000015', 2, 'Tusk Sword', 'This is an item class 15 sword with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000016', 2, 'Jataghan', 'This is an item class 16 sword with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000017', 2, 'Claymore', 'This is an item class 17 sword with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000018', 2, 'Dragonslayer', 'This is an item class 18 sword with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000019', 2, 'Jack Handy''s Knife', 'This is an item class 19 sword with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000020', 2, 'Flamberge', 'This is an item class 20 sword with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000021', 2, 'Giant Sword', 'This is an item class 21 sword with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000022', 2, 'Conquestor Sword', 'This is an item class 22 sword with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000023', 2, 'Mythical Sword', 'This is an item class 23 sword with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000024', 2, 'Highlander Sword', 'This is an item class 24 sword with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000025', 2, 'Balrog Blade', 'This is an item class 25 sword with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000026', 2, 'Archangel Blade', 'This is an item class 26 sword with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000027', 2, 'Rapier of the Sky', 'This is an item class 27 sword with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000028', 2, 'Dimension Claymore', 'This is an item class 28 sword with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000029', 2, 'Mythinite Falchion', 'This is an item class 29 sword with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000030', 2, 'Sword of the Realms', 'This is an item class 30 sword with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000031', 2, 'Nightmare Sword', 'This is an item class 31 sword with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000032', 2, 'Vorpal Blade', 'This is an item class 32 sword with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000033', 2, 'Blade of Past Glory', 'This is an item class 33 sword with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000034', 2, 'Sword of Eternity', 'This is an item class 34 sword with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000035', 2, 'Dante''s Flame Edge', 'This is an item class 35 sword with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000036', 2, 'Retribution Blade', 'This is an item class 36 sword with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000037', 2, 'Hand Axe', 'This is an item class 0 axe with 1 socket.', 50, 25),
('ITEM_00000000000000000000038', 2, 'Hatchet', 'This is an item class 1 axe with 1 socket.', 85, 43),
('ITEM_00000000000000000000039', 2, 'Steel Axe', 'This is an item class 2 axe with 1 socket.', 144, 72),
('ITEM_00000000000000000000040', 2, 'Woodcutter''s Axe', 'This is an item class 3 axe with 1 socket.', 246, 123),
('ITEM_00000000000000000000041', 2, 'Great Axe', 'This is an item class 4 axe with 1 socket.', 418, 209),
('ITEM_00000000000000000000042', 2, 'War Axe', 'This is an item class 5 axe with 1 socket.', 710, 355),
('ITEM_00000000000000000000043', 2, 'Bearded Axe', 'This is an item class 6 axe with 1 socket.', 1207, 604),
('ITEM_00000000000000000000044', 2, 'Tabar', 'This is an item class 7 axe with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000045', 2, 'Ancient Axe', 'This is an item class 8 axe with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000046', 2, 'Tomahawak', 'This is an item class 9 axe with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000047', 2, 'Berserker Axe', 'This is an item class 10 axe with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000048', 2, 'Silver Edge Axe', 'This is an item class 11 axe with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000049', 2, 'Dwarven Mining Pick', 'This is an item class 12 axe with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000050', 2, 'Military Pick', 'This is an item class 13 axe with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000051', 2, 'Weird Axe', 'This is an item class 14 axe with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000052', 2, 'Decapitator', 'This is an item class 15 axe with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000053', 2, 'Axe of Kevlar', 'This is an item class 16 axe with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000054', 2, 'Axe of Doom', 'This is an item class 17 axe with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000055', 2, 'Ancient Dwarven Axe', 'This is an item class 18 axe with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000056', 2, 'Troll Chieftain Axe', 'This is an item class 19 axe with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000057', 2, 'Lucifer''s Axe', 'This is an item class 20 axe with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000058', 2, 'Legendary Minotaur Axe', 'This is an item class 21 axe with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000059', 2, 'Adamantium Waraxe', 'This is an item class 22 axe with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000060', 2, 'Endless Night Axe', 'This is an item class 23 axe with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000061', 2, 'Limb Destroyer', 'This is an item class 24 axe with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000062', 2, 'Axe of Power', 'This is an item class 25 axe with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000063', 2, 'Inflictor of Pain', 'This is an item class 26 axe with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000064', 2, 'Nightblade Waraxe', 'This is an item class 27 axe with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000065', 2, 'Dwarven Axe of Doom', 'This is an item class 28 axe with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000066', 2, 'Infernal Poisoned Axe', 'This is an item class 29 axe with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000067', 2, 'Mythinite Hatchet', 'This is an item class 30 axe with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000068', 2, 'Edge of Terror', 'This is an item class 31 axe with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000069', 2, 'Black Prayer Axe', 'This is an item class 32 axe with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000070', 2, 'Axe of Past Glory', 'This is an item class 33 axe with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000071', 2, 'Double axe of Time', 'This is an item class 34 axe with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000072', 2, 'Soul Wraith Axe', 'This is an item class 35 axe with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000073', 2, 'Mutant Maker', 'This is an item class 36 axe with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000074', 2, 'Tree Branch', 'This is an item class 0 staff with 1 socket.', 50, 25),
('ITEM_00000000000000000000075', 2, 'Walking Staff', 'This is an item class 1 staff with 1 socket.', 85, 43),
('ITEM_00000000000000000000076', 2, 'Short Staff', 'This is an item class 2 staff with 1 socket.', 144, 72),
('ITEM_00000000000000000000077', 2, 'Staff', 'This is an item class 3 staff with 1 socket.', 246, 123),
('ITEM_00000000000000000000078', 2, 'Long Staff', 'This is an item class 4 staff with 1 socket.', 418, 209),
('ITEM_00000000000000000000079', 2, 'Gnarled Staff', 'This is an item class 5 staff with 1 socket.', 710, 355),
('ITEM_00000000000000000000080', 2, 'War Staff', 'This is an item class 6 staff with 1 socket.', 1207, 604),
('ITEM_00000000000000000000081', 2, 'Staff of the Battlemage', 'This is an item class 7 staff with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000082', 2, 'Gothic Staff', 'This is an item class 8 staff with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000083', 2, 'Ironhead Staff', 'This is an item class 9 staff with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000084', 2, 'Bladed Quarterstaff', 'This is an item class 10 staff with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000085', 2, 'Rune Staff', 'This is an item class 11 staff with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000086', 2, 'Twisted Staff', 'This is an item class 12 staff with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000087', 2, 'Archon Staff', 'This is an item class 13 staff with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000088', 2, 'Elder Staff', 'This is an item class 14 staff with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000089', 2, 'Elven Battlestaff', 'This is an item class 15 staff with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000090', 2, 'Serpent Staff', 'This is an item class 16 staff with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000091', 2, 'Salamander Staff', 'This is an item class 17 staff with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000092', 2, 'Ribcracker Staff', 'This is an item class 18 staff with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000093', 2, 'Stormcaller Staff', 'This is an item class 19 staff with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000094', 2, 'Staff of Light', 'This is an item class 20 staff with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000095', 2, 'Staff of the Winds', 'This is an item class 21 staff with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000096', 2, 'Staff of the Moon', 'This is an item class 22 staff with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000097', 2, 'Walker of Eternity', 'This is an item class 23 staff with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000098', 2, 'Spine Splitter', 'This is an item class 24 staff with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000099', 2, 'Warstaff of the Deep', 'This is an item class 25 staff with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000100', 2, 'Lamurian Battlestaff', 'This is an item class 26 staff with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000101', 2, 'Quarterstaff of Hades', 'This is an item class 27 staff with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000102', 2, 'Highlord Staff', 'This is an item class 28 staff with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000103', 2, 'Necromancer Staff', 'This is an item class 29 staff with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000104', 2, 'Staff of Blood', 'This is an item class 30 staff with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000105', 2, 'Eternal Tree Staff', 'This is an item class 31 staff with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000106', 2, 'Mythinite Longstaff', 'This is an item class 32 staff with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000107', 2, 'Vash GunBlazer''s Glory', 'This is an item class 33 staff with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000108', 2, 'Staff of Mystery', 'This is an item class 34 staff with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000109', 2, 'Drazons Aura Wand', 'This is an item class 35 staff with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000110', 2, 'Prophetmaker Staff', 'This is an item class 36 staff with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000111', 2, 'Club', 'This is an item class 0 mace with 1 socket.', 50, 25),
('ITEM_00000000000000000000112', 2, 'Spiked Club', 'This is an item class 1 mace with 1 socket.', 85, 43),
('ITEM_00000000000000000000113', 2, 'Cudgel', 'This is an item class 2 mace with 1 socket.', 144, 72),
('ITEM_00000000000000000000114', 2, 'Mace', 'This is an item class 3 mace with 1 socket.', 246, 123),
('ITEM_00000000000000000000115', 2, 'Flanged Mace', 'This is an item class 4 mace with 1 socket.', 418, 209),
('ITEM_00000000000000000000116', 2, 'Morningstar', 'This is an item class 5 mace with 1 socket.', 710, 355),
('ITEM_00000000000000000000117', 2, 'Crusher', 'This is an item class 6 mace with 1 socket.', 1207, 604),
('ITEM_00000000000000000000118', 2, 'War Hammer', 'This is an item class 7 mace with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000119', 2, 'War Club', 'This is an item class 8 mace with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000120', 2, 'Knout', 'This is an item class 9 mace with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000121', 2, 'Tyrant Club', 'This is an item class 10 mace with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000122', 2, 'Devil Star', 'This is an item class 11 mace with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000123', 2, 'Ogre Battlehammer', 'This is an item class 12 mace with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000124', 2, 'Goblin Scourge', 'This is an item class 13 mace with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000125', 2, 'Giant Mace', 'This is an item class 14 mace with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000126', 2, 'Mythril Mace', 'This is an item class 15 mace with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000127', 2, 'Steel Maul', 'This is an item class 16 mace with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000128', 2, 'Ironstone Hammer', 'This is an item class 17 mace with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000129', 2, 'Dark Orc Crusher', 'This is an item class 18 mace with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000130', 2, 'Mace of Destruction', 'This is an item class 19 mace with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000131', 2, 'Armor Basher', 'This is an item class 20 mace with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000132', 2, 'Avatar Maul', 'This is an item class 21 mace with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000133', 2, 'Hammer of The Skies', 'This is an item class 22 mace with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000134', 2, 'Earthshaker', 'This is an item class 23 mace with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000135', 2, 'Giant King Maul', 'This is an item class 24 mace with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000136', 2, 'Knee Breaker', 'This is an item class 25 mace with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000137', 2, 'Skull Splitter', 'This is an item class 26 mace with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000138', 2, 'Magebane Hammer', 'This is an item class 27 mace with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000139', 2, 'Mythinite Flail', 'This is an item class 28 mace with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000140', 2, 'Abyss Maul', 'This is an item class 29 mace with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000141', 2, 'Alien Morningstar', 'This is an item class 30 mace with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000142', 2, 'Titanic Squisher', 'This is an item class 31 mace with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000143', 2, 'Infernal Maul', 'This is an item class 32 mace with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000144', 2, 'Star of Past Glory', 'This is an item class 33 mace with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000145', 2, 'Hammer of the Gods', 'This is an item class 34 mace with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000146', 2, 'Ravens Rain Knout', 'This is an item class 35 mace with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000147', 2, 'Demi Thunder Mace', 'This is an item class 36 mace with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000148', 2, 'Faerie Fire', 'This is an item class 0 fire with 1 socket.', 50, 25),
('ITEM_00000000000000000000149', 2, 'Minor Ignite', 'This is an item class 1 fire with 1 socket.', 85, 43),
('ITEM_00000000000000000000150', 2, 'Burning Hands', 'This is an item class 2 fire with 1 socket.', 144, 72),
('ITEM_00000000000000000000151', 2, 'Firebolt', 'This is an item class 3 fire with 1 socket.', 246, 123),
('ITEM_00000000000000000000152', 2, 'Flame Blast', 'This is an item class 4 fire with 1 socket.', 418, 209),
('ITEM_00000000000000000000153', 2, 'Flame Strike', 'This is an item class 5 fire with 1 socket.', 710, 355),
('ITEM_00000000000000000000154', 2, 'Burning Blood', 'This is an item class 6 fire with 1 socket.', 1207, 604),
('ITEM_00000000000000000000155', 2, 'Fire Fury', 'This is an item class 7 fire with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000156', 2, 'Fireball', 'This is an item class 8 fire with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000157', 2, 'Incinirating Ray', 'This is an item class 9 fire with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000158', 2, 'Hell''s Legion', 'This is an item class 10 fire with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000159', 2, 'Flame Gusts', 'This is an item class 11 fire with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000160', 2, 'Deadly Destruction', 'This is an item class 12 fire with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000161', 2, 'Gaze Of The Phoenix', 'This is an item class 13 fire with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000162', 2, 'Searing Orb', 'This is an item class 14 fire with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000163', 2, 'Incendiary Strike', 'This is an item class 15 fire with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000164', 2, 'Demon Bane', 'This is an item class 16 fire with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000165', 2, 'Aura of Seraph', 'This is an item class 17 fire with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000166', 2, 'Major Ignite', 'This is an item class 18 fire with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000167', 2, 'Elemental Chaos', 'This is an item class 19 fire with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000168', 2, 'The RKOs burning light', 'This is an item class 20 fire with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000169', 2, 'Orb Of Fury', 'This is an item class 21 fire with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000170', 2, 'Flame Gate', 'This is an item class 22 fire with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000171', 2, 'Flamerain Deathshower', 'This is an item class 23 fire with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000172', 2, 'Scorching Touch', 'This is an item class 24 fire with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000173', 2, 'Meteoric Terrablast', 'This is an item class 25 fire with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000174', 2, 'Mythril Melter', 'This is an item class 26 fire with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000175', 2, 'Hell Gate', 'This is an item class 27 fire with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000176', 2, 'Pentagonal Flames', 'This is an item class 28 fire with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000177', 2, 'Magma Blast', 'This is an item class 29 fire with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000178', 2, 'Incinirating Devastation', 'This is an item class 30 fire with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000179', 2, 'Orb of Hell', 'This is an item class 31 fire with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000180', 2, 'Ataturk''s Revenge', 'This is an item class 32 fire with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000181', 2, 'Fire of Past Glory', 'This is an item class 33 fire with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000182', 2, 'Flame of Mystery', 'This is an item class 34 fire with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000183', 2, 'Hades Light', 'This is an item class 35 fire with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000184', 2, 'Embers Sphere', 'This is an item class 36 fire with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000185', 2, 'Gaze of Cold', 'This is an item class 0 cold with 1 socket.', 50, 25),
('ITEM_00000000000000000000186', 2, 'Chilling Touch', 'This is an item class 1 cold with 1 socket.', 85, 43),
('ITEM_00000000000000000000187', 2, 'Cold Bolt', 'This is an item class 2 cold with 1 socket.', 144, 72),
('ITEM_00000000000000000000188', 2, 'Ice Spike', 'This is an item class 3 cold with 1 socket.', 246, 123),
('ITEM_00000000000000000000189', 2, 'Soulless Killer Gaze', 'This is an item class 4 cold with 1 socket.', 418, 209),
('ITEM_00000000000000000000190', 2, 'Mind Chill', 'This is an item class 5 cold with 1 socket.', 710, 355),
('ITEM_00000000000000000000191', 2, 'Vampire Kiss', 'This is an item class 6 cold with 1 socket.', 1207, 604),
('ITEM_00000000000000000000192', 2, 'Cone of Cold', 'This is an item class 7 cold with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000193', 2, 'Finger Of Death', 'This is an item class 8 cold with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000194', 2, 'Ice Storm', 'This is an item class 9 cold with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000195', 2, 'Wrighteous Wrath', 'This is an item class 10 cold with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000196', 2, 'Ring of Cold', 'This is an item class 11 cold with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000197', 2, 'Hannibal''s Horror', 'This is an item class 12 cold with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000198', 2, 'Ice Cone', 'This is an item class 13 cold with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000199', 2, 'Creeping Doom', 'This is an item class 14 cold with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000200', 2, 'Elemental Strike', 'This is an item class 15 cold with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000201', 2, 'Fakir''s Freezing Sphere', 'This is an item class 16 cold with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000202', 2, 'Freezing Ring', 'This is an item class 17 cold with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000203', 2, 'Frost of Tharsis', 'This is an item class 18 cold with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000204', 2, 'Unholy Blight', 'This is an item class 19 cold with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000205', 2, 'Ice Nova', 'This is an item class 20 cold with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000206', 2, 'Shades Call', 'This is an item class 21 cold with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000207', 2, 'Arctic Breath', 'This is an item class 22 cold with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000208', 2, 'White Forgettance', 'This is an item class 23 cold with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000209', 2, 'Eternal Chiller', 'This is an item class 24 cold with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000210', 2, 'Snowball Overload', 'This is an item class 25 cold with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000211', 2, 'Doom Bolt', 'This is an item class 26 cold with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000212', 2, 'Ice Gate', 'This is an item class 27 cold with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000213', 2, 'Redrum''s Revenge', 'This is an item class 28 cold with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000214', 2, 'Hands of Death', 'This is an item class 29 cold with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000215', 2, 'Death Wish', 'This is an item class 30 cold with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000216', 2, 'Absolute Freeze', 'This is an item class 31 cold with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000217', 2, 'Winter Dragonbreath', 'This is an item class 32 cold with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000218', 2, 'Death Embrace', 'This is an item class 33 cold with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000219', 2, 'Snow of Past Glory', 'This is an item class 34 cold with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000220', 2, 'Chill of Eternity', 'This is an item class 35 cold with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000221', 2, 'Gamon Glass', 'This is an item class 36 cold with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000222', 2, 'Minor Shock', 'This is an item class 0 air with 1 socket.', 50, 25),
('ITEM_00000000000000000000223', 2, 'Magic Arrow', 'This is an item class 1 air with 1 socket.', 85, 43),
('ITEM_00000000000000000000224', 2, 'Lightning Bolt', 'This is an item class 2 air with 1 socket.', 144, 72),
('ITEM_00000000000000000000225', 2, 'Demon Breath', 'This is an item class 3 air with 1 socket.', 246, 123),
('ITEM_00000000000000000000226', 2, 'Spectre Strike', 'This is an item class 4 air with 1 socket.', 418, 209),
('ITEM_00000000000000000000227', 2, ' Charge', 'This is an item class 5 air with 1 socket.', 710, 355),
('ITEM_00000000000000000000228', 2, 'Mind Mutation', 'This is an item class 6 air with 1 socket.', 1207, 604),
('ITEM_00000000000000000000229', 2, 'Rain Of Death', 'This is an item class 7 air with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000230', 2, 'Deadly Pestilence', 'This is an item class 8 air with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000231', 2, 'Storm Strike', 'This is an item class 9 air with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000232', 2, 'Spiritual Wrath', 'This is an item class 10 air with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000233', 2, 'Arctic Winds', 'This is an item class 11 air with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000234', 2, 'Soul Eater', 'This is an item class 12 air with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000235', 2, 'Razor Storm', 'This is an item class 13 air with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000236', 2, 'Twin Twisters', 'This is an item class 14 air with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000237', 2, 'Slesai''s Smile', 'This is an item class 15 air with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000238', 2, 'Acid Rain', 'This is an item class 16 air with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000239', 2, 'Heaven''s Wrath', 'This is an item class 17 air with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000240', 2, 'Fazim''s Fist', 'This is an item class 18 air with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000241', 2, 'Cokatrice Feathers', 'This is an item class 19 air with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000242', 2, 'Deadly Eclipse', 'This is an item class 20 air with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000243', 2, 'Contrived Hurricane', 'This is an item class 21 air with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000244', 2, 'Satanic Swarm', 'This is an item class 22 air with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000245', 2, 'Galeblower''s Stormweave', 'This is an item class 23 air with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000246', 2, 'Cloud of Doom', 'This is an item class 24 air with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000247', 2, 'Cumulus Deathbringer', 'This is an item class 25 air with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000248', 2, 'Tempestual Tornado', 'This is an item class 26 air with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000249', 2, 'Hollow Hurricane', 'This is an item class 27 air with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000250', 2, 'DragonLord''s Ephemeral Hex', 'This is an item class 28 air with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000251', 2, 'Storm of Ancients', 'This is an item class 29 air with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000252', 2, 'Black Samum', 'This is an item class 30 air with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000253', 2, 'Terminating Twister', 'This is an item class 31 air with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000254', 2, 'Rayden''s Revenge', 'This is an item class 32 air with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000255', 2, 'Storm of Past Glory', 'This is an item class 33 air with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000256', 2, 'Winds of Time', 'This is an item class 34 air with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000257', 2, 'Relic Weave', 'This is an item class 35 air with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000258', 2, 'Odras Shriek', 'This is an item class 36 air with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000259', 2, 'Minor Heal', 'This is an item class 0 heal with 1 socket.', 50, 25),
('ITEM_00000000000000000000260', 2, 'Cure', 'This is an item class 1 heal with 1 socket.', 85, 43),
('ITEM_00000000000000000000261', 2, 'Priest Touch', 'This is an item class 2 heal with 1 socket.', 144, 72),
('ITEM_00000000000000000000262', 2, 'Bolt Of Light', 'This is an item class 3 heal with 1 socket.', 246, 123),
('ITEM_00000000000000000000263', 2, 'Heal', 'This is an item class 4 heal with 1 socket.', 418, 209),
('ITEM_00000000000000000000264', 2, 'Soul Soother', 'This is an item class 5 heal with 1 socket.', 710, 355),
('ITEM_00000000000000000000265', 2, 'Herbal Restoration', 'This is an item class 6 heal with 1 socket.', 1207, 604),
('ITEM_00000000000000000000266', 2, 'Nullifier', 'This is an item class 7 heal with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000267', 2, 'Beltin''s Blessing', 'This is an item class 8 heal with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000268', 2, 'Sorcerers Surgery', 'This is an item class 9 heal with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000269', 2, 'Kiss Of Life', 'This is an item class 10 heal with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000270', 2, 'Angel Touch', 'This is an item class 11 heal with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000271', 2, 'Allizar''s Antidote', 'This is an item class 12 heal with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000272', 2, 'Sadim''s Sanctuary', 'This is an item class 13 heal with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000273', 2, 'Soul Reviver', 'This is an item class 14 heal with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000274', 2, 'Godly Touch', 'This is an item class 15 heal with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000275', 2, 'Instant Remedy', 'This is an item class 16 heal with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000276', 2, 'Heavenly Hiatus', 'This is an item class 17 heal with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000277', 2, 'Ariel''s Aura', 'This is an item class 18 heal with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000278', 2, 'Rain Of The Gods', 'This is an item class 19 heal with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000279', 2, 'Elixir Of Life', 'This is an item class 20 heal with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000280', 2, 'Redicir''s Remedy', 'This is an item class 21 heal with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000281', 2, 'Soothing Restoration', 'This is an item class 22 heal with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000282', 2, 'Halinor''s Harmonious Heal', 'This is an item class 23 heal with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000283', 2, 'Total Repair', 'This is an item class 24 heal with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000284', 2, 'Miraculous Renewal', 'This is an item class 25 heal with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000285', 2, 'Liisa''s Lament', 'This is an item class 26 heal with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000286', 2, 'Relentless Rejuvination', 'This is an item class 27 heal with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000287', 2, 'Devil''s Dance', 'This is an item class 28 heal with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000288', 2, 'Drusyle''s Ethereal Storm', 'This is an item class 29 heal with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000289', 2, 'Touch of Mystery', 'This is an item class 30 heal with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000290', 2, 'Bless of Heaven', 'This is an item class 31 heal with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000291', 2, 'Unending Cure', 'This is an item class 32 heal with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000292', 2, 'Elixir of Past Glory', 'This is an item class 33 heal with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000293', 2, 'Restoration of Power', 'This is an item class 34 heal with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000294', 2, 'Kiss of Time', 'This is an item class 35 heal with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000295', 2, 'Curas Aurora', 'This is an item class 36 heal with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000296', 2, 'Clothes', 'This is an item class 0 armor with 1 socket.', 50, 25),
('ITEM_00000000000000000000297', 2, 'Wool Cloak', 'This is an item class 1 armor with 1 socket.', 85, 43),
('ITEM_00000000000000000000298', 2, 'Leather Armor', 'This is an item class 2 armor with 1 socket.', 144, 72),
('ITEM_00000000000000000000299', 2, 'Padded Leather Armor', 'This is an item class 3 armor with 1 socket.', 246, 123),
('ITEM_00000000000000000000300', 2, 'Studded Leather Armor', 'This is an item class 4 armor with 1 socket.', 418, 209),
('ITEM_00000000000000000000301', 2, 'Chainmail Armor', 'This is an item class 5 armor with 1 socket.', 710, 355),
('ITEM_00000000000000000000302', 2, 'Linked Armor', 'This is an item class 6 armor with 1 socket.', 1207, 604),
('ITEM_00000000000000000000303', 2, 'Ringmail Armor', 'This is an item class 7 armor with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000304', 2, 'Elven Chain', 'This is an item class 8 armor with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000305', 2, 'Combat Plate', 'This is an item class 9 armor with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000306', 2, 'Mage Plate', 'This is an item class 10 armor with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000307', 2, 'Heavy Plate', 'This is an item class 11 armor with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000308', 2, 'Lamurian Skin Armor', 'This is an item class 12 armor with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000309', 2, 'Moloch Armor', 'This is an item class 13 armor with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000310', 2, 'Angel Skin Armor', 'This is an item class 14 armor with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000311', 2, 'Ancient Breastplate', 'This is an item class 15 armor with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000312', 2, 'Mythril Ringmail', 'This is an item class 16 armor with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000313', 2, 'Adamantium Plate', 'This is an item class 17 armor with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000314', 2, 'Morkal Armor', 'This is an item class 18 armor with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000315', 2, 'Dragon Scale Plate', 'This is an item class 19 armor with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000316', 2, 'Valar Tunic', 'This is an item class 20 armor with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000317', 2, 'Lucifer''s Cape', 'This is an item class 21 armor with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000318', 2, 'Elemental Armor', 'This is an item class 22 armor with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000319', 2, 'Meteoric Chainmail', 'This is an item class 23 armor with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000320', 2, 'Hellforged Plate', 'This is an item class 24 armor with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000321', 2, 'Eternity Armor', 'This is an item class 25 armor with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000322', 2, 'Mythinite Platemail', 'This is an item class 26 armor with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000323', 2, 'Holy Plate of Light', 'This is an item class 27 armor with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000324', 2, 'Behemoth Scalemail', 'This is an item class 28 armor with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000325', 2, 'Plate of the Realms', 'This is an item class 29 armor with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000326', 2, 'Timeless Ice Armor', 'This is an item class 30 armor with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000327', 2, 'Niflheim Plate', 'This is an item class 31 armor with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000328', 2, 'Dominion Chainmail', 'This is an item class 32 armor with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000329', 2, 'Mail of Past Glory', 'This is an item class 33 armor with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000330', 2, 'Plate of Mystery', 'This is an item class 34 armor with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000331', 2, 'Necromancer Mantle', 'This is an item class 35 armor with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000332', 2, 'Menvas Silhouette', 'This is an item class 36 armor with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000333', 2, 'Small Shield', 'This is an item class 0 shield with 1 socket.', 50, 25),
('ITEM_00000000000000000000334', 2, 'Wooden Shield', 'This is an item class 1 shield with 1 socket.', 85, 43),
('ITEM_00000000000000000000335', 2, 'Round Shield', 'This is an item class 2 shield with 1 socket.', 144, 72),
('ITEM_00000000000000000000336', 2, 'Kite Shield', 'This is an item class 3 shield with 1 socket.', 246, 123),
('ITEM_00000000000000000000337', 2, 'Nature Shield', 'This is an item class 4 shield with 1 socket.', 418, 209),
('ITEM_00000000000000000000338', 2, 'Tower Shield', 'This is an item class 5 shield with 1 socket.', 710, 355),
('ITEM_00000000000000000000339', 2, 'Golden Pavise', 'This is an item class 6 shield with 1 socket.', 1207, 604),
('ITEM_00000000000000000000340', 2, 'Gothic Shield', 'This is an item class 7 shield with 1 socket.', 2052, 1026),
('ITEM_00000000000000000000341', 2, 'Scutum', 'This is an item class 8 shield with 1 socket.', 3488, 1744),
('ITEM_00000000000000000000342', 2, 'Serpent Scale Shield', 'This is an item class 9 shield with 1 socket.', 5929, 2965),
('ITEM_00000000000000000000343', 2, 'Ancient Shield', 'This is an item class 10 shield with 1 socket.', 10080, 5040),
('ITEM_00000000000000000000344', 2, 'Hyperion Shield', 'This is an item class 11 shield with 1 socket.', 17136, 8568),
('ITEM_00000000000000000000345', 2, 'Blade Breaker', 'This is an item class 12 shield with 1 socket.', 29131, 14566),
('ITEM_00000000000000000000346', 2, 'Aegis Shield', 'This is an item class 13 shield with 1 socket.', 49523, 24762),
('ITEM_00000000000000000000347', 2, 'Paladin Shield', 'This is an item class 14 shield with 1 socket.', 84189, 42095),
('ITEM_00000000000000000000348', 2, 'Small Mythril Shield', 'This is an item class 15 shield with 1 socket.', 143121, 71561),
('ITEM_00000000000000000000349', 2, 'Crusader Shield', 'This is an item class 16 shield with 2 sockets.', 243306, 121653),
('ITEM_00000000000000000000350', 2, 'Lich Boneshield', 'This is an item class 17 shield with 2 sockets.', 413620, 206810),
('ITEM_00000000000000000000351', 2, 'Dragon Scale Shield', 'This is an item class 18 shield with 2 sockets.', 703154, 351577),
('ITEM_00000000000000000000352', 2, 'Mythril Wallshield', 'This is an item class 19 shield with 2 sockets.', 1.19536e+006, 597681),
('ITEM_00000000000000000000353', 2, 'Morkal Targe', 'This is an item class 20 shield with 2 sockets.', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000354', 2, 'Adamantium Buckler', 'This is an item class 21 shield with 2 sockets.', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000355', 2, 'Shield of the Elements', 'This is an item class 22 shield with 2 sockets.', 5.87281e+006, 2.93641e+006),
('ITEM_00000000000000000000356', 2, 'Demonic Protector', 'This is an item class 23 shield with 2 sockets.', 9.98378e+006, 4.99189e+006),
('ITEM_00000000000000000000357', 2, 'Impenetrable Shield', 'This is an item class 24 shield with 2 sockets.', 1.69724e+007, 8.48622e+006),
('ITEM_00000000000000000000358', 2, 'Behemoth Skin Shield', 'This is an item class 25 shield with 2 sockets.', 2.88531e+007, 1.44266e+007),
('ITEM_00000000000000000000359', 2, 'Mythinite Shield', 'This is an item class 26 shield with 2 sockets.', 4.90503e+007, 2.45252e+007),
('ITEM_00000000000000000000360', 2, 'Shield of the Realms', 'This is an item class 27 shield with 2 sockets.', 8.33856e+007, 4.16928e+007),
('ITEM_00000000000000000000361', 2, 'Pit Fiend Shield', 'This is an item class 28 shield with 2 sockets.', 1.41755e+008, 7.08777e+007),
('ITEM_00000000000000000000362', 2, 'Abyss Shield', 'This is an item class 29 shield with 2 sockets.', 2.40984e+008, 1.20492e+008),
('ITEM_00000000000000000000363', 2, 'Devil Boneshield', 'This is an item class 30 shield with 2 sockets.', 4.09673e+008, 2.04837e+008),
('ITEM_00000000000000000000364', 2, 'Gaia Wallshield', 'This is an item class 31 shield with 2 sockets.', 6.96445e+008, 3.48222e+008),
('ITEM_00000000000000000000365', 2, 'Ageless Pavise', 'This is an item class 32 shield with 2 sockets.', 1.18396e+009, 5.91978e+008),
('ITEM_00000000000000000000366', 2, 'Shield of Past Glory', 'This is an item class 33 shield with 2 sockets.', 2.01272e+009, 1.00636e+009),
('ITEM_00000000000000000000367', 2, 'Shield of Power', 'This is an item class 34 shield with 2 sockets.', 3.42163e+009, 1.71082e+009),
('ITEM_00000000000000000000368', 2, 'Mirror of Narcissus', 'This is an item class 35 shield with 2 sockets.', 5.81677e+009, 2.90839e+009),
('ITEM_00000000000000000000369', 2, 'Zuel''s Spirit Scutum', 'This is an item class 36 shield with 2 sockets.', 9.88852e+009, 4.94426e+009),
('ITEM_00000000000000000000370', 2, 'Copper Ring', '+2,000 Strength while in battle', 2.5e+007, 5e+006),
('ITEM_00000000000000000000371', 2, 'Iron Ring', '+2,000 Intelligence while in battle', 2.5e+007, 5e+006),
('ITEM_00000000000000000000372', 2, 'Blue Ring', '+2,000 Wisdom while in battle', 2.5e+007, 5e+006),
('ITEM_00000000000000000000373', 2, 'Yellow Ring', '+2,000 Dexterity while in battle', 2.5e+007, 5e+006),
('ITEM_00000000000000000000374', 2, 'Goblin Ring', '+1,000 Vitality while in battle, +1,000 Life each round while in battle', 2.5e+007, 5e+006),
('ITEM_00000000000000000000375', 2, 'Wedding Ring', 'Allows you to marry another player', 1e+007, 5e+006),
('ITEM_00000000000000000000376', 2, 'Band of Defence', '+20% evasion against melee attacks', 5e+007, 5e+006),
('ITEM_00000000000000000000377', 2, 'Amulet of Flames', '+50% evasion against fire spells', 5e+007, 5e+006),
('ITEM_00000000000000000000378', 2, 'Amulet of Ice', '+50% evasion against cold spells', 5e+007, 5e+006),
('ITEM_00000000000000000000379', 2, 'Amulet of Lightning', '+50% evasion against air spells', 5e+007, 5e+006),
('ITEM_00000000000000000000380', 2, 'Pendant of Durability', '+3,000 Vitality while in battle, +3,000 Life each round while in battle', 1e+008, 5e+006),
('ITEM_00000000000000000000381', 2, 'Orb of Curing', '+100% accuracy with arcane (healing) spells', 1e+008, 5e+006),
('ITEM_00000000000000000000382', 2, 'Orb of Channeling', '+50% accuracy with spells', 1e+008, 5e+006),
('ITEM_00000000000000000000383', 2, 'Orb of Power', '+6,000 Intelligence while in battle', 1e+008, 5e+006),
('ITEM_00000000000000000000384', 2, 'Gloves of Skill', 'Allows an extra 10% expansion over normal race maximum masteries', 1e+008, 5e+006),
('ITEM_00000000000000000000385', 2, 'Gloves of Haste', '+50% accuracy with melee attacks', 1e+008, 5e+006),
('ITEM_00000000000000000000386', 2, 'Gauntlets of Might', '+6,000 Strength while in battle', 1e+008, 5e+006),
('ITEM_00000000000000000000387', 2, 'Helmet of Invisibility', 'You cannot be located', 2.5e+008, 5e+006),
('ITEM_00000000000000000000388', 2, 'Crystal of Relocation', 'Teleport and locate players at no cost', 2.5e+008, 5e+006),
('ITEM_00000000000000000000389', 2, 'Orb of Learning', '+20% more experience per fight', 2.5e+008, 5e+006),
('ITEM_00000000000000000000390', 2, 'Chalice of Luck', '+100% drop chance', 5e+008, 5e+006),
('ITEM_00000000000000000000391', 2, 'Golden Orb of Enlightenment', 'Shows all players in a 3x3 area around you. Shows all online players', 5e+008, 5e+006),
('ITEM_00000000000000000000392', 2, 'Eternal Ring', '10% gold lost upon death, instead of 100%', 5e+008, 5e+006),
('ITEM_00000000000000000000393', 2, 'Band of the Chosen', '5% experience lost upon death, instead of 20%', 5e+008, 5e+006),
('ITEM_00000000000000000000394', 2, 'Huggle', 'Just a sign of affection', 1e+007, 5e+006),
('ITEM_00000000001295810077465', 1, 'amethyst*', 'Increases Your Strength 5%', 0, 10000),
('ITEM_00000000001295810077567', 1, 'amethyst**', 'Increases Your Strength 10%', 0, 20000),
('ITEM_00000000001295810077579', 1, 'amethyst***', 'Increases Your Strength 20%', 0, 30000),
('ITEM_00000000001295810077590', 1, 'amethyst****', 'Increases Your Strength 35%', 0, 40000),
('ITEM_00000000001295810077600', 1, 'emerald*', 'Increases Your Dexterity 5%', 0, 10000),
('ITEM_00000000001295810077611', 1, 'emerald**', 'Increases Your Dexterity 10%', 0, 20000),
('ITEM_00000000001295810077622', 1, 'emerald***', 'Increases Your Dexterity 20%', 0, 30000),
('ITEM_00000000001295810077632', 1, 'emerald****', 'Increases Your Dexterity 35%', 0, 40000),
('ITEM_00000000001295810077642', 1, 'ruby*', 'Increases Your Life according to your Vitality 5%', 0, 10000),
('ITEM_00000000001295810077653', 1, 'ruby**', 'Increases Your Life according to your Vitality 10%', 0, 20000),
('ITEM_00000000001295810077663', 1, 'ruby***', 'Increases Your Life according to your Vitality 20%', 0, 30000),
('ITEM_00000000001295810077673', 1, 'ruby****', 'Increases Your Life according to your Vitality 35%', 0, 40000),
('ITEM_00000000001295810077697', 1, 'sapphire*', 'Increases Your Intelligence 5%', 0, 10000),
('ITEM_00000000001295810077707', 1, 'sapphire**', 'Increases Your Intelligence 10%', 0, 20000),
('ITEM_00000000001295810077718', 1, 'sapphire***', 'Increases Your Intelligence 20%', 0, 30000),
('ITEM_00000000001295810077728', 1, 'sapphire****', 'Increases Your Intelligence 35%', 0, 40000),
('ITEM_00000000001295810077738', 1, 'pearl*', 'Increases Your Wisdom 5%', 0, 10000),
('ITEM_00000000001295810077748', 1, 'pearl**', 'Increases Your Wisdom 10%', 0, 20000),
('ITEM_00000000001295810077758', 1, 'pearl***', 'Increases Your Wisdom 20%', 0, 30000),
('ITEM_00000000001295810077768', 1, 'pearl****', 'Increases Your Wisdom 35%', 0, 40000),
('ITEM_00000000001295810077778', 1, 'quartz*', 'Decreases Enemy Strength 5%', 0, 10000),
('ITEM_00000000001295810077797', 1, 'quartz**', 'Decreases Enemy Strength 10%', 0, 20000);
INSERT INTO `item_templates` (`itemTemplateId`, `itemType`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES
('ITEM_00000000001295810077807', 1, 'quartz***', 'Decreases Enemy Strength 20%', 0, 30000),
('ITEM_00000000001295810077817', 1, 'quartz****', 'Decreases Enemy Strength 35%', 0, 40000),
('ITEM_00000000001295810077827', 1, 'opal*', 'Decreases Enemy Dexterity 5%', 0, 10000),
('ITEM_00000000001295810077837', 1, 'opal**', 'Decreases Enemy Dexterity 10%', 0, 20000),
('ITEM_00000000001295810077852', 1, 'opal***', 'Decreases Enemy Dexterity 20%', 0, 30000),
('ITEM_00000000001295810077862', 1, 'opal****', 'Decreases Enemy Dexterity 35%', 0, 40000),
('ITEM_00000000001295810077872', 1, 'tourmaline*', 'Damages Enemy Life  according to the lesser of your current life and current enemy''s Life 15%', 0, 10000),
('ITEM_00000000001295810077882', 1, 'tourmaline**', 'Damages Enemy Life according to the lesser of your current life and current enemy''s Life 20%', 0, 20000),
('ITEM_00000000001295810077892', 1, 'tourmaline***', 'Damages Enemy Life according to the lesser of your current life and current enemy''s Life 30%', 0, 30000),
('ITEM_00000000001295810077902', 1, 'tourmaline****', 'Damages Enemy Life according to the lesser of your current life and current enemy''s Life 45%', 0, 40000),
('ITEM_00000000001295810077912', 1, 'tanzanite*', 'Decreases Enemy Intelligence 5%', 0, 10000),
('ITEM_00000000001295810077922', 1, 'tanzanite**', 'Decreases Enemy Intelligence 10%', 0, 20000),
('ITEM_00000000001295810077932', 1, 'tanzanite***', 'Decreases Enemy Intelligence 20%', 0, 30000),
('ITEM_00000000001295810077942', 1, 'tanzanite****', 'Decreases Enemy Intelligence 35%', 0, 40000),
('ITEM_00000000001295810077965', 1, 'black pearl*', 'Decreases Enemy Wisdom 5%', 0, 10000),
('ITEM_00000000001295810077975', 1, 'black pearl**', 'Decreases Enemy Wisdom 10%', 0, 20000),
('ITEM_00000000001295810077985', 1, 'black pearl***', 'Decreases Enemy Wisdom 20%', 0, 30000),
('ITEM_00000000001295810077996', 1, 'black pearl****', 'Decreases Enemy Wisdom 35%', 0, 40000),
('ITEM_00000000001295810078006', 1, 'topaz*', 'Steals Enemy Strength 4%', 0, 10000),
('ITEM_00000000001295810078016', 1, 'topaz**', 'Steals Enemy Strength 8%', 0, 20000),
('ITEM_00000000001295810078026', 1, 'topaz***', 'Steals Enemy Strength 16%', 0, 30000),
('ITEM_00000000001295810078036', 1, 'topaz****', 'Steals Enemy Strength 32%', 0, 40000),
('ITEM_00000000001295810078046', 1, 'moonstone*', 'Steals Enemy Dexterity 4%', 0, 10000),
('ITEM_00000000001295810078057', 1, 'moonstone**', 'Steals Enemy Dexterity 8%', 0, 20000),
('ITEM_00000000001295810078070', 1, 'moonstone***', 'Steals Enemy Dexterity 16%', 0, 30000),
('ITEM_00000000001295810078081', 1, 'moonstone****', 'Steals Enemy Dexterity 32%', 0, 40000),
('ITEM_00000000001295810078091', 1, 'bloodrock*', 'Steals Enemy Life according to current Life 4%', 0, 10000),
('ITEM_00000000001295810078102', 1, 'bloodrock**', 'Steals Enemy Life according to current Life 8%', 0, 20000),
('ITEM_00000000001295810078112', 1, 'bloodrock***', 'Steals Enemy Life according to current Life 16%', 0, 30000),
('ITEM_00000000001295810078122', 1, 'bloodrock****', 'Steals Enemy Life according to current Life 32%', 0, 40000),
('ITEM_00000000001295810078132', 1, 'malachite*', 'Steals Enemy Intelligence 4%', 0, 10000),
('ITEM_00000000001295810078142', 1, 'malachite**', 'Steals Enemy Intelligence 8%', 0, 20000),
('ITEM_00000000001295810078152', 1, 'malachite***', 'Steals Enemy Intelligence 16%', 0, 30000),
('ITEM_00000000001295810078162', 1, 'malachite****', 'Steals Enemy Intelligence 32%', 0, 40000),
('ITEM_00000000001295810078180', 1, 'corundum*', 'Steals Enemy Wisdom 4%', 0, 10000),
('ITEM_00000000001295810078190', 1, 'corundum**', 'Steals Enemy Wisdom 8%', 0, 20000),
('ITEM_00000000001295810078201', 1, 'corundum***', 'Steals Enemy Wisdom 16%', 0, 30000),
('ITEM_00000000001295810078211', 1, 'corundum****', 'Steals Enemy Wisdom 32%', 0, 40000),
('ITEM_00000000001295810078221', 1, 'dragon fang*', 'Increases the Item Class (IC) of your weapons +1', 0, 10000),
('ITEM_00000000001295810078231', 1, 'dragon fang**', 'Increases the Item Class (IC) of your weapons +2', 0, 20000),
('ITEM_00000000001295810078241', 1, 'dragon fang***', 'Increases the Item Class (IC) of your weapons +4', 0, 30000),
('ITEM_00000000001295810078256', 1, 'dragon fang****', 'Increases the Item Class (IC) of your weapons +6', 0, 40000),
('ITEM_00000000001295810078266', 1, 'demon fang*', 'Increases the Item Class (IC) of your spells +1', 0, 10000),
('ITEM_00000000001295810078276', 1, 'demon fang**', 'Increases the Item Class (IC) of your spells +2', 0, 20000),
('ITEM_00000000001295810078286', 1, 'demon fang***', 'Increases the Item Class (IC) of your spells +4', 0, 30000),
('ITEM_00000000001295810078296', 1, 'demon fang****', 'Increases the Item Class (IC) of your spells +6', 0, 40000),
('ITEM_00000000001295810078306', 1, 'frozen tear*', 'Increases the Item Class (IC) of your armour +1', 0, 10000),
('ITEM_00000000001295810078316', 1, 'frozen tear**', 'Increases the Item Class (IC) of your armour +2', 0, 20000),
('ITEM_00000000001295810078326', 1, 'frozen tear***', 'Increases the Item Class (IC) of your armour +4', 0, 30000),
('ITEM_00000000001295810078336', 1, 'frozen tear****', 'Increases the Item Class (IC) of your armour +6', 0, 40000),
('ITEM_00000000001295810078346', 1, 'diamond*', 'Increases your gold gained per fight 5%', 0, 10000),
('ITEM_00000000001295810078356', 1, 'diamond**', 'Increases your gold gained per fight 10%', 0, 20000),
('ITEM_00000000001295810078366', 1, 'diamond***', 'Increases your gold gained per fight 25%', 0, 30000),
('ITEM_00000000001295810078376', 1, 'diamond****', 'Increases your gold gained per fight 50%', 0, 40000),
('ITEM_00000000001295810078396', 1, 'atmashidade*', 'ncreases your Experience (EXP) gained per fight 2%', 0, 10000),
('ITEM_00000000001295810078407', 1, 'atmashidade**', 'ncreases your Experience (EXP) gained per fight 4%', 0, 20000),
('ITEM_00000000001295810078417', 1, 'atmashidade***', 'ncreases your Experience (EXP) gained per fight 10%', 0, 30000),
('ITEM_00000000001295810078427', 1, 'atmashidade****', 'ncreases your Experience (EXP) gained per fight 20%', 0, 40000),
('ITEM_00000000001295810078437', 1, 'jade*', 'Increases your chance to strike first (initiative) 5%', 0, 10000),
('ITEM_00000000001295810078447', 1, 'jade**', 'Increases your chance to strike first (initiative) 10%', 0, 20000),
('ITEM_00000000001295810078457', 1, 'jade***', 'Increases your chance to strike first (initiative) 25%', 0, 30000),
('ITEM_00000000001295810078467', 1, 'jade****', 'Increases your chance to strike first (initiative) 50%', 0, 40000),
('ITEM_00000000001295810078477', 1, 'onyx*', 'Increases your hit chance 5%', 0, 10000),
('ITEM_00000000001295810078504', 1, 'onyx**', 'Increases your hit chance 10%', 0, 20000),
('ITEM_00000000001295810078514', 1, 'onyx***', 'Increases your hit chance 20%', 0, 30000),
('ITEM_00000000001295810078524', 1, 'onyx****', 'Increases your hit chance 35%', 0, 40000),
('ITEM_00000000001295810078535', 1, 'peridot*', 'Increases your doublehit chance 1%', 0, 10000),
('ITEM_00000000001295810078545', 1, 'peridot**', 'Increases your doublehit chance 2%', 0, 20000),
('ITEM_00000000001295810078555', 1, 'peridot***', 'Increases your doublehit chance 4%', 0, 30000),
('ITEM_00000000001295810078565', 1, 'peridot****', 'Increases your doublehit chance 6%', 0, 40000),
('ITEM_00000000001295810078575', 1, 'aventurine*', 'Increases your base stats 1%', 0, 10000),
('ITEM_00000000001295810078585', 1, 'aventurine**', 'Increases your base stats 2%', 0, 20000),
('ITEM_00000000001295810078595', 1, 'aventurine***', 'Increases your base stats 5%', 0, 30000),
('ITEM_00000000001295810078617', 1, 'aventurine****', 'Increases your base stats 10%', 0, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `item_template_consumables`
--

CREATE TABLE IF NOT EXISTS `item_template_consumables` (
  `itemTemplateId` char(28) NOT NULL,
  `onUse` text,
  PRIMARY KEY (`itemTemplateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_template_consumables`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_template_equippables`
--

CREATE TABLE IF NOT EXISTS `item_template_equippables` (
  `itemTemplateId` char(28) NOT NULL,
  `masteryType` int(10) unsigned NOT NULL,
  `itemClass` int(10) unsigned NOT NULL,
  `slots` int(11) NOT NULL,
  `slotType` int(11) NOT NULL,
  `sockets` int(11) NOT NULL,
  `onEquip` text,
  `onUnequip` text,
  `onAttack` text,
  `onDefend` text,
  PRIMARY KEY (`itemTemplateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_template_equippables`
--

INSERT INTO `item_template_equippables` (`itemTemplateId`, `masteryType`, `itemClass`, `slots`, `slotType`, `sockets`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES
('ITEM_00000000000000000000000', 1, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000001', 1, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000002', 1, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000003', 1, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000004', 1, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000005', 1, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000006', 1, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000007', 1, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000008', 1, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000009', 1, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000010', 1, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000011', 1, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000012', 1, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000013', 1, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000014', 1, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000015', 1, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000016', 1, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000017', 1, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000018', 1, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000019', 1, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000020', 1, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000021', 1, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000022', 1, 22, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000023', 1, 23, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000024', 1, 24, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000025', 1, 25, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000026', 1, 26, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000027', 1, 27, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000028', 1, 28, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000029', 1, 29, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000030', 1, 30, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000031', 1, 31, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000032', 1, 32, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000033', 1, 33, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000034', 1, 34, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000035', 1, 35, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000036', 1, 36, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000037', 2, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000038', 2, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000039', 2, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000040', 2, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000041', 2, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000042', 2, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000043', 2, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000044', 2, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000045', 2, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000046', 2, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000047', 2, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000048', 2, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000049', 2, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000050', 2, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000051', 2, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000052', 2, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000053', 2, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000054', 2, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000055', 2, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000056', 2, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000057', 2, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000058', 2, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000059', 2, 22, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000060', 2, 23, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000061', 2, 24, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000062', 2, 25, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000063', 2, 26, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000064', 2, 27, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000065', 2, 28, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000066', 2, 29, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000067', 2, 30, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000068', 2, 31, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000069', 2, 32, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000070', 2, 33, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000071', 2, 34, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000072', 2, 35, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000073', 2, 36, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000074', 4, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000075', 4, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000076', 4, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000077', 4, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000078', 4, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000079', 4, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000080', 4, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000081', 4, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000082', 4, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000083', 4, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000084', 4, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000085', 4, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000086', 4, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000087', 4, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000088', 4, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000089', 4, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000090', 4, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000091', 4, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000092', 4, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000093', 4, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000094', 4, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000095', 4, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000096', 4, 22, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000097', 4, 23, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000098', 4, 24, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000099', 4, 25, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000100', 4, 26, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000101', 4, 27, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000102', 4, 28, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000103', 4, 29, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000104', 4, 30, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000105', 4, 31, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000106', 4, 32, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000107', 4, 33, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000108', 4, 34, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000109', 4, 35, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000110', 4, 36, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000111', 3, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000112', 3, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000113', 3, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000114', 3, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000115', 3, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000116', 3, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000117', 3, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000118', 3, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000119', 3, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000120', 3, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000121', 3, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000122', 3, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000123', 3, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000124', 3, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000125', 3, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000126', 3, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000127', 3, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000128', 3, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000129', 3, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000130', 3, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000131', 3, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000132', 3, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000133', 3, 22, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000134', 3, 23, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000135', 3, 24, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000136', 3, 25, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000137', 3, 26, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000138', 3, 27, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000139', 3, 28, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000140', 3, 29, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000141', 3, 30, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000142', 3, 31, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000143', 3, 32, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000144', 3, 33, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000145', 3, 34, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000146', 3, 35, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000147', 3, 36, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000148', 6, 0, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000149', 6, 1, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000150', 6, 2, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000151', 6, 3, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000152', 6, 4, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000153', 6, 5, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000154', 6, 6, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000155', 6, 7, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000156', 6, 8, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000157', 6, 9, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000158', 6, 10, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000159', 6, 11, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000160', 6, 12, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000161', 6, 13, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000162', 6, 14, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000163', 6, 15, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000164', 6, 16, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000165', 6, 17, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000166', 6, 18, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000167', 6, 19, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000168', 6, 20, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000169', 6, 21, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000170', 6, 22, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000171', 6, 23, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000172', 6, 24, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000173', 6, 25, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000174', 6, 26, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000175', 6, 27, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000176', 6, 28, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000177', 6, 29, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000178', 6, 30, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000179', 6, 31, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000180', 6, 32, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000181', 6, 33, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000182', 6, 34, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000183', 6, 35, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000184', 6, 36, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000185', 8, 0, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000186', 8, 1, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000187', 8, 2, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000188', 8, 3, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000189', 8, 4, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000190', 8, 5, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000191', 8, 6, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000192', 8, 7, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000193', 8, 8, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000194', 8, 9, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000195', 8, 10, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000196', 8, 11, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000197', 8, 12, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000198', 8, 13, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000199', 8, 14, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000200', 8, 15, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000201', 8, 16, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000202', 8, 17, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000203', 8, 18, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000204', 8, 19, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000205', 8, 20, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000206', 8, 21, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000207', 8, 22, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000208', 8, 23, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000209', 8, 24, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000210', 8, 25, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000211', 8, 26, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000212', 8, 27, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000213', 8, 28, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000214', 8, 29, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000215', 8, 30, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000216', 8, 31, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000217', 8, 32, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000218', 8, 33, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000219', 8, 34, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000220', 8, 35, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000221', 8, 36, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000222', 7, 0, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000223', 7, 1, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000224', 7, 2, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000225', 7, 3, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000226', 7, 4, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000227', 7, 5, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000228', 7, 6, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000229', 7, 7, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000230', 7, 8, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000231', 7, 9, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000232', 7, 10, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000233', 7, 11, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000234', 7, 12, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000235', 7, 13, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000236', 7, 14, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000237', 7, 15, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000238', 7, 16, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000239', 7, 17, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000240', 7, 18, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000241', 7, 19, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000242', 7, 20, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000243', 7, 21, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000244', 7, 22, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000245', 7, 23, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000246', 7, 24, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000247', 7, 25, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000248', 7, 26, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000249', 7, 27, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000250', 7, 28, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000251', 7, 29, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000252', 7, 30, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000253', 7, 31, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000254', 7, 32, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000255', 7, 33, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000256', 7, 34, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000257', 7, 35, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000258', 7, 36, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000259', 11, 0, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000260', 11, 1, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000261', 11, 2, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000262', 11, 3, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000263', 11, 4, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000264', 11, 5, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000265', 11, 6, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000266', 11, 7, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000267', 11, 8, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000268', 11, 9, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000269', 11, 10, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000270', 11, 11, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000271', 11, 12, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000272', 11, 13, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000273', 11, 14, 1, 3, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000274', 11, 15, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000275', 11, 16, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000276', 11, 17, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000277', 11, 18, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000278', 11, 19, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000279', 11, 20, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000280', 11, 21, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000281', 11, 22, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000282', 11, 23, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000283', 11, 24, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000284', 11, 25, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000285', 11, 26, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000286', 11, 27, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000287', 11, 28, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000288', 11, 29, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000289', 11, 30, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000290', 11, 31, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000291', 11, 32, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000292', 11, 33, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000293', 11, 34, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000294', 11, 35, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000295', 11, 36, 1, 3, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000296', 0, 0, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000297', 0, 1, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000298', 0, 2, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000299', 0, 3, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000300', 0, 4, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000301', 0, 5, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000302', 0, 6, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000303', 0, 7, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000304', 0, 8, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000305', 0, 9, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000306', 0, 10, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000307', 0, 11, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000308', 0, 12, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000309', 0, 13, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000310', 0, 14, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000311', 0, 15, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000312', 0, 16, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000313', 0, 17, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000314', 0, 18, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000315', 0, 19, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000316', 0, 20, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000317', 0, 21, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000318', 0, 22, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000319', 0, 23, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000320', 0, 24, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000321', 0, 25, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000322', 0, 26, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000323', 0, 27, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000324', 0, 28, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000325', 0, 29, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000326', 0, 30, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000327', 0, 31, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000328', 0, 32, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000329', 0, 33, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000330', 0, 34, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000331', 0, 35, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000332', 0, 36, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000333', 0, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000334', 0, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000335', 0, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000336', 0, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000337', 0, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000338', 0, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000339', 0, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000340', 0, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000341', 0, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000342', 0, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000343', 0, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000344', 0, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000345', 0, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000346', 0, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000347', 0, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000348', 0, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000349', 0, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000350', 0, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000351', 0, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000352', 0, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000353', 0, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000354', 0, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000355', 0, 22, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000356', 0, 23, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000357', 0, 24, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000358', 0, 25, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000359', 0, 26, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000360', 0, 27, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000361', 0, 28, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000362', 0, 29, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000363', 0, 30, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000364', 0, 31, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000365', 0, 32, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000366', 0, 33, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000367', 0, 34, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000368', 0, 35, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000369', 0, 36, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000370', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000371', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000372', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000373', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000374', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000375', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000376', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000377', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000378', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000379', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000380', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000381', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000382', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000383', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000384', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000385', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000386', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000387', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000388', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000389', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000390', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000391', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000392', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000393', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000394', 999, 0, 1, 2, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_template_socketables`
--

CREATE TABLE IF NOT EXISTS `item_template_socketables` (
  `itemTemplateId` char(28) NOT NULL,
  `onSocket` text,
  PRIMARY KEY (`itemTemplateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_template_socketables`
--

INSERT INTO `item_template_socketables` (`itemTemplateId`, `onSocket`) VALUES
('ITEM_00000000001295810077465', NULL),
('ITEM_00000000001295810077567', NULL),
('ITEM_00000000001295810077579', NULL),
('ITEM_00000000001295810077590', NULL),
('ITEM_00000000001295810077600', NULL),
('ITEM_00000000001295810077611', NULL),
('ITEM_00000000001295810077622', NULL),
('ITEM_00000000001295810077632', NULL),
('ITEM_00000000001295810077642', NULL),
('ITEM_00000000001295810077653', NULL),
('ITEM_00000000001295810077663', NULL),
('ITEM_00000000001295810077673', NULL),
('ITEM_00000000001295810077697', NULL),
('ITEM_00000000001295810077707', NULL),
('ITEM_00000000001295810077718', NULL),
('ITEM_00000000001295810077728', NULL),
('ITEM_00000000001295810077738', NULL),
('ITEM_00000000001295810077748', NULL),
('ITEM_00000000001295810077758', NULL),
('ITEM_00000000001295810077768', NULL),
('ITEM_00000000001295810077778', NULL),
('ITEM_00000000001295810077797', NULL),
('ITEM_00000000001295810077807', NULL),
('ITEM_00000000001295810077817', NULL),
('ITEM_00000000001295810077827', NULL),
('ITEM_00000000001295810077837', NULL),
('ITEM_00000000001295810077852', NULL),
('ITEM_00000000001295810077862', NULL),
('ITEM_00000000001295810077872', NULL),
('ITEM_00000000001295810077882', NULL),
('ITEM_00000000001295810077892', NULL),
('ITEM_00000000001295810077902', NULL),
('ITEM_00000000001295810077912', NULL),
('ITEM_00000000001295810077922', NULL),
('ITEM_00000000001295810077932', NULL),
('ITEM_00000000001295810077942', NULL),
('ITEM_00000000001295810077965', NULL),
('ITEM_00000000001295810077975', NULL),
('ITEM_00000000001295810077985', NULL),
('ITEM_00000000001295810077996', NULL),
('ITEM_00000000001295810078006', NULL),
('ITEM_00000000001295810078016', NULL),
('ITEM_00000000001295810078026', NULL),
('ITEM_00000000001295810078036', NULL),
('ITEM_00000000001295810078046', NULL),
('ITEM_00000000001295810078057', NULL),
('ITEM_00000000001295810078070', NULL),
('ITEM_00000000001295810078081', NULL),
('ITEM_00000000001295810078091', NULL),
('ITEM_00000000001295810078102', NULL),
('ITEM_00000000001295810078112', NULL),
('ITEM_00000000001295810078122', NULL),
('ITEM_00000000001295810078132', NULL),
('ITEM_00000000001295810078142', NULL),
('ITEM_00000000001295810078152', NULL),
('ITEM_00000000001295810078162', NULL),
('ITEM_00000000001295810078180', NULL),
('ITEM_00000000001295810078190', NULL),
('ITEM_00000000001295810078201', NULL),
('ITEM_00000000001295810078211', NULL),
('ITEM_00000000001295810078221', NULL),
('ITEM_00000000001295810078231', NULL),
('ITEM_00000000001295810078241', NULL),
('ITEM_00000000001295810078256', NULL),
('ITEM_00000000001295810078266', NULL),
('ITEM_00000000001295810078276', NULL),
('ITEM_00000000001295810078286', NULL),
('ITEM_00000000001295810078296', NULL),
('ITEM_00000000001295810078306', NULL),
('ITEM_00000000001295810078316', NULL),
('ITEM_00000000001295810078326', NULL),
('ITEM_00000000001295810078336', NULL),
('ITEM_00000000001295810078346', NULL),
('ITEM_00000000001295810078356', NULL),
('ITEM_00000000001295810078366', NULL),
('ITEM_00000000001295810078376', NULL),
('ITEM_00000000001295810078396', NULL),
('ITEM_00000000001295810078407', NULL),
('ITEM_00000000001295810078417', NULL),
('ITEM_00000000001295810078427', NULL),
('ITEM_00000000001295810078437', NULL),
('ITEM_00000000001295810078447', NULL),
('ITEM_00000000001295810078457', NULL),
('ITEM_00000000001295810078467', NULL),
('ITEM_00000000001295810078477', NULL),
('ITEM_00000000001295810078504', NULL),
('ITEM_00000000001295810078514', NULL),
('ITEM_00000000001295810078524', NULL),
('ITEM_00000000001295810078535', NULL),
('ITEM_00000000001295810078545', NULL),
('ITEM_00000000001295810078555', NULL),
('ITEM_00000000001295810078565', NULL),
('ITEM_00000000001295810078575', NULL),
('ITEM_00000000001295810078585', NULL),
('ITEM_00000000001295810078595', NULL),
('ITEM_00000000001295810078617', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `mapId` char(28) NOT NULL,
  `pvp` bit(1) NOT NULL,
  `name` varchar(150) NOT NULL,
  `dimensionX` int(10) unsigned NOT NULL,
  `dimensionY` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`mapId`, `pvp`, `name`, `dimensionX`, `dimensionY`) VALUES
('MAP_00000000000000000000001', '0', 'Test City', 5, 5),
('MAP_00000000000000000000002', '0', 'Wilderness', 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `map_monsters`
--

CREATE TABLE IF NOT EXISTS `map_monsters` (
  `mapId` char(28) NOT NULL,
  `monsterId` char(28) NOT NULL,
  `positionX` int(10) unsigned NOT NULL,
  `positionY` int(10) unsigned NOT NULL,
  KEY `monsterId` (`monsterId`),
  KEY `mapId` (`mapId`),
  KEY `positionX` (`positionX`,`positionY`,`mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_monsters`
--

INSERT INTO `map_monsters` (`mapId`, `monsterId`, `positionX`, `positionY`) VALUES
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000001', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000002', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000003', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000004', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000005', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000006', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000007', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000008', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000009', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000010', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000011', 4, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 0, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 0, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 0, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 0, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 0, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 1, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 1, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 1, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 1, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 1, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 2, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 2, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 2, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 2, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 2, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 3, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 3, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 3, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 3, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 3, 4),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 4, 0),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 4, 1),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 4, 2),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 4, 3),
('MAP_00000000000000000000001', 'MONS_00000000000000000000012', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `map_places`
--

CREATE TABLE IF NOT EXISTS `map_places` (
  `mapId` char(28) NOT NULL,
  `placeId` char(28) DEFAULT NULL,
  `positionX` int(10) unsigned NOT NULL,
  `positionY` int(10) unsigned NOT NULL,
  `isBlocked` bit(1) NOT NULL,
  `isPvp` bit(1) NOT NULL,
  `newMapId` char(28) DEFAULT NULL,
  `newPositionX` int(10) unsigned DEFAULT NULL,
  `newPositionY` int(10) unsigned DEFAULT NULL,
  KEY `mapId` (`mapId`),
  KEY `placeId` (`placeId`),
  KEY `Position` (`positionX`,`positionY`,`mapId`),
  KEY `newMapId` (`newMapId`,`newPositionX`,`newPositionY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_places`
--

INSERT INTO `map_places` (`mapId`, `placeId`, `positionX`, `positionY`, `isBlocked`, `isPvp`, `newMapId`, `newPositionX`, `newPositionY`) VALUES
('MAP_00000000000000000000001', 'PLAC_00000000000000000000001', 0, 1, '0', '0', '', NULL, NULL),
('MAP_00000000000000000000001', 'PLAC_00000000000000000000002', 4, 2, '0', '0', '', NULL, NULL),
('MAP_00000000000000000000001', 'PLAC_00000000000000000000003', 0, 3, '0', '0', '', NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 0, '0', '0', 'MAP_00000000000000000000002', 8, 2),
('MAP_00000000000000000000001', NULL, 4, 4, '1', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 4, '1', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 3, '1', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 2, '1', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 2, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 4, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 0, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 1, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 2, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 3, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 4, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 0, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 1, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 3, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 4, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 0, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 1, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 2, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 3, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 1, '0', '0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 0, '0', '0', NULL, NULL, NULL);

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
('PLAC_00000000000000000000003', 'Bank'),
('PLAC_00000000000000000000002', 'Shrine'),
('PLAC_00000000000000000000001', 'Store');

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

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE IF NOT EXISTS `monsters` (
  `monsterId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `experienceBonus` float unsigned NOT NULL DEFAULT '1',
  `goldBonus` float unsigned NOT NULL DEFAULT '1',
  `dropBonus` float NOT NULL DEFAULT '1',
  `masteryBonus` float NOT NULL DEFAULT '1',
  `weaponClass` int(10) unsigned NOT NULL,
  `spellClass` int(10) unsigned NOT NULL,
  `armorClass` int(10) unsigned NOT NULL,
  `alignGood` int(11) NOT NULL DEFAULT '0',
  `alignOrder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`monsterId`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`monsterId`, `name`, `level`, `experienceBonus`, `goldBonus`, `dropBonus`, `masteryBonus`, `weaponClass`, `spellClass`, `armorClass`, `alignGood`, `alignOrder`) VALUES
('MONS_00000000000000000000001', 'Drunk Beggar', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
('MONS_00000000000000000000002', 'Street Urchin', 2, 1, 1, 1, 1, 1, 1, 1, 0, 0),
('MONS_00000000000000000000003', 'Sly Peddler', 3, 1, 1, 1, 1, 2, 2, 2, 0, 0),
('MONS_00000000000000000000004', 'Stray Dog', 4, 1, 1, 1, 1, 3, 3, 3, 0, 0),
('MONS_00000000000000000000005', 'Cultist Initiate', 5, 1, 1, 1, 1, 4, 4, 4, 0, 0),
('MONS_00000000000000000000006', '', 6, 1, 1, 1, 1, 5, 5, 5, 0, 0),
('MONS_00000000000000000000007', '', 7, 1, 1, 1, 1, 6, 6, 6, 0, 0),
('MONS_00000000000000000000008', '', 8, 1, 1, 1, 1, 7, 7, 7, 0, 0),
('MONS_00000000000000000000009', '', 9, 1, 1, 1, 1, 8, 8, 8, 0, 0),
('MONS_00000000000000000000010', '', 10, 1, 1, 1, 1, 9, 9, 9, 0, 0),
('MONS_00000000000000000000011', '', 11, 1, 1, 1, 1, 10, 10, 10, 0, 0),
('MONS_00000000000000000000012', '', 12, 1, 1, 1, 1, 11, 11, 11, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `monster_types`
--

CREATE TABLE IF NOT EXISTS `monster_types` (
  `monsterTypeId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`monsterTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monster_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE IF NOT EXISTS `proposals` (
  `characterId1` char(28) NOT NULL,
  `characterId2` char(28) NOT NULL,
  `proposedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acceptedOn` timestamp NULL DEFAULT NULL,
  KEY `characterId1` (`characterId1`),
  KEY `characterId2` (`characterId2`),
  KEY `proposedOn` (`proposedOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proposals`
--


-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE IF NOT EXISTS `quests` (
  `questId` char(28) NOT NULL,
  `monsterId` char(28) NOT NULL,
  `monstertypeid` char(28) NOT NULL,
  `mapid` char(28) NOT NULL,
  `experience` bigint(20) unsigned NOT NULL,
  `gold` bigint(20) unsigned NOT NULL,
  `randomGemGrade` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`questId`),
  KEY `monsterId` (`monsterId`),
  KEY `monstertypeid` (`monstertypeid`),
  KEY `mapid` (`mapid`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quests`
--


-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `raceId` char(28) NOT NULL,
  `name` varchar(50) NOT NULL,
  `homeMapId` char(28) NOT NULL,
  `homePositionX` int(11) unsigned NOT NULL,
  `homePositionY` int(11) unsigned NOT NULL,
  `levelRequirement` int(11) unsigned NOT NULL DEFAULT '0',
  `alignMin` int(11) NOT NULL DEFAULT '0',
  `alignMax` int(11) NOT NULL,
  `strength` int(10) unsigned NOT NULL DEFAULT '0',
  `dexterity` int(10) unsigned NOT NULL DEFAULT '0',
  `intelligence` int(10) unsigned NOT NULL DEFAULT '0',
  `wisdom` int(10) unsigned NOT NULL DEFAULT '0',
  `vitality` int(10) unsigned NOT NULL DEFAULT '0',
  `strengthMax` int(10) unsigned NOT NULL DEFAULT '0',
  `dexterityMax` int(10) unsigned NOT NULL DEFAULT '0',
  `intelligenceMax` int(10) unsigned NOT NULL DEFAULT '0',
  `wisdomMax` int(10) unsigned NOT NULL DEFAULT '0',
  `vitalityMax` int(10) unsigned NOT NULL DEFAULT '0',
  `weaponSlots` int(10) unsigned NOT NULL,
  `armorSlots` int(10) unsigned NOT NULL,
  `accessorySlots` int(10) unsigned NOT NULL,
  `spellSlots` int(10) unsigned NOT NULL,
  `alignGood` int(11) NOT NULL,
  `alignOrder` int(11) NOT NULL,
  PRIMARY KEY (`raceId`),
  UNIQUE KEY `name` (`name`),
  KEY `homeMapId` (`homeMapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`raceId`, `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `weaponSlots`, `armorSlots`, `accessorySlots`, `spellSlots`, `alignGood`, `alignOrder`) VALUES
('RACE_00000000000000000000001', 'Aviakan', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 22, 24, 30, 28, 21, 42, 44, 50, 48, 41, 2, 1, 1, 2, 10, -10),
('RACE_00000000000000000000002', 'Drow', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 33, 20, 25, 17, 50, 53, 40, 45, 37, 2, 1, 1, 2, -10, 5),
('RACE_00000000000000000000003', 'Dwarf', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 25, 20, 19, 28, 53, 45, 40, 39, 48, 2, 1, 1, 2, 10, 10),
('RACE_00000000000000000000004', 'Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 25, 30, 23, 17, 50, 45, 50, 40, 37, 2, 1, 1, 2, 10, 5),
('RACE_00000000000000000000005', 'Gargoyle', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 18, 27, 27, 20, 53, 33, 42, 57, 40, 2, 1, 1, 2, -10, 5),
('RACE_00000000000000000000006', 'Half Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 24, 24, 25, 22, 50, 44, 40, 45, 37, 2, 1, 1, 2, 10, -5),
('RACE_00000000000000000000007', 'Human', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 22, 37, 33, 13, 20, 42, 57, 53, 33, 40, 2, 1, 1, 2, 10, 0),
('RACE_00000000000000000000008', 'Orc', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 28, 22, 24, 21, 50, 48, 42, 44, 41, 2, 1, 1, 2, -10, 0),
('RACE_00000000000000000000009', 'Troll', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 30, 28, 20, 22, 25, 50, 48, 40, 44, 45, 2, 1, 1, 2, -10, -5),
('RACE_00000000000000000000010', 'Goblin', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 20, 19, 33, 25, 28, 40, 39, 53, 45, 48, 2, 1, 1, 2, -10, -10);

-- --------------------------------------------------------

--
-- Table structure for table `race_abilities`
--

CREATE TABLE IF NOT EXISTS `race_abilities` (
  `abilityId` char(28) NOT NULL,
  `raceId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`abilityId`),
  KEY `raceId` (`raceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `race_abilities`
--


-- --------------------------------------------------------

--
-- Table structure for table `race_default_items`
--

CREATE TABLE IF NOT EXISTS `race_default_items` (
  `raceId` char(28) NOT NULL,
  `itemTemplateId` char(28) NOT NULL,
  KEY `raceId` (`raceId`),
  KEY `itemTemplateId` (`itemTemplateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `race_default_items`
--

INSERT INTO `race_default_items` (`raceId`, `itemTemplateId`) VALUES
('RACE_00000000000000000000001', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000001', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000002', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000002', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000003', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000003', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000004', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000004', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000005', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000005', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000006', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000006', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000009', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000009', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000010', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000010', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000007', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000007', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000008', 'ITEM_00000000000000000000000'),
('RACE_00000000000000000000008', 'ITEM_00000000000000000000296'),
('RACE_00000000000000000000001', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000002', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000003', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000004', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000005', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000006', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000007', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000008', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000009', 'ITEM_00000000000000000000148'),
('RACE_00000000000000000000010', 'ITEM_00000000000000000000148');

-- --------------------------------------------------------

--
-- Table structure for table `race_default_masteries`
--

CREATE TABLE IF NOT EXISTS `race_default_masteries` (
  `raceId` char(28) NOT NULL,
  `masteryId` tinyint(1) unsigned NOT NULL,
  `value` float NOT NULL,
  `minValue` float NOT NULL,
  `maxValue` float NOT NULL,
  KEY `raceId` (`raceId`),
  KEY `masteryId` (`masteryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `race_default_masteries`
--

INSERT INTO `race_default_masteries` (`raceId`, `masteryId`, `value`, `minValue`, `maxValue`) VALUES
('RACE_00000000000000000000001', 0, 20, 0, 100),
('RACE_00000000000000000000001', 1, 20, 0, 100),
('RACE_00000000000000000000001', 2, 20, 0, 100),
('RACE_00000000000000000000001', 3, 20, 0, 100),
('RACE_00000000000000000000001', 4, 20, 0, 100),
('RACE_00000000000000000000001', 5, 20, 0, 100),
('RACE_00000000000000000000001', 6, 20, 0, 100),
('RACE_00000000000000000000001', 7, 20, 0, 100),
('RACE_00000000000000000000001', 8, 20, 0, 100),
('RACE_00000000000000000000001', 9, 20, 0, 100),
('RACE_00000000000000000000001', 10, 20, 0, 100),
('RACE_00000000000000000000001', 11, 20, 0, 100),
('RACE_00000000000000000000002', 0, 20, 0, 100),
('RACE_00000000000000000000002', 1, 20, 0, 100),
('RACE_00000000000000000000002', 2, 20, 0, 100),
('RACE_00000000000000000000002', 3, 20, 0, 100),
('RACE_00000000000000000000002', 4, 20, 0, 100),
('RACE_00000000000000000000002', 5, 20, 0, 100),
('RACE_00000000000000000000002', 6, 20, 0, 100),
('RACE_00000000000000000000002', 7, 20, 0, 100),
('RACE_00000000000000000000002', 8, 20, 0, 100),
('RACE_00000000000000000000002', 9, 20, 0, 100),
('RACE_00000000000000000000002', 10, 20, 0, 100),
('RACE_00000000000000000000002', 11, 20, 0, 100),
('RACE_00000000000000000000003', 0, 20, 0, 100),
('RACE_00000000000000000000003', 1, 20, 0, 100),
('RACE_00000000000000000000003', 2, 20, 0, 100),
('RACE_00000000000000000000003', 3, 20, 0, 100),
('RACE_00000000000000000000003', 4, 20, 0, 100),
('RACE_00000000000000000000003', 5, 20, 0, 100),
('RACE_00000000000000000000003', 6, 20, 0, 100),
('RACE_00000000000000000000003', 7, 20, 0, 100),
('RACE_00000000000000000000003', 8, 20, 0, 100),
('RACE_00000000000000000000003', 9, 20, 0, 100),
('RACE_00000000000000000000003', 10, 20, 0, 100),
('RACE_00000000000000000000003', 11, 20, 0, 100),
('RACE_00000000000000000000004', 0, 20, 0, 100),
('RACE_00000000000000000000004', 1, 20, 0, 100),
('RACE_00000000000000000000004', 2, 20, 0, 100),
('RACE_00000000000000000000004', 3, 20, 0, 100),
('RACE_00000000000000000000004', 4, 20, 0, 100),
('RACE_00000000000000000000004', 5, 20, 0, 100),
('RACE_00000000000000000000004', 6, 20, 0, 100),
('RACE_00000000000000000000004', 7, 20, 0, 100),
('RACE_00000000000000000000004', 8, 20, 0, 100),
('RACE_00000000000000000000004', 9, 20, 0, 100),
('RACE_00000000000000000000004', 10, 20, 0, 100),
('RACE_00000000000000000000004', 11, 20, 0, 100),
('RACE_00000000000000000000005', 0, 20, 0, 100),
('RACE_00000000000000000000005', 1, 20, 0, 100),
('RACE_00000000000000000000005', 2, 20, 0, 100),
('RACE_00000000000000000000005', 3, 20, 0, 100),
('RACE_00000000000000000000005', 4, 20, 0, 100),
('RACE_00000000000000000000005', 5, 20, 0, 100),
('RACE_00000000000000000000005', 6, 20, 0, 100),
('RACE_00000000000000000000005', 7, 20, 0, 100),
('RACE_00000000000000000000005', 8, 20, 0, 100),
('RACE_00000000000000000000005', 9, 20, 0, 100),
('RACE_00000000000000000000005', 10, 20, 0, 100),
('RACE_00000000000000000000005', 11, 20, 0, 100),
('RACE_00000000000000000000006', 0, 20, 0, 100),
('RACE_00000000000000000000006', 1, 20, 0, 100),
('RACE_00000000000000000000006', 2, 20, 0, 100),
('RACE_00000000000000000000006', 3, 20, 0, 100),
('RACE_00000000000000000000006', 4, 20, 0, 100),
('RACE_00000000000000000000006', 5, 20, 0, 100),
('RACE_00000000000000000000006', 6, 20, 0, 100),
('RACE_00000000000000000000006', 7, 20, 0, 100),
('RACE_00000000000000000000006', 8, 20, 0, 100),
('RACE_00000000000000000000006', 9, 20, 0, 100),
('RACE_00000000000000000000006', 10, 20, 0, 100),
('RACE_00000000000000000000006', 11, 20, 0, 100),
('RACE_00000000000000000000007', 0, 20, 0, 100),
('RACE_00000000000000000000007', 1, 20, 0, 100),
('RACE_00000000000000000000007', 2, 20, 0, 100),
('RACE_00000000000000000000007', 3, 20, 0, 100),
('RACE_00000000000000000000007', 4, 20, 0, 100),
('RACE_00000000000000000000007', 5, 20, 0, 100),
('RACE_00000000000000000000007', 6, 20, 0, 100),
('RACE_00000000000000000000007', 7, 20, 0, 100),
('RACE_00000000000000000000007', 8, 20, 0, 100),
('RACE_00000000000000000000007', 9, 20, 0, 100),
('RACE_00000000000000000000007', 10, 20, 0, 100),
('RACE_00000000000000000000007', 11, 20, 0, 100),
('RACE_00000000000000000000008', 0, 20, 0, 100),
('RACE_00000000000000000000008', 1, 20, 0, 100),
('RACE_00000000000000000000008', 2, 20, 0, 100),
('RACE_00000000000000000000008', 3, 20, 0, 100),
('RACE_00000000000000000000008', 4, 20, 0, 100),
('RACE_00000000000000000000008', 5, 20, 0, 100),
('RACE_00000000000000000000008', 6, 20, 0, 100),
('RACE_00000000000000000000008', 7, 20, 0, 100),
('RACE_00000000000000000000008', 8, 20, 0, 100),
('RACE_00000000000000000000008', 9, 20, 0, 100),
('RACE_00000000000000000000008', 10, 20, 0, 100),
('RACE_00000000000000000000008', 11, 20, 0, 100),
('RACE_00000000000000000000009', 0, 20, 0, 100),
('RACE_00000000000000000000009', 1, 20, 0, 100),
('RACE_00000000000000000000009', 2, 20, 0, 100),
('RACE_00000000000000000000009', 3, 20, 0, 100),
('RACE_00000000000000000000009', 4, 20, 0, 100),
('RACE_00000000000000000000009', 5, 20, 0, 100),
('RACE_00000000000000000000009', 6, 20, 0, 100),
('RACE_00000000000000000000009', 7, 20, 0, 100),
('RACE_00000000000000000000009', 8, 20, 0, 100),
('RACE_00000000000000000000009', 9, 20, 0, 100),
('RACE_00000000000000000000009', 10, 20, 0, 100),
('RACE_00000000000000000000009', 11, 20, 0, 100),
('RACE_00000000000000000000010', 0, 20, 0, 100),
('RACE_00000000000000000000010', 1, 20, 0, 100),
('RACE_00000000000000000000010', 2, 20, 0, 100),
('RACE_00000000000000000000010', 3, 20, 0, 100),
('RACE_00000000000000000000010', 4, 20, 0, 100),
('RACE_00000000000000000000010', 5, 20, 0, 100),
('RACE_00000000000000000000010', 6, 20, 0, 100),
('RACE_00000000000000000000010', 7, 20, 0, 100),
('RACE_00000000000000000000010', 8, 20, 0, 100),
('RACE_00000000000000000000010', 9, 20, 0, 100),
('RACE_00000000000000000000010', 10, 20, 0, 100),
('RACE_00000000000000000000010', 11, 20, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sessionId` char(30) CHARACTER SET latin1 NOT NULL,
  `accountId` char(28) DEFAULT NULL,
  `characterId` char(28) DEFAULT NULL,
  `data` text CHARACTER SET latin1 NOT NULL,
  `lastUsedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sessionId`),
  UNIQUE KEY `accountId` (`accountId`),
  UNIQUE KEY `characterId` (`characterId`),
  KEY `lastUsedOn` (`lastUsedOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sessionId`, `accountId`, `characterId`, `data`, `lastUsedOn`) VALUES
('eaam8log76l92cno4ona0h1u52', NULL, NULL, '', '2011-02-01 16:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `tradeId` char(28) NOT NULL,
  `inventoryIdTo` char(28) NOT NULL,
  `inventoryIdFrom` char(28) NOT NULL,
  `ItemId` char(28) NOT NULL,
  `Cost` bigint(20) unsigned NOT NULL,
  `TradedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tradeId`),
  UNIQUE KEY `ItemId` (`ItemId`),
  KEY `inventoryIdTo` (`inventoryIdTo`),
  KEY `inventoryIdFrom` (`inventoryIdFrom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trades`
--


-- --------------------------------------------------------

--
-- Table structure for table `trade_items`
--

CREATE TABLE IF NOT EXISTS `trade_items` (
  `tradeId` char(28) NOT NULL,
  `itemId` char(28) NOT NULL,
  `sendRecv` tinyint(1) NOT NULL,
  KEY `tradeId` (`tradeId`),
  KEY `itemId` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trade_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `traits`
--

CREATE TABLE IF NOT EXISTS `traits` (
  `traitId` char(28) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`traitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `traits`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `buddy_requests`
--
ALTER TABLE `buddy_requests`
  ADD CONSTRAINT `buddies_requests_ibfk_1` FOREIGN KEY (`characterIdFrom`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buddies_requests_ibfk_2` FOREIGN KEY (`characterIdTo`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `channel_permissions`
--
ALTER TABLE `channel_permissions`
  ADD CONSTRAINT `channel_permissions_ibfk_1` FOREIGN KEY (`channelId`) REFERENCES `channels` (`channelId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `channel_permissions_ibfk_2` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `accounts` (`accountId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`clanId`) REFERENCES `clans` (`clanId`) ON UPDATE CASCADE;

--
-- Constraints for table `character_achievements`
--
ALTER TABLE `character_achievements`
  ADD CONSTRAINT `character_achievements_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_achievements_ibfk_2` FOREIGN KEY (`achievementId`) REFERENCES `achievement_types` (`achievementId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `character_equipment`
--
ALTER TABLE `character_equipment`
  ADD CONSTRAINT `character_equipment_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_equipment_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `character_locations`
--
ALTER TABLE `character_locations`
  ADD CONSTRAINT `character_locations_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_locations_ibfk_2` FOREIGN KEY (`mapId`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `character_masteries`
--
ALTER TABLE `character_masteries`
  ADD CONSTRAINT `characters_masteries_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_masteries_ibfk_1` FOREIGN KEY (`masteryId`) REFERENCES `mastery_types` (`masteryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `character_race_traits`
--
ALTER TABLE `character_race_traits`
  ADD CONSTRAINT `character_race_traits_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `character_race_traits_ibfk_2` FOREIGN KEY (`racialAbility`) REFERENCES `race_abilities` (`abilityId`);

--
-- Constraints for table `character_statistics`
--
ALTER TABLE `character_statistics`
  ADD CONSTRAINT `characters_statistics_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `character_traits`
--
ALTER TABLE `character_traits`
  ADD CONSTRAINT `characters_traits_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `characters_traits_ibfk_2` FOREIGN KEY (`raceId`) REFERENCES `races` (`raceId`) ON UPDATE CASCADE;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`characterIdFrom`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_4` FOREIGN KEY (`characterIdTo`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_5` FOREIGN KEY (`channelId`) REFERENCES `channels` (`channelId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clan_channel_assoc`
--
ALTER TABLE `clan_channel_assoc`
  ADD CONSTRAINT `clan_channel_assoc_ibfk_1` FOREIGN KEY (`channelId`) REFERENCES `channels` (`channelId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clan_channel_assoc_ibfk_2` FOREIGN KEY (`clanId`) REFERENCES `clans` (`clanId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clan_character_assoc`
--
ALTER TABLE `clan_character_assoc`
  ADD CONSTRAINT `clans_characters_ibfk_1` FOREIGN KEY (`clanId`) REFERENCES `clans` (`clanId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clans_characters_ibfk_2` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `command_permissions`
--
ALTER TABLE `command_permissions`
  ADD CONSTRAINT `command_permissions_ibfk_1` FOREIGN KEY (`commandId`) REFERENCES `commands` (`commandId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `command_permissions_ibfk_2` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `command_permissions_ibfk_3` FOREIGN KEY (`channelId`) REFERENCES `channels` (`channelId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_ibfk_1` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventories_ibfk_2` FOREIGN KEY (`clanId`) REFERENCES `clans` (`clanId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`inventoryId`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`itemTemplateId`) REFERENCES `item_templates` (`itemTemplateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_consumables`
--
ALTER TABLE `item_consumables`
  ADD CONSTRAINT `item_consumables_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_equippables`
--
ALTER TABLE `item_equippables`
  ADD CONSTRAINT `item_equippables_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_socketables`
--
ALTER TABLE `item_socketables`
  ADD CONSTRAINT `item_socketables_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_socketables_ibfk_2` FOREIGN KEY (`socketedIn`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_template_consumables`
--
ALTER TABLE `item_template_consumables`
  ADD CONSTRAINT `item_template_consumables_ibfk_1` FOREIGN KEY (`itemTemplateId`) REFERENCES `item_templates` (`itemTemplateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_template_equippables`
--
ALTER TABLE `item_template_equippables`
  ADD CONSTRAINT `item_template_equippables_ibfk_1` FOREIGN KEY (`itemTemplateId`) REFERENCES `item_templates` (`itemTemplateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_template_socketables`
--
ALTER TABLE `item_template_socketables`
  ADD CONSTRAINT `item_template_socketables_ibfk_1` FOREIGN KEY (`itemTemplateId`) REFERENCES `item_templates` (`itemTemplateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `map_monsters`
--
ALTER TABLE `map_monsters`
  ADD CONSTRAINT `maps_monsters_ibfk_1` FOREIGN KEY (`mapId`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maps_monsters_ibfk_2` FOREIGN KEY (`monsterId`) REFERENCES `monsters` (`monsterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `map_monsters_ibfk_1` FOREIGN KEY (`positionX`) REFERENCES `map_places` (`positionX`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `map_places`
--
ALTER TABLE `map_places`
  ADD CONSTRAINT `maps_places_ibfk_1` FOREIGN KEY (`mapId`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maps_places_ibfk_2` FOREIGN KEY (`placeId`) REFERENCES `map_place_types` (`placeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`characterId1`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposals_ibfk_2` FOREIGN KEY (`characterId2`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quests`
--
ALTER TABLE `quests`
  ADD CONSTRAINT `quests_ibfk_1` FOREIGN KEY (`monsterId`) REFERENCES `monsters` (`monsterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quests_ibfk_2` FOREIGN KEY (`monstertypeid`) REFERENCES `monster_types` (`monsterTypeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quests_ibfk_3` FOREIGN KEY (`mapid`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `races_ibfk_1` FOREIGN KEY (`homeMapId`) REFERENCES `maps` (`mapId`) ON UPDATE CASCADE;

--
-- Constraints for table `race_abilities`
--
ALTER TABLE `race_abilities`
  ADD CONSTRAINT `race_abilities_ibfk_1` FOREIGN KEY (`raceId`) REFERENCES `races` (`raceId`);

--
-- Constraints for table `race_default_items`
--
ALTER TABLE `race_default_items`
  ADD CONSTRAINT `race_default_items_ibfk_1` FOREIGN KEY (`raceId`) REFERENCES `races` (`raceId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `race_default_items_ibfk_2` FOREIGN KEY (`itemTemplateId`) REFERENCES `item_templates` (`itemTemplateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `race_default_masteries`
--
ALTER TABLE `race_default_masteries`
  ADD CONSTRAINT `race_default_masteries_ibfk_1` FOREIGN KEY (`raceId`) REFERENCES `races` (`raceId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `race_default_masteries_ibfk_2` FOREIGN KEY (`masteryId`) REFERENCES `mastery_types` (`masteryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`characterId`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `accounts` (`accountId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`inventoryIdTo`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trades_ibfk_2` FOREIGN KEY (`inventoryIdFrom`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trade_items`
--
ALTER TABLE `trade_items`
  ADD CONSTRAINT `trade_items_ibfk_1` FOREIGN KEY (`tradeId`) REFERENCES `trades` (`tradeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trade_items_ibfk_2` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;
