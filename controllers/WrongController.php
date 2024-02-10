<?php

class WrongController extends Controller {
	
	private $pageTpl = '/templates/wrong.tpl';


	public function __construct() {
		$this->model = new WrongModel();
		$this->view = new View_Admin();
	}
	
	public function wrong() {
		global $env;
		
		if(($env['act'] == 'Login') && ($_POST['email'] != '')&&($_POST['password'] != '')){
			$this->model->checkUser();
			
			if($_SESSION['user_id'] != '0'){
				header("Location: /");
			}
			else{
				$this->pageData['wrong'] = 'is-invalid';
			}
		}
		
		else{
			$this->pageData['wrong'] = 'is-invalid';
		}

		$this->view->render($this->pageTpl, $this->pageData);

	}
}
