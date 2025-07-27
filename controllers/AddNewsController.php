<?php
/** @used-by Router */
class AddNewsController extends Controller {

    private $pageTpl = '/templates/add_news.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new AddNewsModel();
        $this->view = new View();
    }

    public function index() {
        global $env;
        $this->controller();

        if($env['act'] == 'Post-NEWS'){
            $this->model->post_news();
            // Use PRG pattern - redirect after POST
            header("Location: /?success=news_added");
            exit; // Important to add exit after redirect
        }

        // Show success message if exists
        if(isset($_GET['success']) && $_GET['success'] == 'news_added') {
            $this->pageData['success_message'] = "News added successfully!";
        }

        $this->view->render($this->pageTpl, $this->pageData);
    }


}
