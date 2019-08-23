# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.7.13)
# Схема: upbrain
# Время создания: 2016-07-03 20:12:00 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы administrators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `administrators`;

CREATE TABLE `administrators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administrators_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;

INSERT INTO `administrators` (`id`, `username`, `password`, `name`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Aglok','$2y$10$yDsE.VWglniXoCmP/4c33uBXeP28f.W0qqCgqTVWiluUlarAuJFYq','Aglok','r42n64ifPdAKv0l3GJQSmRufHa5EBHcHCQiZYxNW3CjDsGqOWuJYX0ZG5sAp','2015-12-31 22:41:50','2016-05-22 19:14:01'),
	(2,'Anna','$2y$10$dO2DhKwVwVfmWvTWFWp7mOPM3KySSO8cm/RVgE7lGoyYh3c1dLXwi','Anna','uChabINcM4SKlbfdQtJo1yfvA8nS7mnyZQWZsivSDIXAZhuwuV5DYOLfm7um','2016-05-08 22:02:38','2016-05-08 22:12:59'),
	(4,'Egor','$2y$10$9a/iNo7qoS8a/SkhIkE6cOOBgCZZAd1KbIFUvy9vlBPbd0uY9fl2S','Egor','43jRp3rFWSP2Ygc7Gpv9tDn2pMiz9h3ebdv6AqL8za1FJeYhFNztXaKG1Ucr','2016-05-08 22:12:14','2016-05-08 22:13:18');

/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы categories_subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories_subjects`;

CREATE TABLE `categories_subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_category_id` tinyint(4) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `categories_subjects` WRITE;
/*!40000 ALTER TABLE `categories_subjects` DISABLE KEYS */;

INSERT INTO `categories_subjects` (`id`, `name`, `parent_category_id`, `code`)
VALUES
	(1,'Алгебра',0,'1'),
	(2,'Числа корни и степени',0,'1.1'),
	(3,'Основы тригонометрии',0,'1.2');

/*!40000 ALTER TABLE `categories_subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы grade
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grade`;

CREATE TABLE `grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` tinyint(4) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `sum_tasks` tinyint(4) NOT NULL,
  `time` tinyint(4) NOT NULL,
  `number_lesson` tinyint(4) NOT NULL,
  `sum_exp` tinyint(4) NOT NULL,
  `sum_gold` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `grade_char` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;

INSERT INTO `grade` (`id`, `subject_id`, `user_id`, `sum_tasks`, `time`, `number_lesson`, `sum_exp`, `sum_gold`, `created_at`, `updated_at`, `grade_char`)
VALUES
	(9,2,2,1,0,1,5,1,'2016-02-23 04:30:38','2016-02-23 04:30:38','D'),
	(10,1,2,1,0,1,5,1,'2016-02-23 04:30:38','2016-02-23 04:30:38','C'),
	(11,1,2,0,0,1,15,3,'2016-02-24 04:24:01','2016-02-24 04:24:01','D'),
	(12,2,2,0,0,1,5,1,'2016-02-24 04:24:01','2016-02-24 04:24:01','D'),
	(13,1,2,0,0,1,5,1,'2016-02-24 04:24:01','2016-02-24 04:24:01','C'),
	(14,1,4,0,0,1,15,3,'2016-02-24 04:26:32','2016-02-24 04:26:32','D'),
	(15,2,4,0,0,1,5,1,'2016-02-24 04:26:32','2016-02-24 04:26:32','D'),
	(16,1,4,0,0,1,5,1,'2016-02-24 04:26:32','2016-02-24 04:26:32','C'),
	(17,2,2,0,0,1,0,0,'2016-02-29 03:49:17','2016-02-29 03:49:17','D'),
	(18,1,2,0,0,1,0,0,'2016-02-29 03:49:17','2016-02-29 03:49:17','C'),
	(19,2,2,0,0,1,0,0,'2016-02-29 03:51:14','2016-02-29 03:51:14','D'),
	(20,1,2,0,0,1,0,0,'2016-02-29 03:51:14','2016-02-29 03:51:14','C'),
	(21,1,2,0,0,1,0,0,'2016-02-29 04:01:10','2016-02-29 04:01:10','D'),
	(22,2,1,0,0,1,0,0,'2016-03-05 01:49:44','2016-03-05 01:49:44','D'),
	(23,1,1,0,0,1,0,0,'2016-03-05 01:49:44','2016-03-05 01:49:44','C'),
	(24,2,2,0,0,1,0,0,'2016-03-18 01:58:56','2016-03-18 01:58:56','D'),
	(25,1,2,0,0,1,0,0,'2016-03-18 01:58:56','2016-03-18 01:58:56','C'),
	(26,1,3,0,0,1,0,0,'2016-04-02 20:51:45','2016-04-02 20:51:45','D'),
	(27,2,3,0,0,1,0,0,'2016-04-02 20:51:45','2016-04-02 20:51:45','D'),
	(28,1,3,0,0,1,0,0,'2016-04-02 20:51:45','2016-04-02 20:51:45','C'),
	(29,1,3,0,0,1,0,0,'2016-04-02 20:52:26','2016-04-02 20:52:26','D'),
	(30,2,3,0,0,1,0,0,'2016-04-02 20:52:26','2016-04-02 20:52:26','D'),
	(31,1,3,0,0,1,0,0,'2016-04-02 20:52:26','2016-04-02 20:52:26','C'),
	(32,1,4,0,0,1,0,0,'2016-04-02 21:14:57','2016-04-02 21:14:57','D'),
	(33,1,2,0,0,1,0,0,'2016-04-02 21:32:45','2016-04-02 21:32:45','D'),
	(34,2,2,0,0,1,0,0,'2016-04-02 21:32:45','2016-04-02 21:32:45','D'),
	(35,1,2,0,0,1,0,0,'2016-04-02 21:32:45','2016-04-02 21:32:45','C'),
	(36,1,2,0,0,1,0,0,'2016-04-02 21:33:37','2016-04-02 21:33:37','D'),
	(37,2,2,0,0,1,0,0,'2016-04-02 21:33:37','2016-04-02 21:33:37','D'),
	(38,1,2,0,0,1,0,0,'2016-04-02 21:33:37','2016-04-02 21:33:37','C'),
	(39,2,2,0,0,1,0,0,'2016-04-02 21:36:14','2016-04-02 21:36:14','D'),
	(40,1,2,0,0,1,0,0,'2016-04-02 21:36:14','2016-04-02 21:36:14','C'),
	(41,2,2,0,0,1,0,0,'2016-04-02 21:36:25','2016-04-02 21:36:25','D'),
	(42,1,2,0,0,1,0,0,'2016-04-02 21:36:25','2016-04-02 21:36:25','C'),
	(43,1,2,0,0,1,0,0,'2016-04-02 21:36:54','2016-04-02 21:36:54','D'),
	(44,2,2,0,0,1,0,0,'2016-04-02 21:36:54','2016-04-02 21:36:54','D'),
	(45,1,2,1,0,1,0,0,'2016-04-02 21:36:54','2016-04-02 21:36:54','C'),
	(46,1,2,0,0,1,0,0,'2016-04-02 21:38:03','2016-04-02 21:38:03','D'),
	(47,2,2,0,0,1,0,0,'2016-04-02 21:38:03','2016-04-02 21:38:03','D'),
	(48,1,2,0,0,1,0,0,'2016-04-02 21:38:03','2016-04-02 21:38:03','C'),
	(49,1,2,0,0,1,0,0,'2016-04-02 21:43:07','2016-04-02 21:43:07','C'),
	(50,2,2,0,0,1,0,0,'2016-04-02 21:43:40','2016-04-02 21:43:40','D'),
	(51,2,2,0,0,1,0,0,'2016-04-02 22:02:19','2016-04-02 22:02:19','D'),
	(52,1,2,0,0,1,0,0,'2016-04-02 22:02:19','2016-04-02 22:02:19','C'),
	(53,1,2,0,0,1,0,0,'2016-04-02 22:02:48','2016-04-02 22:02:48','D'),
	(54,1,2,0,0,1,0,0,'2016-04-02 22:13:18','2016-04-02 22:13:18','C'),
	(55,1,2,0,0,1,0,0,'2016-04-02 22:16:14','2016-04-02 22:16:14','C'),
	(56,1,2,0,0,1,0,0,'2016-04-02 22:24:40','2016-04-02 22:24:40','C'),
	(57,2,2,0,0,1,0,0,'2016-04-02 22:29:29','2016-04-02 22:29:29','D'),
	(58,1,2,0,0,1,0,0,'2016-04-02 22:29:29','2016-04-02 22:29:29','C'),
	(59,2,2,0,0,1,0,0,'2016-04-02 22:43:35','2016-04-02 22:43:35','D'),
	(60,1,2,0,0,1,0,0,'2016-04-02 22:43:35','2016-04-02 22:43:35','C'),
	(61,2,2,1,0,1,5,1,'2016-04-02 22:54:23','2016-04-02 22:54:23','D'),
	(62,1,2,1,0,1,5,1,'2016-04-02 22:54:23','2016-04-02 22:54:23','C'),
	(63,1,3,5,0,1,25,5,'2016-04-20 00:57:02','2016-04-20 00:57:02','D'),
	(64,1,5,3,0,1,15,3,'2016-04-21 00:59:04','2016-04-21 00:59:04','D'),
	(65,1,5,3,0,1,15,3,'2016-04-21 01:16:59','2016-04-21 01:16:59','D'),
	(66,2,5,1,0,1,5,1,'2016-04-21 01:16:59','2016-04-21 01:16:59','D'),
	(67,1,5,1,0,1,5,1,'2016-04-21 01:16:59','2016-04-21 01:16:59','C'),
	(68,1,3,3,0,1,15,3,'2016-04-24 00:43:58','2016-04-24 00:43:58','D'),
	(69,2,3,1,0,1,5,1,'2016-04-24 00:43:58','2016-04-24 00:43:58','D'),
	(70,1,3,1,0,1,5,1,'2016-04-24 00:43:58','2016-04-24 00:43:58','C'),
	(71,1,3,3,0,1,15,3,'2016-04-24 00:47:56','2016-04-24 00:47:56','D'),
	(72,2,3,1,0,1,5,1,'2016-04-24 00:47:56','2016-04-24 00:47:56','D'),
	(73,1,3,1,0,1,5,1,'2016-04-24 00:47:56','2016-04-24 00:47:56','C'),
	(74,1,2,3,0,1,15,3,'2016-04-24 00:49:16','2016-04-24 00:49:16','D'),
	(75,2,2,1,0,1,5,1,'2016-04-24 00:49:17','2016-04-24 00:49:17','D'),
	(76,1,2,1,0,1,5,1,'2016-04-24 00:49:17','2016-04-24 00:49:17','C'),
	(77,2,4,1,0,1,5,1,'2016-04-24 00:54:40','2016-04-24 00:54:40','D'),
	(78,1,4,1,0,1,5,1,'2016-04-24 00:54:40','2016-04-24 00:54:40','C'),
	(79,1,3,3,0,1,15,3,'2016-04-24 00:55:57','2016-04-24 00:55:57','D'),
	(80,2,3,1,0,1,5,1,'2016-04-24 00:55:57','2016-04-24 00:55:57','D'),
	(81,1,3,1,0,1,5,1,'2016-04-24 00:55:57','2016-04-24 00:55:57','C'),
	(82,1,4,5,0,1,25,5,'2016-04-24 01:03:11','2016-04-24 01:03:11','D');

/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы messenger_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messenger_messages`;

CREATE TABLE `messenger_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `images` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;

INSERT INTO `messenger_messages` (`id`, `thread_id`, `user_id`, `body`, `created_at`, `updated_at`, `images`, `dir`)
VALUES
	(1,1,4,'Привет!','2016-05-23 00:39:00','2016-05-23 00:39:00',NULL,NULL),
	(2,1,4,'Задача №3 \r\nОтвет: 12','2016-05-23 00:53:14','2016-05-23 00:53:14',NULL,NULL),
	(3,1,4,'Еще решил! 14 задачу.','2016-05-23 00:55:14','2016-05-23 00:55:14',NULL,NULL),
	(4,1,4,'Отсылаю сообщение Aglok!','2016-05-23 01:11:51','2016-05-23 01:11:51',NULL,NULL),
	(5,2,1,'Всем привет!','2016-05-24 21:21:06','2016-05-24 21:21:06',NULL,NULL),
	(6,2,1,'Привет Михоил!','2016-05-24 21:26:46','2016-05-24 21:26:46',NULL,NULL),
	(7,1,1,'Hi! ','2016-06-20 21:42:30','2016-06-20 21:42:30',NULL,NULL),
	(8,2,1,'img yes!','2016-06-20 21:50:28','2016-06-20 21:50:28','200616_215027_0.jpeg|200616_215027_1.jpeg|200616_215028_2.jpeg',NULL),
	(9,1,1,'Good. sua','2016-06-20 22:00:22','2016-06-20 22:00:22','200616_220021_0.jpeg|200616_220022_1.jpeg',NULL),
	(10,2,1,'Hi& Friend!','2016-06-20 23:28:15','2016-06-20 23:28:15','200616_232813_0.jpeg|200616_232814_1.jpeg|200616_232814_2.jpeg','messages/Artem_Perlov'),
	(11,2,1,'Моя очередь!','2016-06-20 23:39:37','2016-06-20 23:39:37','200616_233936_0.jpeg|200616_233937_1.jpeg','messages/Artem_Perlov'),
	(12,1,1,'Ещё фото!','2016-06-20 23:40:54','2016-06-20 23:40:54','200616_234052_0.jpeg|200616_234053_1.jpeg|200616_234053_2.jpeg|200616_234053_3.jpeg|200616_234054_4.jpeg','messages/Artem_Perlov'),
	(13,2,1,'Привет!','2016-06-21 00:20:22','2016-06-21 00:20:22','210616_002021_0.jpeg|210616_002021_1.jpeg','messages/Artem_Perlov'),
	(14,1,1,'Ok!','2016-06-21 02:28:06','2016-06-21 02:28:06','210616_022804_0.jpeg|210616_022805_1.jpeg|210616_022805_2.jpeg','messages/Artem_Perlov'),
	(15,3,1,'Привет!','2016-06-29 23:30:05','2016-06-29 23:30:05',NULL,NULL),
	(16,4,1,'Еще одна тема!','2016-06-29 23:33:12','2016-06-29 23:33:12',NULL,NULL),
	(17,5,1,'Еще одна тема!','2016-06-29 23:34:21','2016-06-29 23:34:21',NULL,NULL),
	(18,6,1,'','2016-06-30 03:00:34','2016-06-30 03:00:34',NULL,NULL),
	(19,7,1,'Я решил задачу!','2016-06-30 03:23:17','2016-06-30 03:23:17',NULL,NULL);

/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы messenger_participants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messenger_participants`;

CREATE TABLE `messenger_participants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `last_read` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `messenger_participants` WRITE;
/*!40000 ALTER TABLE `messenger_participants` DISABLE KEYS */;

INSERT INTO `messenger_participants` (`id`, `thread_id`, `user_id`, `last_read`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,4,'2016-05-23 01:12:00','2016-05-23 00:39:00','2016-05-23 01:12:00',NULL),
	(2,1,2,NULL,'2016-05-23 00:53:14','2016-05-23 00:53:14',NULL),
	(3,1,5,NULL,'2016-05-23 00:55:14','2016-05-23 00:55:14',NULL),
	(4,1,1,'2016-07-01 16:50:01','2016-07-01 16:50:01','2016-07-01 16:50:01',NULL),
	(5,2,1,'2016-06-30 04:22:17','2016-06-30 04:22:17','2016-06-30 04:22:17',NULL),
	(6,2,4,'2016-05-24 21:26:58','2016-05-24 21:26:46','2016-05-24 21:26:58',NULL),
	(7,3,1,'2016-06-30 04:23:56','2016-06-30 04:23:56','2016-06-30 04:23:56',NULL),
	(8,3,2,NULL,'2016-06-29 23:30:05','2016-06-29 23:30:05',NULL),
	(9,3,3,NULL,'2016-06-29 23:30:05','2016-06-29 23:30:05',NULL),
	(10,3,4,NULL,'2016-06-29 23:30:05','2016-06-29 23:30:05',NULL),
	(11,3,5,NULL,'2016-06-29 23:30:05','2016-06-29 23:30:05',NULL),
	(12,4,1,'2016-06-29 23:33:12','2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(13,4,2,NULL,'2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(14,4,3,NULL,'2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(15,4,4,NULL,'2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(16,4,5,NULL,'2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(17,5,1,'2016-06-30 04:21:35','2016-06-30 04:21:35','2016-06-30 04:21:35',NULL),
	(18,5,2,NULL,'2016-06-29 23:34:21','2016-06-29 23:34:21',NULL),
	(19,5,3,NULL,'2016-06-29 23:34:21','2016-06-29 23:34:21',NULL),
	(20,5,4,NULL,'2016-06-29 23:34:21','2016-06-29 23:34:21',NULL),
	(21,5,5,NULL,'2016-06-29 23:34:21','2016-06-29 23:34:21',NULL),
	(22,6,1,'2016-06-30 03:00:34','2016-06-30 03:00:34','2016-06-30 03:00:34',NULL),
	(23,7,1,'2016-06-30 04:20:48','2016-06-30 04:20:48','2016-06-30 04:20:48',NULL),
	(24,7,2,NULL,'2016-06-30 03:23:17','2016-06-30 03:23:17',NULL);

/*!40000 ALTER TABLE `messenger_participants` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы messenger_threads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messenger_threads`;

CREATE TABLE `messenger_threads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `messenger_threads` WRITE;
/*!40000 ALTER TABLE `messenger_threads` DISABLE KEYS */;

INSERT INTO `messenger_threads` (`id`, `subject`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Тут','2016-06-21 02:28:06','2016-06-21 02:28:06',NULL),
	(2,'Готовы!','2016-06-21 00:20:22','2016-06-21 00:20:22',NULL),
	(3,'Задача 1123','2016-06-29 23:30:05','2016-06-29 23:30:05',NULL),
	(4,'Задача 145','2016-06-29 23:33:12','2016-06-29 23:33:12',NULL),
	(5,'Задача 145','2016-06-29 23:34:21','2016-06-29 23:34:21',NULL),
	(6,'','2016-06-30 03:00:34','2016-06-30 03:00:34',NULL),
	(7,'Задача 100','2016-06-30 03:23:17','2016-06-30 03:23:17',NULL);

/*!40000 ALTER TABLE `messenger_threads` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_28_175635_create_threads_table',1),
	('2014_10_28_175710_create_messages_table',1),
	('2014_10_28_180224_create_participants_table',1),
	('2014_11_03_154831_add_soft_deletes_to_participants_table',1),
	('2014_11_10_083449_add_nullable_to_last_read_in_participants_table',1),
	('2014_11_20_131739_alter_last_read_in_participants_table',1),
	('2014_12_04_124531_add_softdeletes_to_threads_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `header` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `article` text COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Дамп таблицы processes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `processes`;

CREATE TABLE `processes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) DEFAULT NULL,
  `stage_id` tinyint(4) DEFAULT NULL,
  `number_task` tinyint(4) DEFAULT NULL,
  `experience` tinyint(4) DEFAULT NULL,
  `gold` tinyint(4) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `comment` text,
  `number_lesson` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `processes` WRITE;
/*!40000 ALTER TABLE `processes` DISABLE KEYS */;

INSERT INTO `processes` (`id`, `user_id`, `stage_id`, `number_task`, `experience`, `gold`, `rating`, `comment`, `number_lesson`, `created_at`, `updated_at`)
VALUES
	(1,2,5,1,5,5,'','',1,'2016-02-23 04:30:38','2016-02-23 04:30:38'),
	(2,2,2,2,5,5,'','',1,'2016-02-23 04:30:38','2016-02-23 04:30:38'),
	(3,2,5,3,5,5,'','',1,'2016-02-23 04:30:38','2016-02-23 04:30:38'),
	(4,2,2,4,5,5,'','',1,'2016-02-23 04:30:38','2016-02-23 04:30:38'),
	(5,2,1,5,5,5,'','',1,'2016-02-23 04:30:38','2016-02-23 04:30:38'),
	(6,2,1,1,5,5,'','',1,'2016-02-24 04:24:01','2016-02-24 04:24:01'),
	(7,2,1,2,5,5,'','',1,'2016-02-24 04:24:01','2016-02-24 04:24:01'),
	(8,2,1,3,5,5,'','',1,'2016-02-24 04:24:01','2016-02-24 04:24:01'),
	(9,2,1,4,5,5,'','',1,'2016-02-24 04:24:01','2016-02-24 04:24:01'),
	(10,2,1,5,5,5,'','',1,'2016-02-24 04:24:01','2016-02-24 04:24:01'),
	(11,4,1,1,5,5,'','',1,'2016-02-24 04:26:32','2016-02-24 04:26:32'),
	(12,4,1,2,5,5,'','',1,'2016-02-24 04:26:32','2016-02-24 04:26:32'),
	(13,4,1,3,5,5,'','',1,'2016-02-24 04:26:32','2016-02-24 04:26:32'),
	(14,4,1,4,5,5,'','',1,'2016-02-24 04:26:32','2016-02-24 04:26:32'),
	(15,4,1,5,5,5,'','',1,'2016-02-24 04:26:32','2016-02-24 04:26:32'),
	(16,2,1,1,5,5,'','',1,'2016-02-29 03:49:17','2016-02-29 03:49:17'),
	(17,2,1,2,5,5,'','',1,'2016-02-29 03:49:17','2016-02-29 03:49:17'),
	(18,2,1,1,5,5,'','',1,'2016-02-29 03:51:14','2016-02-29 03:51:14'),
	(19,2,1,2,5,5,'','',1,'2016-02-29 03:51:14','2016-02-29 03:51:14'),
	(20,2,1,6,5,5,'','',1,'2016-02-29 04:01:10','2016-02-29 04:01:10'),
	(21,1,1,1,5,5,'','',1,'2016-03-05 01:49:44','2016-03-05 01:49:44'),
	(22,1,1,2,5,5,'','',1,'2016-03-05 01:49:44','2016-03-05 01:49:44'),
	(23,2,2,1,5,5,'','',1,'2016-03-18 01:58:56','2016-03-18 01:58:56'),
	(24,2,2,2,5,5,'','',1,'2016-03-18 01:58:56','2016-03-18 01:58:56'),
	(25,3,1,1,5,5,'','',1,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(26,3,1,2,5,5,'','',1,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(27,3,1,3,5,5,'','',1,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(28,3,1,4,5,5,'','',1,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(29,3,1,5,5,5,'','',1,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(30,3,1,1,5,5,'','',1,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(31,3,1,2,5,5,'','',1,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(32,3,1,3,5,5,'','',1,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(33,3,1,4,5,5,'','',1,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(34,3,1,5,5,5,'','',1,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(35,4,1,3,5,5,'','',1,'2016-04-02 21:14:57','2016-04-02 21:14:57'),
	(36,4,1,4,5,5,'','',1,'2016-04-02 21:14:57','2016-04-02 21:14:57'),
	(37,2,1,1,5,5,'','',1,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(38,2,1,2,5,5,'','',1,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(39,2,1,3,5,5,'','',1,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(40,2,1,4,5,5,'','',1,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(41,2,1,5,5,5,'','',1,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(42,2,1,1,5,5,'','',1,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(43,2,1,2,5,5,'','',1,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(44,2,1,3,5,5,'','',1,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(45,2,1,4,5,5,'','',1,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(46,2,1,5,5,5,'','',1,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(47,2,1,1,5,5,'','',1,'2016-04-02 21:36:14','2016-04-02 21:36:14'),
	(48,2,1,2,5,5,'','',1,'2016-04-02 21:36:14','2016-04-02 21:36:14'),
	(49,2,1,1,5,5,'','',1,'2016-04-02 21:36:25','2016-04-02 21:36:25'),
	(50,2,1,2,5,5,'','',1,'2016-04-02 21:36:25','2016-04-02 21:36:25'),
	(51,2,2,1,5,5,'','',1,'2016-04-02 21:36:54','2016-04-02 21:36:54'),
	(52,2,2,2,5,5,'','',1,'2016-04-02 21:36:54','2016-04-02 21:36:54'),
	(53,2,2,3,5,5,'','',1,'2016-04-02 21:36:54','2016-04-02 21:36:54'),
	(54,2,1,1,5,5,'','',1,'2016-04-02 21:38:03','2016-04-02 21:38:03'),
	(55,2,1,2,5,5,'','',1,'2016-04-02 21:38:03','2016-04-02 21:38:03'),
	(56,2,1,3,5,5,'','',1,'2016-04-02 21:38:03','2016-04-02 21:38:03'),
	(57,2,2,1,5,5,'','',1,'2016-04-02 21:43:07','2016-04-02 21:43:07'),
	(58,2,1,2,5,5,'','',1,'2016-04-02 21:43:40','2016-04-02 21:43:40'),
	(59,2,2,1,5,5,'','',1,'2016-04-02 22:02:19','2016-04-02 22:02:19'),
	(60,2,2,2,5,5,'','',1,'2016-04-02 22:02:19','2016-04-02 22:02:19'),
	(61,2,2,4,5,5,'','',1,'2016-04-02 22:02:48','2016-04-02 22:02:48'),
	(62,2,2,5,5,5,'','',1,'2016-04-02 22:02:48','2016-04-02 22:02:48'),
	(63,2,1,1,5,5,'','',1,'2016-04-02 22:13:18','2016-04-02 22:13:18'),
	(64,2,1,1,5,5,'','',1,'2016-04-02 22:16:14','2016-04-02 22:16:14'),
	(65,2,2,1,5,5,'','',1,'2016-04-02 22:24:40','2016-04-02 22:24:40'),
	(66,2,2,1,5,1,'','',1,'2016-04-02 22:29:29','2016-04-02 22:29:29'),
	(67,2,2,2,5,1,'','',1,'2016-04-02 22:29:29','2016-04-02 22:29:29'),
	(68,2,1,1,5,1,'','',1,'2016-04-02 22:43:35','2016-04-02 22:43:35'),
	(69,2,1,2,5,1,'','',1,'2016-04-02 22:43:35','2016-04-02 22:43:35'),
	(70,2,1,1,5,1,'','',1,'2016-04-02 22:54:23','2016-04-02 22:54:23'),
	(71,2,1,2,5,1,'','',1,'2016-04-02 22:54:23','2016-04-02 22:54:23'),
	(72,3,1,6,5,1,'','',1,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(73,3,1,7,5,1,'','',1,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(74,3,1,8,5,1,'','',1,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(75,3,1,9,5,1,'','',1,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(76,3,1,10,5,1,'','',1,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(77,5,5,6,5,1,'','',1,'2016-04-21 00:59:04','2016-04-21 00:59:04'),
	(78,5,5,7,5,1,'','',1,'2016-04-21 00:59:04','2016-04-21 00:59:04'),
	(79,5,5,8,5,1,'','',1,'2016-04-21 00:59:05','2016-04-21 00:59:05'),
	(80,5,2,1,5,1,'','',1,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(81,5,2,2,5,1,'','',1,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(82,5,2,3,5,1,'','',1,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(83,5,2,4,5,1,'','',1,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(84,5,2,5,5,1,'','',1,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(85,3,4,1,5,1,'','',1,'2016-04-24 00:43:58','2016-04-24 00:43:58'),
	(86,3,4,2,5,1,'','',1,'2016-04-24 00:43:58','2016-04-24 00:43:58'),
	(87,3,2,3,5,1,'','',1,'2016-04-24 00:43:58','2016-04-24 00:43:58'),
	(88,3,2,4,5,1,'','',1,'2016-04-24 00:43:58','2016-04-24 00:43:58'),
	(89,3,2,5,5,1,'','',1,'2016-04-24 00:43:58','2016-04-24 00:43:58'),
	(90,3,5,1,5,1,'','',1,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(91,3,5,2,5,1,'','',1,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(92,3,5,3,5,1,'','',1,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(93,3,5,4,5,1,'','',1,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(94,3,5,5,5,1,'','',1,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(95,2,5,1,5,1,'','',1,'2016-04-24 00:49:17','2016-04-24 00:49:17'),
	(96,2,2,2,5,1,'','',1,'2016-04-24 00:49:17','2016-04-24 00:49:17'),
	(97,2,1,3,5,1,'','',1,'2016-04-24 00:49:17','2016-04-24 00:49:17'),
	(98,2,1,4,5,1,'','',1,'2016-04-24 00:49:17','2016-04-24 00:49:17'),
	(99,2,1,5,5,1,'','',1,'2016-04-24 00:49:17','2016-04-24 00:49:17'),
	(100,4,1,1,5,1,'','',1,'2016-04-24 00:54:40','2016-04-24 00:54:40'),
	(102,3,1,1,5,1,'','',1,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(103,3,1,2,5,1,'','',1,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(104,3,1,3,5,1,'','',1,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(105,3,1,4,5,1,'','',1,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(106,3,1,5,5,1,'','',1,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(107,4,1,6,5,1,'','',1,'2016-04-24 01:03:11','2016-04-24 01:03:11'),
	(108,4,1,7,5,1,'','',1,'2016-04-24 01:03:11','2016-04-24 01:03:11'),
	(109,4,1,8,5,1,'','',1,'2016-04-24 01:03:11','2016-04-24 01:03:11'),
	(110,4,1,9,5,1,'','',1,'2016-04-24 01:03:11','2016-04-24 01:03:11'),
	(111,4,1,10,5,1,'','',1,'2016-04-24 01:03:12','2016-04-24 01:03:12');

/*!40000 ALTER TABLE `processes` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы progress
# ------------------------------------------------------------

DROP TABLE IF EXISTS `progress`;

CREATE TABLE `progress` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `progress` WRITE;
/*!40000 ALTER TABLE `progress` DISABLE KEYS */;

INSERT INTO `progress` (`id`, `name`, `alias`, `description`, `image`, `created_at`, `updated_at`)
VALUES
	(1,'Творчество','Р','Ученик выражает своё внутреннее состояние в виде рисунков.\r\n','','2016-01-25 01:46:43','2016-01-25 01:48:39'),
	(2,'Первый','П','Решает задачи быстрее всех и быстрее чем на доске.\r\n','','2016-01-25 01:48:16','2016-01-25 01:48:16'),
	(3,'Дополнительный очки','ДО','Дополнительные очки за проявление своего мышления.','','2016-01-25 01:49:46','2016-01-25 01:49:46'),
	(4,'Инициатива','И','Ученик проявляет инициативу на уроке.','','2016-01-25 01:50:26','2016-01-25 01:50:26'),
	(5,'Домашнее задание','ДЗ','Успешное выполнение домашнего задания, признак постоянства.','','2016-01-25 01:51:26','2016-01-25 01:51:26'),
	(6,'Быстрота','Б','Быстро соображает и быстрее всех решает первые общие задачи.','','2016-01-25 01:53:13','2016-01-25 01:53:13');

/*!40000 ALTER TABLE `progress` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы set_of_tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `set_of_tasks`;

CREATE TABLE `set_of_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `set_of_tasks` WRITE;
/*!40000 ALTER TABLE `set_of_tasks` DISABLE KEYS */;

INSERT INTO `set_of_tasks` (`id`, `name`, `alias`, `image`, `type`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'Набор задач №1','НЗ1','','1','','2016-01-25 17:41:14','2016-01-25 17:41:14'),
	(2,'Набор задач №2','НЗ2','','1','','2016-01-25 17:41:30','2016-01-25 17:41:30'),
	(3,'Набор задач №3','НЗ3','','1','','2016-01-25 17:41:38','2016-01-25 17:41:52');

/*!40000 ALTER TABLE `set_of_tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stages`;

CREATE TABLE `stages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `stages` WRITE;
/*!40000 ALTER TABLE `stages` DISABLE KEYS */;

INSERT INTO `stages` (`id`, `name`, `alias`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'На уроке','Один','Решение задач на уроке и на доске.\r\n','2016-01-22 02:02:09','2016-01-22 02:03:27'),
	(2,'Самостоятельна работа','С/р','Решают задачи за определённое время.\r\n','2016-01-22 02:03:16','2016-01-22 02:03:37'),
	(3,'В группах','Группы','Делятся на группы и решают трудные задачи.\r\n','2016-01-22 02:05:41','2016-01-22 02:05:41'),
	(4,'Соревнования','Поединок','Соревнуются друг с другом. Кто быстрее или правильно решит задачи.','2016-01-22 02:07:05','2016-01-22 02:07:05'),
	(5,'Домашняя работа','Д/р','Задания для выполнения дома.','2016-01-22 02:09:01','2016-01-22 02:09:01');

/*!40000 ALTER TABLE `stages` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;

INSERT INTO `subjects` (`id`, `name`, `category_id`, `code`)
VALUES
	(1,'Числа корни и степени',1,'1.1'),
	(2,'Тригонометрические функции произвольного угла',3,'1.2.1');

/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number_task` tinyint(4) NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `experience` tinyint(4) NOT NULL,
  `gold` tinyint(4) NOT NULL,
  `grade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` tinyint(4) NOT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_of_task_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `number_task`, `image`, `experience`, `gold`, `grade`, `subject_id`, `answer`, `detail`, `set_of_task_id`)
VALUES
	(1,1,'\\[\\sqrt[3]{{216 \\cdot 0,001}}\\]',5,1,'D',1,'','',1),
	(2,2,'Вычислите: \\[\\sqrt[4]{{81 \\cdot 0,0625}}\\]',5,1,'D',1,'','',1),
	(3,3,'',5,1,'D',1,'','',1),
	(4,4,'',5,1,'D',1,'','',1),
	(5,5,'',5,1,'D',1,'','',1),
	(6,6,'',5,1,'D',1,'','',2),
	(7,7,'',5,1,'D',1,'','',2),
	(8,8,'',5,1,'D',1,'','',2),
	(9,9,'',5,1,'D',1,'','',2),
	(10,10,'',5,1,'D',1,'','',2),
	(11,11,'\\[\\sqrt[3]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(12,12,'\\[\\sqrt[4]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(13,13,'\\[\\sqrt[5]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(14,14,'\\[\\sqrt[6]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(15,15,'\\[\\sqrt[1]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(16,16,'\\[\\sqrt[2]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(17,17,'\\[\\sqrt[3]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(18,18,'\\[\\sqrt[3]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3),
	(19,19,'\\[\\sqrt[3]{{216 \\cdot 0,001}}\\]',5,1,'D',1,NULL,NULL,3);

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `group` tinyint(4) NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `logins` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` tinyint(4) DEFAULT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sex` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notify` enum('y','n') COLLATE utf8_unicode_ci DEFAULT 'y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `login`, `group`, `description`, `logins`, `last_login`, `avatar`, `remember_token`, `created_at`, `updated_at`, `sex`, `notify`)
VALUES
	(1,'perlovav@mail.ru','$2y$10$yDsE.VWglniXoCmP/4c33uBXeP28f.W0qqCgqTVWiluUlarAuJFYq','Артём','Перлов','0',2,'Я создатель и админ игры!',0,0,'aglok.jpg','6DzZrWPsNcH1Yeel1xAUzF3Ckf9UBYYPu5TecTefontruvrtyU0RV9Z50rGx','2015-12-31 22:42:52','2016-05-23 01:13:13',NULL,'y'),
	(2,'','','Лиза','Додукалова','',1,'',0,NULL,NULL,NULL,'2016-01-19 03:02:59','2016-01-19 03:02:59',NULL,'y'),
	(3,'','','Руслан','Кантемиров ','',1,'',0,NULL,NULL,NULL,'2016-01-19 03:03:18','2016-01-19 03:03:18',NULL,'y'),
	(4,'m.mikle2000@gmail.com','$2y$10$MeoybJ9.PhpyIBFvuYiWrOesjjBvZ336gcbRWOcFfq1AjJCLIPXeu','Михаил','Мазевич','',1,'',0,NULL,NULL,'eOisd3rEjw5d0JENmQzhbm1BFx3I4uSmSBPA3TncmUBdlOhrxusoUPav7Qwj','2016-01-19 03:03:37','2016-05-23 01:09:14','M','y'),
	(5,'','','Роман','Дианов','',1,'',0,NULL,NULL,NULL,'2016-01-19 03:03:52','2016-01-19 03:03:52',NULL,'y');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы users_progress
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_progress`;

CREATE TABLE `users_progress` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `progress_id` tinyint(4) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `experience` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `gift` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users_progress` WRITE;
/*!40000 ALTER TABLE `users_progress` DISABLE KEYS */;

INSERT INTO `users_progress` (`id`, `progress_id`, `user_id`, `experience`, `description`, `gift`, `created_at`, `updated_at`)
VALUES
	(1,2,2,10,'',0,'2016-02-29 03:49:17','2016-02-29 03:49:17'),
	(2,2,2,10,'',0,'2016-02-29 03:51:14','2016-02-29 03:51:14'),
	(3,1,2,10,'',0,'2016-02-29 03:51:45','2016-02-29 03:51:45'),
	(4,1,2,10,'',0,'2016-02-29 04:01:09','2016-02-29 04:01:09'),
	(5,2,1,10,'',0,'2016-03-05 01:49:44','2016-03-05 01:49:44'),
	(6,1,2,10,'',0,'2016-03-18 01:58:56','2016-03-18 01:58:56'),
	(7,2,3,10,'',0,'2016-04-02 20:51:45','2016-04-02 20:51:45'),
	(8,2,3,10,'',0,'2016-04-02 20:52:26','2016-04-02 20:52:26'),
	(9,3,4,10,'',0,'2016-04-02 21:14:57','2016-04-02 21:14:57'),
	(10,1,2,10,'',0,'2016-04-02 21:32:45','2016-04-02 21:32:45'),
	(11,1,2,10,'',0,'2016-04-02 21:33:37','2016-04-02 21:33:37'),
	(12,1,2,10,'',0,'2016-04-02 21:36:14','2016-04-02 21:36:14'),
	(13,1,2,10,'',0,'2016-04-02 21:36:25','2016-04-02 21:36:25'),
	(14,1,2,10,'',0,'2016-04-02 21:36:54','2016-04-02 21:36:54'),
	(15,2,2,10,'',0,'2016-04-02 21:38:03','2016-04-02 21:38:03'),
	(16,2,2,10,'',0,'2016-04-02 21:43:07','2016-04-02 21:43:07'),
	(17,1,2,10,'',0,'2016-04-02 21:43:40','2016-04-02 21:43:40'),
	(18,1,2,10,'',0,'2016-04-02 22:02:19','2016-04-02 22:02:19'),
	(19,1,2,10,'',0,'2016-04-02 22:02:48','2016-04-02 22:02:48'),
	(20,1,2,10,'',0,'2016-04-02 22:13:18','2016-04-02 22:13:18'),
	(21,1,2,10,'',0,'2016-04-02 22:16:14','2016-04-02 22:16:14'),
	(22,1,2,10,'',0,'2016-04-02 22:24:40','2016-04-02 22:24:40'),
	(23,2,2,10,'',0,'2016-04-02 22:29:29','2016-04-02 22:29:29'),
	(24,2,2,10,'',0,'2016-04-02 22:43:34','2016-04-02 22:43:34'),
	(25,2,2,10,'',0,'2016-04-02 22:54:23','2016-04-02 22:54:23'),
	(26,1,3,10,'',0,'2016-04-20 00:57:02','2016-04-20 00:57:02'),
	(27,4,5,10,'',0,'2016-04-21 00:59:04','2016-04-21 00:59:04'),
	(28,2,5,10,'',0,'2016-04-21 01:16:59','2016-04-21 01:16:59'),
	(29,4,3,10,'',0,'2016-04-24 00:43:57','2016-04-24 00:43:57'),
	(30,4,3,10,'',0,'2016-04-24 00:47:56','2016-04-24 00:47:56'),
	(31,4,2,10,'',0,'2016-04-24 00:49:16','2016-04-24 00:49:16'),
	(32,2,4,10,'',0,'2016-04-24 00:54:40','2016-04-24 00:54:40'),
	(33,2,3,10,'',0,'2016-04-24 00:55:57','2016-04-24 00:55:57'),
	(34,3,4,10,'',0,'2016-04-24 01:03:11','2016-04-24 01:03:11');

/*!40000 ALTER TABLE `users_progress` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
