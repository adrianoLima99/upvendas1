
<div id="listagens">
<br/>
<br/>
<h3>Ocorr&ecirc;ncias criadas e n&atilde;o ativas</h3>
	<table>
			<tr>
  				<th>Codigo</th>
				<th>Ocorr&ecirc;ncia</th>
				<th>Responsavel</th>
				<th>Descricao</th>
				<th>Data Cria&ccedil;&atilde;o </th>
				<th>Hora Cria&ccedil;&atilde;o</th>
				
				<th colspan=2>A&ccedil;&atilde;o</th>
			</tr>
	{foreach from=$lista item=r }
			<tr>
            	<td>{$r.id}</td>
                <td>{$r.ocorrencia}</td>
                <td>{$r.cargo}</td>
                <td>{$r.descricao}</td>
                <td>{$r.data_cadastro}</td>
                <td>{$r.hora_cadastro}</td>
               
				<td><a href="?pg=aprovarOcorrencia&id={$r.id}">Aprovar</a></td>
				<td><a href="?pg=editarOcorrencia&id={$r.id}&ocorrencia={$r.ocorrencia}&cargo={$r.cargo}&idCargo={$r.idCargo}&descricao={$r.descricao}"><img src='imagens/edita.png' title='editar'/></a></td>
             </tr>
	{/foreach}

		</table>
</div>	
