<?php

class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->model = new AdminModel();
    }
    
    public function index() {
        try {
            $this->controller();
            
            // Get statistics
            $stats = $this->model->getDashboardStats();
            
            // Get recent activities
            $recentActivities = $this->model->getRecentActivities();
            
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
            
            $content = $this->model->getAllContent();
            
            $this->pageData['title'] = "Content Management - Admin Panel";
            $this->pageData['content'] = $content;
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
            
            $reports = $this->model->getReports();
            
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
                    echo json_encode(['success' => true, 'content' => $content]);
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