<?php
namespace App\View;


class Empresa {
    public function __construct() {
    }

    public function showLista() {

        return file_get_contents(__DIR__. '/html/empresaLista.html');
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/empresaCadastro.html');
    }

}
