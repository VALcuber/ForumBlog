<?php

class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->model = new AdminModel();
    }
    
    public function index() {
        try {
            $this->controller();

            $stats = [
                'total_users' => 0,
                'admin_users' => 0,
                'blog_posts' => 0,
                'forum_topics' => 0,
                'total_comments' => 0,
                'total_news' => 0,
                'total_categories' => 0
            ];
            
            // Get statistics
            $stats = $this->model->getDashboardStats($stats);

            $activities = [
                'recent_users' => [],
                'recent_blog_posts' => [],
                'recent_forum_topics' => [],
                'recent_news' => []
            ];

            // Get recent activities
            $recentActivities = $this->model->getRecentActivities($activities);
            
            // Get system information
            $systemInfo = $this->model->getSystemInfo();
            
            $this->pageData['title'] = "Administrative Panel - Forum-blog";
            $this->pageData['stats'] = $stats;
            $this->pageData['recent_activities'] = $recentActivities;
            $this->pageData['system_info'] = $systemInfo;
            $this->pageData['admin_page'] = true;
            
            $this->view->render('admin/dashboard', $this->pageData);
        } catch (Exception $e) {
            // Log error and show user-friendly message
            error_log("Admin dashboard error: " . $e->getMessage());
            $this->pageData['error'] = "An error occurred while loading the dashboard. Please try again.";
            $this->view->render('admin/dashboard', $this->pageData);
        }
    }
    
    public function content() {
        try {
            $this->controller();

            $content = [
                'blog' => [],
                'forum' => [],
                'news' => []
            ];

            $content = $this->model->getAllContent($content);

            // Transform field names to match template expectations
            foreach ($content['blog'] as &$post) {
                $post['author'] = ($post['nickname'] ?? '');
                $post['title'] = $post['title'] ?? 'Untitled';
                $post['category'] = $post['category_name'] ?? 'Unknown';
                $post['status'] = 'published';
            }

            // Transform field names to match template expectations
            foreach ($content['forum'] as &$topic) {
                $topic['author'] = ($topic['first_name'] ?? '');
                $topic['title'] = $topic['title'] ?? 'Untitled';
                $topic['category'] = $topic['category_name'] ?? 'Unknown';
                $topic['status'] = 'published';
            }

            foreach ($content['news'] as &$item) {
                $item['author'] = 'Admin';
                $item['status'] = 'published';
            }

            $this->pageData['title'] = "Content Management - Admin Panel";
            $this->pageData['content'] = $content;
            $this->pageData['content_blog'] = $this->content_blog($content['blog']);
            $this->pageData['content_forum'] = $this->content_forum($content['forum']);
            $this->pageData['content_news'] = $this->content_news($content['news']);
            $this->pageData['admin_page'] = true;

            $this->view->render('admin/content', $this->pageData);
        } catch (Exception $e) {
            error_log("Admin content error: " . $e->getMessage());
            $this->pageData['error'] = "An error occurred while loading content. Please try again.";
            $this->view->render('admin/content', $this->pageData);
        }
    }
    
    public function users() {
        try {
            $this->controller();
            
            $users = $this->model->getAllUsers();

            // Transform field names to match template expectations
            foreach ($users as &$user) {
                $user['first_name'] = $user['First name'] ?? '';
                $user['last_name'] = $user['Last name'] ?? '';
                $user['nickname'] = $user['Nickname'] ?? '';
            }
            
            $this->pageData['title'] = "User Management - Admin Panel";
            $this->pageData['users'] = $users;
            $this->pageData['admin_page'] = true;
            
            $this->view->render('admin/users', $this->pageData);
        } catch (Exception $e) {
            error_log("Admin users error: " . $e->getMessage());
            $this->pageData['error'] = "An error occurred while loading users. Please try again.";
            $this->view->render('admin/users', $this->pageData);
        }
    }

    private function content_blog($blogPosts) {
        $blog_rows = [];

        if (!empty($blogPosts)) {
            foreach ($blogPosts as $post) {
                $blog_rows[] = '<tr>'
                    . '<td>' . htmlspecialchars($post['title']) . '</td>'
                    . '<td><span class="badge bg-info">' . htmlspecialchars($post['category']) . '</span></td>'
                    . '<td>' . htmlspecialchars($post['author']) . '</td>'
                    . '<td><span class="badge bg-success">' . htmlspecialchars(ucfirst($post['status'])) . '</span></td>'
                    . '<td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-content-type="blog">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-content-btn" 
                            data-content-id="' . htmlspecialchars($post['id'] ?? '') . '" 
                            data-content-type="blog">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>'
                    . '</tr>';
            }
        } else {
            $blog_rows[] = '<tr><td colspan="5" class="text-center text-muted">No blog posts found</td></tr>';
        }

        return $blog_rows;
    }
    private function content_forum($forumPosts) {
        $forum_rows = [];

        if (!empty($forumPosts)) {
            foreach ($forumPosts as $topic) {
                $forum_rows[] = '<tr>'
                    . '<td>' . htmlspecialchars($topic['title']) . '</td>'
                    . '<td><span class="badge bg-info">' . htmlspecialchars($topic['category']) . '</span></td>'
                    . '<td>' . htmlspecialchars($topic['author']) . '</td>'
                    . '<td><span class="badge bg-success">' . htmlspecialchars(ucfirst($topic['status'])) . '</span></td>'
                    . '<td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-content-type="forum">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-content-btn" 
                            data-content-id="' . htmlspecialchars($topic['id'] ?? '') . '" 
                            data-content-type="forum">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>'
                    . '</tr>';
            }
        } else {
            $forum_rows[] = '<tr><td colspan="5" class="text-center text-muted">No blog posts found</td></tr>';
        }

        return $forum_rows;
    }
    private function content_news($newsPosts) {
        $news_rows = [];

        if (!empty($newsPosts)) {
            foreach ($newsPosts as $topic) {
                $news_rows[] = '<tr>'
                    . '<td>' . htmlspecialchars($topic['title']) . '</td>'
                    . '<td><span class="badge bg-info">' . htmlspecialchars($topic['content']) . '</span></td>'
                    . '<td>' . htmlspecialchars($topic['author']) . '</td>'
                    . '<td><span class="badge bg-success">' . htmlspecialchars(ucfirst($topic['status'])) . '</span></td>'
                    . '<td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-content-type="news">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-content-btn" 
                            data-content-id="' . htmlspecialchars($topic['id'] ?? '') . '" 
                            data-content-type="news">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>'
                    . '</tr>';
            }
        } else {
            $news_rows[] = '<tr><td colspan="5" class="text-center text-muted">No blog posts found</td></tr>';
        }

        return $news_rows;
    }


    public function settings() {
        try {
            $this->controller();
            
            if ($_POST) {
                $this->model->updateSettings($_POST);
                $this->pageData['success_message'] = "Settings updated successfully";
            }
            
            $settings = $this->model->getSettings();
            
            $this->pageData['title'] = "Site Settings - Admin Panel";
            $this->pageData['settings'] = $settings;
            $this->pageData['admin_page'] = true;
            
            $this->view->render('admin/settings', $this->pageData);
        } catch (Exception $e) {
            error_log("Admin settings error: " . $e->getMessage());
            $this->pageData['error'] = "An error occurred while loading settings. Please try again.";
            $this->view->render('admin/settings', $this->pageData);
        }
    }
    
    public function reports() {
        try {
            $this->controller();

            $reports = [
                'total_users' => 0,
                'total_posts' => 0,
                'total_comments' => 0,
                'total_news' => 0,
                'total_categories' => 0,
                'user_activity' => [],
                'blog_activity' => [],
                'forum_activity' => []
            ];

            $reports = $this->model->getReports($reports);
            
            $this->pageData['title'] = "Reports and Analytics - Admin Panel";
            $this->pageData['reports'] = $reports;
            $this->pageData['admin_page'] = true;
            
            $this->view->render('admin/reports', $this->pageData);
        } catch (Exception $e) {
            error_log("Admin reports error: " . $e->getMessage());
            $this->pageData['error'] = "An error occurred while loading reports. Please try again.";
            $this->view->render('admin/reports', $this->pageData);
        }
    }
    
    public function ajax() {
        try {
            $this->controller();
            
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'delete_user':
                    $userId = $_POST['user_id'] ?? 0;
                    $result = $this->model->deleteUser($userId);
                    echo json_encode(['success' => $result]);
                    break;
                    
                case 'update_user_status':
                    $userId = $_POST['user_id'] ?? 0;
                    $status = $_POST['status'] ?? '';
                    $result = $this->model->updateUserStatus($userId, $status);
                    echo json_encode(['success' => $result]);
                    break;
                    
                case 'delete_content':
                    $contentId = $_POST['content_id'] ?? 0;
                    $contentType = $_POST['content_type'] ?? '';
                    $result = $this->model->deleteContent($contentId, $contentType);
                    echo json_encode(['success' => $result]);
                    break;
                    
                case 'get_content':
                    $contentId = $_POST['content_id'] ?? 0;
                    $contentType = $_POST['content_type'] ?? '';
                    $content = $this->model->getContentById($contentId, $contentType);

                    $categories = [];

                    if ($contentType !== 'news') {
                        $categories = $this->model->getContentCategoriesByType($contentType);
                    }
                    echo json_encode(['success' => true, 'content' => $content, "categories" => $categories, "type" => $contentType]);
                    break;
                    
                case 'update_content':
                    $contentId = $_POST['content_id'] ?? 0;
                    $contentType = $_POST['content_type'] ?? '';
                    $title = $_POST['title'] ?? '';
                    $content = $_POST['content'] ?? '';
                    $result = $this->model->updateContent($contentId, $contentType, $title, $content);
                    echo json_encode(['success' => $result]);
                    break;
                    
                default:
                    echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
        } catch (Exception $e) {
            error_log("Admin AJAX error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
    }
}