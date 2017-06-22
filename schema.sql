-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `app`;

DROP TABLE IF EXISTS `Meal`;
CREATE TABLE `Meal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Calories` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `MealRecord`;
CREATE TABLE `MealRecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `mealId` int(11) NOT NULL,
  `mealType` enum('Breakfast','Lunch','Dinner','Snack') NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `mealId` (`mealId`),
  CONSTRAINT `MealRecord_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`),
  CONSTRAINT `MealRecord_ibfk_2` FOREIGN KEY (`mealId`) REFERENCES `Meal` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Overview`;
CREATE TABLE `Overview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `weight` double NOT NULL,
  `date` date NOT NULL,
  `calories` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `Overview_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` enum('female','male') NOT NULL,
  `height` double DEFAULT NULL,
  `currentWeight` double DEFAULT NULL,
  `Goal` enum('Lose Weight','Maintain Weight','Gain Weight') DEFAULT NULL,
  `goalWeight` double DEFAULT NULL,
  `caloriesGoalIntake` double DEFAULT NULL,
  `resetPoint` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-06-22 06:55:49
