<?php

class PageModel extends Model {
	public function getpage($temporary){
		global $env;

		if($env['route3'] != NULL){
			$sql = "SELECT `name`,`forum_content` FROM `".$env['route']."` WHERE `name` = '".$env['route3']."' ";
		}
		else{
			$sql = "SELECT * FROM `".$env['route']."` WHERE `name` = '$temporary' ";
		}
		
		$smtppage = $this->db->prepare($sql);

		$smtppage->execute();
		
		$rower=$smtppage->fetch(PDO::FETCH_ASSOC);

		return($rower);
		
	}
}