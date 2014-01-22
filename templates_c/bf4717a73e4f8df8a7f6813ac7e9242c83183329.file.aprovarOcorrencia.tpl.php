<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:54:39
         compiled from "templates/aprovarOcorrencia.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1292290950526191fff2eb66-96386143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf4717a73e4f8df8a7f6813ac7e9242c83183329' => 
    array (
      0 => 'templates/aprovarOcorrencia.tpl',
      1 => 1382118216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1292290950526191fff2eb66-96386143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lista' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5261920007f4e3_81225899',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5261920007f4e3_81225899')) {function content_5261920007f4e3_81225899($_smarty_tpl) {?>
<div id="listagens">
<br/>
<br/>
<h3>Ocorr&ecirc;ncias criadas e n&atilde;o ativas</h3>
	<table>
			<tr>
  				<th>Codigo</th>
				<th>Ocorr&ecirc;ncia</th>
				<th>Responsavel</th>
				<th>Descricao</th>
				<th>Data Cria&ccedil;&atilde;o </th>
				<th>Hora Cria&ccedil;&atilde;o</th>
				
				<th colspan=2>A&ccedil;&atilde;o</th>
			</tr>
	<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
			<tr>
            	<td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['ocorrencia'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cargo'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora_cadastro'];?>
</td>
               
				<td><a href="?pg=aprovarOcorrencia&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Aprovar</a></td>
				<td><a href="?pg=editarOcorrencia&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&ocorrencia=<?php echo $_smarty_tpl->tpl_vars['r']->value['ocorrencia'];?>
&cargo=<?php echo $_smarty_tpl->tpl_vars['r']->value['cargo'];?>
&idCargo=<?php echo $_smarty_tpl->tpl_vars['r']->value['idCargo'];?>
&descricao=<?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
"><img src='imagens/edita.png' title='editar'/></a></td>
             </tr>
	<?php } ?>

		</table>
</div>	
<?php }} ?>
