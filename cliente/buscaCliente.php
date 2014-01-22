<?php

ob_start();

class Busca {

    private $conn;
    public $identificador;
    private $nome;
    private $telefone;
    private $clausula;
    private $pessoa;

    function __construct() {

        $this->conn = new connection;
    }
	
  function pesquisaCliente() {
        //formulario pesquisa cliente com telefone,cpf ou cnpj
    echo "<h3>Inserir Cliente:</h3>
            <div id='busca_cliente'>
            <form action='#' method='post' name='frm' onSubmit='return camposVazios();'>
           <table>
                  <th>Escolha uma das opções:</th>
                 
                    <tr>
                        <td><select name='opcao' id='escolha' onchange='val()'>
                               <option  >Selecione opcão</option>
                               <option value='telefone' >Telefone</option>
                               <option value='cpf' >CPF</option>
                               <option value='cnpj' > CNPJ</option>
                               
                             </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id='painel'></div>
                         </td>
                     </tr>
             </table>
            </form>
		<div class='carta'>
                     <a href='?pg=uploadCliente' title='Insira Arquivos'>Upload de Clientes</a>
		</div>
            </div>";



        if (isset($_POST['busca'])) {//se usuario tiver clicado no botão de busca

            if (isset($_POST['CPF'])) {
                
                $vf=  removeCpf($_POST['CPF']);//variavel $vf recebe a funcao que remove caracteres especiais do cpf e deixando apenas os numeros 
                
                $this->selecionaCpf($vf,'f');//chama a funcao que pode encontrar cliente atraves do cpf
                
            } else if (isset($_POST['cnpj'])) {
                
                $vf=  removeCnpj($_POST['cnpj']); //variavel $vf recebe a funcao que remove caracteres especiais do cnpj e deixando apenas os numeros
                
                $this->selecionaCnpj($vf,'j');// chama a funcao que pode encontrar cliente atraves do cnpj
                
            } else if (isset($_POST['telefone'])) {

                $vf=  removeMascaraTel($_POST['telefone']);//variavel $vf recebe a funcao que remove caracteres especiais do telefone e deixando apenas os numeros
                
                 $this->selecionaTelNome($vf);// chama a funcao que pode encontrar cliente atraves do telefone
            }
        }
    }
 function tipo(){
 	 if($_SESSION['tipo']==0){// se super usuario
		   $this->clausula="";
	 	}else{//  usuario diferente de super
		 	$this->clausula="AND empresa_id=$_SESSION[empresaId]";
		 }
 }
    function selecionaCpf($identificador,$pessoa) {//selecione o cliente a prtir do cpf e o tipo de pessoa

        $this->identificador = $identificador; //seta o cpf
         $this->pessoa= $pessoa; //seta a o tipo de pessoa (fisica ou juridica)
		 
	//gera o a consulta de cliente	pessoa fisica
        $sql = $this->conn->query("select numero_documento,tipo_documento from cliente where numero_documento='$this->identificador' and tipo_pessoa='$this->pessoa' $this->clausula AND ativo=0");

        if ($sql->rowCount()) {//verifica se existe algum registro
            
            header("location:?pg=visita&cpf_Cnpj= $this->numero_documento&pessoa=$this->pessoa");//redireciona para a pagina de visita com as informações do cliente
        } else {

            header("location:?pg=pf&identificador= $this->identificador&pessoa=$this->pessoa");//redireciona para pagina de cadastro
        }
    }

    function selecionaCnpj($identificador,$pessoa) {//selecione o cliente a prtir do cpf e o tipo de pessoa

        $this->identificador = $identificador;//seta o cpf
        
        $this->pessoa = $pessoa;        //seta a o tipo de pessoa (fisica ou juridica)
        
        //gera consulta de cliente pessoa juridica
        $sqlPj = $this->conn->query("select numero_documento,tipo_documento from cliente where numero_documento='$this->identificador' and tipo_pessoa='$this->pessoa' $this->clausula AND ativo=0");

        if ($sqlPj->rowCount()) {//verifica se existe algum registro

           header("location:?pg=visita&cpf_Cnpj=$this->identificador&pessoa=$this->pessoa");//redireciona para a pagina de visita com as informações do cliente        
           
        } else {
            
            header("location:?pg=pf&identificador=$this->identificador&pessoa=$this->pessoa");//redireciona para pagina de cadastro
        }
    }

    function selecionaTelNome($telefone) {//selecione o cliente a prtir do cpf e o tipo de pessoa

     $this->telefone = $telefone;//seta o telefone
     
     //gera consulta cliente
     $sql = $this->conn->query("select nome,fone1,tipo_documento from cliente where  (fone1='$this->telefone' or fone2='$this->telefone') $this->clausula AND ativo=0");

        //se existe registro
        if ($sql->rowCount()){
            
             $l=$sql->fetch(PDO::FETCH_OBJ);
             //se pessoa fisica
             if($l->tipo_documento =='f'){
                 
                 header("location:?pg=listaDeCliente&telefone=$l->fone1");
                             
             } else if ($l->tipo_documento =='j'){
                // header("location:?pg=visitaPj&telefone=$l->fone1");
             }
          } else {
                 
         // header("location:?pg=pf&fone=$this->telefone&nome=$this->nome");
           header("location:?pg=pf&fone=$this->telefone&nome=$this->nome");
        }
    }

}

$obj = new Busca();

$obj->tipo();

$obj->pesquisaCliente();

?>

