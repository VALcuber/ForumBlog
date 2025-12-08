<?php

class SearchModel extends Model{

    public function search($query) {

        $user_search = trim($query ?? '');

        $safeuser_search = str_replace("'", "''", $user_search);

        $sql = "SELECT 'Category' AS TYPE, `id`, `Category` COLLATE utf8_general_ci AS `title` FROM `blog` WHERE `Category`= :safeuser_search
                UNION
                SELECT 'Description' AS type, `id`, `Category` COLLATE utf8_general_ci AS `title` FROM `blog_category` WHERE `Description`= :safeuser_search
                UNION
                SELECT 'Category' AS type, `id`, `Category` COLLATE utf8_general_ci AS `title` FROM `forum` WHERE `Category`= :safeuser_search
                UNION
                SELECT 'Description' AS type,`id`, `Category` COLLATE utf8_general_ci AS `title` FROM `forum_category` WHERE `Description`= :safeuser_search
                UNION
                SELECT 'name' AS TYPE, `id`, `name` COLLATE utf8_general_ci AS `title` FROM `news` WHERE `name`= :safeuser_search
                LIMIT 10";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":safeuser_search", $safeuser_search, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
