<?php
session_start(); // starting session
class Routing {

	public static function buildRoute() {
		global $env;

		/* Default controller and action*/
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
            $env['route-2'] = $route[2];
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

        /* Define controller */

        if (isset($route[1]) && $route[1] == 'manage_users'){
            $controllerName = "ManageUsersController";
            $modelName = "ManageUsersModel";
        }

        elseif($route[1] == 'news' && isset($route[2])) {echo 'news';
            $controllerName = "PageController";
            $modelName = "PageModel";
        }

        elseif(isset($route[1]) && ($route[1] == 'forum')){
            $controllerName = "ForumController";
            $modelName = "ForumModel";

        }

        elseif(isset($route[1]) && ($route[1] == 'blog') ) {
            $controllerName = "BlogController";
            $modelName = "BlogModel";

        }

        elseif(isset($route[1]) && $route[1] == 'all'){
            $controllerName = "Categories_allController";
            $modelName = "Categories_allModel";
        }

        if((isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'forum')) && isset($route[2]) && !isset($route[3])){

            $controllerName = "PageController";
            $modelName = "PageModel";

            if(isset($route[2]) && $route[2] == 'CommentController'){
                $controllerName = "CommentController";
                $modelName = "CommentModel";
            }

        }

        if(isset($route[2]) && !isset($route[3])){

            $controllerName = "All_for_certain_categoryController";
            $modelName = "Categories_allModel";

        }

        elseif(isset($route[3])){
             echo 1;
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
        elseif($route[1] != '') {
            $controllerName = ucfirst($route[1]. "Controller");
            $modelName = ucfirst($route[1]. "Model");
        }
*/