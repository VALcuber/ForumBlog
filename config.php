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
$env['route1'] = '';
$env['route2'] = '';
$env['route3'] = '';
$env['forum_blog'] = '';
$env['route'] = '';
$env['status'] = $_POST['userid'] ?? '';
$env['page_id'] = $_POST['page_id'] ?? '';;
$env['action'] = $_POST['action'] ?? '';
$env['token'] = $_POST['token'] ?? '';

// Downloading settings
// Register an autoloader function
spl_autoload_register(function ($class_name) {

    // Define an array of directories where classes might be located
    $directories = [
        PATH_C,
        PATH_M,
        PATH_V
    ];

    // Loop through each directory to find the class file
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';

        // If the file exists, require it and stop searching
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

Routing::buildRoute();

