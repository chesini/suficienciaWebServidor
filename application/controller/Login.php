<?php
namespace App\Controller;

use App\View\Login as vLogin;
use App\Model\Database;
use Exception;

class Login {
    public function __construct($sessaoLogin = NULL) {
    }

    public function show() {
        $view = new vLogin();

        http_response_code(200);
        echo $view->show();
    }

    public function realizarLogin($usuario, $senha) {
        try {
            $database = new Database();
            $buscaUsuario = $database->select('login', "idlogin, nomeresponsavel", array('login = ' => $usuario, ' AND senha = ' => $senha));
            
            if(!is_array($buscaUsuario) || !isset($buscaUsuario[0]['idlogin']))
                return false;
            
            $_SESSION['idlogin'] = $buscaUsuario[0]['idlogin'];
            $_SESSION['nomeresponsavel'] = $buscaUsuario[0]['nomeresponsavel'];
            $_SESSION['logado'] = true;

            return $_SESSION['logado'];

        } catch (Exception $exc) {
            return false;
        }
    }

    public function realizarLogout() {
        try {
            $_SESSION['idlogin'] = NULL;
            $_SESSION['nomeresponsavel'] = NULL;
            $_SESSION['logado'] = false;
            session_destroy();

            return !$_SESSION['logado'];

        } catch (Exception $exc) {
            return false;
        }
    }

}