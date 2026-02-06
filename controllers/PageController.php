<?php
/** @used-by Router */
class PageController extends Controller {

    private $pageTpl = '/templates/page.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new PageModel();
        $this->view = new View();
    }

    public function index() {
        global $env;
        $this->controller();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $env['act'] == 'Commit') {
            echo 1;
            $this->model->add_comment();
            exit;
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
            $per_page = 5; // Comments on page numbers = 1
            // 1. Receive commets through SQL (LIMIT/OFFSET)
            $comments = $this->model->get_comments($page, $per_page);

            $total_rows = $this->model->get_comments_count();

            // 2. Count page numbers
            $total_pages = ceil($total_rows / $per_page);

            header('Content-Type: application/json');

            // 4. Send in JS "package" with keys
            echo json_encode([
                'items' => $comments,
                'total_pages' => $total_pages,
                'current_page' => $page
            ]);
            exit;
        }


        $this->prepare_page();
        $this->view->render($this->pageTpl, $this->pageData);
    }

    private function prepare_page() {
        global $env;

        $this->pageData['forum_comments'] = '<script src="/assets/js/forum.comments.js"></script>';

        $data = $this->model->get_page();

        $author = $this->model->post_author($data['user_id']);
        $this->pageData['title'] = $data['Category'] ?? $data['Description'];
        $this->pageData['content'] = $data['Description'] ?? $data['Category'];
        $this->pageData['nickname'] = $author['Nickname'] ?? 'Admin';

    }
}