<?php

class PageController extends Controller {
    protected $pagesData = array("slash" => '../../../');

	private $pageTpl = '/templates/page.tpl';

	public function __construct() {
		$this->model = new PageModel();
		$this->view = new View();
	}

	public function index() {
        global $env;
        $this->controller();
        $this->pageData['slash'] = "../../../";
        $this->pageData['page'] = $this->echo_page();
        $this->pageData['comments'] = $this->echo_comments();
        $this->pageData['forum_comments'] = '<script src="../../assets/js/forum.comments.js"></script>';


		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;

        $env['temporary'] = $env['route2'];

        if($env['route'] == 'blog'){

            $temporary = $env['temporary'];

            $smtppage = $this->model->get_page($temporary);

            $pageName=$smtppage["Title"];
            $pageContent=$smtppage["Description"];

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

	public function echo_comments(){
	    global $env;
        $resultHTML = '';
        if($env['route'] == 'forum') {

            $smtppage = $this->model->get_comments();

            foreach ($smtppage as $item) {
                $name = $item["name"];
                $Comment = $item["Comment"];
                $Commentid = $item["id"];

                $html_comment_forum = <<<"EOT"
                    <li name="comments_id" class="col-lg-10 col-md-12 mx-auto my-2" data-id="$Commentid">
                        <div>
                            <u>$name</u>
                         </div>
                        <div>
                            <p>$Comment</p>
                        </div >
                    </li >
EOT;
                $resultHTML = $resultHTML . $html_comment_forum;
            }
            return $resultHTML;
        }
    }
}