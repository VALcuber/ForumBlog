<?php


class All_for_certain_categoryModel extends Model{

    public function getpageall(){
        global $env;

        $resultpageall = array();

        $sql = "SELECT `Category` FROM :structure WHERE `Category` = :subcategory ";

        $ppageall = $this->db->prepare($sql);

        $ppageall->bindValue(":structure", $env['structure']."_category", PDO::PARAM_STR);
        $ppageall->bindValue(":subcategory", $env['subcategory'], PDO::PARAM_STR);

        $ppageall->execute();

        while($respageall=$ppageall->fetch(PDO::FETCH_ASSOC)){
            array_push($resultpageall,$respageall);
        }
        var_export($resultpageall);
        return($resultpageall);
    }
    public function getpagealltitles(){
        global $env;

        $resultpage = array();

        $sql = "SELECT `Category` FROM `".$env['structure']."-certain-category` WHERE `Category` = '".$env['category']."' ";

        $ppagealltitles = $this->db->prepare($sql);

        $ppagealltitles->execute();

        while($pagealltitles=$ppagealltitles->fetch(PDO::FETCH_ASSOC)){
            array_push($resultpage,$pagealltitles);
        }

        return($resultpage);
    }


}