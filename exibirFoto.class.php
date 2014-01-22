<?php

class ExibirFoto{
    private $conn;
    private $funcionario;
    private $cond;
    private $foto;
    function __construct() {
        $this->conn = new connection;
    }
    
   function Foto()
    {
      if($_SESSION["usuario"]){
            $consultaFoto=$this->conn->query("SELECT foto FROM funcionario WHERE  id=$_SESSION[func_id] and perfil=$_SESSION[tipo] AND ativo=0 ");
		  
            $li=$consultaFoto->fetch(PDO::FETCH_OBJ);
            if(!empty($li->foto))
             {
              $this->foto ="imagens/usuario/".$li->foto;
             }else
                 {
                 $this->foto="imagens/user.png";
                 }
       
	  
       echo "<header>
    	<figure id='upvendas'>
        	<img src='imagens/upvendas.png' alt='Upvendas Versao 1.0' title='Upvendas Versao 1.0'/>
        </figure>
	";
        echo "<div id='saudacao'><img src='$this->foto' width='110' height='140' alt='$_SESSION[usuario]'>
                <br />Ol&aacute; $_SESSION[usuario],<br/>
                 ($_SESSION[nmCargo])
                    <br />seja bem-vindo!</div>";
      
            echo " </header>";
       }
    } 
    
 }
 	
?>
