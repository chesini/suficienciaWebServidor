<?php

namespace Routes;

use App\Controller\Login;
use App\Controller\Empresa;
use App\Controller\Estagiario;
use App\Controller\ContratoEstagio;

abstract class RouteSwitch {
    protected function login() {
        // require __DIR__ . '\\..\\application\\view\\html\\login.html';
        $autenticacao = new Login();
        $autenticacao->show();
    }

    protected function Empresa() {
        require __DIR__ . '\\..\\application\\controller\\Empresa.php';
    }

    protected function Estagiario() {
        require __DIR__ . '\\..\\application\\controller\\Estagiario.php';
    }

    protected function ContratoEstagio() {
        require __DIR__ . '\\..\\application\\controller\\ContratoEstagio.php';
    }

    public function __call($name, $arguments) {
        http_response_code(404);
        require __DIR__ . '\\..\\application\\view\\not-found.html';
    }
}
