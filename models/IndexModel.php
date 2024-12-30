<?php

class IndexModel extends Model {
	
	public function blog(){
		
		$resultblog=array();

        $sql = "CREATE TABLE if not exists `blog` (`Id` INT, `Topic` TEXT, `blog_content` TEXT, `Title` VARCHAR (20))";
		
		$smtp = $this->db->prepare($sql);
		$smtp->execute();

        $sql = "SELECT * FROM `blog` ORDER BY id DESC LIMIT 7";
        $smtp = $this->db->prepare($sql);
        $smtp->execute();

		while($res=$smtp->fetch(PDO::FETCH_ASSOC)){
            array_push($resultblog,$res);
        }

        return $resultblog;

    }

    public function news(){
		
    	$resultnews=array();

        $sql = "CREATE TABLE if not exists `news` (`Id` INT, `name` TEXT, `content` TEXT)";

        $smtp = $this->db->prepare($sql);
        $smtp->execute();

        $sql = "SELECT * FROM `news` ORDER BY id DESC LIMIT 7";
		
		$smtpn = $this->db->prepare($sql);
		$smtpn->execute();

        while($resnews=$smtpn->fetch(PDO::FETCH_ASSOC)){
            array_push($resultnews,$resnews);
        }

        return $resultnews;
    }

    public function forum(){
                
    	$resultforum=array();

        $sql = "CREATE TABLE if not exists `forum` (`Id` INT, `name` TEXT, `forum_content` TEXT, `structure` VARCHAR (4))";

        $smtp = $this->db->prepare($sql);
        $smtp->execute();

        $sql = "SELECT * FROM `forum` ORDER BY id DESC LIMIT 7";
		
		$smtpf = $this->db->prepare($sql);
		$smtpf->execute();
		
        while($resforum=$smtpf->fetch(PDO::FETCH_ASSOC)){
            array_push($resultforum,$resforum);
        }
       
        return $resultforum;
    }
}