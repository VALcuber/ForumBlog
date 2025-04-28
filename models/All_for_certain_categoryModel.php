<?php

class All_for_certain_categoryModel extends Model{

    public function get_all_subcategories(){

        global $env;

        $title = $env['all_title'];
        $structure = $env['route1'];

        try {
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $structure)) {
                throw new Exception("Invalid table name");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

// Collect SQL string
        /** @noinspection SqlResolve */
        $sql = "SELECT `{$structure}_category`.`Description`, `{$structure}`.`structure`, `{$structure}`.`Category`
                    FROM `{$structure}_category`
                        JOIN `{$structure}`
                            ON `{$structure}`.`id` = `{$structure}_category`.`Category`
                                WHERE `{$structure}`.`Category` = :title";

        $ppageall = $this->db->prepare($sql);
        $ppageall->bindValue(":title", $title, PDO::PARAM_STR);
        $ppageall->execute();

        $resultpageall=$ppageall->fetchall(PDO::FETCH_ASSOC);

        return($resultpageall);

    }

}