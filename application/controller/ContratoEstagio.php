<?php
namespace App\Controller;

use App\View\ContratoEstagio as vContrato;
use App\Model\ContratoEstagio as mContrato;
use App\Model\Estagiario as mEstagiario;
use DateTime;
use Exception;

class ContratoEstagio {
    private $view = NULL;
    private $model = NULL;
    public function __construct() {
        $this->view = new vContrato();
        $this->model = new mContrato();
    }

    public function showLista($idEmpresa = NULL) {
        echo $this->view->showLista($this->getLista($idEmpresa));
    }

    public function getLista($idEmpresa = NULL) {
        return $this->model->getContratoLista($idEmpresa);
    }

    public function showCadastro() {
        echo $this->view->showCadastro();        
    }

    public function cadastrarContrato($param) {
        try {
            $database = new mContrato();
            $dbEstagiario = new mEstagiario();

            if(strlen($param['idempresa']) < 1)
                return false;
            if(strlen($param['regacademico']) <= 1)
                return false;
            if(strlen($param['datainicio']) < 10)
                return false;
            if(strlen($param['datafim']) < 10)
                return false;
            
            $estagiario = $dbEstagiario->getEstagiarioRA(intval($param['regacademico']));

            if(!is_array($estagiario) || !isset($estagiario[0]['idestagiario']))
                return false;

            $idEstagiario = $estagiario[0]['idestagiario'];
            $param['idestagiario'] = intval($idEstagiario);
            unset($param['regacademico']);

            $data = explode("/", $param['datainicio']);
            $param['datainicio'] = $data[2]."-".$data[1]."-".$data[0];

            $data = explode("/", $param['datafim']);
            $param['datafim'] = $data[2]."-".$data[1]."-".$data[0];

            $param['idempresa'] = intval($param['idempresa']);
            $param['cargahoraria'] = intval($param['cargahoraria']);
            $param['idlogin'] = intval($_SESSION['idlogin']);

            $contratoExiste = $database->getContratoVigente($param['idestagiario'], $param['datainicio'], $param['datafim']);

            if(is_array($contratoExiste) && count($contratoExiste) > 0)
                return false;
    
            
            return $database->insertContrato($param);

        } catch (Exception $exc) {
            return false;
        }
    }

    public function excluirContrato($idContrato) {
        return $this->model->delete("contratoestagio", "idcontratoestagio", intval($idContrato));
    }

}