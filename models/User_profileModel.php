<?php

class User_profileModel extends Model {

	public function user_profile_logo($file_name){
    global $env;
	    $id = $_SESSION['user_id'];

        $sql = "UPDATE `users` SET `logo`='../assets/uploads/$file_name' WHERE  `id`='$id'";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        $sql = "SELECT `logo` FROM `users` WHERE `id` = '$id'";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        $resr=$smtpt->fetch(PDO::FETCH_ASSOC);

        if(!empty($resr)){
            return $resr;
        }
        else{
            echo "Proval v logo";
        }
	}
}