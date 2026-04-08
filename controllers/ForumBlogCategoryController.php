<?php
/** @used-by Router */
class ForumBlogCategoryController extends ForumBlogController {

    private $pageTpl = '/templates/forum-blog-cat.tpl';

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
        $route2 = $env['route2'] ?? '';

        // Get latest posts and process translit
        $latest = $this->model->latest_ForumBlog_posts();

        if (!empty($latest)) {
            foreach ($latest as &$post) {
                $post['translit'] = $this->translit($post['Category'] ?? '');
            }
        }

        $this->echo_page_pagination($route2);

        $this->pageData['category_name'] = ucfirst($route2);
        $this->pageData['route_upper'] = strtoupper($env['route'] ?? '');
        $this->pageData['latest_posts_list'] = $latest ?? [];

        $this->view->render($this->pageTpl, $this->pageData);
    }
}