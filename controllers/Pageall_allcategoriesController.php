<?php

class Pageall_allcategoriesController extends Controller {

    private $pageTpl = '/templates/page_all_allcategories.tpl';

    public function __construct() {

        $this->model = new Pageall_allcategoriesModel();

        $this->view = new View();

    }

    public function index() {

        $this->controller();
        $this->pageData['pagealltitles'] = $this->echo_pagealltitles();
        $this->pageData['slash'] = "";

        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_pagealltitles(){ //Ф-я для вывода названия категорий

        global $env;

        $alltitles = $this->model->getpagealltitles();
        $counttitles = count($alltitles);

//-------------------------------------

        $pageallecho2 = "</ul></nav></div></div>";

        $pageallecho0 = '<div class="row px-4 py-2">

                    <div class="col-8 px-0">

                      <h4><b>';

        $pageallecho1 = '</b></h4>

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

 //-----------------------------------------------------------

        $someresultall = "";

//-----------------------------------------------------------

        for ($i = 0; $i < $counttitles; $i++) {

            $someresultdescriptionsall = "";

            $category = $alltitles[$i]['title'];

            $env['alltitle'] = $category;

            $alltitles2 = $this->model->getpageall();

            $counttitles2 = count($alltitles2);


            for ($j = 0; $j < $counttitles2; $j++) {

                $subcategory = $alltitles2[$j]["forum-description"];

                $subcategories = <<<"EOT"

                    <li>

                        <a href="/$category/$subcategory" class="py-2">$subcategory</a>

                    </li>

EOT;

                $someresultdescriptionsall .= $subcategories;

            }

            $someresultall .= $pageallecho0.$category.$pageallecho1.$someresultdescriptionsall.$pageallecho2;

        }

        return $someresultall;

    }

}

