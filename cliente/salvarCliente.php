<?php

ob_start();

class SalvarCliente {

    private $pessoa;
    private $email;
    private $nome;
    private $sexo;
    private $cpf_Cnpj;
    private $nascimento;
    private $endereco;
    private $cidade;
    private $uf;
    private $fonefixo;
    private $cel1;
    private $cel2;
    private $conn;
    private $sql;

    function __construct() {
        $this->conn = new connection;
    }

    function pessoa($pessoa, $nome,$razao, $sexo, $cpf_Cnpj, $nascimento,$telefonia, $endereco, $bairro, $cidade, $uf, $fonefixo, $cel1) {
     //seta os atributos
        $clienteSist = $_SESSION['empresaId'];
        $this->sexo = $sexo;

        $this->pessoa = $pessoa;

        $this->nome = $nome;
        $this->cpf_Cnpj = $cpf_Cnpj;
        if (!empty($nascimento)) {
            $this->nascimento = formata_data_db($nascimento);
        } else {
            $this->nascimento = "0000-00-00";
        }

        $this->endereco = $endereco;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->fonefixo = $fonefixo;
        $this->cel1 = $cel1;
       
        $data_criacao = date("Y-m-d");
        $hora_criacao = date("H:i:s");
       
        
        $this->sql = $this->conn->exec("INSERT INTO cliente VALUES(null,'$this->nome','$razao','$this->sexo','$this->nascimento','$this->endereco',
                                        '',$telefonia,'$this->fonefixo','$this->cel1','$this->pessoa','$this->cpf_Cnpj','$this->bairro','$this->email',
                                         '$this->pessoa','$data_criacao',' $hora_criacao ',0,$clienteSist,$_SESSION[id],$this->cidade)") or die("erro");

        //se inserção for bem sucedida , redireciona para a pagina de visita ,passando o id eo tipo de pessoa(Fisica ou Juridica)
        if ($this->sql) {

            $ultimaInsercao = $this->conn->query("SELECT id FROM cliente WHERE ativo=0 AND usuario_cadastro=$_SESSION[id] order by id desc LIMIT 1");
            $id = $ultimaInsercao->fetch(PDO::FETCH_OBJ);

          echo "<script type='text/javascript'>
                               alert('cliente cadastrado com sucesso')
                               location.href='?pg=visita&id=$id->id&pessoa=$_POST[pessoa]'
                     </script>";
          
            
        }
    }

}

$obj = new SalvarCliente;
if ($_POST['pessoa'] == 'f') {
    //remove mascra do cpf
    $vf = removeCpf($_POST['cpf']);

    if (!empty($_POST['telefone'])) {
        //remove mascara do telefone fixo
        $vtf = removeMascaraTel($_POST['telefone']);
    } else {
        $vtf = '';
    }

    if (!empty($_POST['cel1'])) {
        //remove mascara do celular 1

        $vcf = removeMascaraTel($_POST['cel1']);
    } else {
        $vcf = '';
    }
   
    //chama metodo para inserir novo cliente pessoa fisica 
        $obj->pessoa($_POST["pessoa"], $_POST["nome"],"", $_POST["sexo"], $vf,$_POST["nasc"],$_POST["opTelefonia"],$_POST["end"], $_POST["bairro"],$_POST["cid"], $_POST["uf"],$vtf, $vcf);
} else {
    //remove a mascara
    $vf = removeCnpj($_POST['cnpj']);

    if (!empty($_POST['telefone'])) {
        //remove mascara do telefone fixo
        $vtf = removeMascaraTel($_POST['telefone']);
    } else {
        $vtf = '';
    }

    if (!empty($_POST['cel1'])) {
        //remove mascara do celular 1
        $vcf = removeMascaraTel($_POST['cel1']);
    } else {
        $vcf = '';
    }
   
    //chama metodo para inserir novo cliente pessoa juridica
    $obj->pessoa($_POST["pessoa"], $_POST["nome"],  $_POST["razao"],"", $vf,"",$_POST["opTelefonia"],$_POST["end"], $_POST["bairro"], $_POST["cid"], $_POST["uf"], $vtf, $vcf);
}
?>