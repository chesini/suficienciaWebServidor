<?php
namespace App\View;


class Estagiario {
    public function __construct() {
        if(!$_SESSION['logado']) {
            ob_clean();
            header('Status: 401 Unauthorized', false, 401);
            header('Location: /login/sem_permissao');
        }
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/estagiarioCadastro.html');
    }

}