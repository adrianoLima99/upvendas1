<?php /* Smarty version Smarty-3.1.15, created on 2013-11-13 00:57:08
         compiled from "templates/listaEmpresa.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5361077652618abcad5194-88608686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4b27324b8eef6f6ee0c37ed52b7cbec7f7476ac' => 
    array (
      0 => 'templates/listaEmpresa.tpl',
      1 => 1383441093,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5361077652618abcad5194-88608686',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52618abcb9d7a7_84581345',
  'variables' => 
  array (
    'empresa' => 0,
    'r' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52618abcb9d7a7_84581345')) {function content_52618abcb9d7a7_84581345($_smarty_tpl) {?>
 <!--INICIO MENSAGENS ATIVA OU DESATIVAR-->
     
        <script type='text/javascript'>
               function chamado(id){
                var resposta=confirm("Atenção:Tem certeza que deseja realizar essa operacao")
                 if(resposta)
                 {
                 location.href='?pg=ativaoudesativa&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
                
             
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirempresa&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
      
         </script>
         
        <!--FIM-->

<br/><br/><div id="listagens">
  
     
            <h3 style="clear:both">Listagem de Empresa(s) </h3>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Responsavel</th>
                    <th>Logradouro</th>
                    <th>Bairro</th>
                    <th>Email</th>
                    <th>Fone</th>
                    <th>data Criação</th>
                    <th colspan="3">Ações</th>	
                </tr>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['empresa']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cnpj'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['razao_social'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['responsavel'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['logradouro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['bairro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['email'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['fone'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                        <td><a href="?pg=editarEmpresa&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><img src='imagens/edita.png' title='editar '/></a></td>
                        <?php if ($_SESSION['tipo']==0) {?>
                            <?php if ($_smarty_tpl->tpl_vars['r']->value['ativo']==0) {?>
                                <td><a href="#" onclick='chamado(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'>Desativar</a></td>
                             <?php } else { ?>
                                <td><a href="#" onclick='chamado(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'>Ativar</a></td>
                             <?php }?>
                              <td><a href="#" onclick='excluir(<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
)'><img src='imagens/excluir.gif' title='excluir'/></a></td>
                        <?php }?>
                    </tr>
                <?php } ?>

            </table>
        </div><?php }} ?>
