<?php

	class Controller{

        public $model;
		public $view;
		public $env;
		protected $pageData = array();
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

            $env['active'] = 'active';
            $this->pageData["slash"] = null;

            $this->pageData['id_login'] = $env['token'];

            if(($env['act'] == 'Log In') && ($_POST['email'] != '') && ($_POST['password'] != '')){

                $user_data = $this->model->checkUser();

                $this->pageData['id_login'] = $env['token'] = $this->LogIn($user_data['id']);

                $this->encrypting_data($user_data);

                if($env['token'] == ''){
                    header("Location: /");
                }
            } //Check login info

            $userID = $this->token_check();

            if(isset($env['token']) && $env['token'] !=''){

                if($userID == true) {
                    $users_logo = $this->logo;

                    $data_users = $this->get_decrypted_post_data();

                    $this->pageData['nickname'] = $data_users['nickname'];

                    if ($users_logo !== null) {
                        $user_logo = $users_logo;
                    }
                    else {
                        $user_logo = $this->model->check_logo($data_users['id']);
                    }

                    if ($user_logo['logo'] == 'none') {
                        $Fn = str_split($data_users['first_name']);
                        $Ln = str_split($data_users['last_name']);
                        $this->pageData['id_state'] = 'login';
                        $result_Fn_Ln_arr = $Fn['0'] . $Ln['0'];

                    }
                    else {
                        $result_Fn_Ln_arr = '<img class="toggle-btns header__profile text-center d-none d-sm-block rounded-circle" src="' . $user_logo['logo'] . '">';
                        $this->pageData['id_state'] = 'login';
                    }

                    $user_menu_winwow = 'user-menu';
                    $this->pageData['user_menu_window'] = $user_menu_winwow;

                    if ($data_users['status'] == 'admin') {
                        $adminPanel = $this->admin_panel();
                    }
                    else {
                        $adminPanel = '';
                    }
                }

            } //Check token
            else{
                $this->pageData['user_menu_window'] = '';
                $this->pageData['id_state'] = 'no_login';
                $result_Fn_Ln_arr = 'Log in';
                $adminPanel = '';
                $user_data['status'] = 'user';
                $user_data['user_id'] = '';
                $signin_modal_winwow = 'data-toggle="modal" data-target="#signinModal"';
                $this->pageData['page'] = $this->echo_form_signin();
            }

            if (isset($env['route1']) && $env['route1'] == '') {
                $active = 'active';
            } //For blue button when you are on its page
            else{
                $active = '';
            }

            if($env['act'] == 'Exit'){
                $this->deleteToken();
                header("Location: /");
            }

            if($env['act']=='Register'){
                $this->model->SingIn();
            }

            if(isset($env['route1']) && $env['route1'] != 'manage_users'){
                $this->pageData['topmenu'] = $this->echo_topmenu();
            }

            if(empty($env['route2']) && (($env['route1'] == 'blog' || $env['route1'] == 'forum') && empty($env['route3'])) || $env['route1'] == 'all' ){
                $this->pageData['script_category'] = '<script src="/assets/js/category.js"></script>';
            }  //for categories on blog and forum pages
            else{
                $this->pageData['script_category'] = '';
            }

            if($env['route1'] != 'user_profile'){
                $this->pageData['script_profile'] = '';
            }  //for script on profile page

            $this->pageData['title'] = "Forum-blog";
            /** @noinspection PhpUndefinedVariableInspection */
            $this->pageData['panel'] = $adminPanel;
            /** @noinspection PhpUndefinedVariableInspection */
            $this->pageData['check'] = $result_Fn_Ln_arr;
            $this->pageData['signin_modal_winwow'] = $signin_modal_winwow;
            $this->pageData['active'] = $active;
            $this->pageData['admin-styles'] = '';
            $this->pageData['burger'] = $this->echo_burger();

        }

        public function admin_panel(){
            /** @noinspection HtmlUnknownTarget */
            return $adminPanel = <<<"EOT"
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
        }

        public function echo_topmenu(){
            global $env;

            $result_html_category = "";

            $category = $this->model->gettopic();

            shuffle($category);

            $category = array_slice($category, 0, 12);

            if (count($category) > 0) {

                foreach ($category as $cat) {

                    $route_title = $cat['table_name'];
                    $category = $cat['Category'];

                    if (isset($env['route1'], $env['route2'], $env['route3']) && $env['route1'] == $route_title && $env['route2'] == $category) {
                        $activist = 'active';
                    }
                    else{
                        $activist = '';
                    }

                    if($route_title == 'blog'){
                        $categories = $category. '_blog';
                    }
                    else{
                        $categories = $category. '_forum';
                    }

                    $html_category = <<<"EOT"
            <li class="nav-item">
                <a href="/$route_title/$category" class="nav-link $activist categories__link text-nowrap">$categories</a>
            </li>
EOT;
                    $result_html_category .= $html_category;
                }

                if (isset($env['route1']) && $env['route1'] == 'all') {
                    $active = 'active';
                }
                else{
                    $active = '';
                }

                $buttonall = '<li class="nav-item">
                                  <a href="/all" class="nav-link ' . $active . ' categories__link text-nowrap">All</a>
                              </li>
                          </ul>

                      </nav>

                  </div>';

                return $result_html_category . $buttonall;
            }

            return '';
        }

        public function echo_burger(){
            global $env;

            $resulthtmlburger ="";

            if (isset($env['route1']) && $env['route1'] == 'all') {
                $active = 'active';
            }
            else{
                $active = '';
            }

            $buttonall = '<li class="navbar-item p-2">
                    <a href="/all" class="nav-link categories__link '.$active.' text-nowrap">All</a>
                </li>';

            $category_from_bd = $this->model->getburger();

            $arrSize = count($category_from_bd);

            for($i = 0; $i < $arrSize; $i++){

                $category = $category_from_bd[$i]['Category'];
                $structure = $category_from_bd[$i]['structure'];

                if(isset($env['route2'])) {
                    if(isset($env['route1']) && $env['route1'] == $structure && $env['route2'] == $category) {
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
                    $categories = $category. '_blog';
                }
                else{
                    $categories = $category. '_forum';
                }

                $htmlburger = <<<"EOT"
				<li class= "navbar-item p-2">
				    <a href="/$structure/$category" class="nav-link $activist categories__link text-nowrap">$categories</a>
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

            /** @noinspection PhpDuplicateArrayKeysInspection */
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

            return $form_signin = <<<"EOT"
          <h1>This is user page</h1>
          <div class="d-flex justify-content-between">
          <form method="post">

            <button type="button" class="btn btn-secondary">Registration</button>

            <input type="submit" class="btn btn-primary" name="act" value="Login"/>
          </form>

          </div>
EOT;
        }

        public function LogIn($login){

            try {
                // Generate a secure random token and convert it to hexadecimal format
                $token = bin2hex(random_bytes(32));
            }
            catch (Exception $e) {
                // Handle the error if random_bytes() fails
                echo "Token generation error: " . $e->getMessage();
                // Set token to an empty string (or you can return false/null depending on logic)
                $token = '';
            }

            $tokenFile = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/tokens.json';

            $tokens = [];

            if (file_exists($tokenFile)) {
                $tokens = json_decode(file_get_contents($tokenFile), true);
            }

            // Удалим все старые токены для этого user_id
            foreach ($tokens as $tk => $info) {
                if ($info == $login) {
                    unset($tokens[$tk]);
                }
            }

            $tokens[$token] = $login;
            file_put_contents($tokenFile, json_encode($tokens, JSON_PRETTY_PRINT));

            return $token;
        } // Create and bind token to user

        public function load_tokens() {
            $tokens_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/tokens.json';  // token file

            if (!file_exists($tokens_file)) {
                return [];
            }

            $json = file_get_contents($tokens_file);
            return json_decode($json, true) ?? [];
        } //Read token from file

        public function token_check(){
            global $env;
            $tokens_data = key($this->load_tokens());

            if (isset($tokens_data)) {
                $env['token'] = $tokens_data;
                return $tokens_data;
            }

            return false;

        } //Check tokens

        public function deleteToken() {
            global $env;

            $file = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/tokens.json';  // token file


            // Check file
            if (file_exists($file)) {
                // Read file
                $file_contents = file_get_contents($file);

                // Decode JSON in array
                $tokens_data = json_decode($file_contents, true);

                // Check decode file
                if ($tokens_data === null) {
                    echo "Error reading data from file.";
                    die;
                }

                // Token which we want to delete
                $token_to_delete = key($tokens_data); // Token value

                // Search and delete token
                if (isset($tokens_data[$token_to_delete])) {
                    unset($tokens_data[$token_to_delete]);  // Delete token by key

                    // rewrite file with updated data
                    file_put_contents($file, json_encode($tokens_data, JSON_PRETTY_PRINT));

                }
            }

        } //Delete token

        private function generate_crypto_keys(){
            $cipher = 'AES-256-CBC'; // encrypt type

            $key = hash('sha256', 'some data for key crypt');           //encrypt key
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); //Initialization vector for random encrypt

            // Save in JSON format
            $data = [
                'key' => base64_encode($key),
                'iv'  => base64_encode($iv),
            ];

            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/conf/crypto_keys.json', json_encode($data)); //Keys storage
        } //Generate keys for crypt user info

        public function encrypting_data($user_data) {

            $this->generate_crypto_keys();

            $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/conf/crypto_keys.json'), true); //keys storage

            $cipher = 'AES-256-CBC'; // encrypt type

            $key = base64_decode($data['key']);
            $iv = base64_decode($data['iv']);

            foreach ($user_data as $k => $v) {
                if (!mb_check_encoding($v, 'UTF-8')) {
                    echo "Error with key [$k]: not UTF-8<br>";
                }
            } //Check encoding type

            $json_data = json_encode($user_data, JSON_UNESCAPED_UNICODE);

            if ($json_data === false) {
                echo 'JSON error: ' . json_last_error_msg();
                return;
            } //Check on JSON errors

            $encrypted = openssl_encrypt($json_data, $cipher, $key, 0, $iv);

            if ($encrypted === false) {
                echo 'Encoding error!';
                return;
            } //Check on encoding errors

            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/conf/crypt_data.json', $encrypted); // Encrypting data storage
        } //Crypt user info using keys

        public function get_decrypted_post_data() {

            $crypto_file = $_SERVER['DOCUMENT_ROOT'] . '/conf/crypto_keys.json';

            if (!file_exists($crypto_file)) {
                echo "Файл ключей не найден";
                return null;
            }

            $data = json_decode(file_get_contents($crypto_file), true);

            $key = base64_decode($data['key']);
            $iv = base64_decode($data['iv']);

            $crypt_data_file = $_SERVER['DOCUMENT_ROOT'] . '/conf/crypt_data.json';

            if (!file_exists($crypt_data_file)) {
                echo "Файл шифра не найден";
                return null;
            }

            $encrypted_data = file_get_contents($crypt_data_file);

            $cipher = 'AES-256-CBC';

            $decrypted = openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);

            if ($decrypted === false) {
                echo 'Ошибка расшифровки!';
                return null;
            }

            $data = json_decode($decrypted, true);

            if ($data === null) {
                echo 'Ошибка JSON: ' . json_last_error_msg();
                return null;
            }

            return $data;
        }  //Decrypt user ino for future compare

	}