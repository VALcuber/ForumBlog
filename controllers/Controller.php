<?php

	class Controller{

        public $model;
		public $view;
		public $env;
		protected $pageData = array();
		protected $pagesData = array();
        protected $logo;

        public function __construct() {
			$this->view = new View();
			$this->model = new Model();
		}

        public function setLogo($logo) {
            $this->logo = $logo;
        }

        public function controller(){
            global $env;
            $signin_modal_winwow = '';
            //$active = $env['active'];
            $env['active'] = 'active';
            $this->pageData["slash"] = null;

            if(($env['act'] == 'Log In') && ($_POST['email'] != '') && ($_POST['password'] != '')){

                $this->model->checkUser();

                if($_SESSION['user_id'] == ''){
                    header("Location: /");
                }

            }

            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !=''){

                $users_logo = $this->logo;

                $user_logo = $users_logo ?? $this->model->check_logo();

                if($user_logo['logo'] == 'none') {
                    $Fn = str_split($_SESSION['first-name']);
                    $Ln = str_split($_SESSION['last-name']);

                    $result_Fn_Ln_arr = $Fn['0'] . $Ln['0'];
                }
                else{
                    $result_Fn_Ln_arr = '<img class="toggle-btns header__profile text-center d-none d-sm-block rounded-circle" src="'.$user_logo['logo'].'">';
                    $this->pageData['id_state'] = 'login';
                }

                $user_menu_winwow = 'user-menu';
                $this->pageData['user_menu_window'] = $user_menu_winwow;

                if($_SESSION['status'] == 'admin'){
                    $adminPanel = $this->admin_panel();
                }

                else{
                    $adminPanel = '';
                }

            }
            else{
                $this->pageData['id_state'] = 'no_login';
                $result_Fn_Ln_arr = 'Log in';
                $adminPanel = '';
                $_SESSION['status'] = 'user';
                $_SESSION['user_id'] = '';
                $signin_modal_winwow = 'data-toggle="modal" data-target="#signinModal"';
                $this->pageData['page'] = $this->echo_form_signin();
            }

            if (isset($env['route1']) && $env['route1'] == '') {
                $active = 'active';
            }
            else{
                $active = '';
            }

            if($env['act'] == 'Exit'){
                session_destroy();
                // Delete cookie session
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }
                header("Location: /");
            }

            if($env['act']=='Register'){
                $this->model->SingIn();
            }

            if(isset($env['route1']) && $env['route1'] != 'manage_users'){
                $this->pageData['topmenu'] = $this->echo_topmenu();
            }

            if(empty($env['route2']) && (($env['route1'] == 'blog' || $env['route1'] == 'forum') && empty($env['route3'])) || $env['route1'] == 'all' ){
                $this->pageData['script_category'] = '<script src="/assets/js/category.js"></script>'; //for categories on blog and forum pages
            }
            else{
                $this->pageData['script_category'] = '';
            }

            if($env['route1'] != 'user_profile'){
                $this->pageData['script_profile'] = ''; //for script on profile page
            }

            $this->pageData['title'] = "Forum-blog";
            $this->pageData['panel'] = $adminPanel;
            $this->pageData['check'] = $result_Fn_Ln_arr;
            $this->pageData['signin_modal_winwow'] = $signin_modal_winwow;
            $this->pageData['active'] = $active;
            $this->pageData['admin-styles'] = '';


            $this->pageData['burger'] = $this->echo_burger();

        }

        public function admin_panel(){
            $adminPanel = <<<"EOT"
                <div class="admin_navbar">
                
                  <div class="admin_dropdown">
                  
                    <button class="dropbtn"> News
                    
                      <i class="fa fa-caret-down"></i>
                      
                    </button>
                    
                    <div class="dropdown-content">
                    
                      <a href="/AddNews">Add News</a>
                      
                      <a href="#">Ссылка 2</a>
                      
                      <a href="#">Ссылка 3</a>
                      
                    </div>
                    
                  </div>
                  
                  <div class="admin_dropdown">
                  
                    <button class="dropbtn"> Blog
                    
                      <i class="fa fa-caret-down"></i>
                      
                    </button>
                    
                    <div class="dropdown-content">
                    
                      <a href="#">Create Topic</a>
                      
                      <a href="#">Ссылка 2</a>
                      
                      <a href="#">Ссылка 3</a>
                      
                    </div>
                    
                    </div>
                    
                  <div class="admin_dropdown">
                  
                    <button class="dropbtn"> Forum
                    
                      <i class="fa fa-caret-down"></i>
                      
                    </button>
                    
                    <div class="dropdown-content">
                    
                      <a href="#">Create Topic</a>
                      
                      <a href="#">Ссылка 2</a>
                      
                      <a href="#">Ссылка 3</a>
                      
                    </div>
                    
                  </div>
                  
                  <div class="admin_dropdown">
                  
                    <button class="dropbtn"> Users
                    
                      <i class="fa fa-caret-down"></i>
                      
                    </button>
                    
                    <div class="dropdown-content">
                    
                      <a href="/manage_users">Manage users</a>
                      
                      <a href="#">Ссылка 2</a>
                      
                      <a href="#">Ссылка 3</a>
                      
                    </div>
                    
                  </div> 
                  
                </div>
EOT;
            return $adminPanel;
        }

        public function echo_topmenu(){
            global $env;

            $resulthtmlcategory = "";

            $category = $this->model->gettopic();

            shuffle($category);

            $category = array_slice($category, 0, 12);

            $active = (isset($env['route1']) && $env['route1'] == '') ? 'active' : '';

            if (count($category) > 0) {
                foreach ($category as $cat) {
                    $route_title = $cat['tablename'];
                    $categories = $cat['Category'];

                    $activist = '';

                    if (isset($env['route1'], $env['route2'], $env['route3']) && $env['route1'] == $route_title && $env['route2'] == $categories) {
                        $activist = 'active';
                    }

                    $htmlcategory = <<<"EOT"
            <li class="nav-item">
                <a href="/$route_title/$categories" class="nav-link $activist categories__link text-nowrap">$categories</a>
            </li>
EOT;
                    $resulthtmlcategory .= $htmlcategory;
                }

                if (isset($env['route1']) && $env['route1'] == 'all') {
                    $active = 'active';
                }

                $buttonall = '<li class="nav-item">
                                  <a href="/all" class="nav-link ' . $active . ' categories__link text-nowrap">All</a>
                              </li>
                          </ul>

                      </nav>

                  </div>';

                return $resulthtmlcategory . $buttonall;
            }

            return '';
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

                $categories = $category[$i]['Category'];
                $structure = $category[$i]['structure'];

                if(isset($route[2])) {
                    if(isset($route[1]) && $route[1] == $structure && $route[2] == $categories) {
                        $activist = 'active';
                    }
                    else{
                        $activist = '';
                    }
                }
                else{
                    $activist = '';
                }

                if($structure == 'blog'){
                    $categories = $categories. '_blog';
                }
                else{
                    $categories = $categories. '_forum';
                }

                $htmlburger = <<<"EOT"
				<li class= "navbar-item p-2">
				    <a href="/$structure/$categories" class="nav-link $activist categories__link text-nowrap">$categories</a>
				</li>
EOT;
                $resulthtmlburger =  $resulthtmlburger.$htmlburger;
            }
            $resulthtmlburger = $resulthtmlburger.$buttonall;
            return $resulthtmlburger;
        }

        public function translit($translit) {

            $translit = strip_tags($translit); // Deleting HTML-tegs
            $translit = str_replace(array("\n", "\r"), " ", $translit); // remove carriage return
            $translit = preg_replace("/\s+/", ' ', $translit); // remove duplicate spaces
            $translit = trim($translit); // remove spaces at the beginning and end of the line
            $translit = strtr($translit, array(
                "а"=>"a",
                "б"=>"b",
                "в"=>"v",
                "г"=>"g",
                "д"=>"d",
                "е"=>"e",
                "ё"=>"yo",
                "ж"=>"j",
                "з"=>"z",
                "и"=>"i",
                "й"=>"ij",
                "к"=>"k",
                "л"=>"l",
                "м"=>"m",
                "н"=>"n",
                "о"=>"o",
                "п"=>"p",
                "р"=>"r",
                "с"=>"s",
                "т"=>"t",
                "у"=>"y",
                "ф"=>"f",
                "х"=>"h",
                "ц"=>"c",
                "ч"=>"ch",
                "ш"=>"sh",
                "щ"=>"shch",
                "ы"=>"jj",
                "э"=>"e",
                "ю"=>"u",
                "я"=>"ya",
                "А"=>"A",
                "Б"=>"B",
                "В"=>"V",
                "Г"=>"G",
                "Д"=>"D",
                "Е"=>"E",
                "Ё"=>"Yo",
                "Ж"=>"J",
                "З"=>"Z",
                "И"=>"I",
                "Й"=>"I",
                "К"=>"K",
                "Л"=>"L",
                "М"=>"M",
                "Н"=>"N",
                "О"=>"O",
                "П"=>"P",
                "Р"=>"R",
                "С"=>"S",
                "Т"=>"T",
                "У"=>"Y",
                "Ф"=>"F",
                "Х"=>"H",
                "Ц"=>"C",
                "Ч"=>"Ch",
                "Ш"=>"Sh",
                "Щ"=>"Shch",
                "Ы"=>"JJ",
                "Э"=>"E",
                "Ю"=>"U",
                "Я"=>"Ya",
                "ь"=>"'",
                "Ь"=>"''",
                "ъ"=>"`",
                "Ъ"=>"~",
                "ї"=>"j",
                "і"=>"i",
                "ґ"=>"g",
                "є"=>"ye",
                "Ї"=>"J",
                "І"=>"I",
                "Ґ"=>"G",
                "Є"=>"YE"
            ));
            //$translit = preg_replace("/[^0-9a-z-_ ]/i", "", $translit); // clear the string of invalid characters
            $translit = str_replace(" ", "-", $translit); // replace spaces with a minus sign

            return $translit; // return the result
        }

        public function translit_reverse($translit_reverse) {

            $translit_reverse = strtr($translit_reverse, array(
                "a"=>"а",
                "b"=>"б",
                "v"=>"в",
                "g"=>"г",
                "d"=>"д",
                "e"=>"е",
                "yo"=>"ё",
                "j"=>"ж",
                "z"=>"з",
                "i"=>"и",
                "ij"=>"й",
                "k"=>"к",
                "l"=>"л",
                "m"=>"м",
                "n"=>"н",
                "o"=>"о",
                "p"=>"п",
                "r"=>"р",
                "s"=>"с",
                "t"=>"т",
                "y"=>"у",
                "f"=>"ф",
                "h"=>"х",
                "c"=>"ц",
                "ch"=>"ч",
                "sh"=>"ш",
                "shch"=>"щ",
                "jj"=>"ы",
                "e"=>"е",
                "u"=>"у",
                "ya"=>"я",
                "A"=>"А",
                "B"=>"Б",
                "V"=>"В",
                "G"=>"Г",
                "D"=>"Д",
                "E"=>"Е",
                "Yo"=>"Ё",
                "J"=>"Ж",
                "Z"=>"З",
                "I"=>"И",
                "I"=>"Й",
                "K"=>"К",
                "L"=>"Л",
                "M"=>"М",
                "N"=>"Н",
                "O"=>"О",
                "P"=>"П",
                "R"=>"Р",
                "S"=>"С",
                "T"=>"Т",
                "Y"=>"Ю",
                "F"=>"Ф",
                "H"=>"Х",
                "C"=>"Ц",
                "Ch"=>"Ч",
                "Sh"=>"Ш",
                "Shch"=>"Щ",
                "JJ"=>"Ы",
                "E"=>"Е",
                "U"=>"У",
                "Ya"=>"Я",
                "'"=>"ь",
                "''"=>"Ь",
                "`"=>"ъ",
                "~"=>"Ъ",
                "j"=>"ї",
                "i"=>"и",
                "g"=>"ґ",
                "ye"=>"є",
                "J"=>"Ї",
                "I"=>"І",
                "G"=>"Ґ",
                "YE"=>"Є"
            ));
            $translit_reverse = str_replace("-", " ", $translit_reverse); // replace minus signs with spaces

            return $translit_reverse; // return the result
        }

        public function echo_form_signin(){

            $form_signin = <<<"EOT"
          <h1>This is user page</h1>
          <div class="d-flex justify-content-between">
          <form method="post">

            <button type="button" class="btn btn-secondary">Registration</button>

            <input type="submit" class="btn btn-primary" name="act" value="Login"/>
          </form>

          </div>
EOT;

            return $form_signin;
        }

	}