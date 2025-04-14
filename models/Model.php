<?php

class Model{

    protected $db = null;

    public function __construct(){
        $this->db = DB::connToDB();
    }

    public function gettopic(){

        $categories = array();

        $sql = "SELECT 'blog' AS `tablename`, `id`, `Category` from `blog`
                    UNION ALL SELECT 'forum' AS `tablename`, `id`, `Category` FROM `forum` ORDER BY `id`";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        while ($row = $smtpt->fetch(PDO::FETCH_ASSOC)) {

            array_push($categories, $row);
        }

        return $categories;
    }

    public function getburger(){

        $categories = array();

        $sql = "SELECT `id`,`Category`,`structure` FROM `blog`UNION ALL SELECT `id`,`Category`,`structure` FROM `forum`  ORDER BY `id` DESC LIMIT 49";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        while ($row = $smtpt->fetch(PDO::FETCH_ASSOC)) {
            array_push($categories, $row);
        }
        return $categories;

    }

    public function checkUser () {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $resultchkuser = array();

        $sql = "SELECT `id`,`First name`,`Last name`,`status`, `logo` FROM `users` WHERE `email` = :email and `pass` = :password ";

        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":email", $email, PDO::PARAM_STR);
        $smtpc->bindValue(":password", $password, PDO::PARAM_STR);
        $smtpc->execute();

        $resc=$smtpc->fetch(PDO::FETCH_ASSOC);

        if ($smtpc->rowCount() == 0){
            $resultchkuser['user_id'] = '';
            $resultchkuser['user_id'] = $resultchkuser;
            return $resultchkuser;
        }
        else {
            $resultchkuser['user_id'] = $resc['id'];
            $resultchkuser['user_id'] = $resc['id'];
            $resultchkuser['first-name'] = $resc['First name'];
            $resultchkuser['last-name'] = $resc['Last name'];
            $resultchkuser['status'] = $resc['status'];

            return $resultchkuser;
        }

    }

    public function SingIn(){
        global $env;

        $email = $env['email'];
        $first_name = $env['first-name'];
        $last_name = $env['last-name'];
        $birthday = $env['birthday'];
        $password = $env['password'];
        //$crypt = $env['crypt'];

        $sql = "SELECT `id` FROM `users` WHERE `email`= :email";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":email", $email, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){

            $query =  'Такой пользователь уже есть';
        }

        elseif($ress == NULL){

            $sql = "INSERT INTO `users` (`First name`,`Last name`,`birthday`,`email`,`pass` ) VALUES (:first_name,:last_name,:birthday,:email,:password)";

            $smtpr = $this->db->prepare($sql);
            $smtpr->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $smtpr->bindValue(":last_name", $last_name, PDO::PARAM_STR);
            $smtpr->bindValue(":birthday", $birthday, PDO::PARAM_STR);
            $smtpr->bindValue(":email", $email, PDO::PARAM_STR);
            $smtpr->bindValue(":password", $password, PDO::PARAM_STR);
            $smtpr->execute();

            $resr=$smtpr->fetch(PDO::FETCH_ASSOC);

            if(!empty($resr)){
                $query = $this->db->lastInsertId();
                return $query;
            }
            else{
                echo "Proval";
            }
        }
    }

    public function check_logo(){
        global $env;

        $user_id = $env['user_data']['user_id'];

        $sql = "SELECT `logo` FROM `users` WHERE `id` = '$user_id'";
        $smtpc = $this->db->prepare($sql);
        $smtpc->execute();

        $res=$smtpc->fetch(PDO::FETCH_ASSOC);
        return $res;

    }

}

