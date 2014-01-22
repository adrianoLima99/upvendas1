
 <!--INICIO MENSAGENS ATIVA OU DESATIVAR-->
 {literal}    
        <script type='text/javascript'>
               function chamado(id){
                var resposta=confirm("Atenção:Tem certeza que deseja realizar essa operacao")
                 if(resposta)
                 {
                 location.href='?pg=ativaoudesativa&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
                
             
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirempresa&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
      
         </script>
 {/literal}        
        <!--FIM-->

<br/><br/><div id="listagens">
  
     
            <h3 style="clear:both">Listagem de Empresa(s) </h3>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Responsavel</th>
                    <th>Logradouro</th>
                    <th>Bairro</th>
                    <th>Email</th>
                    <th>Fone</th>
                    <th>data Criação</th>
                    <th colspan="3">Ações</th>	
                </tr>
                {foreach from=$empresa item=r }
                    <tr>
                        <td>{$r.id}</td>
                        <td>{$r.nome}</td>
                        <td>{$r.cnpj}</td>
                        <td>{$r.razao_social}</td>
                        <td>{$r.responsavel}</td>
                        <td>{$r.logradouro}</td>
                        <td>{$r.bairro}</td>
                        <td>{$r.email}</td>
                        <td>{$r.fone}</td>
                        <td>{$r.data_cadastro}</td>
                        <td><a href="?pg=editarEmpresa&id={$r.id}"><img src='imagens/edita.png' title='editar '/></a></td>
                        {if $smarty.session.tipo eq 0}
                            {if $r.ativo eq 0}
                                <td><a href="#" onclick='chamado({$r.id})'>Desativar</a></td>
                             {else}
                                <td><a href="#" onclick='chamado({$r.id})'>Ativar</a></td>
                             {/if}
                              <td><a href="#" onclick='excluir({$r.id})'><img src='imagens/excluir.gif' title='excluir'/></a></td>
                        {/if}
                    </tr>
                {/foreach}

            </table>
        </div>