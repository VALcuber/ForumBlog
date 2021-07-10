<?php

class PanelModel extends Model {

	public function InsertNews(){
		$news_name = $_POST['title'] ?? '';
		$news_content = $_POST['description'] ?? '';
		
		$sql = "INSERT INTO `news` (`news_name`,`news_content`) VALUES (:news_name,:news_content)";
		
		$smtpi = $this->db->prepare($sql);
		$smtpi->bindValue(":news_name", $news_name, PDO::PARAM_STR);
		$smtpi->bindValue(":news_content", $news_content, PDO::PARAM_STR);
		$smtpi->execute();
		return($smtpi);
	}

	
}