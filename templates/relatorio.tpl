<script type="text/javascript">
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
        {if $smarty.session.tipo eq 0}
            <li><a href="?pg=relatorio&opc=Empresa" >Empresas</a></li>
            {/if}
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

    {if $smarty.get.opc !=""}
        {if $smarty.get.opc =="retorno"}
            <h3>Relatorio de Retorno Inteliegnte</h3>
        {else}
            <h3>Relatorio de {$smarty.get.opc}</h3>
        {/if}    
        <div id="formularios">
            <fieldset> 
                <legend>Pesquisa Relatorio</legend>    
                <form action="#" method="post" >
                    <table border="1">
                        <tr>
                        <input type="hidden" name="opcao" id="opcao" value="{$smarty.get.opc}"/>
                        {if $smarty.get.opc eq "cliente" || $smarty.get.opc eq "retorno" || $smarty.get.opc eq "venda" ||   $smarty.get.opc eq "visita" || $smarty.get.opc eq "Empresa" }
                     <tr>
                        <td>UF:</td><td>
                            <select name="estado" id="uf" onchange="listaCidades()" >
                                     <option value="">Selecione UF</option>
                        {html_options  values=$idEstado output=$estado}
                                                       </select> </td>
                   </tr>
                   <tr>
                        <td>Municipio:</td><td>
                            <select name="municipio"  id="municipio" >
                                <option></option>
                             </select></td>
                    </tr>
                        {/if}
                            {if $smarty.get.opc eq "venda" || $smarty.get.opc eq "comissao" || $smarty.get.opc eq "visita" || $smarty.get.opc eq "cliente" || $smarty.get.opc eq "retorno"} 

                      
                        <tr>
                            <td>Gerente Vendas</td>
                            <td><select name="gerenteV"  id="gerente" onchange="selecionaVendedor()" ></select></td>
                        </tr>
                        <tr>
                            <td>Vendedor:</td>
                            <td><select name="vendedor"  id="exibir" ></select></td>
                        </tr>
                            {/if}
                            {if $smarty.get.opc eq "visita" || $smarty.get.opc eq "retorno"}
                        <td>Status</td>
                        <td><select name="status" id="status" >
                                <option></option>
                                <option value="0">Vendido</option>
                                <option value='1'>Quente</option>
                                <option value="2">Morno</option>
                            </select>
                        </td>

                            {/if}
                            {if  $smarty.get.opc eq "acompanhamento"  || $smarty.get.opc eq "comissao" || $smarty.get.opc eq "agendamento" || $smarty.get.opc eq "Pendencia" || $smarty.get.opc eq "retorno" }
                        <tr>
                            <td>Gerente Telemarketing:</td>
                            <td><select name="gerenteTel"  id='exibiGerTel' onchange='selecionaOperador2()' ></select></td>
                        </tr>
                        <tr>
                            <td>Operador(a) Telemarketing:</td>
                            <td><select name="operador"  id="operador" ></select></td>
                        </tr>
                            {if $smarty.get.opc eq "Pendencia"}
                          <tr>
                             <td>Pendente:</td>
                              <td><select name="pendente">
                                        <option value="">Selecione</option>
                                        <option value="1">sim</option>
                                        <option value="0">não</option>
                                    </select></td>
                          </tr>
                            {/if}
                    
                            {/if}
                
                    </table>
                    <table border="1">
                     {if $smarty.get.opc  neq "funcionario" } 
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
                         {/if}
                          {if $smarty.get.opc eq "funcionario"}
                            <tr>
                                <td>Cargo:</td>
                                <td><select name="cargo" required="required">
                                        <option value="">Selecione Cargo</option>
                                    {html_options  values=$idCargo output=$cargo}
                             
                                    </select></td>
                            </tr>
                                {/if}
                        
                        <tr>
                            <td><label for="tela-input">Tela</label></td>
                            <td>
                                <input id="tela-input" type="radio" name="opcaoExibicao" value="tela" onclick="escondeOpcaoGrafico()" />
                                <label>Pdf: <input type="radio" name="opcaoExibicao" value="pdf" onclick="escondeOpcaoGrafico()" /></label>

                                {if $smarty.get.opc eq venda|| $smarty.get.opc eq acompanhamento || $smarty.get.opc eq agendamento || $smarty.get.opc eq visita || $smarty.get.opc eq Pendencia}
                                    <!-- <label>Grafico: <input type="radio" name="opcaoExibicao" value="grafico" onclick="mostraOpcaoGrafico()"  /></label>-->
                                    <label>Grafico: <input type="radio" name="opcaoExibicao" value="grafico"   /></label>
                                    <select name="opcaoGrafico" id="opcaoGrafico" style="display:none">
                                        <option></option>
                                        <option value="bars">Barras</option>
                                        <option value="pie">Pizza</option>

                                    </select>

                                {/if}
                               
                            </td>
                        </tr>
                                {if $smarty.session.tipo eq 0}
                         <input type='hidden' name='empresa' value=''/>
                                {else}
                          <input type='hidden' name='empresa' value='{$smarty.session.empresaId}'/>  
                                {/if}
                       <tr>
                            <td colspan="2"><input type="submit" name="enviar" value="Enviar" class="botao"/></td>
                        </tr> 
                    </table>
                                {/if}
            </form> 
        </fieldset>
    </div>
       
</div>
               <div style="clear:both;height:60px;width:auto;  "></div>          