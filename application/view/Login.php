<?php
namespace App\View;


class Login {
    public function __construct() {
    }

    public function show() {

        return file_get_contents(__DIR__. '/html/login.html');
    }

}