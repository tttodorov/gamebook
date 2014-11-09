<?php

date_default_timezone_set('Europe/Sofia');

// include the base class
require_once ROOT_DIR . 'class/BaseObject.php';
require_once ROOT_DIR . 'class/Info.php';
require_once ROOT_DIR . 'class/Error.php';
require_once ROOT_DIR . 'class/User.php';
require_once ROOT_DIR . 'class/UserFunction.php';
require_once ROOT_DIR . 'class/UserStudent.php';
require_once ROOT_DIR . 'class/UserStudentFunction.php';

// connect to localSystemDb
try {
    $db = new PDO('mysql:host=localhost;dbname=gamebook', 'gamebook', 'gamebook');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8");
} catch (Exception $ex) {
    $error = new Error($ex->getMessage());
    $error->writeLog();
}

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}

if(!isset($_SESSION['json_obj']) && $page != 'login') {
    logout();
}