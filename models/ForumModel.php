<?php


class ForumModel extends Model{


    public function get_page_topic(){

        $result_page_all = array();

        $sql = "SELECT `Category` FROM `forum`";

        $page_all = $this->db->prepare($sql);

        $page_all->execute();

        while($res_page_all=$page_all->fetch(PDO::FETCH_ASSOC)){

            array_push($result_page_all,$res_page_all);

        }

        return($result_page_all);

    }

    public function add_forum_content(){

        $forum_topic = $_POST['Category'] ?? '';
        $forum_title = $_POST['Category_Description'] ?? '';

        $sql = "SELECT `id` FROM `forum` WHERE `Category`= :forum_topic";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":forum_topic", $forum_topic, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){

          return 'Same forum already exist';
        }

        elseif($ress == NULL) {

            $sql = "INSERT INTO `forum` (`Category`,`Category_Description`) VALUES (:forum_topic,:forum_title)";


            $forum = $this->db->prepare($sql);
            $forum->bindValue(":forum_topic", $forum_topic, PDO::PARAM_STR);
            $forum->bindValue(":forum_title", $forum_title, PDO::PARAM_STR);
            $forum->execute();
            return ($forum);
        }
    }

    public function latest_forum_posts(){

        $result_forum = array();

        $sql = "SELECT `Category` FROM `forum` ORDER BY id DESC LIMIT 10";

        $request = $this->db->prepare($sql);
        $request->execute();

        while($res_forum = $request->fetch(PDO::FETCH_ASSOC)){
            array_push($result_forum,$res_forum);
        }

        return $result_forum;
    }

}