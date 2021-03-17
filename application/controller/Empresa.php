<?php
namespace App\Controller;

use App\View\Empresa as vEmpresa;
use App\Model\Empresa as mEmpresa;
use Exception;

class Empresa {
    private $view = NULL;
    private $model = NULL;
    public function __construct() {
        $this->view = new vEmpresa();
        $this->model = new mEmpresa();
    }

    public function showLista() {
        echo $this->view->showLista();
    }

    public function showCadastro() {
        echo $this->view->showCadastro();        
    }

    public function cadastrarEmpresa($param) {
        try {
            $database = new mEmpresa();
            $param['telefone'] = intval($param['telefone']);
            return $database->insertEmpresa($param);

        } catch (Exception $exc) {
            return false;
        }
    }

}