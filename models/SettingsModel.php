<?php
class SettingsModel extends Model {
    
    // Get all settings
    public function getSettings() {
        return [
            'site' => [
                'title' => 'Forum-blog',
                'maintenance_mode' => false,
                'default_language' => 'en',
                'contact_email' => 'admin@forum-blog.com',
                'welcome_message' => 'Welcome to our forum and blog!',
                'registration_enabled' => true,
                'logo' => 'assets/img/logo.png',
                'favicon' => 'assets/img/favicon.ico',
            ],
            'categories' => [
                'sort_order' => 'asc',
                'show_empty' => false,
                'max_depth' => 2,
            ],
            'moderation' => [
                'premoderation' => false,
                'auto_hide_reported' => true,
                'stop_words' => '',
            ],
            'news' => [
                'news_on_main' => 5,
                'comments_enabled' => true,
            ],
            'files' => [
                'max_file_size' => 2048,
                'allowed_types' => 'jpg,png,gif',
                'images_in_comments' => true,
            ],
            'seo' => [
                'meta_title' => 'Forum-blog - Community and News',
                'meta_description' => 'Join our community forum and read the latest news',
                'meta_keywords' => 'forum, blog, community, news',
                'robots_txt' => 'User-agent: *\nAllow: /',
                'sitemap_enabled' => true,
            ],
            'security' => [
                'login_attempts_limit' => 5,
                'lockout_time' => 15,
                'captcha_enabled' => false,
                'min_password_length' => 8,
            ],
            'backup' => [
                'auto_backup' => false,
                'backup_time' => '03:00',
                'backup_storage' => 'local',
            ],
            'theme' => [
                'theme' => 'light',
                'custom_css' => '',
                'mobile_logo' => 'assets/img/logo_mobile.png',
                'animations_enabled' => true,
            ]
        ];
    }
    
    // Get one section
    public function getSection($section) {
        $settings = $this->getSettings();
        return $settings[$section] ?? [];
    }
    
    // Save section (overwrite all values)
    public function saveSettings($settings) {
        // In a real application, you would save to database or file
        // For now, we'll just return true
        return true;
    }
}