<div id="listagens">
    {if $contador > 0}
        {if $smarty.get.opc eq cliente}
            <h3 style="clear:both">Relatorio de Clientes</h3>
            <p style="clear:both">Total de Registros:{$contador}</p>
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
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.id}</td>
                        <td>{$r.nome}</td>
                        <td>{$r.numero_documento}</td>
                        <td>{$r.sexo}</td>
                        <td>{$r.fone1}</td>
                        <td>{$r.fone2}</td>
                        <td>{$r.logradouro}</td>
                        <td>{$r.bairro}</td>
                        <td>{$r.municipio}</td>
                        <td>{$r.estado}</td>
                        <td>{$r.data_cadastro}</td>
                    </tr>
                {/foreach}

            </table>

        {else if $smarty.get.opc eq "visita" }

            <h3 style="clear:both">Relatorio de Visita</h3>
            <p style="clear:both">Total de Registros:{$contador}</p>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Gerente Vendas</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th> Produto</th>
                    <th>Data Visita</th>

                </tr>
                {foreach from=$listaGerente item=g }  
                {foreach from=$lista item=r }
                         
                 <tr>
                      <td>{$r.idVisita}</td>
                   {if $r.gerente_vendas_id eq $g.id }
                        <td> {$g.nome}</td>
                   {else}
                        <td>
                            {$r.nome}
                         </td>
                   {/if}
                        <td>
                            {$r.nome}
                         </td> 
                         <td>{$r.cliente}</td>
                         <td>{$r.produto}</td>
                         <td>{$r.data_visita}</td>
                  </tr>
                     {/foreach}     
                {/foreach}

            </table>

        {else if $smarty.get.opc eq "venda" }

            <h3 style="clear:both">Relatorio de Vendas</h3>

            <p style="clear:both">Total de Registros:{$contador}</p>

            <table>
                <tr>
                    <th>Gerente Vendas</th><th>Vendedor</th><th>Cliente</th><th>Produto</th><th>Data Venda</th>
                </tr>
                {foreach from=$listaGerente item=g } 
                {foreach from=$lista item=r }
                    <tr>
                       {if $r.gerente_vendas_id eq $g.id}
                          <td> {$g.nome}</td>
                       {/if}
                        <td>{$r.nomeFunc}</td>
                        <td>{$r.cliente}</td>
                        <td>{$r.nomeProd}</td>
                        <td>{$r.data}</td>

                    </tr>
                {/foreach}
                {/foreach}
                

            </table>


          {else if $smarty.get.opc eq "funcionario"}

            <h3 style="clear:both">Relatorio de </h3>

            <p style="clear:both">Total de Registros:{$contador}</p>

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
               {foreach from=$listaSup item=s } 
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.id}</td>
                        <td>{$r.nome}</td>
                        <td>{$r.sexo}</td>
                        {if $s.id eq $r.superior_id}
                        <td>{$s.nome}</td>
                        {/if}
                        <td>{$r.fone1}</td>
                        <td>{$r.logradouro}</td>
                        <td>{$r.municipio}</td>
                        <td>{$r.estado}</td>
                        <td>{$r.email}</td>
                        <td>{$r.data_cadastro}</td>
                    </tr>
                {/foreach}
                {/foreach}

            </table>       
       
        {else if $smarty.get.opc eq "Produto"}

            <h3 style="clear:both">Relatorio de Produto</h3>

            <p style="clear:both">Total de Registros:{$contador}</p>

            <table>
                <tr>
                    <th>Codigo Veiculo</th>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Data Cadastramento</th>
                </tr>
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.id}</td>
                        <td>{$r.nome}</td>
                        <td>{$r.valor}</td>
                        <td>{$r.data_cadastro}</td>
                    </tr>
                {/foreach}

            </table>

        {else if $smarty.get.opc eq "acompanhamento"}

            <h3 style="clear:both">Relatorio de Acompanhamento</h3>

            <p style="clear:both">Total de Registros:{$contador}</p>

            <table>
                <tr>
                    <th>Operador Telemarketing</th>
                    <th>Data cadastro </th>
                    <th>Hora Cadastro</th>
                    <th>Ocorrencia</th>

                </tr>
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.nome}</td>
                        <td>{$r.data}</td>
                        <td>{$r.hora}</td>
                        {if $r.statusOcorrencia eq 0}
                            <td>Não existe ocorrencia</td>
                        {else}     
                            <td>Não existe ocorrencia</td>
                        {/if}

                    </tr>
                {/foreach}

            </table>

        {else if $smarty.get.opc eq "agendamento"}

            <h3 style="clear:both">Relatorio de Agendamento</h3>

            <p style="clear:both">Total de Registros:{$contador}</p>

            <table>
                <tr>
                    <th>Operador Telemarketing</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                </tr>
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.nome}</td>
                        <td>{$r.data}</td>
                        <td>{$r.hora}</td>
                        <td>{$r.cliente}</td>
                    </tr>
                {/foreach}

            </table>


        {/if}
    {/if}
</div>