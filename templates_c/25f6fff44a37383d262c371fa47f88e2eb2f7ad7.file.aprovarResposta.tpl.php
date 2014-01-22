<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:50:59
         compiled from "templates/aprovarResposta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1309866177526191230d9b22-57774381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25f6fff44a37383d262c371fa47f88e2eb2f7ad7' => 
    array (
      0 => 'templates/aprovarResposta.tpl',
      1 => 1382118217,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1309866177526191230d9b22-57774381',
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
  'unifunc' => 'content_52619123177360_73793202',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52619123177360_73793202')) {function content_52619123177360_73793202($_smarty_tpl) {?><br/><br/>
<div id="listagens">

 <?php if ($_smarty_tpl->tpl_vars['lista']->value!='') {?>
    <h3>Respostas N&atilde;o Ativas</h3>
	<table>
			<tr>
  				<th>Id</th>
				<th>Resposta</th>
				<th>Descricao</th>
				<th>Data Cadastro</th>
                                <th>Hora Cadastro</th>
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
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['resposta'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora_cadastro'];?>
</td>
                <td><a href="?pg=ativacaoResposta&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
">Aprovar</a></td>
		<td><a href="?pg=editarResposta&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&resposta=<?php echo $_smarty_tpl->tpl_vars['r']->value['resposta'];?>
&descricao=<?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
"><img src='imagens/edita.png' title='editar resposta'/></a></td>
             </tr>
	<?php } ?>

	</table>
    <?php } else { ?>
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta para ativa&ccedil;&atilde;o<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    <?php }?>
</div>	<?php }} ?>
