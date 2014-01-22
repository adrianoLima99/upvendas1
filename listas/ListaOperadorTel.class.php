<?php
class ListaOperadorTel{ 
 private $conn;
private $nome;
private $id;
    function __construct() {
	$this -> conn = new connection;
    }
       function lista() {
        $listagem = $this->conn->query("SELECT * FROM cargo WHERE empresa_id=$_SESSION[empresaId]");
        while ($l = $listagem->fetch(PDO::FETCH_OBJ)) {
                 $this->idCargo[]    = $l->id;
                 $this->cargo[]     = $l->nome;
        }
    }
   function getCargo() {
        return $this->cargo;
    }

    function getIdCargo() {
        return $this->idCargo;
    }


}      
?>
