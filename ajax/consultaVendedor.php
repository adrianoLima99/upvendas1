<?php
include_once("conexao/conexao.class.php");
class consulta
{
    private $gerente;
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaVendedor($gerente)
    {
      $this->gerente =$gerente;  
       $consulta=$this->conn->query("SELECT id_vendedor,nome_vendedor  FROM vendedor WHERE superior= $this->gerente ");
      echo " 
           <!-- <select name='vendedor' >-->
                <option></option>";
               while($l=$consulta->fetch(PDO::FETCH_OBJ))
               {
                 echo "<option value='$l->id_vendedor'>$l->nome_vendedor</option>";
                 }
                 echo "<!--</select>-->";
    }
}
$obj = new consulta();
$obj->listaVendedor($_GET['id']);

?>
