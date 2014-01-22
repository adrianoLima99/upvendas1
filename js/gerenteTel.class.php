<?php
session_start();
include_once("../conexao/conexao.class.php");
class GerenteTel
{
 
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaGerenteTel()
    {
      
        $consulta=$this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=4");
        echo "<option value=''>Selecione Gerente de Telemarketing</option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
          echo "<option value='$l->id'>$l->nome</option>";
        }
      
    }
}
$obj = new GerenteTel();
$obj->listaGerenteTel();
?>
