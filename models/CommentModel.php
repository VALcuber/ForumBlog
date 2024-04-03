<?php

class CommentModel extends Model{

    public function forum_comment(){

        global $env;

        $page_id = $_SESSION["page_id"];

        $sql = "SELECT `id`, `Comment`, `Forum_page` FROM `forum_comments` WHERE `Forum_page` = '$page_id'";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $comment = $smtppage->fetchall(PDO::FETCH_ASSOC);

        return ($comment);
    }
}
