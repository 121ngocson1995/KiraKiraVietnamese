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
-- Dumping data for table `language_cultures`
--

LOCK TABLES `language_cultures` WRITE;
/*!40000 ALTER TABLE `language_cultures` DISABLE KEYS */;
INSERT INTO `language_cultures` VALUES (1,1,1,0,'Hình ảnh đất nước - con người Việt Nam','demo','exten/img/preview.jpg',NULL,NULL,'The map of Vietnam|National flag|Turtle Tower|Ha Long bay|Kindergarten|Rice field','exten/img/bando.jpg|exten/img/quocki.png|exten/img/thaprua.jpg|exten/img/halong.jpg|exten/img/nhatre.jpg|exten/img/donglua.jpg','','',NULL,NULL,NULL,NULL),(2,1,2,1,'Bài hát dành cho em','Con cò bé bé|Nó đậu cành tre|Đi không hỏi mẹ|Biết đi đường nào|Khi đi em hỏi|Khi về em chào|Miệng em chúm chím|Mẹ yêu không nào','exten/img/concobebe.jpg','exten/audio/mykn.mp3',NULL,NULL,NULL,'Lê Xuân Thọ','Thành Nguyễn',NULL,NULL,NULL,NULL),(3,1,3,2,'Em đọc thơ','Đi đến nơi nào|Lời chào đi trước|Lời chào dẫn bước|Chẳng sợ lạc nhà|Lời chào kết bạn|Con đường bớt xa','exten/img/preview.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,4,3,'Thành ngữ - Tục ngữ - Ca dao','Lời chào cao hơn mâm cỗ','exten/img/preview.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,5,4,'Thử đoán nào?','Con gì mào đỏ|Lông mượt như tơ|Sáng sớm tinh mơ|Gọi người thức dậy?','Situation_img/rooster.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,6,5,'Cùng chơi các bạn ơi!','Chi chi chành chành|Cái đanh thổi lửa|Con ngựa đứt cương|Ba Vương ngũ Đế|Bắt dế đi tìm...|Ù à ù ập...','exten/img/preview.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,0,0,0,NULL,'','exten/img/preview.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `language_cultures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `lesson_notes`
--

LOCK TABLES `lesson_notes` WRITE;
/*!40000 ALTER TABLE `lesson_notes` DISABLE KEYS */;
INSERT INTO `lesson_notes` VALUES (1,1,0,'When you are talking with someone who is male and several years older than you, you must call him “anh” and now you are “em”. “Anh” means an older man, “em” means a younger person for both male or female. If that person is female, you will call her “chị”, and you are still “em”.|If you are talking with someone who is many years older than you, who might be around your parent’s age, you will call him/her “bác”, and now you are “cháu”. |If that person is many years older than you, who might be around your grandparent’s age, you will call him/her “ông” for male and “bà” for female, and you are still “cháu”.|If you are talking with someone who is around your age, you can use “tôi” with that person and that person is now “bạn”.|“Dạ”, “Ạ”, “Vâng” are respectful words used while talking with older people.',NULL,NULL,NULL);
/*!40000 ALTER TABLE `lesson_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,1,1,'Hello','You will learn about various ways to greet people.','Trung NL',1,1,NULL,'2017-04-18 21:48:17',NULL);
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
INSERT INTO `p11_conversation_reorders` VALUES (13,1,'- abc','0,0,1,0,1','2017-04-19 02:00:49','2017-04-19 02:00:49',NULL),(14,1,'- ghj','1,1,0,1,0','2017-04-19 02:00:49','2017-04-19 02:00:49',NULL);
/*!40000 ALTER TABLE `p11_conversation_reorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p12_group_interactions`
--

LOCK TABLES `p12_group_interactions` WRITE;
/*!40000 ALTER TABLE `p12_group_interactions` DISABLE KEYS */;
INSERT INTO `p12_group_interactions` VALUES (1,1,'Tương tác nhóm','Các nhóm nhỏ trong lớp cùng nhau chuẩn bị và thực hành trong nhóm phần tự giới thiệu về mình. Sau đó các nhóm cùng nhau chỉnh sửa một bài chung và cử một bạn đại diện thay mặt nhóm tự giới thiệu trước toàn lớp. ','Each small group in class prepares and practices the self-introduction together. After that, all group should find out the best dialogue and then a representative group will be presented the self-introduction.',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p12_group_interactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p13_texts`
--

LOCK TABLES `p13_texts` WRITE;
/*!40000 ALTER TABLE `p13_texts` DISABLE KEYS */;
INSERT INTO `p13_texts` VALUES (1,1,'Viết một bài tự giới thiệu về mình.','Write an introduction about yourself.','Tôi tên là Trung Anh. Tôi 9 tuổi. Tôi là học sinh. Còn bạn, bạn tên là gì? Bạn bao nhiêu tuổi? Bạn cũng là học sinh à?',NULL,NULL,NULL);
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
INSERT INTO `p1_word_memorizes` VALUES (1,1,1,'chào','audio/P1/lesson1/1-chao.mp3',NULL,NULL,NULL),(2,1,2,'bạn','audio/P1/lesson1/2-ban.mp3',NULL,NULL,NULL),(3,1,3,'anh','audio/P1/lesson1/3-anh.mp3',NULL,NULL,NULL),(4,1,4,'chị','audio/P1/lesson1/4-chi.mp3',NULL,NULL,NULL),(5,1,5,'cô','audio/P1/lesson1/5-co.mp3',NULL,NULL,NULL),(6,1,6,'chú','audio/P1/lesson1/6-chu.mp3',NULL,NULL,NULL),(7,1,1,'bác','audio/P1/lesson1/7-bac.mp3',NULL,NULL,NULL),(8,1,2,'ông','audio/P1/lesson1/8-ong.mp3',NULL,NULL,NULL),(9,1,3,'bà','audio/P1/lesson1/9-ba.mp3',NULL,NULL,NULL),(10,1,4,'tôi','audio/P1/lesson1/10-toi.mp3',NULL,NULL,NULL),(11,1,5,'em','audio/P1/lesson1/11-em.mp3',NULL,NULL,NULL),(12,1,6,'cháu','audio/P1/lesson1/12-chau.mp3',NULL,NULL,NULL),(13,1,1,'tên','audio/P1/lesson1/13-ten.mp3',NULL,NULL,NULL),(14,1,2,'tuổi','audio/P1/lesson1/14-tuoi.mp3',NULL,NULL,NULL),(15,1,3,'các','audio/P1/lesson1/15-cac.mp3',NULL,NULL,NULL),(16,1,4,'ạ','audio/P1/lesson1/16-a.mp3',NULL,NULL,NULL),(17,1,5,'à','audio/P1/lesson1/17-a.mp3',NULL,NULL,NULL),(18,1,6,'dạ','audio/P1/lesson1/18-da.mp3',NULL,NULL,NULL),(19,1,7,'là','audio/P1/lesson1/19-la.mp3',NULL,NULL,NULL),(20,1,8,'bao nhiêu','audio/P1/lesson1/26-bao-nhieu.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p1_word_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p2_word_recognizes`
--

LOCK TABLES `p2_word_recognizes` WRITE;
/*!40000 ALTER TABLE `p2_word_recognizes` DISABLE KEYS */;
INSERT INTO `p2_word_recognizes` VALUES (1,1,'tôi','audio/P2/lesson1/1-toi.mp3',NULL,NULL,NULL),(2,1,'chín','audio/P2/lesson1/2-chin.mp3',NULL,NULL,NULL),(3,1,'bao nhiêu','audio/P2/lesson1/3-bao-nhieu.mp3',NULL,NULL,NULL),(4,1,'tuổi','audio/P2/lesson1/4-tuoi.mp3',NULL,NULL,NULL),(5,1,'tên','audio/P2/lesson1/5-ten.mp3',NULL,NULL,NULL),(6,1,'chào','audio/P2/lesson1/6-chao.mp3',NULL,NULL,NULL),(7,1,'bạn','audio/P2/lesson1/7-ban.mp3',NULL,NULL,NULL),(8,1,'em','audio/P2/lesson1/8-em.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p2_word_recognizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p3_sentence_memorizes`
--

LOCK TABLES `p3_sentence_memorizes` WRITE;
/*!40000 ALTER TABLE `p3_sentence_memorizes` DISABLE KEYS */;
INSERT INTO `p3_sentence_memorizes` VALUES (1,1,1,'Chào bạn.','audio/P3/lesson1/1-chao-ban.mp3',NULL,NULL,NULL),(2,1,2,'Chào anh.','audio/P3/lesson1/2-chao-anh.mp3',NULL,NULL,NULL),(3,1,3,'Chào chị.','audio/P3/lesson1/3-chao-chi.mp3',NULL,NULL,NULL),(4,1,4,'Bạn tên là gì?','audio/P3/lesson1/4-ban-ten-la-gi.mp3',NULL,NULL,NULL),(5,1,5,'Tôi tên là Nam.','audio/P3/lesson1/5-toi-ten-la-nam.mp3',NULL,NULL,NULL),(6,1,6,'Bạn bao nhiêu tuổi?','audio/P3/lesson1/6-ban-bao-nhieu-tuoi.mp3',NULL,NULL,NULL),(13,1,7,'Tôi mười tuổi.','audio/P3/lesson1/7-toi-muoi-tuoi.mp3',NULL,NULL,NULL),(14,1,8,'Còn tôi, tôi chín tuổi.','audio/P3/lesson1/8-con-toi-toi-chin-tuoi.mp3',NULL,NULL,NULL),(15,1,9,'Cháu mấy tuổi rồi?','audio/P3/lesson1/9-chau-may-tuoi-roi.mp3',NULL,NULL,NULL),(16,1,10,'Dạ, cháu chín tuổi ạ.','audio/P3/lesson1/10-da-chau-chin-tuoi-a.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p3_sentence_memorizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p4_sentence_recognizes`
--

LOCK TABLES `p4_sentence_recognizes` WRITE;
/*!40000 ALTER TABLE `p4_sentence_recognizes` DISABLE KEYS */;
INSERT INTO `p4_sentence_recognizes` VALUES (1,1,'Tôi là học sinh.','audio/P4/audio_1_0.mp3',NULL,NULL,NULL),(2,1,'Em chín tuổi.','audio/P4/audio_1_1.mp3',NULL,NULL,NULL),(3,1,'Em mấy tuổi rồi ?','audio/P4/audio_1_2.mp3',NULL,NULL,NULL),(4,1,'Tôi tên là Nam.','audio/P4/audio_1_3.mp3',NULL,NULL,NULL),(5,1,'Bạn tên là gì?','audio/P4/audio_1_4.mp3',NULL,NULL,NULL),(6,1,'Tôi à? Tôi tên là Hoa.','audio/P4/audio_1_5.mp3',NULL,NULL,NULL),(7,1,'Còn tôi, tôi tên là Lan.','audio/P4/audio_1_6.mp3',NULL,NULL,NULL),(8,1,'Cháu là học sinh à?','audio/P4/audio_1_7.mp3',NULL,NULL,NULL),(9,1,'Dạ, cháu là học sinh ạ','audio/P4/audio_1_8.mp3',NULL,NULL,NULL),(10,1,'Cháu bao nhiêu tuổi ?','audio/P4/audio_1_9.mp3',NULL,NULL,NULL);
/*!40000 ALTER TABLE `p4_sentence_recognizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `p5_dialogue_memorizes`
--

LOCK TABLES `p5_dialogue_memorizes` WRITE;
/*!40000 ALTER TABLE `p5_dialogue_memorizes` DISABLE KEYS */;
INSERT INTO `p5_dialogue_memorizes` VALUES (1,1,0,'- Chào bạn!|- Chào bạn!','audio/P5/B1_P5_D1.mp3',NULL,NULL,NULL),(2,1,1,'- Chào anh!|- Chào em!','audio/P5/B1_P5_D2.mp3',NULL,NULL,NULL),(3,1,2,'- Chào chị!|- Chào em!','audio/P5/B1_P5_D3.mp3',NULL,NULL,NULL),(4,1,3,'- Chào chú!|- Chào cháu!','audio/P5/B1_P5_D4.mp3',NULL,NULL,NULL),(5,1,4,'- Chào cô!|- Chào cháu!','audio/P5/B1_P5_D5.mp3',NULL,NULL,NULL),(6,1,5,'- Chào bác!|- Chào cháu!','audio/P5/B1_P5_D6.mp3',NULL,NULL,NULL),(7,1,6,'- Bạn tên là gì?|- Tôi tên là Trung Anh.','audio/P5/B1_P5_D7.mp3',NULL,NULL,NULL),(8,1,7,'- Cháu tên là gì?|- Cháu tên là Trung Anh.','audio/P5/B1_P5_D8.mp3',NULL,NULL,NULL),(9,1,8,'- Bạn mấy tuổi?|- Tôi 9 tuổi.','audio/P5/B1_P5_D9.mp3',NULL,NULL,NULL),(10,1,9,'- Em bao nhiêu tuổi?|- Em 9 tuổi ạ.','audio/P5/B1_P5_D10.mp3',NULL,NULL,NULL),(11,1,10,'- Bạn là hoc sinh à?|- Ừ, tôi là học sinh.','audio/P5/B1_P5_D11.mp3',NULL,NULL,NULL),(12,1,11,'- Cháu là học sinh à?|-Vâng ạ, cháu là học sinh ạ.','audio/P5/B1_P5_D12.mp3',NULL,NULL,NULL);
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
INSERT INTO `p7_conversation_memorizes` VALUES (0,1,3,'Trung Anh :* - Chào anh.|Ba :* - Chào em.| *- Em tên là gì?|Trung Anh:* - Em tên là Trung Anh ạ.|Ba :* - Em mấy tuổi rồi?|Trung Anh :* - Em 9 tuổi ạ.|Ba :* - Em là học sinh à?|Trung Anh :* - Vâng, em là học sinh ạ.','audio/P7/lesson1/audio_3.mp3',NULL,NULL,NULL),(1,1,0,'Trung Anh :* - Chào bạn.|Hoa :* - Chào bạn.|Trung Anh :* - Tôi tên là Trung Anh.|Hoa :* - Tôi tên là Hoa.|Trung Anh :* - Tôi chín tuổi.|Hoa :* - Tôi cũng chín tuổi.','audio/P7/lesson1/audio_0.mp3',NULL,NULL,NULL),(2,1,1,'Trung Anh :* - Chào bạn.|Hoa :* - Chào bạn.|Trung Anh :* - Tôi tên là Trung Anh, còn bạn?|Hoa :* - Tôi à, tôi tên là Hoa.| *-  Tôi là học sinh, còn bạn?|Trung Anh :* - Tôi cũng là học sinh.','audio/P7/lesson1/audio_1.mp3',NULL,NULL,NULL),(3,1,2,'Trung Anh :*  - Chào bạn.|Hoa :* - Chào bạn.|Trung Anh :* - Tôi tên là Trung Anh, còn bạn?|Hoa :* - Tôi tên là Hoa.| * - Tôi chín tuổi, còn bạn?|Trung Anh :* - Tôi cũng chín tuổi.| *-  Tôi là học sinh.|Hoa :*- Tôi cũng là học sinh.','audio/P7/lesson1/audio_2.mp3',NULL,NULL,NULL);
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
INSERT INTO `roles` VALUES (0,'No role','small pry',NULL,NULL,NULL),(1,'Applicant','peasant',NULL,NULL,NULL),(2,'Learner','so so',NULL,NULL,NULL),(3,'Teacher','bad ass',NULL,NULL,NULL),(10,'Admin','a',NULL,NULL,NULL),(100,'Super Administrator','a',NULL,NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `situations`
--

LOCK TABLES `situations` WRITE;
/*!40000 ALTER TABLE `situations` DISABLE KEYS */;
INSERT INTO `situations` VALUES (1,1,1,'Situation_img/S1.png','- Chào các bạn.|- Tôi tên là Trung Anh.|- Tôi 9 tuổi.|- Tôi là học sinh.','Hello!|My name is Trung Anh.|I am nine years old.|I am a pupil.','audio/Situation/lesson1/01-B01-S01.mp3',NULL,NULL,NULL),(2,2,1,'Situation_img/S2.png','- Chào bạn, bạn tên là gì?|- Tôi tên là Nam.|- Bạn bao nhiêu tuổi?|- Tôi 9 tuổi. Tôi là học sinh.','Hi, what is your name?|My name is Nam.|How old are you?|I am nine. I am a pupil.','audio/Situation/lesson1/02-B01-S02.mp3',NULL,NULL,NULL),(3,3,1,'Situation_img/S3.png','- Chào anh.|- Em tên là Trung Anh.|- Em 9 tuổi.|- Em là học sinh.','Hello.|My name is Trung Anh.|I am nine.|I am a pupil.','audio/Situation/lesson1/03-B01-S03.mp3',NULL,NULL,NULL),(4,4,1,'Situation_img/S4.png','- Chào em, em tên là gì?|- Em tên là Trung Anh.|- Em bao nhiêu tuổi?|- Em 9 tuổi ạ, em là học sinh.','Hi, what is your name?|My name is Trung Anh.|How old are you?|I am nine. I am a pupil.','audio/Situation/lesson1/04-B01-S04.mp3',NULL,NULL,NULL),(5,5,1,'Situation_img/S5.png','- Chào bác.|- Cháu tên là Trung Anh.|- Cháu 9 tuổi.|- Cháu là học sinh.','Hello.|My name is Trung Anh?|I am nine|I am a pupil.','audio/Situation/lesson1/05-B01-S05.mp3',NULL,NULL,NULL),(6,6,1,'Situation_img/S6.png','- Chào cháu, cháu tên là gì?|- Cháu tên là Trung Anh ạ.|- Cháu mấy tuổi?|- Dạ, cháu 9 tuổi ạ, cháu là học sinh.','Hi, what is your name?|My name is Trung Anh.|How old are you?|I am nine. I am a pupil.','audio/Situation/lesson1/06-B01-S06.mp3',NULL,NULL,NULL),(7,7,1,'Situation_img/S7.png','- Còn bạn?|- Bạn tên là gì?|- Bạn bao nhiêu tuổi?|- Bạn là học sinh à?','How about you?|What is your name?|How old are you?|Are you a pupil?','audio/Situation/lesson1/07-B01-S07.mp3',NULL,NULL,NULL),(8,8,1,'Situation_img/S8.png','- Tôi à?|- Tôi tên là...|- Tôi... tuổi.|- Tôi là học sinh.','Me?|My name is...|I am ... years old.|I am a pupil.','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `situations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sondn','Son','Doan','sondn@gmail.com',1,'12345678','1995-12-01','publicimgavatar_2x.png',NULL,NULL,'VN',1,NULL,NULL,NULL,NULL),(2,'あの','あの日','あの','あの',NULL,'12345678','1995-12-01','あの','',NULL,'VB',1,NULL,NULL,NULL,NULL),(3,'ngocson','aaaa','aaaa','abc123@gmail.com',1,'$2y$10$yC/x9il2Z0yql0ay34qZE.pZN2e0Pfb22qtYqNWojXcCnZ3w1shce','1998-01-05','publicimgavatar_2x.png',NULL,NULL,NULL,100,'X853G87EERfuGrT6Sc8OFR9tPjVetc3GVIpPf7vnDBHitPZjAIDzGFZEzn2M','2017-04-03 03:59:15','2017-04-16 08:39:57',NULL),(4,'ngocson',NULL,NULL,'super_musix@yahoo.com.vn',NULL,'$2y$10$Aqie4yfCXUtoOAx4qWqHueceyA.4vKyieaFIuwgzWWJcVaL/L4UHu',NULL,'publicimgavatar_2x.png',NULL,NULL,NULL,0,'HOTPZ36RfafQbB3FyGt0sbYWHMNVWcEWQrrTxischOIoRl8lOh80ejl51EqR','2017-04-14 14:05:21','2017-04-14 14:05:21',NULL),(5,'aaa',NULL,NULL,'super_musix1@yahoo.com.vn',NULL,'$2y$10$3yTjiMqoDGbnXmPgekkCdO7KtWOgNuAaJiSfKa0sPUpvLCSfDQI8K',NULL,'publicimgavatar_2x.png',NULL,NULL,NULL,0,'ur7deoxIusf7JRHxz9KkCOg6ZgrPqdRlSgsBvR81Nq3DRa7mfqt8zQVytvUn','2017-04-14 14:56:13','2017-04-14 14:56:13',NULL),(6,'111',NULL,NULL,'super_musix2@yahoo.com.vn',NULL,'$2y$10$7AEB9C11aGfvE/NzTHze7OHjstByZEl573.pXHuo6dUDnO3dH7kvC',NULL,'public/img/avatar_2x.png',NULL,NULL,NULL,10,NULL,'2017-04-14 14:59:22','2017-04-14 14:59:22',NULL),(7,'11111','abc','abc','super_musix@yahoo.com.vn3',1,'$2y$10$rmA/Q.1KN3mkwJfLnauFk.2xC06/umpgkmJ9kMOqXlCisZUeuOZY6','2017-04-03','public/img/avatar_2x.png',NULL,NULL,NULL,3,'yc7KKh3CwwJRK5ewVWxypynwPaMZvP1LCV1ZSGCa2AscyLA0uZT7u2sW05Nl','2017-04-15 14:10:01','2017-04-17 17:28:03',NULL),(8,'bbbb','b','b','super_musix@yahoo.com.vn1',1,'$2y$10$irC3AItx.7p7uTZlxBxSy.QEVFEGQ0ZUqeogXAYgT0SpZVyQ/147e','1996-01-01','public/img/avatar_2x.png',NULL,NULL,NULL,1,'GLKPpx4JHBJs0sh9je1eM2rBTiFuAbrEP885RspRYeOy08GualQ78MPA5bGC','2017-04-17 21:56:27','2017-04-17 21:56:27',NULL),(9,'bbbbbb','Son','Doan','super_musix@yahoo.com.vn2',1,'$2y$10$RwHqGqfyWZqic.QTdN4lVOM4EU6h4mW9PrW.J3L5Jaz6QpSYH0tba','1992-01-06','public/img/avatar_2x.png',NULL,NULL,NULL,1,'OqdwZyVLw6cJV8XAEkDlRYgCSD8n95VM5u2i6yk5u1BQ26iUxZ0bBm4lUDPW','2017-04-17 22:04:58','2017-04-17 22:04:58',NULL),(10,'cc','Son','Doan','super_musix@yahoo.com.vn4',0,'$2y$10$q4pfdq7VRRyoKmAHhe8iJeACHeKr/BcmGRwxTuH5GR22y2t/ZQ.aC','1994-01-03','public/img/avatar_2x.png','public/cv/CV_cc_2017-04-18-05-06-45.pdf',NULL,NULL,1,'IGSlw6B2VOEwEuGiAg2wkcsaepbE9QDxfdHlDXGeDTBCFsm6L03veRzn4uf7','2017-04-17 22:06:45','2017-04-17 22:06:45',NULL);
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

-- Dump completed on 2017-04-19 17:50:46
