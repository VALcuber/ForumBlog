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
        }

        /*Определяем контроллер*/

        if(isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'forum' || $route[1] == 'news') ) {

            $controllerName = "Blog_forum_news_Controller";
            $modelName = "Blog_forum_news_Model";

            if($route[1] == 'blog'){
                $env['route'] = 'blog';
            }

            if($route[1] == 'forum'){
                $env['route'] = 'forum';
            }

            if($route[1] == 'news'){
                $env['route'] = 'news';
            }

			if(isset($route2)){

                $controllerName = "PageController";
                $modelName = "PageModel";

                //$env['temporary'] = $route[2];
                //var_export($env);

            }
		}

		elseif(isset($route[3])) {

			$controllerName = "Certain_TopicController";
			$modelName = "Certain_TopicModel";

            $route3 = strtok($route[2], '_');

			$env['route3'] = $route[3];
			$env['route'] = lcfirst($route3);
		}
		
		elseif(isset($route2) && $route2 != 'all' ){

			$controllerName = "Page_allController";
			$modelName = "Page_allModel";

            $route3 = strtok($route[2], '_');

			$env['title_category'] = $route[1];
			$env['forum_blog'] = lcfirst($route3);
			$env['subcategory'] = $route[2];

		}

		elseif(isset($route[1]) && $route[1] == 'all'){
            $controllerName = "Page_all_all_categoriesController";
            $modelName = "Page_all_all_categoriesModel";
        }

        elseif($route[1] != '') {
            $controllerName = ucfirst($route[1]. "Controller");
            $modelName = ucfirst($route[1]. "Model");
        }

        elseif($route[1] == 'panel'){
            $controllerName = "PanelController";
            $modelName = "PanelModel";
        }

		include PATH_C . $controllerName . ".php"; //IndexController.php
		include PATH_M . $modelName . ".php"; //IndexModel.php

		$controller = new $controllerName();
		$controller->$action();

	}

	/*
	public function errorPage() {

	}
	*/
}
