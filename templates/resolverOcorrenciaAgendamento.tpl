<div id="formularios">
    <fieldset>
        <legend>Resolver  ocorr&ecirc;ncia Agendamento</legend>
        <table>
            <form method="post" action="#">
                
                <tr>
                    <td>Codigo Agendamento</td>
                                   <td><input type="text" readonly value="{$idAgen}" name="id_tabela"/></td>	
                </tr>
                <tr>
                    <td>Codigo Visita</td>
                       <input type="hidden"  value="agendamento_visita" name="tabela"/>
                      <td><input type="text" readonly value="{$visita}" name="idVisita"/></td>	
                </tr>
                <tr>
                      <td>Codigo Acompanhamento</td>
                       <td><input type="text" readonly value="{$acom}" name="idAcom"/></td>	
                </tr>
                <tr>
                      <td>Operador de Telemarketing</td>
                      <td><input type="text" readonly value="{$operador}" name="operador"/></td>	
                </tr>
                <tr>
                     <td>Cliente</td>
                     <td><input type="text" readonly value="{$cliente}" name="cliente"/></td>	
                </tr>
                <tr>
                     <td>Telefone Cliente</td>
                     <td><input type="text" readonly value="{$telefone}" name="telefone"/></td>	
                </tr>
                <tr>
                     <td>Email Cliente</td>
                     <td><input type="text"  value="{$email}" name="email"/></td>	
                </tr>
                <tr>
                     <td>Ocorrencia</td>
                        <input type="hidden" readonly value="{$idOcorrencia}" name="ocorrencia"/>
                     <td><input type="text" readonly value="{$idOcorrencia}-{$ocorrencia}" /></td>	
                </tr>	
                <tr>
                    <td>Obs:</td>
                    <td><textarea cols="37" rows="15" required name="obs"></textarea></td>	
                </tr>	
                <tr>
                    <td></td><td><input type="submit" name="enviar" value="Finalizar" class="botao"/></td>
                </tr>
            </form>
        </table>	
    </fieldset>
</div>
