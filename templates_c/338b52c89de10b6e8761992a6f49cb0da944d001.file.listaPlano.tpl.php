<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:21:41
         compiled from "templates/listaPlano.tpl" */ ?>
<?php /*%%SmartyHeaderCode:87876161752618a45745909-77878160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '338b52c89de10b6e8761992a6f49cb0da944d001' => 
    array (
      0 => 'templates/listaPlano.tpl',
      1 => 1382118222,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '87876161752618a45745909-77878160',
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
  'unifunc' => 'content_52618a457bba96_29700511',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52618a457bba96_29700511')) {function content_52618a457bba96_29700511($_smarty_tpl) {?>
    <script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirPlano&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
     </script>

<br/>
<br/>
<div id="listagens">
  
     
            <h3 style="clear:both">Listagem de Planos </h3>
            
            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Plano</th>
                    <th>Meses</th>
                    <th>data Criação</th><th>Hora Criação</th><th colspan="2">Ações</th>	
                </tr>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['meses'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora_cadastro'];?>
</td>
                        <td><a href="?pg=editarPlano&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><img src='imagens/edita.png' title='editar'/></a></td>
                        <td><a href="#" onclick='excluir(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'><img src='imagens/excluir.gif' title='excluir'/></a></td>
                        
                    </tr>
                <?php } ?>

            </table>
        </div><?php }} ?>
