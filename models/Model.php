<?php

class Model{

    protected $db = null;

    public function __construct(){
        $this->db = DB::connToDB();
    }

    public function gettopic(){

        $categories = array();

        $sql = "SELECT 'blog' AS `table_name`, `id`, `Category` from `blog`
                    UNION ALL SELECT 'forum' AS table_name, `id`, `Category` FROM `forum` ORDER BY `id`";

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

        $sql = "SELECT `id`, `first_name`, `last_name`,`nickname`, `status`, `logo` FROM `users` WHERE `email` = :email and `pass` = :password ";

        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":email", $email, PDO::PARAM_STR);
        $smtpc->bindValue(":password", $password, PDO::PARAM_STR);
        $smtpc->execute();

        if ($smtpc->rowCount() == 0){
            $resultchkuser['user_id'] = '';
            return $resultchkuser;
        }
        else {
            $resc=$smtpc->fetch(PDO::FETCH_ASSOC);
            foreach ($resc as $k => $v) {
                if (!mb_check_encoding($v, 'UTF-8')) {
                    echo "Проблема с [$k]: не UTF-8<br>";
                }
            }
            return $resc;
        }

    }

    public function SingIn(){
        global $env;

        $email = $env['email'];
        $first_name = $env['first-name'];
        $last_name = $env['last-name'];
        $nickname = $env['nickname'];
        $birthday = $env['birthday'];
        $password = $env['password'];
        //$crypt = $env['crypt'];

        $sql = "SELECT `id` FROM `users` WHERE `email`= :email";

        $smtps = $this->db->prepare($sql);
        $smtps->bindValue(":email", $email, PDO::PARAM_STR);
        $smtps->execute();

        $ress=$smtps->fetch(PDO::FETCH_ASSOC);

        if(!empty($ress)){
            return 'User already exist';
        }

        elseif($ress == NULL){

            $sql = "INSERT INTO `users` (`first_name`,`last_name`,`nickname`,`birthday`,`email`,`pass` ) VALUES (:first_name,:last_name,:nickname,:birthday,:email,:password)";

            $smtpr = $this->db->prepare($sql);
            $smtpr->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $smtpr->bindValue(":last_name", $last_name, PDO::PARAM_STR);
            $smtpr->bindValue(":nickname", $nickname, PDO::PARAM_STR);
            $smtpr->bindValue(":birthday", $birthday, PDO::PARAM_STR);
            $smtpr->bindValue(":email", $email, PDO::PARAM_STR);
            $smtpr->bindValue(":password", $password, PDO::PARAM_STR);
            $smtpr->execute();

            $resr=$smtpr->fetch(PDO::FETCH_ASSOC);

            if(!empty($resr)){
                return $this->db->lastInsertId();
            }
            else{
                echo "Proval";
            }
        }
    }

    public function check_logo($user_id){

        $sql = "SELECT `logo` FROM `users` WHERE `id` = :id";

        $smtpc = $this->db->prepare($sql);
        $smtpc->bindValue(":id", $user_id, PDO::PARAM_STR);
        $smtpc->execute();

        return $smtpc->fetch(PDO::FETCH_ASSOC);

    }

    public function getSettings() {
        $sql = "SELECT `id`,`name`,`value` FROM `settings`";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        return $smtpt->fetchall(PDO::FETCH_ASSOC);



 /*return [
            'site_name' => 'Forum-blog',
            'site_description' => 'A forum and blog platform',
            'admin_email' => 'lordiccat@gmail.com',
            'posts_per_page' => 10,
            'allow_comments' => '1',
            'max_upload_size' => 10,
            'allowed_file_types' => 'jpg,jpeg,png',
        ];*/
    }//rework

}

