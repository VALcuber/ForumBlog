<?php

class IndexModel extends Model {
	
	public function blog(){
		
		$resultblog=array();

        $sql = "SELECT * FROM `blog` ORDER BY id";
        $smtp = $this->db->prepare($sql);
        $smtp->execute();

		while($res=$smtp->fetch(PDO::FETCH_ASSOC)){
            array_push($resultblog,$res);
        }

        return $resultblog;

    }

    public function news(){
		
    	$resultnews=array();

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

        $sql = "SELECT * FROM `forum` ORDER BY id";
		
		$smtpf = $this->db->prepare($sql);
		$smtpf->execute();
		
        while($resforum=$smtpf->fetch(PDO::FETCH_ASSOC)){
            array_push($resultforum,$resforum);
        }
       
        return $resultforum;
    }
}