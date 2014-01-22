<?php
class EditarOcorrencia{
	private $nome;
	private $id;
	private $conn;
	
	function __construct() {
		$this -> conn = new connection;
	}
	function edicao($id,$nome,$descricao,$responsavel){
		
		$modificar=$this->conn->exec("UPDATE ocorrencia SET nome='$nome', cargo_responsavel=$responsavel, descricao='$descricao' WHERE id=$id AND empresa_id=$_SESSION[empresaId] ");
		if($modificar){
			echo "<script type='text/javascript'>
     							  alert('ocorrencia editada com sucesso');
      								  location.href='?pg=aprovarOcorrencia';
      							</script>";
		}	
	}
}