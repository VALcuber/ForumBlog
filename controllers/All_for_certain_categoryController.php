<?php

class All_for_certain_categoryController extends Controller{

    private $pageTpl = '/templates/All_for_certain_category.tpl';

    public function __construct() {
        $this->model = new Categories_allModel();
        $this->view = new View();
    }

    public function index(){

        $this->controller();
        $this->pageData['pagealltitles'] = $this->echo_certain_category();
        $this->pageData['slash'] = "../";
        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function echo_certain_category(){
global $env;
        $someresultall = "";

            $category = $env['route2'];

            $titles = "<h4>".$category."</h4>";

            $pageallecho = <<<"EOT"
                </div>
                <div class="col-4">
                  <ul class="nav align-items-center justify-content-center">
                    <li class="nav-item">
                      <button type="button" class="btn-add rounded-circle bg-secondary">
                        <i class="bi bi-plus text-white"></i>
                      </button>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">FORUM</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">BLOG</a></li>
                  </ul>
                </div>
              </div>
              <div class="row px-4 py-2">
                <div class="col-8 px-0">
                  <nav>
                    <ul class="category-list p-0">
EOT;

/*
            $get_structure = $this->model->get_sertain_category_structure();

            $count_structure = count($get_structure);

            for($i = 0; $i < $count_structure; $i++){
                $env['all_title'] = $get_structure[$i]["structure"];
                var_export($env['all_title']);
            }
*/
            $env['all_title'] =$env['route2'];

            $all = $this->model->get_all_subcategories();

            $count2 = count($all);

        for($i = 0; $i < $count2; $i++) {
            $someresult = "";
            for ($i = 0; $i < $count2; $i++) {

                $structure = $all[$i]["structure"];
                $category_from_bd = $all[$i]["Category"];
                $subcategory = $all[$i]["Description"];

                $subcategoryes = <<<"EOT"
                    <li class="py-2">
                        <a href="/$structure/$category_from_bd/$subcategory">$subcategory</a>
                    </li>
EOT;
                $someresult = $someresult . $subcategoryes;
            }

            $someresultall = $titles . $pageallecho . $someresult;
        }
        return $someresultall;
    }


















/*

    public function echo_all_subcategories() {

        for ($i = 0; $i < $count; $i++) {



            $category_from_bd = $env['alltitles'][$i]['Category'];






        }
        return $someresult;
    }*/

}