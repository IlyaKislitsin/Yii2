-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.38 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных yii2
CREATE DATABASE IF NOT EXISTS `yii2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yii2`;

-- Дамп структуры для таблица yii2.access
CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_access_user` (`user_id`),
  KEY `fk_access_event` (`event_id`),
  CONSTRAINT `fk_access_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `fk_access_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.access: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
/*!40000 ALTER TABLE `access` ENABLE KEYS */;

-- Дамп структуры для таблица yii2.event
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `dt` datetime NOT NULL,
  `creator_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_event_user` (`creator_id`),
  CONSTRAINT `fk_event_user` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.event: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` (`id`, `text`, `dt`, `creator_id`, `created_at`) VALUES
	(1, 'event_1', '0000-00-00 00:00:00', 2, NULL),
	(2, 'event_2', '0000-00-00 00:00:00', 2, NULL),
	(3, 'event_3', '0000-00-00 00:00:00', 4, NULL),
	(4, 'event_4', '0000-00-00 00:00:00', 5, NULL);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;

-- Дамп структуры для таблица yii2.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.migration: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1529390509),
	('m180619_064605_create_table_user', 1529396698),
	('m180619_064625_create_table_event', 1529396698),
	('m180619_064646_create_table_access', 1529396698),
	('m180622_122443_add_foreign_key', 1529671729);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица yii2.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы yii2.product: ~10 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `price`, `created_at`) VALUES
	(1, 'product_1', 19.99, '2018-06-11 23:59:11'),
	(2, 'product_2', 29.99, '2018-06-11 23:59:11'),
	(3, 'product_3', 39.99, '2018-06-11 23:59:11'),
	(4, 'product_4', 49.99, '2018-06-11 23:59:11'),
	(5, 'product_5', 59.99, '2018-06-11 23:59:11'),
	(6, 'product_6', 69.99, '2018-06-11 23:59:11'),
	(7, 'product_7', 79.99, '2018-06-11 23:59:11'),
	(8, 'product_8', 89.99, '2018-06-11 23:59:11'),
	(9, 'product_9', 99.99, '2018-06-11 23:59:11'),
	(10, 'product_10', 333.00, '2018-06-11 23:59:11');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Дамп структуры для таблица yii2.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `username` varchar(255) NOT NULL COMMENT 'Логин',
  `name` varchar(255) NOT NULL COMMENT 'Имя',
  `surname` varchar(255) DEFAULT NULL COMMENT 'Фамилия',
  `password_hash` varchar(255) NOT NULL COMMENT 'hash пароля',
  `access_token` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.user: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `name`, `surname`, `password_hash`, `access_token`, `auth_key`, `created_at`, `updated_at`) VALUES
	(1, 'user_1', 'Александр', NULL, '1q2w3e4r5t6y', NULL, NULL, NULL, NULL),
	(2, 'user_2', 'Иван', NULL, 'q1w2e3r4t5y6', NULL, NULL, NULL, NULL),
	(3, 'user_3', 'Сергей', NULL, 'zaq1xsw2cde3', NULL, NULL, NULL, NULL),
	(4, 'user_4', 'Евгений', NULL, 'vfr4bgt5nhy6', NULL, NULL, NULL, NULL),
	(5, 'user_5', 'Илья', '', '1z2x3c4v5b6n', '', '', NULL, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
