<?php


class ForumModel extends Model{


    public function get_page_titles(){

        global $env;

        $sql = "CREATE TABLE if not exists `forum` (`Id` INT, `Topic` TEXT, `Title` TEXT, `Description` TEXT)";

        $forum = $this->db->prepare($sql);

        $forum->execute();

        $result_page_all = array();

        $sql = "SELECT `Topic` FROM `forum`";

        $page_all = $this->db->prepare($sql);

        $page_all->execute();

        while($res_page_all=$page_all->fetch(PDO::FETCH_ASSOC)){

            array_push($result_page_all,$res_page_all);

        }

        return($result_page_all);

    }

    public function add_forum_content(){
        $forum_topic = $_POST['Topic'] ?? '';
        $forum_title = $_POST['Title'] ?? '';
        $forum_description = $_POST['description'] ?? '';

        $sql = "SELECT `id` FROM `forum` WHERE `Topic`= :forum_topic";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":forum_topic", $forum_topic, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){

            $query =  'Такой форум уже есть';
            return $query;
        }

        elseif($ress == NULL) {

            $sql = "INSERT INTO `forum` (`Topic`,`Title`, `Description`) VALUES (:forum_topic,:forum_title, :forum_description)";


            $forum = $this->db->prepare($sql);
            $forum->bindValue(":forum_topic", $forum_topic, PDO::PARAM_STR);
            $forum->bindValue(":forum_title", $forum_title, PDO::PARAM_STR);
            $forum->bindValue(":forum_description", $forum_description, PDO::PARAM_STR);
            $forum->execute();
            return ($forum);
        }
    }

}