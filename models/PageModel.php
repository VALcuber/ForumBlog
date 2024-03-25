<?php

class PageModel extends Model{

    public function get_page($temporary)
    {

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `Title`,`Description` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        } elseif ($env['route1'] == 'news') {

            $sql = "SELECT `name`,`content` FROM `" . $env['route1'] . "` WHERE `name` = '$temporary'";

        } elseif ($env['route1'] == 'blog') {

            $sql = "SELECT `Title`,`blog_content` FROM `" . $env['route1'] . "` WHERE `Title` = '" . $env['route3'] . "' ";

        }

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        $rower = $smtppage->fetch(PDO::FETCH_ASSOC);

        return ($rower);

    }

    public function forum_commit($forumpage){

        //global $env;

        $comment = array();

        $sql = "SELECT `Comment` FROM `forum_comments` ";//WHERE `Forum_page` = '$forumpage'\"

        $smtppage = $this->db->prepare($sql);

        $smtppage->execute();

        while ($commentsforum = $smtppage->fetchall(PDO::FETCH_ASSOC)) {

            array_push($comment, $commentsforum);
        }

        return ($comment);
    }

}