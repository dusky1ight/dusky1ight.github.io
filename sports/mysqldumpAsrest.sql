-- MySQL dump 10.19  Distrib 10.3.35-MariaDB, for Linux (x86_64)
--
-- Host: studdb.csc.liv.ac.uk    Database: hspprate
-- ------------------------------------------------------
-- Server version	10.5.16-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `teams_table`
--

DROP TABLE IF EXISTS `teams_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams_table` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sport` varchar(50) NOT NULL,
  `avg_age` float(4,2) DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams_table`
--

LOCK TABLES `teams_table` WRITE;
/*!40000 ALTER TABLE `teams_table` DISABLE KEYS */;
INSERT INTO `teams_table` VALUES (1,'Arsenal','Football',41.00),(2,'CSK','Cricket',42.00),(3,'Redbull Racing','F1',26.00);
/*!40000 ALTER TABLE `teams_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players_table`
--

DROP TABLE IF EXISTS `players_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players_table` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(50) NOT NULL,
  `given_names` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`player_id`,`team_id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `players_table_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams_table` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players_table`
--

LOCK TABLES `players_table` WRITE;
/*!40000 ALTER TABLE `players_table` DISABLE KEYS */;
INSERT INTO `players_table` VALUES (10,'Prateek','wicky','british','1990-01-01',1),(12,'Smithens','TJohny','USA','1990-07-01',2),(17,'Doe','John','American','1990-01-01',2),(22,'Deven','Johno','British','1999-09-09',2),(23,'saka','bukayo','Englis','2001-09-05',1),(24,'xhaka','Granit','Swiss','1992-09-27',1),(25,'Max','Verstappen','Dutch','1997-09-30',3),(26,'Pérez','Sergio','Dutch','1990-01-26',3),(27,'Horner OBE','Christian','Dutch','1973-11-16',3);
/*!40000 ALTER TABLE `players_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-13  6:50:05
