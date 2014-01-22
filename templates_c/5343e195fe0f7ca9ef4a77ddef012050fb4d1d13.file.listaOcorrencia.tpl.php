<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:56:59
         compiled from "templates/listaOcorrencia.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2993847705261928b8a2385-20416292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5343e195fe0f7ca9ef4a77ddef012050fb4d1d13' => 
    array (
      0 => 'templates/listaOcorrencia.tpl',
      1 => 1382118222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2993847705261928b8a2385-20416292',
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
  'unifunc' => 'content_5261928b98b296_46314385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5261928b98b296_46314385')) {function content_5261928b98b296_46314385($_smarty_tpl) {?>
<div id="listagens">
<br/>
<br/>
 <?php if ($_smarty_tpl->tpl_vars['lista']->value!='') {?>
<h3>Listagem de Ocorr&ecirc;ncias </h3>
	<table>
		<tr>
                    <th>Codigo</th>
                    <th>Ocorr&ecirc;ncia</th>
                    <th>Responsavel</th>
                    <th>Descricao</th>
                    <th>Data Cria&ccedil;&atilde;o </th>
		    <th>Hora Cria&ccedil;&atilde;o</th>
		    <?php if ($_SESSION['tipo']==0||$_SESSION['tipo']==1||$_SESSION['tipo']==2) {?>
                    <th colspan=2>A&ccedil;&atilde;o</th>
                    <?php }?>
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
              <?php if ($_SESSION['tipo']==0||$_SESSION['tipo']==1||$_SESSION['tipo']==2) {?>
        	<td><a href="?pg=editarOcorrencia&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&ocorrencia=<?php echo $_smarty_tpl->tpl_vars['r']->value['ocorrencia'];?>
&cargo=<?php echo $_smarty_tpl->tpl_vars['r']->value['cargo'];?>
&idCargo=<?php echo $_smarty_tpl->tpl_vars['r']->value['idCargo'];?>
&descricao=<?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
"><img src='imagens/edita.png' title='editar'/></a></td>
                <td><a href="#" onclick='exclua(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'><img src='imagens/excluir.gif' title='excluir '/></td>
               <?php }?> 
             </tr>
	<?php } ?>

		</table>
<?php } else { ?>
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta ativas<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    <?php }?>
</div>	
<?php }} ?>
