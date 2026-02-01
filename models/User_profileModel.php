<?php

class User_profileModel extends Model {

	public function user_profile_logo($file_name, $id){

        $sql = "UPDATE `users` SET `logo`='/assets/uploads/$file_name' WHERE  `id`='$id'";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        $sql = "SELECT `logo` FROM `users` WHERE `id` = '$id'";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        $resr=$smtpt->fetch(PDO::FETCH_ASSOC);

        if(empty($resr)){
            echo "Crash in logo";
        }
        else{
            return $resr;
        }
	}

    public function user_forum_posts($id){

        $sql = "SELECT `forum`.`Category` AS `Category`, 
                       `forum_category`.`Description` AS `Description`,
                       'forum' AS `Part`
                                        FROM `forum_category`
                                            JOIN `forum` ON `forum_category`.`Category` = `forum`.`id`
                                                WHERE `forum_category`.`user_id` = :user_id";

        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":user_id", $id, PDO::PARAM_STR);

        $smtppage->execute();

        $user_forum_posts = $smtppage->fetchall(PDO::FETCH_ASSOC);


        return ($user_forum_posts);
    }

    public function user_blog_posts($id){

        $sql = "SELECT `blog`.`Category` AS `Category`, 
                       `blog_category`.`Description` AS `Description`,
                       'blog' AS `Part`
                                        FROM `blog_category`
                                            JOIN `blog` ON `blog_category`.`Category` = `blog`.`id`
                                                WHERE `blog_category`.`user_id` = :user_id";

        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":user_id", $id, PDO::PARAM_STR);

        $smtppage->execute();

        $user_blog_posts = $smtppage->fetchall(PDO::FETCH_ASSOC);

        return ($user_blog_posts);
    }

    public function users_inbox($userId){
        $sql = "SELECT m.sender_id, m.receiver_id, u.nickname
                    FROM messages m
                        /* Connect with NOT ME */
                        INNER JOIN users u ON u.id = IF(m.sender_id = :userId, m.receiver_id, m.sender_id)
                            INNER JOIN (
                                SELECT MAX(id) as max_id
                                    FROM messages
                                        WHERE receiver_id = :userId OR sender_id = :userId
                                            /* Group by ID */
                                            GROUP BY IF(sender_id = :userId, receiver_id, sender_id)
                                         ) last_msgs ON m.id = last_msgs.max_id
                                        ORDER BY m.created_at DESC";
        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":userId", $userId, PDO::PARAM_STR);
        $smtpc->execute();
    }

}