<?php /* Smarty version Smarty-3.1.15, created on 2013-10-20 19:59:47
         compiled from "templates/listaRelatorio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1898418816526452536a0043-24746702%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b9e34fe5c529c352bdb4cdb7b9f920da3282c93' => 
    array (
      0 => 'templates/listaRelatorio.tpl',
      1 => 1382118223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1898418816526452536a0043-24746702',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'contador' => 0,
    'lista' => 0,
    'r' => 0,
    'listaGerente' => 0,
    'g' => 0,
    'listaSup' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5264525392d895_52247020',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5264525392d895_52247020')) {function content_5264525392d895_52247020($_smarty_tpl) {?><div id="listagens">
    <?php if ($_smarty_tpl->tpl_vars['contador']->value>0) {?>
        <?php if ($_GET['opc']=='cliente') {?>
            <h3 style="clear:both">Relatorio de Clientes</h3>
            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>
            <table>
                <tr>
                    <th>Codigo</th><th>Nome</th>
                    <th>Nºdocumento</th>
                    <th>Sexo</th>
                    <th>Telefone Fixo</th>
                    <th>Celular </th>
                    <th>Logradouro</th>
                    <th>bairro</th>
                    <th>Cidade</th>
                    <th>Uf</th>
                    <th>Data de cadastro</th>	
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
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['numero_documento'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['sexo'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['fone1'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['fone2'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['logradouro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['bairro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['municipio'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['estado'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                    </tr>
                <?php } ?>

            </table>

        <?php } elseif ($_GET['opc']=="visita") {?>

            <h3 style="clear:both">Relatorio de Visita</h3>
            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Gerente Vendas</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th> Produto</th>
                    <th>Data Visita</th>

                </tr>
                <?php  $_smarty_tpl->tpl_vars['g'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['g']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listaGerente']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['g']->key => $_smarty_tpl->tpl_vars['g']->value) {
$_smarty_tpl->tpl_vars['g']->_loop = true;
?>  
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                         
                 <tr>
                      <td><?php echo $_smarty_tpl->tpl_vars['r']->value['idVisita'];?>
</td>
                   <?php if ($_smarty_tpl->tpl_vars['r']->value['gerente_vendas_id']==$_smarty_tpl->tpl_vars['g']->value['id']) {?>
                        <td> <?php echo $_smarty_tpl->tpl_vars['g']->value['nome'];?>
</td>
                   <?php } else { ?>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>

                         </td>
                   <?php }?>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>

                         </td> 
                         <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cliente'];?>
</td>
                         <td><?php echo $_smarty_tpl->tpl_vars['r']->value['produto'];?>
</td>
                         <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_visita'];?>
</td>
                  </tr>
                     <?php } ?>     
                <?php } ?>

            </table>

        <?php } elseif ($_GET['opc']=="venda") {?>

            <h3 style="clear:both">Relatorio de Vendas</h3>

            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>

            <table>
                <tr>
                    <th>Gerente Vendas</th><th>Vendedor</th><th>Cliente</th><th>Produto</th><th>Data Venda</th>
                </tr>
                <?php  $_smarty_tpl->tpl_vars['g'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['g']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listaGerente']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['g']->key => $_smarty_tpl->tpl_vars['g']->value) {
$_smarty_tpl->tpl_vars['g']->_loop = true;
?> 
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                    <tr>
                       <?php if ($_smarty_tpl->tpl_vars['r']->value['gerente_vendas_id']==$_smarty_tpl->tpl_vars['g']->value['id']) {?>
                          <td> <?php echo $_smarty_tpl->tpl_vars['g']->value['nome'];?>
</td>
                       <?php }?>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nomeFunc'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cliente'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nomeProd'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data'];?>
</td>

                    </tr>
                <?php } ?>
                <?php } ?>
                

            </table>


          <?php } elseif ($_GET['opc']=="funcionario") {?>

            <h3 style="clear:both">Relatorio de </h3>

            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>

            <table>
                <tr>
                    <th>Id </th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Superior</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Email</th>
                    <th>Data de Cadastro</th>
                </tr>
               <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listaSup']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->_loop = true;
?> 
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
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['sexo'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['s']->value['id']==$_smarty_tpl->tpl_vars['r']->value['superior_id']) {?>
                        <td><?php echo $_smarty_tpl->tpl_vars['s']->value['nome'];?>
</td>
                        <?php }?>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['fone1'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['logradouro'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['municipio'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['estado'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['email'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                    </tr>
                <?php } ?>
                <?php } ?>

            </table>       
       
        <?php } elseif ($_GET['opc']=="Produto") {?>

            <h3 style="clear:both">Relatorio de Produto</h3>

            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>

            <table>
                <tr>
                    <th>Codigo Veiculo</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Data Cadastramento</th>
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
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['valor'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data_cadastro'];?>
</td>
                    </tr>
                <?php } ?>

            </table>

        <?php } elseif ($_GET['opc']=="acompanhamento") {?>

            <h3 style="clear:both">Relatorio de Acompanhamento</h3>

            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>

            <table>
                <tr>
                    <th>Operador Telemarketing</th>
                    <th>Data cadastro </th>
                    <th>Hora Cadastro</th>
                    <th>Ocorrencia</th>

                </tr>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['r']->value['statusOcorrencia']==0) {?>
                            <td>Não existe ocorrencia</td>
                        <?php } else { ?>     
                            <td>Não existe ocorrencia</td>
                        <?php }?>

                    </tr>
                <?php } ?>

            </table>

        <?php } elseif ($_GET['opc']=="agendamento") {?>

            <h3 style="clear:both">Relatorio de Agendamento</h3>

            <p style="clear:both">Total de Registros:<?php echo $_smarty_tpl->tpl_vars['contador']->value;?>
</p>

            <table>
                <tr>
                    <th>Operador Telemarketing</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                </tr>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lista']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['nome'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['data'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['hora'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['r']->value['cliente'];?>
</td>
                    </tr>
                <?php } ?>

            </table>


        <?php }?>
    <?php }?>
</div><?php }} ?>
