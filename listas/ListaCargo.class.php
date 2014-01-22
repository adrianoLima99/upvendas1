<?php
class ListaCargo{ 
 private $conn;
private $cargo;
private $idCargo;
    function __construct() {
	$this -> conn = new connection;
    }
       function lista() {
           if($_SESSION["tipo"]==0){
               $clausula="";
           }else{
               $clausula=" AND empresa_id=$_SESSION[empresaId] OR empresa_id=3  ";
           }
        $listagem = $this->conn->query("SELECT * FROM cargo WHERE ativo=0  $clausula ");
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
