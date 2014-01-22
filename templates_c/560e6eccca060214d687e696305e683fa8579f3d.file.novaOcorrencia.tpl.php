<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:52:22
         compiled from "templates/novaOcorrencia.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1221635165261917611ea93-57425551%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '560e6eccca060214d687e696305e683fa8579f3d' => 
    array (
      0 => 'templates/novaOcorrencia.tpl',
      1 => 1382118224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1221635165261917611ea93-57425551',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'nome' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52619176174b77_91710270',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52619176174b77_91710270')) {function content_52619176174b77_91710270($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?>
<div id="formularios">
	<fieldset>
		<legend>Cadastrar Nova Ocorrencia	</legend>
			<table>
				<form action="?pg=salvaOcorrencia" method="post">
					<tr>
						<td>Ocorrencia</td>
						<td><input type="text" name="ocorrencia"/></td>
					</tr>
					<tr>
						<td>Descricao</td>
						<td><textarea name="descricao" cols="40" rows="20">
							</textarea>	
						</td>
					</tr>
					<tr>
						<td>Responsavel:</td>
						<td><select name="responsavel" >
                                                        <option> SELECIONE O RESPONSAVEL</option>
								<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['id']->value,'output'=>$_smarty_tpl->tpl_vars['nome']->value),$_smarty_tpl);?>

							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="cadastrar" name="cadastrar" class="botao"/></td>
					</tr>
			
				</form>

			</table>
	</fieldset>
</div>	<?php }} ?>
