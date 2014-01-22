<?php
class  SalvarCargo{
	private $cargo;
	private $conn;
	
	function __construct() {
		$this -> conn = new connection;
	}
	function setCargo($cargo){
		$this->cargo = $cargo;
	}
	function getCargo(){
		return $this->cargo;
	}
	function salvar(){
	
   	    	
   		$nome=$this->getCargo();
                $consCargo=$this->conn->query("SELECT nome FROM cargo WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 AND nome='$nome'");
                if($consCargo->rowCount()){
                    echo "<script type='text/javascript'>
     				 alert('Cargo ja foi cadastrado ');
      				 location.href='?pg=pesquisa';
                        </script>";
                }else{
                    $sql=$this->conn->exec("INSERT INTO cargo(nome,empresa_id,ativo) VALUES('$nome',$_SESSION[empresaId],0) ")or die("erro");
		
                	if($sql){
			echo "<script type='text/javascript'>
     							  alert('Cargo cadastrado com sucesso');
      								 location.href='?pg=pesquisa';
      							</script>";
		}
                }
		
	}
}