<?php

class CommentModel extends Model{

    public function forum_comment(){

        global $env;

        $page_id = $_SESSION["page_id"];

        $sql = "SELECT `forum_comments`.*, `users`.`First name` AS `name` FROM `forum_comments` INNER JOIN `users` ON `forum_comments` . `user_id` = `users`.`Id` WHERE `Forum_page` = ' $page_id ' AND `structure` = '" . $env['route1'] . "' ";

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

        $sql = "INSERT INTO `forum_comments` (`Comment`, `Forum_page`, `user_id`, `structure`) VALUES ('$comment_text','$page_id','$userid','" . $env['route1'] . "')";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

    }
}
