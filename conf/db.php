<?php

class DB{

	const USER = "root";
	const PASS = "";
	const HOST = '127.0.0.1';
	const DB   = 'epiz_27717656_forumblog';
	//const CHARSET = "utf8mb4";

	public static function connToDB() {

		$user = self::USER;
		$pass = self::PASS;
		$host = self::HOST;
		$db   = self::DB;
		//$charset = self::CHARSET;
        try {
            $conn = new PDO('mysql:host='.$host,  $user, $pass);
            $sql = "CREATE DATABASE IF NOT EXISTS $db";
            $conn->query($sql);
            $conn = null;
            $dbh = new PDO('mysql:host='.$host.';dbname='.$db,  $user, $pass);
            $sql = "CREATE TABLE if not exists `users` (`Id` INT, `First name` TEXT, `Last name` TEXT, `birthday` TEXT, `email` TEXT, `pass` TEXT, `status` VARCHAR (5) DEFAULT 'user')";
            $dbh->query($sql);
            return $dbh;
        }
        catch (PDOException $e) {
            print "Error!: Database not responding";
            die();
        }
	}
}