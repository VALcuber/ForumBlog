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
        $content = $this->forumblog_content($blog_page, $forum_page);

        if (isset($_POST['blog_page'])) {
            if (ob_get_level()) ob_clean();
            header('Content-Type: application/json');
            echo json_encode($content);
            exit;
        }
    }

    private function forumblog_content($blog_page, $forum_page) {
        global $env;
        $per_page = $env['settings_array']['posts_per_page'] ?? 10;
        $subcategory_limit = 4;

        $all_topics = $this->model->get_ForumBlog_topic($env['route1']);

        $blogs_all = array_filter($all_topics, function($t) { return $t['structure'] === 'blog'; });
        $forums_all = array_filter($all_topics, function($t) { return $t['structure'] === 'forum'; });

        $blogs_grouped = $this->group_topics_by_subcategory($blogs_all);
        $forums_grouped = $this->group_topics_by_subcategory($forums_all);

        // Calculate offsets separately
        $blog_offset = ($blog_page - 1) * $per_page;
        $forum_offset = ($forum_page - 1) * $per_page;

        // Show only the latest subcategories in each category block
        $blogs_grouped = array_slice($blogs_grouped, 0, $subcategory_limit);
        $forums_grouped = array_slice($forums_grouped, 0, $subcategory_limit);

        return [
            'blog' => [
                'items' => array_values(array_slice($blogs_grouped, $blog_offset, $per_page)),
                'pagination' => [
                    'total' => ceil(count($blogs_grouped) / $per_page),
                    'current' => $blog_page
                ]
            ],
            'forum' => [
                'items' => array_values(array_slice($forums_grouped, $forum_offset, $per_page)),
                'pagination' => [
                    'total' => ceil(count($forums_grouped) / $per_page),
                    'current' => $forum_page
                ]
            ]
        ];
    }


    private function group_topics_by_subcategory(array $topics): array {
        $grouped = [];

        foreach ($topics as $topic) {
            $subcategory = $topic['Subcategory'] ?? '';
            if ($subcategory === '') {
                continue;
            }

            if (!isset($grouped[$subcategory])) {
                $grouped[$subcategory] = [
                    'structure' => $topic['structure'],
                    'Category' => $topic['Category'],
                    'Subcategory' => $subcategory,
                    'category_link' => '/' . $topic['structure'] . '/' . $this->translit($subcategory),
                    'posts' => []
                ];
            }

            $description = trim((string)($topic['Description'] ?? ''));
            if ($description === '') {
                continue;
            }

            $grouped[$subcategory]['posts'][] = [
                'title' => $description,
                'link' => '/' . $topic['structure'] . '/' . $topic['Category'] . '/' . $this->translit($description)
            ];
        }

        return array_values($grouped);
    }
}