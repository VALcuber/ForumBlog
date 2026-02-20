<?php

class Description_HelpController extends Controller{

    private $pageTpl = '/templates/description.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new Description_HelpModel();
        $this->view = new View();
    }

    public function index(){

        $this->controller();

        $this->pageData['description'] = $this->model->choose_description();;

        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function help(){
        $this->controller();

        $this->pageData['description'] = $this->model->choose_help();;

        $this->view->render($this->pageTpl, $this->pageData);
    }
}