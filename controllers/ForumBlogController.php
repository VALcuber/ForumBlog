<?php
/** @used-by Router */
class ForumBlogController extends Controller{

    private $pageTpl = '/templates/forum-blog.tpl';

    public function __construct() {
        parent::__construct();
        $this->model = new ForumBlogModel();
        $this->view = new View();
    }

    public function index() {
        global $env;

        $this->controller();
        if($env['act'] == 'Post')
            $this->model->add_blog_content();

        $this->pageData['forum_titles'] = $this->echo_ForumBlog_titles();
        $this->pageData['echo_latest_forum_posts'] = $this->echo_latest_ForumBlog_posts();
        $this->pageData['route'] = strtoupper($env['route']);
        $this->view->render($this->pageTpl, $this->pageData);

    }

    private function echo_ForumBlog_content() {

        global $env;

        $result = "";

        $all_titles = $this->model->get_ForumBlog_topic($env['route1']);

        $count = count($all_titles);

        for($i = 0; $i < $count; $i++){

            $subcategory=$all_titles[$i]["Category"];

            $route_structure = $all_titles[$i]["structure"];

            $subcategory_translit = $this->translit($subcategory);

            $subcategoryes = <<<"EOT"
                <li class="blog-content py-2 col d-flex justify-content-left">
                    <a href="/$route_structure/$subcategory_translit">$subcategory</a>
                </li>
EOT;

            $result = $result.$subcategoryes;
        }

        return $result;

    }  // function for ForumBlog

    private function echo_ForumBlog_titles(){

        global $env;

        $category = ucfirst($env['route1']);

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

                    <ul class="p-0 blog_topics row row-cols-3">
EOT;
        $ul_nav = '   
                </ul>

                </nav>';

        return $titles.$pageallecho.$this->echo_ForumBlog_content().$ul_nav;

    } // // function for ForumBlog and button " + " with links

    private function echo_latest_ForumBlog_posts(){
        global $env;

        $result = "";

        $route_title =$env['route'];

        $latest_blog_posts = $this->model->latest_ForumBlog_posts();

        $count = count($latest_blog_posts);

        if ($count != NULL) {

            for ($i = 0; $i < $count; $i++) {

                $echo_latest_blog_posts = $latest_blog_posts[$i]["Category"];

                $echo_latest_blog_posts_translit = $this->translit($echo_latest_blog_posts);

                $subcategoryes = <<<"EOT"
                    <li class="py-2">
                        <a href="/$route_title/$echo_latest_blog_posts_translit">$echo_latest_blog_posts</a>
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
