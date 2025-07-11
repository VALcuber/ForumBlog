<?php

class PageModel extends Model{

    public function get_page($temporary){

        global $env;

        if ($env['route1'] == 'forum') {

            $sql = "SELECT `forum_category`.`Description`, `forum`.`Category`, `forum_category`.`id`,`forum_category`.`user_id`
                        FROM `forum_category`
                            JOIN `forum`
                                ON `forum`.`id` = `forum_category`.`Category`
                                	JOIN `users`
                                		ON `users`.`id` = `forum_category`.`user_id`
                                    		WHERE `forum_category`.`Description` = :description ";

        }
        elseif ($env['route1'] == 'news') {

            $sql = "SELECT `id`,`name`,`content` FROM `news` WHERE `name` = '$temporary'";

        }
        elseif ($env['route1'] == 'blog') {

            $sql = "SELECT `blog_category`.`Description`, `blog`.`Category`, `blog_category`.`id`,`blog_category`.`user_id`
                        FROM `blog_category`
                            JOIN `blog`
                                ON `blog`.`id` = `blog_category`.`Category`
                                	JOIN `users`
                                		ON `users`.`id` = `blog_category`.`user_id`
                                    		WHERE `blog_category`.`Description` = :description ";

        }

        /** @noinspection PhpUndefinedVariableInspection */
        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":description", $env['route3'], PDO::PARAM_STR);

        $smtppage->execute();

        $rower = $smtppage->fetch(PDO::FETCH_ASSOC);

        return ($rower);

    }

    public function post_author($user_id_for_post){
        $sql = "SELECT `Nickname` from `users` WHERE `id` = :id";

        $smtppage = $this->db->prepare($sql);

        $smtppage->bindValue(":id", $user_id_for_post, PDO::PARAM_STR);

        $smtppage->execute();

        $result = $smtppage->fetch(PDO::FETCH_ASSOC);

        return ($result);

    }

}