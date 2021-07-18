<?php

class Page_allController extends Controller {

    private $pageTpl = '/templates/page_all.tpl';

    public function __construct() {

        $this->model = new Page_allModel();
        $this->view = new View();

    }

    public function index() {

        $this->controller();
        $this->pageData['pageall'] = $this->echo_pageall();
        $this->pageData['pagealltitles'] = $this->echo_pagealltitles();
        $this->pageData['slash'] = "../";


        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function echo_pageall() { //Ф-я для вывода блога
      global $env;

        $someresult = "";

        $routecategory = $env['subcategory'];

        $routetitle = $env['title category'];


        $all = $this->model->getpageall();



        $count = count($all);

        for($i = 0; $i < $count; $i++){



            $subcategory=$all[$i]["Sub_category"];



            $subcategoryes = <<<"EOT"

                <li class="py-2">

                    <a href="/$routetitle/$routecategory/$subcategory">$subcategory</a>

                </li>

EOT;

            $someresult = $someresult.$subcategoryes;

        }



        return $someresult;

    }



    public function echo_pagealltitles(){ //Ф-я для вывода блога

        $someresultall = "";



        $alltitles = $this->model->getpagealltitles();



        for ($i = 0; $i < 1; $i++) {



            $category = $alltitles[$i]['Category'];



            $titles = <<<"EOT"

                <h4>$category</h4>

EOT;

            //$someresultall = $someresultall.$titles;



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

            $someresultall = $titles.$pageallecho.$this->echo_pageall();

        }

        return $someresultall;

}



























}