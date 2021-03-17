<?php
namespace App\View;


class Contrato {
    public function __construct() {
    }

    public function showLista() {

        return file_get_contents(__DIR__. '/html/contratoLista.html');
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/contratoCadastro.html');
    }

}