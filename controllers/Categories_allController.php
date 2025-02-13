<?php

class Categories_allController extends Controller {

    private $pageTpl = '/templates/all.tpl';

    public function __construct() {

        $this->model = new Categories_allModel();

        $this->view = new View();

    }

    public function index() {

        $this->controller();
        $this->pageData['page_all_titles'] = $this->echo_pagealltitles();


        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_pagealltitles(){

        global $env;

        $all_titles = $this->model->get_all_categories();
        $count_titles = count($all_titles);

//-------------------------------------

        $page_all_echo_0 = '<div class="row px-4 py-2">

                    <div class="col-8 px-0">

                      ';

        $page_all_echo_1 = '

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

                    <div class="col-12 px-0">

                      <nav>

                        <ul class="category-list p-0">';

        $page_all_echo_2 = "</ul></nav></div></div>";

 //-----------------------------------------------------------

        $some_result_all = "";
        $structure = 'forum-blog';
//----------------------------------------------------------- For displaying categories

        for ($i = 0; $i < $count_titles; $i++) {

            $some_result_descriptions_all = "";

            $category_from_bd = $all_titles[$i]['Category'];

            $category = <<<"EOT"
                <a href="/$structure/$category_from_bd" class="py-2" style="font-size: 2.2em; font-weight: bold;">$category_from_bd</a>
EOT;
            $env['all_title'] = $category_from_bd;

//----------------------------------------------------------- For displaying subcategories

            $alltitles2 = $this->model->get_all_subcategories();

            $counttitles2 = count($alltitles2);

            for ($j = 0; $j < $counttitles2; $j++) {

                $structure_from_db = $alltitles2[$j]["structure"];
                $category_from_bd_2 = $alltitles2[$j]["Category"];;
                $subcategory = $alltitles2[$j]["Description"];

                $subcategories = <<<"EOT"

                    <li>

                        <a href="/$structure_from_db/$category_from_bd_2/$subcategory" class="py-2">$subcategory</a>

                    </li>

EOT;

                $some_result_descriptions_all .= $subcategories;

            }

            $some_result_all .= $page_all_echo_0.$category.$page_all_echo_1.$some_result_descriptions_all.$page_all_echo_2;

        }

        return $some_result_all;

    } //function for displaying categories and subcategories

}