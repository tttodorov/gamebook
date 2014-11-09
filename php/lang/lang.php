<?php

global $lang;

// include the set language translation
$filename = ROOT_DIR . 'lang/' . $lang . '.php';
if (file_exists($filename)) {
    require_once ROOT_DIR . 'lang/' . $lang . '.php';
} else {
    require_once ROOT_DIR . 'lang/bg_bg.php';
}

?>