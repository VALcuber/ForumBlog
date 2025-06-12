<?php
/** @used-by Router */
class PageController extends Controller {

	private $pageTpl = '/templates/page.tpl';

	public function __construct() {
        parent::__construct();
		$this->model = new PageModel();
		$this->view = new View();
	}

	public function index() {
        $this->controller();
        $this->pageData['page'] = $this->echo_page();

		$this->view->render($this->pageTpl, $this->pageData);
	}
	
	public function echo_page(){
		global $env;


        $env['temporary'] = $env['route2'];

        if($env['route'] == 'blog' || $env['route'] == 'forum'){

            $this->pageData['comments'] = $this->echo_html_comments();
            $this->pageData['forum_comments'] = '<script src="/assets/js/forum.comments.js"></script>';

            $temporary = $env['temporary'];

            $smtppage = $this->model->get_page($temporary);
var_export($smtppage['user_id']);
            $post_author = $this->model->post_author($smtppage['user_id']);

            $nickname = $env['nickname'] = $post_author['Nickname'];

            $pageName=$smtppage["Category"];
            $pageContent=$smtppage["Description"];

            return '<div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">'.
                        $pageName
                    .'</h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">'.
            		    $pageContent
            	    .'</p>
                    <p class="p-1 text-right">by '.$nickname.'</p>
                  </div>
                </div>';
        }

        else{
            $this->pageData['forum_comments'] = '';
            $this->pageData['comments'] = '';

            $temporary = $this->translit_reverse($env['route-2']);

            $smtppage = $this->model->get_page($temporary);

            $pageName=$smtppage["name"];
            $pageContent=$smtppage["content"];

            return '<div class="card">
                  <div class="card-header">
                    <h2 class="text-center p-2">'.
                        $pageName
                    .'</h2>
                  </div>
                  <div class="card-body">
                    <p class="p-2">'.
            		    $pageContent
            	    .'</p>
                    <p class="p-1 text-right">by '.$nickname.'</p>
                  </div>
                </div>';
        }
	}

    public function echo_html_comments(){

        return '<div>
        <ul id="messages" class=" row px-5 message">
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

      </div>';
  }
}