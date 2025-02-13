<?php

class CommentModel extends Model{

    public function forum_comment(){

        global $env;

        $page_id = $_SESSION["page_id"];

        $sql = "SELECT `forum_comments`.*, `users`.`First name` AS `name` FROM `forum_comments` INNER JOIN `users` ON `forum_comments` . `user_id` = `users`.`Id` WHERE `forum_comments`.`Forum_page` = ' $page_id ' AND `forum_comments`.`structure` = '" . $env['route1'] . "'";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $comment = $smtppage->fetchall(PDO::FETCH_ASSOC);


        return ($comment);
    }

    public function add_comments(){
        global $env;

        $comment_text = ($_POST['comment']) ? $_POST['comment'] : '';
        $page_id = $_SESSION["page_id"];
        $userid = $_SESSION['user_id'];
        $rout_1 = $env['route1'];

        $sql = "INSERT INTO `forum_comments` (`Comment`, `Forum_page`, `user_id`, `structure`) VALUES ('$comment_text','$page_id','$userid','$rout_1')";

        $smtppage = $this->db->prepare($sql);
        $smtppage->execute();

        $errorInfo = $smtppage->errorInfo();
        if ($errorInfo[0] !== '00000') {
            // Error handling
            $result = ("Error: " . $errorInfo[2]);
        }
        else {
            $result = 'Request done';
        }

        return $result;
    }
}
