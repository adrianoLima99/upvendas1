
<div id="listagens">
<br/>
<br/>
 {if $lista!=""}
<h3>Listagem de Ocorr&ecirc;ncias </h3>
	<table>
		<tr>
                    <th>Codigo</th>
                    <th>Ocorr&ecirc;ncia</th>
                    <th>Responsavel</th>
                    <th>Descricao</th>
                    <th>Data Cria&ccedil;&atilde;o </th>
		    <th>Hora Cria&ccedil;&atilde;o</th>
		    {if $smarty.session.tipo eq 0 || $smarty.session.tipo eq 1 ||  $smarty.session.tipo eq 2}
                    <th colspan=2>A&ccedil;&atilde;o</th>
                    {/if}
                </tr>
	{foreach from=$lista item=r }
			<tr>
            	<td>{$r.id}</td>
                <td>{$r.ocorrencia}</td>
                <td>{$r.cargo}</td>
                <td>{$r.descricao}</td>
                <td>{$r.data_cadastro}</td>
                <td>{$r.hora_cadastro}</td>
              {if $smarty.session.tipo eq 0 || $smarty.session.tipo eq 1 ||  $smarty.session.tipo eq 2}
        	<td><a href="?pg=editarOcorrencia&id={$r.id}&ocorrencia={$r.ocorrencia}&cargo={$r.cargo}&idCargo={$r.idCargo}&descricao={$r.descricao}"><img src='imagens/edita.png' title='editar'/></a></td>
                <td><a href="#" onclick='exclua({$r.id})'><img src='imagens/excluir.gif' title='excluir '/></td>
               {/if} 
             </tr>
	{/foreach}

		</table>
{else}
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta ativas<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    {/if}
</div>	
