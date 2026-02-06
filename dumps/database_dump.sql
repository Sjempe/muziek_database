/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.3-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: muziek_database
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `titel_album` varchar(255) NOT NULL,
  `artiest_id` int(11) DEFAULT NULL,
  `drager_album` varchar(50) DEFAULT NULL,
  `type_album` varchar(50) DEFAULT NULL,
  `cover_album` varchar(255) DEFAULT NULL,
  `extra_info_album` text DEFAULT NULL,
  `toegevoegd_op` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`album_id`),
  KEY `artiest_id` (`artiest_id`),
  CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`artiest_id`) REFERENCES `artiesten` (`artiest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `albums` VALUES
(4,'The Black Parade',4,NULL,'CD',NULL,NULL,'2026-02-04 15:41:47');
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `artiesten`
--

DROP TABLE IF EXISTS `artiesten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `artiesten` (
  `artiest_id` int(11) NOT NULL AUTO_INCREMENT,
  `naam_artiest` varchar(255) NOT NULL,
  `extra_info_artiest` text DEFAULT NULL,
  PRIMARY KEY (`artiest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artiesten`
--

LOCK TABLES `artiesten` WRITE;
/*!40000 ALTER TABLE `artiesten` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `artiesten` VALUES
(1,'test1','test1'),
(2,'test2',NULL),
(3,'Nirvana',''),
(4,'My Chemical Romance',NULL);
/*!40000 ALTER TABLE `artiesten` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `liedjes`
--

DROP TABLE IF EXISTS `liedjes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `liedjes` (
  `lied_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `titel_lied` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`lied_id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `liedjes_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liedjes`
--

LOCK TABLES `liedjes` WRITE;
/*!40000 ALTER TABLE `liedjes` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `liedjes` VALUES
(2,4,'The End\r\nDead!\r\nThis Is How To Disappear\r\nThe Sharpest Lives\r\nWelcome To The Black Parade\r\nI Don\'t Love You\r\nHouse Of Wolves\r\nCancer\r\nMama\r\nSleep\r\nTeenagers\r\nDisenchanted\r\nFamous Last Words');
/*!40000 ALTER TABLE `liedjes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `merch`
--

DROP TABLE IF EXISTS `merch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `merch` (
  `merch_id` int(11) NOT NULL AUTO_INCREMENT,
  `artiest_id` int(11) DEFAULT NULL,
  `naam_merch` varchar(255) NOT NULL,
  `extra_info_merch` text DEFAULT NULL,
  PRIMARY KEY (`merch_id`),
  KEY `artiest_id` (`artiest_id`),
  CONSTRAINT `merch_ibfk_1` FOREIGN KEY (`artiest_id`) REFERENCES `artiesten` (`artiest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merch`
--

LOCK TABLES `merch` WRITE;
/*!40000 ALTER TABLE `merch` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `merch` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-02-04 18:24:23
