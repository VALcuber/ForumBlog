<?php

class IndexController extends Controller {

	private $pageTpl = '/templates/index.tpl';

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
        $this->pageData['blog'] = $this->echo_blog();
        $this->pageData['news'] = $this->echo_news();
        $this->pageData['forum'] = $this->echo_forum();
        $this->pageData['slash'] = "";

		$this->view->render($this->pageTpl, $this->pageData);

	}

	public function echo_blog() { //Ф-я для вывода блога
		
		$resultHTML = "";  
		$blog = $this->model->blog();

		if($blog != NULL) {
            $resultblog = $this->makeRandomArrayblog(5, $blog);

		  $arrSize = count($resultblog);
        }
        else
            $resultblog = '';

		  for($i = 0; $i < $arrSize; $i++){

              if($i >= 7){
                  break;
              }
              else {

                  $blogName = $resultblog[$i]["name"];
                  $blogContent = $resultblog[$i]["blog_content"];

                  $htmlblog = <<<"EOT"
			  <div class="d-flex justify-content-between align-items-center flex-grow-1">
				<h5 class="card-title">$blogName</h5>
				<a href="/blog/$blogName"" class="card-link">Go to category</a>
			  </div>
			  <p class="card-text flex-grow-1">$blogContent</p>
EOT;
                  $resultHTML = $resultHTML . $htmlblog;
              }
		  }
		  
		  return $resultHTML;
	}
	
	public function makeRandomArrayblog($amount,$array){

			$randomArrayblog = array();
			$randKeys = array_rand($array,$amount);

			for($i = 0; $i < count($randKeys); $i++){
				array_push($randomArrayblog,$array[$randKeys[$i]]);
			}

			return $randomArrayblog;
	}
	
	public function echo_news() { //Ф-я для вывода новостей

	    $resulthtmlnews = "";
		$news = $this->model->news();

		$count = count($news);

		$reversearray0 = array_reverse($news);

			for($i = 0; $i < $count; $i++){

                if($i >= 7){
                    break;
                }
                else {
                    $newsName = $reversearray0[$i]["name"];
                    $newsContent = $reversearray0[$i]["content"];

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

	public function echo_forum() { //Ф-я для вывода блога

	    $resulthtmlforum = "";

	    $forum = $this->model->forum();

		if($forum != NULL) {
            $resultforum = $this->makeRandomArrayforum(5, $forum);

            $arrSize = count($resultforum);
        }
		else
            $resultforum = '';

		  for($i = 0; $i < $arrSize; $i++){

              if($i >= 7){
                  break;
              }
              else {
                  $forumName = $resultforum[$i]["name"];
                  $forumContent = $resultforum[$i]["forum_content"];

                  $htmlforum = <<<"EOT"
			  <div class="d-flex justify-content-between align-items-center flex-grow-1">
				<h5 class="card-title">$forumName</h5>
				<a href="/forum/$forumName" class="card-link">Go to category</a>
			  </div>
			  <p class="card-text flex-grow-1">$forumContent</p>
EOT;

                  $resulthtmlforum = $resulthtmlforum . $htmlforum;
              }
		  }
			return $resulthtmlforum;
	}
	
	public function makeRandomArrayforum($amount,$array){

		  $randomArrayforum = array();
		  $randKeys = array_rand($array,$amount);

		  for($i = 0; $i < count($randKeys); $i++){
			  array_push($randomArrayforum,$array[$randKeys[$i]]);
		  }

		  return $randomArrayforum;
	}
}