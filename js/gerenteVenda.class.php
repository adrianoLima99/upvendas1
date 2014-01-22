<?php
session_start();
include_once("../conexao/conexao.class.php");
class consulta
{
    private $gerente;
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaGerente()
    {
       
        $consulta=$this->conn->query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=3");
        echo "<option value=''>Selecione o gerente</option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
    }
}
$obj = new consulta();
$obj->listaGerente();
?>
