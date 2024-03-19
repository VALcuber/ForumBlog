<?php

class Page_all_all_categoriesController extends Controller {

    private $pageTpl = '/templates/page_all_all_categories.tpl';

    public function __construct() {

        $this->model = new Page_all_all_categoriesModel();

        $this->view = new View();

    }

    public function index() {

        $this->controller();
        $this->pageData['page_all_titles'] = $this->echo_pagealltitles();


        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_pagealltitles(){ //Ф-я для вывода названия категорий

        global $env;

        $all_titles = $this->model->getpagealltitles();
        $count_titles = count($all_titles);

//-------------------------------------

        $page_all_echo_0 = '<div class="row px-4 py-2">

                    <div class="col-8 px-0">

                      <h4><b>';

        $page_all_echo_1 = '</b></h4>

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

//-----------------------------------------------------------

        for ($i = 0; $i < $count_titles; $i++) {

            $some_result_descriptions_all = "";

            $category = $all_titles[$i]['title'];
var_dump($category);
            $env['all_title'] = $category;

            $alltitles2 = $this->model->getpageall();

            $counttitles2 = count($alltitles2);


            for ($j = 0; $j < $counttitles2; $j++) {

                $subcategory = $alltitles2[$j]["forum-description"];

                $subcategories = <<<"EOT"

                    <li>

                        <a href="/$category/$subcategory" class="py-2">$subcategory</a>

                    </li>

EOT;

                $some_result_descriptions_all .= $subcategories;

            }

            $some_result_all .= $page_all_echo_0.$category.$page_all_echo_1.$some_result_descriptions_all.$page_all_echo_2;

        }

        return $some_result_all;

    }

}

