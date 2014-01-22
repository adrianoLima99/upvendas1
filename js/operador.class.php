<?php
session_start();
include_once("../conexao/conexao.class.php");
class Operador
{
     private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
   
    function listaOperador()
    {	
       if($_GET["id"]){
           $condicao=" AND superior_id=$_GET[id]";
       }else{
           $condicao="";
       }
        $consulta=$this->conn->query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=5 $condicao");
        echo "<option value=''>Selecione operador telemarketing</option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
       
    }
}
$obj = new Operador();
$obj->listaOperador();
//$obj->listaOperador($_GET['id']);
?>
