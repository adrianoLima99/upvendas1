<?php

class SalvarProduto{

private $produto;
 private $valor;
 private $ano;
 private $descricao;
 private $conn;
 
function __construct()
 {
   $this->conn = new connection;
  
 }
 function dadosProduto($produto,$valor,$descricao,$ano)
 {
 	 
     $this->produto   = $produto;
   //   $this->valor  = $valor;
      
     $this->valor  = removeMascaraNum($valor);
    // $this->valor2  = number_format($this->valor,2,",",".");
     $this->descricao=$descricao;
     $this->ano = $ano;
    $this->salveProduto();
 }
  function salveProduto()
 {

     
      $data_criacao = date("Y-m-d");
   
 echo "INSERT INTO produto VALUES(null,'$this->produto',$this->valor,'$this->ano',0,'$data_criacao',$_SESSION[empresaId],$_SESSION[func_id],'$this->descricao')";
	   $sql=$this->conn->exec("INSERT INTO produto VALUES(null,'$this->produto',$this->valor,'$this->ano',0,'$data_criacao',$_SESSION[empresaId],$_SESSION[func_id],'$this->descricao')") or die("erro sql");
   if($sql){
       echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                  location.href='?pg=listaProduto';
                    </script>";
   }
 }
 

}
$obj= new  SalvarProduto();

    $obj->dadosProduto($_POST["produto"],$_POST["valor"],$_POST["descricao"],$_POST["ano"]);
	



?>