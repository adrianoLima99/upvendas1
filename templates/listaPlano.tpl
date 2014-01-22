{literal}
    <script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirPlano&id='+id;
                 }else{alert('A ação foi abortada!')}
                }
     </script>
{/literal}
<br/>
<br/>
<div id="listagens">
  
     
            <h3 style="clear:both">Listagem de Planos </h3>
            
            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Plano</th>
                    <th>Meses</th>
                    <th>data Criação</th><th>Hora Criação</th><th colspan="2">Ações</th>	
                </tr>
                {foreach from=$lista item=r }
                    <tr>
                        <td>{$r.id}</td>
                        <td>{$r.nome}</td>
                        <td>{$r.meses}</td>
                        <td>{$r.data_cadastro}</td>
                        <td>{$r.hora_cadastro}</td>
                        <td><a href="?pg=editarPlano&id={$r.id}"><img src='imagens/edita.png' title='editar'/></a></td>
                        <td><a href="#" onclick='excluir({$r.id})'><img src='imagens/excluir.gif' title='excluir'/></a></td>
                        
                    </tr>
                {/foreach}

            </table>
        </div>