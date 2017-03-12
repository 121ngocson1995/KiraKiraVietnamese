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
-- Table structure for table `p5_elements`
--

DROP TABLE IF EXISTS `p5_elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `p5_elements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson_id` int(10) unsigned NOT NULL,
  `dialogNo` tinyint(3) unsigned NOT NULL,
  `dialog` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p5_elements_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `p5_elements_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p5_elements`
--

LOCK TABLES `p5_elements` WRITE;
/*!40000 ALTER TABLE `p5_elements` DISABLE KEYS */;
INSERT INTO `p5_elements` VALUES (1,1,0,'- Chào bạn!|- Chào bạn!','P5_audio/test_0.mp3',NULL,NULL,NULL),(2,1,1,'- Chào chị!|- Chào em!','P5_audio/test_1.mp3',NULL,NULL,NULL),(3,1,2,'- Chào anh!|- Chào em!','P5_audio/test_2.mp3',NULL,NULL,NULL),(4,1,3,'- Chào chú!|- Chào cháu!','P5_audio/test_3.mp3',NULL,NULL,NULL),(5,1,4,'- Chào cô!|- Chào cháu!','P5_audio/test_4.mp3',NULL,NULL,NULL),(6,1,5,'- Chào bác!|- Chào cháu!','P5_audio/test_5.mp3',NULL,NULL,NULL),(7,1,6,'- Bạn tên là gì ?|- Tôi tên là Trung anh.','P5_audio/test_6.mp3',NULL,NULL,NULL),(8,1,7,'- Cháu tên là gì?|- Cháu tên là Trung Anh.','P5_audio/test_7.mp3',NULL,NULL,NULL),(9,1,8,'- Bạn mấy tuổi ?|- Tôi 7 tuổi.','P5_audio/test_8.mp3',NULL,NULL,NULL),(10,1,9,'- Em bao nhiêu tuổi ?|- Em 7 tuổi ạ.','P5_audio/test_9.mp3',NULL,NULL,NULL),(11,1,10,'- Bạn là hoc sinh à ?|- Ừ, tôi là học sinh.','P5_audio/test_10.mp3',NULL,NULL,NULL),(12,1,11,'- Cháu là học sinh à ?|-Vâng ạ, cháu là học sinh.','P5_audio/test_11.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p5_elements` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12 13:15:52
