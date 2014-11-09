<?php

// root dir
define('ROOT_DIR', './');

// secure the application
$host = $_SERVER['HTTP_HOST'];
$request_uri = strtok($_SERVER["REQUEST_URI"], '?');
$dns = $host . $request_uri;

// select language
require_once ROOT_DIR . 'lang/lang.php';

//include special functions
require_once ROOT_DIR . 'functions/functions.php';

// include the configs
require_once ROOT_DIR . 'config/config.php';

// include the page template
require_once ROOT_DIR . 'pages/main.php';

