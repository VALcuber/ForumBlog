<?php

class IndexController extends Controller {

	private $pageTpl = '/templates/index.tpl';

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
        $this->pageData['blog'] = $this->echo_random_blog_topics();
        $this->pageData['news'] = $this->echo_latest_news();
        $this->pageData['forum'] = $this->echo_random_forum_topics();

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function echo_random_blog_topics() { //Ф-я для вывода блога
        $resultHTML = '';
		$blog = $this->model->blog();

		$blog_count = count($blog);

		if($blog != NULL) {
		    if($blog_count != 1)
                $resultblog = $this->make_Random_Array_blog($blog_count, $blog);
            else
                $resultblog = $blog;
		    $arrSize = count($resultblog);

        }
        else {
            $resultblog = '';
        }

        for($i = 0; $i < $arrSize; $i++){

                 $blogName = $resultblog[$i]["Topic"];
                 $blogContent = $resultblog[$i]["blog_content"];

                 $htmlblog = <<<"EOT"
		        	  <div class="d-flex justify-content-between align-items-center flex-grow-1">
				        <h5 class="card-title">$blogName</h5>
				        <a href="/blog/$blogName" class="card-link">Go to category</a>
			          </div>
			          <p class="card-text flex-grow-1">$blogContent</p>
EOT;
                 $resultHTML = $resultHTML . $htmlblog;

		 }
		  
		  return $resultHTML;
	}
	
	public function make_Random_Array_blog($amount, $array){
        //$amount = $amount -1;
			$randomArrayblog = array();
			$randKeys = array_rand($array, $amount);

			for($i = 0; $i < $amount; $i++){
				array_push($randomArrayblog,$array[$randKeys[$i]]);
			}

			return $randomArrayblog;
	} //Функция для случайного отображения елементов в массиве
	
	public function echo_latest_news() { //Ф-я для вывода новостей

	    $resulthtmlnews = "";
		$news = $this->model->news();

		$count = count($news);

			for($i = 0; $i < $count; $i++){

                if($i >= 7){
                    break;
                }
                else {
                    $newsName = $news[$i]["name"];
                    $newsContent = $news[$i]["content"];

                    $reversearray = $this->translit($newsName);
                    if ($news != NULL) {

                        $htmlnews = <<<"EOT"
                    <div class="d-flex justify-content-between align-items-center flex-grow-1">
                      <h5 class="card-title">$newsName</h5>
                      <a href="/news/$reversearray" class="card-link">Go to news</a>
                    </div>
                    <p class="card-text flex-grow-1">$newsContent</p>
EOT;
                    }
                    else {
                        $htmlnews = '';
                    }
                    $resulthtmlnews = $resulthtmlnews . $htmlnews;
                }

			}

		return $resulthtmlnews;
	}

	public function echo_random_forum_topics() { //Ф-я для вывода форума

	    $forum = $this->model->forum();

	    $forum_count = count($forum);
        $resulthtmlforum = '';

		if($forum != NULL) {
            $resultforum = $this->make_Random_Array_forum($forum_count, $forum);

            $arrSize = count($resultforum);
        }
		else
            $resultforum = '';

		for($i = 0; $i < $arrSize; $i++){
		    if($i >= 7){
		        break;
		    }
            else {
                $forumName = $resultforum[$i]["Topic"];

                $forumContent = $resultforum[$i]["Title"];

                $htmlforum = <<<"EOT"
			  <div class="d-flex justify-content-between align-items-center flex-grow-1">
				<h5 class="card-title">$forumName</h5>
				<a href="/forum/$forumName/$forumContent" class="card-link">Go to post</a>
			  </div>
			  <p class="card-text flex-grow-1">$forumContent</p>
EOT;
                $resulthtmlforum = $resulthtmlforum . $htmlforum;
            }
		}
			return $resulthtmlforum;
	}
	
	public function make_Random_Array_forum($amount, $array){
        $amount = $amount -1;
		  $randomArrayforum = array();
		  $randKeys = array_rand($array,$amount);


		  for($i = 0; $i < count($randKeys); $i++){

			  array_push($randomArrayforum,$array[$randKeys[$i]]);
		  }

		  return $randomArrayforum;
	} //Функция для случайного отображения елементов в массиве 
}