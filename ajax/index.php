<?php 
ob_start();
include_once("conexao/conexao.class.php");
include_once "configuracoes.php";
include_once("formataData.php");

?> 
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<title>UPvendas</title>
<link type="text/css" href="css/cssreset.css" rel="stylesheet"/>
<link type="text/css" href="css/estilo.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="css/styles.css"/>


<script type="text/javascript" src="http://cidades-estados-js.googlecode.com/files/cidades-estados-v0.2.js"></script>
<script  type="text/javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.min.js"></script>

<link type="text/css" href="css/ui-lightness/ui-blitzer.datepick.css" rel="stylesheet" />

<script type="text/javascript" src="js/d/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/d/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/funcoes.js"></script>
<script type="text/javascript" src="js/func.js"></script>
<script type="text/javascript" src="js/accordion.js"></script>

<script typr="text/javascript">

  jQuery(function($){
	     $("#hora").mask(" 99:99:00");
              $(".num").mask("99.999,99"); 
		 $(".tel").mask("(99) 9999-9999"); 
                  $("#cpf").mask("999.999.999-99");
                  $("#nasc").mask("99/99/9999")
                  $("#cnpj").mask("99.999.999/9999-99");
                   $("#dataDia").mask("99/99/9999");
                  $("#dataMes").mask("99/9999");
                  $("#dataAno").mask("9999");
                 $(".data").datepicker({
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Próximo',
    prevText: 'Anterior'
});
                  
	     	   	}); 
                        
 
</script>

</head>

<body onload="selecionaGerOpRel()">

	<div id="menu-elastico">
  		<!-- Widget Previs&atilde;o de Tempo CPTEC/INPE --><iframe allowtransparency="true" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" src="http://www.cptec.inpe.br/widget/widget.php?p=245&w=h&c=748ccc&f=ffffff" height="200px" width="215px"></iframe><noscript>Previs&atilde;o de <a href="http://www.cptec.inpe.br/cidades/tempo/245">Teresina/PI</a> oferecido por <a href="http://www.cptec.inpe.br">CPTEC/INPE</a></noscript><!-- Widget Previs&atilde;o de Tempo CPTEC/INPE -->
  	</div>

      <?php 
     session_start();
    if(!empty($_SESSION['usuario'])&& !empty($_SESSION['senha']))
     {
        include_once 'exibirFoto.class.php';
        $obj_foto =new  ExibirFoto();
        $obj_foto->Foto();
       
             include("menu.php");
     ?>
    <section style="clear:both;">
      <article>
      <?php
      
       include_once "controle.php";
     }else{ 
	 		echo "<header>
    	<figure id='wrlogo'>
        	<img src='imagens/logo.png' alt='WR representa&ccedil;&otilde;es' 
        		title='WR representa&ccedil;&otilde;es'/>          
        </figure>
        <figure id='convolks'>
        	<img src='imagens/logovolks.png' alt='Cons&oacute;rcio Nacional Volkswagen' 
        		title='Cons&oacute;rcio Nacional Volkswagen'/>
        </figure>
    </header>
	";
			include("login.php");
            $obj=new Login();
            $obj->FormLogin();
     } 
      ?> 
      <!-- <form action="controle.php" method="post" name="formCliente">
        Cpf/Cnpj<input type="text" name="numero" id="numero"  required /><br/>
         
       <input type="submit" npame="enviar" value="enviar"/>
       
       </form>
        -->  
      </article>
  
  </section>
  
</body>
</html>
