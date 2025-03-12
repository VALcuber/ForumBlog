<?php

class User_profileModel extends Model {

	public function user_profile_logo($file_name){
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
            echo "Crash in logo";
        }
	}

    public function user_forum_posts(){
        $id = $_SESSION['user_id'];

        $sql = "SELECT `description` FROM `forum_category` WHERE user_id = :user_id";

        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":user_id", $id, PDO::PARAM_STR);

        $smtppage->execute();

        $user_forum_posts = $smtppage->fetchall(PDO::FETCH_ASSOC);


        return ($user_forum_posts);
    }

}