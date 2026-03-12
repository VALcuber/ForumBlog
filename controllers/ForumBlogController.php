<?php
/** @used-by Router */
class ForumBlogController extends Controller {

    private $pageTpl = '/templates/forum-blog.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new ForumBlogModel();
        $this->view = new View();
    }

    public function index() {
        global $env;

        $this->controller();

        // Handle post request
        if ($env['act']  === 'Post') {
            $this->model->add_ForumBlog_content($_POST['target'] ?? '');
        }

        // Prepare raw data for the view
        $route1 = $env['route1'] ?? '';


        // Get latest posts and process translit
        $latest = $this->model->latest_ForumBlog_posts();

        if (!empty($latest)) {
            foreach ($latest as &$post) {
                $post['translit'] = $this->translit($post['Category'] ?? '');
            }
        }

        // Add this in your index() method before $this->view->render(...)
        $this->pageData['blog_categories'] = $this->model->get_all_categories('blog');
        $this->pageData['forum_categories'] = $this->model->get_all_categories('forum');

        $this->echo_page_pagination();

        $this->pageData['category_name'] = ucfirst($route1);
        $this->pageData['route_upper'] = strtoupper($env['route'] ?? '');
        $this->pageData['current_route'] = $env['route'] ?? '';
        $this->pageData['latest_posts_list'] = $latest ?? [];

        $this->view->render($this->pageTpl, $this->pageData);
    }

    private function echo_page_pagination() {
        global $env;

        // Get separate pages for each block
        $blog_page = isset($_POST['blog_page']) ? (int)$_POST['blog_page'] : 1;
        $forum_page = isset($_POST['forum_page']) ? (int)$_POST['forum_page'] : 1;

        // Pass both pages to the content collector
        $content = $this->forum_content($blog_page, $forum_page);

        if (isset($_POST['blog_page'])) {
            if (ob_get_level()) ob_clean();
            header('Content-Type: application/json');
            echo json_encode($content);
            exit;
        }
    }

    private function forum_content($blog_page, $forum_page) {
        global $env;
        $per_page = $env['settings_array']['posts_per_page'] ?? 10;

        $all_topics = $this->model->get_ForumBlog_topic($env['route1']);

        foreach ($all_topics as &$topic) {
            $topic['translit'] = $this->translit($topic['Description'] ?? '');
        }

        $blogs_all = array_filter($all_topics, function($t) { return $t['structure'] === 'blog'; });
        $forums_all = array_filter($all_topics, function($t) { return $t['structure'] === 'forum'; });

        // Calculate offsets separately
        $blog_offset = ($blog_page - 1) * $per_page;
        $forum_offset = ($forum_page - 1) * $per_page;

        return [
            'blog' => [
                'items' => array_values(array_slice($blogs_all, $blog_offset, $per_page)),
                'pagination' => [
                    'total' => ceil(count($blogs_all) / $per_page),
                    'current' => $blog_page
                ]
            ],
            'forum' => [
                'items' => array_values(array_slice($forums_all, $forum_offset, $per_page)),
                'pagination' => [
                    'total' => ceil(count($forums_all) / $per_page),
                    'current' => $forum_page
                ]
            ]
        ];
    }
}