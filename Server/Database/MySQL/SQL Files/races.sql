-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2010 at 04:11 PM
-- Server version: 5.1.51
-- PHP Version: 5.3.3

-- Based on DB version 1-0-14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `neflaria`
--

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`raceId`, `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `armorMasteryMin`, `armorMasteryMax`, `swordMasteryMin`, `swordMasteryMax`, `axeMasteryMin`, `axeMasteryMax`, `maceMasteryMinimum`, `maceMasteryMax`, `staffMasteryMin`, `staffMasteryMax`, `shieldMasteryMin`, `shieldMasteryMax`, `fireMasteryMin`, `fireMastereyMax`, `coldMasteryMin`, `coldMasteryMax`, `arcaneMasteryMin`, `arcaneMasteryMax`, `airMasteryMin`, `airMasterytMax`) VALUES
('RACE_00000000000000000000001', 'Aviakan', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 22, 24, 30, 28, 21, 42, 44, 50, 48, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('RACE_00000000000000000000002', 'Drow', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 33, 20, 25, 17, 50, 53, 40, 45, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100),
('RACE_00000000000000000000003', 'Dwarf', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 25, 20, 19, 28, 53, 45, 40, 39, 48, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('RACE_00000000000000000000004', 'Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 25, 30, 20, 17, 50, 45, 50, 40, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100),
('RACE_00000000000000000000005', 'Gargoyle', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 33, 13, 22, 27, 20, 53, 33, 42, 57, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('RACE_00000000000000000000006', 'Half Elf', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 30, 24, 20, 25, 17, 50, 44, 40, 45, 37, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100),
('RACE_00000000000000000000009', 'Troll', 'MAP_00000000000000000000001', 0, 0, 0, -99999999, 99999999, 30, 28, 20, 24, 25, 50, 48, 40, 44, 45, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('RACE_00000000000000000000010', 'Goblin', 'MAP_00000000000000000000001', 0, 0, 0, 0, 0, 20, 19, 33, 25, 28, 40, 39, 53, 45, 48, 0, 100, 0, 50, 0, 50, 0, 50, 0, 75, 0, 100, 0, 100, 0, 100, 0, 100, 0, 100);
