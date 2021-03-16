<?php
namespace App\Controller;

use App\View\Login as vLogin;

class Login {
    public function __construct($sessaoLogin = NULL) {
    }

    public function show() {
        $view = new vLogin();
        echo $view->show();
    }

    public function realizarLogin()
    {
        echo 'LOGINHO';
    }

}