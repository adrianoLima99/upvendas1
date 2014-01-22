<?php
 Class Comissao{
     private $nome;
     private $cargo_id;
     private $producao;
     private $modeloPagamento;
     private $qtd_parcelas;
     private $val_parcela;
     private  $comissao;
     private $funcionario;
     private $periodo1;
     private $periodo2;
     private $subordinado;
     private $tipo;
     private $data;
     private $hora;
     private $conn;
    
    function __construct() {
        $this->conn = new Connection();
    }
    
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function setComissao($comissao){
        $this->comissao = $comissao;
    }
    public function setCargo($cargo_id){
        $this->cargo_id = $cargo_id;
    }
    public function setFuncionario($funcionario){
       if(!empty($funcionario)){
           $this->funcionario = $funcionario;
       }else{
          $this->funcionario =0;
       }
    }
    public function setProducao($producao1,$producao2){
        if(empty($producao2)){
          $this->producao = $producao1."-100000";
        }else{
              $this->producao = $producao1."-".$producao2; 
        }
    }
      public function setModeloPagamento($modeloPagamento){
        $this->modeloPagamento = $modeloPagamento;
    }
    public function setQtdParcelas($qtd_parcelas){
        $this->qtd_parcelas = $qtd_parcelas;
    }
    public function setValParcela($val_parcela){
        $this->val_parcela = $val_parcela;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    
    public function  setSubordinado($subordinado){
        if(!empty($subordinado)){
             $this->subordinado = $subordinado;
        }else{
            $this->subordinado = 0;
        }
    }


    public function getNome(){
        return $this->nome;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function getCargo(){
        return $this->cargo_id;
    }
    public function getProducao(){
        return $this->producao;
    }
    
    public function getModeloPagamento(){
        return $this->modeloPagamento;
    }
    public function getQtdParcelas(){
        return $this->qtd_parcelas;
    }
    public function getValParcela(){
        return $this->val_parcela;
    }
    public function getComissao(){
        return $this->comissao;
    }
    public function getData(){
        $this->data=date("Y-m-d");
        return $this->data;
    }
    public function getHora(){
        $this->hora=date("H:m:s");
        return $this->hora;
    }
    
    public function getFuncionario(){
        return $this->funcionario;
    }
    public function getSubordinado(){
        return $this->subordinado;
    }

  public function cadastra(){//exibe o formulario de cadastro
  echo "<div id='formularios'>
         <fieldset>
          <legend>Nova Comissão</legend>
            <form action='' method='post'>
                <table>
                    <tr>
                        <td>Nome: </td>
                        <td><input type='text' name='nome' /></td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        
                        <td>
                             <input type='hidden' name='cliEmpresa' value='$_SESSION[empresaId]' id='cliEmpresa'/>
                                <select name='cargo' onchange='selecionaCargo()' id='cargo' required>   
                                <option value=''>selecione cargo</option>
                                 <option value='1'>Administrador Master</option>
                                <option value='7'>Administrador</option>
                                <option value='3'>Gerente de Vendas</option>
                                <option value='4'>Gerente de TeleMarketing</option>
                                <option value='5'>Operador de Telemarketing</option>
                                <option value='6'>vendedor</option>
                   </select></td>
                   
                    </tr>
                   <tr>
                       <td>Funcionario</td>
                       <td> <select name='funcionario' id='nomeCargo'>
                                <option></option>
                            </select>
                       </td>     
                    </tr>
                    <tr>
                        <td>Subordinados</td><td><input type='checkbox' name='subordinado' value='1' style='border:0;width:auto'/></td>
                        </td>
                    </tr>
                    <tr>
                        <td>Comissão:</td>
                        <td><select name='tipo'  style='width:50%' required>
                              <option value=''>Selecione</option>
                              <option value='P'>Porcentagem</option>
                              <option value='F'>Fixa</option>
                            </select> 
                            <input type='text' name='comissao' style='width:30%' required/></td>
                    </tr>
                     <tr>
                        <td>Produção:</td>
                        <td><input type='number' name='producao1' style='width:110px'/> A <input type='number' name='producao2' style='width:110px'/></td>
                    </tr>
                      
                    <tr>
                        <td>Modelo de Pagamento:</td>
                        <td>
                            <select name='modelo'>
                                <option value=''>Selecione</option>
                                <option>Escalonado</option>
                                <option>Á vista</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Quantidade de Parcelas:</td>
                        <td><input type='number' name='parcelas'/></td>
                    </tr>
                    <tr>
                        <td>Valor/Parcela(s)(%):</td>
                        <td><input type='text' name='valor'/></td>
                    </tr>
                    <tr>
                        <td></td><td><input type='submit' name='salvar' value='Salvar' class='botao'/></td>
                    </tr>
                </table>
            </form>
            
          </fieldset> 
          <br/>
                    <a href='javascript:history.go(-1)'>Voltar</a>
          </div>  ";  
          if(isset($_POST["salvar"])){
              //seta os atributos
              $this->setNome($_POST["nome"]);
              $this->setProducao($_POST["producao1"],$_POST["producao2"]);
              $this->setCargo($_POST["cargo"]);
              $this->setComissao($_POST["comissao"]);
              $this->setModeloPagamento($_POST["modelo"]);
              $this->setQtdParcelas($_POST["parcelas"]);
              $this->setValParcela($_POST["valor"]);
              $this->setSubordinado($_POST["subordinado"]);
              $this->setFuncionario($_POST["funcionario"]);
              $this->setTipo($_POST["tipo"]);
              $this->salvar();
          }
    }
   //metodo de edicao 
   public function editar($id){
      //consulta  comissao pelo id 
       $sel=  $this->conn->query("SELECT * FROM comissao WHERE id=$id AND ativo=0 AND empresa_id=$_SESSION[empresaId]");
       
       $list=$sel->fetch(PDO::FETCH_OBJ);//recebe o resultado da consulta
       
       $separa=  explode("-",$list->producao);//quebra campo produção em 2 partes
       
       //seleciona o cargo do funcionario
       $cargo=  $this->conn->query("SELECT id,nome FROM cargo WHERE ativo=0 AND id=$list->cargo_id ");
       //recebe o resultado da consulta
       $listCargo=$cargo->fetch(PDO::FETCH_OBJ);
       
       if(!empty($list->funcionario_id)){//se funcionario_id fro diferente de vazio
           //consulta o id e o nome do funcionario
            
           $funcionario=  $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND id=$list->funcionario_id ");
            
            //recebe o resultado da consulta
     
            $listFuncionario=$funcionario->fetch(PDO::FETCH_OBJ);
       
     }
     //exibe o formulario de edição da comissão  
  echo "<div id='formularios'>
         <fieldset>
          <legend>Editar Comissão</legend>
            <form action='#' method='post'>
                <table>
                    <tr>
                        <td>Nome: </td>
                        <td><input type='text' name='nome' value='$list->nome' /></td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        
                        <td>
                             <input type='hidden' name='cliEmpresa' value='$_SESSION[empresaId]' id='cliEmpresa'/>
                                <select name='cargo' onchange='selecionaCargo()' id='cargo' required>   
                                        <option value='$listCargo->id'>$listCargo->nome</option>
                                         <option value='1'>Administrador Master</option>
                                        <option value='7'>Administrador</option>
                                        <option value='3'>Gerente de Vendas</option>
                                        <option value='4'>Gerente de TeleMarketing</option>
                                        <option value='5'>Operador de Telemarketing</option>
                                        <option value='6'>vendedor</option>
                                </select>
                       </td>
                   </tr>
                   <tr>
                       <td>Funcionario</td>
                       <td> <select name='funcionario' id='nomeCargo'>";
                            if(!empty($list->funcionario_id)){//se funcionario_id  for diferente de vazio, lista os resultados da consulta
                                 echo " <option value='$listFuncionario->id'>$listFuncionario->nome</option>";
                            }
                        echo " </select>
                       </td>     
                    </tr>
                    <tr>";
                    if($list->subordinado==1){
                     echo "<td>Subordinados</td><td><input type='checkbox' name='subordinado' value='1' style='border:0;width:auto' checked /></td>";
                    }else{
                      echo "<td>Subordinados</td><td><input type='checkbox' name='subordinado' value='1' style='border:0;width:auto' /></td>";   
                    }
                    echo  "</td>
                    </tr>
                    <tr>
                        <td>Comissão(%):</td>
                        <td><input type='text' name='comissao' value='$list->comissao' /></td>
                    </tr>
                     <tr>
                        <td>Produção:</td>
                        <td><input type='number' name='producao1' style='width:110px' value='$separa[0]' /> A <input type='number' name='producao2' style='width:110px' value='$separa[1]' /></td>
                    </tr>
                      
                    <tr>
                        <td>Modelo de Pagamento:</td>
                        <td><input type='text' name='modelo' value='$list->modeloPagamento'/></td>
                    </tr>
                    <tr>
                        <td>Quantidade de Parcelas:</td>
                        <td><input type='number' name='parcelas' value='$list->qtd_parcelas' /></td>
                    </tr>
                    <tr>
                        <td>Valor/Parcela(s)(%):</td>
                        <td><input type='text' name='valor' value='$list->val_parcela'/></td>
                    </tr>
                    <tr>
                        <td></td><td><input type='submit' name='salvar' value='Salvar' class='botao'/></td>
                    </tr>
                </table>
            </form>
          </fieldset>
          <a href='?pg=listaComissao'>Voltar</a>
          </div>  ";  
          if(isset($_POST["salvar"])){
              //seta os atributos
              $this->setNome($_POST["nome"]);
              $this->setProducao($_POST["producao1"],$_POST["producao2"]);
              $this->setCargo($_POST["cargo"]);
              $this->setComissao($_POST["comissao"]);
              $this->setModeloPagamento($_POST["modelo"]);
              $this->setQtdParcelas($_POST["parcelas"]);
              $this->setValParcela($_POST["valor"]);
              $this->setSubordinado($_POST["subordinado"]);
              $this->setFuncionario($_POST["funcionario"]);
             
              try{
            
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $this->conn->beginTransaction();
                
                //executa a atualização da comissao
                $this->conn->exec("UPDATE comissao SET nome='".$this->getNome()."',comissao='".$this->getComissao()."',subordinado=".$this->getSubordinado().",cargo_id=".$this->getCargo().",
                                   funcionario_id=".$this->getFuncionario().",producao='".$this->getProducao()."',modeloPagamento='".$this->getModeloPagamento()."',qtd_parcelas='".$this->getQtdParcelas()."',val_parcela='".$this->getValParcela()."',data='".$this->getData()."',hora='".$this->getHora()."',usuario_cadastro=$_SESSION[func_id] WHERE id=$id");
                //finaliza a consulta
                $this->conn->commit();      
                   
                //redireciona para lista de comissão
                    echo "<script type='text/javascript'>
                             alert('Atualização feita com sucesso');
                             location.href='?pg=listaComissao';
                            </script>";
              }catch (Exception $e){
                   echo "<h3 style=color:red;>Houve 1 erro na operação , por favor entre em contato,com o administrador!</h3>";
              $this->conn->rollBack();
              } 
          }
    }
  //metodo que salva a comiss'ão  
  public function salvar(){
   try{
            
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
       $this->conn->beginTransaction();
       
       //insere nova comissão no banco 
       $this->conn->exec("INSERT INTO comissao(nome,cargo_id,producao,tipo,comissao,subordinado,modeloPagamento,qtd_parcelas,val_parcela,data,hora,usuario_cadastro,empresa_id,funcionario_id) 
                                  VALUES('".$this->getNome()."',".$this->getCargo().",'".$this->getProducao()."','".$this->getTipo()."','".$this->getComissao()."',".$this->getSubordinado().",'".$this->getModeloPagamento()."',".$this->getQtdParcelas().",'".$this->getValParcela()."','".$this->getData()."','".$this->getHora()."',$_SESSION[func_id],$_SESSION[empresaId],".$this->getFuncionario().")");
       //finaliza a inserção
         $this->conn->commit();
         //redireciona para lista de comissão 
           echo "<script type='text/javascript'>
                    alert('Registro salvo com sucesso');
                    location.href='?pg=listaComissao';
                   </script>";
         
        }catch (Exception $e){
            echo "<h3 style=color:red;>Houve 1 erro na operação , por favor entre em contato,com o administrador!</h3>";
           //desfaz a operação realizada
            $this->conn->rollBack();
    } 
  }
  //metodo que lista as comissões cadastradas
  public function lista(){
       //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirComissao&id='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM

      echo "<div id='listagens'><br/>
              <h3>Listagem de Comissões </h3>
                <table>
              
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Para</th>
                    <th>Produção</th>
                    <th>Modelo de Pagamento</th>
                    <th>Quantidade /Parcelas</th>
                    <th>Valor / parcela(s)</th>
                    <th>Cadastrador</th>
                    <th>Cadastrado em</th>
                    <th colspan=2>Ações</th>
                    
                </tr>";
                //gera a consulta de comissão
                $lista=  $this->conn->query("SELECT DISTINCT C.*,CG.nome as funcionario,F.nome AS usuario FROM comissao AS C INNER JOIN cargo AS CG ON CG.id=C.cargo_id 
                                             INNER JOIN funcionario AS F ON F.id=C.usuario_cadastro WHERE C.empresa_id=$_SESSION[empresaId] ");
                while($row=$lista->fetch(PDO::FETCH_OBJ)){//cria laço e exibe o resultado da consulta
                    echo "<tr>
                            <td>$row->id</td>
                            <td>$row->nome</td>
                            <td>$row->funcionario</td>
                            <td>$row->producao</td>
                            <td>$row->modeloPagamento</td>
                            <td>$row->qtd_parcelas</td>
                            <td>$row->val_parcela</td>
                            <td>$row->usuario</td>
                            <td>".formata_data($row->data)." - $row->hora</td>
                            <td><a href='?pg=editarComissao&id=$row->id'><img src='imagens/edita.png' title='editar'/></a></td>
                                <td><a href='#' onclick=excluir($row->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>      
                          </tr>";
                }
           echo " </table>
                    <br/>
                    <a href='javascript:history.go(-1)'>Voltar</a>
               </div>";
  }
  //metedo de excluir
  public function excluir($id){
      try{
            
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
       $this->conn->beginTransaction();
      //executa a exclusão do registro
       $this->conn->exec("DELETE FROM comissao WHERE id=$id"); 
       //confirma a exclusão
       $this->conn->commit();      
       
       echo "<script type='text/javascript'>
                    alert('Registro excluido com sucesso');
                    location.href='?pg=listaComissao';
                   </script>";
         
        }catch (Exception $e){
            echo "<h3 style=color:red;>Houve 1 erro na operação , por favor entre em contato,com o administrador!</h3>";
            //desfaz todas as operações
           $this->conn->rollBack();
    }
  }
    
    
    
    
 }
?>
