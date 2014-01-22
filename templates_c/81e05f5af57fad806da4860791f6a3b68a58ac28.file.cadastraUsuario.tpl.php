<?php /* Smarty version Smarty-3.1.15, created on 2013-11-16 18:08:24
         compiled from "templates/cadastraUsuario.tpl" */ ?>
<?php /*%%SmartyHeaderCode:204664635852617fa9d80c01-20432230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81e05f5af57fad806da4860791f6a3b68a58ac28' => 
    array (
      0 => 'templates/cadastraUsuario.tpl',
      1 => 1384632501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '204664635852617fa9d80c01-20432230',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52617fa9df37d2_44579792',
  'variables' => 
  array (
    'idEmpresa' => 0,
    'empresa' => 0,
    'idCargo' => 0,
    'cargo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52617fa9df37d2_44579792')) {function content_52617fa9df37d2_44579792($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?>	
   
<div id='formularios'>
    <fieldset>
    <legend>Cadastrar usuários</legend>
 	   <form method='post' action='?pg=salvaUsuario' onsubmit='return verificaSenha()'>  
            <table>
        	 <tr>
        	 <?php if ($_SESSION['tipo']==0) {?>
                     <td>Empresa:</td>
                     <td><select name="cliEmpresa" id="cliEmpresa">
                           <option>Selecione  empresa</option>  
                        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEmpresa']->value,'output'=>$_smarty_tpl->tpl_vars['empresa']->value),$_smarty_tpl);?>

                         </select></td>
                 <?php } else { ?>
                      <td><input type='hidden' name='cliEmpresa' id='cliEmpresa' value='<?php echo $_SESSION['empresaId'];?>
'/></td>
                 <?php }?>
                 
        	 </tr>   
	    	 <tr>
              <td>Cargo:</td>
              <td><select name='tipo' id='cargo' onchange='selecionaCargo();' >
                    <option value="">Selecione Cargo</option>
                           <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idCargo']->value,'output'=>$_smarty_tpl->tpl_vars['cargo']->value),$_smarty_tpl);?>

		  
                  </select> 
              </td>
            </tr>
            <tr>
              <td> Nome:</td>
              <td><select name='id_func' id='nomeCargo' >
                    <option></option>
                   </select> 
              </td>
            </tr> 
            <tr> 
	      <td>Usuario</td>
	      <td><input type='text' name='usuario' id='usuario' placeholder='Digite o usuário' required  onblur="verificaUsuario()"/></td>
            </tr>
            <tr > 
	    
            </tr>
            
            <tr>
	      <td>Senha:</td>
	      <td><input type='password' name='senha' id='senha' placeholder='Digite a senha' required/></td>
	   </tr>
           <tr>
	      <td>Confirmar Senha:</td>
	      <td><input type='password' name='confsenha' id='confsenha' placeholder='Digite novamente  a senha' required/></td>
	   </tr>
	   <tr>
	     <td></td>
             <td id="check">
	     </td> 
           </tr>
        </table>
   </form>
   </fieldset>
   </div>";
     
<?php }} ?>
