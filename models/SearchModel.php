<?php

class SearchModel extends Model{

    public function search($searchPattern) {
        $sql = "SELECT 'blog' AS type, 
                       b.`id`, 
                       b.`Category` AS `title`, 
                       b.`Category_Description` AS description,
                       NULL AS parent_category,
                       NULL AS parent_id
                FROM `blog` b
                WHERE b.`Category` LIKE :search
                
                UNION
                
                SELECT 'blog_category' AS type, 
                       bc.`id`, 
                       bc.`Description` AS `title`, 
                       NULL AS description,
                       b.`Category` AS parent_category,
                       b.`id` AS parent_id
                FROM `blog_category` bc
                INNER JOIN `blog` b ON bc.`Category` = b.`id`
                WHERE bc.`Description` LIKE :search
                
                UNION
                
                SELECT 'forum' AS type, 
                       f.`id`, 
                       f.`Category` AS `title`, 
                       f.`Category_Description` AS description,
                       NULL AS parent_category,
                       NULL AS parent_id
                FROM `forum` f
                WHERE f.`Category` LIKE :search
                
                UNION
                
                SELECT 'forum_category' AS type, 
                       fc.`id`, 
                       fc.`Description` AS `title`, 
                       NULL AS description,
                       f.`Category` AS parent_category,
                       f.`id` AS parent_id
                FROM `forum_category` fc
                INNER JOIN `forum` f ON fc.`Category` = f.`id`
                WHERE fc.`Description` LIKE :search
                
                LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":search", $searchPattern, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}