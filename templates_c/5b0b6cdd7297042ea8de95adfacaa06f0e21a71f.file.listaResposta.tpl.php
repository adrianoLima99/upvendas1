<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:28:33
         compiled from "templates/listaResposta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121549959552618be141e358-33413748%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b0b6cdd7297042ea8de95adfacaa06f0e21a71f' => 
    array (
      0 => 'templates/listaResposta.tpl',
      1 => 1382118223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121549959552618be141e358-33413748',
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
  'unifunc' => 'content_52618be1505c50_84909338',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52618be1505c50_84909338')) {function content_52618be1505c50_84909338($_smarty_tpl) {?>
 <!--INICIO MENSAGENS EXCLUSÃO-->
     
        <script type='text/javascript'>
               function exclua(id){
                var resposta=confirm("Atenção:Esse registro pode esta contida em algum acompanhamento,Tem certeza que deseja exclui-lo")
                 if(resposta)
                 {
                 location.href='?pg=excluirResposta&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }
         </script>
         
        <!--FIM-->

<br/><br/>
<div id="listagens">

 <?php if ($_smarty_tpl->tpl_vars['lista']->value!='') {?>
<h3>Resposta Automaticas ativas</h3>
<br/>	<table>
              <tr>
                  <th>Id</th>
                  <th>Resposta</th>
		  <th>Descricao</th>
		  <th>Data Cadastro </th>
                  <th>Hora Cadastro </th>
<?php if ($_SESSION['tipo']==0||$_SESSION['tipo']==1||$_SESSION['tipo']==2) {?>
                  <th colspan='2'>Ações</th>    
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
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['resposta'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                 <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora_cadastro'];?>
</td>
               <?php if ($_SESSION['tipo']==0||$_SESSION['tipo']==1||$_SESSION['tipo']==2) {?> 
                    <?php if ($_smarty_tpl->tpl_vars['r']->value['id']!=9) {?>
                         <td><a href="?pg=editarResposta&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
&resposta=<?php echo $_smarty_tpl->tpl_vars['r']->value['resposta'];?>
&descricao=<?php echo $_smarty_tpl->tpl_vars['r']->value['descricao'];?>
"><img src='imagens/edita.png' title='editar resposta'/></a></td>
                         <td><a href="#" onclick='exclua(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'><img src='imagens/excluir.gif' title='excluir resposta'/></a></td>
                      <?php } else { ?>
                          <td></td>
                          <td></td>
                     <?php }?>       
               <?php }?>	 
             </tr>
	<?php } ?>
       </table>
  <?php } else { ?>
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta ativas<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    <?php }?>
</div><?php }} ?>
