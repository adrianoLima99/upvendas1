<?php
class Agendados {

    private $conn;
    private $cliente;
    private $telFixo;
    private $cel1;
    private $cel2;
    private $visibilidade;

    function __construct() {
        $this->conn = new connection;
    }
    public function usuario(){
        if($_SESSION["tipo"]==0){
            $empresa=0;
        }else{
            $empresa=" AND ";
        }
    }
    public function adicionar(){
        
    } 
    
    public function listar($cliente_id,$cliente_nome,$gerente_vendas,$vendedor,$operador){
        
        
        
    }
}
?>
