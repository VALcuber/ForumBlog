<?php

class PanelController extends Controller {
	
	private $pageTpl = '/templates/panel.tpl';


	public function __construct() {
		$this->model = new PanelModel();
		$this->view = new View_Admin();
	}
	
	public function index() {
		global $env;

		if($_SESSION['status'] != 'admin'){
			header("Location: /");
		}

		if($env['act'] == 'Post'){
			$this->model->InsertNews();
			header("Location: /");
		}

		$this->view->render($this->pageTpl, $this->pageData);

	}
}
