<?php
namespace App\View;


class Estagiario {
    public function __construct() {
    }

    public function showCadastro() {

        return file_get_contents(__DIR__. '/html/estagiarioCadastro.html');
    }

}