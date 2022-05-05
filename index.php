<?php

use App\Router;

ob_start();
session_start();

spl_autoload_register(function ($class) {
    include_once  __DIR__ . '\\' . strtolower(str_replace('\\', '/', $class) . '.php');;
});

$router = new Router();
$router->handleRequest();

