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

		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;

        $env['temporary'] = $env['route2'];

        if($env['route'] == 'blog' || $env['route'] == 'forum'){

            $this->pageData['comments'] = $this->echo_html_comments();
            $this->pageData['forum_comments'] = '<script src="../../assets/js/forum.comments.js"></script>';

            $temporary = $env['temporary'];

            $smtppage = $this->model->get_page($temporary);

            $pageName=$smtppage["Category"];
            $pageContent=$smtppage["Category_Description"];

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
            $this->pageData['forum_comments'] = '';
            $this->pageData['comments'] = '';

            $env['temporary'] = $env['route-2'];
            $temporary = $this->translit_reverse($env['temporary']);

            $smtppage = $this->model->get_page($temporary);

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

	}

	public function echo_comments(){
	    global $env;
        $resultHTML = '';
        if($env['route'] == 'forum' || $env['route'] == 'blog') {

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

    public function echo_html_comments(){

	    $echo_comments = $this->echo_comments();

	    $html_comments_echo = <<<"EOT"
<div>
        <ul id="messages" class=" row px-5 message">
          $echo_comments
        </ul>
      </div>

      <div class="row px-4">

        <form method="post" id="comments-send" class="row gy-2 gx-3 align-items-center col-lg-10 col-md-12 mx-auto my-2">

          <div class="col-10">

            <input  type="text" id="comment_text" class="form-control" name="forum_commit" required>

          </div>

          <div class="col-1.5">

            <input type="submit" class="btn btn-primary btn-lg" name="act" value="Commit">

          </div>

        </form>

      </div>

EOT;

        return$html_comments_echo;
    }
}