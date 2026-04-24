<?php

class SearchModel extends Model{

    public function search($searchPattern) {
        $sql = "SELECT DISTINCT 'blog' AS type,
                       b.id,
                       b.Category AS title,
                       NULL AS description,
                       NULL AS Subcategory,
                       NULL AS parent_category
                FROM blog b
                WHERE b.Category LIKE :search
        
                UNION
        
                SELECT 'blog_subcategory' AS type,
                       MIN(bc.id),
                       bc.Subcategory AS title,
                       NULL AS description,
                       bc.Subcategory AS Subcategory,
                       b.Category AS parent_category
                FROM blog_category bc
                INNER JOIN blog b ON bc.Category = b.id
                WHERE bc.Subcategory LIKE :search
                GROUP BY bc.Subcategory, b.Category
        
                UNION
        
                SELECT 'blog_post' AS type,
                       bc.id,
                       bc.Description AS title,
                       bc.Description AS description,
                       bc.Subcategory AS Subcategory,
                       b.Category AS parent_category
                FROM blog_category bc
                INNER JOIN blog b ON bc.Category = b.id
                WHERE bc.Description LIKE :search
        
                UNION
        
                SELECT DISTINCT 'forum' AS type,
                       f.id,
                       f.Category AS title,
                       NULL AS description,
                       NULL AS Subcategory,
                       NULL AS parent_category
                FROM forum f
                WHERE f.Category LIKE :search
        
                UNION
        
                SELECT 'forum_subcategory' AS type,
                       MIN(fc.id),
                       fc.Subcategory AS title,
                       NULL AS description,
                       fc.Subcategory AS Subcategory,
                       f.Category AS parent_category
                FROM forum_category fc
                INNER JOIN forum f ON fc.Category = f.id
                WHERE fc.Subcategory LIKE :search
                GROUP BY fc.Subcategory, f.Category
        
                UNION
        
                SELECT 'forum_post' AS type,
                       fc.id,
                       fc.Description AS title,
                       fc.Description AS description,
                       fc.Subcategory AS Subcategory,
                       f.Category AS parent_category
                FROM forum_category fc
                INNER JOIN forum f ON fc.Category = f.id
                WHERE fc.Description LIKE :search
                
                LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":search", $searchPattern, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}