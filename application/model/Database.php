<?php

namespace App\Model;
include __DIR__ . '\\..\\..\\config\\database.php';

use Exception;
use PDO;

class Database {
    private $conexao = NULL;
    
    public function __construct(){
        $this->conexao = new PDO('mysql:host=' . DB_HOST . ';dbname=estagio', DB_USER, DB_PASSWORD);
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function insert($tabela, $colunas, $valores) {
        try {
            foreach($valores as $i => $valor) {
                $valores[$i] = is_int($valor) ? $valor : '\'' . $valor . '\'';
            }
            $insert = "INSERT INTO {$tabela} (" . implode(", ", $colunas) . ") VALUES (" . implode(", ", $valores) . ") ;";

            $query = $this->conexao->prepare($insert);

            $query->execute();
            return true;

        } catch(Exception $exc) {
            return false;
        }
    }

    public function delete($tabela, $colunas, $valores) {

    }

    public function select($tabela, $colunasRetorno = "*", $condicoes = []) {

        try {
            $select = "SELECT {$colunasRetorno} FROM {$tabela} WHERE TRUE AND ";
            $where = "";
            foreach($condicoes as $condicao => $valor) {
                $where .= $condicao . (is_int($valor) ? $valor : '\'' . $valor . '\'');
            }

            $query = $this->conexao->prepare($select . $where);

            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);

        } catch(Exception $exc) {
            $this->tratarErro($exc);
        }
    }

    private function tratarErro(Exception $exc) {
    }
}
