<?php
include_once("../conexao/conexao.class.php");
class Vendedor
{
   public $id;
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaVendedor()
    {
      
       
        $consulta=$this->conn->query("SELECT id_vendedor,nome_vendedor  FROM vendedor WHERE ativo=0 $this->id");
        echo "<option></option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id_vendedor'>$l->nome_vendedor</option>";
        }
    }
}
$obj = new Vendedor();
$obj->listaVendedor();
?>
