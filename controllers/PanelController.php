<?php

class PanelController extends Controller {

	private $pageTpl = '/templates/admin-panel.tpl';


	public function __construct() {
		$this->model = new PanelModel();
		$this->view = new View_Admin();
	}
	
	public function index() {
		global $env;

		if($_SESSION['status'] != 'admin'){
			header("Location: /");
		}

		if($env['act'] == 'Post-NEWS'){
			$this->model->InsertNews();
			header("Location: /");
		}

        $this->controller();
        $this->pageData['users'] = $this->echo_users();

		$this->view->render($this->pageTpl, $this->pageData);

	}

    public function echo_users() { //Ф-я для вывода блога

        $resultHTML = "";
        $users = $this->model->GetUsers();
        
        $arrSize = count($users);

        for($i = 0; $i < $arrSize; $i++){
            $usersFirstName=$users[$i]["First name"];
            $usersLastName=$users[$i]["Last name"];
            $usersstatus=$users[$i]["status"];

            $htmlusers = <<<"EOT"
			  <tr>
               <td class="card-title">$usersFirstName</td>
               <td class="card-title">$usersLastName</td>
               <td class="card-title">$usersstatus</td>
              </tr>
EOT;
            $resultHTML = $resultHTML.$htmlusers;
        }

        return $resultHTML;
    }
}

