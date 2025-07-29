<?php

class AdminModel extends Model {
    
    public function getDashboardStats($stats) {
        
        // Get user statistics
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM users");
            $stmt->execute();
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM users WHERE status = 'admin'");
            $stmt->execute();
            $stats['admin_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_users'] = 0;
            $stats['admin_users'] = 0;
        }
        
        // Get blog posts count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM blog_category");
            $stmt->execute();
            $stats['blog_posts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['blog_posts'] = 0;
        }
        
        // Get forum topics count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM forum_category");
            $stmt->execute();
            $stats['forum_topics'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['forum_topics'] = 0;
        }
        
        // Get comments count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM forum_comments");
            $stmt->execute();
            $stats['total_comments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_comments'] = 0;
        }
        
        // Get news count
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM news");
            $stmt->execute();
            $stats['total_news'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $stats['total_news'] = 0;
        }
        
        // Get total categories (blog + forum)
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM blog UNION ALL SELECT COUNT(*) FROM forum");
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
            $sql = "SELECT id, `First name`, `Last name`, `Nickname`, email, status 
                                                        FROM users 
                                                            ORDER BY id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Transform field names to match template expectations
            foreach ($users as &$user) {
                $user['first_name'] = $user['First name'] ?? '';
                $user['last_name'] = $user['Last name'] ?? '';
                $user['nickname'] = $user['Nickname'] ?? '';
            }
            
            $activities['recent_users'] = $users;
        } catch (Exception $e) {
            $activities['recent_users'] = [];
        }
        
        // Get recent blog posts with category names
        try {
            $sql = "SELECT bc.id, bc.Description as title, b.Category as category_name, u.`First name`, u.`Last name`, u.`Nickname`
                                                        FROM blog_category bc
                                                            LEFT JOIN blog b ON bc.Category = b.id
                                                                LEFT JOIN users u ON bc.user_id = u.id
                                                                    ORDER BY bc.id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Transform field names to match template expectations
            foreach ($posts as &$post) {
                $post['author'] = ($post['First name'] ?? '') . ' ' . ($post['Last name'] ?? '');
                $post['title'] = $post['title'] ?? 'Untitled';
                $post['category'] = $post['category_name'] ?? 'Unknown';
            }
            
            $activities['recent_blog_posts'] = $posts;
        } catch (Exception $e) {
            $activities['recent_blog_posts'] = [];
        }
        
        // Get recent forum topics with category names
        try {
            $sql = "SELECT fc.id, fc.Description as title, f.Category as category_name, u.`First name`, u.`Last name`, u.`Nickname`
                                                        FROM forum_category fc
                                                            LEFT JOIN forum f ON fc.Category = f.id
                                                                LEFT JOIN users u ON fc.user_id = u.id
                                                                    ORDER BY fc.id DESC LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Transform field names to match template expectations
            foreach ($topics as &$topic) {
                $topic['author'] = ($topic['First name'] ?? '') . ' ' . ($topic['Last name'] ?? '');
                $topic['title'] = $topic['title'] ?? 'Untitled';
                $topic['category'] = $topic['category_name'] ?? 'Unknown';
            }
            
            $activities['recent_forum_topics'] = $topics;
        } catch (Exception $e) {
            $activities['recent_forum_topics'] = [];
        }
        
        // Get recent news
        try {
            $sql = "SELECT id, name as title, content
                            FROM news 
                                ORDER BY id DESC LIMIT 10";
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
            $sql = "SELECT id, `First name`, `Last name`, `Nickname`, email, status, logo FROM users ORDER BY id DESC";
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
            $sql = "SELECT bc.id, bc.Description as title, b.Category as category_name, u.`First name`, u.`Last name`, u.`Nickname`
                                                        FROM blog_category bc
                                                            LEFT JOIN blog b ON bc.Category = b.id
                                                                LEFT JOIN users u ON bc.user_id = u.id
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
            $sql = "SELECT fc.id, fc.Description as title, f.Category as category_name, u.`First name`, u.`Last name`, u.`Nickname`
                            FROM forum_category fc
                                LEFT JOIN forum f ON fc.Category = f.id
                                    LEFT JOIN users u ON fc.user_id = u.id
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
            $sql = "SELECT id, name as title, content FROM news ORDER BY id DESC" ;
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
    
    public function getSettings() {
        return [
            'site_name' => 'Forum-blog',
            'site_description' => 'A forum and blog platform',
            'admin_email' => 'admin@example.com',
            'posts_per_page' => 10,
            'allow_comments' => '1',
            'moderate_comments' => '1',
            'max_upload_size' => 10,
            'allowed_file_types' => 'jpg,jpeg,png,gif,pdf',
            'allow_registration' => '1',
            'email_verification' => '0'
        ];
    }//rework
    
    public function updateSettings($settings) {
        // In a real application, you would save these to database
        // For now, just return true
        return true;
    }//rework
    
    public function getReports($reports) {

        // Get user statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_users'] = 0;
        }
        
        // Get blog statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM blog_category";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_posts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_posts'] = 0;
        }
        
        // Get comments statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM forum_comments";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_comments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_comments'] = 0;
        }
        
        // Get news statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM news";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reports['total_news'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            $reports['total_news'] = 0;
        }
        
        // Get categories statistics
        try {
            $sql = "SELECT COUNT(*) as total FROM blog UNION ALL SELECT COUNT(*) FROM forum";
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
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function updateUserStatus($userId, $status) {
        try {
            $sql = "UPDATE users SET status = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function deleteContent($contentId, $type) {
        try {
            if ($type === 'news') {
                $sql = "DELETE FROM news WHERE id = ?";
                $stmt = $this->db->prepare($sql);
            } else {
                $table = ($type === 'blog') ? 'blog_category' : 'forum_category';
                $sql = "DELETE FROM $table WHERE id = ?";
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
                $sql = "SELECT id, name as title, content FROM news WHERE id = ?";
                $stmt = $this->db->prepare($sql);
            }
            elseif ($type === 'blog') {
                $sql = "SELECT bc.id, bc.Description as title, b.Category as category_name
                                                            FROM blog_category bc
                                                                LEFT JOIN blog b ON bc.Category = b.id
                                                                    WHERE bc.id = ?";
                $stmt = $this->db->prepare($sql);
            }
            else {
                $sql = "SELECT fc.id, fc.Description as title, f.Category as category_name
                                                            FROM forum_category fc
                                                                LEFT JOIN forum f ON fc.Category = f.id
                                                                    WHERE fc.id = ?";
                $stmt = $this->db->prepare($sql);
            } // forum
            
            $stmt->execute([$contentId]);
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($content) {
                $content['type'] = $type;
                if ($type === 'news') {
                    $content['content'] = $content['content'] ?? '';
                } else {
                    $content['content'] = $content['title'] ?? '';
                }
            }
            
            return $content;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public function updateContent($contentId, $type, $title, $content) {
        try {
            if ($type === 'news') {
                $sql = "UPDATE news SET name = ?, content = ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$title, $content, $contentId]);
            } else {
                $table = ($type === 'blog') ? 'blog_category' : 'forum_category';
                $sql = "UPDATE $table SET Description = ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$title, $contentId]);
            }
        } catch (Exception $e) {
            return false;
        }
    }
} 