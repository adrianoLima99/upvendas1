<?php

include_once("../conexao/conexao.class.php");

class consulta {

    private $tabela;
    private $cargo;
    private $conn;

    function __construct() {
        $this->conn = new connection();
    }

    function tabelas($cargo, $empresa) {
        $this->cargo = $cargo;

            $consulta = $this->conn->query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND cargo_id=$cargo AND empresa_id=$empresa");
            echo "<select>
                        <option value=''>Selecione</option>";
            while ($l = $consulta->fetch(PDO::FETCH_OBJ)) {
                echo "<option value='$l->id'>$l->nome</option>";
          }
          echo "</select>";
    }

}

$obj = new consulta();
$obj->tabelas($_GET['cargo'], $_GET['empresa']);
?>
