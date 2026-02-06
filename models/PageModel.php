<?php

class PageModel extends Model {

    public function get_page() {
        global $env;

        if ($env['route1'] == 'forum') {
            $sql = "SELECT `forum_category`.`Description`, `forum`.`Category`, `forum_category`.`id`, `forum_category`.`user_id`
                    FROM `forum_category`
                    JOIN `forum` ON `forum`.`id` = `forum_category`.`Category`
                    JOIN `users` ON `users`.`id` = `forum_category`.`user_id`
                    WHERE `forum_category`.`Description` = :description";
        } elseif ($env['route1'] == 'news') {
            $sql = "SELECT `id`, `name`, `content` FROM `news` WHERE `name` = :description";
        } elseif ($env['route1'] == 'blog') {
            $sql = "SELECT `blog_category`.`Description`, `blog`.`Category`, `blog_category`.`id`, `blog_category`.`user_id`
                    FROM `blog_category`
                    JOIN `blog` ON `blog`.`id` = `blog_category`.`Category`
                    JOIN `users` ON `users`.`id` = `blog_category`.`user_id`
                    WHERE `blog_category`.`Description` = :description";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":description", $env['route3'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function post_author($user_id) {
        $sql = "SELECT `nickname` FROM `users` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_comments($page = 1, $per_page) {
        global $env;

        $offset = ($page - 1) * $per_page;

        $sql = "SELECT `forum_comments`.*, `users`.`nickname` AS `name` 
                FROM `forum_comments`
                INNER JOIN `users` ON `forum_comments`.`user_id` = `users`.`Id`
                WHERE `forum_comments`.`Forum_page` = (SELECT `id` FROM `forum_category` WHERE `Description` = :page_name)
                AND `forum_comments`.`structure` = :structure
                ORDER BY id DESC 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":page_name", $env['route3'], PDO::PARAM_STR);
        $stmt->bindValue(":structure", $env['route1'], PDO::PARAM_STR);
        $stmt->bindValue(":limit", (int)$per_page, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_comment() {
        global $env;

        $text = $_POST['comment'] ?? '';
        $sql = "INSERT INTO `forum_comments` (`Comment`, `Forum_page`, `user_id`, `structure`) 
                VALUES (:comment, (SELECT `Id` FROM `forum_category` WHERE `Description` = :page_name), :user_id, :structure)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':comment' => $text,
            ':page_name' => $env['route3'],
            ':user_id' => $env['id'] ?? 0,
            ':structure' => $env['route1']
        ]);
    }

    public function get_comments_count() {
        global $env;
        $sql = "SELECT COUNT(*) FROM forum_comments WHERE Forum_page = (SELECT `Id` FROM `forum_category` WHERE `Description` = :page_name)";
        $stat = $this->db->prepare($sql);
        $stat->bindValue(':page_name', $env['route3'], PDO::PARAM_STR);
        $stat->execute();
        return $stat->fetchColumn();
    }
}