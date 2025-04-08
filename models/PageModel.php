<?php

class PageModel extends Model{

    public function get_page($temporary){

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `forum_category`.`Description`, `forum`.`Category`, `forum_category`.`id`
                        FROM `forum_category`
                            JOIN `forum`
                                ON `forum`.`id` = `forum_category`.`Category`
                                    WHERE `forum_category`.`Description` = :description ";

        }
        elseif ($env['route1'] == 'news') {

            $sql = "SELECT `id`,`name`,`content` FROM `news` WHERE `name` = '$temporary'";

        }
        elseif ($env['route1'] == 'blog') {

            $sql = "SELECT `blog_category`.`Description`, `blog`.`Category`, `blog_category`.`id`
                        FROM `blog_category`
                            JOIN `blog`
                                ON `blog`.`id` = `blog_category`.`Category`
                                    WHERE `blog_category`.`Description` = :description ";

        }

        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":description", $env['route3'], PDO::PARAM_STR);

        $smtppage->execute();

        $rower = $smtppage->fetch(PDO::FETCH_ASSOC);

        $_SESSION["page_id"] = $env['id'] = $rower['id'];

        return ($rower);

    }

    public function get_comments(){
        global $env;

        $page_id = $_SESSION["page_id"];
echo $page_id;
        $sql = "SELECT `forum_comments`.*, `users`.`First name` AS `name` FROM `forum_comments`
                    INNER JOIN `users` ON `forum_comments` . `user_id` = `users`.`Id` WHERE `Forum_page` = ' $page_id ' AND `structure` = '" . $env['route1'] . "' ";

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