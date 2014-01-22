
<script type='text/javascript' src='ajax/listaCidades.js'></script>
<?php
class EdicaoCliente {

	private $id;
	private $conn;
	private $nome;
	private $cpf;
	private $email;
	private $fone1;
	private $fone2;
	private $fone3;
	private $logradouro;
	private $numero;
	private $complemento;
	private $uf;
	private $municipio;
	private $bairro;
	private $nascimento;

	function __construct() {
		$this -> conn = new connection;
	}
        
        //recebe o id e o tipo de pessoa se juridica ou fisica
	function escolha($id, $pessoa) {
                        //seta as atributos
			$this -> id = $id;
			$this -> pessoa = $pessoa;
			$this -> frmEdicao();//chama a funcao que contem o formulario com as informacoes do cliente
		
	}
        //remove a mascara telefone
	function removeMascaraTel($v) {
             $vf= removeMascaraTel($v);
		return $vf;
	}
        //remove a mascara cpf
	function removeMascaraCpf($c) {
		
            $vf=  removeCpf($c);
		return $vf;
	}

    function frmEdicao() {
            //gera a consulta que lista o cliente apartir do  id setado
   $consulta =$this->conn->query("SELECT C.id ,C.tipo_pessoa,C.razao_social,C.sexo,C.nome,C.numero_documento,C.logradouro,C.fone1,C.fone2,C.email,C.bairro,
                                          C.data_nascimento,E.id AS idUF ,E.nome AS estado,M.id AS idMunc,M.nome AS municipio 
                                          FROM cliente AS C INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                          INNER JOIN estado AS E ON E.id=M.estado_uf WHERE C.id=$this->id ");

       $linhas = $consulta -> fetch(PDO::FETCH_OBJ);
        
       echo "<h3>Atualizar Dados do Cliente</h3>
      
       <div id='formularios'>
       <a href='?pg=listaDeCliente'>Voltar</a>
         <form method='post' action='#' >
          <fieldset>
           <table>
             <tr>
                
                <td>Id</td><td><input type='text' name='codigo' value='$this->id' readonly/></td>
               </tr>
               <tr>
                  <td>Nome:</td>
                  <td><input type='text' name='nome' value='$linhas->nome '/></td>
              </tr>";
            echo"<tr>
                <td>Pessoa</td>
                <td><select name='tipo_pessoa'>    ";
            if($linhas->tipo_pessoa=="F" || $linhas->tipo_pessoa=="f"){
                echo "<option value='F'>Fisica</option>
                     <option value='J'>Juridica</option>";        
            }else{
                echo "<option value='J'>Juridica</option>
                     <option value='F'>Fisica</option>";        
          
            }
        echo"</td>
            </tr>";     
         if($linhas->tipo_pessoa=="f" || $linhas->tipo_pessoa=="F" ){       
            
          echo"<tr> 
                <td>Sexo:</td>
                <td><select name='sexo'>";
               if($linhas->sexo=="f" || $linhas->sexo=="F"){ 
                    echo " <option value='$linhas->sexo'>Feminino  </option>
                           <option value='m'>Masculino  </option> ";
                }else{
                    echo " <option value='$linhas->sexo'> Masculino </option>
                            <option value='f'>Feminino  </option> ";
                }
            echo"  </tr>
              
              <tr>
                    <td>Data de Nascimento:</td>
                    <td><input type='text' name='data_nasc' value='" . formata_data($linhas -> data_nascimento) . "' class='data' /></td>
                </tr>
               <tr>
                 <td>Cpf/Cnpj:</td>
                 <td><input type='text' name='numero_documento' value='$linhas->numero_documento'  onkeypress='return valCPF(event,this);return false;' maxlength='14'/></td>
              </tr>
              ";
         }else{
        echo"<tr>
                <td>Razão Social:</td>
                <td><input type='text' name='razao' value='$linhas->razao_social'  /></td>
                </tr>
               <tr>
                 <td>Cnpj:</td>
                 <td><input type='text' name='numero_documento' value='$linhas->numero_documento'  /></td>
              </tr>
              "; 
             
         }   
       echo " <tr>
                 <td>Fone 1:</td>
                 <td><input type='text' name='fone1' value='$linhas->fone1' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'/></td>
               </tr>
               <tr>
                 <td>Fone 2:</td>
                 <td><input type='text' name='fone2' value='$linhas->fone2' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'/></td>
               </tr>
             
               <tr>
                 <td>Email:</td>
                 <td><input type='email' name='email' value='$linhas->email'/></td>
                </tr> 
                <tr>
                    <td>Logradouro:</td>
                    <td><input type='text' name='logradouro' value='$linhas->logradouro'/></td>
                </tr>
                
                
                <tr>
                    <td>Uf:</td>
                    <td><select name='uf' id='uf' onchange='listaCidades()' >
                          <option value='$linhas->idUF'>$linhas->estado</option>";
                            $estado=  $this->conn->query("SELECT id,nome FROM estado WHERE id<>$linhas->idUF");
                            while($rUF=$estado->fetch(PDO::FETCH_OBJ)){
                                echo "<option value='$rUF->id'>$rUF->nome</option>";
                            }
               echo "  </select>
                    </td>
                </tr>
                <tr>
                    <td>Municipio:</td>
                    <td><select name='mun' id='municipio'>
                          <option value='$linhas->idMunc'>$linhas->municipio</option>
                         </select>
                    </td>
                </tr>
                <tr>
                    <td>Bairro:</td>
                    <td><input type='text' name='bairro' value='$linhas->bairro'/></td>
                </tr>
                
                  <tr>
                  <td><input type='submit' name='atualizar' value='Atualizar' class='botao'/</td>
                </tr>
                       
                 
                 
                 
                 
            </table>
           </fieldset> 
          </form>
          
        </div>";
		if (isset($_POST['atualizar'])) {
                    //chama a funcao para ataualizar as informaçoes do cliente
			$this -> atualizaCliente($_POST['codigo'], $_POST['nome'], $_POST['tipo_pessoa'],$_POST['razao'], $_POST['numero_documento'], $_POST['fone1'], $_POST['fone2'], $_POST['email'], $_POST['logradouro'], $_POST['uf'], $_POST['mun'], $_POST['bairro'], $_POST['data_nasc']);
		}
	}

	function atualizaCliente($id,$nome,$tipo_pessoa,$razao,$numero_documento,$fone1, $fone2,$email, $logradouro, $uf, $municipio, $bairro, $nascimento) {
		//seta os atributos
                $this -> id = $id;
		$this -> nome = $nome;

		$this -> numero_documento = $this -> removeMascaraCpf($numero_documento);

		$this -> email = $email;
		$this -> fone1 = $this -> removeMascaraTel($fone1);
		$this -> fone2 = $this -> removeMascaraTel($fone2);
		
		$this -> logradouro = $logradouro;
		$this -> uf = $uf;
		$this -> municipio = $municipio;
		$this -> bairro = $bairro;
		$this -> nascimento = formata_data_db($nascimento);

		$data_criacao = date("Y-m-d");
		$hora_criacao = date("H:i:s");

		
                //executa a consulta com as alterações do cliente
		$alteracao = $this -> conn -> exec("UPDATE   cliente SET nome='$this->nome',tipo_pessoa='$tipo_pessoa',razao_social='$razao',numero_documento='$this->numero_documento',email='$this->email',
                                                    fone1='$this->fone1',fone2='$this->fone2',logradouro='$this->logradouro',municipio_codigo='$this->municipio',bairro='$this->bairro',
                                                     data_nascimento='$this->nascimento',data_cadastro='$data_criacao',hora_cadastro='$hora_criacao',
                                                     usuario_cadastro=$_SESSION[id]
                                         WHERE   id=$this->id AND empresa_id=$_SESSION[empresaId] AND ativo=0") or die("DEU ERRO");
	
                //se aatualização bem sucedidade, redireciona para a paginalistaDecliente
                if ($alteracao) {

			echo "<script type='text/javascript'>
                                alert('Atualização Feita com sucesso');
                                location.href='?pg=listaDeCliente';
                               </script>";
		}
	}

}
?>
