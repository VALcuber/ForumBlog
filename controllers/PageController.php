<?php

class PageController extends Controller {

	private $pageTpl = '/templates/page.tpl';

	public function __construct() {
		$this->model = new PageModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
        $this->pageData['slash'] = "../";
        $this->pageData['page'] = $this->echo_page();
        $this->pageData['forum_comments'] = '<script src="../../assets/js/forum.comments.js"></script>';


		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;

        $env['temporary'] = $env['route-2'];

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
}
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