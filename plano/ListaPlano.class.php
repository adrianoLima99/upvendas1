<?php
    class ListaPlano{
      private $conn;
   

    function __construct() {
        $this->conn = new connection;
    }
    
    function lista(){
        $sql=$this->conn->query("SELECT * FROM plano WHERE ativo=0 AND empresa_id=$_SESSION[empresaId]");
        return $sql;
    }
    
}
?>
