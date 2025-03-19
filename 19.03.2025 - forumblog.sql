-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.12 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных epiz_27717656_forumblog
CREATE DATABASE IF NOT EXISTS `epiz_27717656_forumblog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `epiz_27717656_forumblog`;

-- Дамп структуры для таблица epiz_27717656_forumblog.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Category_Description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `structure` varchar(4) NOT NULL DEFAULT 'blog',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog: ~12 rows (приблизительно)
REPLACE INTO `blog` (`id`, `Category`, `Category_Description`, `structure`) VALUES
	(1, 'Blog', 'Blog Description', 'blog'),
	(2, 'Games', 'Games Description', 'blog'),
	(3, 'Weather', 'Weather Description', 'blog'),
	(4, 'Movies', 'Movies Description', 'blog'),
	(5, 'Business', 'Business Description', 'blog'),
	(6, 'Computers', 'Computers Description', 'blog'),
	(7, 'Programs', 'Programs Description', 'blog'),
	(8, 'Phones', 'Phones Description', 'blog'),
	(9, 'Sites', 'Sites Description', 'blog'),
	(10, 'Work', 'Work Description', 'blog'),
	(11, 'Health', 'Health Description', 'blog'),
	(12, 'Philosophy', 'Philosophy Description', 'blog');

-- Дамп структуры для таблица epiz_27717656_forumblog.blog_category
CREATE TABLE IF NOT EXISTS `blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` int(11) DEFAULT NULL,
  `Description` text,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_category_blog` (`Category`),
  KEY `blog_posts_user_id` (`user_id`),
  CONSTRAINT `blog_category_blog` FOREIGN KEY (`Category`) REFERENCES `blog` (`id`),
  CONSTRAINT `blog_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog_category: ~3 rows (приблизительно)
REPLACE INTO `blog_category` (`id`, `Category`, `Description`, `user_id`) VALUES
	(1, 1, 'Strange things', 2),
	(2, 2, 'Dark Souls', 2),
	(3, 2, 'Dota', 2);

-- Дамп структуры для таблица epiz_27717656_forumblog.forum
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Category_Description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `structure` varchar(5) NOT NULL DEFAULT 'forum',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum: ~12 rows (приблизительно)
REPLACE INTO `forum` (`id`, `Category`, `Category_Description`, `structure`) VALUES
	(1, 'Forum', 'Forum Description', 'forum'),
	(2, 'Games', 'Games Description', 'forum'),
	(3, 'Weather', 'Weather Description', 'forum'),
	(4, 'Movies', 'Movies Description', 'forum'),
	(5, 'Business', 'Business Description', 'forum'),
	(6, 'Computers', 'Computers Description', 'forum'),
	(7, 'Programs', 'Programs Description', 'forum'),
	(8, 'Phones', 'Phones Description', 'forum'),
	(9, 'Sites', 'Sites Description', 'forum'),
	(10, 'Work', 'Work Description', 'forum'),
	(11, 'Health', 'Health Description', 'forum'),
	(12, 'Philosophy', 'Philosophy Description', 'forum');

-- Дамп структуры для таблица epiz_27717656_forumblog.forum_category
CREATE TABLE IF NOT EXISTS `forum_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` int(11) DEFAULT NULL,
  `Description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `forum_category` (`Category`) USING BTREE,
  KEY `forum_posts_user_id` (`user_id`),
  CONSTRAINT `forum_category` FOREIGN KEY (`Category`) REFERENCES `forum` (`id`),
  CONSTRAINT `forum_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum_category: ~4 rows (приблизительно)
REPLACE INTO `forum_category` (`id`, `Category`, `Description`, `user_id`) VALUES
	(1, 1, 'Something weared', 5),
	(2, 2, 'Lineage', 2),
	(3, 2, 'Portal', 2),
	(4, 12, 'Some philosophy thoughts', 5);

-- Дамп структуры для таблица epiz_27717656_forumblog.forum_comments
CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` varchar(50) DEFAULT NULL,
  `Forum_page` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `structure` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_forum_comments_users` (`user_id`),
  KEY `FK_forum_comments_forum_category` (`Forum_page`),
  CONSTRAINT `FK_forum_comments_forum_category` FOREIGN KEY (`Forum_page`) REFERENCES `forum_category` (`id`),
  CONSTRAINT `FK_forum_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum_comments: ~3 rows (приблизительно)
REPLACE INTO `forum_comments` (`id`, `Comment`, `Forum_page`, `user_id`, `structure`) VALUES
	(1, 'First comment', 4, 2, 'forum'),
	(2, 'Second comment', 4, 2, 'forum'),
	(3, 'Third comment', 4, 2, 'forum');

-- Дамп структуры для таблица epiz_27717656_forumblog.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы epiz_27717656_forumblog.news: ~11 rows (приблизительно)
REPLACE INTO `news` (`id`, `name`, `content`) VALUES
	(8, 'Хостинг', 'Cайт перенесен на хостинг с локального хостинга'),
	(9, 'Вывод топиков', 'Вывод топиков теперь доступен на сайте'),
	(10, 'Вывод колонок', 'Вывод колонок НОВОСТИ, БЛОГ, ФОРУМ'),
	(11, 'Серый фон', 'Добавлен серый фон в бургер меню'),
	(12, 'Функция логина', 'На сайте теперь доступна авторизация'),
	(13, 'Обновление сайта', 'Сайт переведён на ООП'),
	(14, 'Админ панель', 'Добавлена админ панель'),
	(18, 'Ошибки', 'Добавлены ошибки при ошибочном логине'),
	(19, 'Добавлены комментарии в форум и блог', 'Добавлена возможность комментировать записи в форуме и блоге'),
	(24, 'Личный кабинет', 'Добавлен личный кабинет'),
	(25, 'Фото профиля', 'Добавлена возможность выбрать фото профиля');

-- Дамп структуры для таблица epiz_27717656_forumblog.top-menu
CREATE TABLE IF NOT EXISTS `top-menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `id_blog` int(11) DEFAULT NULL,
  `id_forum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog-categories` (`id_blog`),
  KEY `forum-categories` (`id_forum`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.top-menu: ~12 rows (приблизительно)
REPLACE INTO `top-menu` (`id`, `name`, `id_blog`, `id_forum`) VALUES
	(1, 'Programs-Forum', NULL, 7),
	(2, 'Programs', 7, NULL),
	(3, 'Phones-Forum', NULL, 8),
	(4, 'Phones', 8, NULL),
	(5, 'Sites-Forum', NULL, 9),
	(6, 'Sites', 9, NULL),
	(7, 'Work-Forum', NULL, 10),
	(8, 'Work', 10, NULL),
	(9, 'Health-Forum', NULL, 11),
	(10, 'Health', 11, NULL),
	(11, 'Philosophy-Forum', NULL, 12),
	(12, 'Philosophy', 12, NULL);

-- Дамп структуры для таблица epiz_27717656_forumblog.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `First name` text,
  `Last name` text NOT NULL,
  `birthday` text NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `logo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'none',
  `status` varchar(5) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.users: ~2 rows (приблизительно)
REPLACE INTO `users` (`id`, `First name`, `Last name`, `birthday`, `email`, `pass`, `logo`, `status`) VALUES
	(2, 'Sviatoslav', 'Komputerz', '1994-03-26', 'lordiccat@gmail.com', '159159', '../assets/uploads/hortitsa_1943_god.jpg', 'admin'),
	(5, 'Kirill', 'Kirillovich', '0001-01-01', 'asfdfs@sdfsfesfe', '123456789', 'none', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
