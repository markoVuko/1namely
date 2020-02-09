<?php

// require_once "app/Controllers/Controller.php";
// App\Controllers\Controller
// require_once "app/Controllers/PageController.php";

spl_autoload_register(function($classname){
    // echo $classname;
    // App\Controllers\PageController
    // app/Controllers/PageController
    // app\Controllers\PageController
    $classname = lcfirst($classname);
    $classname = str_replace("\\", DIRECTORY_SEPARATOR, $classname);
    $classname .= ".php";
    // echo $classname;
    require_once $classname;
});