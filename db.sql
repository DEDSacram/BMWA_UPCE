SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Subcategories`;
CREATE TABLE `Subcategories` (
  `SubcategoryID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `SubcategoryName` varchar(255) NOT NULL,
  `Order` int(11) NOT NULL,
  PRIMARY KEY (`SubcategoryID`),
  KEY `ItemID` (`ItemID`),
  CONSTRAINT `Subcategories_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `ToDoItems` (`ItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `ToDoItems`;
CREATE TABLE `ToDoItems` (
  `ItemID` int(11) NOT NULL,
  `ListID` int(11) DEFAULT NULL,
  `ItemName` varchar(255) NOT NULL,
  `IsCompleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `ListID` (`ListID`),
  CONSTRAINT `ToDoItems_ibfk_1` FOREIGN KEY (`ListID`) REFERENCES `ToDoLists` (`ListID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `ToDoLists`;
CREATE TABLE `ToDoLists` (
  `ListID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ListName` varchar(255) NOT NULL,
  PRIMARY KEY (`ListID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `ToDoLists_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `UserSettings`;
CREATE TABLE `UserSettings` (
  `SettingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SettingName` varchar(255) NOT NULL,
  `SettingValue` varchar(255) NOT NULL,
  PRIMARY KEY (`SettingID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `UserSettings_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
