<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:37:24
         compiled from "templates/editarEmpresa.tpl" */ ?>
<?php /*%%SmartyHeaderCode:69340353152618df49a69f7-20135458%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28ef6e099d2b04ca03b3606d0d077790df0f560d' => 
    array (
      0 => 'templates/editarEmpresa.tpl',
      1 => 1382118218,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69340353152618df49a69f7-20135458',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nome' => 0,
    'cnpj' => 0,
    'razao' => 0,
    'responsavel' => 0,
    'email' => 0,
    'fone' => 0,
    'logradouro' => 0,
    'bairro' => 0,
    'complemento' => 0,
    'numero' => 0,
    'idUf' => 0,
    'estado' => 0,
    'idEstado' => 0,
    'idMunc' => 0,
    'municipio' => 0,
    'dataCadastro' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52618df4a567c2_14621716',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52618df4a567c2_14621716')) {function content_52618df4a567c2_14621716($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?>
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<div id="formularios">
    <fieldset>
        <legend>Editar Empresa</legend>
        <table>
            <form action="#" method="post">
                <tr>
                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>
" />
                <td>Empresa</td>
                <td><input type="text" name="nome" value="<?php echo $_smarty_tpl->tpl_vars['nome']->value;?>
" placeholder="digite o nome da empresa" /></td>
                </tr>
                <tr>
                    <td>CNPJ</td>
                    <td><input type="text" name="cnpj" value="<?php echo $_smarty_tpl->tpl_vars['cnpj']->value;?>
"  onkeypress='return valCNPJ(event,this);return false;'  placeholder='Numero CNPJ' maxlength='18' /></td>
                </tr>
                
                <tr>
                    <td>Razão Social</td>
                    <td><input type="text" name="razao" value="<?php echo $_smarty_tpl->tpl_vars['razao']->value;?>
" /></td>
                </tr>
                <tr>
                    <td>Responsavel</td>
                    <td><input type="text" name="responsavel" value="<?php echo $_smarty_tpl->tpl_vars['responsavel']->value;?>
" placeholder="digite o nome do responsavel" /></td>
                </tr>
                
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" placeholder="digite o email..ex:fictico@ficticio.com" /></td>
                </tr>
                <tr>
                    <td>Fone</td>
                    <td><input type="text" name="fone" value="<?php echo $_smarty_tpl->tpl_vars['fone']->value;?>
" maxlength="11" placeholder="digite apenas numeros.."/></td>
                </tr>
                <tr>
                    <td>Endereço</td>
                    <td><input type="text" name="endereco" value="<?php echo $_smarty_tpl->tpl_vars['logradouro']->value;?>
" placeholder="digite o  seu endereço" /></td>
                </tr>
                <tr>
                    <td>Bairro</td>
                    <td><input type="text" name="bairro" value="<?php echo $_smarty_tpl->tpl_vars['bairro']->value;?>
" placeholder="digite o bairro " /></td>
                </tr>
                 <tr>
                    <td>Complemento</td>
                    <td><input type="text" name="complemento" value="<?php echo $_smarty_tpl->tpl_vars['complemento']->value;?>
" placeholder="digite o complemento"/></td>
                </tr>
                 <tr>
                    <td>Numero</td>
                    <td><input type="number" name="numero" value="<?php echo $_smarty_tpl->tpl_vars['numero']->value;?>
" placeholder="digite o numero" /></td>
                </tr>
                
                 
                <tr>
                    <td>Estado</td>
                    <td><select name="estado"  id="uf" onchange="listaCidades()">
                            <option id="<?php echo $_smarty_tpl->tpl_vars['idUf']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['estado']->value;?>
</option>
                             <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEstado']->value,'output'=>$_smarty_tpl->tpl_vars['estado']->value),$_smarty_tpl);?>

                        </select>
                           
                    </td>
                </tr>
               
                <tr>
                    <td>Municipio</td>
                    <td><select name="municipio" id="municipio" >
                            <option value="<?php echo $_smarty_tpl->tpl_vars['idMunc']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['municipio']->value;?>
</option>
                        </select>
                           
                    </td>
                </tr>
              <tr>
                    <td>Data Cadastro</td>
                    <td><input type="text" name="data" value="<?php echo $_smarty_tpl->tpl_vars['dataCadastro']->value;?>
" placeholder="digite o numero" class='data' /></td>
                </tr>
                
                <tr>
                    <td><input type="submit" value="gravar" name="atualizar" class="botao"/></td>
                </tr>
                
            </form>

        </table>
                <a href="?pg=listaEmpresa">Voltar</a>     
    </fieldset>
</div>	<?php }} ?>
