-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: exp_4
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.20.04.1

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
-- Temporary view structure for view `coach_message`
--

DROP TABLE IF EXISTS `coach_message`;
/*!50001 DROP VIEW IF EXISTS `coach_message`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `coach_message` AS SELECT 
 1 AS `id`,
 1 AS `sex`,
 1 AS `username`,
 1 AS `name`,
 1 AS `tel`,
 1 AS `email`,
 1 AS `start`,
 1 AS `end`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `compete_message`
--

DROP TABLE IF EXISTS `compete_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compete_message` (
  `com_id` int NOT NULL AUTO_INCREMENT,
  `team1` varchar(50) NOT NULL DEFAULT (_utf8mb4'冬日'),
  `team2` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `state` enum('主场','客场') NOT NULL,
  PRIMARY KEY (`com_id`),
  KEY `team2` (`team2`),
  CONSTRAINT `compete_message_ibfk_1` FOREIGN KEY (`team2`) REFERENCES `team` (`team_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compete_message`
--

LOCK TABLES `compete_message` WRITE;
/*!40000 ALTER TABLE `compete_message` DISABLE KEYS */;
INSERT INTO `compete_message` VALUES (1,'冬日','Atlanta Hawks','Atlanta Arena','2024-06-01 18:00:00','2024-06-01 20:00:00','主场'),(2,'冬日','Boston Celtics','Boston Stadium','2024-06-02 19:00:00','2024-06-02 21:00:00','客场'),(3,'冬日','Brooklyn Nets','Brooklyn Center','2024-06-03 17:00:00','2024-06-03 19:00:00','主场'),(4,'冬日','Chicago Bulls','Chicago Coliseum','2024-06-04 18:30:00','2024-06-04 20:30:00','客场'),(5,'冬日','Cleveland Cavaliers','Cleveland Arena','2024-06-05 19:30:00','2024-06-05 21:30:00','主场'),(6,'冬日','Dallas Mavericks','Dallas Center','2024-06-06 18:00:00','2024-06-06 20:00:00','客场'),(7,'冬日','Denver Nuggets','Denver Stadium','2024-06-07 17:30:00','2024-06-07 19:30:00','主场'),(8,'冬日','Los Angeles Lakers','Los Angeles Coliseum','2024-06-08 18:45:00','2024-06-08 20:45:00','客场'),(9,'冬日','Golden State Warriors','Golden State Center','2024-06-09 19:15:00','2024-06-09 21:15:00','主场'),(10,'冬日','Atlanta Hawks','Atlanta Arena','2024-06-10 18:30:00','2024-06-10 20:30:00','客场'),(11,'冬日','Boston Celtics','Boston Stadium','2024-06-11 19:00:00','2024-06-11 21:00:00','主场'),(12,'冬日','Brooklyn Nets','Brooklyn Center','2024-06-12 17:45:00','2024-06-12 19:45:00','客场'),(13,'冬日','Chicago Bulls','Chicago Coliseum','2024-06-13 18:15:00','2024-06-13 20:15:00','主场'),(14,'冬日','Cleveland Cavaliers','Cleveland Arena','2024-06-14 19:30:00','2024-06-14 21:30:00','客场'),(15,'冬日','Dallas Mavericks','Dallas Center','2024-06-15 17:30:00','2024-06-15 19:30:00','主场'),(16,'冬日','Denver Nuggets','Denver Stadium','2024-06-16 18:00:00','2024-06-16 20:00:00','客场'),(17,'冬日','Los Angeles Lakers','Los Angeles Coliseum','2024-06-17 19:15:00','2024-06-17 21:15:00','主场'),(18,'冬日','Golden State Warriors','Golden State Center','2024-06-18 18:45:00','2024-06-18 20:45:00','客场'),(19,'冬日','Atlanta Hawks','Atlanta Arena','2024-06-19 19:30:00','2024-06-19 21:30:00','主场'),(20,'冬日','Boston Celtics','Boston Stadium','2024-06-20 18:00:00','2024-06-20 20:00:00','客场');
/*!40000 ALTER TABLE `compete_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract` (
  `id` int NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract`
--

LOCK TABLES `contract` WRITE;
/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
INSERT INTO `contract` VALUES (2,'2024-05-20','2025-06-25'),(4,'2024-05-20','2024-05-22'),(6,'2024-05-20','2026-10-15'),(7,'2024-05-20','2024-05-24'),(8,'2024-05-20','2024-05-24');
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_message`
--

DROP TABLE IF EXISTS `person_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_message` (
  `sex` enum('男','女','未知') DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `tel` varchar(15) DEFAULT (NULL),
  `email` varchar(256) DEFAULT (NULL),
  PRIMARY KEY (`username`),
  CONSTRAINT `person_message_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_message`
--

LOCK TABLES `person_message` WRITE;
/*!40000 ALTER TABLE `person_message` DISABLE KEYS */;
INSERT INTO `person_message` VALUES ('男','admin','18125965137','2113346861@qq.com'),('女','harden','1278596','123'),(NULL,'James','222','456'),('男','Kerr','123456789','kerr@qq.com'),(NULL,'LUE','null','null'),(NULL,'Popovich','null','123');
/*!40000 ALTER TABLE `person_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `person_users`
--

DROP TABLE IF EXISTS `person_users`;
/*!50001 DROP VIEW IF EXISTS `person_users`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `person_users` AS SELECT 
 1 AS `id`,
 1 AS `username`,
 1 AS `name`,
 1 AS `sex`,
 1 AS `identify`,
 1 AS `tel`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `player_basic_message`
--

DROP TABLE IF EXISTS `player_basic_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `player_basic_message` (
  `id` int NOT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `player_basic_message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player_basic_message`
--

LOCK TABLES `player_basic_message` WRITE;
/*!40000 ALTER TABLE `player_basic_message` DISABLE KEYS */;
INSERT INTO `player_basic_message` VALUES (2,200,160),(4,0,0);
/*!40000 ALTER TABLE `player_basic_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `player_message`
--

DROP TABLE IF EXISTS `player_message`;
/*!50001 DROP VIEW IF EXISTS `player_message`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `player_message` AS SELECT 
 1 AS `id`,
 1 AS `sex`,
 1 AS `username`,
 1 AS `name`,
 1 AS `tel`,
 1 AS `email`,
 1 AS `start`,
 1 AS `end`,
 1 AS `height`,
 1 AS `weight`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team` (
  `team_id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(50) NOT NULL,
  `team_clothes` varchar(50) DEFAULT NULL,
  `team_badge` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `team_name` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'冬日','champion winter','winter winner'),(2,'Atlanta Hawks','Hawks Uniform','Hawks Badge'),(3,'Boston Celtics','Celtics Uniform','Celtics Badge'),(4,'Brooklyn Nets','Nets Uniform','Nets Badge'),(5,'Chicago Bulls','Bulls Uniform','Bulls Badge'),(6,'Cleveland Cavaliers','Cavaliers Uniform','Cavaliers Badge'),(7,'Dallas Mavericks','Mavericks Uniform','Mavericks Badge'),(8,'Denver Nuggets','Nuggets Uniform','Nuggets Badge'),(9,'Los Angeles Lakers','Lakers Uniform','Lakers Badge'),(10,'Golden State Warriors','Warriors Uniform','Warriors Badge');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `identify` enum('管理员','球员','教练') NOT NULL,
  `status` enum('通过','审核中','未通过') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','蔡严冬','$2y$10$h8bgj05nTREvlb3UvVv/MuI.Nt5xIuANpncfn01anBvt19gFbMQQ6','管理员','通过'),(2,'Harden','James Harden','$2y$10$AJC2odvp/ogrXOuXkRhoB.SeorgnNEc0YIoLOKqwvtgFKoBw10bmy','球员','通过'),(4,'James','LBJ','$2y$10$tvCrlOpJCC0c4VLaaY2l3u4q9C92NNl358AJ3CzYKjg5pv1809Ava','球员','通过'),(6,'Kerr','Steve Kerr','$2y$10$aE9B.Oco0W1xOcVItSEIDO1X/W5e6uPO/oxxWCXZHM3BKyCHKY.Oe','教练','通过'),(7,'LUE','Tyronn Lue','$2y$10$eYFSECkNsqYyThTbgI3vw.rPfe8ixfv7uBN6CU9BHwpFyz6s33oom','教练','通过'),(8,'Popovich','Gregg Popovich','$2y$10$W89V1N9V1OJJMFlHboiCK.NKhECPLSCNbrTgp4qIojG9H39I61L8q','教练','通过');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `person_users_insert` AFTER INSERT ON `users` FOR EACH ROW begin
        insert into person_message(username) values (new.username);
    end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `user_status_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.status = '通过' AND (NEW.identify = '球员' OR NEW.identify = '教练') THEN
        IF NOT EXISTS (SELECT 1 FROM contract WHERE id = NEW.id) THEN
            INSERT INTO contract(id, start) VALUES (NEW.id, NOW());
        END IF;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `player_basic_message_insert` AFTER INSERT ON `users` FOR EACH ROW begin
    IF NEW.status = '通过' AND NEW.identify = '球员' THEN
        IF NOT EXISTS (SELECT 1 FROM player_basic_message WHERE id = NEW.id) THEN
            INSERT INTO player_basic_message(id) VALUES (NEW.id);
        END IF;
    END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `user_status_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    IF NEW.status = '通过' AND (NEW.identify = '球员' OR NEW.identify = '教练') THEN
        IF NOT EXISTS (SELECT 1 FROM contract WHERE id = NEW.id) THEN
            INSERT INTO contract(id, start) VALUES (NEW.id, NOW());
        END IF;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `player_basic_message_update` AFTER UPDATE ON `users` FOR EACH ROW begin
    IF NEW.status = '通过' AND NEW.identify = '球员' THEN
        IF NOT EXISTS (SELECT 1 FROM player_basic_message WHERE id = NEW.id) THEN
            INSERT INTO player_basic_message(id) VALUES (NEW.id);
        END IF;
    END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `coach_message`
--

/*!50001 DROP VIEW IF EXISTS `coach_message`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `coach_message` AS select 1 AS `id`,1 AS `sex`,1 AS `username`,1 AS `name`,1 AS `tel`,1 AS `email`,1 AS `start`,1 AS `end` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `person_users`
--

/*!50001 DROP VIEW IF EXISTS `person_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `person_users` AS select 1 AS `id`,1 AS `username`,1 AS `name`,1 AS `sex`,1 AS `identify`,1 AS `tel`,1 AS `email` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `player_message`
--

/*!50001 DROP VIEW IF EXISTS `player_message`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `player_message` AS select 1 AS `id`,1 AS `sex`,1 AS `username`,1 AS `name`,1 AS `tel`,1 AS `email`,1 AS `start`,1 AS `end`,1 AS `height`,1 AS `weight` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 17:35:02
