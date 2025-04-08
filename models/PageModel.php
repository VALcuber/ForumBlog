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

        return ($rower);

    }

}