-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entity_type` enum('Patient','Facility') NOT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `facility_id` bigint(20) unsigned DEFAULT NULL,
  `address` varchar(255) NOT NULL,
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
INSERT INTO `addresses` VALUES
(1,'Patient',2,NULL,'calle 2 #26-36, Bogota, 110111','2024-08-27 11:09:30','2024-08-27 11:09:30'),
(2,'Facility',NULL,3,'Calle 71 #11-07, Bogota, 110111','2024-08-27 11:10:15','2024-08-27 11:10:15'),
(3,'Patient',10,NULL,'4038 Grandin Rd. Lenoir,, NC, 28645','2024-08-30 15:47:36','2024-08-30 15:47:36'),
(4,'Patient',11,NULL,'2865 Sycamore Ct. Granite Falls, NC, 28630','2024-08-30 15:49:09','2024-08-30 15:49:09'),
(5,'Facility',NULL,4,'1208 Hickory Blvd. Lenoir, NC, 28645','2024-08-30 15:51:46','2024-08-30 15:51:46'),
(6,'Facility',NULL,5,'Peters Court High point, NC, 27265.','2024-08-30 15:52:49','2024-08-30 15:52:49'),
(7,'Facility',NULL,5,'Drop off: 3604 Peters Court High point, , NC, 27265','2024-08-30 22:19:36','2024-08-30 22:19:36'),
(8,'Facility',NULL,4,'Ak 68 # 49A - 47, Engativá, Bogotá, 110412','2024-08-30 22:20:29','2024-08-30 22:20:29'),
(9,'Facility',NULL,4,'Cl. 67 #10-06, Bogotá, 110121','2024-08-30 22:20:29','2024-08-30 22:20:29'),
(10,'Facility',NULL,4,'Cra. 7 #55 - 37, Chapinero, Bogotá, 110183','2024-08-30 22:20:29','2024-08-30 22:20:29');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `service_contract_id` int(11) DEFAULT NULL,
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
INSERT INTO `facilities` VALUES
(1,'Burke County Dept Social Services',2,'2024-08-02 03:57:46','2024-08-02 03:57:46'),
(3,'Novant Health Rowan Medical Center',3,'2024-08-03 21:40:51','2024-08-03 21:40:51'),
(4,'Compensar',1,'2024-08-30 15:51:46','2024-08-30 22:20:29'),
(5,'PRUEBA2',4,'2024-08-30 15:52:49','2024-08-30 22:42:26');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_seq` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sequence` int(11) NOT NULL DEFAULT 1,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2024_04_23_00000_create_vehicles_table',1),
(6,'2024_05_14_111713_create_service_contracts_table',1),
(7,'2024_05_21_040118_create_permission_tables',1),
(8,'2024_05_22_075648_create_patients_table',1),
(9,'2024_05_22_131223_create_facilities_table',1),
(10,'2024_05_28_112727_create_schedulings_table',1),
(11,'2024_06_05_003820_create_events_table',1),
(12,'2024_06_17_232704_create_address_table',1),
(13,'2024_07_31_121736_create_invoice_seq_table',1),
(14,'2024_08_05_220142_create_scheduling_address_table',1),
(15,'2024_08_05_220202_create_scheduling_charge_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
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
INSERT INTO `model_has_roles` VALUES
(1,'App\\Models\\User',1),
(1,'App\\Models\\User',2),
(1,'App\\Models\\User',3),
(2,'App\\Models\\User',4),
(2,'App\\Models\\User',5),
(2,'App\\Models\\User',6),
(2,'App\\Models\\User',7),
(2,'App\\Models\\User',8),
(2,'App\\Models\\User',9),
(2,'App\\Models\\User',10),
(2,'App\\Models\\User',11),
(2,'App\\Models\\User',12);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_contract_id` int(10) unsigned DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birth_date` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `medicalid` varchar(255) DEFAULT NULL,
  `billing_code` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
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
INSERT INTO `patients` VALUES
(1,1,'Sarah','Hamilton','1954-09-09','123123123','','12312312','A0120-Ambulatory','123123123','2024-08-01','2024-12-25','None','2024-08-02 03:57:08','2024-08-30 13:49:02'),
(2,3,'Dawn Perry','Lawson','1933-10-04','1029381','','12312312','A0130-Wheelchair','12312321','2024-08-02','2024-12-25','None','2024-08-03 01:51:33','2024-08-03 01:51:33'),
(3,3,'Michael','Wayne Litaker','1978-08-07','1231231','','123123','A0130-Wheelchair','123123','2024-08-02','2024-12-25','None','2024-08-03 01:54:36','2024-08-03 01:54:36'),
(4,3,'Jerry ','Dean Corl','2024-08-07','4013789','','12312312','A0130-Wheelchair','4013789','2024-08-02','2024-08-30','none','2024-08-03 05:05:47','2024-08-30 13:48:28'),
(5,3,'Betty','Ivey Cross','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-09','none','2024-08-03 05:07:32','2024-08-03 05:07:32'),
(6,3,'Ramona','Coppins Soto','2024-08-01','1231231231','','1231231231','A0130-Wheelchair','1231231231','2024-08-01','2024-08-30','none','2024-08-03 05:08:34','2024-08-03 05:08:34'),
(7,3,'Sylvia','Tart Ogni','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 05:09:54','2024-08-03 05:09:54'),
(8,3,'Raquel','Elyse Martinez','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-30','none','2024-08-03 21:13:14','2024-08-03 21:13:14'),
(9,3,'Gilberto','Rodriguez','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 21:14:17','2024-08-03 21:14:17'),
(10,1,'Virginia','Decker',NULL,'4544586989536','','789456-3',NULL,NULL,NULL,NULL,NULL,'2024-08-30 15:47:36','2024-08-30 15:47:36'),
(11,1,'W.Kelly','Pierce',NULL,'487984546','','7879456-9',NULL,NULL,NULL,NULL,NULL,'2024-08-30 15:49:09','2024-08-30 22:33:22'),
(12,1,'Dawn','Amett',NULL,'1546569','','789456-6',NULL,NULL,NULL,NULL,NULL,'2024-08-30 15:50:34','2024-08-30 15:50:34');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
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
INSERT INTO `permissions` VALUES
(1,'user.view','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(2,'user.create','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(3,'user.update','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(4,'user.delete','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(5,'role.view','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(6,'role.create','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(7,'role.update','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(8,'role.delete','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(9,'driver.view','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(10,'driver.create','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(11,'driver.update','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(12,'driver.delete','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(13,'vehicle.view','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(14,'vehicle.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(15,'vehicle.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(16,'vehicle.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(17,'facility.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(18,'facility.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(19,'facility.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(20,'facility.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(21,'servicecontract.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(22,'servicecontract.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(23,'servicecontract.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(24,'servicecontract.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(25,'patient.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(26,'patient.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(27,'patient.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(28,'patient.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(29,'scheduling.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(30,'scheduling.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(31,'scheduling.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(32,'scheduling.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(33,'report.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(34,'report.create','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(35,'report.update','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(36,'report.delete','web','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(37,'dashboard.view','web','2024-08-30 03:11:23','2024-08-30 03:11:23');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
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
INSERT INTO `role_has_permissions` VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,1),
(23,1),
(24,1),
(25,1),
(26,1),
(27,1),
(28,1),
(29,1),
(30,1),
(31,1),
(32,1),
(33,1),
(34,1),
(35,1),
(36,1),
(37,1),
(37,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
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
INSERT INTO `roles` VALUES
(1,'Admin','web','2024-08-30 03:11:22','2024-08-30 03:11:22'),
(2,'Driver','web','2024-08-30 03:11:22','2024-08-30 03:11:22');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_address`
--

DROP TABLE IF EXISTS `scheduling_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduling_address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `scheduling_id` int(10) unsigned DEFAULT NULL,
  `driver_id` int(10) unsigned DEFAULT NULL,
  `pick_up_address` varchar(255) DEFAULT NULL,
  `drop_off_address` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `pick_up_hour` varchar(255) DEFAULT NULL,
  `drop_off_hour` varchar(255) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `type_of_trip` varchar(255) DEFAULT NULL,
  `request_by` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_address`
--

LOCK TABLES `scheduling_address` WRITE;
/*!40000 ALTER TABLE `scheduling_address` DISABLE KEYS */;
INSERT INTO `scheduling_address` VALUES
(1,1,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-08-30','11:40','11:50','6.0','24','pick_up','','In Progress',NULL,'2024-08-30 03:21:36','2024-08-30 13:31:56'),
(2,1,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-08-30','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(3,2,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-02','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(4,2,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-02','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(5,3,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-06','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(6,3,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-06','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(7,4,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-09','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(8,4,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-09','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(9,5,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-13','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(10,5,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-13','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(11,6,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-16','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(12,6,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-16','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(13,7,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-20','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(14,7,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-20','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(15,8,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-23','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(16,8,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-23','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(17,9,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-27','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(18,9,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-27','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(19,10,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-09-30','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(20,10,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-09-30','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(21,11,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-04','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(22,11,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-04','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(23,12,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-07','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(24,12,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-07','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(25,13,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-11','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(26,13,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-11','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(27,14,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-14','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(28,14,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-14','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(29,15,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-18','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(30,15,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-18','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(31,16,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-21','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(32,16,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-21','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(33,17,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-25','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(34,17,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-25','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(35,18,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-10-28','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(36,18,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-10-28','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(37,19,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-01','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(38,19,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-01','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(39,20,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-04','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(40,20,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-04','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(41,21,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-08','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(42,21,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-08','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(43,22,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-11','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(44,22,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-11','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(45,23,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-15','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(46,23,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-15','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(47,24,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-18','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(48,24,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-18','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(49,25,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-22','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(50,25,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-22','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(51,26,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-25','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(52,26,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-25','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(53,27,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-11-29','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(54,27,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-11-29','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(55,28,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-02','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(56,28,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-02','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(57,29,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-06','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(58,29,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-06','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(59,30,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-09','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(60,30,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-09','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(61,31,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-13','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(62,31,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-13','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(63,32,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-16','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(64,32,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-16','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(65,33,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-20','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(66,33,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-20','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(67,34,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-23','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(68,34,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-23','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(69,35,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-27','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(70,35,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-27','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(71,36,4,'calle 2 #26-36, Bogota, 110111','Calle 71 #11-07, Bogota, 110111','2024-12-30','11:40','11:50','6.0','24','pick_up','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(72,36,4,'Calle 71 #11-07, Bogota, 110111','calle 2 #26-36, Bogota, 110111','2024-12-30','12:30','12:40','6.6','27','return','','Waiting',NULL,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(73,37,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-08-30','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(74,37,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-08-30','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(75,38,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-03','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(76,38,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-03','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(77,39,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-06','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(78,39,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-06','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(79,40,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-10','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(80,40,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-10','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(81,41,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-13','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(82,41,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-13','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(83,42,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-17','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(84,42,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-17','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(85,43,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-20','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(86,43,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-20','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(87,44,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-24','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(88,44,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-24','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(89,45,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-27','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(90,45,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-27','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(91,46,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-01','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(92,46,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-01','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(93,47,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-04','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(94,47,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-04','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(95,48,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-08','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(96,48,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-08','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(97,49,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-11','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(98,49,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-11','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(99,50,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-15','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(100,50,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-15','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(101,51,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-18','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(102,51,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-18','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(103,52,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-22','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(104,52,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-22','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(105,53,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-25','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(106,53,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-25','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(107,54,5,'4038 Grandin Rd. Lenoir,, NC, 28645','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-10-29','00:00','00:10','11.2','15','pick_up',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(108,54,5,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-10-29','14:00','14:10','11.3','15','return',NULL,'Waiting',NULL,'2024-08-30 15:58:57','2024-08-30 15:58:57');
/*!40000 ALTER TABLE `scheduling_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_charge`
--

DROP TABLE IF EXISTS `scheduling_charge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduling_charge` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `scheduling_id` int(10) unsigned NOT NULL,
  `type_of_trip` varchar(255) DEFAULT NULL,
  `wheelchair` tinyint(1) DEFAULT 0,
  `ambulatory` tinyint(1) DEFAULT 0,
  `out_of_hours` tinyint(1) DEFAULT 0,
  `saturdays` tinyint(1) DEFAULT 0,
  `sundays_holidays` tinyint(1) DEFAULT 0,
  `companion` tinyint(1) DEFAULT 0,
  `aditional_waiting` tinyint(1) DEFAULT 0,
  `fast_track` tinyint(1) DEFAULT 0,
  `if_not_cancel` tinyint(1) DEFAULT 0,
  `collect_cancel` tinyint(1) DEFAULT 0,
  `overcharge` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_charge`
--

LOCK TABLES `scheduling_charge` WRITE;
/*!40000 ALTER TABLE `scheduling_charge` DISABLE KEYS */;
INSERT INTO `scheduling_charge` VALUES
(1,1,'round_trip',1,0,0,0,0,0,0,0,0,1,0,'2024-08-30 03:21:36','2024-08-30 03:32:12'),
(2,2,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(3,3,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(4,4,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(5,5,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(6,6,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(7,7,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(8,8,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(9,9,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(10,10,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(11,11,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(12,12,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(13,13,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(14,14,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(15,15,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(16,16,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(17,17,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(18,18,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(19,19,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(20,20,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(21,21,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(22,22,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(23,23,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(24,24,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(25,25,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(26,26,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(27,27,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(28,28,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(29,29,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(30,30,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(31,31,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(32,32,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(33,33,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(34,34,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(35,35,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(36,36,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(37,37,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(38,38,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(39,39,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(40,40,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(41,41,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(42,42,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(43,43,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(44,44,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(45,45,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(46,46,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(47,47,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(48,48,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(49,49,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(50,50,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(51,51,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(52,52,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(53,53,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(54,54,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 15:58:57','2024-08-30 15:58:57'),
(55,55,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 16:00:27','2024-08-30 16:00:27'),
(56,56,'',0,1,0,0,0,0,0,0,0,0,0,'2024-08-30 16:10:31','2024-08-30 16:10:31');
/*!40000 ALTER TABLE `scheduling_charge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedulings`
--

DROP TABLE IF EXISTS `schedulings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedulings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL,
  `auto_agend` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedulings`
--

LOCK TABLES `schedulings` WRITE;
/*!40000 ALTER TABLE `schedulings` DISABLE KEYS */;
INSERT INTO `schedulings` VALUES
(1,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(2,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(3,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(4,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(5,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(6,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(7,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(8,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(9,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(10,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(11,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(12,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(13,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(14,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(15,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(16,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(17,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(18,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(19,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(20,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(21,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(22,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(23,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(24,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(25,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(26,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(27,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(28,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(29,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(30,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(31,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(32,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(33,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(34,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(35,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36'),
(36,2,1,'2024-08-30 03:21:36','2024-08-30 03:21:36');
/*!40000 ALTER TABLE `schedulings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_contracts`
--

DROP TABLE IF EXISTS `service_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_contracts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) NOT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `wheelchair` int(11) DEFAULT 0,
  `ambulatory` int(11) DEFAULT 0,
  `out_of_hours` int(11) DEFAULT 0,
  `saturdays` int(11) DEFAULT 0,
  `sundays_holidays` int(11) DEFAULT 0,
  `companion` int(11) DEFAULT 0,
  `additional_waiting` int(11) DEFAULT 0,
  `after` int(11) DEFAULT 0,
  `fast_track` int(11) DEFAULT 0,
  `if_not_cancel` int(11) DEFAULT 0,
  `rate_per_mile` int(11) DEFAULT 0,
  `overcharge` int(11) DEFAULT 0,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
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
INSERT INTO `service_contracts` VALUES
(1,'Caldwell County','Caldwell County',120,55,45,65,85,35,35,0,15,0,4,0,'Medicaid Transportation NEMT PO Box 200 Lenoir, NC 28645','(828) 426-8217','Active','2023-07-28','2023-07-28','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(2,'Burke County','Burke County',120,55,45,65,85,25,35,0,15,0,4,0,'700 East Parker Road Morganton, NC 28655','(828) 764-9612','Active','2023-07-28','2023-07-28','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(3,'Novant Health Rowan Medical Center','Novant Health',95,55,45,65,85,15,35,0,15,0,4,0,'123 Main St.','123456789','Active','2023-07-28','2023-07-28','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(4,'Carteret County','Carteret County',120,55,45,65,85,25,35,0,15,0,4,0,'123 Main St.','123456789','Active','2023-07-28','2023-07-28','2024-08-30 03:11:23','2024-08-30 03:11:23');
/*!40000 ALTER TABLE `service_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `dl_state` varchar(255) DEFAULT NULL,
  `dl_number` varchar(255) DEFAULT NULL,
  `date_of_hire` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin@material.com','2024-08-30 03:11:23',NULL,'$2y$10$8O/MpiS0Mr0Y4YIqVN3d9e/Q/olzAOfP2.vN2u4PrAi0x8Oso4YkS','eNAgiUggN9Cm2SQ3FTBr5m1efrK02eSFs97YwjiWOwbQSEJTjR4h1WlLilGI','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(2,'Laura ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'laura@material.com','2024-08-30 03:11:23',NULL,'$2y$10$RWFC5LzAoQ3bA4sBIRZPs.11VytWuthPx3O6b1Z4nogzEhFvWUtbK','yEy9getCjO','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(3,'Cony',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'cony@material.com','2024-08-30 03:11:23',NULL,'$2y$10$oNhQtIPvbnvUO3gHxZDvRua2wZSMXcUy7S40bU/JTvlew97O7sfkC','E1R2T4LMeH','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(4,'Carlos Hernandez',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'carlos@material.com','2024-08-30 03:11:23',NULL,'$2y$10$AmtzAqLgofv0p3DwFx0bpOHJHL0NDsKMGDQoN7LG5XK9Q6KZY.qDK','U0iu0Jp3V7R4ZnO5UEVrOkSIye5FnaFUJwfdkW5kdZBWsjtTsl9QpanJA8Jo','2024-08-30 03:11:23','2024-08-30 03:11:23'),
(5,'Miguel Chavez','1979-06-24','NC','32581474','Owner',NULL,NULL,NULL,'miguel_chavez@example.com',NULL,NULL,'$2y$10$SGQtaMl9pEHPMyNAQb/wU.e36NPpPd52SMWRBHnZa5IdTK/vtkg4e',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(6,'Laura Chavez','1987-01-23','NC','36083553','Owner',NULL,NULL,NULL,'laura_chavez@example.com',NULL,NULL,'$2y$10$3Vk2GbQlEiyICDwQKYHvW.bTNQ0Gpguj22np4JO6YQSiSzweFSeuK',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(7,'Ger Yang','1994-05-27','NC','33975298','2023-07-28',NULL,NULL,NULL,'ger_yang@example.com',NULL,NULL,'$2y$10$oDyX8mlk6/QQXn8/y/Cz1.6x1OYGn1gCioKFxVpznbc0R5ZkkCzd6',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(8,'Freddy Nieto','1970-08-17','NC','29050340','2023-08-25',NULL,NULL,NULL,'freddy_nieto@example.com',NULL,NULL,'$2y$10$GERx7X61gntbes2KUTCoCe9ixe2Q/L6MpWolGk7he9IKNzGKqmrLK',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(9,'Wilmar Jimenez','1982-07-10','NC','35825495','2023-11-25',NULL,NULL,NULL,'wilmar_jimenez@example.com',NULL,NULL,'$2y$10$86qyQ2v.6moK765VxyQvlu7v7U1kMi0sU6te5tMAFy.D3shxSz/w6',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(10,'Omar Rodriguez','1986-07-22','NC','42514740','2024-01-22',NULL,NULL,NULL,'omar_rodriguez@example.com',NULL,NULL,'$2y$10$8A6WVpJBD8zLkcD8r3Kfq.lmMSzO2p8Z7BYjXb8sRfhPfuqQiPP4W',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(11,'Judy Hemric','1959-10-31','NC','24998006','2024-03-13',NULL,NULL,NULL,'judy_hemric@example.com',NULL,NULL,'$2y$10$UxiPP1MuR0XHy0FcvN0vMeRa/J6A4AYbYsspMQ0V2grO2Whnwtv7G',NULL,'2024-08-30 03:11:23','2024-08-30 03:11:23'),
(12,'Constanza Velez',NULL,NULL,NULL,NULL,'1236987',NULL,NULL,'constanzavelezb@gmail.com',NULL,NULL,'$2y$10$sPCJPsRhPdeb0AcCsbKgy.NQz16Vri29CaRjmaAxM8mBHAPjAD9xy',NULL,'2024-08-30 15:34:37','2024-08-30 15:34:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(255) DEFAULT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `vin` varchar(255) DEFAULT NULL,
  `number_vehicle` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
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
INSERT INTO `vehicles` VALUES
(1,'2006','Toyota','Sienna','5TDZA23C56S566778',1,4,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(2,'2010','Ford','Econoline','1FDEE3FL1ADA68677',2,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(3,'2006','Ford','Econoline','1FTSS34L56HB31363',3,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(4,'2023','Chevy','Suburban','1GNSKEKD9PR238670',4,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(5,'2020','Toyota','Sienna','5TDKZ3DC2LS029988',5,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(6,'2020','Toyota','Sienna','5TDYZ3DC4LS053218',6,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51'),
(7,'2007','Ford','Econoline','1FBSS31L57DB34734',7,NULL,'2024-08-02 03:55:51','2024-08-02 03:55:51');
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

-- Dump completed on 2024-08-30 22:47:23
