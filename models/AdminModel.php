<?php

class AdminModel extends Model {
    
    public function getDashboardStats($stats) {
        
        // Get user statistics
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `users`");
            $stmt->execute();
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `users` WHERE status = 'admin'");
            $stmt->execute();
            $stats['admin_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_users'] = 0;
            $stats['admin_users'] = 0;
        }
        
        // Get blog posts count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `blog_category`");
            $stmt->execute();
            $stats['blog_posts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['blog_posts'] = 0;
        }
        
        // Get forum topics count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `forum_category`");
            $stmt->execute();
            $stats['forum_topics'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['forum_topics'] = 0;
        }
        
        // Get comments count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `forum_comments`");
            $stmt->execute();
            $stats['total_comments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_comments'] = 0;
        }
        
        // Get news count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `news`");
            $stmt->execute();
            $stats['total_news'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_news'] = 0;
        }
        
        // Get total categories (blog + forum)
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `blog` UNION ALL SELECT COUNT(*) FROM `forum`");
            $stmt->execute();
            $blogCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $stmt->fetch(PDO::FETCH_ASSOC); // Skip to next result
            $forumCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $stats['total_categories'] = $blogCount + $forumCount;
        } catch (Exception $e) {
            $stats['total_categories'] = 0;
        }
        
        return $stats;
    }
    
    public function getRecentActivities($activities) {

        // Get recent users
        try {
            $sql = "SELECT `id`, `first_name`, `last_name`, `nickname`, `email`, `status` FROM `users` ORDER BY id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $activities['recent_users'] = $users;
        } catch (Exception $e) {
            $activities['recent_users'] = [];
        }
        
        // Get recent blog posts with category names
        try {
            $sql = "SELECT bc.`id`, bc.`Description` as `title`, b.`Category` as `category`, u.`nickname` as `author`
                                                        FROM `blog_category` bc
                                                            LEFT JOIN blog b ON bc.`Category` = b.`id`
                                                                LEFT JOIN `users` u ON bc.`user_id` = u.`id`
                                                                    ORDER BY bc.id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $activities['recent_blog_posts'] = $posts;
        } catch (Exception $e) {
            $activities['recent_blog_posts'] = [];
        }
        
        // Get recent forum topics with category names
        try {
            $sql = "SELECT fc.`id`, fc.`Description` as `title`, f.`Category` as `category`, u.`nickname` as `author`
                                                        FROM `forum_category` fc
                                                            LEFT JOIN `forum` f ON fc.`Category` = f.`id`
                                                                LEFT JOIN `users` u ON fc.`user_id` = u.`id`
                                                                    ORDER BY fc.id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $activities['recent_forum_topics'] = $topics;
        } catch (Exception $e) {
            $activities['recent_forum_topics'] = [];
        }
        
        // Get recent news
        try {
            $sql = "SELECT `id`, `name` as `title`, `content` FROM `news` ORDER BY id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $activities['recent_news'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $activities['recent_news'] = [];
        }
        
        return $activities;
    }
    
    public function getSystemInfo() {
        return [
            'php_version' => PHP_VERSION,
            'mysql_version' => $this->db->getAttribute(PDO::ATTR_SERVER_VERSION),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
        ];
    }//rework
    
    public function getAllUsers() {
        try {
            $sql = "SELECT `id`, `first_name`, `last_name`, `nickname`, `email`, `status`, `logo` FROM `users` ORDER BY id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getAllContent($content) {

        // Get blog posts with category names
        try {
            $sql = "SELECT bc.`id`, bc.`Description` as `title`, b.`Category` as `category_name`, u.`first_name`, u.`last_name`, u.`nickname`
                                                        FROM `blog_category` bc
                                                            LEFT JOIN `blog` b ON bc.`Category` = b.`id`
                                                                LEFT JOIN `users` u ON bc.`user_id` = u.`id`
                                                                    ORDER BY bc.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $content['blog'] = $posts;
        } catch (Exception $e) {
            $content['blog'] = [];
        }
        
        // Get forum topics with category names
        try {
            $sql = "SELECT fc.`id`, fc.`Description` as `title`, f.`Category` as `category_name`, u.`first_name`, u.`last_name`, u.`nickname`
                            FROM `forum_category` fc
                                LEFT JOIN `forum` f ON fc.`Category` = f.`id`
                                    LEFT JOIN `users` u ON fc.`user_id` = u.`id`
                                        ORDER BY fc.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $content['forum'] = $topics;
        } catch (Exception $e) {
            $content['forum'] = [];
        }
        
        // Get news
        try {
            $sql = "SELECT `id`, `name` as `title`, `content` FROM `news` ORDER BY id DESC" ;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($news as &$item) {
                $item['author'] = 'Admin';
                $item['status'] = 'published';
            }
            
            $content['news'] = $news;
        } catch (Exception $e) {
            $content['news'] = [];
        }
        
        return $content;
    }

    public function updateSettings(array $d) {
        try {
            $sql = "UPDATE `settings` 
                SET `value` = CASE `name`
                    WHEN 'title'              THEN :title
                    WHEN 'description'        THEN :description
                    WHEN 'help'               THEN :help
                    WHEN 'admin_email'        THEN :email
                    WHEN 'posts_per_page'     THEN :posts_per_page
                    WHEN 'max_upload_size'    THEN :max_upload_size
                    WHEN 'allowed_file_types' THEN :allowed_file_types
                    ELSE `value`
                END
                WHERE `name` IN ('title', 'description','help', 'admin_email', 'posts_per_page', 'max_upload_size', 'allowed_file_types')";

            $stmt = $this->db->prepare($sql);

            // Explicitly binding each variable
            // This is where the "magic" happens:
            $stmt->bindValue(':title',              $d['title'],       PDO::PARAM_STR);
            $stmt->bindValue(':description',        $d['site_description'], PDO::PARAM_STR);
            $stmt->bindValue(':help',               $d['site_help'], PDO::PARAM_STR);
            $stmt->bindValue(':email',              $d['admin_email'], PDO::PARAM_STR);
            $stmt->bindValue(':posts_per_page',     $d['posts_per_page'], PDO::PARAM_STR);
            $stmt->bindValue(':max_upload_size',    $d['max_upload_size'], PDO::PARAM_STR);
            $stmt->bindValue(':allowed_file_types', $d['allowed_file_types'], PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getReports($reports) {

        // Get user statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `users`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_users'] = 0;
        }

        try {
            $sql = "SELECT `status`, COUNT(*) as total FROM `users` GROUP BY `status`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['users_by_status'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (Exception $e) {
            $reports['users_by_status'] = [];
        }

        try {
            $sql = "SELECT `first_name`, `last_name`, `nickname`, `status`, `birthday`
                        FROM `users`
                        ORDER BY `id` DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['users_list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $reports['users_list'] = [];
        }
        
        // Get blog statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `blog_category`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_posts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_posts'] = 0;
        }

        // Get blog statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `forum_category`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_topics'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_topics'] = 0;
        }
        
        // Get comments statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `forum_comments`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_comments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_comments'] = 0;
        }

        //Get content statistics
        try {
            $sql = "SELECT SUM(total) AS total FROM (SELECT COUNT(*) AS total FROM `blog_category` UNION ALL SELECT COUNT(*) FROM `forum_category`) AS combined_count";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_content'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_content'] = 0;
        }
        
        // Get news statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `news`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_news'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_news'] = 0;
        }
        
        // Get categories statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM `blog` UNION ALL SELECT COUNT(*) FROM `forum`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $blogCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $stmt->fetch(PDO::FETCH_ASSOC); // Skip to next result
            $forumCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            $reports['total_categories'] = $blogCount + $forumCount;
        } catch (Exception $e) {
            $reports['total_categories'] = 0;
        }
        
        return $reports;
    }
    
    public function deleteUser($userId) {
        try {
            $sql = "DELETE FROM `users` WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function createUser($userData) {
        try {
            if (
                $userData['first_name'] === '' ||
                $userData['last_name'] === '' ||
                $userData['nickname'] === '' ||
                $userData['birthday'] === '' ||
                $userData['email'] === '' ||
                $userData['password'] === ''
            ) {
                return ['success' => false, 'message' => 'All fields are required.'];
            }

            $allowedStatuses = ['user', 'moderator', 'admin'];
            if (!in_array($userData['status'], $allowedStatuses, true)) {
                $userData['status'] = 'user';
            }

            $checkSql = "SELECT `id` FROM `users` WHERE `email` = :email LIMIT 1";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindValue(':email', $userData['email'], PDO::PARAM_STR);
            $checkStmt->execute();

            if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                return ['success' => false, 'message' => 'A user with this email already exists.'];
            }

            $sql = "INSERT INTO `users` (`first_name`, `last_name`, `nickname`, `birthday`, `email`, `pass`, `status`)
                    VALUES (:first_name, :last_name, :nickname, :birthday, :email, :password, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':first_name', $userData['first_name'], PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $userData['last_name'], PDO::PARAM_STR);
            $stmt->bindValue(':nickname', $userData['nickname'], PDO::PARAM_STR);
            $stmt->bindValue(':birthday', $userData['birthday'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $userData['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $userData['password'], PDO::PARAM_STR);
            $stmt->bindValue(':status', $userData['status'], PDO::PARAM_STR);
            $stmt->execute();

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to create user.'];
        }
    }
    
    public function updateUserStatus($userId, $status) {
        try {
            $sql = "UPDATE `users` SET `status` = ? WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateUser($userId, $userData) {
        try {
            if ($userId <= 0) {
                return ['success' => false, 'message' => 'Invalid user ID.'];
            }

            $allowedStatuses = ['user', 'moderator', 'admin'];
            if (!in_array($userData['status'], $allowedStatuses, true)) {
                $userData['status'] = 'user';
            }

            if ($userData['email'] !== '') {
                $checkSql = "SELECT `id` FROM `users` WHERE `email` = :email AND `id` != :id LIMIT 1";
                $checkStmt = $this->db->prepare($checkSql);
                $checkStmt->bindValue(':email', $userData['email'], PDO::PARAM_STR);
                $checkStmt->bindValue(':id', $userId, PDO::PARAM_INT);
                $checkStmt->execute();

                if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
                    return ['success' => false, 'message' => 'A user with this email already exists.'];
                }
            }

            $fields = ['`status` = :status'];
            $params = [
                ':status' => $userData['status'],
                ':id' => $userId
            ];

            if ($userData['first_name'] !== '') {
                $fields[] = '`first_name` = :first_name';
                $params[':first_name'] = $userData['first_name'];
            }

            if ($userData['last_name'] !== '') {
                $fields[] = '`last_name` = :last_name';
                $params[':last_name'] = $userData['last_name'];
            }

            if ($userData['nickname'] !== '') {
                $fields[] = '`nickname` = :nickname';
                $params[':nickname'] = $userData['nickname'];
            }

            if ($userData['email'] !== '') {
                $fields[] = '`email` = :email';
                $params[':email'] = $userData['email'];
            }

            $sql = "UPDATE `users` SET " . implode(', ', $fields) . " WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $paramType = $key === ':id' ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $paramType);
            }

            $stmt->execute();

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to update user.'];
        }
    }
    
    public function deleteContent($contentId, $type) {
        try {
            if ($type === 'news') {
                $sql = "DELETE FROM `news` WHERE `id` = ?";
                $stmt = $this->db->prepare($sql);
            } else {
                $table = ($type === 'blog') ? 'blog_category' : 'forum_category';
                $sql = "DELETE FROM $table WHERE `id` = ?";
                $stmt = $this->db->prepare($sql);
            }
            return $stmt->execute([$contentId]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getContentById($contentId, $type) {
        try {
            if ($type === 'news') {
                $sql = "SELECT `id`, `name` as `title`, `content` FROM `news` WHERE `id` = ?";
                $stmt = $this->db->prepare($sql);
            }
            elseif ($type === 'blog') {
                $sql = "SELECT bc.`id`, bc.`Description` as `title`, b.`Category` as `category_name`
                                                            FROM `blog_category` bc
                                                                LEFT JOIN `blog` b ON bc.`Category` = b.`id`
                                                                    WHERE bc.`id` = ?";
                $stmt = $this->db->prepare($sql);
            }
            else {
                $sql = "SELECT fc.`id`, fc.`Description` as `title`, f.`Category` as `category_name`
                                                            FROM `forum_category` fc
                                                                LEFT JOIN `forum` f ON fc.`Category` = f.`id`
                                                                    WHERE fc.`id` = ?";
                $stmt = $this->db->prepare($sql);
            } // forum
            
            $stmt->execute([$contentId]);
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($content) {
                $content['type'] = $type;
                if ($type === 'news') {
                    $content['content'] = $content['content'] ?? '';
                } else {
                    $content['content'] = $content['category_name'] ?? '';
                }
            }
            
            return $content;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getContentCategoriesByType($type) {
        try {
            if ($type === 'blog') {
                $sql = "SELECT `Category` as `category_name` FROM `blog`";
                $stmt = $this->db->prepare($sql);
            }
            elseif($type === 'forum') {
                $sql = "SELECT `Category` as `category_name` FROM `forum`";
                $stmt = $this->db->prepare($sql);
            }
            else die;
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);

        } catch (Exception $e) {
            return null;
        }
    }
    
    public function updateContent($contentId, $type, $title, $content) {
        try {
            if ($type === 'news') {
                $sql = "UPDATE `news` SET `name` = ?, `content` = ? WHERE `id` = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$title, $content, $contentId]);
            } else {
                $table = ($type === 'blog') ? 'blog_category' : 'forum_category';
                $sql = "UPDATE $table SET `Description` = ? WHERE `id` = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$title, $contentId]);
            }
        } catch (Exception $e) {
            return false;
        }
    }
} 
