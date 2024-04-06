<?php


class BlogModel extends Model{


    public function get_page_topic(){

        global $env;

        $sql = "CREATE TABLE if not exists `blog` (`Id` INT, `Topic` TEXT, `Title` TEXT, `Description` TEXT, `structure` VARCHAR)";

        $forum = $this->db->prepare($sql);

        $forum->execute();

        $result_page_all = array();

        $sql = "SELECT `Topic` FROM `blog`";

        $page_all = $this->db->prepare($sql);

        $page_all->execute();

        while($res_page_all=$page_all->fetch(PDO::FETCH_ASSOC)){

            array_push($result_page_all,$res_page_all);

        }

        return($result_page_all);

    }

    public function add_blog_content(){
        $blog_topic = $_POST['Topic'] ?? '';
        $blog_title = $_POST['Title'] ?? '';
        $blog_description = $_POST['description'] ?? '';

        $sql = "SELECT `id` FROM `blog` WHERE `Topic`= :blog_topic";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":blog_topic", $blog_topic, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){

            $query =  'Blog already exists';
            return $query;
        }

        elseif($ress == NULL) {

            $sql = "INSERT INTO `blog` (`Topic`,`Title`, `Description`) VALUES (:blog_topic,:blog_title, :blog_description)";


            $forum = $this->db->prepare($sql);
            $forum->bindValue(":blog_topic", $blog_topic, PDO::PARAM_STR);
            $forum->bindValue(":blog_title", $blog_title, PDO::PARAM_STR);
            $forum->bindValue(":blog_description", $blog_description, PDO::PARAM_STR);
            $forum->execute();
            return ($forum);
        }
    }

    public function latest_blog_posts(){

        $result_forum = array();

        $sql = "SELECT `Topic` FROM `blog` ORDER BY id DESC LIMIT 10";

        $request = $this->db->prepare($sql);
        $request->execute();

        while($res_forum = $request->fetch(PDO::FETCH_ASSOC)){
            array_push($result_forum,$res_forum);
        }

        return $result_forum;
    }

}