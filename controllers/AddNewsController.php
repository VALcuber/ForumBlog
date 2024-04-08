<?php

class AddNewsController extends Controller {

    private $pageTpl = '/templates/add_news.tpl';

    public function __construct() {
        $this->model = new AddNewsModel();
        $this->view = new View();
    }

    public function index() {

        $this->controller();

        if($_POST['act'] == 'Post-NEWS'){
            $this->model->post_news();
        }

        $this->view->render($this->pageTpl, $this->pageData);
    }


}
