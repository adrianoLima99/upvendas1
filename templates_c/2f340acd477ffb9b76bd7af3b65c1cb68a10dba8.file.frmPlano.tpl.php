<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:18:59
         compiled from "templates/frmPlano.tpl" */ ?>
<?php /*%%SmartyHeaderCode:460172581526189a3b62579-77078469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f340acd477ffb9b76bd7af3b65c1cb68a10dba8' => 
    array (
      0 => 'templates/frmPlano.tpl',
      1 => 1382118221,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '460172581526189a3b62579-77078469',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_526189a3ba4ea2_19658732',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_526189a3ba4ea2_19658732')) {function content_526189a3ba4ea2_19658732($_smarty_tpl) {?>
<div id="formularios">
    <fieldset>
        <legend>Novo Plano</legend> 
        <form method="post" action="?pg=salvarPlano">
            <table>
                <tr>
                    <td>Plano:</td><td><input type="text" name="plano" placeholder="nome do plano"/></td>

                </tr>
                 <tr>
                    <td>Meses:</td><td><input type="text" name="meses" placeholder="quantidade de meses"/></td>
                </tr>
                <tr>
                    <td></td><td><input type="submit" name="salvar" value="salvar" class="botao"/></td>

                </tr>
            </table>
        </form>
    </fieldset>     
</div>    <?php }} ?>
