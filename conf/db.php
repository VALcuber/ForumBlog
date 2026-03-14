<?php

class DB{

	const USER = "root";
	const PASS = "123456";
	const HOST = '127.0.0.1';
	const DB   = 'epiz_27717656_forumblog';
	const CHARSET = "utf8mb4";

	public static function connToDB() {

		$user = self::USER;
		$pass = self::PASS;
		$host = self::HOST;
		$db   = self::DB;
		$charset = self::CHARSET;

        try {
            // Initial connection to create database if not exists
            $conn = new PDO("mysql:host=$host", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE utf8mb4_general_ci");

            // Reconnect to the specific database
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // List of tables in correct order (Parents first, then Children with Foreign Keys)
            $queries = [
                // 1. Independent tables (No foreign keys)
                "users" => "CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `First name` TEXT NULL DEFAULT NULL,
                    `Last name` TEXT NOT NULL,
                    `nickname` VARCHAR(50) NULL DEFAULT 'Random user',
                    `birthday` TEXT NOT NULL,
                    `email` TEXT NOT NULL,
                    `pass` TEXT NOT NULL,
                    `logo` VARCHAR(50) NOT NULL DEFAULT 'none',
                    `status` VARCHAR(5) NOT NULL DEFAULT 'user',
                    `google_id` VARCHAR(255) NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB",

                "blog" => "CREATE TABLE IF NOT EXISTS `blog` ( 
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `Category` tinytext NOT NULL,
                    `Category_Description` text NOT NULL,
                    `structure` varchar(4) NOT NULL DEFAULT 'blog',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB",

                "forum" => "CREATE TABLE IF NOT EXISTS `forum` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `Category` text NOT NULL,
                    `Category_Description` text NOT NULL,
                    `structure` varchar(5) NOT NULL DEFAULT 'forum',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB",

                "settings" => "CREATE TABLE IF NOT EXISTS `settings` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `section` VARCHAR(50) NOT NULL,
                    `name` VARCHAR(50) NOT NULL,
                    `value` TEXT NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE INDEX `section` (`section`, `name`)
                ) ENGINE=InnoDB",

                // 2. Tables with Foreign Keys (Must come after parent tables)
                "blog_category" => "CREATE TABLE IF NOT EXISTS `blog_category` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `Category` int(11) DEFAULT NULL,
                    `Description` text,
                    `user_id` int(11) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    CONSTRAINT `blog_category_blog` FOREIGN KEY (`Category`) REFERENCES `blog` (`id`),
                    CONSTRAINT `blog_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                ) ENGINE=InnoDB",

                "forum_category" => "CREATE TABLE IF NOT EXISTS `forum_category` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `Category` int(11) DEFAULT NULL,
                    `Description` text,
                    `user_id` int(11) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    CONSTRAINT `forum_category_fk` FOREIGN KEY (`Category`) REFERENCES `forum` (`id`),
                    CONSTRAINT `forum_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                ) ENGINE=InnoDB",

                "forum_comments" => "CREATE TABLE IF NOT EXISTS `forum_comments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `Comment` varchar(50) DEFAULT NULL,
                    `Forum_page` int(11) DEFAULT NULL,
                    `user_id` int(11) DEFAULT NULL,
                    `structure` varchar(50) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    CONSTRAINT `FK_forum_comments_forum_category` FOREIGN KEY (`Forum_page`) REFERENCES `forum_category` (`id`),
                    CONSTRAINT `FK_forum_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                ) ENGINE=InnoDB",

                "messages" => "CREATE TABLE IF NOT EXISTS `messages` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `sender_id` INT(11) NULL DEFAULT NULL,
                    `receiver_id` INT(11) NOT NULL,
                    `content` TEXT NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `is_read` INT(1) NULL DEFAULT 0,
                    PRIMARY KEY (`id`),
                    CONSTRAINT `FK_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
                    CONSTRAINT `FK_messages_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
                ) ENGINE=InnoDB",

                "news" => "CREATE TABLE IF NOT EXISTS `news` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                    `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB",

                "top-menu" => "CREATE TABLE IF NOT EXISTS `top-menu` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` text NOT NULL,
                    `id_blog` int(11) DEFAULT NULL,
                    `id_forum` int(11) DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    KEY `blog-categories` (`id_blog`),
                    KEY `forum-categories` (`id_forum`)
                ) ENGINE=InnoDB",

                "user_settings" => "CREATE TABLE IF NOT EXISTS `user_settings` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    PRIMARY KEY (`id`),
                ) ENGINE=InnoDB"
            ];

            // Execute all queries
            foreach ($queries as $name => $sql) {
                $conn->exec($sql);
            }

            return $conn;

        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
	}
}

/*
		$conn = new PDO('mysql:host='.$host,  $user, $pass);
		$sql = "CREATE DATABASE IF NOT EXISTS $db";
		$conn->query($sql);
		$conn = new PDO("mysql:host=$host; dbname=$db; charset=$charset", $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Connect to db

*/