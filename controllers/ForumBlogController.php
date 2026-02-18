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
        if (($env['act'] ?? '') === 'Post') {
            $this->model->add_blog_content();
        }

        // Prepare raw data for the view
        $route1 = $env['route1'] ?? '';
        $this->pageData['category_name'] = ucfirst($route1);
        $this->pageData['route_upper'] = strtoupper($env['route'] ?? '');
        $this->pageData['current_route'] = $env['route'] ?? '';

        // Get topics and process translit for links
        $topics = $this->model->get_ForumBlog_topic($route1);
        foreach ($topics as &$topic) {
            $topic['translit'] = $this->translit($topic['Description'] ?? '');
        }
        $this->pageData['topics_list'] = $topics;

        // Get latest posts and process translit
        $latest = $this->model->latest_ForumBlog_posts();
        if (!empty($latest)) {
            foreach ($latest as &$post) {
                $post['translit'] = $this->translit($post['Category'] ?? '');
            }
        }
        $this->pageData['latest_posts_list'] = $latest ?? [];

        $this->view->render($this->pageTpl, $this->pageData);
    }
}