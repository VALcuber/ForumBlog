<?php
/** @used-by Router */
class ManageUsersController extends Controller{

    private $pageTpl = '/templates/ManageUsers.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new ManageUsersModel();
        $this->view = new View();
    }

    public function index() {
        global $env;

        $this->controller();

        if($env['act'] == 'Change user status'){
            $this->model->ChangeUserStatus();
        }

        $this->pageData['users'] = $this->echo_users();
        /** @noinspection HtmlUnknownTarget */
        $this->pageData['admin-styles'] = '<link rel="stylesheet" href="assets/css/admin.style.css">';
        $this->pageData['topmenu'] = '';

        $this->view->render($this->pageTpl, $this->pageData);

    }

    private function echo_users() {

        $resultHTML = "";
        $users = $this->model->GetUsers();

        $arrSize = count($users);

        for($i = 0; $i < $arrSize; $i++){

            $userid = $users[$i]["id"];
            $usersFirstName=$users[$i]["First name"];
            $usersLastName=$users[$i]["Last name"];
            $usersstatus=$users[$i]["status"];

            if($usersstatus == 'admin') {
                $selected1 = 'selected';
                $selected2 = '';
            }
            else {
                $selected1 = '';
                $selected2 = 'selected';
            }

            $htmlusers = <<<"EOT"
			  <form method="post" name="change_user_status">
                  <tr>
                   <td class="card-title">$userid</td>
                   <td class="card-title">$usersFirstName</td>
                   <td class="card-title">$usersLastName</td>
                   <td class="card-title">$usersstatus</td>
                   <td class="card-title">
                        <select name="userid[$userid]">
                            <option value="admin" $selected1>admin</option>
                            <option value="user" $selected2>user</option>
                        </select>                        
                   </td>
                   <td class="card-title">                   
                    <input type="submit" class="btn btn-primary" name="act" value="Change user status">
                    </td>
                  </tr>
              </form>
EOT;
            $resultHTML = $resultHTML.$htmlusers;

        }

        return $resultHTML;
    } // Function for displaying users
}