<?php
include_once("../conexao/conexao.class.php");
class Administrador
{
 
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaAdministradores()
    {
       
        $consulta=$this->conn->query("SELECT id,nome  FROM administrador WHERE ativo=0");
        echo "<option></option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
    }
}
$obj = new Administrador();
$obj->listaAdministradores();
?>
