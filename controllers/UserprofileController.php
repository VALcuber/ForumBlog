<?php

class UserprofileController extends Controller {

	private $pageTpl = '/templates/userprofile.tpl';

	public function __construct() {
		$this->model = new UserprofileModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
//        $this->pageData['slash'] = "../";

		$this->view->render($this->pageTpl, $this->pageData);
	}
	


}