<?php
namespace Routes;

use Exception;
use Routes\RouteSwitch;

class Router extends RouteSwitch {
    public function run(string $requestUri) {
        try {
            $route = array_filter(explode("/", $requestUri), function($part) {
                return strlen($part) > 0;
            });
            array_unshift($route);
            
            if (count($route) <=0 ) {
                // se nao esta logado
                if(!$_SESSION['logado']) {
                    ob_clean();
                    header('Status: 401 Unauthorized', false, 401);
                    header('Location: login/sem_permissao');
                } else {
                    $this->home();
                }
            } else {
                $metodo = strval($route[array_key_first($route)]);
                $parametros = array_slice($route, 1);
                $this->$metodo($parametros);
                
            }
        } catch(Exception $exc) {
            $this->notFound();
        }
    }
}
