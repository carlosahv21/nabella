-- MySQL dump 10.13  Distrib 9.0.1, for macos14.4 (arm64)
--
-- Host: localhost    Database: sdh_livewire
-- ------------------------------------------------------
-- Server version	9.0.1

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `entity_type` enum('Patient','Facility') COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint unsigned DEFAULT NULL,
  `facility_id` bigint unsigned DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_patient_id_foreign` (`patient_id`),
  KEY `addresses_facility_id_foreign` (`facility_id`),
  CONSTRAINT `addresses_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  CONSTRAINT `addresses_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,'Patient',2,NULL,'calle 2 #26-36, Bogota, 110111','2024-08-27 16:09:30','2024-08-27 16:09:30'),(2,'Facility',NULL,3,'Calle 71 #11-07, Bogota, 110111','2024-08-27 16:10:15','2024-08-27 16:10:15'),(3,'Patient',10,NULL,'4038 Grandin Rd. Lenoir,, NC, 28645','2024-08-30 20:47:36','2024-08-30 20:47:36'),(4,'Patient',11,NULL,'2865 Sycamore Ct. Granite Falls, NC, 28630','2024-08-30 20:49:09','2024-08-30 20:49:09'),(5,'Facility',NULL,4,'1208 Hickory Blvd. Lenoir, NC, 28645','2024-08-30 20:51:46','2024-08-30 20:51:46'),(6,'Facility',NULL,5,'Peters Court High point, NC, 27265.','2024-08-30 20:52:49','2024-08-30 20:52:49'),(7,'Facility',NULL,5,'Drop off: 3604 Peters Court High point, , NC, 27265','2024-08-31 03:19:36','2024-08-31 03:19:36'),(8,'Facility',NULL,4,'Ak 68 # 49A - 47, Engativá, Bogotá, 110412','2024-08-31 03:20:29','2024-08-31 03:20:29'),(9,'Facility',NULL,4,'Cl. 67 #10-06, Bogotá, 110121','2024-08-31 03:20:29','2024-08-31 03:20:29'),(10,'Facility',NULL,4,'Cra. 7 #55 - 37, Chapinero, Bogotá, 110183','2024-08-31 03:20:29','2024-08-31 03:20:29');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
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
  `service_contract_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES (1,'Burke County Dept Social Services',2,'2024-08-02 08:57:46','2024-08-02 08:57:46'),(3,'Novant Health Rowan Medical Center',3,'2024-08-04 02:40:51','2024-08-04 02:40:51'),(4,'Compensar',1,'2024-08-30 20:51:46','2024-08-31 03:20:29'),(5,'PRUEBA2',4,'2024-08-30 20:52:49','2024-08-31 03:42:26');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_seq`
--

DROP TABLE IF EXISTS `invoice_seq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_seq` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sequence` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_seq`
--

LOCK TABLES `invoice_seq` WRITE;
/*!40000 ALTER TABLE `invoice_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_04_23_00000_create_vehicles_table',1),(6,'2024_05_14_111713_create_service_contracts_table',1),(7,'2024_05_21_040118_create_permission_tables',1),(8,'2024_05_22_075648_create_patients_table',1),(9,'2024_05_22_131223_create_facilities_table',1),(10,'2024_05_28_112727_create_schedulings_table',1),(11,'2024_06_05_003820_create_events_table',1),(12,'2024_06_17_232704_create_address_table',1),(13,'2024_07_31_121736_create_invoice_seq_table',1),(14,'2024_08_05_220142_create_scheduling_address_table',1),(15,'2024_08_05_220202_create_scheduling_charge_table',1),(16,'2024_09_10_085343_create_scheduling_autoagend_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(1,'App\\Models\\User',2),(1,'App\\Models\\User',3),(2,'App\\Models\\User',4),(2,'App\\Models\\User',5),(2,'App\\Models\\User',6),(2,'App\\Models\\User',7),(2,'App\\Models\\User',8),(2,'App\\Models\\User',9),(2,'App\\Models\\User',10),(2,'App\\Models\\User',11);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,1,'Sarah','Hamilton','1954-09-09','123123123','','12312312','A0120-Ambulatory','123123123','2024-08-01','2024-12-25','None','2024-08-02 08:57:08','2024-08-30 18:49:02'),(2,3,'Dawn Perry','Lawson','1933-10-04','1029381','','12312312','A0130-Wheelchair','12312321','2024-08-02','2024-12-25','None','2024-08-03 06:51:33','2024-08-03 06:51:33'),(3,3,'Michael','Wayne Litaker','1978-08-07','1231231','','123123','A0130-Wheelchair','123123','2024-08-02','2024-12-25','None','2024-08-03 06:54:36','2024-08-03 06:54:36'),(4,3,'Jerry ','Dean Corl','2024-08-07','4013789','','12312312','A0130-Wheelchair','4013789','2024-08-02','2024-08-30','none','2024-08-03 10:05:47','2024-08-30 18:48:28'),(5,3,'Betty','Ivey Cross','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-09','none','2024-08-03 10:07:32','2024-08-03 10:07:32'),(6,3,'Ramona','Coppins Soto','2024-08-01','1231231231','','1231231231','A0130-Wheelchair','1231231231','2024-08-01','2024-08-30','none','2024-08-03 10:08:34','2024-08-03 10:08:34'),(7,3,'Sylvia','Tart Ogni','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 10:09:54','2024-08-03 10:09:54'),(8,3,'Raquel','Elyse Martinez','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-30','none','2024-08-04 02:13:14','2024-08-04 02:13:14'),(9,3,'Gilberto','Rodriguez','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-04 02:14:17','2024-08-04 02:14:17'),(10,1,'Virginia','Decker',NULL,'4544586989536','','789456-3',NULL,NULL,NULL,NULL,NULL,'2024-08-30 20:47:36','2024-08-30 20:47:36'),(11,1,'W.Kelly','Pierce',NULL,'487984546','','7879456-9',NULL,NULL,NULL,NULL,NULL,'2024-08-30 20:49:09','2024-08-31 03:33:22'),(12,1,'Dawn','Amett',NULL,'1546569','','789456-6',NULL,NULL,NULL,NULL,NULL,'2024-08-30 20:50:34','2024-08-30 20:50:34');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'user.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(2,'user.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(3,'user.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(4,'user.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(5,'role.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(6,'role.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(7,'role.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(8,'role.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(9,'driver.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(10,'driver.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(11,'driver.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(12,'driver.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(13,'vehicle.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(14,'vehicle.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(15,'vehicle.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(16,'vehicle.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(17,'facility.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(18,'facility.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(19,'facility.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(20,'facility.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(21,'servicecontract.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(22,'servicecontract.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(23,'servicecontract.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(24,'servicecontract.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(25,'patient.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(26,'patient.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(27,'patient.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(28,'patient.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(29,'scheduling.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(30,'scheduling.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(31,'scheduling.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(32,'scheduling.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(33,'report.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(34,'report.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(35,'report.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(36,'report.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(37,'dashboard.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(37,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),(2,'Driver','web','2024-09-10 15:05:24','2024-09-10 15:05:24');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_address`
--

DROP TABLE IF EXISTS `scheduling_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scheduling_address` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `scheduling_id` int unsigned DEFAULT NULL,
  `scheduling_autoagend_id` int unsigned DEFAULT NULL,
  `driver_id` int unsigned DEFAULT NULL,
  `pick_up_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drop_off_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `pick_up_hour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drop_off_hour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_trip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_milles` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_address`
--

LOCK TABLES `scheduling_address` WRITE;
/*!40000 ALTER TABLE `scheduling_address` DISABLE KEYS */;
INSERT INTO `scheduling_address` VALUES (1,1,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-11','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(2,1,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-11','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(3,2,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-14','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(4,2,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-14','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(5,3,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-18','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(6,3,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-18','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(7,4,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-21','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(8,4,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-21','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(9,5,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-25','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(10,5,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-25','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(11,6,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-09-28','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(12,6,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-09-28','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(13,7,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-02','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(14,7,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-02','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(15,8,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-05','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(16,8,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-05','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(17,9,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-09','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(18,9,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-09','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(19,10,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-12','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(20,10,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-12','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(21,11,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-16','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(22,11,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-16','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(23,12,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-19','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(24,12,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-19','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(25,13,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-23','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(26,13,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-23','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(27,14,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-26','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(28,14,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-26','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(29,15,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-10-30','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(30,15,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-10-30','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(31,16,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-02','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(32,16,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-02','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(33,17,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-06','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(34,17,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-06','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(35,18,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-09','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(36,18,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-09','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(37,19,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-13','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(38,19,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-13','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(39,20,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-16','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(40,20,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-16','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(41,21,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-20','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(42,21,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-20','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(43,22,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-23','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(44,22,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-23','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(45,23,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-27','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(46,23,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-27','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(47,24,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-11-30','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(48,24,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-11-30','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(49,25,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-04','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(50,25,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-04','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(51,26,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-07','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(52,26,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-07','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(53,27,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-11','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(54,27,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-11','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(55,28,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-14','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(56,28,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-14','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(57,29,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-18','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(58,29,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-18','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(59,30,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-21','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(60,30,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-21','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(61,31,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-25','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(62,31,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-25','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(63,32,1,7,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd. Lenoir, NC, 28645','2024-12-28','11:00','11:10','11.2','15','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(64,32,1,7,'1208 Hickory Blvd. Lenoir, NC, 28645','4038 Grandin Rd. Lenoir,, NC, 28645','2024-12-28','12:00','12:10','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-10 15:07:43','2024-09-10 15:07:43');
/*!40000 ALTER TABLE `scheduling_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_autoagend`
--

DROP TABLE IF EXISTS `scheduling_autoagend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scheduling_autoagend` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_autoagend`
--

LOCK TABLES `scheduling_autoagend` WRITE;
/*!40000 ALTER TABLE `scheduling_autoagend` DISABLE KEYS */;
INSERT INTO `scheduling_autoagend` VALUES (1,'2024-09-10 15:05:25','2024-09-10 15:05:25');
/*!40000 ALTER TABLE `scheduling_autoagend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_charge`
--

DROP TABLE IF EXISTS `scheduling_charge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scheduling_charge` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `scheduling_id` int unsigned NOT NULL,
  `type_of_trip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wheelchair` tinyint(1) DEFAULT '0',
  `ambulatory` tinyint(1) DEFAULT '0',
  `out_of_hours` tinyint(1) DEFAULT '0',
  `saturdays` tinyint(1) DEFAULT '0',
  `sundays_holidays` tinyint(1) DEFAULT '0',
  `companion` tinyint(1) DEFAULT '0',
  `aditional_waiting` tinyint(1) DEFAULT '0',
  `fast_track` tinyint(1) DEFAULT '0',
  `if_not_cancel` tinyint(1) DEFAULT '0',
  `collect_cancel` tinyint(1) DEFAULT '0',
  `overcharge` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_charge`
--

LOCK TABLES `scheduling_charge` WRITE;
/*!40000 ALTER TABLE `scheduling_charge` DISABLE KEYS */;
INSERT INTO `scheduling_charge` VALUES (1,1,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(2,2,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(3,3,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(4,4,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(5,5,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(6,6,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(7,7,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(8,8,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(9,9,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(10,10,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(11,11,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(12,12,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(13,13,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(14,14,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(15,15,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(16,16,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(17,17,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(18,18,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(19,19,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(20,20,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(21,21,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(22,22,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(23,23,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(24,24,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(25,25,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(26,26,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(27,27,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(28,28,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(29,29,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(30,30,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(31,31,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43'),(32,32,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-10 15:07:43','2024-09-10 15:07:43');
/*!40000 ALTER TABLE `scheduling_charge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedulings`
--

DROP TABLE IF EXISTS `schedulings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedulings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int unsigned NOT NULL,
  `auto_agend` tinyint(1) NOT NULL DEFAULT '0',
  `select_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ends_schedule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedulings`
--

LOCK TABLES `schedulings` WRITE;
/*!40000 ALTER TABLE `schedulings` DISABLE KEYS */;
INSERT INTO `schedulings` VALUES (1,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(2,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(3,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(4,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(5,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(6,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(7,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(8,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(9,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(10,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(11,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(12,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(13,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(14,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(15,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(16,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(17,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(18,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(19,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(20,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(21,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(22,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(23,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(24,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(25,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(26,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(27,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(28,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(29,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(30,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(31,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43'),(32,10,1,'Wednesday,Saturday','never','2024-12-31','2024-09-10 15:07:43','2024-09-10 15:07:43');
/*!40000 ALTER TABLE `schedulings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_contracts`
--

DROP TABLE IF EXISTS `service_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wheelchair` int DEFAULT '0',
  `ambulatory` int DEFAULT '0',
  `out_of_hours` int DEFAULT '0',
  `saturdays` int DEFAULT '0',
  `sundays_holidays` int DEFAULT '0',
  `companion` int DEFAULT '0',
  `additional_waiting` int DEFAULT '0',
  `after` int DEFAULT '0',
  `fast_track` int DEFAULT '0',
  `if_not_cancel` int DEFAULT '0',
  `rate_per_mile` int DEFAULT '0',
  `overcharge` int DEFAULT '0',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_contracts`
--

LOCK TABLES `service_contracts` WRITE;
/*!40000 ALTER TABLE `service_contracts` DISABLE KEYS */;
INSERT INTO `service_contracts` VALUES (1,'Caldwell County','Caldwell County',120,55,45,65,85,35,35,0,15,0,4,0,'Medicaid Transportation NEMT PO Box 200 Lenoir, NC 28645','(828) 426-8217','Active','2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),(2,'Burke County','Burke County',120,55,45,65,85,25,35,0,15,0,4,0,'700 East Parker Road Morganton, NC 28655','(828) 764-9612','Active','2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),(3,'Novant Health Rowan Medical Center','Novant Health',95,55,45,65,85,15,35,0,15,0,4,0,'123 Main St.','123456789','Active','2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),(4,'Carteret County','Carteret County',120,55,45,65,85,25,35,0,15,0,4,0,'123 Main St.','123456789','Active','2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25');
/*!40000 ALTER TABLE `service_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `dl_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dl_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_hire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin@material.com','2024-09-10 15:05:24',NULL,'$2y$10$euSdZ5zGcn2jVMbuwM1hv..H425Ty5qO4TdEATF167oPQU8Tw.Ida','BG8svBy1Ub','2024-09-10 15:05:24','2024-09-10 15:05:24'),(2,'Laura ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'laura@material.com','2024-09-10 15:05:24',NULL,'$2y$10$vVWo/6kuo/O3cJgyBjpQHutTdhxBQa7Q3Qw80ZKqHA0Zmtlzq.sKO','RWGFJIZCnu','2024-09-10 15:05:24','2024-09-10 15:05:24'),(3,'Cony',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'cony@material.com','2024-09-10 15:05:24',NULL,'$2y$10$OUDL2E4QerLs9NQ3XriTTeJReHfV4vmknA0Lf0cV7Dxh2w28iYTJG','aNTImqESQZ','2024-09-10 15:05:24','2024-09-10 15:05:24'),(4,'Carlos Hernandez',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'carlos@material.com','2024-09-10 15:05:24',NULL,'$2y$10$8rMwT0pAt4mF5jghiMSY1eyFb2uJmu.2KHSEqJKA0HqoC5ibipfSO','IkFNBBQMVU','2024-09-10 15:05:24','2024-09-10 15:05:24'),(5,'Miguel Chavez','1979-06-24','NC','32581474','Owner',NULL,NULL,NULL,'miguel_chavez@example.com',NULL,NULL,'$2y$10$f0N9neqdKIehudtUhGiYwuG.yOCKlFj1lh0Ir8pb6sD/L15B9HuPG',NULL,'2024-09-10 15:05:24','2024-09-10 15:05:24'),(6,'Laura Chavez','1987-01-23','NC','36083553','Owner',NULL,NULL,NULL,'laura_chavez@example.com',NULL,NULL,'$2y$10$hJWNaPC1Ufy4RiHDR65GdO4gngZ30hxlsdu291GixkxzxbbLeK8YK',NULL,'2024-09-10 15:05:24','2024-09-10 15:05:24'),(7,'Ger Yang','1994-05-27','NC','33975298','2023-07-28',NULL,NULL,NULL,'ger_yang@example.com',NULL,NULL,'$2y$10$vIX6usAjytntoop7VGe/CuwoOofIapb9dPoXeY6ep9zmFK3w.dtjS',NULL,'2024-09-10 15:05:24','2024-09-10 15:05:24'),(8,'Freddy Nieto','1970-08-17','NC','29050340','2023-08-25',NULL,NULL,NULL,'freddy_nieto@example.com',NULL,NULL,'$2y$10$Tgd3SZpowc/jRZq9ipXtjui5X1ZfjGV5i4/yVr86fEjNF6yJhJY1e',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(9,'Wilmar Jimenez','1982-07-10','NC','35825495','2023-11-25',NULL,NULL,NULL,'wilmar_jimenez@example.com',NULL,NULL,'$2y$10$enrZcGELfEKk1xE9NTu0nekWmb8BZ5WFJb0XnxxEQQ2Y3/M/Z2.A6',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(10,'Omar Rodriguez','1986-07-22','NC','42514740','2024-01-22',NULL,NULL,NULL,'omar_rodriguez@example.com',NULL,NULL,'$2y$10$er7C/g6BZHEucaMqkc7/Qeuw3QUUxvwwhvx0gN4gvoWoWnZgka1gW',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(11,'Judy Hemric','1959-10-31','NC','24998006','2024-03-13',NULL,NULL,NULL,'judy_hemric@example.com',NULL,NULL,'$2y$10$Gy.fSMrjCMZlyfbw31OCse0Ef6FhkU0tvXnOEhLRq5E.56pId4DCW',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES (1,'2006','Toyota','Sienna','5TDZA23C56S566778',1,4,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(2,'2010','Ford','Econoline','1FDEE3FL1ADA68677',2,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(3,'2006','Ford','Econoline','1FTSS34L56HB31363',3,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(4,'2023','Chevy','Suburban','1GNSKEKD9PR238670',4,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(5,'2020','Toyota','Sienna','5TDKZ3DC2LS029988',5,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(6,'2020','Toyota','Sienna','5TDYZ3DC4LS053218',6,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),(7,'2007','Ford','Econoline','1FBSS31L57DB34734',7,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25');
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

-- Dump completed on 2024-09-10  5:08:57
