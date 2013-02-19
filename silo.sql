# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.25)
# Database: silo
# Generation Time: 2013-02-16 02:21:53 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Affectations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Affectations`;

CREATE TABLE `Affectations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `superviseur_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Affectations` WRITE;
/*!40000 ALTER TABLE `Affectations` DISABLE KEYS */;

INSERT INTO `Affectations` (`id`, `job_id`, `superviseur_id`, `date`, `comment`, `user_id`)
VALUES
	(1,3,1,'2012-11-21','',14),
	(2,2,1,'2012-11-20','',14),
	(3,3,2,'2012-11-20','',14),
	(4,2,2,'2012-11-21','',18),
	(5,9,1,'2012-11-21','',18),
	(6,2,1,'2013-01-24','',14);

/*!40000 ALTER TABLE `Affectations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Distributions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Distributions`;

CREATE TABLE `Distributions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `affectation_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `debut_distribution` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Distributions` WRITE;
/*!40000 ALTER TABLE `Distributions` DISABLE KEYS */;

INSERT INTO `Distributions` (`id`, `affectation_id`, `employee_id`, `debut_distribution`)
VALUES
	(1,1,3,'0000-00-00'),
	(3,2,6,'0000-00-00'),
	(4,2,7,'0000-00-00'),
	(5,3,4,'0000-00-00'),
	(6,3,3,'0000-00-00'),
	(7,3,8,'0000-00-00'),
	(8,4,4,'0000-00-00'),
	(9,6,3,'0000-00-00');

/*!40000 ALTER TABLE `Distributions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Employees`;

CREATE TABLE `Employees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Employees` WRITE;
/*!40000 ALTER TABLE `Employees` DISABLE KEYS */;

INSERT INTO `Employees` (`id`, `name`, `type_id`)
VALUES
	(1,'Charles Lalonde',1),
	(2,'Mathieu',1),
	(3,'Francis',2),
	(4,'Carlos',3),
	(5,'Test',1),
	(6,'user1',3),
	(7,'user2',3),
	(8,'user3',3);

/*!40000 ALTER TABLE `Employees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Jobs`;

CREATE TABLE `Jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `client` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Jobs` WRITE;
/*!40000 ALTER TABLE `Jobs` DISABLE KEYS */;

INSERT INTO `Jobs` (`id`, `name`, `client`)
VALUES
	(2,'Silo 1','Mathieu'),
	(3,'Test','test'),
	(4,'Charles','test'),
	(7,'Mathieu','BOOM'),
	(8,'test','max'),
	(9,'numero xxx','wahler');

/*!40000 ALTER TABLE `Jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Permissions`;

CREATE TABLE `Permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `type_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;

INSERT INTO `Users` (`id`, `name`, `password`, `type_id`)
VALUES
	(14,'charles','49c9619009a7c40fdad5200a59d9d424c1523022',1),
	(16,'mathieu','49c9619009a7c40fdad5200a59d9d424c1523022',1),
	(17,'marie','49c9619009a7c40fdad5200a59d9d424c1523022',2),
	(18,'max','0e0265e3a056b0420a5a8f32a75236ffb822c852',1);

/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;