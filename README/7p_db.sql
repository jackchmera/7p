-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: 7p_forms
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `forms_data`
--

DROP TABLE IF EXISTS `forms_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text_field` varchar(255) DEFAULT NULL,
  `number_field` int(11) DEFAULT NULL,
  `select_field` varchar(255) DEFAULT NULL,
  `check_field` enum('0','1') DEFAULT NULL,
  `date_field` date DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `row_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`field_id`,`row_id`),
  KEY `fk_forms_data_1_idx` (`row_id`),
  CONSTRAINT `fk_forms_data_1` FOREIGN KEY (`row_id`) REFERENCES `rows` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms_data`
--

LOCK TABLES `forms_data` WRITE;
/*!40000 ALTER TABLE `forms_data` DISABLE KEYS */;
INSERT INTO `forms_data` VALUES (1,'John',NULL,NULL,NULL,NULL,1,54),(2,'Smith',NULL,NULL,NULL,NULL,2,54),(3,NULL,NULL,NULL,NULL,'1976-12-22',3,54),(4,NULL,10001,NULL,NULL,NULL,4,54),(5,NULL,NULL,'R&D',NULL,NULL,5,54),(6,NULL,NULL,NULL,'1',NULL,6,54),(7,'Jack',NULL,NULL,NULL,NULL,1,55),(8,'Chmera',NULL,NULL,NULL,NULL,2,55),(9,NULL,NULL,NULL,NULL,'1986-02-09',3,55),(10,NULL,10002,NULL,NULL,NULL,4,55),(11,NULL,NULL,'Sales',NULL,NULL,5,55),(12,NULL,NULL,NULL,'',NULL,6,55),(13,'Maite',NULL,NULL,NULL,NULL,1,56),(14,'Perroni',NULL,NULL,NULL,NULL,2,56),(15,NULL,NULL,NULL,NULL,'1966-11-11',3,56),(16,NULL,10004,NULL,NULL,NULL,4,56),(17,NULL,NULL,'Management',NULL,NULL,5,56),(18,NULL,NULL,NULL,'1',NULL,6,56);
/*!40000 ALTER TABLE `forms_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rows`
--

DROP TABLE IF EXISTS `rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rows`
--

LOCK TABLES `rows` WRITE;
/*!40000 ALTER TABLE `rows` DISABLE KEYS */;
INSERT INTO `rows` VALUES (54,1),(55,1),(56,1);
/*!40000 ALTER TABLE `rows` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-24  7:19:54
