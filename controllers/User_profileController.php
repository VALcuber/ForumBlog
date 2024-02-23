<?php

class User_profileController extends Controller {

	private $pageTpl = '/templates/user_profile.tpl';

	public function __construct() {
		$this->model = new User_profileModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();

		$this->view->render($this->pageTpl, $this->pageData);
	}

}