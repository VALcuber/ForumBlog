<?php

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
            $env['route-2'] = $route[2]; //Need for translitreverse news in PageController
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

        if($route[1] == 'user_profile'){
            $controllerName = "User_profileController";
            $modelName = "User_profileModel";
        }

        elseif (isset($route[1]) && $route[1] == 'manage_users'){
            $controllerName = "ManageUsersController";
            $modelName = "ManageUsersModel";
        }

        elseif($route[1] == 'news' && isset($route[2])) {
            $controllerName = "PageController";
            $modelName = "PageModel";
        }

        elseif((isset($route[1]) && ($route[1] == 'blog')) && empty($route[2]) ) {
            $controllerName = "BlogController";
            $modelName = "BlogModel";

        }
        elseif((isset($route[1]) && ($route[1] == 'forum')) && empty($route[2]) ) {
            $controllerName = "ForumController";
            $modelName = "ForumModel";

        }

        elseif(isset($route[1]) && $route[1] == 'all'){
            $controllerName = "Categories_allController";
            $modelName = "Categories_allModel";
        }

        elseif((isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'forum')) && isset($route[3])){

            $controllerName = "PageController";
            $modelName = "PageModel";
            if(!empty($route[4]) && $route[4] == 'CommentController') {
                $controllerName = "CommentController";
                $modelName = "CommentModel";
            }

        }

        elseif(!empty($route[1]) && empty($route[2])){
            echo 'Empty rout';
        }

        elseif(isset($route[2]) && $route[2] != 'CommentController' && !isset($route[3])){

            $controllerName = "All_for_certain_categoryController";
            $modelName = "All_for_certain_categoryModel";

        }

        /** @noinspection PhpIncludeInspection */
        include PATH_C . $controllerName . ".php"; //IndexController.php
        /** @noinspection PhpIncludeInspection */
        include PATH_M . $modelName . ".php"; //IndexModel.php

		$controller = new $controllerName();
		$controller->$action();

	}

}

/*
	public function errorPage() {

	}
*/