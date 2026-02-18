<?php
/** @used-by Router */
class All_for_certain_categoryController extends Controller{

    private $pageTpl = '/templates/All_for_certain_category.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new All_for_certain_categoryModel();
        $this->view = new View();
    }

    public function index() {
        global $env;

        $this->controller();

        // Get category name from route
        $categoryName = $env['route2'] ?? 'Default Category';

        // Update global environment if needed by other components
        $env['all_title'] = $categoryName;

        // Fetch data from model
        $subcategories = $this->model->get_all_subcategories();

        // Pass data to the view
        $this->pageData['category_name'] = $categoryName;
        $this->pageData['subcategories'] = $subcategories ?: [];

        $this->view->render($this->pageTpl, $this->pageData);
    }
}