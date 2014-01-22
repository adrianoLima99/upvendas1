<?php
include_once "email/enviarEmail.php";
//ini_set('default_charset','UTF-8');

class SalvarEmpresa{
	private $nome;
	private $razaoSocial;
	private $cnpj;
	private $responsavel;
	private $endereco;
	private $telefone;
	private $municipio;
	private $complemento;
	private $numero;
	private $bairro;
	private $usuario;
        private $senha;
	private $conn;
	
	function __construct(){
            
            $this->conn = new connection();  
        }
  
	function setCnpj($cnpj){
		if(!empty($cnpj)){
			$this->cnpj = removeCnpj($cnpj);	
		}else{
			$this->cnpj = 0;
		}
		
	}
	
	function setNome($nome){
	
		  $this->nome = $nome;	
	}
        function setResponsavel($responsavel){
	
		  $this->responsavel = $responsavel;	
	}
	function setRazao($razaoSocial){
		
		  $this->razaoSocial = $razaoSocial;
	}
	
	/*function setlogin($login){
		
		  $this->login = $login;
	}*/
	
	function setEndereco($endereco){
		
		 $this->endereco=$endereco;
	}
	function setTelefone($telefone){
		if(!empty($telefone)){
                    $this->telefone=  removeMascaraTel($telefone);
                }else{
                    $this->telefone=$telefone;
                }
		 
	}
	function setEmail($email){
		
		 $this->email=$email;
	}
	function setMunicipio($municipio){
		
		 $this->municipio=$municipio;
	}
        function setUsuario($usuario){
		
		 $this->usuario=$usuario;
	}
        function setSenha($senha){
		
		 $this->senha=hash("SHA512","$senha");
	}
	
	function setComplemento($complemento){
		
		 $this->complemento=$complemento;
	}
	function setNumero($numero){
		if(!empty($numero)){
			$this->numero=$numero;	
		}else{
			$this->numero=0;	
		}
		 
	}
	function setBairro($bairro){
		
		 $this->bairro=$bairro;
	}
	
	public function salvar(){
		$data=date('Y-m-d');
		$hora=date('H:m:i');
		$nascimento="0000-00-00";
	//se passou for diferente de vazio enta ele é empreendedor individual	
	
      try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();

 
           //executa a insercao dos registros
           $gravar= $this->conn->exec("INSERT INTO empresa(nome,razao_social,cnpj,responsavel,logradouro,numero,bairro,complemento,email,fone,data_cadastro,hora_cadastro,municipio_codigo,ativo)
                         		   VALUES('$this->nome','$this->razaoSocial','$this->cnpj','$this->responsavel','$this->endereco',$this->numero,'$this->bairro','$this->complemento','$this->email','$this->telefone','$data','$hora',$this->municipio,0)") or die("erro empresa");
        	
       
	
           if ($gravar){//se insercao de empresa bem sucedida 
               //executa a consulta para pega o ultimo id inserido
               $select=  $this->conn->query("SELECT id FROM empresa WHERE ativo=0 ORDER BY id DESC LIMIT 1");
                
               $ultimoEmpresa=$select->fetch(PDO::FETCH_OBJ);//recebe o ultimo id inserido
                //executa a insercao de funcionario com funcao de master
                 $adm=$this->conn->exec("INSERT INTO funcionario(nome,logradouro,bairro,complemento,municipio_codigo,cargo_id,empresa_id,ativo,perfil) 
                                        VALUES('$this->responsavel','$this->endereco','$this->bairro','$this->complemento',$this->municipio,1,$ultimoEmpresa->id,0,1)")or die("erro funcionario");
                
                if($adm){//se insercao de funcionario master bem sucedida
                    //executa a seleção do ultimo funcionario master inserido
                    $selUltimoFunc=$this->conn->query("SELECT id FROM funcionario  WHERE ativo=0 AND cargo_id=1 AND empresa_id=$ultimoEmpresa->id")or die("erro select funconario");
                    
                    $retornaUltimoFunc=$selUltimoFunc->fetch(PDO::FETCH_OBJ);//recebe o id do ultimo funcionario master inserido
                    
                    if($selUltimoFunc){//se seleção for bem sucedida
                       //executa inserção de usuario pra funcionario master
                       $this->conn->exec("INSERT INTO usuario VALUES(null,'$this->usuario','$this->senha',0,$retornaUltimoFunc->id)")or die("erro usuario");
                    }
                       
                }
                
           
            //envia email
            if(!empty($this->email)){
                 $mensagem="Sua empresa foi cadastro com sucesso no UpvendasBrasil!<br/><h2>Empresa:$this->nome</h2><h2> usuario:$this->usuario</h2><h2> Senha:$_POST[senha]</h2>        <p>Link:<a href='http://upvendasbrasil.com.br/login/'>http://upvendasbrasil.com.br/login/</a></p>";
                  email($this->email,$this->nome ,"Cadastro realizado com sucesso", $mensagem);
                
               }
              // move_uploaded_file($_FILES['foto']['tmp_name'], "imagens/usuario/" . $_FILES['foto']['name']);
              $this->conn->commit();
              
               if(!empty($this->email)){//se atributo email for preenchido
                echo "<script type='text/javascript'>
                          alert('Empresa cadastrado com sucesso e Um e-mail foi enviado ');
                          location.href='?pg=pesquisa';
      			</script>";
                }else{
                 echo "<script type='text/javascript'>
     			  alert('Empresa cadastrado com sucesso  ');
                         location.href='?pg=pesquisa';
                       </script>";
                }
            }
        }catch (Exception $e){
              
                 echo "Não foi possivel fazer seu cadastro, entre em contato com o administrador!";
                 //desfaz as operacoes de sql realizada  
                 $this->conn->rollBack();
         }   
    }
}

	$obj = new SalvarEmpresa();
	$obj->setNome($_POST['empresa']);
	$obj->setCnpj($_POST['cnpj']);
	$obj->setRazao($_POST['razao']);
        //$obj->setLogo($_FILES['foto']['name']);
        $obj->setEmail($_POST['email']);
        $obj->setEndereco($_POST['endereco']);  
        $obj->setResponsavel($_POST["responsavel"]);
        $obj->setComplemento($_POST['complemento']);
        $obj->setNumero($_POST['numero']);
        $obj->setMunicipio($_POST['cidade']);
        $obj->setBairro($_POST['bairro']);
        $obj->setTelefone($_POST['tel']);
        $obj->setUsuario($_POST['usuario']);
        $obj->setSenha($_POST['senha']);
        $obj->salvar();
        

?>