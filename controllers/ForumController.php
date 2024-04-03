<?php


class ForumController extends Controller{

    private $pageTpl = '/templates/Forum.tpl';

    public function __construct() {
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
        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_page_content() { //Ф-я для отображения форума

        global $env;

        $result = "";

        $route_title = $env['route'];

        $all_titles = $this->model->get_page_topic();

        $all = array_reverse($all_titles);

        $count = count($all);

        for($i = 0; $i < $count; $i++){

            $subcategory=$all[$i]["Topic"];

            $subcategory_translit = $this->translit($subcategory);

            $subcategoryes = <<<"EOT"
                <li class="py-2 col d-flex justify-content-center">
                    <a href="/$route_title/$subcategory_translit">$subcategory</a>
                </li>
EOT;

            $result = $result.$subcategoryes;
        }

        return $result;

    }

    public function echo_page_titles(){ //Ф-я для отображения форума и кнопка " + " со ссылками

        global $env;

        $category = ucfirst($env['route']);

        $titles = <<<"EOT"
                <h4>$category</h4>
EOT;

        $pageallecho = <<<"EOT"
                </div>

                <div class="col-4">

                  <ul class="nav align-items-center justify-content-center">

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

                <div class="col-9 px-0">

                  <nav>

                    <ul class="p-0 forum_topics row row-cols-3">
EOT;
        $ul_nav = '   
                </ul>

                </nav>';

        return $titles.$pageallecho.$this->echo_page_content().$ul_nav;

    }

    public function echo_latest_forum_posts(){
        global $env;

        $result = "";

        $route_title =$env['route'];

        $latest_forum_posts = $this->model->latest_forum_posts();

        $count = count($latest_forum_posts);

        if ($count != NULL) {

            for ($i = 0; $i < $count; $i++) {

                $echo_latest_forum_posts = $latest_forum_posts[$i]["Topic"];

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
