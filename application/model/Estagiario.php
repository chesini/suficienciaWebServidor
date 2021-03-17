<?php

namespace App\Model;

class Estagiario extends Database {
    public function __construct() {
        parent::__construct();
    }
    
    public function insertEstagiario($param) {
        return $this->insert('estagiario', array_keys($param), array_values($param));
    }

    public function getEstagiarioNome($nomeEstagiario) {
        return $this->select('estagiario', "*", array('nomeestagiario LIKE ' => $nomeEstagiario));
    }

    public function getEstagiarioRA($regAcademico) {
        return $this->select('estagiario', "*", array('regacademico = ' => $regAcademico));
    }

    public function getEstagiarioLista() {
        return $this->select('estagiario');
    }

    public function deleteEstagiarioId($idEstagiario) {
        return $this->delete('estagiario', 'idestagiario', $idEstagiario);
    }


}
