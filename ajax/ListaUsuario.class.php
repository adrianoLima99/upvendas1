<?php
include_once("../conexao/conexao.class.php");
class ListaUsuario{
  
    private $conn;

function __construct(){
  $this->conn = new connection;
 }
 function verificaUsuario($usuario,$funcionario){
 
     $checkUsuario=$this->conn->query("SELECT nome FROM usuario WHERE (nome='$usuario' || funcionario_id=$funcionario) AND ativo=0");
     if($checkUsuario->rowCount()){
       echo "<h3 style='color:red'>Esse Usuario ja existe no sistema ou funcionario ja possui senha e nome usuario</h3>";
     }else{
       
         echo "<input type='submit' class='botao' name='cadastrar' value='cadastrar'/>
	       	 <input type='reset'class='botao' name='cancelar' value='cancelar'/>";
     }
     
 }
}
$obj=new ListaUsuario();
$obj->verificaUsuario($_GET["usuario"],$_GET["funcionario"]);
?>
