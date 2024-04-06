-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.41-log - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица epiz_27717656_forumblog.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Topic` text NOT NULL,
  `Title` text NOT NULL,
  `Description` text NOT NULL,
  `structure` varchar(4) NOT NULL DEFAULT 'blog',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` (`id`, `Topic`, `Title`, `Description`, `structure`) VALUES
	(1, 'Blog', 'Blog Title', 'Blog Description', 'blog'),
	(2, 'Games', 'Games Title', 'Games Description', 'blog'),
	(3, 'Weather', 'Weather Title', 'Weather Description', 'blog'),
	(4, 'Movies', 'Movies Title', 'Movies Description', 'blog'),
	(5, 'Business', 'Business Title', 'Business Description', 'blog'),
	(6, 'Computers', 'Computers Title', 'Computers Description', 'blog'),
	(7, 'Programs', 'Programs Title', 'Programs Description', 'blog'),
	(8, 'Phones', 'Phones Title', 'Phones Description', 'blog'),
	(9, 'Sites', 'Sites Title', 'Sites Description', 'blog'),
	(10, 'Work', 'Work Title', 'Work Description', 'blog'),
	(11, 'Health', 'Health Title', 'Health Description', 'blog'),
	(12, 'Philosophy', 'Philosophy Title', 'Philosophy Description', 'blog');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.blog-categories
CREATE TABLE IF NOT EXISTS `blog-categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `blog-description` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog-categories: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `blog-categories` DISABLE KEYS */;
INSERT INTO `blog-categories` (`id`, `title`, `blog-description`) VALUES
	(1, 'Category_First', 'Blog_Certain_Category_First'),
	(2, 'Category_Second', 'Blog_Certain_Category_Second');
/*!40000 ALTER TABLE `blog-categories` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.blog-certain-category
CREATE TABLE IF NOT EXISTS `blog-certain-category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` varchar(50) NOT NULL,
  `Sub_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog-certain-category: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `blog-certain-category` DISABLE KEYS */;
INSERT INTO `blog-certain-category` (`id`, `Category`, `Sub_category`) VALUES
	(1, 'Blog_Certain_Category_First', 'Blog_Certain_Topic_First'),
	(2, 'Blog_Certain_Category_Second', 'Blog_Certain_Topic_Second');
/*!40000 ALTER TABLE `blog-certain-category` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.blog-certain-topic
CREATE TABLE IF NOT EXISTS `blog-certain-topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Sub_category` varchar(50) NOT NULL,
  `Certain_topic` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.blog-certain-topic: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `blog-certain-topic` DISABLE KEYS */;
INSERT INTO `blog-certain-topic` (`id`, `Sub_category`, `Certain_topic`) VALUES
	(1, 'Blog_Certain_Topic_First', 'Blog_Certain_Topic_First_Description'),
	(2, 'Blog_Certain_Topic_Second', 'Blog_Certain_Topic_Second_Description');
/*!40000 ALTER TABLE `blog-certain-topic` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.forum
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Topic` text NOT NULL,
  `Title` text NOT NULL,
  `Description` text NOT NULL,
  `structure` varchar(5) NOT NULL DEFAULT 'forum',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
INSERT INTO `forum` (`id`, `Topic`, `Title`, `Description`, `structure`) VALUES
	(1, 'Forum', 'Forum Description', '', 'forum'),
	(2, 'Games', 'Games Description', '', 'forum'),
	(3, 'Weather', 'Weather Description', '', 'forum'),
	(4, 'Movies', 'Movies Description', '', 'forum'),
	(5, 'Business', 'Business Description', '', 'forum'),
	(6, 'Computers', 'Computers Description', '', 'forum'),
	(7, 'Programs', 'Programs Description', '', 'forum'),
	(8, 'Phones', 'Phones Description', '', 'forum'),
	(9, 'Sites', 'Sites Description', '', 'forum'),
	(10, 'Work', 'Work Description', '', 'forum'),
	(11, 'Health', 'Health Description', '', 'forum'),
	(12, 'Philosophy', 'Philosophy Description', 'Lalalalalal', 'forum');
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.forum-categories
CREATE TABLE IF NOT EXISTS `forum-categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `forum-description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum-categories: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `forum-categories` DISABLE KEYS */;
INSERT INTO `forum-categories` (`id`, `title`, `forum-description`) VALUES
	(1, 'Category_First', 'Forum_Certain_Category_First'),
	(2, 'Category_Second', 'Forum_Certain_Category_Second'),
	(3, 'Category_First', 'Forum_Certain_Category_First'),
	(4, 'Category_Second', 'Forum_Certain_Category_Second');
/*!40000 ALTER TABLE `forum-categories` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.forum-certain-category
CREATE TABLE IF NOT EXISTS `forum-certain-category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Category` varchar(50) NOT NULL,
  `Sub_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum-certain-category: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `forum-certain-category` DISABLE KEYS */;
INSERT INTO `forum-certain-category` (`id`, `Category`, `Sub_category`) VALUES
	(1, 'Forum_Certain_Category_First', 'Forum_Certain_Topic_First'),
	(2, 'Forum_Certain_Category_Second', 'Forum_Certain_Topic_Second'),
	(3, 'Forum_Certain_Category_First', 'Forum_Certain_Topic_First');
/*!40000 ALTER TABLE `forum-certain-category` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.forum-certain-topic
CREATE TABLE IF NOT EXISTS `forum-certain-topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Sub_category` varchar(50) NOT NULL,
  `Certain_topic` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum-certain-topic: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `forum-certain-topic` DISABLE KEYS */;
INSERT INTO `forum-certain-topic` (`id`, `Sub_category`, `Certain_topic`) VALUES
	(1, 'Forum_Certain_Topic_First', 'Forum_Certain_Topic_First_Description'),
	(2, 'Forum_Certain_Topic_Second', 'Forum_Certain_Topic_Second_Description');
/*!40000 ALTER TABLE `forum-certain-topic` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.forum_comments
CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` varchar(50) DEFAULT NULL,
  `Forum_page` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `structure` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Forum_page` (`Forum_page`),
  KEY `FK_forum_comments_users` (`user_id`),
  CONSTRAINT `FK_forum_comments_forum` FOREIGN KEY (`Forum_page`) REFERENCES `forum` (`id`),
  CONSTRAINT `FK_forum_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.forum_comments: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `forum_comments` DISABLE KEYS */;
INSERT INTO `forum_comments` (`id`, `Comment`, `Forum_page`, `user_id`, `structure`) VALUES
	(1, 'First comment', 12, 2, 'forum'),
	(2, 'Second comment', 12, 2, 'forum'),
	(3, 'Third comment', 12, 2, 'forum'),
	(6, 'blog new comment', 12, 2, 'blog');
/*!40000 ALTER TABLE `forum_comments` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы epiz_27717656_forumblog.news: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `name`, `content`) VALUES
	(8, 'Хостинг', 'Cайт перенесен на хостинг с локального хостинга'),
	(9, 'Вывод топиков', 'Вывод топиков теперь доступен на сайте'),
	(10, 'Вывод колонок', 'Вывод колонок НОВОСТИ, БЛОГ, ФОРУМ'),
	(11, 'Серый фон', 'Добавлен серый фон в бургер меню'),
	(12, 'Функция логина', 'На сайте теперь доступна авторизация'),
	(13, 'Обновление сайта', 'Сайт переведён на ООП'),
	(14, 'Админ панель', 'Добавлена админ панель'),
	(18, 'Ошибки', 'Добавлены ошибки при ошибочном логине');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

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
/*!40000 ALTER TABLE `top-menu` DISABLE KEYS */;
INSERT INTO `top-menu` (`id`, `name`, `id_blog`, `id_forum`) VALUES
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
/*!40000 ALTER TABLE `top-menu` ENABLE KEYS */;

-- Дамп структуры для таблица epiz_27717656_forumblog.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `First name` text,
  `Last name` text NOT NULL,
  `birthday` text NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы epiz_27717656_forumblog.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `First name`, `Last name`, `birthday`, `email`, `pass`, `status`) VALUES
	(2, 'Sviatoslav', 'Kitastiy', '1994-03-26', 'lordiccat@gmail.com', '159159', 'admin'),
	(3, 'Artem', 'Stokiz', '2020-12-24', 'artemstokiz@gmail.com', 'hello2020', 'admin'),
	(5, 'Kirill', 'Kirillovich', '0001-01-01', 'asfdfs@sdfsfesfe', '123456789', 'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
