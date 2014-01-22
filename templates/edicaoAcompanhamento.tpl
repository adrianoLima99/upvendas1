   <div id='formularios'>
            <a href='?pg=agendamento' style='align:center'>Voltar</a>
            <fieldset>
				<legend>Edi&ccedil;&atilde;o de Acompanhamento</legend>
					<form method='post' action='#'>
						<table>
							<tr>
								<td>Id Acompanhamento:</td>
								<td><input type='text' name='id' value='{$smarty.get.idAcom}' readonly/></td>
							</tr>
							<tr>
								<td>Id Visita:</td>
								<td><input type='text' name='visita' value='{$smarty.get.idVis}' readonly/></td>
							</tr>
							<tr>
								<td>Cliente:</td>
								<td><input type='text' name='cliente' value='{$smarty.get.cli}' readonly/></td>
							</tr>
							<tr>
								<td>Operador de Telemarketing:</td>
								<td><input type='text' name='operador' value='{$smarty.get.op}' readonly/></td>
								 
							</tr>
							<tr>
								<td>Obs:</td>
								<td><textarea name='obs' cols="33" rows="10">{$smarty.get.obs}</textarea></td>
							</tr>	
							<tr>
								<td></td><td><input type='submit' name='enviar' value='salvar' class='botao'/></td>
							</tr>
						</table>
					</form>
			</fieldset>
	</div>