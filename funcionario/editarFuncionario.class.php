<script type="text/javascript" src="ajax/listaCidades.js"></script>
<?php

//include_once("conexao/conexao.class.php");

class EdicaoFuncionario {

    private $id;
    private $conn;
    private $nome;
    private $foto;
    private $cargo;
    private $cpf;
    private $email;
    private $superior;
    private $fone1;
    private $logradouro;
    private $numero;
    private $complemento;
    private $uf;
    private $municipio;
    private $bairro;
    private $nascimento;
    private $admissao;

    function __construct() {
        $this->conn = new connection;
    }

    function formata_data($data) {
        list($ano, $mes, $dia) = explode("-", $data);
        return $dia . "/" . $mes . "/" . $ano;
    }

    function removeMascaraTel($v) {

        $v1 = removeMascaraTel($v);
        return $v1;
    }

    function removeMascaraCpf($c) {

        $vf = removeCpf($c);
        return $vf;
    }

    function frmEdicao($id) {
        
     if($_SESSION["tipo"]!=0){   
        if (empty($id)) {
            $this->id = $_SESSION["func_id"];
        } else {
            $this->id = $id;
        }

        $listaDados = $this->conn->query("SELECT F.id,F.nome,F.foto,F.pis,F.email,F.complemento,F.bairro,F.salario,F.logradouro,F.sexo,F.superior_id,F.cpf,F.data_nascimento,
                                          F.data_admissao,F.fone1,F.fone2,C.id AS idCargo,C.nome AS cargo,M.id AS idMunc,M.nome AS municipio,E.id AS idUf,E.nome AS estado 
                                          FROM funcionario AS F INNER JOIN municipio AS M ON F.municipio_codigo=M.id 
                                         INNER JOIN cargo AS C ON F.cargo_id=C.id  INNER JOIN estado AS E ON E.id=estado_uf  WHERE F.id=$this->id AND F.empresa_id=$_SESSION[empresaId] AND  F.ativo=0");
     }else{
         $listaDados = $this->conn->query("SELECT F.id,F.nome,F.foto,F.pis,F.email,F.complemento,F.bairro,F.logradouro,F.sexo,F.superior_id,F.cpf,F.data_nascimento,
                                          F.data_admissao,F.fone1,F.fone2,C.id AS idCargo,C.nome AS cargo,M.id AS idMunc,M.nome AS municipio,E.id AS idUf,E.nome AS estado 
                                          FROM funcionario AS F INNER JOIN municipio AS M ON F.municipio_codigo=M.id 
                                         INNER JOIN cargo AS C ON F.cargo_id=C.id  INNER JOIN estado AS E ON E.id=estado_uf  WHERE F.id=$id AND  F.ativo=0");
     }
        $row = $listaDados->fetch(PDO::FETCH_OBJ);


        $sqlsup = $this->conn->query("SELECT F.id,F.nome,C.nome as cargo FROM funcionario AS F INNER JOIN cargo AS C ON F.cargo_id=C.id  WHERE F.id=$row->superior_id ");

        $super = $sqlsup->fetch(PDO::FETCH_OBJ);

        echo "<h3>Atualizar Dados do Funcionario</h3>
      
       <div id='formularios'>
       <a href='javascript:history.go(-1)'>Voltar</a>
         <form method='post' action='#' enctype='multipart/form-data'>
          <fieldset>
           <table>
             <tr>
                <td>
                    <input type='hidden' name='cliEmpresa' value='$_SESSION[empresaId]' id='cliEmpresa'/>
                    <input type='hidden' name='codigo' value='$row->id'/></td>
               </tr>
               <tr>
                    <td>Nome:</td>
                    <td><input type='text' name='nome' value='$row->nome'/></td>
              </tr>
                    <td>Sexo:</td>
                    <td>
                        <select name='sexo'>
                            <option >$row->sexo</option>
                            <option >M</option>
                            <option >F</option>  
                        </select>
                    </td>
               <tr>
                    <td> Nascimento:</td>
                    <td><input type='text' name='data_nasc' value='" .  formata_data($row->data_nascimento) . "' class='data'/> </td>
                </tr>
                <tr>
                 <td>Cpf:</td>
                 <td><input type='text' name='cpf' value='$row->cpf'  onkeypress='return valCPF(event,this);return false;' maxlength='14'/></td>
              </tr>
               <tr>
                 <td>PIS:</td>
                 <td><input type='text' name='pis' value='$row->pis' /></td>
              </tr>
              <tr>
                    <td>Salário R$:</td>
                 <td><input type='text' name='salario' value='".$row->salario."' id='valor' onKeyPress=return(MascaraMoeda(this,'.',',',event))  maxlength='15'  placeholder='Digite o valor do veiculo' title='digite o valor do salario' required/></td>
                     
               </tr>
               <tr>";
        
        echo "<td>Cargo:</td>
                    <input type='hidden' name='copiaCargo' value='$row->idCargo'/>
                <td><select name='cargo' onchange='selecionaPerfil()' id='perfil'>
                      <option  value='$row->idCargo'>$row->cargo</option>";
             if($_SESSION["tipo"]==1){
                 if($_SESSION["func_id"]!=$id){
                   echo "   <option value='2'>Administrador</option>
                            <option value='3'>Gerente de Vendas</option>
                            <option value='4'>Gerente de TeleMarketing</option>
                            <option value='5'>Operador de Telemarketing</option>
                            <option value='6'>vendedor</option>";              
                    }
             }    
              echo "</td>
              </tr>
              <tr>
                    <td>Admissão :</td>
                    <td><input type='text' name='data_crenden' value='" . formata_data($row->data_admissao). "' class='data'  /></td>
                </tr>

              
              <tr>
                 <td>Foto:</td>
                 <td><input type='file' name='foto' id='foto' value='$row->foto'/></td>
              </tr>
              <tr>";
        //se funcionaro nao for administrador,ou seja se ele for gerente por exemplo      
        if($_SESSION["tipo"]>2){ 
        echo "<td>Superior:</td>
                 <td><select name='superior' id='retornaPerfil'>
                        <option value='$super->id' >$super->nome($super->cargo)</option>
                      </select>
                   </td>";
        }elseif($_SESSION["tipo"]<=2 AND $_SESSION["func_id"]!=$id  ) {
          echo "   <input type='hidden' name='superior'  value='$super->id'/>";
          echo "   <td>Superior:</td>
                   <td><select name='superior_id' id='retornaPerfil'>
                            <option value='$super->id' >$super->nome($super->cargo)</option>  
                       </select>
                   </td>";
  
        } 
         echo "</tr>
              
              <tr>
                 <td>Fone 1:</td>
                 <td><input type='text' name='telFixo' value='$row->fone1'  onkeypress='return valPHONE(event,this);return false;'  maxlength='13'/></td>
               </tr>
               <tr>
                 <td>Fone 2:</td>
                 <td><input type='text' name='fone2' value='$row->fone2'  onkeypress='return valPHONE(event,this);return false;'  maxlength='13'/></td>
               </tr>
               <tr>
                 <td>Email:</td>
                 <td><input type='email' name='email' value='$row->email'/></td>
                </tr> 
                <tr>
                    <td>Logradouro:</td>
                    <td><input type='text' name='logradouro' value='$row->logradouro'/></td>
                </tr>
                
              
                <tr>
                    <td>Complemento:</td>
                    <td><input type='text' name='complemento' value='$row->complemento'/></td>
                </tr>
                <tr>
                    <td>Uf:</td>
                    <td><select name='uf' id='uf' onchange='listaCidades()'>
                          <option value='$row->idUf'>$row->estado</option>
                         </select>
                    </td>
                </tr>
                <tr>
                    <td>Municipio:</td>
                    <td><select name='mun'  id='municipio'>
                          <option value='$row->idMunc'>$row->municipio</option>
                         </select>
                    </td>
                </tr>
                <tr>
                    <td>Bairro:</td>
                    <td><input type='text' name='bairro' value='$row->bairro'/></td>
                </tr>
                
                  <tr>
                  <td><input type='submit' name='atualizar' value='Atualizar' class='botao'/</td>
                </tr>
                       
                 
                 
                 
                 
            </table>
           </fieldset> 
          </form>
          
        </div>";
        if (isset($_POST['atualizar'])) {
            $this->atualizaFuncionario($_POST['codigo'], $_POST['nome'], $_FILES['foto']['name'], $_POST['copiaCargo'],$_POST['cargo'], $_POST['cpf'], $_POST['pis'], $_POST['email'], $_POST['superior'], $_POST['telFixo'], $_POST['fone2'], $_POST['logradouro'], $_POST['complemento'], $_POST['uf'], $_POST['mun'], $_POST['bairro'], $_POST['data_nasc'], $_POST['data_crenden'], $_POST['sexo'], $_POST['salario']);
        }
    }

    function atualizaFuncionario($id, $nome, $foto,$copiaCargo, $cargo, $cpf,$pis,$email, $superior, $fone1,$fone2, $logradouro,  $complemento, $uf, $municipio, $bairro, $nascimento, $admissao,$sexo,$salario) {
       
      
        
        $this->id = $id;

        $this->nome = $nome;
        $this->foto = $foto;
        $this->cargo = $cargo;
        $this->cpf = $this->removeMascaraCpf($cpf);
        $this->pis=$pis;
        $this->email = $email;
        $s  = removeMascaraNum($salario);
        if(!empty($_POST["superior_id"])){
            $this->superior = $_POST["superior_id"];
        }else{
             $this->superior = $superior;    
        }
        
        $this->fone1 = $this->removeMascaraTel($fone1);
        $this->fone2 = $this->removeMascaraTel($fone2);
        $this->logradouro = $logradouro;
        $this->complemento = $complemento;
        $this->uf = $uf;
        $this->municipio = $municipio;
        $this->bairro = $bairro;
        if(!empty($nascimento)){
             if($_POST["data_nasc"]!=$nascimento){
                  $this->nascimento = formata_data_db($nascimento);
              }else{
                    $this->nascimento = $nascimento; 
            }
        }    
       if(!empty($admissao)){
           if($_POST["data_crenden"]!=$admissao){
                $this->admissao = formata_data_db($admissao); 
            }else{
                $this->admissao = $admissao;
            }
       }    
        $data_criacao = date("Y-m-d");
        $hora_criacao = date("H:i:s");
        
    try{
            
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
       $this->conn->beginTransaction();
        //nao modificou o cargo
        if($copiaCargo==$cargo){
           
            $alteracao = $this->conn->exec("UPDATE funcionario SET nome='$this->nome',salario=$s,cpf='$this->cpf',foto='$this->foto',sexo='$sexo',
                                            email='$this->email',fone1='$this->fone1',logradouro='$this->logradouro',
                                            complemento='$this->complemento',municipio_codigo='$this->municipio',
                                            bairro='$this->bairro',data_nascimento='$this->nascimento',data_admissao='$this->admissao' ,
                                            pis='$this->pis' WHERE id=$this->id AND  empresa_id=$_SESSION[empresaId] AND ativo=0") or die("UPDATE funcionario SET nome='$this->nome',salario=$s,cpf='$this->cpf',foto='$this->foto',sexo='$sexo',
                                            email='$this->email',fone1='$this->fone1',logradouro='$this->logradouro',
                                            complemento='$this->complemento',municipio_codigo='$this->municipio',
                                            bairro='$this->bairro',data_nascimento='$this->nascimento',data_admissao='$this->admissao' ,
                                            pis='$this->pis' WHERE id=$this->id AND  empresa_id=$_SESSION[empresaId] AND ativo=0");
        }else{
          //alterou o cargo  
            //descobre o id do cargo
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
            
                    $alteracao2=$this->conn->exec("INSERT INTO funcionario(nome,sexo,data_nascimento,data_admissao,logradouro,fone1,fone2,email,complemento,bairro,foto,
                                                 cargo_id,empresa_id,superior_id,data_cadastro,ativo,cpf,pis,municipio_codigo,perfil,usuario_cadastro)
                                           VALUES('$this->nome','$sexo','$this->nascimento','$this->admissao','$this->logradouro','$this->fone1',
                                                  '$this->fone2','$this->email','$this->complemento','$this->bairro','$this->foto',$row->id,$_SESSION[empresaId],$this->superior,
                                                  '$data_criacao',0,'$this->cpf','$this->pis',$this->municipio,$cargo,$_SESSION[func_id])") or die("deu erro");
          // }
            if($alteracao2){
                //excluir o funcionario na funcao antigas q ele exercia    
                $this->conn->exec("UPDATE funcionario SET ativo=-1 WHERE id=$this->id");
          
                
            }
        }
         move_uploaded_file($_FILES['foto']['tmp_name'], "imagens/usuario/" . $this->foto = $foto);
            //  $_SESSION['foto']=$this->foto;
      $this->conn->commit();      
           echo "<script type='text/javascript'>
                    alert('Atualização Feita com sucesso');
                    location.href='?pg=listaFuncionario';
                   </script>";
         
    }catch (Exception $e){
       echo "deu erro";
      $this->conn->rollBack();
    }  

 }
}
?>
