<?php

class ForumBlogSertainSubcategoryModel extends Model{

    public function get_ForumBlog_sertain_sub_topic($route){

        $result_page_all = array();

        $sql = "SELECT f.structure, f.Category, fc.id, fc.Subcategory, fc.Description, fc.user_id
                    FROM forum_category fc
                        JOIN forum f ON fc.Category = f.id
                            WHERE fc.Description = :route
                 UNION(
                     
                 SELECT b.structure, b.Category, bc.id, bc.Subcategory, bc.Description, bc.user_id
                    FROM blog_category bc
                        JOIN blog b ON bc.Category = b.id
                            WHERE bc.Description = :route)
                                ORDER BY structure, Subcategory, Description";

        $page_all = $this->db->prepare($sql);
        $page_all->bindValue(":route", $route, PDO::PARAM_STR);
        $page_all->execute();

        while ($res_page_all = $page_all->fetch(PDO::FETCH_ASSOC)) {

            array_push($result_page_all, $res_page_all);

        }

        return ($result_page_all);

    }

    public function add_ForumBlog_sertain_sub_content($target){
        global $env;
        try {
            $forumblog_topic = $_POST['Category'] ?? '';
            $forumblog_title = $_POST['Category_Description'] ?? '';
            $forumblog_subcategory = $_POST['Subcategory'] ?? '';
            $forumblog_description = $_POST['Description'] ?? '';

            if (!in_array($target, ['forum', 'blog'], true)) {
                return "Error: Invalid target";
            }

            $table = ($target === 'forum') ? 'forum' : 'blog';
            // Fix: Removed 'to_forum' check as the target is passed as 'forum' or 'blog' from data-act
            $childTable = ($target === 'forum') ? 'forum_category' : 'blog_category';

            // Check if category already exists
            $sql = "SELECT `id` FROM `$table` WHERE `Category` = :topic LIMIT 1";
            $smtps = $this->db->prepare($sql);
            $smtps->bindValue(":topic", $forumblog_topic, PDO::PARAM_STR);
            $smtps->execute();
            $existingCategory = $smtps->fetch(PDO::FETCH_ASSOC);

            $this->db->beginTransaction();

            if (!empty($existingCategory)) {
                // Category exists, get its ID to link the subcategory
                $categoryId = $existingCategory['id'];
            } else {
                // Category is new, insert it into the parent table
                $sql1 = "INSERT INTO `$table` (`Category`, `Category_Description`) VALUES (:category, :cat_desc)";
                $stmt1 = $this->db->prepare($sql1);
                $stmt1->bindValue(":category", $forumblog_topic, PDO::PARAM_STR);
                $stmt1->bindValue(":cat_desc", $forumblog_title, PDO::PARAM_STR);
                $stmt1->execute();

                // Get the newly created ID
                $categoryId = $this->db->lastInsertId();
            }

            // Insert the subcategory into the child table, linked by category_id
            $sql2 = "INSERT INTO `$childTable` (`Category`, `Subcategory`, `Description`, `user_id`) 
                 VALUES (:category_id, :sub, :descr, :user_id)";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bindValue(":category_id", $categoryId, PDO::PARAM_INT);
            $stmt2->bindValue(":sub", $forumblog_subcategory, PDO::PARAM_STR);
            $stmt2->bindValue(":descr", $forumblog_description, PDO::PARAM_STR);
            // Ensure $env['id'] is cast properly
            $stmt2->bindValue(":user_id", $env['id'] ?? 0, PDO::PARAM_INT);
            $stmt2->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Rollback transaction on failure
            $this->db->rollBack();
            return "Error: " . $e->getMessage();
        }
    }

    public function latest_ForumBlog_sertain_sub_posts(){

        $result_forum = array();

        $sql = "SELECT `id`,`Category` FROM `blog` UNION ALL SELECT `id`,`Category` FROM `forum` ORDER BY id DESC LIMIT 10";

        $request = $this->db->prepare($sql);
        $request->execute();

        while ($res_forum = $request->fetch(PDO::FETCH_ASSOC)) {
            array_push($result_forum, $res_forum);
        }

        return $result_forum;
    }
}