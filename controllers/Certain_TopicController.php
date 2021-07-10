<?php

class Certain_TopicController extends Controller {

	private $pageTpl = '/templates/certain_topic.tpl';

	public function __construct() {
		$this->model = new Certain_TopicModel();
		$this->view = new View();
	}

	public function index() {

	    $this->controller();
        $this->pageData['page'] = $this->echo_page();
        $this->pageData['slash'] = "../../";

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function echo_page(){
		global $env;

		if($env['route'] == 'blog'){

			$page3 = $this->model->getpage();

			$pageName3=$page3["Sub_category"];
			$pageContent3=$page3["Certain_topic"];

			$htmlpage = <<<"EOT"
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">
                        $pageName3
                    </h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">
            		    $pageContent3
            	    </p>
                  </div>
                </div>
EOT;
			return ($htmlpage);
		}
		
		if($env['route'] == 'forum'){

			$page2 = $this->model->getpage();

			$pageName2=$page2["Sub_category"];
			$pageContent2=$page2["Certain_topic"];

			$htmlpage = <<<"EOT"
                <div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">
                        $pageName2
                    </h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">
            		    $pageContent2
            	    </p>
                  </div>
                </div>
EOT;
			return ($htmlpage);
		}


	}
}