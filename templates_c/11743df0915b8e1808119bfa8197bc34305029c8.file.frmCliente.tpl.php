<?php /* Smarty version Smarty-3.1.15, created on 2013-11-17 10:46:24
         compiled from "templates/frmCliente.tpl" */ ?>
<?php /*%%SmartyHeaderCode:203459574452617fc441e7c3-66130932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11743df0915b8e1808119bfa8197bc34305029c8' => 
    array (
      0 => 'templates/frmCliente.tpl',
      1 => 1384692331,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203459574452617fc441e7c3-66130932',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52617fc44f1418_17298391',
  'variables' => 
  array (
    'idEstado' => 0,
    'estado' => 0,
    'id' => 0,
    'nome' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52617fc44f1418_17298391')) {function content_52617fc44f1418_17298391($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?>
<script type="text/javascript" src="ajax/listaCidades.js"></script>

<div id="formularios">

    <fieldset>
        <legend>Novo Cliente</legend>
        <p style="color:red;font-size:18px">Campos Obrigatorios:*</p>
        <form action="?pg=salvarPs" method="post">
            <table>
                <tr>
                    <td>Nome Cliente:</td>  
                    <?php if (isset($_GET['nome'])) {?>
                        <td><input type="text" name='nome'  placeholder='Digite No Cliente' value="<?php echo $_GET['nome'];?>
" required/></td><td style="color:red">*</td>
                        <?php } else { ?>
                        <td><input type="text" name='nome'  placeholder='Digite No Cliente' required/></td><td style="color:red">*</td>
                        <?php }?>
                </tr>
                <tr>
                    <?php if (isset($_GET['identificador'])&&($_GET['pessoa']=="f")) {?>
                        <td>CPF:</td><td><input type="text" name="cpf"  onkeypress='return valCPF(event,this);return false;' placeholder='numero cpf' value='<?php echo $_GET['identificador'];?>
' maxlength='14'/></td>
                        <td><input type="hidden" name="pessoa" value="f"/></td>
                <tr>
                        <td>Sexo:</td>
                         <td><select name='sexo' required>
                                 <option value=''>Selecione o sexo</option>
                                 <option value='f'>Feminino</option>
                                 <option value='m'>Masculino</option>
                             </select>
                         </td>
                </tr>
                <tr>
                     <td>Data de Nascimento:</td><td><input type='text' name='nasc' id="nasc"  maxlength='10' placeholder='Data de Nascimento' /></td>
                </tr>
                    <?php } elseif (isset($_GET['identificador'])&&($_GET['pessoa']=="j")) {?>
                     <tr><td>CNPJ:</td>
                         <td><input type="text" name="cnpj" onkeypress='return valCNPJ(event,this);return false;'  placeholder='numero cnpj' value='<?php echo $_GET['identificador'];?>
' maxlength='18' /></td>
                         <td><input type="hidden" name="pessoa" value="j"/></td>
                     </tr>
                     <tr>
                         <td>Razão Social:</td>
                          <td><input type="text" name="razao"  placeholder='infrome a razão social' /></td>
                     </tr>
                    <?php } else { ?>

                        <td>Tipo de  Pessoa :</td>
                        <td><select name="pessoa" id="pessoa" onchange="habilitaDesabilita(this)" required>
                                <option value="">Selecione o tipo</option>
                                <option value="f">Pessoa Fisica</option>
                                <option value="j">Pessoa Juridica</option>
                            </select>
                        </td><td style="color:red">*</td>


                    </tr>  
                </table>
                <table id="tbFisica" style="display:none">    
                    <tr>

                        <td>Numdero do Cpf: </td>
                        <td ><input type='text' name='cpf'  onkeypress='return valCPF(event,this);return false;' placeholder='numero cpf' maxlength='14'/></td>

                    </tr>
                    <tr>

                        <td>Data de Nascimento</td>
                        <td><input type='text' name='nasc' id="nasc" maxlength='10' placeholder='digite a data nascimento' /></td>

                    </tr>
                    <tr> 
                        <td>Sexo.:</td>
                        <td><select   name='sexo'>
                                <option value="">sexo do cliente </option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>	
                        </td>

                    </tr>  
                </table>
                <table id="tbJuridica" style="display:none">   
                    <tr>
                        <td>Numero do CNPJ : </td>
                        <td><input type='text' name='cnpj'   onkeypress='return valCNPJ(event,this);return false;'  placeholder='numero cnpj' maxlength='18' /></td>
                    </tr> 
                     <tr>
                        <td>Razão Social  :</td>
                        <td><input type='text' name='razao'    placeholder='razao social'  /></td>
                    </tr> 
                  
                <?php }?>  
            </table>
            <table>    
                <tr> 
                    <td> Endere&ccedil;o:</td><td><input type="text" name="end" id="end" placeholder='rua,avenida..' /></td><td style="color:red">*</td>
                </tr>
                <tr>
                    <td>UF:</td><td><select name="uf" id="uf" onchange="listaCidades()"  >
                          <option>Selecione o estado</option>  
                         <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEstado']->value,'output'=>$_smarty_tpl->tpl_vars['estado']->value),$_smarty_tpl);?>

                        </select></td><td style="color:red">*</td>
                </tr>
                <tr>
                    <td>Cidade:</td>
                    <td><select name="cid" id="municipio" >
                            <option></option>
                        </select></td><td  style="color:red">*</td>
                </tr>
                <tr>    
                    <td>Bairro:</td><td><input type="text" name="bairro" id="Bairro" required placeholder='digite o nome do bairro'/></td><td  style="color:red">*</td>
                </tr>

                <tr>
                    <td>Email:</td><td><input type="email" name="email" placeholder='digite o email do cliente' /></td>
                </tr>

                <tr>
                    <td>Operadora telefonia</td>
                    <td><select name="opTelefonia" required="required">
                            <option value="">Selecione</option>
                            <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['id']->value,'output'=>$_smarty_tpl->tpl_vars['nome']->value),$_smarty_tpl);?>

                        </select>
                    </td><td  style="color:red">*</td>
                </tr>    

                <tr>
                    <td>Telefone Fixo:</td>
                    <?php if (isset($_GET['fone'])) {?> 
                        <td><input type="text" name="telefone" value="<?php echo $_GET['fone'];?>
" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td><td  style="color:red">*</td>
                        <?php } else { ?>
                        <td><input type="text" name="telefone" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td><td  style="color:red">*</td>
                        <?php }?>
                </tr>
                <tr>
                    <td>Celular 1:</td><td><input type="text" name="cel1" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td>
                </tr>
                <tr>
                    <td>Celular 2:</td><td><input type="text" name="cel2" onkeypress='return valPHONE(event,this);return false;'  maxlength='13' /></td>
                </tr>
                <tr>
                    <td></td>  <td><input type="submit" name="enviar" value="salvar" class="botao"/>


                </tr>


            </table>


        </form>
        <a href="?pg=listaDeCliente">Voltar</a>            
    </fieldset>            
</div><?php }} ?>
