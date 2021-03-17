<?php

require __DIR__. '/vendor/autoload.php';

use Routes\Router;

if(!isset($_SESSION['logado']) || !isset($_SESSION['idsessao']))
    session_start();

$requestUri = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->run($requestUri);
