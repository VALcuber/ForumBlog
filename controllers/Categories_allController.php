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

        // This method now populates $this->pageData['page_all_titles']
        $this->echo_pagealltitles();

        $this->pageData['script_page_all'] = '<script src="../assets/js/page_all.js"></script>';
        $this->view->render($this->pageTpl, $this->pageData);
    }

    private function echo_pagealltitles() {
        // 1. Get current page from POST (for AJAX) or default to 1
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        if ($page < 1) $page = 1;

        // 2. Generate HTML content
        $content = $this->get_paged_content($page);

        // 3. AJAX check: JavaScript needs a direct 'echo' to see the result
        if (isset($_POST['page'])) {
            // Check if there is an active output buffer to clean
            if (ob_get_level()) {
                ob_clean();
            }
            // You MUST echo here because JavaScript's fetch() reads the output buffer
            echo $content;
            exit;
        }

        // 4. Initial load: Fill the pageData for the standard template render
        return $this->pageData['page_all_titles'] = $content;
    }

    /**
     * Internal logic to fetch data and build the HTML string
     */
    /**
     * Helper function to generate HTML content with exactly 10 valid items per page
     */
    private function get_paged_content($page) {
        global $env;

        $items_per_page =  $env['settings_array']['posts_per_page']; //Number of categories on page
        $some_result_all = "";

        // 1. Get ALL categories from the model
        $all_titles = $this->model->get_all_categories();

        // 2. FILTER: Keep only those that have subcategories
        // This ensures we only count and display categories with content
        $valid_categories = [];
        foreach ($all_titles as $cat) {
            $subs = $this->model->get_all_subcategories($cat['Category']);
            if (count($subs) > 0) {
                // Store subcategories inside the object to avoid calling the model again later
                $cat['subs_data'] = $subs;
                $valid_categories[] = $cat;
            }
        }

        // 3. Now calculate totals based on VALID categories only
        $total_items = count($valid_categories);
        $total_pages = ceil($total_items / $items_per_page);

        // 4. Slice the FILTERED array to get exactly 10 items for the current page
        $offset = ($page - 1) * $items_per_page;
        $paged_titles = array_slice($valid_categories, $offset, $items_per_page);

        // 5. Generate HTML
        foreach ($paged_titles as $value) {
            $category_from_bd = $value['Category'];
            $alltitles2 = $value['subs_data']; // Use the data we already fetched

            $env['all_title'] = $category_from_bd;
            $category_low = lcfirst($category_from_bd);
            $some_result_descriptions_all = "";

            $category_html = <<<"EOT"
        <div class="row px-4 py-2">
            <div class="col-8 px-0">
                <a href="/$category_low" class="py-2" style="font-size: 2.2em; font-weight: bold;">$category_from_bd</a>
            </div>
            <div class="col-4">
                <ul class="nav align-items-center justify-content-center">
                    <li class="nav-item">
                        <button type="button" class="btn-add rounded-circle bg-secondary">
                            <i class="bi bi-plus text-white"></i>
                        </button>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">FORUM</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">BLOG</a></li>
                </ul>
            </div>
        </div>
EOT;

            foreach ($alltitles2 as $value2) {
                $structure = $value2["structure"];
                $cat_name = $value2["Category"];
                $sub_name = $value2["Description"];

                $some_result_descriptions_all .= <<<"EOT"
            <li><a href="/$structure/$cat_name/$sub_name" class="py-2">$sub_name</a></li>
EOT;
            }

            $some_result_all .= $category_html;
            $some_result_all .= <<<"EOT"
        <div class="row px-4 py-2">
            <div class="col-12 px-0">
                <nav><ul class="category-list p-0">$some_result_descriptions_all</ul></nav>
            </div>
        </div>
        <hr class="mx-4">
EOT;
        }

        // Pagination Block
        if ($total_pages > 1) {
            $some_result_all .= '<div class="pagination-wrapper px-4 py-4"><nav><ul class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i == $page) ? 'btn-primary text-white' : 'btn-outline-primary';
                $some_result_all .= "
            <li class='page-item me-1'>
                <button class='btn $active_class js-ajax-page' data-page='$i'>$i</button>
            </li>";
            }
            $some_result_all .= '</ul></nav></div>';
        }

        return $some_result_all;
    }
}