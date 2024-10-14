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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES
(4,'Patient',11,NULL,'2865 Sycamore Ct. Granite Falls, NC, 28630','2024-08-30 20:49:09','2024-08-30 20:49:09'),
(12,'Patient',15,NULL,'557 Brookdale Dr. Statesville, NC, 28677.','2024-09-10 13:28:58','2024-09-10 13:28:58'),
(13,'Patient',13,NULL,'557 Brookdale Drive Statesville, NC,  28677','2024-09-10 13:33:07','2024-09-10 13:33:07'),
(14,'Patient',16,NULL,'4038 Grandin Rd. Lenoir, NC, 28645','2024-09-12 19:09:03','2024-09-12 19:09:03'),
(15,'Patient',17,NULL,'431 Vance St. NW Apt 25. Lenoir, NC, 28645','2024-09-12 19:10:55','2024-09-12 19:10:55'),
(16,'Facility',NULL,6,'Medicaid Transportation NEMT PO Box 200 Lenoir, NC, 28645','2024-09-17 07:16:47','2024-09-17 07:16:47'),
(17,'Patient',12,NULL,'307 Kristin LN, Hudson, NC, 28638','2024-09-17 23:21:08','2024-09-17 23:21:08'),
(18,'Patient',19,NULL,'2835 Rutherford College Rd. Connelly Springs,, NC, 2612','2024-09-20 20:25:18','2024-09-20 20:25:18'),
(20,'Patient',22,NULL,'220 Falls Street Apt. K Morganton,, NC, 28655','2024-09-20 20:29:34','2024-09-20 20:29:34'),
(21,'Patient',23,NULL,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','2024-09-20 20:29:53','2024-09-20 20:29:53'),
(22,'Patient',24,NULL,'101 Sherwood Dr. Morganton,, NC, 28655','2024-09-20 20:31:14','2024-09-20 20:31:14'),
(23,'Patient',25,NULL,'1945 Tucker St. Apt. 3 Hickory, NC, 27601','2024-09-20 20:32:04','2024-09-20 20:32:04'),
(24,'Patient',26,NULL,': 318 Walker Rd. #8 Morganton, NC, 28655','2024-09-20 20:33:18','2024-09-20 20:33:18'),
(25,'Patient',27,NULL,': 2400 Mourglea Ave. SE Apt. 6G Valdese, NC,  28690','2024-09-20 20:34:29','2024-09-20 20:34:29'),
(26,'Facility',NULL,7,'814 W. Union St. Morganton, NC, 28655','2024-09-20 20:43:11','2024-09-20 20:43:11'),
(27,'Patient',20,NULL,'3560 Ridge Court. Morganton,, NC, 28655.','2024-09-20 20:56:04','2024-09-20 20:56:04'),
(28,'Patient',20,NULL,'4011 Zero Mull Rd. Morganton, NC, 28655','2024-09-20 20:56:04','2024-09-20 20:56:04'),
(29,'Facility',NULL,8,'214 Avery Ave, Morganton, NC, 28655','2024-09-20 21:04:49','2024-09-20 21:04:49'),
(30,'Facility',NULL,9,'32 E Main St, Old Fort, NC, 28762','2024-09-20 21:14:31','2024-09-20 21:14:31'),
(31,'Facility',NULL,10,'1899 Tate Blvd SE #2110 Hickory, NC, 28602','2024-09-23 16:21:20','2024-09-23 16:21:20'),
(32,'Patient',21,NULL,'204 Hillcrest Ave. Hickory, NC, 28207','2024-09-23 16:34:29','2024-09-23 16:34:29'),
(33,'Facility',NULL,11,'1010 Edgehil Rd. Charlotte, NC, 28207','2024-09-23 16:41:57','2024-09-23 16:41:57'),
(35,'Facility',NULL,12,'303 S. Green St. Morganton, NC, 28655','2024-09-30 21:02:11','2024-09-30 21:02:11'),
(36,'Facility',NULL,13,'401 Mulberry St SW, Lenoir, NC, 28645','2024-10-03 22:26:45','2024-10-03 22:26:45'),
(37,'Facility',NULL,14,'720 Malcolm Blvd, Connelly Springs, NC, 28612','2024-10-03 22:35:40','2024-10-03 22:35:40'),
(38,'Facility',NULL,1,'700 E Parker Rd, Morganton, NC, 28655','2024-10-06 16:34:10','2024-10-06 16:34:10'),
(39,'Facility',NULL,3,'612 Mocksville Ave, Salisbur, NC, 28144','2024-10-07 14:32:01','2024-10-07 14:32:01'),
(40,'Patient',2,NULL,'615 Varnadore Rd. Salisbury, NC, 28146','2024-10-07 14:51:58','2024-10-07 14:51:58'),
(41,'Patient',1,NULL,'1300 Burkemont Ave. Morganton, NC,  28655','2024-10-08 22:22:06','2024-10-08 22:22:06');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES
(1,'Burke County Dept Social Services',2,'2024-08-02 08:57:46','2024-08-02 08:57:46'),
(3,'Novant Health Rowan Medical Center',3,'2024-08-04 02:40:51','2024-08-04 02:40:51'),
(6,'Caldwell',1,'2024-09-17 07:16:47','2024-10-11 20:53:09'),
(7,'Fresenius Kidney Care Burke County',2,'2024-09-20 20:43:11','2024-09-20 20:43:11'),
(8,'CaldWell Banker Newton Real Estate',1,'2024-09-20 21:04:49','2024-10-11 20:53:34'),
(9,'Old Fort Family Medicine',2,'2024-09-20 21:14:31','2024-09-23 15:03:34'),
(10,'Hickory Dermatology',2,'2024-09-23 16:21:20','2024-09-23 16:21:31'),
(11,'Atrium Health Neurology Specialty Care',2,'2024-09-23 16:41:57','2024-09-23 16:41:57'),
(12,'Gragg Orthodontics ',1,'2024-09-30 21:02:11','2024-09-30 21:02:11'),
(13,'Burke Mulberry Health',2,'2024-10-03 22:26:45','2024-10-11 20:53:18'),
(14,' Blue Ridge Radiology - Valdese',2,'2024-10-03 22:35:40','2024-10-03 22:35:40');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(15,'2024_08_05_220202_create_scheduling_charge_table',1),
(16,'2024_09_10_085343_create_scheduling_autoagend_table',1);
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
(2,'App\\Models\\User',8),
(2,'App\\Models\\User',9),
(2,'App\\Models\\User',10),
(2,'App\\Models\\User',12),
(2,'App\\Models\\User',19),
(2,'App\\Models\\User',20),
(2,'App\\Models\\User',22);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES
(1,2,'Sarah','Hamilton','1954-09-09','123123123','','123123122','A0120-Ambulatory','123123123','2024-08-01','2024-12-25','Apt. G203','2024-08-02 08:57:08','2024-10-08 22:22:06'),
(2,3,'Dawn Perry','Lawson','1933-10-04','1029381','','12312311','A0130-Wheelchair','12312321','2024-08-02','2024-12-25','None','2024-08-03 06:51:33','2024-10-07 14:49:28'),
(3,3,'Michael','Wayne Litaker','1978-08-07','1231231','','123123','A0130-Wheelchair','123123','2024-08-02','2024-12-25','None','2024-08-03 06:54:36','2024-08-03 06:54:36'),
(4,3,'Jerry ','Dean Corl','2024-08-07','4013789','','12312312','A0130-Wheelchair','4013789','2024-08-02','2024-08-30','none','2024-08-03 10:05:47','2024-08-30 18:48:28'),
(5,3,'Betty','Ivey Cross','2024-08-01','123123123','','123123123','A0130-Wheelchair','123123123','2024-08-01','2024-08-09','none','2024-08-03 10:07:32','2024-08-03 10:07:32'),
(6,3,'Ramona','Coppins Soto','2024-08-01','1231231231','','1231231231','A0130-Wheelchair','1231231231','2024-08-01','2024-08-30','none','2024-08-03 10:08:34','2024-08-03 10:08:34'),
(7,3,'Sylvia','Tart Ogni','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-03 10:09:54','2024-08-03 10:09:54'),
(9,3,'Gilberto','Rodriguez','2024-08-01','123123','','123123','A0130-Wheelchair','123123','2024-08-01','2024-08-30','none','2024-08-04 02:14:17','2024-08-04 02:14:17'),
(11,1,'Kelly W.','Pierce',NULL,'487984546','','7879456-9','A0120-Ambulatory',NULL,NULL,NULL,NULL,'2024-08-30 20:49:09','2024-10-11 20:51:09'),
(12,1,'Dawn','Arnett',NULL,'1546569','','789456-0',NULL,NULL,NULL,NULL,NULL,'2024-08-30 20:50:34','2024-10-11 20:50:56'),
(13,5,'Doris','Rodland',NULL,'25465798','','32566414-3',NULL,NULL,NULL,NULL,NULL,'2024-09-10 13:26:54','2024-09-10 13:33:07'),
(14,5,'Nancy',' Prose ','1976-04-04','311211411','','909080','A0130-Wheelchair',NULL,NULL,NULL,NULL,'2024-09-10 13:28:16','2024-09-10 13:28:16'),
(15,5,'Mary','Lezotte',NULL,'7492532','','7777-3','A0130-Wheelchair',NULL,NULL,NULL,NULL,'2024-09-10 13:28:58','2024-09-10 13:28:58'),
(16,1,'Virginia','Decker',NULL,'1111','','1235456-5','A0120-Ambulatory',NULL,NULL,NULL,NULL,'2024-09-12 19:09:03','2024-09-12 19:09:03'),
(17,1,'Rebecca','Canipe',NULL,'7777','','4444-8','A0120-Ambulatory',NULL,NULL,NULL,NULL,'2024-09-12 19:10:54','2024-09-12 19:10:54'),
(18,1,'Sandra','St.Denis',NULL,'36984','','1236-11','A0120-Ambulatory',NULL,NULL,NULL,NULL,'2024-09-12 19:20:27','2024-09-12 19:20:27'),
(19,2,'Mao','Xiong',NULL,'78932465','','898989-9',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:25:18','2024-09-20 20:25:18'),
(20,2,'Douglas','Luckadoo',NULL,'8699745456','','333333-7','A0120-Ambulatory',NULL,NULL,NULL,NULL,'2024-09-20 20:26:02','2024-09-20 20:46:19'),
(21,2,'Dylan','Brinkley',NULL,'12213','','888888-7',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:28:08','2024-09-20 20:28:08'),
(22,2,'Dorine','Keener',NULL,'9889865465','','36363636-7',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:29:34','2024-09-20 20:29:34'),
(23,2,'Lue','Yang',NULL,'7788','','0099',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:29:53','2024-09-20 20:29:53'),
(24,2,'Tammy','Curtis',NULL,'456476989','','45647899945465-1',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:31:14','2024-09-20 20:31:14'),
(25,2,'Shirley','y Slaughter',NULL,'8877','','098',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:32:04','2024-09-20 20:32:04'),
(26,NULL,'Victoria','Carroll ',NULL,'3344','','5566',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:33:18','2024-09-20 20:33:18'),
(27,NULL,'William','Yarbrough',NULL,'2200','','5500',NULL,NULL,NULL,NULL,NULL,'2024-09-20 20:34:29','2024-09-20 20:34:29');
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
(1,'user.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(2,'user.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(3,'user.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(4,'user.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(5,'role.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(6,'role.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(7,'role.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(8,'role.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(9,'driver.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(10,'driver.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(11,'driver.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(12,'driver.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(13,'vehicle.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(14,'vehicle.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(15,'vehicle.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(16,'vehicle.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(17,'facility.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(18,'facility.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(19,'facility.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(20,'facility.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(21,'servicecontract.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(22,'servicecontract.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(23,'servicecontract.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(24,'servicecontract.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(25,'patient.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(26,'patient.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(27,'patient.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(28,'patient.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(29,'scheduling.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(30,'scheduling.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(31,'scheduling.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(32,'scheduling.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(33,'report.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(34,'report.create','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(35,'report.update','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(36,'report.delete','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(37,'dashboard.view','web','2024-09-10 15:05:24','2024-09-10 15:05:24');
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
(1,'Admin','web','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(2,'Driver','web','2024-09-10 15:05:24','2024-09-10 15:05:24');
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
  `scheduling_autoagend_id` int(10) unsigned DEFAULT NULL,
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
  `additional_milles` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=983 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_address`
--

LOCK TABLES `scheduling_address` WRITE;
/*!40000 ALTER TABLE `scheduling_address` DISABLE KEYS */;
INSERT INTO `scheduling_address` VALUES
(178,89,4,7,'2865 Sycamore Ct. Granite Falls, NC, 28630','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-12','09:40:00','09:29','1','1','pick_up',NULL,'Canceled',NULL,NULL,'2024-09-11 20:42:01','2024-09-11 21:43:57'),
(179,89,4,7,'2865 Sycamore Ct. Granite Falls, NC, 28630','Bojangles, 302 Blowing Rock Blvd, Lenoir, NC 28645, USA','2024-09-12','09:40:00','09:29','9.7','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-11 20:42:01','2024-09-11 21:35:43'),
(180,89,4,7,'Bojangles, 302 Blowing Rock Blvd, Lenoir, NC 28645, USA','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-12','09:40:00','09:29','9.7','16','return',NULL,'Waiting',NULL,NULL,'2024-09-11 20:42:01','2024-09-11 21:35:43'),
(181,90,4,7,'2865 Sycamore Ct. Granite Falls, NC, 28630','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-15','09:40','09:29','1','1','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-11 20:42:01','2024-09-20 21:35:49'),
(182,90,4,7,'2865 Sycamore Ct. Granite Falls, NC, 28630','Bojangles, 302 Blowing Rock Blvd, Lenoir, NC 28645, USA','2024-09-15','09:51','09:29','9.7','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-11 20:42:01','2024-09-11 20:42:01'),
(183,90,4,7,'Bojangles, 302 Blowing Rock Blvd, Lenoir, NC 28645, USA','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-15','10:50','09:29','9.7','16','return',NULL,'Waiting',NULL,NULL,'2024-09-11 20:42:01','2024-09-11 20:42:01'),
(386,176,7,6,'557 Brookdale Dr. Statesville, NC, 28677.','124 Welton Way, Mooresville, NC 28117, USA','2024-09-17','13:30:00','12:58','16.6','22','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-12 13:34:19','2024-09-17 07:04:57'),
(387,176,7,6,'124 Welton Way, Mooresville, NC 28117, USA','557 Brookdale Dr. Statesville, NC, 28677.','2024-09-17','13:30:00','12:58','16.7','23','return',NULL,'Waiting',NULL,NULL,'2024-09-12 13:34:19','2024-09-17 07:04:57'),
(388,177,7,5,'557 Brookdale Drive Statesville, NC,  28677','131 Miller Street, Winston-Salem, NC, USA','2024-09-18','15:00:00','14:10','41.5','40','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-12 13:42:50','2024-09-12 19:17:22'),
(389,177,7,5,'131 Miller Street, Winston-Salem, NC, USA','557 Brookdale Drive Statesville, NC,  28677','2024-09-18','15:00:00','14:10','41.2','41','return',NULL,'Waiting',NULL,NULL,'2024-09-12 13:42:50','2024-09-12 19:17:22'),
(428,191,12,13,'307 Kristin Ln, Hudson, NC 28638, USA','4355 Hickory Street, Granite Falls, NC 28630, USA','2024-09-12','12:00:00','11:40','5.8','10','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-12 19:53:47','2024-09-12 19:54:59'),
(429,191,12,13,'4355 Hickory Street, Granite Falls, NC 28630, USA','307 Kristin Ln, Hudson, NC 28638, USA','2024-09-12','12:00:00','11:40','5.8','11','return',NULL,'Waiting',NULL,NULL,'2024-09-12 19:53:47','2024-09-12 19:54:59'),
(430,34,12,13,'2865 Sycamore Ct. Granite Falls, NC, 28630','3604 Peters Court, High Point, NC, USA','2024-09-17','10:00:00','09:49','97.4','1','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-16 19:07:38','2024-09-17 07:04:56'),
(431,34,12,13,'3604 Peters Court, High Point, NC, USA','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-17','10:00:00','09:49','101','1','return',NULL,'Waiting',NULL,NULL,'2024-09-16 19:07:38','2024-09-17 07:04:56'),
(432,189,12,13,'4038 Grandin Rd, Lenoir, NC 28645, USA','1208 Hickory Blvd, Lenoir, NC 28645, USA','2024-09-12','07:21:00','06:55','11.3','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-17 08:16:08','2024-09-17 08:16:08'),
(433,189,12,13,'1208 Hickory Blvd, Lenoir, NC 28645, USA','4038 Grandin Rd, Lenoir, NC 28645, USA','2024-09-12','07:21:00','06:55','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-17 08:16:08','2024-09-17 08:16:08'),
(434,190,12,13,'2865 Sycamore Ct. Granite Falls, NC, 28630','3604 Peters Court, High Point, NC 27265, USA','2024-09-12','09:35:00','09:24','97.4','1','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-17 08:16:14','2024-09-17 08:16:14'),
(435,190,12,13,'3604 Peters Court, High Point, NC 27265, USA','2865 Sycamore Ct. Granite Falls, NC, 28630','2024-09-12','09:35:00','09:24','101','1','return',NULL,'Waiting',NULL,NULL,'2024-09-17 08:16:14','2024-09-17 08:16:14'),
(450,199,14,16,'4011 Zero Mull Rd. Morganton, NC, 28655','ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','2024-09-26','09:00','08:40','4.7','10','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-20 21:12:58','2024-09-20 21:12:58'),
(451,199,14,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','4011 Zero Mull Rd. Morganton, NC, 28655','2024-09-26','10:00','08:40','4.6','10','return',NULL,'Waiting',NULL,NULL,'2024-09-20 21:12:58','2024-09-20 21:12:58'),
(471,205,18,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-10-02','09:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:11:52','2024-09-23 16:11:52'),
(472,205,18,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-10-02','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:11:52','2024-09-23 16:11:52'),
(495,202,21,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-10-09','09:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:49:51','2024-09-23 16:49:51'),
(496,202,21,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-10-09','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:49:51','2024-09-23 16:49:51'),
(497,201,22,16,'1300 Burkemont Avenue, Morganton, NC, USA','32 E Main St, Old Fort, NC 28762, USA','2024-10-07','10:00','09:19','31.5','31','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:50:01','2024-09-23 16:50:01'),
(498,201,22,16,'32 E Main St, Old Fort, NC 28762, USA','1300 Burkemont Avenue, Morganton, NC, USA','2024-10-07','12:00','09:19','31.5','30','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:50:01','2024-09-23 16:50:01'),
(503,210,22,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-10-07','09:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(504,210,22,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-10-07','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(505,211,22,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-10-08','09:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(506,211,22,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-10-08','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(507,212,22,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-10-09','09:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(508,212,22,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-10-09','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(547,228,28,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-09-23','09:00:00','08:36','6.0','14','pick_up',NULL,'In Progress',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:16:44'),
(548,228,28,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-09-23','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(549,229,28,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-09-24','09:00:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(550,229,28,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-09-24','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(551,230,28,16,'3560 Ridge Court. Morganton,, NC, 28655.','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-09-25','09:00:00','08:36','6.0','14','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(552,230,28,16,'ColdWell Banker Newton Real Estate, 214 Avery Avenue, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-09-25','10:00','08:36','5.8','13','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(553,231,29,16,'4038 Grandin Rd. Lenoir, NC, 28645','1208 Hickory Boulevard, Lenoir, NC, USA','2024-09-23','15:00:00','14:34','11.3','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(554,231,29,16,'1208 Hickory Boulevard, Lenoir, NC, USA','4038 Grandin Rd. Lenoir, NC, 28645','2024-09-23','15:00:00','14:34','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(555,232,29,16,'4038 Grandin Rd. Lenoir, NC, 28645','1208 Hickory Boulevard, Lenoir, NC, USA','2024-09-25','15:00:00','14:34','11.3','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(556,232,29,16,'1208 Hickory Boulevard, Lenoir, NC, USA','4038 Grandin Rd. Lenoir, NC, 28645','2024-09-25','15:00:00','14:34','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(557,233,29,16,'4038 Grandin Rd. Lenoir, NC, 28645','1208 Hickory Boulevard, Lenoir, NC, USA','2024-09-28','15:00:00','14:34','11.3','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(558,233,29,16,'1208 Hickory Boulevard, Lenoir, NC, USA','4038 Grandin Rd. Lenoir, NC, 28645','2024-09-28','15:00:00','14:34','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(559,234,29,16,'4038 Grandin Rd. Lenoir, NC, 28645','1208 Hickory Boulevard, Lenoir, NC, USA','2024-09-30','15:00:00','14:34','11.3','16','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(560,234,29,16,'1208 Hickory Boulevard, Lenoir, NC, USA','4038 Grandin Rd. Lenoir, NC, 28645','2024-09-30','15:00:00','14:34','11.3','15','return',NULL,'Waiting',NULL,NULL,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(617,265,32,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-01','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:18:13','2024-09-24 15:18:13'),
(618,265,32,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-01','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:18:13','2024-09-24 15:18:13'),
(635,274,33,6,'4011 Zero Mull Rd, Morganton, NC 28655, USA','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-07-04','11:00','10:40','4.7','10','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(636,274,33,6,'ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','4011 Zero Mull Rd, Morganton, NC 28655, USA','2024-07-04','12:00','10:40','4.6','10','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(637,275,33,6,'4011 Zero Mull Rd, Morganton, NC 28655, USA','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-07-11','11:00','10:40','4.7','10','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(638,275,33,6,'ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','4011 Zero Mull Rd, Morganton, NC 28655, USA','2024-07-11','12:00','10:40','4.6','10','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(639,276,33,6,'4011 Zero Mull Rd, Morganton, NC 28655, USA','ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','2024-07-18','11:00','10:40','4.7','10','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(640,276,33,6,'ColdWell Banker Newton Real Estate, 214 Avery Ave, Morganton, NC, USA','4011 Zero Mull Rd, Morganton, NC 28655, USA','2024-07-18','12:00','10:40','4.6','10','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(643,278,34,16,'1300 Burkemont Avenue, Morganton, NC, USA','32 E Main St, Old Fort, NC 28762, USA','2024-07-01','13:00','12:19','31.5','31','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:25:08','2024-09-24 15:25:08'),
(644,278,34,16,'32 E Main St, Old Fort, NC 28762, USA','1300 Burkemont Avenue, Morganton, NC, USA','2024-07-01','14:00','12:19','31.5','30','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:25:08','2024-09-24 15:25:08'),
(645,279,34,6,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Blvd SE #2110 Hickory, NC, 28602','2024-07-01','10:00','09:31','14.7','19','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-24 15:27:20','2024-09-24 15:27:20'),
(646,279,34,6,'1899 Tate Blvd SE #2110 Hickory, NC, 28602','6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','2024-07-01','11:00','09:31','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-09-24 15:27:20','2024-09-24 15:27:20'),
(651,282,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-02','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(652,282,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-02','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(653,283,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-03','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(654,283,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-03','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(655,284,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-08','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(656,284,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-08','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(657,285,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-09','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(658,285,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-09','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(659,286,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-10','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(660,286,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-10','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(661,287,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-15','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(662,287,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-15','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(663,288,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-16','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(664,288,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-16','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(665,289,34,16,'3560 Ridge Court. Morganton,, NC, 28655.','214 Avery Road, Morganton, NC, USA','2024-07-17','11:00','10:32','9.8','18','pick_up',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(666,289,34,16,'214 Avery Road, Morganton, NC, USA','3560 Ridge Court. Morganton,, NC, 28655.','2024-07-17','12:00','10:32','9.8','18','return',NULL,'Waiting',NULL,NULL,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(913,404,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-11','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(914,404,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-11','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(915,405,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-14','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(916,405,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-14','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(917,406,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-16','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(918,406,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-16','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(919,407,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-18','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(920,407,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-18','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(921,408,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-21','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(922,408,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-21','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(923,409,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-23','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(924,409,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-23','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(925,410,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-25','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(926,410,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-25','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(927,411,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-28','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(928,411,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-28','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(929,412,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-10-30','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(930,412,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-10-30','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(931,413,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-01','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(932,413,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-01','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(933,414,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-04','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(934,414,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-04','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(935,415,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-06','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(936,415,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-06','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(937,416,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-08','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(938,416,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-08','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(939,417,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-11','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(940,417,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-11','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(941,418,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-13','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(942,418,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-13','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(943,419,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-15','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(944,419,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-15','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(945,420,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-18','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(946,420,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-18','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(947,421,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-20','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(948,421,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-20','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(949,422,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-22','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(950,422,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-22','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(951,423,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-25','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(952,423,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-25','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(953,424,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-27','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(954,424,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-27','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(955,425,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-11-29','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(956,425,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-11-29','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(957,426,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-02','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(958,426,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-02','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(959,427,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-04','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(960,427,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-04','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(961,428,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-06','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(962,428,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-06','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(963,429,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-09','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(964,429,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-09','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(965,430,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-11','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(966,430,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-11','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(967,431,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-13','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(968,431,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-13','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(969,432,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-16','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(970,432,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-16','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(971,433,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-18','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(972,433,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-18','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(973,434,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-20','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(974,434,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-20','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(975,435,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-23','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(976,435,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-23','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(977,436,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-25','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(978,436,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-25','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(979,437,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-27','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(980,437,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-27','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(981,438,42,8,'6970 Hildebran Mtn Ave. Connelly Sprigs, NC,  28612','1899 Tate Boulevard Southeast, Hickory, NC, USA','2024-12-30','11:10','12:00','14.8','20','pick_up',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(982,438,42,8,'1899 Tate Boulevard Southeast, Hickory, NC, USA','6970 Hildebran Mountain Avenue, Connelly Springs, NC, USA','2024-12-30','16:00','16:00','12.9','18','return',NULL,'Waiting',NULL,NULL,'2024-10-11 22:07:08','2024-10-11 22:07:08');
/*!40000 ALTER TABLE `scheduling_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling_autoagend`
--

DROP TABLE IF EXISTS `scheduling_autoagend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduling_autoagend` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_autoagend`
--

LOCK TABLES `scheduling_autoagend` WRITE;
/*!40000 ALTER TABLE `scheduling_autoagend` DISABLE KEYS */;
INSERT INTO `scheduling_autoagend` VALUES
(43,'2024-09-10 15:05:25','2024-10-11 22:07:08');
/*!40000 ALTER TABLE `scheduling_autoagend` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=439 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling_charge`
--

LOCK TABLES `scheduling_charge` WRITE;
/*!40000 ALTER TABLE `scheduling_charge` DISABLE KEYS */;
INSERT INTO `scheduling_charge` VALUES
(34,34,'round_trip',0,1,1,0,0,0,0,0,0,0,0,'2024-09-11 20:17:40','2024-09-11 20:17:40'),
(89,89,'round_trip',1,0,0,0,0,0,0,0,1,1,0,'2024-09-11 20:42:01','2024-09-11 21:43:57'),
(90,90,'round_trip',1,0,0,0,0,0,0,0,0,1,0,'2024-09-11 20:42:01','2024-09-20 21:35:49'),
(176,176,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-12 13:34:19','2024-09-12 13:34:19'),
(177,177,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-12 13:42:50','2024-09-12 13:42:50'),
(189,189,'one_way',1,0,0,0,0,0,0,0,0,0,0,'2024-09-12 19:25:52','2024-09-17 08:16:08'),
(190,190,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-12 19:38:28','2024-09-12 19:38:28'),
(191,191,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-12 19:44:31','2024-09-12 19:44:31'),
(199,199,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-20 21:12:58','2024-09-20 21:12:58'),
(201,201,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-20 21:20:31','2024-09-20 21:25:46'),
(202,202,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 16:09:02','2024-09-23 16:09:02'),
(205,205,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 16:11:52','2024-09-23 16:11:52'),
(210,210,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(211,211,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(212,212,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 16:54:17','2024-09-23 16:54:17'),
(228,228,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(229,229,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(230,230,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-23 22:06:28','2024-09-23 22:06:28'),
(231,231,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(232,232,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(233,233,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(234,234,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-23 22:06:56','2024-09-23 22:06:56'),
(265,265,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-24 15:18:13','2024-09-24 15:18:13'),
(274,274,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(275,275,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(276,276,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-24 15:20:38','2024-09-24 15:20:38'),
(278,278,'round_trip',0,1,0,0,0,0,0,0,0,0,0,'2024-09-24 15:25:08','2024-09-24 15:25:08'),
(279,279,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-09-24 15:27:20','2024-09-24 15:27:20'),
(282,282,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(283,283,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(284,284,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(285,285,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(286,286,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(287,287,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(288,288,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(289,289,'round_trip',1,0,0,0,0,1,0,0,0,0,0,'2024-09-27 16:11:14','2024-09-27 16:11:14'),
(338,338,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-07 14:38:06','2024-10-07 14:38:06'),
(404,404,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(405,405,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(406,406,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(407,407,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(408,408,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(409,409,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(410,410,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(411,411,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(412,412,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(413,413,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(414,414,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(415,415,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(416,416,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(417,417,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(418,418,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(419,419,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(420,420,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(421,421,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(422,422,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(423,423,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(424,424,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(425,425,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(426,426,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(427,427,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:07','2024-10-11 22:07:07'),
(428,428,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(429,429,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(430,430,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(431,431,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(432,432,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(433,433,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(434,434,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(435,435,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(436,436,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(437,437,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08'),
(438,438,'round_trip',1,0,0,0,0,0,0,0,0,0,0,'2024-10-11 22:07:08','2024-10-11 22:07:08');
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
  `select_date` varchar(255) DEFAULT NULL,
  `ends_schedule` varchar(255) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=439 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedulings`
--

LOCK TABLES `schedulings` WRITE;
/*!40000 ALTER TABLE `schedulings` DISABLE KEYS */;
INSERT INTO `schedulings` VALUES
(265,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-24 15:18:13','2024-09-24 15:18:13'),
(274,20,1,'Thursday','ends_check','2024-07-18','2024-09-24 15:20:38','2024-09-24 15:20:38'),
(275,20,1,'Thursday','ends_check','2024-07-18','2024-09-24 15:20:38','2024-09-24 15:20:38'),
(276,20,1,'Thursday','ends_check','2024-07-18','2024-09-24 15:20:38','2024-09-24 15:20:38'),
(278,1,0,'',NULL,NULL,'2024-09-24 15:25:08','2024-09-24 15:25:08'),
(279,23,0,'',NULL,NULL,'2024-09-24 15:27:20','2024-09-24 15:27:20'),
(282,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(283,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(284,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(285,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(286,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(287,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(288,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(289,20,1,'Monday,Tuesday,Wednesday','ends_check','2024-07-18','2024-09-27 16:11:14','2024-09-27 16:11:14'),
(338,4,0,'',NULL,NULL,'2024-10-07 14:38:06','2024-10-07 14:38:06'),
(404,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(405,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(406,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(407,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(408,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(409,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(410,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(411,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(412,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(413,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(414,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(415,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(416,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(417,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(418,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(419,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(420,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(421,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(422,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(423,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(424,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(425,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(426,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(427,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:07','2024-10-11 22:07:07'),
(428,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(429,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(430,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(431,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(432,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(433,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(434,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(435,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(436,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(437,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08'),
(438,23,1,',Monday,Wednesday,Friday',NULL,'2024-12-31','2024-10-11 22:07:08','2024-10-11 22:07:08');
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
  `email` varchar(255) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_contracts`
--

LOCK TABLES `service_contracts` WRITE;
/*!40000 ALTER TABLE `service_contracts` DISABLE KEYS */;
INSERT INTO `service_contracts` VALUES
(1,'Caldwell County','Caldwell County',120,55,45,65,85,35,35,0,15,0,4,0,'Medicaid Transportation NEMT PO Box 200 Lenoir, NC 28645','(828) 426-8217','Active', 'caldwell@example.com', '2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),
(2,'Burke County','Burke County',120,55,45,65,85,25,35,0,15,0,4,0,'700 East Parker Road Morganton, NC 28655','(828) 764-9612','Active', 'burke@example.com', '2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),
(3,'Novant Health Rowan Medical Center','Novant Health',95,55,45,65,85,15,35,0,15,0,4,0,'123 Main St.','123456789','Active', 'novant@example.com', '2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),
(4,'Carteret County','Carteret County',120,55,45,65,85,25,35,0,15,0,4,0,'123 Main St.','123456789','Active', 'carteret@example.com', '2023-07-28','2023-07-28','2024-09-10 15:05:25','2024-09-10 15:05:25'),
(5,'Iredell Health System','Iredell',95,55,45,65,85,25,35,35,15,0,4,0,'557 Brookdale Drive Statesville, NC 28677',NULL,'active', 'iredell@example.com', '2024-09-10','2024-09-30','2024-09-10 13:25:26','2024-09-10 13:25:26');
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
  `dob` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin@material.com','2024-09-10 15:05:24',NULL,'$2y$10$euSdZ5zGcn2jVMbuwM1hv..H425Ty5qO4TdEATF167oPQU8Tw.Ida','R9Z2kFIQHv9CEkw3YPT6MlFhDK00BYEEaNEqmUnTNyMcbWjxrH7qCHZBkIis','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(2,'Laura ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'laura@material.com','2024-09-10 15:05:24',NULL,'$2y$10$vVWo/6kuo/O3cJgyBjpQHutTdhxBQa7Q3Qw80ZKqHA0Zmtlzq.sKO','RWGFJIZCnu','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(3,'Cony',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'cony@material.com','2024-09-10 15:05:24',NULL,'$2y$10$OUDL2E4QerLs9NQ3XriTTeJReHfV4vmknA0Lf0cV7Dxh2w28iYTJG','aNTImqESQZ','2024-09-10 15:05:24','2024-09-10 15:05:24'),
(5,'Miguel Chavez','1979-06-24','NC','32581474','Owner',NULL,NULL,NULL,'miguel_chavez@example.com',NULL,NULL,'$2y$10$f0N9neqdKIehudtUhGiYwuG.yOCKlFj1lh0Ir8pb6sD/L15B9HuPG',NULL,'2024-09-10 15:05:24','2024-09-28 15:29:19'),
(8,'Freddy Nieto','1970-08-17','NC','29050340','2023-08-25',NULL,NULL,NULL,'freddy_nieto@example.com',NULL,NULL,'$2y$10$Tgd3SZpowc/jRZq9ipXtjui5X1ZfjGV5i4/yVr86fEjNF6yJhJY1e',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(9,'Wilmar Jimenez','1982-07-10','NC','35825495','2023-11-25',NULL,NULL,NULL,'wilmar_jimenez@example.com',NULL,NULL,'$2y$10$enrZcGELfEKk1xE9NTu0nekWmb8BZ5WFJb0XnxxEQQ2Y3/M/Z2.A6',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(10,'Omar Rodriguez','1986-07-22','NC','42514740','2024-01-22',NULL,NULL,NULL,'omar_rodriguez@example.com',NULL,NULL,'$2y$10$er7C/g6BZHEucaMqkc7/Qeuw3QUUxvwwhvx0gN4gvoWoWnZgka1gW',NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(19,'Laura Chavez','1987-01-23','NC','11223344','2024-01-01','7046260573',NULL,NULL,'caliasi0624@yahoo.com',NULL,NULL,'$2y$10$HSXtB6lOx4C9XVxmyJId4OU/FLx.FsPgV9OMOvO.8bD2cjjmGBjUG',NULL,'2024-10-08 22:05:09','2024-10-08 22:05:09'),
(20,'Javier Puentes','1976-04-04','NC','66778899','2024-01-02','31923505628',NULL,NULL,'jpuentes.76@gmail.com',NULL,NULL,'$2y$10$GMt/cLKwJYId.HMVfEvgR.Cb.ek25RdHxM0Mp0WQAQabiX//k5fgi',NULL,'2024-10-08 22:07:28','2024-10-08 22:07:28'),
(22,'Constanza Velez',NULL,NULL,NULL,NULL,'3186811981',NULL,NULL,'constanzavelezb@gmail.com',NULL,NULL,'$2y$10$CPrKL1JgkZK4ds1XJBHDBO414nYnLQ1FsnvEt1UPMq3dhtUf6vSHu',NULL,'2024-10-11 22:02:55','2024-10-11 22:02:55');
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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
INSERT INTO `vehicles` VALUES
(1,'2006','Toyota','Sienna','5TDZA23C56S566778',1,19,'2024-09-10 15:05:25','2024-10-08 23:07:36'),
(2,'2010','Ford','Econoline','1FDEE3FL1ADA68677',2,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(3,'2006','Ford','Econoline','1FTSS34L56HB31363',3,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(4,'2023','Chevy','Suburban','1GNSKEKD9PR238670',4,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(5,'2020','Toyota','Sienna','5TDKZ3DC2LS029988',5,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(6,'2020','Toyota','Sienna','5TDYZ3DC4LS053218',6,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25'),
(7,'2007','Ford','Econoline','1FBSS31L57DB34734',7,NULL,'2024-09-10 15:05:25','2024-09-10 15:05:25');
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

-- Dump completed on 2024-10-14 18:35:59
