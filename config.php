<?php

define("ROOT", dirname(__FILE__));
define("PATH_C", ROOT. "/controllers/");
define("PATH_M", ROOT. "/models/");
define("PATH_V", ROOT. "/views/");

$env = [];	// глобальный массив, содержащий параметры приложения
$env['route'] = $_POST['route'] ?? '';
include ("conf/db.php");
include ("conf/router.php");

// инициализация
$env['id'] = $_POST['id']?? '';
$env['act'] = $_POST['act']?? '';
$env['active'] = '';
$env['all_title'] = '';
$env['subcategory'] = '';
$env['title_category'] = '';
$env['route3'] = '';
$env['forum_blog'] = '';
$env['route'] = '';
$env['status'] = $_POST['userid'] ?? '';
$env['page_id'] = '';
$env['action'] = $_POST['action'] ?? '';

//$_SESSION['user_id'] = '';
// загрузка настроек

include PATH_M. 'Model.php';
include PATH_V. 'View.php';
include PATH_C. 'Controller.php'; // Подключаем контроллер

Routing::buildRoute();

