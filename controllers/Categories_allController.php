<?php
/** @used-by Router */
class Categories_allController extends Controller {

    private $pageTpl = '/templates/all.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new Categories_allModel();
        $this->view = new View();
    }

    public function index() {
        $this->controller();

        $this->echo_page_pagination();

        $this->view->render($this->pageTpl, $this->pageData);
    }

    private function echo_page_pagination() {
        //Pagination
        // 1. Get current page from POST (for AJAX) or default to 1
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        if ($page < 1)
            $page = 1;

        // 2. Generate HTML content
        $content = $this->get_paged_content($page);

        // 3. Prepare data for the view
        $this->pageData['categories_list'] = $content['items'];
        $this->pageData['pagination'] = $content['pagination'];

        // 4. AJAX check: JavaScript needs a direct 'echo' to see the result
        if (isset($_POST['page'])) {
            // Check if there is an active output buffer to clean
            if (ob_get_level()) {
                ob_clean();
            }
            $this->view->render($this->pageTpl, $this->pageData);
            exit;
        }
    }

    private function get_paged_content($page) {
        global $env;

        $items_per_page =  $env['settings_array']['posts_per_page']; //Number of categories on page

        // 1. Get ALL categories from the model
        $all_titles = $this->model->get_all_categories();

        // 2. FILTER: Keep only those that have subcategories
        // This ensures we only count and display categories with content
        $valid_categories = [];
        foreach ($all_titles as $cat) {
            $cat_key = $cat['Category']; // Use category name as a unique key
            // Skip if we already processed this category to avoid duplicates
            if (isset($valid_categories[$cat_key])) {
                continue;
            }
            $subs = $this->model->get_all_subcategories($cat['Category']);
            if (count($subs) > 0) {
                // Store subcategories inside the object to avoid calling the model again later
                $cat['subs_data'] = $subs;
                $cat['category_link'] = $cat['Category'];
                $cat['category_structure'] = $cat['structure'];
                $valid_categories[$cat_key] = $cat;
            }
        }

        // Reset array keys to sequential numbers (0, 1, 2...) for array_slice to work properly
        $valid_categories = array_values($valid_categories);

        // 3. Now calculate totals based on VALID categories only
        $total_items = count($valid_categories);
        $total_pages = $items_per_page > 0 ? ceil($total_items / $items_per_page) : 1;

        // 4. Slice the FILTERED array to get exactly 10 items for the current page
        $offset = ($page - 1) * $items_per_page;

        return [
            'items' => array_slice($valid_categories, $offset, $items_per_page),
            'pagination' => [
                'total' => $total_pages,
                'current' => $page
            ]
        ];

    }
}