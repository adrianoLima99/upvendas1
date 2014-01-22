<?php
include_once("../conexao/conexao.class.php");
class ConsultaMunicipio
{
    private $id;
    private $conn;
    function __construct()
    {
        $this->conn = new connection();  
    }
    function listaMunicipio($id)
    {
        $this->id = $id;
        $consulta=$this->conn->query("SELECT id,nome  FROM municipio WHERE estado_uf= $this->id ");
       echo " <option value=''>Selecione a cidade</option>";
        while($l=$consulta->fetch(PDO::FETCH_OBJ))
        {
            echo "<option value='$l->id'>$l->nome</option>";
        }
    }
}
$obj = new consultaMunicipio();
$obj->listaMunicipio($_GET['id']);
?>
