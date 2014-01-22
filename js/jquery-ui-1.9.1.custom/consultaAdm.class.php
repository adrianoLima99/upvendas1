<?php
include_once("../conexao/conexao.class.php");
class consulta
{
    private $admin;
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaVendedor($admin)
    {
        $this->admin = $admin;
        $consulta=$this->conn->query("SELECT id,nome  FROM gerente_vendas WHERE superior= $this->admin ");
        echo "<option></option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
    }
}
$obj = new consulta();
$obj->listaVendedor($_GET['id']);
?>
