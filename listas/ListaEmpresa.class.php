<?php
class ListaEmpresa{
   
    private $empresa;
    private $idEmpresa;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function  listaEmpresa(){
      $listagem = $this->conn->query("SELECT id,nome FROM empresa WHERE ativo=0");
        while ($l = $listagem->fetch(PDO::FETCH_OBJ)) {
                 $this->idEmpresa[]    = $l->id;
                 $this->empresa[]     = $l->nome;
        }
    }
   function getEmpresa() {
        return $this->empresa;
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }
  
}
?>
