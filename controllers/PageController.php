<?php

class PageController extends Controller {

	private $pageTpl = '/templates/page.tpl';

	public function __construct() {
		$this->model = new PageModel();
		$this->view = new View();
	}

	public function index() {

        //$this->controller();
        $this->pageData['slash'] = "../";
        $this->pageData['forum_comments'] = '<script src="../../assets/js/forum.comments.js"></script>';
        $this->pageData['page'] = $this->echo_page();
        $this->pageData['comments'] = $this->echo_comments();

		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;

        $env['temporary'] = $env['route-2'];
/*
		if($env['route'] == 'blog'){

            $temporary = $this->translit_reverse($env['temporary'][0]);
			$smtppage = $this->model->get_page($temporary);
	
			$pageName=$smtppage["Title"];
			$pageContent=$smtppage["blog_content"];

            $html_page_blog = <<<"EOT"
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">
                        $pageName
                    </h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">
            		    $pageContent
            	    </p>
                  </div>
                </div>
EOT;
			return $html_page_blog;
		}
*/
        if($env['route'] == 'news'){

            $temporary = $this->translit_reverse($env['temporary']);

            $smtppage = $this->model->getpage($temporary);

            $pageName=$smtppage["name"];
            $pageContent=$smtppage["content"];

            $html_page_news = <<<"EOT"
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">
                        $pageName
                    </h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">
            		    $pageContent
            	    </p>
                  </div>
                </div>
EOT;
            return $html_page_news;
        }
		
		if($env['route'] == 'forum'){

			$temporary = $env['temporary'];

            //$temporary = $this->translit_reverse($temporary);

			$smtppage = $this->model->get_page($temporary);

			$pageName=$smtppage["Title"];
			$pageContent=$smtppage["Description"];

            $html_page_forum = <<<"EOT"
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">
                        $pageName
                    </h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">
            		    $pageContent
            	    </p>
                  </div>
                </div>
EOT;
			return $html_page_forum;
		}

	}

	public function echo_comments(){

        global $env;

            $resultHTML = '';

            $forumpage = $env['route3'];

            $comments = $this->model->forum_commit($forumpage);

            foreach($comments as $item){
                echo $item['Comment'].'<br>';
            }
/*
            $arrSize = count($comments);

            for($i = 0; $i < $arrSize; $i++){

                $blogName = $comments[$i]["Comment"];

                $htmlblog = <<<"EOT"
                    <p class="col-lg-10 col-md-12 mx-auto my-2">$blogName</p>
EOT;
                $resultHTML = $resultHTML . $htmlblog;
            }
*/
            return $comments;
	}
}