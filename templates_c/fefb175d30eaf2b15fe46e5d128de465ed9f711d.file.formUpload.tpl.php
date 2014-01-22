<?php /* Smarty version Smarty-3.1.15, created on 2013-11-14 18:51:07
         compiled from "templates/formUpload.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1946163545261933ad6b873-82367830%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fefb175d30eaf2b15fe46e5d128de465ed9f711d' => 
    array (
      0 => 'templates/formUpload.tpl',
      1 => 1384462166,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1946163545261933ad6b873-82367830',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5261933add36b3_22496579',
  'variables' => 
  array (
    'idEstado' => 0,
    'estado' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5261933add36b3_22496579')) {function content_5261933add36b3_22496579($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?><link rel="stylesheet" type="text/css" href="js/lightbox/css/lightbox.css" media="screen"/>

    	<script type="text/javascript" src="js/lightbox/js/modernizr.custom.js"></script>
         <script type="text/javascript" src="js/lightbox/js/jquery-1.10.2.min.js"></script>
        
<script  type="text/javascript" src="js/lightbox/js/lightbox-2.6.min.js"></script>

    <script type="text/javascript" src="ajax/listaCidades.js"></script>
    <script type="text/javascript" >
      function frmCodigo(){
          document.getElementById("tbCodigo").style.display="block";
       }
      function mostraCodigo(valor){
          document.getElementById("codigo").value=valor;
      }
    </script>
    
    
<?php if ($_SESSION['usuario']!='') {?>
    <br/>
    <div style="margin:0 auto;width:600px;color:green;font-family:verdana, helvetica,arial ">
     <p>Atenção:</p>
        <p>Siga as instruções, onde tiver a palavra vazio ,o campo não poderá ser preenchido, o formato do arquivo devera ser ".csv"!</p>
        <p>Se for pessoa fisica,siga a sequência:</p>
        <figure>
           <div class="image-row">
		<a class="example-image-link" href="imagens/pessoaFisica.png"  data-lightbox="example-1">
	                <img src="imagens/pessoaFisica.png" width="600px" title="Pessoa Fisica"/>
            </a>
           </div> 
        </figure>
        <p>Se for pessoa juridica,siga a sequência:</p>
        <figure>
            <div class="image-row">
		<a class="example-image-link" href="imagens/pessoaJuridica.png"  data-lightbox="example-1">
	                <img src="imagens/pessoaJuridica.png" width="600px" title="Pessoa Juridica" />
            </a>
           </div>
        </figure>
       <br/>
      </div> 
    <div id=formularios>
          
        <fieldset>
            <legend>Enviar carta Cliente</legend>
            <form method='post' action='?pg=envioCartaCliente' name='uploadCSV' enctype='multipart/form-data'>

                <table>
                    <tr>
                        <td>Inserir Arquivo</td>
                        <td><input type='file' name='cartaCliente' /></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Convertido pelo:</td>
                        <td><select name='convertido' required >
                                <option></option>
                                <option value='1'>EXCEL</option>
                                <option value='2'>BROFFICE</option>	
                            </select>
                        </td>
                    <tr>  
                    <tr><td colspan="2" onclick="frmCodigo()"><a href="#" style="text-decoration:none;">Consultar codigo municipio</a></td></tr>
                    <table style="display:none " id="tbCodigo">  
                    <tr>
                           <td>Estado</td>
                            <td><select name='estado'id="uf" onchange="listaCidades()">
                                    <option>Selecione o estado</option>
                              <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEstado']->value,'output'=>$_smarty_tpl->tpl_vars['estado']->value),$_smarty_tpl);?>

                                </select>
                            </td>
                        </tr>
                        <tr>   
                            <td>Municipio</td>
                            <td><select name='municipio' id="municipio" onchange="mostraCodigo(this.value)" >
                                   <option value=""></option>  
                                </select>
                            </td>
                        </tr>
                        <tr>   
                            <td>Codigo</td> <td><input type="text" name='codigo' id="codigo" placeholder="copie este codigo " /></td>
                        </tr>
                    </table>  
                       <tr>
                        <td><input type='submit' name='upload' value='enviar' class='botao'/></td>
                    </tr>

                </table>

            </form>

        </fieldset> 
        <a href='javascript:history.go(-1)'>Voltar</a>
    </div> 
<?php }?><?php }} ?>
