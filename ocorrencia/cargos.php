<?php
class Cargos{
	private $nome;
	private $id;
	private $conn;
	
	function __construct() {
		$this -> conn = new connection;
	}
	function listaCargos(){
		
		$lista=$this->conn->query("SELECT * FROM cargo where  ativo=0 AND (empresa_id=$_SESSION[empresaId] OR empresa_id=3 )  ");
		while($l = $lista-> fetch(PDO::FETCH_OBJ)) {
			$this -> id[] = $l-> id;
			$this -> nome[] = $l-> nome;
			}
	}
	function getId() {
		return $this -> id;
	}

	function getNome() {
		return $this -> nome;
	}
	
	
}

	

?>