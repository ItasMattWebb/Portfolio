-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: bookdb
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `availability` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'CompTIA A+ Guide to 801 Managing and Troubleshooting PCs, Fourth Edition (Exam 220-801)','Mike Meyers','82.95','','ITAS 155','978-0071795913','Theo Postulo','/images/ITAS155.jpg',3),(2,'Windows® 7 Inside Out','Ed Bott','20.21','','ITAS 167','0735626650','John Loewen','/images/ITAS167.jpg',3),(3,'Starting Out with Java: Early Objects (4th Edition)','Tony Gaddis','76.39','','ITAS 185','9780132164764','Mark Dutchuk','/images/ITAS185.jpg',3),(4,'Web Development and Design Fundamentals with HTML5, 6th Edition','Terry Ann Felke-Morris','55.99','','ITAS 191','0132783398','David Grant','/images/ITAS191.jpg',3),(5,'Security+ Guide to Network Security Fundamentals, Fourth Edition','Mark Ciampa','91.98','2.0000','ITAS 218','9781111640125','John Loewen','/images/ITAS218.jpg',3),(6,'MCITP Guide to Microsoft® Windows Server 2008 Administration, Exam #70-646, 1st Edition','Michael Palmer','108.48','3.0000','ITAS 233','9781423902386','John Loewen','/images/ITAS233.jpg',3),(7,'Linux Apache Web Server Administration','Charles Aulds','49.80','4.0000','ITAS 257 ','9780782127348','Mark Dutchuk','/images/ITAS257.jpg',0),(8,'PHP 5 MySQL Programming for the Absolute Beginner','Andy Harris','141.90','5.0000','ITAS 255','9781423902362','Mark Dutchuk','/images/ITAS255.jpg',3),(9,'New Perspectives on Mictosoft Project 2010: Introductory','Biheller Bunin','111.95','','ITAS 164','9780538746762','John Loewen','/images/ITAS164.jpg',3),(10,'Network+ Guide to Networks - 5th edition','Tamara Dean','71.56','','ITAS 175','9780619217433','John Loewen','/images/ITAS175.jpg',3),(11,' Linux+ Guide to Linux Certification – 3rd Edition','Jason Eckert','85.95','','ITAS 181','9781418837211','Mark Dutchuk','/images/ITAS181.jpg',3),(12,'PHP and MySQL Web Development, 4rth Edition\r\n','Luke Welling','54.99','','ITAS 186','0672329166','Dave Croft','/images/ITAS186.jpg',3),(13,'Android™ Wireless Application Development, Volume 1: Android Essentials, Third Edition','Lauren Darcey','44.99','4.0000','ITAS 274','9780321813831','Mark Dutchuk','/images/ITAS274.jpg',0),(14,'The Accidental Administrator: Linux Server Configuration Guide','Don R Crawley','40.00','','ITAS 278','9781453689929','Mark Dutchuk','/images/ITAS278.jpg',3),(15,'Microsoft® SharePoint® 2010: Creating and Implementing Real-World Projects, 1st Edition','Jennifer Mason','29.24','','ITAS 280','9780735662827','John Loewen','/images/ITAS280.jpg',3),(16,'Modern Database Management – 10th Edition','Jeffrey A. Hoffer','26.60','','ITAS 288','9780136088394','Mark Dutchuk','/images/ITAS288.jpg',3);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,13,1),(3,7,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate`
--

DROP TABLE IF EXISTS `rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `bookid` tinyint(4) NOT NULL DEFAULT '0',
  `userid` varchar(500) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate`
--

LOCK TABLES `rate` WRITE;
/*!40000 ALTER TABLE `rate` DISABLE KEYS */;
INSERT INTO `rate` VALUES (1,8,'1',5),(2,6,'1',3),(3,5,'1',2),(4,13,'1',4),(5,7,'1',4);
/*!40000 ALTER TABLE `rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'bob','$2y$08$J1YdorMhTLSmg.puseSjKeoneqwTWuMV9zMqjYZLHvuXnOnWSE2y6','1@bob');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-10 21:06:53
