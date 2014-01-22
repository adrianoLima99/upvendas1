<?php
include_once("../conexao/conexao.class.php");
class Produto
{
    
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaProduto()
    {
        
        $consulta=$this->conn->query("SELECT id_produto,nome_produto  FROM produto WHERE ativo=0");
        echo "<option></option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id_produto'>$l->nome_produto</option>";
        }
    }
}
$obj = new Produto();
$obj->listaProduto();
?>
