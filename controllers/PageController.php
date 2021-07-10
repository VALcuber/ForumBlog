<?php

class PageController extends Controller {

	private $pageTpl = '/templates/page.tpl';

	public function __construct() {
		$this->model = new PageModel();
		$this->view = new View();
	}

	public function index() {

        $this->controller();
        $this->pageData['page'] = $this->echo_page();
        $this->pageData['slash'] = "../";
		
		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;

		if($env['route'] == 'blog'){
			
			$temporary = $env['temporary'][0];
			$smtppage = $this->model->getpage($temporary);

	
			$pageName=$smtppage["name"];
			$pageContent=$smtppage["blog_content"];

			$htmlpage = <<<"EOT"
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
			return ($htmlpage);
		}
		
		if($env['route'] == 'forum'){

			$temporary = $env['temporary'][0];
			
			$smtppage = $this->model->getpage($temporary);

			$pageName=$smtppage["name"];
			$pageContent=$smtppage["forum_content"];

			$htmlpage = <<<"EOT"
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
			return ($htmlpage);
		}


	}
}