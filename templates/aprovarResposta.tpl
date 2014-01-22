<br/><br/>
<div id="listagens">

 {if $lista!=""}
    <h3>Respostas N&atilde;o Ativas</h3>
	<table>
			<tr>
  				<th>Id</th>
				<th>Resposta</th>
				<th>Descricao</th>
				<th>Data Cadastro</th>
                                <th>Hora Cadastro</th>
				<th colspan=2>A&ccedil;&atilde;o</th>
			</tr>
	{foreach from=$lista item=r }
			<tr>
            	<td>{$r.id}</td>
                <td>{$r.resposta}</td>
                <td>{$r.descricao}</td>
                <td>{$r.data_cadastro}</td>
                <td>{$r.hora_cadastro}</td>
                <td><a href="?pg=ativacaoResposta&id={$r.id}">Aprovar</a></td>
		<td><a href="?pg=editarResposta&id={$r.id}&resposta={$r.resposta}&descricao={$r.descricao}"><img src='imagens/edita.png' title='editar resposta'/></a></td>
             </tr>
	{/foreach}

	</table>
    {else}
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta para ativa&ccedil;&atilde;o<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    {/if}
</div>	