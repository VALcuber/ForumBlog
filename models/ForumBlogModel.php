<?php

class ForumBlogModel extends Model{


    public function get_ForumBlog_topic($route){

        $result_page_all = array();

        $sql = "SELECT `Category`, `structure` FROM `blog` WHERE `Category` = :route UNION ALL SELECT `Category`, `structure` FROM `forum` WHERE `Category` = :route";

        $page_all = $this->db->prepare($sql);
        $page_all->bindValue(":route", $route, PDO::PARAM_STR);
        $page_all->execute();

        while($res_page_all=$page_all->fetch(PDO::FETCH_ASSOC)){

            array_push($result_page_all,$res_page_all);

        }

        return($result_page_all);

    }

    public function add_ForumBlog_content(){

        $forumblog_topic = $_POST['Category'] ?? '';
        $forumblog_title = $_POST['Category_Description'] ?? '';

        $sql = "SELECT `id` FROM `blog` WHERE `Category`= :forumblog_topic";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":topic", $blog_topic, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){
            return  'Forum or Blog already exists';
        }

        elseif($ress == NULL) {

            $sql = "INSERT INTO `blog` (`Category`,`Category_Description`) VALUES (:blog_topic,:blog_title)";


            $forumblog = $this->db->prepare($sql);
            $forumblog->bindValue(":blog_topic", $blog_topic, PDO::PARAM_STR);
            $forumblog->bindValue(":blog_title", $blog_title, PDO::PARAM_STR);
            $forumblog->execute();
            return ($forum);
        }
    }

    public function latest_ForumBlog_posts(){

        $result_forum = array();

        $sql = "SELECT `id`,`Category` FROM `blog` UNION ALL SELECT `id`,`Category` FROM `forum` ORDER BY id DESC LIMIT 10";

        $request = $this->db->prepare($sql);
        $request->execute();

        while($res_forum = $request->fetch(PDO::FETCH_ASSOC)){
            array_push($result_forum,$res_forum);
        }

        return $result_forum;
    }

}