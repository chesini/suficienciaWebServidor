<?php

namespace App\Model;

use PDO;

class Empresa extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function insertEmpresa($param) {
        return $this->insert('empresa', array_keys($param), array_values($param));
    }

    public function getEmpresaNome($nomeEmpresa) {
        return $this->select('empresa', "*", array('nomeempresa LIKE ' => $nomeEmpresa));
    }

    public function getEmpresaId($idEmpresa) {
        return $this->select('empresa', "*", array('idempresa = ' => $idEmpresa));
    }

    public function getEmpresaLista($filtro = "TRUE") {
        $sql = "SELECT emp.*, COALESCE(ctvigente.qtd, 0) AS qtdvigente, COALESCE(ctencerrado.qtd, 0) AS qtdencerrado

                FROM empresa emp
                
                LEFT JOIN (
                    SELECT contratoestagio.idempresa, COUNT(*) AS qtd
                    FROM contratoestagio
                    WHERE CURRENT_DATE BETWEEN contratoestagio.datainicio AND contratoestagio.datafim
                    GROUP BY 1
                ) ctvigente
                ON ctvigente.idempresa = emp.idempresa
                
                LEFT JOIN (
                    SELECT contratoestagio.idempresa, COUNT(*) AS qtd
                    FROM contratoestagio
                    WHERE CURRENT_DATE BETWEEN contratoestagio.datainicio AND contratoestagio.datafim
                    GROUP BY 1
                ) ctencerrado
                ON ctencerrado.idempresa = emp.idempresa
                
                WHERE {$filtro}
                ;
        ";
        return $this->query($sql);
    }

    public function deleteEmpresaId($idEmpresa) {
        return $this->delete('empresa', 'idempresa', $idEmpresa);
    }

}
