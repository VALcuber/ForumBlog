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

            $translit = strip_tags($translit); // убираем HTML-теги
            $translit = str_replace(array("\n", "\r"), " ", $translit); // убираем перевод каретки
            $translit = preg_replace("/\s+/", ' ', $translit); // удаляем повторяющие пробелы
            $translit = trim($translit); // убираем пробелы в начале и конце строки
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
            //$translit = preg_replace("/[^0-9a-z-_ ]/i", "", $translit); // очищаем строку от недопустимых символов
            $translit = str_replace(" ", "-", $translit); // заменяем пробелы знаком минус

            return $translit; // возвращаем результат
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
            $translit_reverse = str_replace("-", " ", $translit_reverse); // заменяем знаки минус пробелами

            return $translit_reverse; // возвращаем результат
        }

	}
