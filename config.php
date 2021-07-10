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
$env['user_id'] = $_POST['user_id'] ?? '';
$env['first-name'] = $_POST['first-name'] ?? '';
$env['last-name'] = $_POST['last-name'] ?? '';
$env['birthday'] = $_POST['birthday'] ?? '';
$env['email'] = $_POST['email'] ?? '';
$env['password'] = $_POST['password'] ?? ''; //Не забыть экранировать пароль
$env['act'] = $_POST['act']?? '';
$env['active'] = '';
$env['alltitle'] = '';
$env['subcategory'] = '';
$env['titlecategory'] = '';
$env['route3'] = '';
$nv['forumblog'] = '';
$env['route'] = '';

//$_SESSION['user_id'] = '0';
// загрузка настроек

include PATH_M. 'Model.php';
include PATH_V. 'View.php';
include PATH_V. 'View_Admin.php';
include PATH_C. 'Controller.php'; // Подключаем контроллер

Routing::buildRoute();

