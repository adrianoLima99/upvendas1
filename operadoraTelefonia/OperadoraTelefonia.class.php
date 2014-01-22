<?php

class OperadoraTelefonica {

    private $operadora;
    private $idOperadora;
    private $idEstado;
    private $estado;
    private $conn;

    function __construct() {
        $this->conn = new connection();
    }

    function listaOperadorasTelefonia() {
        $listagem = $this->conn->query("SELECT * FROM operadoratelefonica");
        while ($l = $listagem->fetch(PDO::FETCH_OBJ)) {
                 $this->idOperadora[]    = $l->id;
                 $this->operadora[]     = $l->operadora;
        }
    }
     function listaEstados() {
        $listagem = $this->conn->query("SELECT * FROM estado");
        while ($l = $listagem->fetch(PDO::FETCH_OBJ)) {
                 $this->idEstado[]    = $l->id;
                 $this->estado[]     = $l->nome;
        }
    }

   
    function getOperadora() {
        return $this->operadora;
    }

    function getIdOperadora() {
        return $this->idOperadora;
    }
      function getEstado() {
        return $this->estado;
    }

    function getIdEstado() {
        return $this->idEstado;
    }

}

?>
