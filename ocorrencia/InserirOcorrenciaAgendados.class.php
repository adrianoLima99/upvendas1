<?php
class  InserirOcorrenciaAcompanhamento{
 
	private $conn;
	
	
	function __construct() {
		$this -> conn = new connection;
	}
	function lista(){
		echo "SELECT id,nome FROM ocorrencia WHERE ativo=0 AND cliente_sistema=$_SESSION[empresaId]";
	
		
	echo "	<div id='formularios'>
		<fieldset>
			<legend>Adicionar  ocorr&ecirc;ncia Acompanhamento</legend>
				<table>
					<form method='post' action='?pg=inserirOcorrenciaAgendados'>
						<tr>
							<td><input type='text' name=id value='$_GET[id]'></td>
							<td> Ocorr&ecirc;ncia </td>
							<td><select name='ocorrencia required> 
									<option value='' >Seleciona uma ocorr&ecirc;ncia </option>";
							     			$sql=$this->conn->query("SELECT id,nome FROM ocorrencia WHERE ativo=0 AND cliente_sistema=$_SESSION[empresaId]");
							    				while ($l = $sql-> fetch(PDO::FETCH_OBJ)) {
													echo "<option value='$l->id'>$l->id-$l->nome</option>";
												}							
						 echo "</select></td>	
						</tr>	
						<tr>
							<td></td><td><input type='submit' name='enviar' value='Adicionar' class='botao'/></td>
						</tr>
					</form>
				</table>	
		</fieldset>
	</div>";
	
	}
	function setOcorrencia($id,$ocorrencia){
		$exc=$this->conn->query("UPDATE acompanhamento SET id_ocorrencia  WHERE ativo=0 AND cliente_sistema=$_SESSION[empresaId] AND Id_acompanhamento=$id  ");
	}
	

}