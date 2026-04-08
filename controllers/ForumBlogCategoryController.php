<?php
/** @used-by Router */
class ForumBlogCategoryController extends Controller {

    private $pageTpl = '/templates/forum-blog-cat.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new ForumBlogCategoryModel();
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

        $this->echo_cat_page_pagination($route2);

        $this->pageData['category_name'] = ucfirst($route2);
        $this->pageData['route_upper'] = strtoupper($env['route'] ?? '');
        $this->pageData['latest_posts_list'] = $latest ?? [];

        $this->view->render($this->pageTpl, $this->pageData);
    }

    protected function echo_cat_page_pagination($route2) {

        // Get separate pages for each block
        $blog_page = isset($_POST['blog_page']) ? (int)$_POST['blog_page'] : 1;
        $forum_page = isset($_POST['forum_page']) ? (int)$_POST['forum_page'] : 1;

        // Pass both pages to the content collector
        $content = $this->forumblog_cat_content($route2, $blog_page, $forum_page);

        if (isset($_POST['blog_page'])) {
            if (ob_get_level()) ob_clean();
            header('Content-Type: application/json');
            echo json_encode($content);
            exit;
        }
    }

    private function forumblog_cat_content($route2, $blog_page, $forum_page) {
        global $env;
        // Keep the pagination limit at 10 as requested
        $per_page = $env['settings_array']['posts_per_page'] ?? 10;

        $all_topics = $this->model->get_ForumBlog_cat_topic($route2);

        // Filter by structure type
        $blogs_all = array_filter($all_topics, function($t) { return $t['structure'] === 'blog'; });
        $forums_all = array_filter($all_topics, function($t) { return $t['structure'] === 'forum'; });

        // Group topics and slice for the last 4 posts inside each
        $blogs_grouped = $this->group_topics_by_subcategory($blogs_all);
        $forums_grouped = $this->group_topics_by_subcategory($forums_all);

        // Calculate pagination offsets
        $blog_offset = ($blog_page - 1) * $per_page;
        $forum_offset = ($forum_page - 1) * $per_page;

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

        // 1. First, group ALL posts by subcategory
        foreach ($topics as $topic) {
            $subcategory = $topic['Subcategory'] ?? '';
            if ($subcategory === '') continue;

            if (!isset($grouped[$subcategory])) {
                $grouped[$subcategory] = [
                    'structure' => $topic['structure'],
                    'Category' => $topic['Category'],
                    'Subcategory' => $subcategory,
                    'category_link' => '/' . $topic['structure'] . '/' . $this->translit($topic['Category']),
                    'subcategory_link' => '/' . $topic['structure'] . '/' . $this->translit($topic['Category']) . '/' . $this->translit($subcategory),
                    'posts' => []
                ];
            }

            $description = trim((string)($topic['Description'] ?? ''));
            if ($description !== '') {
                $grouped[$subcategory]['posts'][] = [
                    'title' => $description,
                    'link' => '/' . $topic['structure'] . '/' . $topic['Category'] . '/' . $topic['Subcategory'] . '/' . $this->translit($description)
                ];
            }
        }

        // 2. Now, iterate through grouped categories and keep only the LAST 4 posts
        foreach ($grouped as &$item) {
            // array_slice with -4 takes elements from the end of the array
            // This ensures we get the most recently added posts in the list
                $item['posts'] = array_reverse(array_slice($item['posts'], -4));
        }

        return array_values($grouped);
    }
}