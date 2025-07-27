<?php
class SettingsController extends Controller{

    private $pageTpl = '/templates/settings.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new settingsModel();
        $this->view = new View();
    }

    public function index(){
        $this->controller();
        $this->pageData['settings'] = $this->model->getSettings();
        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function save(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingsModel = new SettingsModel();
            $settings = $this->getSettings();

            // Collect data by sections
            $settings['site'] = [
                'title' => $_POST['site_title'] ?? '',
                'maintenance_mode' => isset($_POST['maintenance_mode']),
                'default_language' => $_POST['default_language'] ?? 'ru',
                'contact_email' => $_POST['contact_email'] ?? '',
                'welcome_message' => $_POST['welcome_message'] ?? '',
                'registration_enabled' => isset($_POST['registration_enabled']),
                'logo' => $settings['site']['logo'],
                'favicon' => $settings['site']['favicon'],
            ];
            // Handle file uploads
            if (!empty($_FILES['site_logo']['tmp_name'])) {
                $logoPath = 'assets/img/logo.png';
                move_uploaded_file($_FILES['site_logo']['tmp_name'], $logoPath);
                $settings['site']['logo'] = $logoPath;
            }
            if (!empty($_FILES['site_favicon']['tmp_name'])) {
                $faviconPath = 'assets/img/favicon.ico';
                move_uploaded_file($_FILES['site_favicon']['tmp_name'], $faviconPath);
                $settings['site']['favicon'] = $faviconPath;
            }

            $settings['categories'] = [
                'sort_order' => $_POST['categories_sort_order'] ?? 'asc',
                'show_empty' => isset($_POST['categories_show_empty']),
                'max_depth' => (int)($_POST['categories_max_depth'] ?? 2),
            ];

            $settings['moderation'] = [
                'premoderation' => isset($_POST['moderation_premoderation']),
                'auto_hide_reported' => isset($_POST['moderation_auto_hide_reported']),
                'stop_words' => $_POST['moderation_stop_words'] ?? '',
            ];

            $settings['news'] = [
                'news_on_main' => (int)($_POST['news_on_main'] ?? 5),
                'comments_enabled' => isset($_POST['news_comments_enabled']),
            ];

            $settings['files'] = [
                'max_file_size' => (int)($_POST['files_max_file_size'] ?? 2048),
                'allowed_types' => $_POST['files_allowed_types'] ?? 'jpg,png,gif',
                'images_in_comments' => isset($_POST['files_images_in_comments']),
            ];

            $settings['seo'] = [
                'meta_title' => $_POST['seo_meta_title'] ?? '',
                'meta_description' => $_POST['seo_meta_description'] ?? '',
                'meta_keywords' => $_POST['seo_meta_keywords'] ?? '',
                'robots_txt' => $_POST['seo_robots_txt'] ?? '',
                'sitemap_enabled' => isset($_POST['seo_sitemap_enabled']),
            ];

            $settings['security'] = [
                'login_attempts_limit' => (int)($_POST['security_login_attempts_limit'] ?? 5),
                'lockout_time' => (int)($_POST['security_lockout_time'] ?? 15),
                'captcha_enabled' => isset($_POST['security_captcha_enabled']),
                'min_password_length' => (int)($_POST['security_min_password_length'] ?? 8),
            ];

            $settings['backup'] = [
                'auto_backup' => isset($_POST['backup_auto_backup']),
                'backup_time' => $_POST['backup_time'] ?? '03:00',
                'backup_storage' => $_POST['backup_storage'] ?? 'local',
            ];

            $settings['theme'] = [
                'theme' => $_POST['theme_theme'] ?? 'light',
                'custom_css' => $_POST['theme_custom_css'] ?? '',
                'mobile_logo' => $settings['theme']['mobile_logo'],
                'animations_enabled' => isset($_POST['theme_animations_enabled']),
            ];
            if (!empty($_FILES['theme_mobile_logo']['tmp_name'])) {
                $mobileLogoPath = 'assets/img/logo_mobile.png';
                move_uploaded_file($_FILES['theme_mobile_logo']['tmp_name'], $mobileLogoPath);
                $settings['theme']['mobile_logo'] = $mobileLogoPath;
            }

            $settingsModel->saveSettings($settings);

            // Use PRG pattern - redirect after POST
            header('Location: /admin/settings?success=1');
            exit; // Important to add exit after redirect
        }
    }
}