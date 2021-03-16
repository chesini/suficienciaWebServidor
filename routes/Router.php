<?php
namespace Routes;

use Routes\RouteSwitch;

class Router extends RouteSwitch {
    public function run(string $requestUri) {
        $route = str_replace(["/", "\\"], "", substr($requestUri, 1));

        if ($route === '') {
            $this->login();
        } else {
            $this->$route();
        }
    }
}
