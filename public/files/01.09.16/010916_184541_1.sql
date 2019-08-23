# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: localhost (MySQL 5.6.21)
# Схема: upbrain
# Время создания: 2016-09-01 15:43:39 +0000
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
	(1,'Aglok','$2y$10$yDsE.VWglniXoCmP/4c33uBXeP28f.W0qqCgqTVWiluUlarAuJFYq','Aglok','r42n64ifPdAKv0l3GJQSmRufHa5EBHcHCQiZYxNW3CjDsGqOWuJYX0ZG5sAp','2015-12-31 20:41:50','2016-05-22 17:14:01'),
	(2,'Anna','$2y$10$dO2DhKwVwVfmWvTWFWp7mOPM3KySSO8cm/RVgE7lGoyYh3c1dLXwi','Anna','uChabINcM4SKlbfdQtJo1yfvA8nS7mnyZQWZsivSDIXAZhuwuV5DYOLfm7um','2016-05-08 20:02:38','2016-05-08 20:12:59'),
	(4,'Egor','$2y$10$9a/iNo7qoS8a/SkhIkE6cOOBgCZZAd1KbIFUvy9vlBPbd0uY9fl2S','Egor','43jRp3rFWSP2Ygc7Gpv9tDn2pMiz9h3ebdv6AqL8za1FJeYhFNztXaKG1Ucr','2016-05-08 20:12:14','2016-05-08 20:13:18');

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
  `time` tinyint(4) DEFAULT NULL,
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
	(1,1,16,5,NULL,1,25,5,'2016-07-28 19:31:40','2016-07-28 19:31:40','D');

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
	(1,1,4,'Привет!','2016-05-22 22:39:00','2016-05-22 22:39:00',NULL,NULL),
	(2,1,4,'Задача №3 \r\nОтвет: 12','2016-05-22 22:53:14','2016-05-22 22:53:14',NULL,NULL),
	(3,1,4,'Еще решил! 14 задачу.','2016-05-22 22:55:14','2016-05-22 22:55:14',NULL,NULL),
	(4,1,4,'Отсылаю сообщение Aglok!','2016-05-22 23:11:51','2016-05-22 23:11:51',NULL,NULL),
	(5,2,1,'Всем привет!','2016-05-24 19:21:06','2016-05-24 19:21:06',NULL,NULL),
	(6,2,1,'Привет Михоил!','2016-05-24 19:26:46','2016-05-24 19:26:46',NULL,NULL),
	(7,1,1,'Hi! ','2016-06-20 19:42:30','2016-06-20 19:42:30',NULL,NULL),
	(8,2,1,'img yes!','2016-06-20 19:50:28','2016-06-20 19:50:28','200616_215027_0.jpeg|200616_215027_1.jpeg|200616_215028_2.jpeg',NULL),
	(9,1,1,'Good. sua','2016-06-20 20:00:22','2016-06-20 20:00:22','200616_220021_0.jpeg|200616_220022_1.jpeg',NULL),
	(10,2,1,'Hi& Friend!','2016-06-20 21:28:15','2016-06-20 21:28:15','200616_232813_0.jpeg|200616_232814_1.jpeg|200616_232814_2.jpeg','messages/Artem_Perlov'),
	(11,2,1,'Моя очередь!','2016-06-20 21:39:37','2016-06-20 21:39:37','200616_233936_0.jpeg|200616_233937_1.jpeg','messages/Artem_Perlov'),
	(12,1,1,'Ещё фото!','2016-06-20 21:40:54','2016-06-20 21:40:54','200616_234052_0.jpeg|200616_234053_1.jpeg|200616_234053_2.jpeg|200616_234053_3.jpeg|200616_234054_4.jpeg','messages/Artem_Perlov'),
	(13,2,1,'Привет!','2016-06-20 22:20:22','2016-06-20 22:20:22','210616_002021_0.jpeg|210616_002021_1.jpeg','messages/Artem_Perlov'),
	(14,1,1,'Ok!','2016-06-21 00:28:06','2016-06-21 00:28:06','210616_022804_0.jpeg|210616_022805_1.jpeg|210616_022805_2.jpeg','messages/Artem_Perlov'),
	(15,3,1,'Привет!','2016-06-29 21:30:05','2016-06-29 21:30:05',NULL,NULL),
	(16,4,1,'Еще одна тема!','2016-06-29 21:33:12','2016-06-29 21:33:12',NULL,NULL),
	(17,5,1,'Еще одна тема!','2016-06-29 21:34:21','2016-06-29 21:34:21',NULL,NULL),
	(18,6,1,'','2016-06-30 01:00:34','2016-06-30 01:00:34',NULL,NULL),
	(19,7,1,'Я решил задачу!','2016-06-30 01:23:17','2016-06-30 01:23:17',NULL,NULL),
	(20,3,1,'Отправляем данные!','2016-07-23 15:33:28','2016-07-23 15:33:28',NULL,NULL),
	(21,7,1,'Попытка!','2016-07-23 22:20:32','2016-07-23 22:20:32',NULL,NULL),
	(22,7,1,'Ещё раз!','2016-07-23 22:22:46','2016-07-23 22:22:46',NULL,NULL),
	(23,7,1,'#2','2016-07-23 22:24:03','2016-07-23 22:24:03','240716_002402_0.jpeg|240716_002402_1.jpeg','messages/Perlov_Artem'),
	(24,8,16,'Доделал первую часть! ','2016-07-28 19:33:35','2016-07-28 19:33:35',NULL,NULL),
	(25,8,16,'Две темы!','2016-07-28 19:34:41','2016-07-28 19:34:41','280716_213440_0.jpeg|280716_213440_1.png','messages/Mazevich_Mihail');

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
	(1,1,4,'2016-05-22 23:12:00','2016-05-22 22:39:00','2016-05-22 23:12:00',NULL),
	(2,1,2,NULL,'2016-05-22 22:53:14','2016-05-22 22:53:14',NULL),
	(3,1,5,NULL,'2016-05-22 22:55:14','2016-05-22 22:55:14',NULL),
	(4,1,1,'2016-07-26 09:50:59','2016-07-26 11:50:59','2016-07-26 09:50:59',NULL),
	(5,2,1,'2016-07-23 15:57:25','2016-07-23 17:57:25','2016-07-23 15:57:25',NULL),
	(6,2,4,'2016-05-24 19:26:58','2016-05-24 19:26:46','2016-05-24 19:26:58',NULL),
	(7,3,1,'2016-07-23 15:53:33','2016-07-23 17:53:33','2016-07-23 15:53:33',NULL),
	(8,3,2,NULL,'2016-06-29 21:30:05','2016-06-29 21:30:05',NULL),
	(9,3,3,NULL,'2016-06-29 21:30:05','2016-06-29 21:30:05',NULL),
	(10,3,4,NULL,'2016-06-29 21:30:05','2016-06-29 21:30:05',NULL),
	(11,3,5,NULL,'2016-06-29 21:30:05','2016-06-29 21:30:05',NULL),
	(12,4,1,'2016-06-29 21:33:12','2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(13,4,2,NULL,'2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(14,4,3,NULL,'2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(15,4,4,NULL,'2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(16,4,5,NULL,'2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(17,5,1,'2016-07-23 15:57:35','2016-07-23 17:57:35','2016-07-23 15:57:35',NULL),
	(18,5,2,NULL,'2016-06-29 21:34:21','2016-06-29 21:34:21',NULL),
	(19,5,3,NULL,'2016-06-29 21:34:21','2016-06-29 21:34:21',NULL),
	(20,5,4,NULL,'2016-06-29 21:34:21','2016-06-29 21:34:21',NULL),
	(21,5,5,NULL,'2016-06-29 21:34:21','2016-06-29 21:34:21',NULL),
	(22,6,1,'2016-06-30 01:00:34','2016-06-30 01:00:34','2016-06-30 01:00:34',NULL),
	(23,7,1,'2016-07-23 22:24:03','2016-07-24 00:24:03','2016-07-23 22:24:03',NULL),
	(24,7,2,NULL,'2016-06-30 01:23:17','2016-06-30 01:23:17',NULL),
	(25,8,16,'2016-08-24 08:25:42','2016-08-24 10:25:42','2016-08-24 08:25:42',NULL),
	(26,8,1,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(27,8,2,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(28,8,3,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(29,8,4,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(30,8,5,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(31,8,6,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL),
	(32,8,7,NULL,'2016-07-28 19:33:35','2016-07-28 19:33:35',NULL);

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
	(1,'Тут','2016-06-21 00:28:06','2016-06-21 00:28:06',NULL),
	(2,'Готовы!','2016-06-20 22:20:22','2016-06-20 22:20:22',NULL),
	(3,'Задача 1123','2016-07-23 17:33:28','2016-07-23 15:33:28',NULL),
	(4,'Задача 145','2016-06-29 21:33:12','2016-06-29 21:33:12',NULL),
	(5,'Задача 145','2016-06-29 21:34:21','2016-06-29 21:34:21',NULL),
	(6,'','2016-06-30 01:00:34','2016-06-30 01:00:34',NULL),
	(7,'Задача 100','2016-07-24 00:24:03','2016-07-23 22:24:03',NULL),
	(8,'Задача 1112','2016-07-28 21:34:41','2016-07-28 19:34:41',NULL);

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


# Дамп таблицы newsletters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsletters`;

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1',
  `sender_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text,
  `path_files` varchar(555) DEFAULT NULL,
  `mail_type` tinyint(4) DEFAULT '0',
  `mail_from` varchar(128) DEFAULT NULL,
  `emails_total` int(11) DEFAULT '0',
  `emails_sent` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dir` varchar(255) DEFAULT NULL,
  `timeSend` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;

INSERT INTO `newsletters` (`id`, `type`, `sender_name`, `subject`, `body`, `path_files`, `mail_type`, `mail_from`, `emails_total`, `emails_sent`, `created_at`, `updated_at`, `dir`, `timeSend`)
VALUES
	(1,1,'Панель управления','dsfsd','<p>sdfs</p>\r\n','220816_010428_0.xls|220816_010428_1.xls|220816_010428_2.xls',0,NULL,0,0,'2016-08-21 23:04:28','2016-08-21 23:04:28',NULL,0),
	(2,1,'Панель управления','fsdf','<p>sdfsdf</p>\r\n','220816_011011_0.xls|220816_011011_1.xls|220816_011011_2.xls|220816_011011_3.xls|220816_011011_4.docx',1,'perlovav@mail.ru',4,0,'2016-08-21 23:10:11','2016-08-21 23:10:11',NULL,0),
	(3,1,'Object','asdasd','<p>asdasda</p>\r\n','/Users/artemperlov/Sites/upbrain/public/files/23.08.16/230816_235649_0.css|/Users/artemperlov/Sites/upbrain/public/files/23.08.16/230816_235649_1.css|/Users/artemperlov/Sites/upbrain/public/files/23.08.16/230816_235649_2.css',1,'perlovav@mail.ru',2,0,'2016-08-23 21:56:49','2016-08-23 21:56:49',NULL,0),
	(4,1,'{\"id\":1,\"username\":\"Aglok\",\"name\":\"Aglok\",\"created_at\":\"2015-12-31 22:41:50\",\"updated_at\":\"2016-05-22 19:14:01\"}','sdfsdf','<p>werwer</p>\r\n','240816_001857_0.epub|240816_001857_1.sql',1,'perlovav@mail.ru',2,0,'2016-08-23 22:18:57','2016-08-23 22:18:57',NULL,0),
	(5,1,'{\"id\":1,\"username\":\"Aglok\",\"name\":\"Aglok\",\"created_at\":\"2015-12-31 22:41:50\",\"updated_at\":\"2016-05-22 19:14:01\"}','fsdfsdfsd','<p>sdfsdfasdf</p>\r\n','240816_003711_0.xls|240816_003711_1.xls|240816_003711_2.xls',1,'perlovav@mail.ru',2,0,'2016-08-23 22:37:11','2016-08-23 22:37:11',NULL,0),
	(6,1,'1','asdad','<p>sdfsdfsdf</p>\r\n','240816_004621_0.docx',1,'perlovav@mail.ru',2,0,'2016-08-23 22:46:21','2016-08-23 22:46:21',NULL,0),
	(7,1,'Aglok','sfdsdfsf','<p>sdfsdfsdfs</p>\r\n','240816_005629_0.xls|240816_005629_1.xls',0,'perlovav@mail.ru',3,0,'2016-08-23 22:56:29','2016-08-23 22:56:29','/Users/artemperlov/Sites/upbrain/public/files/24.08.16',0);

/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы newsletters_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsletters_users`;

CREATE TABLE `newsletters_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) DEFAULT NULL,
  `newsletter_id` int(11) DEFAULT NULL,
  `is_sent` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `newsletters_users` WRITE;
/*!40000 ALTER TABLE `newsletters_users` DISABLE KEYS */;

INSERT INTO `newsletters_users` (`id`, `user_id`, `newsletter_id`, `is_sent`, `created_at`, `updated_at`)
VALUES
	(1,27,NULL,NULL,'2016-08-23 22:37:11','2016-08-23 22:37:11'),
	(2,28,NULL,NULL,'2016-08-23 22:37:12','2016-08-23 22:37:12'),
	(3,1,NULL,NULL,'2016-08-23 22:46:21','2016-08-23 22:46:21'),
	(4,2,NULL,NULL,'2016-08-23 22:46:21','2016-08-23 22:46:21'),
	(5,1,7,1,'2016-08-23 22:56:29','2016-08-23 22:56:29'),
	(6,2,7,1,'2016-08-23 22:56:29','2016-08-23 22:56:29'),
	(7,3,7,1,'2016-08-23 22:56:29','2016-08-23 22:56:29');

/*!40000 ALTER TABLE `newsletters_users` ENABLE KEYS */;
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
	(1,16,1,1,5,1,'','',1,'2016-07-28 19:31:40','2016-07-28 19:31:40'),
	(2,16,1,2,5,1,'','',1,'2016-07-28 19:31:40','2016-07-28 19:31:40'),
	(3,16,1,3,5,1,'','',1,'2016-07-28 19:31:40','2016-07-28 19:31:40'),
	(4,16,1,4,5,1,'','',1,'2016-07-28 19:31:40','2016-07-28 19:31:40'),
	(5,16,1,5,5,1,'','',1,'2016-07-28 19:31:40','2016-07-28 19:31:40');

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
	(1,'Творчество','Р','Ученик выражает своё внутреннее состояние в виде рисунков.\r\n','','2016-01-24 23:46:43','2016-01-24 23:48:39'),
	(2,'Первый','П','Решает задачи быстрее всех и быстрее чем на доске.\r\n','','2016-01-24 23:48:16','2016-01-24 23:48:16'),
	(3,'Дополнительный очки','ДО','Дополнительные очки за проявление своего мышления.','','2016-01-24 23:49:46','2016-01-24 23:49:46'),
	(4,'Инициатива','И','Ученик проявляет инициативу на уроке.','','2016-01-24 23:50:26','2016-01-24 23:50:26'),
	(5,'Домашнее задание','ДЗ','Успешное выполнение домашнего задания, признак постоянства.','','2016-01-24 23:51:26','2016-01-24 23:51:26'),
	(6,'Быстрота','Б','Быстро соображает и быстрее всех решает первые общие задачи.','','2016-01-24 23:53:13','2016-01-24 23:53:13');

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
	(1,'Набор задач №1','НЗ1','','1','','2016-01-25 15:41:14','2016-01-25 15:41:14'),
	(2,'Набор задач №2','НЗ2','','1','','2016-01-25 15:41:30','2016-01-25 15:41:30'),
	(3,'Набор задач №3','НЗ3','','1','','2016-01-25 15:41:38','2016-01-25 15:41:52');

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
	(1,'На уроке','Один','Решение задач на уроке и на доске.\r\n','2016-01-22 00:02:09','2016-01-22 00:03:27'),
	(2,'Самостоятельна работа','С/р','Решают задачи за определённое время.\r\n','2016-01-22 00:03:16','2016-01-22 00:03:37'),
	(3,'В группах','Группы','Делятся на группы и решают трудные задачи.\r\n','2016-01-22 00:05:41','2016-01-22 00:05:41'),
	(4,'Соревнования','Поединок','Соревнуются друг с другом. Кто быстрее или правильно решит задачи.','2016-01-22 00:07:05','2016-01-22 00:07:05'),
	(5,'Домашняя работа','Д/р','Задания для выполнения дома.','2016-01-22 00:09:01','2016-01-22 00:09:01');

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
  `email` varchar(120) COLLATE utf8_unicode_ci DEFAULT '',
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT '',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `group` tinyint(4) DEFAULT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci DEFAULT '',
  `logins` tinyint(4) DEFAULT '0',
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
	(1,'sergey.baranikovi@mail.ru',NULL,'Серго','Бараникови',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(2,'alexbog.lem@yandex.ru',NULL,'Алексей','Богачев',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(3,'stan.milren@mail.ru',NULL,'Стас','Голубков',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(4,'nastena.goncharova.00@inbox.ru',NULL,'Настя','Гончарова',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(5,'gipotut15@rambler.ru',NULL,'Настя','Деева',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(6,'cveta5@mail.ru',NULL,'Рома','Дианов',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(7,NULL,NULL,'Вероника','Добровидова',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(8,'lisa.dodukalova@mail.ru',NULL,'Лиза','Додукалова',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(9,'nikitasi99@yandex.ru',NULL,'Никита','Игошин',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(10,'rusicx15@gmail.com',NULL,'Руслан','Кантемиров',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(11,'kudryashova-nastya@inbox.ru',NULL,'Настя','Кудряшова',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(12,NULL,NULL,'Настя','Кузеленкова',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(13,'kuzmash@gmail.com',NULL,'Мария','Кузнецова',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(14,'akutyashina@mail.ru',NULL,'Арина','Кутящина',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(15,'andr1999@mail.ru',NULL,'Андрей','Лавров',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(16,'m.mikle2000@gmail.com','$2y$10$jhayKsoO37DMvWLPqiuApukCBB5QtsV/PEYeQufyEpTr0jyO0Wphm','Михаил','Мазевич','',1,'',NULL,NULL,NULL,NULL,'2016-07-28 20:37:12','2016-07-28 18:37:12','M','y'),
	(17,NULL,NULL,'Алёна','Макарова',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(18,'morskoynikita@gmail.com',NULL,'Никита','Морской',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(19,'tomkacm@hormail.com',NULL,'Татьяна','Мюррей',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(20,'mcphersonwiston00@gmail.com',NULL,'Григорий','Пронченко',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(21,'rafeeva.sonya@yandex.ru',NULL,'Соня','Рафеева',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(22,'andry10111999@gmail.com',NULL,'Андрей','Резников',NULL,2,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(23,'veronika-syanova@yandex.ru',NULL,'Вероника','Свянова',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(24,'dasha_silv@mail.ru',NULL,'Дарья','Сиурко',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','W','y'),
	(25,NULL,NULL,'Леон','Тужба',NULL,3,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(26,'arsen0304@bk.ru',NULL,'Арсен','Усманов',NULL,1,NULL,NULL,NULL,NULL,NULL,'2016-07-28 20:35:48','2016-07-28 20:35:48','M','y'),
	(27,'perlovav@mail.ru','','z','z','',4,'',0,NULL,NULL,NULL,'2016-08-23 23:55:34','2016-08-23 23:55:34',NULL,'y'),
	(28,'perlovav@gmail.com','','y','y','',4,'',0,NULL,NULL,NULL,'2016-08-23 23:56:01','2016-08-23 23:56:01',NULL,'y');

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
  `description` text COLLATE utf8_unicode_ci,
  `gift` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users_progress` WRITE;
/*!40000 ALTER TABLE `users_progress` DISABLE KEYS */;

INSERT INTO `users_progress` (`id`, `progress_id`, `user_id`, `experience`, `description`, `gift`, `created_at`, `updated_at`)
VALUES
	(1,2,2,10,'',0,'2016-02-29 01:49:17','2016-02-29 01:49:17'),
	(2,2,2,10,'',0,'2016-02-29 01:51:14','2016-02-29 01:51:14'),
	(3,1,2,10,'',0,'2016-02-29 01:51:45','2016-02-29 01:51:45'),
	(4,1,2,10,'',0,'2016-02-29 02:01:09','2016-02-29 02:01:09'),
	(5,2,1,10,'',0,'2016-03-04 23:49:44','2016-03-04 23:49:44'),
	(6,1,2,10,'',0,'2016-03-17 23:58:56','2016-03-17 23:58:56'),
	(7,2,3,10,'',0,'2016-04-02 18:51:45','2016-04-02 18:51:45'),
	(8,2,3,10,'',0,'2016-04-02 18:52:26','2016-04-02 18:52:26'),
	(9,3,4,10,'',0,'2016-04-02 19:14:57','2016-04-02 19:14:57'),
	(10,1,2,10,'',0,'2016-04-02 19:32:45','2016-04-02 19:32:45'),
	(11,1,2,10,'',0,'2016-04-02 19:33:37','2016-04-02 19:33:37'),
	(12,1,2,10,'',0,'2016-04-02 19:36:14','2016-04-02 19:36:14'),
	(13,1,2,10,'',0,'2016-04-02 19:36:25','2016-04-02 19:36:25'),
	(14,1,2,10,'',0,'2016-04-02 19:36:54','2016-04-02 19:36:54'),
	(15,2,2,10,'',0,'2016-04-02 19:38:03','2016-04-02 19:38:03'),
	(16,2,2,10,'',0,'2016-04-02 19:43:07','2016-04-02 19:43:07'),
	(17,1,2,10,'',0,'2016-04-02 19:43:40','2016-04-02 19:43:40'),
	(18,1,2,10,'',0,'2016-04-02 20:02:19','2016-04-02 20:02:19'),
	(19,1,2,10,'',0,'2016-04-02 20:02:48','2016-04-02 20:02:48'),
	(20,1,2,10,'',0,'2016-04-02 20:13:18','2016-04-02 20:13:18'),
	(21,1,2,10,'',0,'2016-04-02 20:16:14','2016-04-02 20:16:14'),
	(22,1,2,10,'',0,'2016-04-02 20:24:40','2016-04-02 20:24:40'),
	(23,2,2,10,'',0,'2016-04-02 20:29:29','2016-04-02 20:29:29'),
	(24,2,2,10,'',0,'2016-04-02 20:43:34','2016-04-02 20:43:34'),
	(25,2,2,10,'',0,'2016-04-02 20:54:23','2016-04-02 20:54:23'),
	(26,1,3,10,'',0,'2016-04-19 22:57:02','2016-04-19 22:57:02'),
	(27,4,5,10,'',0,'2016-04-20 22:59:04','2016-04-20 22:59:04'),
	(28,2,5,10,'',0,'2016-04-20 23:16:59','2016-04-20 23:16:59'),
	(29,4,3,10,'',0,'2016-04-23 22:43:57','2016-04-23 22:43:57'),
	(30,4,3,10,'',0,'2016-04-23 22:47:56','2016-04-23 22:47:56'),
	(31,4,2,10,'',0,'2016-04-23 22:49:16','2016-04-23 22:49:16'),
	(32,2,4,10,'',0,'2016-04-23 22:54:40','2016-04-23 22:54:40'),
	(33,2,3,10,'',0,'2016-04-23 22:55:57','2016-04-23 22:55:57'),
	(34,3,4,10,'',0,'2016-04-23 23:03:11','2016-04-23 23:03:11'),
	(35,1,2,10,NULL,NULL,'2016-07-23 23:27:25','2016-07-23 23:27:25'),
	(36,1,16,10,NULL,NULL,'2016-07-28 19:00:07','2016-07-28 19:00:07'),
	(37,1,16,10,NULL,NULL,'2016-07-28 19:03:21','2016-07-28 19:03:21'),
	(38,1,16,10,NULL,NULL,'2016-07-28 19:05:26','2016-07-28 19:05:26'),
	(39,1,16,10,NULL,NULL,'2016-07-28 19:13:08','2016-07-28 19:13:08'),
	(40,2,16,10,NULL,NULL,'2016-07-28 19:26:58','2016-07-28 19:26:58'),
	(41,1,16,10,NULL,NULL,'2016-07-28 19:31:40','2016-07-28 19:31:40');

/*!40000 ALTER TABLE `users_progress` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
