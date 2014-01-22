<?php
  class Edicao{
  	function __construct() {
		$this -> conn = new connection;
	}
		function editarOcorrencia($id){
		$sql=$this->conn->query("SELECT * FROM ocorrencia WHERE id=$id ");
		
	}
  }


?>

	<div id="formularios">
	<fieldset>
		<legend>Cadastrar Nova Ocorr&ecirc;ncia	</legend>
			<table>
				<form action="?pg=salvaOcorrencia" method="post">
					<tr>
						<td>Ocorrencia</td>
						<td><input type="text" name="ocorrencia"/></td>
					</tr>
					<tr>
						<td>Descricao</td>
						<td><textarea name="descricao" cols="40" rows="20">
							</textarea>	
						</td>
					</tr>
					<tr>
						<td>Responsavel:</td>
						<td><select name="responsavel" >
								{html_options  values=$id output=$nome}
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="cadastrar" name="cadastrar" class="botao"/></td>
					</tr>
			
				</form>

			</table>
	</fieldset>
</div>



