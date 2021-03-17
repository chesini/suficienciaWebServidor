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
}
