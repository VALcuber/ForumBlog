<?php

class TopicController extends Controller{

    private $pageTpl = '/templates/topics.tpl';

    public function __construct()
    {
        $this->model = new TopicModel();
        $this->view = new View();
    }

    public function index()
    {
        $this->controller();
        $this->pageData['certain_topics'] = $this->echo_certain_topics();

        $this->view->render($this->pageTpl, $this->pageData);
    }

    public function echo_certain_topics (){
        global $env;

        $result = "";

        $route_title = $env['route'];

        $all_topics = $this->model->gettopics();

        //$all = array_reverse($all_titles);

        $count = count($all_topics);

        for($i = 0; $i < $count; $i++){

            $Topics = $all_topics[$i]["Topic"];
            $Title = $all_topics[$i]["Title"];

            $Topics_translit = $this->translit($Topics);

            $subcategoryes = <<<"EOT"
                <li class="py-2 col d-flex justify-content-center">
                    <a href="/$route_title/$Topics_translit/$Title">$Topics</a>
                </li>
EOT;

            $result = $result.$subcategoryes;
        }

        return $result;
    }
}
