-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: kirakiravn
-- ------------------------------------------------------
-- Server version	5.7.16-log

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
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'','First course','Today, Vietnamese people have set foot and settled all around the world. That\'s a wonderful thing. However, after generations and generations, the language has faded away among those living overseas. This course aims to provide to small children the basic knowledge of Vietnamese language as well as Vietnamese culture.',8,'Trung NL',1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `extensions`
--

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
INSERT INTO `extensions` VALUES (1,1,1,0,'Hình ảnh đất nước, con người','demo',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,2,1,'Bài hát dành cho em','Con cò bé bé|Nó đậu cành tre|Đi không hỏi mẹ|Biết đi đường nào|Khi đi em hỏi|Khi về em chào|Miệng em chúm chím|Mẹ có yêu không nào',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,3,2,'Em đọc thơ','Đi đến nơi nào|Lời chào đi trước|Lời chào dẫn bước|Chẳng sợ lạc nhà|Lời chào kết bạn|Con đường bớt xa',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,4,3,'Thành ngữ - Tục ngữ - Ca dao','Lời chào cao hơn mâm cỗ',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,5,4,'Thử đoán nào?','Con gì mào đỏ|Lông mượt như tơ|Sáng sớm tinh mơ|Gọi người thức dậy?',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,6,5,'Cùng chơi các bạn ơi!','Chi chi chành chành|Cái đanh thổi lửa|Con ngựa đứt cương|Ba Vương ngũ Đế|Bắt dế đi tìm...|Ù à ù ập...',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,1,1,'Hello','You will learn about various ways to greet people.','Trung NL',1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p10_sentence_reorders`
--

LOCK TABLES `p10_sentence_reorders` WRITE;
/*!40000 ALTER TABLE `p10_sentence_reorders` DISABLE KEYS */;
INSERT INTO `p10_sentence_reorders` VALUES (1,1,2,'tôi',0,NULL,NULL,NULL),(2,1,2,'tên',1,NULL,NULL,NULL),(3,1,2,'là',2,NULL,NULL,NULL),(4,1,2,'Trung Anh',3,NULL,NULL,NULL),(5,1,1,'tôi',0,NULL,NULL,NULL),(6,1,1,'chín',1,NULL,NULL,NULL),(7,1,1,'tuổi',2,NULL,NULL,NULL),(8,1,3,'tôi',0,NULL,NULL,NULL),(9,1,3,'là',1,NULL,NULL,NULL),(10,1,3,'học',2,NULL,NULL,NULL),(11,1,3,'sinh',3,NULL,NULL,NULL);
/*!40000 ALTER TABLE `p10_sentence_reorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p11_conversation_reorders`
--

LOCK TABLES `p11_conversation_reorders` WRITE;
/*!40000 ALTER TABLE `p11_conversation_reorders` DISABLE KEYS */;
INSERT INTO `p11_conversation_reorders` VALUES (1,1,'Chào bạn.',0,NULL,NULL,NULL),(2,1,'Chào bạn.',1,NULL,NULL,NULL),(3,1,'Tôi tên là Lan.',2,NULL,NULL,NULL),(4,1,'Tôi tên là Sơn',3,NULL,NULL,NULL),(5,1,'Tôi chín tuổi, còn bạn?',4,NULL,NULL,NULL),(6,1,'Còn tôi, tôi mười tuổi.',5,NULL,NULL,NULL),(7,1,'Tôi là học sinh.',6,NULL,NULL,NULL),(8,1,'Tôi cũng là học sinh',7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `p11_conversation_reorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p12_group_interactions`
--

LOCK TABLES `p12_group_interactions` WRITE;
/*!40000 ALTER TABLE `p12_group_interactions` DISABLE KEYS */;
INSERT INTO `p12_group_interactions` VALUES (1,1,'Tương tác nhóm','Các nhóm nhỏ trong lớp cùng nhau chuẩn bị và thực hành trong nhóm phần tự giới thiệu về mình. Sau đó các nhóm cùng nhau chỉnh sửa một bài chung và cử một bạn đại diện thay mặt nhóm tự giới thiệu trước toàn lớp.','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p12_group_interactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p13_texts`
--

LOCK TABLES `p13_texts` WRITE;
/*!40000 ALTER TABLE `p13_texts` DISABLE KEYS */;
INSERT INTO `p13_texts` VALUES (1,1,'Học thuộc lòng bài khóa. | Viết một bài tự giới thiệu về mình.','Tôi tên là Trung Anh. Tôi 9 tuổi. Tôi là học sinh. Còn bạn, bạn tên là gì? Bạn bao nhiêu tuổi? Bạn cũng là học sinh à?','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p13_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p14_sentence_patterns`
--

LOCK TABLES `p14_sentence_patterns` WRITE;
/*!40000 ALTER TABLE `p14_sentence_patterns` DISABLE KEYS */;
INSERT INTO `p14_sentence_patterns` VALUES (1,1,1,'Chào*bạn|em|cháu*',NULL,NULL,NULL),(2,1,2,'Chào*anh|chị|cô|chú|bác|ông|bà*',NULL,NULL,NULL),(3,1,3,'*Bạn|Em|Cháu*tên là gì?',NULL,NULL,NULL),(4,1,4,'Tên*bạn|em|cháu*là gì?',NULL,NULL,NULL),(5,1,5,'Tên*tôi|em|cháu*là...',NULL,NULL,NULL),(6,1,6,'*Bạn|Em|Cháu*bao nhiêu tuổi?',NULL,NULL,NULL),(7,1,7,'*Bạn|Em|Cháu*mấy tuổi?',NULL,NULL,NULL),(8,1,8,'*Tôi|Em|Cháu*9 tuổi.',NULL,NULL,NULL),(9,1,9,'*Em|Cháu*là học sinh à?',NULL,NULL,NULL),(10,1,10,'Vâng*em|cháu*là học sinh.',NULL,NULL,NULL),(11,1,11,'**Bạn là học sinh à?',NULL,NULL,NULL),(12,1,12,'**Ừ, tôi là học sinh.',NULL,NULL,NULL),(13,1,13,'Còn*bạn|em|cháu*?',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p14_sentence_patterns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p1_word_memorizes`
--

LOCK TABLES `p1_word_memorizes` WRITE;
/*!40000 ALTER TABLE `p1_word_memorizes` DISABLE KEYS */;
INSERT INTO `p1_word_memorizes` VALUES (1,1,1,1,'Chào','/audio/P1/lesson1/1-chao.mp3',NULL,NULL,NULL),(2,1,1,2,'Bạn','/audio/P1/lesson1/2-ban.mp3',NULL,NULL,NULL),(3,1,1,3,'Anh','/audio/P1/lesson1/3-anh.mp3',NULL,NULL,NULL),(4,1,1,4,'Chị','/audio/P1/lesson1/4-chi.mp3',NULL,NULL,NULL),(5,1,1,5,'Cô','/audio/P1/lesson1/5-co.mp3',NULL,NULL,NULL),(6,1,1,6,'Chú','/audio/P1/lesson1/6-chu.mp3',NULL,NULL,NULL),(7,1,2,1,'Bác','/audio/P1/lesson1/7-bac.mp3',NULL,NULL,NULL),(8,1,2,2,'Ông','/audio/P1/lesson1/8-ong.mp3',NULL,NULL,NULL),(9,1,2,3,'Bà','/audio/P1/lesson1/9-ba.mp3',NULL,NULL,NULL),(10,1,2,4,'Tôi','/audio/P1/lesson1/10-toi.mp3',NULL,NULL,NULL),(11,1,2,5,'Em','/audio/P1/lesson1/11-em.mp3',NULL,NULL,NULL),(12,1,2,6,'Cháu','/audio/P1/lesson1/12-chau.mp3',NULL,NULL,NULL),(13,1,3,1,'Tên','/audio/P1/lesson1/13-ten.mp3',NULL,NULL,NULL),(14,1,3,2,'Tuổi','/audio/P1/lesson1/14-tuoi.mp3',NULL,NULL,NULL),(15,1,3,3,'Các','/audio/P1/lesson1/15-cac.mp3',NULL,NULL,NULL),(16,1,3,4,'À','/audio/P1/lesson1/16-a.mp3',NULL,NULL,NULL),(17,1,3,5,'Ạ','/audio/P1/lesson1/17-a.mp3',NULL,NULL,NULL),(18,1,3,6,'Là','/audio/P1/lesson1/18-da.mp3',NULL,NULL,NULL),(19,1,3,5,'Bao nhiêu','/audio/P1/lesson1/18-da.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p1_word_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p2_word_recognizes`
--

LOCK TABLES `p2_word_recognizes` WRITE;
/*!40000 ALTER TABLE `p2_word_recognizes` DISABLE KEYS */;
INSERT INTO `p2_word_recognizes` VALUES (1,1,'tôi',0,'/audio/P2/lesson1/1-toi.mp3',NULL,NULL,NULL),(2,1,'chín',1,'/audio/P2/lesson1/2-chin.mp3',NULL,NULL,NULL),(3,1,'bao nhiêu',2,'/audio/P2/lesson1/3-bao-nhieu.mp3',NULL,NULL,NULL),(4,1,'tuổi',3,'/audio/P2/lesson1/4-tuoi.mp3',NULL,NULL,NULL),(5,1,'tên',4,'/audio/P2/lesson1/5-ten.mp3',NULL,NULL,NULL),(6,1,'chào',5,'/audio/P2/lesson1/6-chao.mp3',NULL,NULL,NULL),(7,1,'bạn',6,'/audio/P2/lesson1/7-ban.mp3',NULL,NULL,NULL),(8,1,'em',7,'/audio/P2/lesson1/8-em.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p2_word_recognizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p3_sentence_memorizes`
--

LOCK TABLES `p3_sentence_memorizes` WRITE;
/*!40000 ALTER TABLE `p3_sentence_memorizes` DISABLE KEYS */;
INSERT INTO `p3_sentence_memorizes` VALUES (1,1,1,'Chào bạn.','/audio/P3/lesson1/1-chao-ban.mp3',NULL,NULL,NULL),(2,1,2,'Chào anh.','/audio/P3/lesson1/2-chao-anh.mp3',NULL,NULL,NULL),(3,1,3,'Chào chị.','/audio/P3/lesson1/3-chao-chi.mp3',NULL,NULL,NULL),(4,1,4,'Bạn tên là gì?','/audio/P3/lesson1/4-ban-ten-la-gi.mp3',NULL,NULL,NULL),(5,1,5,'Tôi tên là Nam.','/audio/P3/lesson1/5-toi-ten-la-nam.mp3',NULL,NULL,NULL),(6,1,6,'Bạn bao nhiêu tuổi?','/audio/P3/lesson1/6-ban-bao-nhieu-tuoi.mp3',NULL,NULL,NULL),(13,1,7,'Tôi mười tuổi.','/audio/P3/lesson1/7-toi-muoi-tuoi.mp3',NULL,NULL,NULL),(14,1,8,'Còn tôi, tôi chín tuổi.','/audio/P3/lesson1/8-con-toi-toi-chin-tuoi.mp3',NULL,NULL,NULL),(15,1,9,'Cháu mấy tuổi rồi?','/audio/P3/lesson1/9-chau-may-tuoi-roi.mp3',NULL,NULL,NULL),(16,1,10,'Dạ, cháu chín tuổi ạ.','/audio/P3/lesson1/10-da-chau-chin-tuoi-a.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p3_sentence_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p4_sentence_recognizes`
--

LOCK TABLES `p4_sentence_recognizes` WRITE;
/*!40000 ALTER TABLE `p4_sentence_recognizes` DISABLE KEYS */;
INSERT INTO `p4_sentence_recognizes` VALUES (1,1,0,'Tôi là học sinh.','audio/P4/audio_1_0.mp3',NULL,NULL,NULL),(2,1,1,'Em chín tuổi.','audio/P4/audio_1_1.mp3',NULL,NULL,NULL),(3,1,2,'Em mấy tuổi rồi ?','audio/P4/audio_1_2.mp3',NULL,NULL,NULL),(4,1,3,'Tôi tên là Nam.','audio/P4/audio_1_3.mp3',NULL,NULL,NULL),(5,1,4,'Bạn tên là gì?','audio/P4/audio_1_4.mp3',NULL,NULL,NULL),(6,1,5,'Tôi à, tôi tên là Hoa.','audio/P4/audio_1_5.mp3',NULL,NULL,NULL),(7,1,6,'Còn tôi, tôi tên là Lan.','audio/P4/audio_1_6.mp3',NULL,NULL,NULL),(8,1,7,'Cháu là học sinh à?','audio/P4/audio_1_7.mp3',NULL,NULL,NULL),(9,1,8,'Dạ, cháu là học sinh ạ','audio/P4/audio_1_8.mp3',NULL,NULL,NULL),(10,1,9,'Cháu bao nhiêu tuổi ?','audio/P4/audio_1_9.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p4_sentence_recognizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p5_dialogue_memorizes`
--

LOCK TABLES `p5_dialogue_memorizes` WRITE;
/*!40000 ALTER TABLE `p5_dialogue_memorizes` DISABLE KEYS */;
INSERT INTO `p5_dialogue_memorizes` VALUES (1,1,0,'- Chào bạn!|- Chào bạn!','audio/P5/audio_1_0.mp3',NULL,NULL,NULL),(2,1,1,'- Chào chị!|- Chào em!','audio/P5/audio_1_1.mp3',NULL,NULL,NULL),(3,1,2,'- Chào anh!|- Chào em!','audio/P5/audio_1_2.mp3',NULL,NULL,NULL),(4,1,3,'- Chào chú!|- Chào cháu!','audio/P5/audio_1_3.mp3',NULL,NULL,NULL),(5,1,4,'- Chào cô!|- Chào cháu!','audio/P5/audio_1_4.mp3',NULL,NULL,NULL),(6,1,5,'- Chào bác!|- Chào cháu!','audio/P5/audio_1_5.mp3',NULL,NULL,NULL),(7,1,6,'- Bạn tên là gì ?|- Tôi tên là Trung anh.','audio/P5/audio_1_6.mp3',NULL,NULL,NULL),(8,1,7,'- Cháu tên là gì?|- Cháu tên là Trung Anh.','audio/P5/audio_1_7.mp3',NULL,NULL,NULL),(9,1,8,'- Bạn mấy tuổi ?|- Tôi 7 tuổi.','audio/P5/audio_1_8.mp3',NULL,NULL,NULL),(10,1,9,'- Em bao nhiêu tuổi ?|- Em 7 tuổi ạ.','audio/P5/audio_1_9.mp3',NULL,NULL,NULL),(11,1,10,'- Bạn là hoc sinh à ?|- Ừ, tôi là học sinh.','audio/P5/audio_1_10.mp3',NULL,NULL,NULL),(12,1,11,'- Cháu là học sinh à ?|-Vâng ạ, cháu là học sinh.','audio/P5/audio_1_11.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p5_dialogue_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p6_dialogue_multiple_choices`
--

LOCK TABLES `p6_dialogue_multiple_choices` WRITE;
/*!40000 ALTER TABLE `p6_dialogue_multiple_choices` DISABLE KEYS */;
INSERT INTO `p6_dialogue_multiple_choices` VALUES (1,1,1,'- Chào bác. | - Chào...','cháu','anh','em',NULL,NULL,NULL),(2,1,2,'- Chào em. | - Chào...','anh','bạn','em',NULL,NULL,NULL),(3,1,3,'- Chào bạn. | - Chào...','bạn','chị','em',NULL,NULL,NULL),(4,1,4,'- Bạn tên là gì? | -... tên là Trung Anh','tôi','cháu','em',NULL,NULL,NULL),(5,1,5,'- Cháu tên là gì? | -... tên là Trung Anh.','cháu','em','anh',NULL,NULL,NULL),(6,1,6,'- Em... tuổi? | - Em 7 tuổi.','bao nhiêu','tên','là',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p6_dialogue_multiple_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p7_conversation_memorizes`
--

LOCK TABLES `p7_conversation_memorizes` WRITE;
/*!40000 ALTER TABLE `p7_conversation_memorizes` DISABLE KEYS */;
INSERT INTO `p7_conversation_memorizes` VALUES (0,1,0,0,'Trung Anh:| - Chào bạn!!','audio/P7/audio_1_0_0.mp3',NULL,NULL,NULL),(2,1,0,1,'Hoa:| - Chào bạn!!*','audio/P7/audio_1_0_1.mp3',NULL,NULL,NULL),(3,1,0,2,'Trung Anh:| -Tôi tên là Trung Anh.','audio/P7/audio_1_0_2.mp3',NULL,NULL,NULL),(4,1,0,3,'Hoa:|- Tôi tên là Hoa.*','audio/P7/audio_1_0_3.mp3',NULL,NULL,NULL),(5,1,0,4,'Trung Anh:| - Tôi bảy tuổi.','audio/P7/audio_1_0_4.mp3',NULL,NULL,NULL),(6,1,0,5,'Hoa:| - Tôi cũng bảy tuổi.*','audio/P7/audio_1_0_5.mp3',NULL,NULL,NULL),(7,1,1,0,'Trung Anh:| - Chào bạn!!','audio/P7/audio_1_1_0.mp3',NULL,NULL,NULL),(8,1,1,1,'Hoa:| - Chào bạn!!*','audio/P7/audio_1_1_1.mp3',NULL,NULL,NULL),(9,1,1,2,'Trung Anh :| - Tôi tên là Trung Anh, còn bạn?','audio/P7/audio_1_1_2.mp3',NULL,NULL,NULL),(10,1,1,3,'Hoa:| - Tôi à, tôi tên là Hoa.*','audio/P7/audio_1_1_3.mp3',NULL,NULL,NULL),(11,1,1,4,' |Tôi là học sinh, còn bạn?*','audio/P7/audio_1_1_4.mp3',NULL,NULL,NULL),(12,1,1,5,'Trung Anh:| - Tôi cũng là học sinh.','audio/P7/audio_1_1_5.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p7_conversation_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p8_conversation_fill_words`
--

LOCK TABLES `p8_conversation_fill_words` WRITE;
/*!40000 ALTER TABLE `p8_conversation_fill_words` DISABLE KEYS */;
INSERT INTO `p8_conversation_fill_words` VALUES (1,1,0,0,'– Chào *!','bạn',NULL,NULL,NULL),(13,1,0,1,'- * bạn!','Chào',NULL,NULL,NULL),(14,1,0,2,'- Tôi * là Trung Anh.','tên',NULL,NULL,NULL),(15,1,0,3,'Bạn tên * gì?','là',NULL,NULL,NULL),(16,1,0,4,'- * tên là Lan. Tôi 7 tuổi.','Tôi',NULL,NULL,NULL),(17,1,0,5,'- Tôi * 7 tuổi.','cũng',NULL,NULL,NULL),(18,1,0,6,'Tôi là *.Còn *?','học sinh,bạn',NULL,NULL,NULL),(19,1,0,7,'-Tôi * là học sinh.','cũng',NULL,NULL,NULL),(20,1,1,0,'- Chào *.','bác',NULL,NULL,NULL),(21,1,1,1,'- Chào cháu.',NULL,NULL,NULL,NULL),(22,1,1,2,'- * tên là gì ?','Cháu',NULL,NULL,NULL),(23,1,1,3,'- *, * tên là Trung Anh ạ','Dạ,cháu',NULL,NULL,NULL),(24,1,1,4,'- Cháu * tuổi ?','bao nhiêu',NULL,NULL,NULL),(25,1,1,5,'- * 9 * ạ. Cháu * học sinh.','Cháu,tuổi,là',NULL,NULL,NULL),(40,1,2,0,'- Chào chị.',NULL,NULL,NULL,NULL),(41,1,2,1,'- Chào *.','em',NULL,NULL,NULL),(42,1,2,2,' Em * là gì ?','tên',NULL,NULL,NULL),(43,1,2,3,'- * tên * Nam ạ.','Em,là',NULL,NULL,NULL),(44,1,2,4,'- Em * tuổi ?','mấy',NULL,NULL,NULL),(45,1,2,5,'- Em chín * ạ.','tuổi',NULL,NULL,NULL),(46,1,2,6,'- Em là *.','học sinh',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p8_conversation_fill_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p9_conversation_fill_sentences`
--

LOCK TABLES `p9_conversation_fill_sentences` WRITE;
/*!40000 ALTER TABLE `p9_conversation_fill_sentences` DISABLE KEYS */;
INSERT INTO `p9_conversation_fill_sentences` VALUES (1,1,0,0,'– Chào bạn !',NULL,NULL,NULL,NULL),(2,1,0,1,'– *','Chào bạn.',NULL,NULL,NULL),(3,1,0,2,'- Tôi tên là Trung Anh. Còn bạn ?',NULL,NULL,NULL,NULL),(4,1,0,3,'– *','Tôi tên là Nam.',NULL,NULL,NULL),(5,1,0,4,'Tôi 7 tuổi. Tôi là học sinh. *','Còn bạn ?',NULL,NULL,NULL),(6,1,0,5,'– *','Tôi cũng là học sinh.',NULL,NULL,NULL),(7,1,1,0,'-  Chào anh.',NULL,NULL,NULL,NULL),(8,1,1,1,'– *','Chào em.',NULL,NULL,NULL),(9,1,1,2,'*','Em tên là gì ?',NULL,NULL,NULL),(10,1,1,3,'- Em tên là Trung Anh ạ.',NULL,NULL,NULL,NULL),(11,1,1,4,'– *','Em bao nhiêu tuổi ?',NULL,NULL,NULL),(12,1,1,5,'- Em 9 tuổi ạ.',NULL,NULL,NULL,NULL),(13,1,1,6,'– *','Em là học sinh à ?',NULL,NULL,NULL),(14,1,1,7,'- Vâng, em là học sinh ạ.',NULL,NULL,NULL,NULL),(15,1,2,0,'- *','Chào bác ạ.',NULL,NULL,NULL),(16,1,2,1,'- Chào cháu.',NULL,NULL,NULL,NULL),(17,1,2,2,'- *','Cháu tên là gì.',NULL,NULL,NULL),(18,1,2,3,'- Cháu tên là Trung Anh ạ.',NULL,NULL,NULL,NULL),(19,1,2,4,'- *','Cháu mấy tuổi rồi ?',NULL,NULL,NULL),(20,1,2,5,'- Cháu 9 tuổi ạ.',NULL,NULL,NULL,NULL),(21,1,2,6,' *','Cháu là học sinh.',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p9_conversation_fill_sentences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (0,'learner','small pry',NULL,NULL,NULL),(100,'Super Administrator','bad ass',NULL,NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `situations`
--

LOCK TABLES `situations` WRITE;
/*!40000 ALTER TABLE `situations` DISABLE KEYS */;
INSERT INTO `situations` VALUES (1,1,1,'Situation_img/hinh.png','Chào các bạn.|Tôi tên là Trung Anh.|Tôi 9 tuổi.|Tôi là học sinh.','audio/Situation/lesson1/01-B01-S01.mp3',NULL,NULL,NULL),(2,2,1,'Situation_img/hinh1.png','- Chào bạn, bạn tên là gì?|- Tôi tên là Nam.|- Bạn bao nhiêu tuổi?|- Tôi 9 tuổi.|- Tôi là học sinh.','audio/Situation/lesson1/02-B01-S02.mp3',NULL,NULL,NULL),(3,3,1,'Situation_img/hinh.png','Chào anh.|Em tên là Trung Anh.|Em 9 tuổi.|Em là học sinh.','audio/Situation/lesson1/03-B01-S03.mp3',NULL,NULL,NULL),(4,4,1,'Situation_img/hinh1.png','- Chào em, em tên là gì?|- Em tên là Trung Anh.|- Em bao nhiêu tuổi?|- Em 9 tuổi ạ, em là học sinh.','audio/Situation/lesson1/04-B01-S04.mp3',NULL,NULL,NULL),(5,5,1,'Situation_img/hinh.png','Chào bác.|Cháu tên là Trung Anh.|Cháu 9 tuổi.|Cháu là học sinh.','audio/Situation/lesson1/05-B01-S05.mp3',NULL,NULL,NULL),(6,6,1,'Situation_img/hinh1.png','- Chào cháu, cháu tên là gì?|Cháu tên là Trung Anh ạ.|- Cháu mấy tuổi?|- Dạ, cháu 9 tuổi ạ, cháu là học sinh.','audio/Situation/lesson1/06-B01-S06.mp3',NULL,NULL,NULL),(7,7,1,'Situation_img/hinh.png','Còn bạn?|Bạn tên là gì?|Bạn bao nhiêu tuổi?|Bạn là học sinh à?','audio/Situation/lesson1/07-B01-S07.mp3',NULL,NULL,NULL),(8,8,1,'Situation_img/hinh1.png','Tôi à?|Tôi tên là...|Tôi... tuổi.|Tôi là học sinh.','audio/Situation/lesson1/08-B01-S08.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `situations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sondn','Son','Doan','sondn@gmail.com',1,'12345678','1995-12-01','publicimgavatar_2x.png',NULL,'VN',1,NULL,NULL,NULL,NULL),(2,'あの','あの日','あの','あの',NULL,'12345678','1995-12-01','あの',NULL,'VB',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-31 10:53:58
