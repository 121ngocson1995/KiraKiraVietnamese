-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.19-MariaDB

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
-- Table structure for table `p9_elements`
--

DROP TABLE IF EXISTS `p9_elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p9_elements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson_id` int(10) unsigned NOT NULL,
  `dialogNo` tinyint(3) unsigned NOT NULL,
  `lineNo` tinyint(3) unsigned NOT NULL,
  `line` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p9_elements_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `p9_elements_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p9_elements`
--

LOCK TABLES `p9_elements` WRITE;
/*!40000 ALTER TABLE `p9_elements` DISABLE KEYS */;
INSERT INTO `p9_elements` VALUES (1,1,1,1,'– Chào bạn !',NULL,NULL,NULL,NULL),(2,1,1,2,'– *','Chào bạn.',NULL,NULL,NULL),(3,1,1,3,'- Tôi tên là Trung Anh. Còn bạn ?',NULL,NULL,NULL,NULL),(4,1,1,4,'– *','Tôi tên là Nam.',NULL,NULL,NULL),(5,1,1,5,'Tôi 7 tuổi. Tôi là học sinh. *','Còn bạn ?',NULL,NULL,NULL),(6,1,1,6,'– *','Tôi cũng là học sinh.',NULL,NULL,NULL),(7,1,2,1,'-  Chào anh.',NULL,NULL,NULL,NULL),(8,1,2,2,'– *','Chào em.',NULL,NULL,NULL),(9,1,2,3,'*','Em tên là gì ?',NULL,NULL,NULL),(10,1,2,4,'- Em tên là Trung Anh ạ.',NULL,NULL,NULL,NULL),(11,1,2,5,'– *','Em bao nhiêu tuổi ?',NULL,NULL,NULL),(12,1,2,6,'- Em 9 tuổi ạ.',NULL,NULL,NULL,NULL),(13,1,2,7,'– *','Em là học sinh à ?',NULL,NULL,NULL),(14,1,2,8,'- Vâng, em là học sinh ạ.',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `p9_elements` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12 13:15:53
