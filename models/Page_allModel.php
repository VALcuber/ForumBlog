<?php

class Page_allModel extends Model {

    public function getpageall(){

        global $env;

        $resultpageall = array();

        $sql = "SELECT `Sub_category` FROM `".$env['forum_blog']."-certain-category` WHERE `Category` = '".$env['subcategory']."' ";

        $ppageall = $this->db->prepare($sql);

        $ppageall->execute();

        while($respageall=$ppageall->fetch(PDO::FETCH_ASSOC)){

            array_push($resultpageall,$respageall);

        }

        return($resultpageall);

    }

    public function getpagealltitles(){

        global $env;

        $resultpage = array();

        $sql = "SELECT `Category` FROM `".$env['forum_blog']."-certain-category` WHERE `Category` = '".$env['subcategory']."' ";

        $ppagealltitles = $this->db->prepare($sql);

        $ppagealltitles->execute();

        while($pagealltitles=$ppagealltitles->fetch(PDO::FETCH_ASSOC)){

            array_push($resultpage,$pagealltitles);

        }

        return($resultpage);

    }

}