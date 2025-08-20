<?php

define("ROOT", dirname(__FILE__));
define("PATH_C", ROOT. "/controllers/");
define("PATH_M", ROOT. "/models/");
define("PATH_V", ROOT. "/views/");

$env = [];	// Global array which consist all parameters app
$env['route'] = $_POST['route'] ?? '';
include ("conf/db.php");
include ("conf/router.php");
include ("conf/google_oauth.php"); // Include Google OAuth configuration

// Initialisation
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
$env['token'] = $_POST['token'] ?? '';

// Downloading settings

include PATH_C. 'Controller.php'; // Connecting controller
include PATH_M. 'Model.php';
include PATH_V. 'View.php';

Routing::buildRoute();

