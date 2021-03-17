<?php
namespace App\View;


class Home {
    public function __construct() {
        if(!$_SESSION['logado']) {
            ob_clean();
            header('Status: 401 Unauthorized', false, 401);
            header('Location: login/sem_permissao');
        }
    }

    public function show() {

        return file_get_contents(__DIR__. '/html/home.html');
    }

}