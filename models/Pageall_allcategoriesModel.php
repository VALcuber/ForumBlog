<?php

class Pageall_allcategoriesModel extends Model {

    public function getpageall(){
        global $env;
        $resultpageall = array();
        $title = $env['alltitle'];

        $sql = "SELECT `forum-description` FROM `forum-categories` WHERE `title` = :forum_title UNION SELECT `blog-description` FROM `blog-categories` WHERE `title` = :forum_title";

        $ppageall = $this->db->prepare($sql);
        $ppageall->bindValue(":forum_title", $title, PDO::PARAM_STR);
        $ppageall->execute();

        while($respageall=$ppageall->fetch(PDO::FETCH_ASSOC)){
            array_push($resultpageall,$respageall);
        }

        return($resultpageall);

    }

    public function getpagealltitles(){
        global $env;
        $resultpage = array();

        $sql = "SELECT DISTINCT `title` FROM `forum-categories` UNION SELECT `title` FROM `blog-categories`";

        $ppagealltitles = $this->db->prepare($sql);

        $ppagealltitles->execute();

        while($pagealltitles=$ppagealltitles->fetch(PDO::FETCH_ASSOC)){
            array_push($resultpage,$pagealltitles);
        }

        return($resultpage);

    }
}

//UNION SELECT `title`,`blog-description` FROM `blog-categories`