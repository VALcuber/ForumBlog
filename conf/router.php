<?php

class Routing {

    public static function buildRoute() {

        global $env;

        try {
            /* Default controller and action */
            $controllerName = "IndexController";
            $modelName = "IndexModel";
            $action = "index";

            $route = explode("/", $_SERVER['REQUEST_URI']);

            if (isset($route[1])) {
                $route1 = strtok($route[1], '-');
                $env['route1'] = $route1;
            }

            if (isset($route[2])) {
                $route2 = urldecode(strtok($route[2], '-'));
                $env['route2'] = $route2;
                $env['route-2'] = urldecode($route[2]); // Need for translitreverse news in PageController
            }

            if (isset($route[3])) {
                $route3 = urldecode($route[3]);
                $env['route3'] = $route3;
            }

            /* Define controller */

            if ($route[1] == 'user_profile') {
                $controllerName = "User_profileController";
                $modelName = "User_profileModel";
            }

            elseif (isset($route[1]) && $route[1] == 'AddNews') {
                $controllerName = "AddNewsController";
                $modelName = "AddNewsModel";
            }
            elseif (isset($route[1]) && $route[1] == 'manage_users') {
                $controllerName = "ManageUsersController";
                $modelName = "ManageUsersModel";
            }
            elseif (isset($route[1]) && $route[1] == 'admin') {
                $controllerName = "AdminController";
                $modelName = "AdminModel";
                
                // Determine action for admin panel
                if (isset($route[2])) {
                    switch ($route[2]) {
                        case 'content':
                            $action = "content";
                            break;
                        case 'users':
                            $action = "users";
                            break;
                        case 'settings':
                            $action = "settings";
                            break;
                        case 'reports':
                            $action = "reports";
                            break;
                        case 'ajax':
                            $action = "ajax";
                            break;
                        default:
                            $action = "index";
                    }
                } else {
                    $action = "index";
                }
            }
            elseif($route[1] == 'settings' && !isset($route[2])){
                $controllerName = 'SettingsController';
                $modelName = "SettingsModel";
            }

            elseif ($route[1] == 'news' && isset($route[2])) {
                $controllerName = "PageController";
                $modelName = "PageModel";
            }

            elseif ((isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'forum')) && empty($route[2])) {
                if($route[1] == 'blog'){
                    $controllerName = "BlogController";
                    $modelName = "BlogModel";
                }
                elseif($route[1] == 'forum'){
                    $controllerName = "ForumController";
                    $modelName = "ForumModel";
                }
            }
/*
            elseif ((isset($route[1]) && ($route[1] == 'forum')) && empty($route[2])) {
                $controllerName = "ForumController";
                $modelName = "ForumModel";
            }*/
            elseif (!empty($route[1]) && !in_array($route[1], ['forum', 'blog', 'all'], true) && empty($route[2])) {
                $controllerName = "ForumBlogController";
                $modelName = "ForumBlogModel";
            }

            elseif (isset($route[1]) && $route[1] == 'all') {
                $controllerName = "Categories_allController";
                $modelName = "Categories_allModel";
            }

            elseif ((isset($route[1]) && ($route[1] == 'blog' || $route[1] == 'forum')) && isset($route[3])) {
                $controllerName = "PageController";
                $modelName = "PageModel";
                if (!empty($route[4]) && $route[4] == 'CommentController') {
                    $controllerName = "CommentController";
                    $modelName = "CommentModel";
                }
            }

            elseif (isset($route[2]) && $route[2] != 'CommentController' && !isset($route[3])) {
                $controllerName = "All_for_certain_categoryController";
                $modelName = "All_for_certain_categoryModel";
            }

/*            elseif(!empty($route[1]) && empty($route[2])){
                throw new Exception("Page", 404);
            }*/

            /** @noinspection PhpIncludeInspection */
            include PATH_C . $controllerName . ".php";      //IndexController.php
            /** @noinspection PhpIncludeInspection */
            include PATH_M . $modelName . ".php";           //IndexModel.php

            $controller = new $controllerName();
            $controller->$action();
        }
        catch (PDOException $e) {
            include_once PATH_C . "ErrorController.php";
            $controller = new ErrorController();
            $msg = $controller->handlePdoException($e);         // Receive message error
            $controller->index("Database error", $msg);         // push in controller
        }
        catch (Exception $e) {
            include_once PATH_C . "ErrorController.php";
            $controller = new ErrorController();
            $msg = $controller->handleGeneralException($e);     // Receive message error
            $controller->index("Unexpected error", $msg);       // push in controller
        }
    }


}
