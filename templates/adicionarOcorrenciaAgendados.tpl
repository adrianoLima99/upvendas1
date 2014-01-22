<div id="formularios">
		<fieldset>
			<legend>Adicionar  ocorr&ecirc;ncia Agendamento</legend>
				<table>
					<form method="post" action="?pg=inserirOcorrenciaAgendados">
						<tr>
							<td>Cargo</td><td>
								<select name="ocorrencia" required> 
								<option value="" >Seleciona uma ocorr&ecirc;ncia </option>
							     {html_options  values=$id output=$id$nome}
								</select>
							</td>	
						</tr>	
						<tr>
							<td></td><td><input type="submit" name="enviar" value="Adicionar" class="botao"/></td>
						</tr>
					</form>
				</table>	
		</fieldset>
	</div>
