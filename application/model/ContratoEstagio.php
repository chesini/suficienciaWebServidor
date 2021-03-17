<?php

namespace App\Model;

class ContratoEstagio extends Database {
    public function __construct() {
        parent::__construct();
    }
    public function insertContrato($param) {
        return $this->insert('contratoestagio', array_keys($param), array_values($param));
    }

    public function getContratoIdEmpresa($idEmpresa) {
        return $this->select('contratoestagio', "*", array('idempresa = ' => $idEmpresa));
    }

    public function getContratoId($idContrato) {
        return $this->select('contratoestagio', "*", array('idcontratoestagio = ' => $idContrato));
    }

    public function getContratoVigente($idEstagiario, $dataInicial) {
        return $this->select('contratoestagio', "*", array('idestagiario = ' => $idEstagiario, ' AND \'' . $dataInicial . '\' BETWEEN datainicio AND datafim AND 1 =' => 1));
    }

    public function getContratoLista($idEmpresa) {
        if(!$idEmpresa || !is_int($idEmpresa))
            $idEmpresa = " TRUE ";
        else
            $idEmpresa = "ce.idempresa = " . $idEmpresa;        

        $sql = "SELECT  CASE 
                            WHEN CURRENT_DATE BETWEEN ce.datainicio AND ce.datafim THEN
                                'Vigente'
                            ELSE 'Encerrado'
                        END AS situacao,
                        CONCAT(em.idempresa, ' - ', em.nomeempresa) AS empresa,
                        CONCAT(es.regacademico, ' - ', es.nomeestagiario) AS estagiario,
                        ce.cargahoraria,
                        DATE_FORMAT(ce.datainicio, '%d/%m/%Y') AS datainicio,
                        DATE_FORMAT(ce.datafim, '%d/%m/%Y') AS datafim,
                        ce.descricao,
                        ce.idcontratoestagio

                        FROM contratoestagio ce

                        JOIN empresa em
                        ON em.idempresa = ce.idempresa

                        JOIN estagiario es
                        ON es.idestagiario = ce.idestagiario

                        ORDER BY situacao DESC, ce.datafim DESC";
        return $this->query($sql);
    }

    public function deleteContratoId($idContrato) {
        return $this->delete('contratoestagio', 'idcontratoestagio', $idContrato);
    }
}

