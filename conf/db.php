<?php

class DB{

	const USER = "root";
	const PASS = "";
	const HOST = "127.0.0.1";
	const DB   = "epiz_27717656_Forumblog";

	public static function connToDB() {

		$user = self::USER;
		$pass = self::PASS;
		$host = self::HOST;
		$db   = self::DB;

		$conn = new PDO("mysql:dbname=$db;host=$host;charset=utf8mb4", $user, $pass);

		if(!$conn){
		    echo 'Неудалось связаться с базой данных';
		    exit;
        }
		else
		    return $conn;

	}
}