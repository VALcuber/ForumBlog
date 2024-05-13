<?php

class PageModel extends Model{

    public function get_page($temporary){

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `id`,`Title`,`Description` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        }
        elseif ($env['route1'] == 'news') {

            $sql = "SELECT `id`,`name`,`content` FROM `" . $env['route1'] . "` WHERE `name` = '$temporary'";

        }
        elseif ($env['route1'] == 'blog') {

            $sql = "SELECT `id`,`Title`,`Description` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        }

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $rower = $smtppage->fetch(PDO::FETCH_ASSOC);

        $_SESSION["page_id"] = $env['id'] = $rower['id'];

        return ($rower);

    }

    public function get_comments(){
        global $env;

        $page_id = $env['id'];

        $sql = "SELECT `forum_comments`.*, `users`.`First name` AS `name` FROM `forum_comments` INNER JOIN `users` ON `forum_comments` . `user_id` = `users`.`Id` WHERE `Forum_page` = ' $page_id ' AND `structure` = '" . $env['route1'] . "' ";

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $comment = $smtppage->fetchall(PDO::FETCH_ASSOC);


        $sql = "SELECT `id` AS 'commentid' FROM forum_comments WHERE `id` = (SELECT MAX(`id`) FROM forum_comments)";

        $prepare = $this->db->prepare($sql);
        $prepare->execute();

        $maxid = $prepare->fetch(PDO::FETCH_ASSOC);

        $_SESSION["maxid"] = $maxid;

        return ($comment);
    }

}