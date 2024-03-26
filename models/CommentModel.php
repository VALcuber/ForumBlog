<?php

class CommentModel extends Model{

    public function forum_comment(){

        $sql = "SELECT `id`, `Comment` FROM `forum_comments` LIMIT 100";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $comment = $smtppage->fetchall(PDO::FETCH_ASSOC);

        return ($comment);
    }
}
