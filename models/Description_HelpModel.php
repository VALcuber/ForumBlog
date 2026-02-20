<?php

class Description_HelpModel extends Model{

    public function choose_description(){
        $sql = "SELECT `value` FROM `settings` WHERE `name` = 'description'";
        $request = $this->db->prepare($sql);
        $request->execute();

        return $request->fetchColumn();
    }
    public function choose_help(){
        $sql = "SELECT `value` FROM `settings` WHERE `name` = 'help'";
        $request = $this->db->prepare($sql);
        $request->execute();

        return $request->fetchColumn();
    }
}