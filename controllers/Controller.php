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

            if($env['act'] == 'Admin Panel'){
                header("Location: /panel");
            }

            $env['active'] = 'active';
            $active = $env['active'];

            if(($env['act'] == 'Login') && ($_POST['email'] != '') && ($_POST['password'] != '')){
                $resultchkuser = $this->model->checkUser();
                if($resultchkuser['user_id'] == ''){
                    header("Location: /wrong");
                }
            }
            elseif(($env['act'] == 'Login') && ($_POST['email']=='') && ($_POST['password']=='')){
                header("Location: /wrong");
            }

            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !=''){

                $Fn = str_split($_SESSION['first-name']);
                $Ln = str_split($_SESSION['last-name']);

                $result_Fn_Ln_arr = $Fn['0'].$Ln['0'];

                if($_SESSION['status'] == 'admin'){
                    $adminPanel =
                        '<form method="post">
							<input type="submit" name="act" class="btn btn-primary btn-lg" value="Admin Panel">
						</form>';
                }

                else{
                    $adminPanel = '';
                }

            }
            else{
                $result_Fn_Ln_arr = 'No';
                $adminPanel = '';
                $_SESSION['status'] = 'user';
                $_SESSION['user_id'] = '';
            }

            if($env['act'] == 'Exit'){
                $_SESSION['status'] = 'user';
                $_SESSION['user_id'] = '';
                header("Refresh:0");
            }

            if($env['act']=='Register'){
                $this->model->SingIn();
            }

            $this->pageData['title'] = "Forum-blog";
            $this->pageData['panel'] = $adminPanel;
            $this->pageData['check'] = $result_Fn_Ln_arr;
            $this->pageData['active'] = $active;
            $this->pageData['topmenu'] = $this->echo_topmenu();
            $this->pageData['burger'] = $this->echo_burger();

        }

        public function echo_topmenu(){
            global $env;

            $resulthtmlcategory ="";

            $category = $this->model->gettopic();

            $arrSize = count($category);

            for($i = 0; $i < $arrSize; $i++){

                $categories = $category[$i]['name'];
                $structure = $category[$i]['structure'];
                $Name = $category[$i]['name'];

                $activist = '';
                $active = $activist;

                if(isset($env['route2'])) {

                    if(isset($env['route1']) && $env['route1'] == $structure && $env['route2'] == $Name) {
                        $activist = 'active';
                    }

                }
                else{
                    if (isset($env['route1']) && $env['route1'] == 'all') {
                        $active = 'active';
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

            $category = $this->model->getburger();

            $arrSize = count($category);

            for($i = 0; $i < $arrSize; $i++){

                $route = explode("/", $_SERVER['REQUEST_URI']);

                $categories = $category[$i]['name'];
                $structure = $category[$i]['structure'];
                $Name = $category[$i]['name'];

                if(isset($route[2])) {
                    if(isset($route[1]) && $route[1] == $structure && $route[2] == $Name) {
                        $activist = 'active';
                    }
                    else{
                        $activist = '';
                    }
                }
                else{
                    $activist = '';
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

        public function translit($translit) {

            $translit = strip_tags($translit); // ?????????????? HTML-????????
            $translit = str_replace(array("\n", "\r"), " ", $translit); // ?????????????? ?????????????? ??????????????
            $translit = preg_replace("/\s+/", ' ', $translit); // ?????????????? ?????????????????????? ??????????????
            $translit = trim($translit); // ?????????????? ?????????????? ?? ???????????? ?? ?????????? ????????????
            $translit = strtr($translit, array(
                "??"=>"a",
                "??"=>"b",
                "??"=>"v",
                "??"=>"g",
                "??"=>"d",
                "??"=>"e",
                "??"=>"yo",
                "??"=>"j",
                "??"=>"z",
                "??"=>"i",
                "??"=>"ij",
                "??"=>"k",
                "??"=>"l",
                "??"=>"m",
                "??"=>"n",
                "??"=>"o",
                "??"=>"p",
                "??"=>"r",
                "??"=>"s",
                "??"=>"t",
                "??"=>"y",
                "??"=>"f",
                "??"=>"h",
                "??"=>"c",
                "??"=>"ch",
                "??"=>"sh",
                "??"=>"shch",
                "??"=>"jj",
                "??"=>"e",
                "??"=>"u",
                "??"=>"ya",
                "??"=>"A",
                "??"=>"B",
                "??"=>"V",
                "??"=>"G",
                "??"=>"D",
                "??"=>"E",
                "??"=>"Yo",
                "??"=>"J",
                "??"=>"Z",
                "??"=>"I",
                "??"=>"I",
                "??"=>"K",
                "??"=>"L",
                "??"=>"M",
                "??"=>"N",
                "??"=>"O",
                "??"=>"P",
                "??"=>"R",
                "??"=>"S",
                "??"=>"T",
                "??"=>"Y",
                "??"=>"F",
                "??"=>"H",
                "??"=>"C",
                "??"=>"Ch",
                "??"=>"Sh",
                "??"=>"Shch",
                "??"=>"JJ",
                "??"=>"E",
                "??"=>"U",
                "??"=>"Ya",
                "??"=>"'",
                "??"=>"''",
                "??"=>"`",
                "??"=>"~",
                "??"=>"j",
                "??"=>"i",
                "??"=>"g",
                "??"=>"ye",
                "??"=>"J",
                "??"=>"I",
                "??"=>"G",
                "??"=>"YE"
            ));
            //$translit = preg_replace("/[^0-9a-z-_ ]/i", "", $translit); // ?????????????? ???????????? ???? ???????????????????????? ????????????????
            $translit = str_replace(" ", "-", $translit); // ???????????????? ?????????????? ???????????? ??????????

            return $translit; // ???????????????????? ??????????????????
        }

        public function translit_reverse($translit_reverse) {

            $translit_reverse = strtr($translit_reverse, array(
                "a"=>"??",
                "b"=>"??",
                "v"=>"??",
                "g"=>"??",
                "d"=>"??",
                "e"=>"??",
                "yo"=>"??",
                "j"=>"??",
                "z"=>"??",
                "i"=>"??",
                "ij"=>"??",
                "k"=>"??",
                "l"=>"??",
                "m"=>"??",
                "n"=>"??",
                "o"=>"??",
                "p"=>"??",
                "r"=>"??",
                "s"=>"??",
                "t"=>"??",
                "y"=>"??",
                "f"=>"??",
                "h"=>"??",
                "c"=>"??",
                "ch"=>"??",
                "sh"=>"??",
                "shch"=>"??",
                "jj"=>"??",
                "e"=>"??",
                "u"=>"??",
                "ya"=>"??",
                "A"=>"??",
                "B"=>"??",
                "V"=>"??",
                "G"=>"??",
                "D"=>"??",
                "E"=>"??",
                "Yo"=>"??",
                "J"=>"??",
                "Z"=>"??",
                "I"=>"??",
                "I"=>"??",
                "K"=>"??",
                "L"=>"??",
                "M"=>"??",
                "N"=>"??",
                "O"=>"??",
                "P"=>"??",
                "R"=>"??",
                "S"=>"??",
                "T"=>"??",
                "Y"=>"??",
                "F"=>"??",
                "H"=>"??",
                "C"=>"??",
                "Ch"=>"??",
                "Sh"=>"??",
                "Shch"=>"??",
                "JJ"=>"??",
                "E"=>"??",
                "U"=>"??",
                "Ya"=>"??",
                "'"=>"??",
                "''"=>"??",
                "`"=>"??",
                "~"=>"??",
                "j"=>"??",
                "i"=>"??",
                "g"=>"??",
                "ye"=>"??",
                "J"=>"??",
                "I"=>"??",
                "G"=>"??",
                "YE"=>"??"
            ));
            $translit_reverse = str_replace("-", " ", $translit_reverse); // ???????????????? ?????????? ?????????? ??????????????????

            return $translit_reverse; // ???????????????????? ??????????????????
        }

	}
