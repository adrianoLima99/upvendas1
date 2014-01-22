<?php
include_once("../conexao/conexao.class.php");
class consulta
{
    
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaVendedor($gerente)
    {
       
        
        $consulta=$this->conn->query("SELECT id,nome  FROM funcionario WHERE superior_id=$gerente AND perfil=6 AND ativo=0");
        echo "<option value=''>Selecione vendedor</option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
        
    }
}
$obj = new consulta();
$obj->listaVendedor($_GET['id']);

?>
