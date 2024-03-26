<?php

class CommentModel extends Model{

    public function forum_comment(){

        //$start = ($_POST['start']) ? $_POST['start'] : 0;

        $sql = "SELECT `Comment` FROM `forum_comments` LIMIT 100";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $comment = $smtppage->fetchall(PDO::FETCH_ASSOC);

        return ($comment);
    }
}
