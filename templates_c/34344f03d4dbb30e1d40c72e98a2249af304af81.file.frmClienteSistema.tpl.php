<?php /* Smarty version Smarty-3.1.15, created on 2013-11-26 15:32:19
         compiled from "templates/frmClienteSistema.tpl" */ ?>
<?php /*%%SmartyHeaderCode:130015723752648b49b7e267-43736527%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34344f03d4dbb30e1d40c72e98a2249af304af81' => 
    array (
      0 => 'templates/frmClienteSistema.tpl',
      1 => 1385487135,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '130015723752648b49b7e267-43736527',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52648b49bdbed3_14392084',
  'variables' => 
  array (
    'idEstado' => 0,
    'estado' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52648b49bdbed3_14392084')) {function content_52648b49bdbed3_14392084($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?>
<br/>
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<div id="formularios">
    <fieldset>
        <legend>
           
           <h3> Empresa</h3>
                    
        </legend>
        <form name="clienteSistema"  action="?pg=salvarEmpresa" method="post"  enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Nome:</td><td><input type="text" name="empresa" required="required" placeholder='Digite nome da empresa' /><span style='color:red;'>*</span></td>
                </tr>
               <tr>
                   <td>Razão Social:</td><td><input type='text' name='razao' required  placeholder='Digite razão social'/><span style='color:red;'>*</span></td>
		</tr>
		<tr>
                   <td>Cnpj:</td>
                  <td><input type='text' name='cnpj' onkeypress='return valCNPJ(event,this);return false;'  placeholder='Digite numero CNPJ' maxlength='18'  /></td>
                </tr>
                <tr>
                   <td>Responsavel:</td><td><input type='text' name='responsavel' placeholder='Digite nome do responsavel pela empresa' required /><span style='color:red;'>*</span></td>
		</tr>
                <tr>
                    <td>Foto:</td><td><input type="file" name="foto"   /></td>
                </tr>          
                <tr>
                    <td>Telefone</td>
                    <td><input type="tel" name="tel" class='tel' placeholder="Digite o telefone" required/><span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" id="email" placeholder="Digite o e-mail" /></td>
                </tr>
                <tr>
                    <td>Endere&ccedil;o:</td>
                    <td><input type="text" name="endereco" id="lograr" placeholder="Digite o nome da rua" /></td>
                </tr>
                <tr>
                    <td>Número:</td>
                    <td><input type="number" name="numero" id="numero" placeholder="Digite o número" /></td>
                </tr>
                <tr>
                    <td>Complemento:</td>
                    <td><input type="text" name="complemento" placeholder="Digite o complemento" id="complemento" /></td>
                </tr>
                <tr>
                    <td>Uf:</td>
                    <td><select name="estado" id="uf" onchange="listaCidades()" required>
                           <option>Selecione o estado</option>  
                        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEstado']->value,'output'=>$_smarty_tpl->tpl_vars['estado']->value),$_smarty_tpl);?>

                        </select> <span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Municipio:</td>
                    <td><select name="cidade"  id="municipio" required>
                            <option></option>
                        </select><span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Bairro:</td>
                    <td><input type="text" name="bairro" id="bairro" placeholder="Digite o bairro" />
                </tr>
               <tr>
                    <td>Usuario:</td>
                    <td><input type="text" name="usuario" id="usuario" placeholder="Digite o nome de usuario" required/><span style='color:red;'>*</span>
                </tr> 
                <tr>
                    <td>Senha:</td>
                    <td><input type="password" name="senha" id="senha" placeholder="Digite o senha" required/><span style='color:red;'>*</span>
                </tr>
                <tr>
                    <td>Confirmar senha:</td>
                    <td><input type="password" name="confSenha"  placeholder="Digite o novamente a senha"  required/><span style='color:red;'>*</span>
                </tr>
                
                <tr>
                    <td><input type="submit" name="gravar" value="Salvar" class="botao"/></td>
                </tr>
            </table>
        </form>
    </fieldset>		
</div><?php }} ?>
