<?php
include_once("../conexao/conexao.class.php");
class Plano
{
    
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaPlano()
    {
        
        $consulta=$this->conn->query("SELECT id_plano,nome_plano  FROM plano WHERE ativo=0 AND cliente_sistema=$_SESSION[empresaId]");
        echo "<option></option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id_plano'>$l->nome_plano</option>";
        }
    }
}
$obj = new Plano();
$obj->listaPlano();
?>
