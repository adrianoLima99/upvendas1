<?php /* Smarty version Smarty-3.1.15, created on 2013-10-18 16:21:36
         compiled from "templates/adicionarResposta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:73014697052618a40770a76-60145262%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a558345111803eaf179a7c7e9a45d0880112f31d' => 
    array (
      0 => 'templates/adicionarResposta.tpl',
      1 => 1382118216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73014697052618a40770a76-60145262',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52618a407abb66_80680222',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52618a407abb66_80680222')) {function content_52618a407abb66_80680222($_smarty_tpl) {?><br/>
<br/>
<div id="formularios">
	<fieldset>
            <legend>Cadastrar Resposta Autmatica</legend>
		
             <form action="#" method="post"> 
                <table>
                       <tr>
                            <td>Resposta</td>
                            <td><input type="text" name="resposta"/></td>
			</tr>
			<tr>
                            <td>Descri&ccedil;&atilde;o</td>
                            <td><textarea name="descricao" cols="40" rows="20"></textarea></td>
                        </tr>
			<tr>
                           <td></td> <td><input type="submit" value="cadastrar" name="cadastrar" class="botao"/></td>
			</tr>
		</table>
             </form>
        </fieldset>
</div>	<?php }} ?>
