<?php

class Model{

    protected $db = null;

    public function __construct(){
        $this->db = DB::connToDB();
    }

    public function gettopic(){

        $categories = array();

        $sql = "SELECT 
                    table_name, 
                    Category, 
                    Subcategory, 
                    MAX(id) AS id
                        FROM (
                            SELECT 
                                'blog' AS `table_name`, 
                                b.Category, 
                                bc.Subcategory,
                                bc.id
                                    FROM blog_category bc
                                        JOIN blog b ON bc.Category = b.id
                        UNION ALL 
                            SELECT 
                                'forum' AS `table_name`, 
                                f.Category, 
                                fc.Subcategory,
                                fc.id
                                    FROM forum_category fc
                                        JOIN forum f ON fc.Category = f.id
                        ) AS combined_results
                            GROUP BY table_name, Category, Subcategory
                                ORDER BY RAND()
                                    LIMIT 9";

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

    public function getSettings(){

        $sql = "SELECT `id`,`name`,`value` FROM `settings`";

        $smtpt = $this->db->prepare($sql);
        $smtpt->execute();

        return $smtpt->fetchall(PDO::FETCH_ASSOC);
    }

    /**
     * Lower-cases a UTF-8 string. Uses the mbstring extension when it is enabled; otherwise falls back
     * to ASCII + Cyrillic (Russian and Ukrainian) letters, so the blacklist works without mbstring.
     */
    public static function lowerCase($str) {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($str, 'UTF-8');
        }

        static $map = null;
        if ($map === null) {
            $map = [];
            // Not strtolower(): before PHP 8.2 it depends on the locale and could damage UTF-8 bytes
            foreach (range('A', 'Z') as $letter) {
                $map[$letter] = strtolower($letter);
            }
            // U+0410..U+042F (cyrillic capital A..YA) -> U+0430..U+044F
            for ($cp = 0x0410; $cp <= 0x042F; $cp++) {
                $map[html_entity_decode('&#' . $cp . ';', ENT_NOQUOTES, 'UTF-8')] = html_entity_decode('&#' . ($cp + 0x20) . ';', ENT_NOQUOTES, 'UTF-8');
            }
            // U+0400..U+040F (cyrillic capital IE with grave, YO, ... DZHE) -> U+0450..U+045F
            for ($cp = 0x0400; $cp <= 0x040F; $cp++) {
                $map[html_entity_decode('&#' . $cp . ';', ENT_NOQUOTES, 'UTF-8')] = html_entity_decode('&#' . ($cp + 0x50) . ';', ENT_NOQUOTES, 'UTF-8');
            }
            // Ukrainian GHE WITH UPTURN: U+0490 -> U+0491
            $map[html_entity_decode('&#1168;', ENT_NOQUOTES, 'UTF-8')] = html_entity_decode('&#1169;', ENT_NOQUOTES, 'UTF-8');
        }

        return strtr($str, $map);
    }

    /**
     * Cuts a UTF-8 string to $length characters (works without the mbstring extension).
     */
    public static function cutString($str, $length) {
        return preg_match('/^.{0,' . (int)$length . '}/us', $str, $m) ? $m[0] : $str;
    }

    /**
     * Brings a category name to one form for comparison: lower case, "yo" = "e",
     * any whitespace collapsed to a single space, trimmed.
     * Must stay identical to normalizeName() in assets/js/category_blacklist.js
     */
    public static function normalizeCategoryName($name) {
        $name = self::lowerCase((string)$name);
        $name = str_replace("\u{0451}", "\u{0435}", $name); // cyrillic yo -> ye
        $name = (string)preg_replace('/[\s\p{Z}]+/u', ' ', $name);
        return trim($name);
    }

    /**
     * Turns the raw settings value (names separated by commas and/or new lines)
     * into a list of normalized unique names.
     */
    public static function parseCategoryBlacklist($raw) {
        $list = [];
        $lines = preg_split('/[,\r\n]+/u', (string)$raw);
        if ($lines === false) {
            return $list;
        }
        foreach ($lines as $line) {
            $line = self::normalizeCategoryName($line);
            if ($line !== '') {
                $list[] = $line;
            }
        }
        return array_values(array_unique($list));
    }

    /**
     * True if the name is in the category blacklist (Admin panel -> Settings).
     */
    public function isCategoryBlacklisted($name) {
        global $env;
        $raw = $env['settings_array']['category_blacklist'] ?? '';
        return in_array(self::normalizeCategoryName($name), self::parseCategoryBlacklist($raw), true);
    }

}