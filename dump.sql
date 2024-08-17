-- MySQL dump 10.13  Distrib 8.3.0, for macos14.2 (arm64)
--
-- Host: localhost    Database: sdh_livewire
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_contract_id` int unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medicalid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `observations` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,1,'Sarah','Hamilton','1954-09-09','123123123','','123123123','A0120-Ambulatory','123123123','2024-08-01','2024-12-25','None','2024-08-02 03:57:08','2024-08-02 03:57:08'),(2,3,'Dawn Perry','Lawson','1933-10-04','1029381','','12312312','A0130-Wheelchair','12312321','2024-08-02','2024-12-25','None','2024-08-03 01:51:33','2024-08-03 01:51:33'),(3,3,'Michael','Wayne Litaker','1978-08-07','1231231','','123123','A0130-Wheelchair','123123','2024-08-02','2024-12-25','None','2024-08-03 01:54:36','2024-08-03 01:54:36'),(4,3,'Jerry ','Dean Corl','2024-08-07','4013789','','4013789','A0130-Wheelchair','4013789','2024-08-02','2024-08-30','none','2024-08-03 05:05:47','2024-08-03 05:05:47'),(5,3,'Betty','Ivey Cross','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-09','none','2024-08-03 05:07:32','2024-08-03 05:07:32'),(6,3,'Ramona','Coppins Soto','2024-08-01','1231231231','','1231231231','A0130-Wheelchair','1231231231','2024-08-01','2024-08-30','none','2024-08-03 05:08:34','2024-08-03 05:08:34'),(7,3,'Sylvia','Tart Ogni','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 05:09:54','2024-08-03 05:09:54'),(8,3,'Raquel','Elyse Martinez','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-30','none','2024-08-03 21:13:14','2024-08-03 21:13:14'),(9,3,'Gilberto','Rodriguez','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 21:14:17','2024-08-03 21:14:17');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES (1,'Burke County Dept Social Services','2024-08-02 03:57:46','2024-08-02 03:57:46'),(3,'Novant Health Rowan Medical Center','2024-08-03 21:40:51','2024-08-03 21:40:51');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_vehicle` int DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'2006','Toyota','Sienna','5TDZA23C56S566778',1,4,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(2,'2010','Ford','Econoline','1FDEE3FL1ADA68677',2,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(3,'2006','Ford','Econoline','1FTSS34L56HB31363',3,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(4,'2023','Chevy','Suburban','1GNSKEKD9PR238670',4,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(5,'2020','Toyota','Sienna','5TDKZ3DC2LS029988',5,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(6,'2020','Toyota','Sienna','5TDYZ3DC4LS053218',6,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),(7,'2007','Ford','Econoline','1FBSS31L57DB34734',7,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51');
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-05 17:17:54
