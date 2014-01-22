<?php
class  AprovarOcorrencia{
 private $id;
	private $conn;
	
	function __construct() {
		$this -> conn = new connection;
	}
	function lista(){

         $sql=$this->conn->query("SELECT O.id,O.nome AS ocorrencia,O.descricao,O.data_cadastro,O.hora_cadastro,C.nome as cargo,C.id as idCargo
                             FROM ocorrencia AS O INNER JOIN cargo AS C ON C.id=O.cargo_responsavel WHERE O.aprovado=-1 AND O.empresa_id=$_SESSION[empresaId]");
		return $sql;
		
	}
        function listaOcorrenciaPendente(){
                if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 || $_SESSION["tipo"]==2){
                      $cond="";
                }else{
              
                    $cond=" AND (O.usuario_cadastro=$_SESSION[func_id] or O.usuario_cadastro=$_SESSION[func_id]  )";
                } 
         
                      $sql=$this->conn->query("SELECT O.id,O.nome AS ocorrencia,O.descricao,O.data_cadastro,O.hora_cadastro,C.nome as cargo,C.id as idCargo
                                                FROM ocorrencia AS O INNER JOIN cargo AS C ON C.id=O.cargo_responsavel WHERE O.aprovado=0 AND O.empresa_id=$_SESSION[empresaId]");
                
                      return $sql;
		
	}
        public function listaOcorrenciaCargo(){
            if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 || $_SESSION["tipo"]==2){
                      $cond="";
                }else{
                    $cargo=  $this->conn->quer("SELECT id FROM cargo  WHERE nome=$_SESSION[nmcargo]");
                    $l=$cargo->fetch(PDO::FETCH_OBJ);
                    $cond=" AND (O.usuario_cadastro=$_SESSION[func_id] or O.cargo_responsavel=$l->id )";
                } 
         
                      $sql=$this->conn->query("SELECT O.id,O.nome AS ocorrencia,O.descricao,O.data_cadastro,O.hora_cadastro,C.nome as cargo,C.id as idCargo
                                                FROM ocorrencia AS O INNER JOIN cargo AS C ON C.id=O.cargo_responsavel WHERE O.aprovado=0 AND O.empresa_id=$_SESSION[empresaId] $cond");
                      
                      if($sql->rowCount()){
                           return $sql;
                       } else{
                         return "";
                        }
        }
	function ativaOcorrencia($id){
		
		$sql=$this->conn->exec("UPDATE ocorrencia SET aprovado=0 WHERE id=$id AND empresa_id=$_SESSION[empresaId]");
		if($sql){
			echo "<script type='text/javascript'>
     				 alert('ocorrencia ativada');
      				 location.href='?pg=aprovarOcorrencia';
      			</script>";
		}
	}

}