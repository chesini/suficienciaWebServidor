<?php
namespace App\Controller;

use App\View\Estagiario as vEstagiario;
use App\Model\Estagiario as mEstagiario;
use Exception;

class Estagiario {
    public function __construct() {
    }

    public function show() {
        $view = new vEstagiario();

        http_response_code(200);
        echo $view->showCadastro();
    }

    public function cadastrarEstagiario($param) {
        try {
            $database = new mEstagiario();
            
            if(strlen($param['nomeestagiario']) <= 1)
                return false;
            if(strlen($param['regacademico']) <= 1)
                return false;
            if(strlen($param['telefone']) <= 1)
                return false;
            if(strlen($param['email']) <= 1)
                return false;
            
            $param['regacademico'] = intval($param['regacademico']);
            
            $estagiarioExiste = $database->getEstagiarioRA($param['regacademico']);

            if(is_array($estagiarioExiste) && count($estagiarioExiste) > 0)
                return false;

            return $database->insertEstagiario($param);

        } catch (Exception $exc) {
            return false;
        }
    }

}
