<?php
namespace App\Controller;

use App\View\Estagiario as vEstagiario;

class Estagiario {
    public function __construct() {
    }

    public function show() {
        $view = new vEstagiario();

        http_response_code(200);
        echo $view->showCadastro();
    }

}
