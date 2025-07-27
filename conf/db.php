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

		$conn = new PDO('mysql:host='.$host,  $user, $pass);
		$sql = "CREATE DATABASE IF NOT EXISTS $db";
		$conn->query($sql);
		$conn = new PDO("mysql:host=$host; dbname=$db; charset=$charset", $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Connect to db
        $sql = "CREATE TABLE IF NOT EXISTS `blog` ( 
                                                        `id` int(11) NOT NULL AUTO_INCREMENT,
                                                        `Category` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                                        `Category_Description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                                        `structure` varchar(4) NOT NULL DEFAULT 'blog',
                                                        PRIMARY KEY (`id`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `blog_category` (
                                                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                `Category` int(11) DEFAULT NULL,
                                                                `Description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
                                                                `user_id` int(11) DEFAULT NULL,
                                                                PRIMARY KEY (`id`) USING BTREE,
                                                                KEY `blog_category_blog` (`Category`) USING BTREE,
                                                                KEY `blog_posts_user_id` (`user_id`),
                                                                CONSTRAINT `blog_category_blog` FOREIGN KEY (`Category`) REFERENCES `blog` (`id`),
                                                                CONSTRAINT `blog_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `forum` (
                                                        `id` int(11) NOT NULL AUTO_INCREMENT,
                                                        `Category` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                                        `Category_Description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                                                        `structure` varchar(5) NOT NULL DEFAULT 'forum',
                                                        PRIMARY KEY (`id`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `forum_category` (
                                                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                 `Category` int(11) DEFAULT NULL,
                                                                 `Description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
                                                                 `user_id` int(11) DEFAULT NULL,
                                                                 PRIMARY KEY (`id`) USING BTREE,
                                                                 KEY `forum_category` (`Category`) USING BTREE,
                                                                 KEY `forum_posts_user_id` (`user_id`),
                                                                 CONSTRAINT `forum_category` FOREIGN KEY (`Category`) REFERENCES `forum` (`id`),
                                                                 CONSTRAINT `forum_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `forum_comments` (
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
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `news` (
                                                       `id` int(11) NOT NULL AUTO_INCREMENT,
                                                       `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                                       `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                                       PRIMARY KEY (`id`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `top-menu` (
                                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                                           `name` text NOT NULL,
                                                           `id_blog` int(11) DEFAULT NULL,
                                                           `id_forum` int(11) DEFAULT NULL,
                                                           PRIMARY KEY (`id`),
                                                           KEY `blog-categories` (`id_blog`),
                                                           KEY `forum-categories` (`id_forum`)
        )";
        $conn->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS `users` (
                                                        `id` INT(11) NOT NULL AUTO_INCREMENT,
	                                                    `First name` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	                                                    `Last name` TEXT NOT NULL COLLATE 'utf8_general_ci',
	                                                    `Nickname` VARCHAR(50) NULL DEFAULT 'Random user' COLLATE 'utf8_general_ci',
	                                                    `birthday` TEXT NOT NULL COLLATE 'utf8_general_ci',
	                                                    `email` TEXT NOT NULL COLLATE 'utf8_general_ci',
	                                                    `pass` TEXT NOT NULL COLLATE 'utf8_general_ci',
	                                                    `logo` VARCHAR(50) NOT NULL DEFAULT 'none' COLLATE 'utf8_general_ci',
	                                                    `status` VARCHAR(5) NOT NULL DEFAULT 'user' COLLATE 'utf8_general_ci',
	                                                    PRIMARY KEY (`id`) USING BTREE

         )";
        $conn->query($sql);
        return $conn;

	}
}
