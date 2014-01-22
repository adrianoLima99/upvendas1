<?php

//include_once "mascara/removeMascara.php";


class AdicionarFuncionario {

    private $perfil;
    private $nome;
    private $sexo;
    private $foto;
    private $identificador;
    private $pis;
    private $superior;
    private $fone1;
    private $fone2;
    private $email;
    private $logradouro;
    private $numero;
    private $complemento;
    private $uf;
    private $municipio;
    private $bairro;
    private $data_nasc;
    private $data_crenden;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function adicionar($cargo, $nome, $sexo, $identificador,$pis, $foto, $superior, $fone, $email, $logradouro, $numero, $complemento, $uf, $municipio, $bairro, $data_nasc, $data_crenden) {

        $this->sexo = $sexo;
        $this->cargo = $cargo;
        $this->identificador = $identificador;
         $this->pis=$pis;
        $this->nome = $nome;

        $this->foto = $foto;
        //se o cargo for 2 , ele sera o administrador, entao o superior sera Empresa		
        if(empty($superior)){
            $consulta=$this->conn->query("SELECT id FROM funcionario  WHERE perfil=0 AND ativo=0");
             $exibir=$consulta->fetch(PDO::FETCH_OBJ);
               $this->superior =$exibir->id;
        }else{ 
            $this->superior =$superior;    
        }
        if (!empty($fone)) {
            $this->fone1 = removeMascaraTel($fone);
        } else {
            $this->fone1 = $fone;
        }

        $this->email = $email;
        $this->logradouro = $logradouro;
        if (empty($numero)) {
            $this->numero = 0;
        } else {

            $this->numero = $numero;
        }

        $this->complemento = $complemento;
        $this->uf = $uf;

        $this->municipio = $municipio;
        $this->bairro = $bairro;
        if (!empty($data_nasc)) {
            $this->data_nasc = formata_data_db($data_nasc);
        } else {
            $this->data_nasc = "0000-00-00";
        }
        if (!empty($data_crenden)) {
            $this->data_crenden = formata_data_db($data_crenden);
        } else {
            $this->data_crenden = "0000-00-00";
        }

        $data_criacao = date("Y-m-d");
       // $id_criador = $_SESSION['id'];
        if($_SESSION["tipo"]==0){
        $empresa = $_POST['cliEmpresa'];
            
        }else{
        $empresa = $_SESSION['empresaId'];
            
        }    
            
        
         if($cargo==1){
             
             $nome="administrador master";
        }elseif($cargo==2){
                $nome="administrador";
         
        }elseif($cargo==3){
               $nome="gerente de vendas";
        }elseif($cargo==4){
               $nome="gerente de telemarketing";
        }elseif($cargo==5){
               $nome="operador de telemarketing";
        }elseif($cargo==6){
               $nome="vendedor";
         }
        $sqlCargo=$this->conn->query("SELECT id FROM  cargo WHERE ativo=0 AND nome='$nome'");
        $row=$sqlCargo->fetch(PDO::FETCH_OBJ);
       
        
        $this->perfil = $cargo;
    
        $novoFunc = $this->conn->exec("INSERT INTO funcionario(nome,sexo,data_nascimento,data_admissao,logradouro,fone1,fone2,email,complemento,bairro,foto,
                                                                 cargo_id,empresa_id,superior_id,data_cadastro,ativo,pis,cpf,municipio_codigo,perfil,usuario_cadastro)
                                                       VALUES('$this->nome','$this->sexo','$this->data_nasc','$this->data_crenden','$this->logradouro','$this->fone1',
                                                               '$this->fone2','$this->email','$this->complemento','$this->bairro','$this->foto',$row->id,$empresa,$this->superior,
                                                                '$data_criacao',0,'$this->pis','$this->identificador',$this->municipio,$this->perfil,$_SESSION[id])") or die("deu erro");

        if ($novoFunc) {
               //seleciona administrador que foi atribui supoerior
            
             /*   $sup=$this->conn->query("SELECT id,nome FROM funcionario WHERE perfil=2 AND empresa_id=$empresa ORDER BY id DESC LIMIT 1"); 
               //inserir 1 superior pra ele que sera ele mesmo
                if( $sup->rowCount()){
                    $r=$sup->fetch(PDO::FETCH_OBJ);
                    $this->conn->exec("UPDATE funcionario SET superior_id=$r->id WHERE empresa_id=$empresa AND perfil=2 ");
                }
               */ 
                
               
            move_uploaded_file($_FILES['foto']['tmp_name'], "imagens/usuario/" . $_FILES['foto']['name']);
            echo "<script type='text/javascript'>
     							  alert('Funcionario cadastrado com sucesso');
      								 location.href='?pg=listaFuncionario';
      							</script>";
        }
     
   } 
}

?>
