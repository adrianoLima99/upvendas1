<?php

class Estado{
   private $conn;
   private $idUF;
   private $estado;
   public function __construct() {
		$this -> conn = new connection();
    }
    public function lista(){
        $selEstado=$this->conn->query("SELECT id,nome FROM estado ");
         
          while($lista=$selEstado->fetch(PDO::FETCH_OBJ)){
              echo "<option value='$lista->id'>$lista->nome</option>";
          }
    }
    public function lista2() {
           
        $listagem = $this->conn->query("SELECT id,nome FROM estado");
        while ($l = $listagem->fetch(PDO::FETCH_OBJ)) {
                 $this->idUF[]    = $l->id;
                 $this->estado[]     = $l->nome;
        }
    }
   function getEstado() {
        return $this->estado;
    }

    function getIdUF() {
        return $this->idUF;
    }

        
}
?>
