<?php

class Certain_TopicModel extends Model {
	public function getpage(){
		global $env;

        $table_name = $env['route'].'-certain-topic';

		$sql = "SELECT `Sub_category`,`Certain_topic` FROM `$table_name` WHERE `Sub_category` = '".$env['route3']."' ";
		
		$page_model = $this->db->prepare($sql);
        $page_model->execute();

		$rowers=$page_model->fetch(PDO::FETCH_ASSOC);

		return($rowers);
	}
}