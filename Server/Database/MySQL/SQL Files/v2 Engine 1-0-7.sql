-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 21, 2010 at 05:39 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

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
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`channelId`),
  UNIQUE KEY `name` (`name`),
  KEY `createdOn` (`createdOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channels`
--


-- --------------------------------------------------------

--
-- Table structure for table `channel_permissions`
--

CREATE TABLE IF NOT EXISTS `channel_permissions` (
  `channelId` char(28) CHARACTER SET utf8 NOT NULL,
  `characterId` char(28) CHARACTER SET utf8 NOT NULL,
  `accessRead` bit(1) NOT NULL,
  `accessModerator` bit(1) NOT NULL,
  `accessWrite` bit(1) NOT NULL,
  `accessAdmin` bit(1) NOT NULL,
  `givenOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `channelId` (`channelId`),
  KEY `characterId` (`characterId`),
  KEY `givenOn` (`givenOn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `clanId` char(28) DEFAULT NULL,
  `pin` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `biography` text,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`characterId`),
  UNIQUE KEY `Name` (`firstName`,`middleName`,`lastName`),
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
-- Table structure for table `character_locations`
--

CREATE TABLE IF NOT EXISTS `character_locations` (
  `characterId` char(28) NOT NULL,
  `mapId` char(28) NOT NULL,
  `positionX` int(11) unsigned NOT NULL,
  `positionY` int(11) unsigned NOT NULL,
  PRIMARY KEY (`characterId`),
  KEY `mapId` (`mapId`),
  KEY `positionY` (`positionY`),
  KEY `positionX` (`positionX`)
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
  `masteryId` char(28) NOT NULL,
  `mastery` int(11) NOT NULL,
  `masteryBonus` int(11) NOT NULL,
  PRIMARY KEY (`characterId`),
  KEY `masteryId` (`masteryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `character_masteries`
--


-- --------------------------------------------------------

--
-- Table structure for table `character_race_traits`
--

CREATE TABLE IF NOT EXISTS `character_race_traits` (
  `characterId` char(28) CHARACTER SET utf8 NOT NULL,
  `strength` int(11) NOT NULL,
  `dexterity` int(11) NOT NULL,
  `wisdom` int(11) NOT NULL,
  `intelligence` int(11) NOT NULL,
  `vitality` int(11) NOT NULL,
  `racialAbility` char(28) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`characterId`),
  KEY `racialAbility` (`racialAbility`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `characterIdTo` char(28) DEFAULT NULL,
  `characterIdFrom` char(28) NOT NULL,
  `channelId` char(28) NOT NULL,
  `message` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `fromName` varchar(153) NOT NULL,
  `sentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `characterIdTo` (`characterIdTo`),
  KEY `characterIdFrom` (`characterIdFrom`),
  KEY `channelId` (`channelId`),
  KEY `sentOn` (`sentOn`),
  KEY `type` (`type`)
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
  `maxSlots` int(10) unsigned NOT NULL,
  PRIMARY KEY (`inventoryId`),
  KEY `characterId` (`characterId`),
  KEY `clanId` (`clanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventories`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory_item_assoc`
--

CREATE TABLE IF NOT EXISTS `inventory_item_assoc` (
  `itemId` char(28) NOT NULL,
  `inventoryId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slots` int(10) unsigned NOT NULL,
  KEY `itemId` (`itemId`),
  KEY `inventoryId` (`inventoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_item_assoc`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemId` char(28) NOT NULL,
  `itemTypeId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `itemClass` int(10) unsigned NOT NULL DEFAULT '0',
  `statRequirement` int(10) unsigned NOT NULL DEFAULT '0',
  `levelRequirement` int(10) unsigned NOT NULL DEFAULT '0',
  `requiredStat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`itemId`),
  KEY `itemTypeId` (`itemTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_socket_assoc`
--

CREATE TABLE IF NOT EXISTS `item_socket_assoc` (
  `itemId` char(28) NOT NULL,
  `socketItemId` char(28) NOT NULL,
  KEY `itemId` (`itemId`),
  KEY `socketItemId` (`socketItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_socket_assoc`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_stat_bonuses`
--

CREATE TABLE IF NOT EXISTS `item_stat_bonuses` (
  `itemId` char(28) NOT NULL,
  `statId` char(28) NOT NULL,
  `modifier` float NOT NULL,
  `modifierType` int(11) NOT NULL,
  KEY `itemId` (`itemId`),
  KEY `statId` (`statId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_stat_bonuses`
--


-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE IF NOT EXISTS `item_types` (
  `itemTypeId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`itemTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_types`
--


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
  `minLevel` int(10) unsigned NOT NULL DEFAULT '0',
  `maxLevel` int(10) unsigned NOT NULL,
  `minAlign` bigint(20) NOT NULL,
  `maxAlign` bigint(20) NOT NULL,
  PRIMARY KEY (`mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`mapId`, `pvp`, `name`, `dimensionX`, `dimensionY`, `minLevel`, `maxLevel`, `minAlign`, `maxAlign`) VALUES
('MAP_00000000000000000000001', b'1', 'Test', 5, 5, 0, 99999999, -99999999, 999999999);

-- --------------------------------------------------------

--
-- Table structure for table `map_monster_assoc`
--

CREATE TABLE IF NOT EXISTS `map_monster_assoc` (
  `mapId` char(28) NOT NULL,
  `monsterId` char(28) NOT NULL,
  KEY `monsterId` (`monsterId`),
  KEY `mapId` (`mapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_monster_assoc`
--


-- --------------------------------------------------------

--
-- Table structure for table `map_places`
--

CREATE TABLE IF NOT EXISTS `map_places` (
  `mapId` char(28) NOT NULL,
  `placeId` char(28) NOT NULL,
  `positionX` int(10) unsigned NOT NULL,
  `positionY` int(10) unsigned NOT NULL,
  KEY `mapId` (`mapId`),
  KEY `placeId` (`placeId`),
  KEY `positionX` (`positionX`),
  KEY `positionY` (`positionY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `map_places`
--


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


-- --------------------------------------------------------

--
-- Table structure for table `mastery_types`
--

CREATE TABLE IF NOT EXISTS `mastery_types` (
  `masteryId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `itemTypeId` char(28) DEFAULT NULL,
  PRIMARY KEY (`masteryId`),
  KEY `itemTypeId` (`itemTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mastery_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE IF NOT EXISTS `monsters` (
  `monsterId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  `stats` int(10) unsigned NOT NULL,
  `experience` int(10) unsigned NOT NULL,
  `gold` int(10) unsigned NOT NULL,
  `itemClass` int(10) unsigned NOT NULL,
  PRIMARY KEY (`monsterId`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monsters`
--


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
  `armorMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `armorMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `swordMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `swordMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `axeMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `axeMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `maceMasteryMinimum` int(11) unsigned NOT NULL DEFAULT '0',
  `maceMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `staffMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `staffMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `shieldMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `shieldMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `fireMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `fireMastereyMax` int(11) unsigned NOT NULL DEFAULT '0',
  `coldMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `coldMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `arcaneMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `arcaneMasteryMax` int(11) unsigned NOT NULL DEFAULT '0',
  `airMasteryMin` int(11) unsigned NOT NULL DEFAULT '0',
  `airMasterytMax` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`raceId`),
  UNIQUE KEY `name` (`name`),
  KEY `homeMapId` (`homeMapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`raceId`, `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `armorMasteryMin`, `armorMasteryMax`, `swordMasteryMin`, `swordMasteryMax`, `axeMasteryMin`, `axeMasteryMax`, `maceMasteryMinimum`, `maceMasteryMax`, `staffMasteryMin`, `staffMasteryMax`, `shieldMasteryMin`, `shieldMasteryMax`, `fireMasteryMin`, `fireMastereyMax`, `coldMasteryMin`, `coldMasteryMax`, `arcaneMasteryMin`, `arcaneMasteryMax`, `airMasteryMin`, `airMasterytMax`) VALUES
('RACE_00000000000000000000001', 'Test Race', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 20, 20, 20, 20, 20, 35, 30, 28, 35, 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `race_abilities`
--

CREATE TABLE IF NOT EXISTS `race_abilities` (
  `abilityId` char(28) CHARACTER SET utf8 NOT NULL,
  `raceId` char(28) CHARACTER SET utf8 NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`abilityId`),
  KEY `raceId` (`raceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `race_abilities`
--


-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sessionId` char(30) NOT NULL,
  `data` text NOT NULL,
  `lastUsedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sessionId`),
  KEY `lastUsedOn` (`lastUsedOn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--


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
  KEY `inventoryIdTo` (`inventoryIdTo`),
  KEY `inventoryIdFrom` (`inventoryIdFrom`),
  KEY `ItemId` (`ItemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trades`
--


-- --------------------------------------------------------

--
-- Table structure for table `traits`
--

CREATE TABLE IF NOT EXISTS `traits` (
  `statId` char(28) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`statId`),
  KEY `name` (`name`)
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
  ADD CONSTRAINT `characters_masteries_ibfk_3` FOREIGN KEY (`masteryId`) REFERENCES `mastery_types` (`masteryId`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`channelId`) REFERENCES `channels` (`channelId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`characterIdTo`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`characterIdFrom`) REFERENCES `characters` (`characterId`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `inventory_item_assoc`
--
ALTER TABLE `inventory_item_assoc`
  ADD CONSTRAINT `inventories_items_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventories_items_ibfk_2` FOREIGN KEY (`inventoryId`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`itemTypeId`) REFERENCES `item_types` (`itemTypeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_socket_assoc`
--
ALTER TABLE `item_socket_assoc`
  ADD CONSTRAINT `item_socket_assoc_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_socket_assoc_ibfk_2` FOREIGN KEY (`socketItemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_stat_bonuses`
--
ALTER TABLE `item_stat_bonuses`
  ADD CONSTRAINT `item_stat_bonuses_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_stat_bonuses_ibfk_2` FOREIGN KEY (`statId`) REFERENCES `traits` (`statId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `map_monster_assoc`
--
ALTER TABLE `map_monster_assoc`
  ADD CONSTRAINT `maps_monsters_ibfk_1` FOREIGN KEY (`mapId`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maps_monsters_ibfk_2` FOREIGN KEY (`monsterId`) REFERENCES `monsters` (`monsterId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `map_places`
--
ALTER TABLE `map_places`
  ADD CONSTRAINT `maps_places_ibfk_1` FOREIGN KEY (`mapId`) REFERENCES `maps` (`mapId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maps_places_ibfk_2` FOREIGN KEY (`placeId`) REFERENCES `map_place_types` (`placeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mastery_types`
--
ALTER TABLE `mastery_types`
  ADD CONSTRAINT `itemTypeId` FOREIGN KEY (`itemTypeId`) REFERENCES `item_types` (`itemTypeId`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`inventoryIdTo`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trades_ibfk_2` FOREIGN KEY (`inventoryIdFrom`) REFERENCES `inventories` (`inventoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trades_ibfk_3` FOREIGN KEY (`ItemId`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE;
