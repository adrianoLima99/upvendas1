<?php 
ob_start();
date_default_timezone_set ('America/Sao_Paulo');
include_once("conexao/conexao.class.php");
include_once "configuracoes.php";
include_once("formataData.php");
include_once("mascaras/removeMascara.php");
include_once("mascaras/formatacao.php");


?> 
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<title>UPvendas | Versão 1.0</title>
<link type="text/css" href="css/cssreset.css" rel="stylesheet"/>
<link type="text/css" href="css/estilo.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="css/styles.css"/>
<script  type="text/javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.min.js"></script>

<link type="text/css" href="css/ui-lightness/ui-blitzer.datepick.css" rel="stylesheet" />

<script type="text/javascript" src="js/d/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/d/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/funcoes.js"></script>
<script type="text/javascript" src="js/func.js"></script>
<script type="text/javascript" src="js/accordion.js"></script>



<script type="text/javascript">
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
                      
  $(function() {
  new dgCidadesEstados({
    estado: $('#estado').get(0),
    cidade: $('#cidade').get(0)
  });
});                           
 
</script>

</head>

<!--<body onload="selecionaGerOpRel()">-->
<body>
	
      <?php 
     session_start();
    if(!empty($_SESSION['usuario']))
     {
        include_once "exibirFoto.class.php";
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
			<figure id='upvendas'>
        	<img src='imagens/upvendas.png' alt='Upvendas Versao 1.0' title='Upvendas Versao 1.0'/>
        </figure>
		
    </header>
	";
	
         if($_GET["pg"]=="cadastre"){
          echo "  <div id='legend'><h3 style='color: #fff;'>Cadastro</h3></div><br/><br/>";
                 include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';
                    $obj = new OperadoraTelefonica();
                    $obj->listaEstados();

                    $smarty->assign("idEstado", $obj->getIdEstado());
                    $smarty->assign("estado", $obj->getEstado());
                    $smarty->display("frmClienteSistema.tpl");

            }else if($_GET["pg"]=="salvarEmpresa"){
                 include_once "clienteSistema/salvarClienteSistema.class.php";
                
           
        } else{
         
                include("login.php");
                    $obj=new Login();
                    $obj->FormLogin();

                 echo "<a href='?pg=cadastre'>Cadastre-se</a>";
            }
         } 
      ?> 
      
      </article>
  
  </section>
  
</body>
</html>
