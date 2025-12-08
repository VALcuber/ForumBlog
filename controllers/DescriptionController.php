<?php

class DescriptionController extends Controller{

    private $pageTpl = '/templates/description.tpl';

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
    }

    public function index()
    {

        $this->controller();

        $this->view->render($this->pageTpl, $this->pageData);
    }
}