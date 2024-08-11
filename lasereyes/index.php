<?php

include_once 'preload.php';
include_once 'autoloader.php';
include_once 'vendor/autoload.php';
include_once 'utilities.php';

if (env('ENV') === 'local') {
    error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
    ini_set('display_errors', 'On');
} else {
    error_reporting(0);
    ini_set('display_errors', 'Off');
}

header("Access-Control-Allow-Origin: " . env('APP_ORIGIN_URL'));
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (!is_cli()) {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}

try {
    // Initialize the application.
    $initialize = new \App\Initialize();

    // Run the action and show the output.
    $initialize->action()->show();
} catch (Exception $e) {
    ob_start();
    require(ROOT . DS . 'templates' . DS . 'layouts' . DS . 'error.phtml');
    $errorPage = ob_get_contents();
    ob_end_clean();

    echo $errorPage;
}
