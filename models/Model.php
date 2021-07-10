<?php

class Model
{
    protected $db = null;

    public function __construct()
    {
        $this->db = DB::connToDB();
    }

    public function gettopic()
    {

        $categories = array();

        $sql = "SELECT `id`,`name`,`structure` FROM `blog`UNION ALL SELECT `id`,`name`,`structure` FROM `forum`  ORDER BY `id` DESC LIMIT 12";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        while ($row = $smtpt->fetch(PDO::FETCH_ASSOC)) {
            array_push($categories, $row);
        }
        return $categories;
    }

    public function getburger()
    {

        $categories = array();

        $sql = "SELECT `id`,`name`,`structure` FROM `blog`UNION ALL SELECT `id`,`name`,`structure` FROM `forum`  ORDER BY `id` DESC LIMIT 49";

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

        $result_chk_user = array();

        $sql = "SELECT `id`,`First name`,`Last name`,`status` FROM `users` WHERE `email` = :email and `pass` = :password ";

        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":email", $email, PDO::PARAM_STR);
        $smtpc->bindValue(":password", $password, PDO::PARAM_STR);
        $smtpc->execute();

        $resc=$smtpc->fetch(PDO::FETCH_ASSOC);

        if ($smtpc->rowCount() == 0){
            $result_chk_user['user_id'] = '';
            $_SESSION['user_id'] = $result_chk_user;
            return $result_chk_user;
        }
        else {
            $result_chk_user['user_id'] = $resc['id'];
            //$_SESSION['user_id'] = $resc['id'];
            $result_chk_user['first-name'] = $resc['First name'];
            $result_chk_user['last-name'] = $resc['Last name'];
            $result_chk_user['status'] = $resc['status'];

            return $result_chk_user;
        }

    }

    public function SingIn(){
        global $env;

        $email = $env['email'];
        $first_name = $env['first-name'];
        $last_name = $env['last-name'];
        $birthday = $env['birthday'];
        $password = $env['password'];

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
            $smtpr->bindValue(":email", $email, PDO::PARAM_STR);
            $smtpr->bindValue(":password", $password, PDO::PARAM_STR);
            $smtpr->execute();

            $resr=$smtps->fetch(PDO::FETCH_ASSOC);

            if(!empty($resr)){
                $query = $this->db->lastInsertId();
                return $query;
            }
            else{
                echo "Proval";
            }
        }
    }
}

