<?php /* Smarty version Smarty-3.1.15, created on 2013-12-02 17:40:46
         compiled from "templates/relatorio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96339992052619aa4007552-97550693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b16e1cc00bb7104e79d20099b4da055b1b23a0aa' => 
    array (
      0 => 'templates/relatorio.tpl',
      1 => 1386013244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96339992052619aa4007552-97550693',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_52619aa40fbaa6_88023459',
  'variables' => 
  array (
    'idEstado' => 0,
    'estado' => 0,
    'idCargo' => 0,
    'cargo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52619aa40fbaa6_88023459')) {function content_52619aa40fbaa6_88023459($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'smarty/plugins/function.html_options.php';
?><script type="text/javascript">
    function verificadorCampovazio() {
        if (jquery("#data-input").attr('checked') == true && document.getElementById("exibiGerTel").value == "" && document.getElementById("operador").value == "" &&
                document.getElementById("gerente").value == "" && document.getElementById("periodo1").value == "" && document.getElementById("periodo2").value == "") {

            alert("por favor");

            return false;
        }
        return true;


    }

//cham funcao q exibir os gerente e operadores de telemarketing
    selecionaGerOpRel()

</script>
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<script type="text/javascript">

    selecionaGerente();
</script>
<div id="menuRelatorio">
    <ul>
        <?php if ($_SESSION['tipo']==0) {?>
            <li><a href="?pg=relatorio&opc=Empresa" >Empresas</a></li>
            <?php }?>
        <li><a href="?pg=relatorio&opc=cliente" > Clientes</a></li>
        <li><a href="?pg=relatorio&opc=funcionario" > Funcionario</a></li>
        <li><a  href='?pg=relatorio&opc=acompanhamento'><span>Acompanhamento</span></a></li>
        <li><a  href='?pg=relatorio&opc=agendamento'><span>Agendamento</span></a></li>
        <li><a  href='?pg=relatorio&opc=Pendencia'><span>Pendência</span></a></li>
        <li><a  href='?pg=relatorio&opc=retorno'><span>Retorno Inteligente</span></a></li>
        <li><a href="?pg=relatorio&opc=Produto">Produto</a></li>  
        <li><a href="?pg=relatorio&opc=visita">Visita</a></li>
        <li><a href="?pg=relatorio&opc=venda">Vendas</a></li>
        <li><a href="?pg=relatorio&opc=comissao">Comissão</a></li>
    </ul>
</div>

<div id="relatorioOpcoes">

    <?php if ($_GET['opc']!='') {?>
        <?php if ($_GET['opc']=="retorno") {?>
            <h3>Relatorio de Retorno Inteliegnte</h3>
        <?php } else { ?>
            <h3>Relatorio de <?php echo $_GET['opc'];?>
</h3>
        <?php }?>    
        <div id="formularios">
            <fieldset> 
                <legend>Pesquisa Relatorio</legend>    
                <form action="#" method="post" >
                    <table border="1">
                        <tr>
                        <input type="hidden" name="opcao" id="opcao" value="<?php echo $_GET['opc'];?>
"/>
                        <?php if ($_GET['opc']=="cliente"||$_GET['opc']=="retorno"||$_GET['opc']=="venda"||$_GET['opc']=="visita"||$_GET['opc']=="Empresa") {?>
                     <tr>
                        <td>UF:</td><td>
                            <select name="estado" id="uf" onchange="listaCidades()" >
                                     <option value="">Selecione UF</option>
                        <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idEstado']->value,'output'=>$_smarty_tpl->tpl_vars['estado']->value),$_smarty_tpl);?>

                                                       </select> </td>
                   </tr>
                   <tr>
                        <td>Municipio:</td><td>
                            <select name="municipio"  id="municipio" >
                                <option></option>
                             </select></td>
                    </tr>
                        <?php }?>
                            <?php if ($_GET['opc']=="venda"||$_GET['opc']=="comissao"||$_GET['opc']=="visita"||$_GET['opc']=="cliente"||$_GET['opc']=="retorno") {?> 

                      
                        <tr>
                            <td>Gerente Vendas</td>
                            <td><select name="gerenteV"  id="gerente" onchange="selecionaVendedor()" ></select></td>
                        </tr>
                        <tr>
                            <td>Vendedor:</td>
                            <td><select name="vendedor"  id="exibir" ></select></td>
                        </tr>
                            <?php }?>
                            <?php if ($_GET['opc']=="visita"||$_GET['opc']=="retorno") {?>
                        <td>Status</td>
                        <td><select name="status" id="status" >
                                <option></option>
                                <option value="0">Vendido</option>
                                <option value='1'>Quente</option>
                                <option value="2">Morno</option>
                            </select>
                        </td>

                            <?php }?>
                            <?php if ($_GET['opc']=="acompanhamento"||$_GET['opc']=="comissao"||$_GET['opc']=="agendamento"||$_GET['opc']=="Pendencia"||$_GET['opc']=="retorno") {?>
                        <tr>
                            <td>Gerente Telemarketing:</td>
                            <td><select name="gerenteTel"  id='exibiGerTel' onchange='selecionaOperador2()' ></select></td>
                        </tr>
                        <tr>
                            <td>Operador(a) Telemarketing:</td>
                            <td><select name="operador"  id="operador" ></select></td>
                        </tr>
                            <?php if ($_GET['opc']=="Pendencia") {?>
                          <tr>
                             <td>Pendente:</td>
                              <td><select name="pendente">
                                        <option value="">Selecione</option>
                                        <option value="1">sim</option>
                                        <option value="0">não</option>
                                    </select></td>
                          </tr>
                            <?php }?>
                    
                            <?php }?>
                
                    </table>
                    <table border="1">
                     <?php if ($_GET['opc']!="funcionario") {?> 
                        <tr>
                            <td>
                                <label for="data-input">Dia:</label>
                            </td>
                            <td colspan="2">
                                <input id="data-input" type="radio" name="opcaoData" value="dia"  onclick="escondeAparece(this.value),habilitaCampoData(),desabilitaCampoPeriodo()"/>
                                <label>M&ecirc;s: <input type="radio" name="opcaoData" value="mes"  onclick="escondeAparece(this.value),habilitaCampoData(),desabilitaCampoPeriodo()"/></label>
                                <label>Ano: <input type="radio" name="opcaoData" value="ano"  onclick="escondeAparece(this.value),habilitaCampoData(),desabilitaCampoPeriodo()" /></label>
                            </td>
                        </tr>
                        <tr>
                            <td>Data:</td>
                            <td>
                                <input type="text"   id="dataDia" name='dataDia' />
                                <input type="text"   id="dataMes" name='dataMes' style="display:none" />
                                <input type="text"   id="dataAno" name='dataAno' style="display:none"/>
                            </td>
                        </tr>
                        <tr>
                            <td>De</td>
                            <td>
                                <input type="text"  class='data' name='periodo1' style="width:70px;" id="periodo1" onclick="desabilitaCampoData(),habilitaCampoPeriodo()" /> A <input type="text"  class='data' name='periodo2' id="periodo2" style="width:70px;"  onclick="desabilitaCampoData(),habilitaCampoPeriodo()"/>
                            </td>
                        </tr>
                         <?php }?>
                          <?php if ($_GET['opc']=="funcionario") {?>
                            <tr>
                                <td>Cargo:</td>
                                <td><select name="cargo" required="required">
                                        <option value="">Selecione Cargo</option>
                                    <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['idCargo']->value,'output'=>$_smarty_tpl->tpl_vars['cargo']->value),$_smarty_tpl);?>

                             
                                    </select></td>
                            </tr>
                                <?php }?>
                        
                        <tr>
                            <td><label for="tela-input">Tela</label></td>
                            <td>
                                <input id="tela-input" type="radio" name="opcaoExibicao" value="tela" onclick="escondeOpcaoGrafico()" />
                                <label>Pdf: <input type="radio" name="opcaoExibicao" value="pdf" onclick="escondeOpcaoGrafico()" /></label>

                                <?php if ($_GET['opc']=='venda'||$_GET['opc']=='acompanhamento'||$_GET['opc']=='agendamento'||$_GET['opc']=='visita'||$_GET['opc']=='Pendencia') {?>
                                    <!-- <label>Grafico: <input type="radio" name="opcaoExibicao" value="grafico" onclick="mostraOpcaoGrafico()"  /></label>-->
                                    <label>Grafico: <input type="radio" name="opcaoExibicao" value="grafico"   /></label>
                                    <select name="opcaoGrafico" id="opcaoGrafico" style="display:none">
                                        <option></option>
                                        <option value="bars">Barras</option>
                                        <option value="pie">Pizza</option>

                                    </select>

                                <?php }?>
                               
                            </td>
                        </tr>
                                <?php if ($_SESSION['tipo']==0) {?>
                         <input type='hidden' name='empresa' value=''/>
                                <?php } else { ?>
                          <input type='hidden' name='empresa' value='<?php echo $_SESSION['empresaId'];?>
'/>  
                                <?php }?>
                       <tr>
                            <td colspan="2"><input type="submit" name="enviar" value="Enviar" class="botao"/></td>
                        </tr> 
                    </table>
                                <?php }?>
            </form> 
        </fieldset>
    </div>
       
</div>
               <div style="clear:both;height:60px;width:auto;  "></div>          <?php }} ?>
