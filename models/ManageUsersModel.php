<?php

class ManageUsersModel extends Model{

    public function GetUsers(){
        $resultusers=array();

        $sql = "SELECT `id`,`First name`, `Last name`, `status`  FROM `epiz_27717656_forumblog`.`users`";

        $smtp = $this->db->prepare($sql);
        $smtp->execute();

        while($res=$smtp->fetch(PDO::FETCH_ASSOC)){
            array_push($resultusers,$res);
        }

        return $resultusers;
    }

    public function ChangeUserStatus(){
        global $env;

        $status = current($env['id']);
        $id = key($env['id']);

        $sql = "UPDATE `epiz_27717656_forumblog`.`users` SET `status`=:status WHERE  `id`=:id";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":status", $status, PDO::PARAM_STR);
        $smtps->bindValue(":id", $id, PDO::PARAM_STR);
        $smtps->execute();
        return($smtps);
    }
}