<?php
/** @used-by Router */
class ForumController extends Controller{

    private $pageTpl = '/templates/forum-blog.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new ForumModel();
        $this->view = new View();
    }

    public function index() {
        global $env;

        $this->controller();
        if($env['act'] == 'Post')
            $this->model->add_forum_content();

        $this->pageData['forum_titles'] = $this->echo_page_titles();
        $this->pageData['echo_latest_forum_posts'] = $this->echo_latest_forum_posts();
        $this->pageData['route'] = strtoupper($env['route']);
        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_page_content() {

        global $env;

        $result = "";

        $route_title = $env['route'];

        $all_titles = $this->model->get_page_topic();

        $all = array_reverse($all_titles);

        $count = count($all);

        for($i = 0; $i < $count; $i++){

            $subcategory=$all[$i]["Category"];

            $subcategory_translit = $this->translit($subcategory);

            $subcategoryes = <<<"EOT"
                <li class="forum-content py-2 col d-flex justify-content-left">
                    <a href="/$route_title/$subcategory_translit">$subcategory</a>
                </li>
EOT;

            $result = $result.$subcategoryes;
        }

        return $result;

    } // Function for displaying forum

    public function echo_page_titles(){

        global $env;

        $category = ucfirst($env['route']);

        $titles = <<<"EOT"
                <h4 class="py-2">$category</h4>
EOT;
        /** @noinspection HtmlUnknownTarget */
        $pageallecho = <<<"EOT"
                </div>

                <div class="col-2">

                  <ul class="nav align-items-center justify-content-end">

                    <li class="nav-item">

                      <button type="button" class="btn-add rounded-circle bg-secondary">

                        <i class="bi bi-plus text-white"></i>

                      </button>

                    </li>

                    <li class="nav-item"><a href="/forum" class="nav-link">FORUM</a></li>

                    <li class="nav-item"><a href="/blog" class="nav-link">BLOG</a></li>

                  </ul>

                </div>

              </div>

              <div class="row px-4 py-2">

                <div class="col-10 px-0">

                  <nav>

                    <ul class="p-0 forum_topics row row-cols-3">
EOT;
        $ul_nav = '   
                </ul>

                </nav>';

        return $titles.$pageallecho.$this->echo_page_content().$ul_nav;

    } // Function for displaying forum and button " + " with links

    public function echo_latest_forum_posts(){
        global $env;

        $result = "";

        $route_title =$env['route'];

        $latest_forum_posts = $this->model->latest_forum_posts();

        $count = count($latest_forum_posts);

        if ($count != NULL) {

            for ($i = 0; $i < $count; $i++) {

                $echo_latest_forum_posts = $latest_forum_posts[$i]["Category"];

                $echo_latest_forum_posts_translit = $this->translit($echo_latest_forum_posts);

                $subcategoryes = <<<"EOT"
                    <li class="py-2">
                        <a href="/$route_title/$echo_latest_forum_posts_translit">$echo_latest_forum_posts</a>
                    </li>
EOT;

                $result = $result . $subcategoryes;
            }
        }
        else
            $result = '';

        return $result;
    }

}
