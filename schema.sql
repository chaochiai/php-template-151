-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

/*CREATE DATABASE `app` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `app`;

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
  `Goal` enum('Lose Weight'', ''Maintain Weight'', ''Gain Weight') DEFAULT NULL,
  `goalWeight` double DEFAULT NULL,
  `caloriesGoalIntake` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `User` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `gender`, `height`, `currentWeight`, `Goal`, `goalWeight`, `caloriesGoalIntake`) VALUES
(4,	'junhan',	'junhyeokhan.it@gmail.com',	'junhyeokgan',	'Junhyeok',	'Han',	'male',	176,	72,	NULL,	70,	NULL),
(5,	'chaochiai',	'chantalochiaionline@gmail.com',	'deathnote07',	'Chantal',	'Ochiai',	'female',	157,	58,	NULL,	50,	NULL),
(6,	'npeter',	'noahpeter0@gmail.com',	'noah',	'Noah',	'Peter',	'male',	180,	73,	NULL,	75,	NULL);

-- 2017-06-08 06:26:16
