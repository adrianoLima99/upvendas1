	<div id="formularios">
		<fieldset>
			<legend>Resolver  ocorr&ecirc;ncia Visita</legend>
				<table>
					<form method="post" action="#">
						
						<tr>
							<td>Codigo Visita</td>
							<input type="hidden"  value="visita" name="tabela"/>
							<td><input type="text" readonly value="{$visita}" name="id_tabela"/></td>	
						</tr>
						<tr>
							<td>Vendedor</td>
							<td><input type="text" readonly value="{$vendedor}" name="vendedor"/></td>	
						</tr>
						<tr>
							<td>Cliente</td>
							<td><input type="text" readonly value="{$cliente}"  name="cliente"/></td>	
						</tr>
						<tr>
							<td>Produto</td>
							<td><input type="text" readonly value="{$produto}" name="produto"/></td>	
						</tr>
						<tr>
							<td>Telefone Cliente</td>
							<td><input type="text" readonly value="{$telefone}" name="telefone"/></td>	
						</tr>
						<tr>
							<td>Email Cliente</td>
							<td><input type="text" readonly value="{$email}" name="email"/></td>	
						</tr>
						<tr>
							<td>Ocorrencia</td>
							<input type="hidden" readonly value="{$idOcorrencia}" name="ocorrencia"/>
							<td><input type="text" readonly value="{$idOcorrencia}-{$ocorrencia}"  /></td>	
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
             <a href="?pg=visitados">Voltar</a>                                   
	</div>
