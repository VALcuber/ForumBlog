<?php
session_start();
class Routing {

	public static function buildRoute() {
		global $env;

		/*Контроллер и action по умолчанию*/
		$controllerName = "IndexController";
		$modelName = "IndexModel";
		$action = "index";

		$route = explode("/", $_SERVER['REQUEST_URI']);

        if(isset($route[1])) {
            $route1 = strtok($route[1], '-');
            $env['route1'] = $route1;
        }

        if(isset($route[2])) {
            $route2 = strtok($route[2], '-');
            $env['route2'] = $route2;
            //$env['route-2'] = $route[2];
        }

        if(isset($route[3])) {
            $route3 = urldecode($route[3]);
            $env['route3'] = $route3;
        }

        if($route[1] == 'blog'){
            $env['route'] = 'blog';
        }

        if($route[1] == 'forum'){
            $env['route'] = 'forum';
        }

        if($route[1] == 'news'){
            $env['route'] = 'news';
        }

        /*Определяем контроллер*/

        if(isset($route[3])) {
            $controllerName = "PageController";
            $modelName = "PageModel";
        }



        elseif((isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'news' || $route[1] == 'forum')) && isset($route[2])){
            $controllerName = "TopicController";
            $modelName = "TopicModel";

            if(isset($route[2]) && $route[2] == 'CommentController'){
                $controllerName = "CommentController";
                $modelName = "CommentModel";
            }

        }

        elseif(isset($route[1]) && ($route[1] == 'forum')){
            $controllerName = "ForumController";
            $modelName = "ForumModel";

        }

        elseif(isset($route[1]) && ($route[1] == 'blog') ) {
            $controllerName = "BlogController";
            $modelName = "BlogModel";

		}

        elseif (isset($route[1]) && $route[1] == 'manage_users'){
            $controllerName = "ManageUsersController";
            $modelName = "ManageUsersModel";
        }

		elseif(isset($route[1]) && $route[1] == 'all'){
            $controllerName = "";
            $modelName = "";
        }

        elseif($route[1] != '') {
            $controllerName = ucfirst($route[1]. "Controller");
            $modelName = ucfirst($route[1]. "Model");
        }

		include PATH_C . $controllerName . ".php"; //IndexController.php
		include PATH_M . $modelName . ".php"; //IndexModel.php

		$controller = new $controllerName();
		$controller->$action();

	}

}

/*
	public function errorPage() {

	}
*/
/*
    elseif(isset($route2) && $route2 != 'all' ){

        $controllerName = "Page_allController";
        $modelName = "Page_allModel";

        $route3 = strtok($route[2], '_');

        $env['title_category'] = $route[1];
        $env['forum_blog'] = lcfirst($route3);
        $env['subcategory'] = $route[2];

    }
*/