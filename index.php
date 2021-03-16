<?php

require __DIR__. '/vendor/autoload.php';

use Routes\Router;

$requestUri = $_SERVER['REQUEST_URI'];
// var_dump($requestUri);

$router = new Router();
$router->run($requestUri);
