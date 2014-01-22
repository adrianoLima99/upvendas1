<?php
include_once "email/enviarEmail.php";
class ResolverOcorrencia {
    private $cliente;
	private $obs;
	private $ocorrencia;
	private $idOcorrencia;
	private $operador; 
	private $produto;
	private $vendedor;
	private $visita;
	private $telefone;
	private $email;
	private $acompanhamento;
	private $agendamento;
	private $conn;

	function __construct() {
		$this -> conn = new connection;
	}
	function frmResolverAcompanhamento($id){
	
	
		$sql=$this->conn->query("SELECT A.id as idAcom,C.nome,C.fone1,C.email,P.nome AS nomeProd,A.visita_id,A.obs,O.id,O.nome AS ocorrencia,F.nome
									FROM acompanhamento AS A INNER JOIN visita AS V ON A.visita_id=V.id								 
										INNER JOIN funcionario  AS F ON F.id=V.operador_id
										INNER JOIN  ocorrencia AS O ON O.id=A.ocorrencia_id
										INNER JOIN cliente AS C ON C.id=V.cliente_id
                                                                                INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
										inner join produto AS P ON P.id=VP.produto_id
									 WHERE A.id=$id AND A.ativo=0 AND F.empresa_id=$_SESSION[empresaId]");
									 
			$l=$sql->fetch(PDO::FETCH_OBJ);
				$this->setCliente($l->nome);
				$this->setObs($l->obs);
				$this->setOcorrencia($l->ocorrencia);
				$this->setIdOcorrencia($l->id);	
				$this->setOperador($l->nomefunc);
				$this->setVisita($l->visita_id);
				$this->setAcom($l->idAcom);
				$this->setProduto($l->nomeProd);
				$this->setTel($l->fone1);
				$this->setEmail($l->email);
								 
	}
	function frmResolverVisita($id){
	
	
		$sql=$this->conn->query("SELECT V.id AS idVis,V.obs,C.nome,C.fone1,C.email,P.nome AS nmProduto,F.nome AS nmFuncionario,O.id,O.nome AS ocorrencia 
                                          FROM  visita AS V INNER JOIN cliente AS C ON V.cliente_id=C.id
                                           INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                            INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                            INNER JOIN produto AS P ON P.id=VP.produto_id
                                            INNER JOIN ocorrencia AS O ON O.id=V.ocorrencia_id
                                             WHERE V.id=$id AND V.ativo=0 AND F.empresa_id=$_SESSION[empresaId]");
									 
			$l=$sql->fetch(PDO::FETCH_OBJ);
				$this->setCliente($l->nome);
				$this->setObs($l->obs);
				$this->setOcorrencia($l->ocorrencia);	
				$this->setIdOcorrencia($l->id);	
				$this->setVendedor($l->nmFuncionario);
				$this->setVisita($l->idVis);
				$this->setProduto($l->nmProduto);
				$this->setTel($l->fone1);
				$this->setEmail($l->email);
				
				
				
				
								 
	}
	function frmResolverAgendamento($id){
	
	
		$sql=$this->conn->query("SELECT  AG.id AS idAg,AC.id AS idAcom,V.id AS idVis,F.nome,F.id,C.id AS idCli,
                                         C.nome as cliente,C.fone1,C.email,O.id AS id_ocorrencia,O.nome AS ocorrencia
                                         FROM  agendamento_visita AS AG INNER JOIN acompanhamento AS AC ON AG.acompanhamento_id=AC.id 
					 INNER JOIN visita AS V ON V.id=AC.visita_id
					 INNER JOIN ocorrencia AS O ON O.id=AG.ocorrencia_id
					 INNER JOIN cliente AS C ON C.id=V.cliente_id
                                         INNER JOIN funcionario AS F ON F.id = V.operador_id	 
                                         WHERE AG.id=$id AND V.ativo=0 AND F.empresa_id=$_SESSION[empresaId]");
									 
			$l=$sql->fetch(PDO::FETCH_OBJ);
				$this->setCliente($l->cliente);
				$this->setOcorrencia($l->ocorrencia);	
				$this->setIdOcorrencia($l->ocorrencia_id);	
				$this->setVisita($l->idVis);
				$this->setTel($l->fone1);
				$this->setEmail($l->email);
				$this->setOperador($l->nome);
				$this->setAcom($l->idAcom);
				$this->setAg($l->idAg);
				
        } 
	function setAg($agendamento){
		$this->agendamento = $agendamento;
	
	}
	function getAg(){
		return $this->agendamento;
	}
	function setIdOcorrencia($idOcorrencia){
		$this->idOcorrencia = $idOcorrencia;
	
	}
	function getIdOcorrencia(){
		return $this->idOcorrencia;
	}
	function setCliente($cliente){
		$this->cliente = $cliente;
	
	}
	function getCliente(){
		return $this->cliente;
	}
	function setEmail($email){
		$this->email = $email;
	
	}
	function getEmail(){
		return $this->email;
	}
	function setTel($telefone){
		$this->telefone = $telefone;
	
	}
	function getTel(){
		return $this->telefone;
	}
	function setVendedor($vendedor){
		$this->vendedor = $vendedor;
	
	}
	function getVendedor(){
		return $this->vendedor;
	}
	function setProduto($produto){
		$this->produto = $produto;
	
	}
	function getProduto(){
		return $this->produto;
	}
	function setOcorrencia($ocorrencia){
		$this->ocorrencia = $ocorrencia;
	}
	function getOcorrencia(){
		return $this->ocorrencia;
	}
	function setObs($obs){
		$this->obs= $obs;
	}
	function getObs(){
		return $this->obs;
	}
	function setOperador($operador){
		$this->operador=$operador;
	}
	function getOperador(){
		return $this->operador;
	}
	function setVisita($visita){
		$this->visita=$visita;
	}
	function getVisita(){
		return $this->visita;
	}
	function setAcom($acompanhamento){
		$this->acompanhamento=$acompanhamento;
	}
	function getAcom(){
		return $this->acompanhamento;
	}
	function enviaEmail($AddAddress, $nomeCliente, $assunto, $mensagem){
			
			if($_POST['tabela']=="visita"){
					
				$tab="visita";
				
				$mensagem="Codigo da Visita:".$this->getVisita()."<br/>Codigo Ocorrencia:".$this->getIdOcorrencia()."<br/>Cliente:".$this->getCliente()."<br/>Produto:".$this->getProduto()."<br/><br>$_POST[obs]";
				
			}else if($_POST['tabela']=="acompanhamento"){
					
				$tab="acompanhamento";
				
				$mensagem="Codigo da Acompanhamento:".$this->getAcom()."<br/>Codigo Ocorrencia:".$this->getIdOcorrencia()."<br/>Cliente:".$this->getCliente()."<br/>Produto:".$this->getProduto()."<br/>$_POST[obs]";
			}else if($_POST['tabela']=="agendamento_visita"){
					
				$tab="agendamento_visita";
				
				$mensagem="Codigo da Agendamento:".$this->getAg()."<br/>Codigo Ocorrencia:".$this->getIdOcorrencia()."<br/>Cliente:".$this->getCliente()."<br/>$_POST[obs]";
				
			}
						
		$acompanhamento=$this->getAcom();
		
		$atualizar=$this->conn->query("UPDATE $tab SET statusOcorrencia=0, ocorrencia_id=0 WHERE ativo=0 AND  id=$_POST[id_tabela]")or die("erro");
	    
	if($atualizar){
		
		$tabela=$_POST['tabela'];
		$id_tabela=$_POST['id_tabela'];
		$data_insercao = date('Y-m-d');
		$hora_insercao = date('H:i:s');
		//se email diferente vazio
		if(!empty($AddAddress)){
                  email($AddAddress, $nomeCliente, $assunto, $mensagem);
                }
              
		$ocorremcia_feita=$this->conn->exec("INSERT INTO ocorrencia_realizada(tabela,tabela_id,data,hora,usuario_cadastro) 
							VALUES('$tabela',$id_tabela,'$data_insercao','$hora_insercao',$_SESSION[id]) ")or die("erro");
		if($ocorremcia_feita){
                 if($tabela=="visita"){
                     echo "<script type='text/javascript'>
					alert('Ocorrencia Finalizada')
					  location.href='?pg=visitados';
					</script>";
        
                 }elseif($tabela=="acompanhamento"){
                     echo "<script type='text/javascript'>
					alert('Ocorrencia Finalizada')
					  location.href='?pg=acompanha';
					</script>";
        
                     
                 }elseif($tabela=="agendamento_visita"){
                            echo "<script type='text/javascript'>
					alert('Ocorrencia Finalizada')
					  location.href='?pg=agendamento';
					</script>";
        
                 }    
              }
            }
	}
	
}