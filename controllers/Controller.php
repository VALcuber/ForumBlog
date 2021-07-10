<?php

	class Controller{
		public $model;
		public $view;
		public $env;
		protected $pageData = array();

		public function __construct() {
			$this->view = new View();
			$this->model = new Model();
			$PageData1 = array();
		}

        public function controller(){
            global $env;

            if ($env['act'] == 'Admin Panel') {
                header("Location: /panel");
            }

            $env['active'] = 'active';
            $active = $env['active'];

            if (($env['act'] == 'Login') && ($_POST['email'] != '') && ($_POST['password'] != '')) {

                $result_chk_user = $this->model->checkUser();

                if ($result_chk_user['user_id'] == '') {
                    header("Location: /wrong");
                }
                else{
                    setcookie("user_id[user_id]", $result_chk_user['user_id'], time()+1600 );
                    setcookie("user_id[first-name]", $result_chk_user['first-name'], time()+1600 );
                    setcookie("user_id[last-name]", $result_chk_user['last-name'], time()+1600 );
                    setcookie("user_id[status]", $result_chk_user['status'], time()+1600 );
                    header("Refresh:0");
                }
            }
            elseif (($env['act'] == 'Login') && ($_POST['email'] == '') && ($_POST['password'] == '')) {
                header("Location: /wrong");
            }

            if (isset($_COOKIE['user_id']["user_id"]) && $_COOKIE['user_id']["user_id"] != '') {

                $Fn = str_split($_COOKIE["user_id"]['first-name']);
                $Ln = str_split($_COOKIE["user_id"]['last-name']);

                $result_Fn_Ln_arr = $Fn['0'] . $Ln['0'];

                if ($_COOKIE["user_id"]['status'] == 'admin') {
                    $adminPanel =
                        '<form method="post">
							<input type="submit" name="act" class="btn btn-primary btn-lg" value="Admin Panel">
						</form>';
                }
                else {
                    $adminPanel = '';
                }

            }
            else {
                $result_Fn_Ln_arr = 'No';
                $adminPanel = '';
            }

            if ($env['act'] == 'Exit') {
                setcookie("user_id[user_id]","",1,"/");
                setcookie("user_id[first-name]","",1,"/");
                setcookie("user_id[last-name]","",1,"/");
                setcookie("user_id[status]","",1,"/");
                header("Refresh:0");
            }

            if ($env['act'] == 'Register') {
                $this->model->SingIn();
            }

            $this->pageData['topmenu'] = $this->echo_topmenu();
            $this->pageData['title'] = "Forum-blog";
            $this->pageData['check'] = $result_Fn_Ln_arr;
            $this->pageData['panel'] = $adminPanel;
            $this->pageData['active'] = $active;
            $this->pageData['burger'] = $this->echo_burger();

        }

        public function echo_topmenu(){

            $resulthtmlcategory ="";

            $category = $this->model->gettopic();

            $arrSize = count($category);

            for($i = 0; $i < $arrSize; $i++){

                $route = explode("/", $_SERVER['REQUEST_URI']);

                $categories = $category[$i]['name'];
                $structure = $category[$i]['structure'];
                $Name = $category[$i]['name'];

                $activist = '';
                $active = $activist;

                if(isset($route[2])) {
                    if(isset($route[1]) && $route[1] == $structure && $route[2] == $Name) {
                        $activist = 'active';
                    } else {

                        if (isset($route[1]) && $route[1] == 'all') {
                            $active = 'active';
                        }
                    }
                }

                $htmlcategory = <<<"EOT"
				<li class= "nav-item">
				    <a href="/$structure/$Name" class="nav-link $activist categories__link text-nowrap">$categories</a>
				</li>
EOT;
                $resulthtmlcategory =  $resulthtmlcategory.$htmlcategory;
            }
            $buttonall = '<li class="nav-item">
                    <a href="/all" class="nav-link '.$active.' categories__link text-nowrap">All</a>
                </li>';
            $resulthtmlcategory = $resulthtmlcategory.$buttonall;
            return $resulthtmlcategory;
        }

        public function echo_burger(){

            $resulthtmlburger ="";
            $buttonall = '<li class="navbar-item p-2">
                    <a href="/all" class="nav-link categories__link text-nowrap">All</a>
                </li>';

            $activist = '';
            //$active = $activist;

            $category = $this->model->getburger();

            $arrSize = count($category);

            for($i = 0; $i < $arrSize; $i++){

                $route = explode("/", $_SERVER['REQUEST_URI']);

                $categories = $category[$i]['name'];
                $structure = $category[$i]['structure'];
                $Name = $category[$i]['name'];

                if(isset($route[2])) {
                    if (isset($route[1]) && $route[1] == $structure && $route[2] == $Name) {
                        $activist = 'active';
                    }
                }


                $htmlburger = <<<"EOT"
				<li class= "navbar-item p-2">
				    <a href="/$structure/$Name" class="nav-link $activist categories__link text-nowrap">$categories</a>
				</li>
EOT;
                $resulthtmlburger =  $resulthtmlburger.$htmlburger;
            }
            $resulthtmlburger = $resulthtmlburger.$buttonall;
            return $resulthtmlburger;
        }
	}
