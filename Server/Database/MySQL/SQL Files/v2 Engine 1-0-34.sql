-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 14, 2011 at 04:28 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `chrysellia`
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

INSERT INTO `channels` (`channelId`, `name`, `motd`, `createdOn`) VALUES
('CHAN_00000000000000000000001', 'General', 'Welcome to Chrysellia!', '2011-01-06 15:35:42'),
('CHAN_00000000000000000000002', 'Trade', 'Trade chat.', '2011-01-06 15:35:42');

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
('ITEM_00000000000000000000001', 2, 'Dagger', 'A small dagger.', 50, 25),
('ITEM_00000000000000000000002', 2, 'Clothes', 'Simple clothing.', 50, 25),
('ITEM_00000000000000000000003', 2, 'Faerie Fire', 'A spell that burns with the power of faeries.', 50, 25),
('ITEM_00000000000000000000004', 2, 'Lamprey', 'Sword type weapon IC 4', 418, 209),
('ITEM_00000000000000000000005', 2, 'Sabre', 'Sword type weapon IC 5', 710, 355),
('ITEM_00000000000000000000006', 2, 'Falchion', 'Sword type weapon IC 6', 1207, 604),
('ITEM_00000000000000000000007', 2, 'Long Sword', 'Sword type weapon IC 7', 2052, 1026),
('ITEM_00000000000000000000008', 2, 'Gladius', 'Sword type weapon IC 8', 3488, 1744),
('ITEM_00000000000000000000009', 2, 'Cutlass', 'Sword type weapon IC 9', 5929, 2965),
('ITEM_00000000000000000000010', 2, 'Battle Sword', 'Sword type weapon IC 10', 10080, 5040),
('ITEM_00000000000000000000011', 2, 'War Sword', 'Sword type weapon IC 11', 17136, 8568),
('ITEM_00000000000000000000012', 2, 'Broad Sword', 'Sword type weapon IC 12', 29131, 14566),
('ITEM_00000000000000000000013', 2, 'Crystal Sword', 'Sword type weapon IC 13', 49523, 24762),
('ITEM_00000000000000000000014', 2, 'Rune Sword', 'Sword type weapon IC 14', 84189, 42095),
('ITEM_00000000000000000000015', 2, 'Tusk Sword', 'Sword type weapon IC 15', 143121, 71561),
('ITEM_00000000000000000000016', 2, 'Jataghan', 'Sword type weapon IC 16', 243306, 121653),
('ITEM_00000000000000000000017', 2, 'Claymore', 'Sword type weapon IC 17', 413620, 206810),
('ITEM_00000000000000000000018', 2, 'Dragonslayer', 'Sword type weapon IC 18', 703154, 351577),
('ITEM_00000000000000000000019', 2, 'Jack Handy''s Knife', 'Sword type weapon IC 19', 1.19536e+006, 597681),
('ITEM_00000000000000000000020', 2, 'Flamberge', 'Sword type weapon IC 20', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000021', 2, 'Giant Sword', 'Sword type weapon IC 21', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000022', 2, 'Demon''s Nail', 'Sword type weapon IC 2', 144, 72),
('ITEM_00000000000000000000023', 2, 'Wool Cloak', 'Armor IC 1', 85, 43),
('ITEM_00000000000000000000024', 2, 'Leather Armor', 'Armor IC 2', 144, 72),
('ITEM_00000000000000000000025', 2, 'Padded Leather Armor', 'Armor IC 3', 246, 123),
('ITEM_00000000000000000000026', 2, 'Studded Leather Armor', 'Armor IC 4', 418, 209),
('ITEM_00000000000000000000027', 2, 'Chainmail Armor', 'Armor IC 5', 710, 355),
('ITEM_00000000000000000000028', 2, 'Linked Armor', 'Armor IC 6', 1207, 604),
('ITEM_00000000000000000000029', 2, 'Ringmail Armor', 'Armor IC 7', 2052, 1026),
('ITEM_00000000000000000000030', 2, 'Elven Chain', 'Armor IC 8', 3488, 1744),
('ITEM_00000000000000000000031', 2, 'Combat Plate', 'Armor IC 9', 5929, 2965),
('ITEM_00000000000000000000032', 2, 'Mage Plate', 'Armor IC 10', 10080, 5040),
('ITEM_00000000000000000000033', 2, 'Heavy Plate', 'Armor IC 11', 17136, 8568),
('ITEM_00000000000000000000034', 2, 'Lamurian Skin Armor', 'Armor IC 12', 29131, 14566),
('ITEM_00000000000000000000035', 2, 'Moloch Armor', 'Armor IC 13', 49523, 24762),
('ITEM_00000000000000000000036', 2, 'Angel Skin Armor', 'Armor IC 14', 84189, 42095),
('ITEM_00000000000000000000037', 2, 'Ancient Breastplate', 'Armor IC 15', 143121, 71561),
('ITEM_00000000000000000000038', 2, 'Mythril Ringmail', 'Armor IC 16', 243306, 121653),
('ITEM_00000000000000000000039', 2, 'Adamantium Plate', 'Armor IC 17', 413620, 206810),
('ITEM_00000000000000000000040', 2, 'Morkal Armor', 'Armor IC 18', 703154, 351577),
('ITEM_00000000000000000000041', 2, 'Dragon Scale Plate', 'Armor IC 19', 1.19536e+006, 597681),
('ITEM_00000000000000000000042', 2, 'Valar Tunic', 'Armor IC 20', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000043', 2, 'Lucifer''s Cape', 'Armor IC 21', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000044', 2, 'Scimitar', 'Sword type weapon IC 3', 246, 123),
('ITEM_00000000000000000000045', 2, 'Minor Ignite', 'Armor IC 1', 85, 43),
('ITEM_00000000000000000000046', 2, 'Burning Hands', 'Armor IC 2', 144, 72),
('ITEM_00000000000000000000047', 2, 'Firebolt', 'Armor IC 3', 246, 123),
('ITEM_00000000000000000000048', 2, 'Flame Blast', 'Armor IC 4', 418, 209),
('ITEM_00000000000000000000049', 2, 'Flame Strike', 'Armor IC 5', 710, 355),
('ITEM_00000000000000000000050', 2, 'Burning Blood', 'Armor IC 6', 1207, 604),
('ITEM_00000000000000000000051', 2, 'Fire Fury', 'Armor IC 7', 2052, 1026),
('ITEM_00000000000000000000052', 2, 'Fireball', 'Armor IC 8', 3488, 1744),
('ITEM_00000000000000000000053', 2, 'Incinirating Ray', 'Armor IC 9', 5929, 2965),
('ITEM_00000000000000000000054', 2, 'Hell''s Legion', 'Armor IC 10', 10080, 5040),
('ITEM_00000000000000000000055', 2, 'Flame Gusts', 'Armor IC 11', 17136, 8568),
('ITEM_00000000000000000000056', 2, 'Deadly Destruction', 'Armor IC 12', 29131, 14566),
('ITEM_00000000000000000000057', 2, 'Gaze Of The Phoenix', 'Armor IC 13', 49523, 24762),
('ITEM_00000000000000000000058', 2, 'Searing Orb', 'Armor IC 14', 84189, 42095),
('ITEM_00000000000000000000059', 2, 'Incendiary Strike', 'Armor IC 15', 143121, 71561),
('ITEM_00000000000000000000060', 2, 'Demon Bane', 'Armor IC 16', 243306, 121653),
('ITEM_00000000000000000000061', 2, 'Aura of Seraph', 'Armor IC 17', 413620, 206810),
('ITEM_00000000000000000000062', 2, 'Major Ignite', 'Armor IC 18', 703154, 351577),
('ITEM_00000000000000000000063', 2, 'Elemental Chaos', 'Armor IC 19', 1.19536e+006, 597681),
('ITEM_00000000000000000000064', 2, 'The RKOs burning light', 'Armor IC 20', 2.03212e+006, 1.01606e+006),
('ITEM_00000000000000000000065', 2, 'Orb Of Fury', 'Armor IC 21', 3.4546e+006, 1.7273e+006),
('ITEM_00000000000000000000066', 2, 'Short Sword', 'Sword IC 1', 85, 43);

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
('ITEM_00000000000000000000001', 1, 0, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000002', 0, 0, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000003', 8, 0, 1, 3, 1, NULL, NULL, NULL, NULL),
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
('ITEM_00000000000000000000022', 1, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000023', 0, 1, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000024', 0, 2, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000025', 0, 3, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000026', 0, 4, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000027', 0, 5, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000028', 0, 6, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000029', 0, 7, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000030', 0, 8, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000031', 0, 9, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000032', 0, 10, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000033', 0, 11, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000034', 0, 12, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000035', 0, 13, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000036', 0, 14, 1, 1, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000037', 0, 15, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000038', 0, 16, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000039', 0, 17, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000040', 0, 18, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000041', 0, 19, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000042', 0, 20, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000043', 0, 21, 1, 1, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000044', 1, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000045', 2, 1, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000046', 2, 2, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000047', 2, 3, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000048', 2, 4, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000049', 2, 5, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000050', 2, 6, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000051', 2, 7, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000052', 2, 8, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000053', 2, 9, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000054', 2, 10, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000055', 2, 11, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000056', 2, 12, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000057', 2, 13, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000058', 2, 14, 1, 0, 1, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000059', 2, 15, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000060', 2, 16, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000061', 2, 17, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000062', 2, 18, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000063', 2, 19, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000064', 2, 20, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000065', 2, 21, 1, 0, 2, NULL, NULL, NULL, NULL),
('ITEM_00000000000000000000066', 1, 1, 1, 0, 1, NULL, NULL, NULL, NULL);

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
('MAP_00000000000000000000001', b'0', 'Test City', 5, 5),
('MAP_00000000000000000000002', b'0', 'Wilderness', 20, 20);

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
('MAP_00000000000000000000001', 'PLAC_00000000000000000000001', 0, 1, b'0', b'0', '', NULL, NULL),
('MAP_00000000000000000000001', 'PLAC_00000000000000000000002', 4, 2, b'0', b'0', '', NULL, NULL),
('MAP_00000000000000000000001', 'PLAC_00000000000000000000003', 0, 3, b'0', b'0', '', NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 0, b'0', b'0', 'MAP_00000000000000000000002', 8, 2),
('MAP_00000000000000000000001', NULL, 4, 4, b'1', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 4, b'1', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 3, b'1', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 2, b'1', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 2, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 0, 4, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 0, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 1, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 2, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 3, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 1, 4, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 0, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 1, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 3, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 2, 4, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 0, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 1, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 2, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 3, 3, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 1, b'0', b'0', NULL, NULL, NULL),
('MAP_00000000000000000000001', NULL, 4, 0, b'0', b'0', NULL, NULL, NULL);

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
  `masteryId` char(28) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`masteryId`)
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
  `level` int(10) unsigned NOT NULL,
  `experienceBonus` float unsigned NOT NULL,
  `goldBonus` float unsigned NOT NULL,
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

INSERT INTO `monsters` (`monsterId`, `name`, `level`, `experienceBonus`, `goldBonus`, `weaponClass`, `spellClass`, `armorClass`, `alignGood`, `alignOrder`) VALUES
('MONS_00000000000000000000001', 'Drunk Beggar', 1, 100, 100, 0, 0, 0, 0, 0),
('MONS_00000000000000000000002', 'Street Urchin', 2, 100, 100, 1, 1, 1, 0, 0),
('MONS_00000000000000000000003', 'Sly Peddler', 3, 100, 100, 2, 2, 2, 0, 0),
('MONS_00000000000000000000004', 'Stray Dog', 4, 100, 100, 3, 3, 3, 0, 0),
('MONS_00000000000000000000005', 'Cultist Initiate', 5, 100, 100, 4, 4, 4, 0, 0),
('MONS_00000000000000000000006', '', 6, 100, 100, 5, 5, 5, 0, 0),
('MONS_00000000000000000000007', '', 7, 100, 100, 6, 6, 6, 0, 0),
('MONS_00000000000000000000008', '', 8, 100, 100, 7, 7, 7, 0, 0),
('MONS_00000000000000000000009', '', 9, 100, 100, 8, 8, 8, 0, 0),
('MONS_00000000000000000000010', '', 10, 100, 100, 9, 9, 9, 0, 0),
('MONS_00000000000000000000011', '', 11, 100, 100, 10, 10, 10, 0, 0),
('MONS_00000000000000000000012', '', 12, 100, 100, 11, 11, 11, 0, 0);

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
  `weaponSlots` int(10) unsigned NOT NULL,
  `armorSlots` int(10) unsigned NOT NULL,
  `accessorySlots` int(10) unsigned NOT NULL,
  `spellSlots` int(10) unsigned NOT NULL,
  PRIMARY KEY (`raceId`),
  UNIQUE KEY `name` (`name`),
  KEY `homeMapId` (`homeMapId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`raceId`, `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `armorMasteryMin`, `armorMasteryMax`, `swordMasteryMin`, `swordMasteryMax`, `axeMasteryMin`, `axeMasteryMax`, `maceMasteryMinimum`, `maceMasteryMax`, `staffMasteryMin`, `staffMasteryMax`, `shieldMasteryMin`, `shieldMasteryMax`, `fireMasteryMin`, `fireMastereyMax`, `coldMasteryMin`, `coldMasteryMax`, `arcaneMasteryMin`, `arcaneMasteryMax`, `airMasteryMin`, `airMasterytMax`, `weaponSlots`, `armorSlots`, `accessorySlots`, `spellSlots`) VALUES
('RACE_00000000000000000000001', 'Aviakan', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 22, 24, 30, 28, 21, 42, 44, 50, 48, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 2),
('RACE_00000000000000000000002', 'Drow', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 33, 20, 25, 17, 50, 53, 40, 45, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100, 2, 1, 1, 2),
('RACE_00000000000000000000003', 'Dwarf', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 25, 20, 19, 28, 53, 45, 40, 39, 48, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 2),
('RACE_00000000000000000000004', 'Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 25, 30, 23, 17, 50, 45, 50, 40, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100, 2, 1, 1, 2),
('RACE_00000000000000000000005', 'Gargoyle', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 18, 27, 27, 20, 53, 33, 42, 57, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 2),
('RACE_00000000000000000000006', 'Half Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 24, 24, 25, 22, 50, 44, 40, 45, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100, 2, 1, 1, 2),
('RACE_00000000000000000000007', 'Human', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 22, 37, 33, 13, 20, 42, 57, 53, 33, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 2),
('RACE_00000000000000000000008', 'Orc', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 28, 22, 24, 21, 50, 48, 42, 44, 41, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100, 2, 1, 1, 2),
('RACE_00000000000000000000009', 'Troll', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 30, 28, 20, 22, 25, 50, 48, 40, 44, 45, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 2),
('RACE_00000000000000000000010', 'Goblin', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 20, 19, 33, 25, 28, 40, 39, 53, 45, 48, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100, 2, 1, 1, 2);

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


-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sessionId` char(30) CHARACTER SET latin1 NOT NULL,
  `data` text CHARACTER SET latin1 NOT NULL,
  `lastUsedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sessionId`),
  KEY `lastUsedOn` (`lastUsedOn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
