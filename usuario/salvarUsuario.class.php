<?php

Class SalvarUsuario{
  private $id_func;
  private $usuario;
  private $senha;
  private $tipo;
  private $conn;

function __construct()
 {
  $this->conn = new connection;
 }
function recebeusuario($id_func,$usuario,$senha,$tipo)
 {
  $this->id_func = $id_func;
    $this->usuario=$usuario;
    $this->senha =$senha;
   $this->tipo=  $tipo;
     
    
 }
 function UsuarioSalvar()
 {
 
	
 $senha=hash("SHA512","$this->senha");
 
 
      $novoUsuario =$this->conn->exec("INSERT INTO usuario VALUES(null,'$this->usuario','$senha',0,$this->id_func) ") or die("erro insercao");     
        if($novoUsuario){ 
           echo "<script type='text/javascript'>
                        alert('Usuario cadastrado com sucesso');
                        location.href='?pg=listaFuncionario';
                </script>";
        }
}
 
 
 
}


?>
