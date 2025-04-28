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
        }

        $this->view->render($this->pageTpl, $this->pageData);
    }


}
