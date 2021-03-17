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

    public function showLista($lista = []) {
        echo $this->view->showLista($lista);
    }

    public function getLista($filtro = " TRUE ") {
        $lista = $this->model->getEmpresaLista($filtro);

        if(!isset($lista[0]))
            $lista = [$lista];

        return $lista;
    }

    public function showCadastro() {
        echo $this->view->showCadastro();        
    }

    public function cadastrarEmpresa($param) {
        try {
            $database = new mEmpresa();
            
            if(strlen($param['nomeempresa']) <= 1)
                return false;
            if(strlen($param['responsavelempresa']) <= 1)
                return false;
            if(strlen($param['telefone']) <= 1)
                return false;
            if(strlen($param['email']) <= 1)
                return false;
            
            $empresaExiste = $database->getEmpresaNome($param['nomeempresa']);
            if(is_array($empresaExiste) && count($empresaExiste) > 0)
                return false;

            $param['telefone'] = intval(str_replace(["(", ")", "-", " "], "", $param['telefone']));
            return $database->insertEmpresa($param);

        } catch (Exception $exc) {
            return false;
        }
    }

}