<?php

class editaAgendamento{
 
private $id_agendamento;

function __construct() {

     $this->conn = new connection;
}
function frmEdicao($id_agendamento){
    
    $this->id_agendamento = $id_agendamento;
   //gera a consulta referente ao id 
    $cons = $this->conn->query("SELECT  A.id AS idAg,A.data,A.acompanhamento_id,A.hora,V.id as visita_id,V.operador_id,V.gerente_vendas_id,V.vendedor_id,VP.status,F.id ,
                                F.perfil,F.nome,C.id AS idCli,C.nome as cliente,C.logradouro,C.fone1,C.fone2
                                FROM visita AS V INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                                INNER JOIN acompanhamento AS AC ON AC.visita_id=V.id
                                INNER JOIN agendamento_visita AS A ON A.acompanhamento_id=AC.id 
                                INNER JOIN cliente AS C ON V.cliente_id=C.id 
                                INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                WHERE A.id=$this->id_agendamento");
    $row= $cons->fetch(PDO::FETCH_OBJ);
   
    echo "
            <div id='formularios'>
            <a href='?pg=agendamento' style='align:center'>Voltar</a>
            <fieldset>
            <legend>Edição de Agendamento</legend>
            <form method='post' action='#'>
            <table>
                <tr>
                    <td>Id Agendamento:</td>
                    <td><input type='text' name='id' value='$row->idAg' readonly/>
                        <input type='hidden' name='acompanhamento_id' value='$row->acompanhamento_id' />
                         <input type='hidden' name='visita_id' value='$row->visita_id' />    </td>
                        
                 </tr>
                 <tr>
                    <td>Data Agendamento:</td>
                    <td><input type='text' name='data' value='".formata_data($row->data)."'  class='data'/></td>
                 </tr>
                  <tr>
                    <td>Hora Agendamento:</td>
                    <td><input type='text' name='hora' value='".$row->hora."' onkeypress='return valHora(event,this);return false;'  maxlength='8'  /></td>
                 </tr>
                 <tr>
                    <td>Gerente de Vendas:</td>";
                       //gera a consulta para listar os gerente de vendas
                       $sqlGer=$this->conn->query("SELECT id,nome FROM funcionario  WHERE id=$row->gerente_vendas_id");
                       $sqlexibi=$sqlGer->fetch(PDO::FETCH_OBJ);
              echo "<td><input type='text' name='gerente' value='$sqlexibi->nome' readonly/></td>
                    <td><input type='hidden' name='id_gerente' value='$sqlexibi->id'/></td>    
                 </tr>
                 <tr>
                  <td>Vendedor</td>";
                      //gera a consulta para listar os vendedores
                      $sqlVendedor=$this->conn->query("SELECT id,nome FROM funcionario  WHERE id=$row->vendedor_id");
                       $exibiVendedor=$sqlVendedor->fetch(PDO::FETCH_OBJ);
            echo "<td><input type='text' name='vendedor' value='$exibiVendedor->nome' readonly/></td>
                 <td><input type='hidden' name='vendedor_id' value='$exibiVendedor->id'/></td>    
                </tr>"; 
           echo "<tr>";
            //verifica se o nivel do usuario é:upgrade,master,administrador,gerente telemarketing 
            if($_SESSION["tipo"]==0 ||  $_SESSION["tipo"]==1 || $_SESSION["tipo"]==2 ||$_SESSION["tipo"]==4  ){
                    //selecina os gerentes 
                    $sql = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=3 ");
            echo " <td>Novo Gerente :</td>
                    <td><select  name='novogerente' id='gerente'  placeholder='Gerente de vendas' onchange = selecionaVendedor() >
                     <option value=''>Selecione o gerente</option> ";
            
                    //cria o laço  para exibir os nomes dos gerentes de vendas
            
                         while ($rowGerente = $sql->fetch(PDO::FETCH_OBJ)) {
                    
                             echo " <option value='$rowGerente->id'>$rowGerente->nome</option>";
                        }
            echo " </select> </td>";
            //seleciona vendedor ...atraves do ajax sera gerado o nome dos vendedores de acordo com id do gerente vendas e exibido no campo com id=exibir , abaixo 
            echo "<tr>
                    <td>Novo Vendedor:</td>
                    <td><select name='novovendedor' id='exibir'>
                          <option></option>  
                         </select></td>
                  </tr>";
            
            
            
            //SE FOR GERENTE DE VENDAS
           
            }else if($_SESSION["tipo"]==3 ){
                 //seleciona vendedores    
                 $sql = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=5 AND superior_id=$_SESSION[func_id] ");
                 echo "<input type='hidden' name='gerente' value='$_SESSION[func_id]'/>
                        <td>Vendedor:</td>
                        <td><select  name='novovendedor'>
                        <option value=''>Selecione o vendedor</option> ";
                   //verifica se  a consulta gerou algum registro     
                    if($sql->rowCount()){    
                    
                            while ($rowVendedor = $sql->fetch(PDO::FETCH_OBJ)) {
                                
                             echo " <option value='$rowVendedor->id'>$rowVendedor->nome</option>";
                        
                            }
                       } 
            echo "    </select> 
                   </td>";
            //se FOR VENDEDOR    
           }else  if($_SESSION["tipo"]==6 ){
            echo "<td>
                       <input type='hidden' name='gerente' value=''/>
                       <input type='hidden' name='vendedor' value='$_SESSION[func_id]'/>
                 </td>";
                
                 }
           echo " </tr>";
           
           //se super usuario   
           
           if($_SESSION["tipo"]==0 ){
               //gera consulta com a lista de operador telemarketing
               $sqlOP=$this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0  AND perfil=5"); 
            }
           
            //se usuario master, administrador ,gerente de telemarketing  
            
           if($_SESSION["tipo"]==1 ||$_SESSION["tipo"]==2 || $_SESSION["tipo"]==4 ){
           
             $sqlOP=$this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND perfil=5 AND empresa_id=$_SESSION[empresaId]");  
           }
           
         // se nao for operador de telemarketing  
          
           if($_SESSION["tipo"]!=5 ){// se diferente de operador de telemarketing gera a consulta com todos os operadores telemarketing
             
             $sqloperador=  $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND perfil=5 AND id=$row->operador_id");
            
             $rowOperador=$sqloperador->fetch(PDO::FETCH_OBJ);
          
             echo "<tr>
                    <td>Operador(a) Telemaketing:</td>
                    <td><input type='text' name='operador' value='$rowOperador->nome' readonly/></td>
                    <td><input type='hidden' name='id_operador' value='$rowOperador->id'/></td> 
                </tr>
                <tr> 
                    <td>Novo(a) Operador(a):</td>
                    <td><select name='novooperador'>
                        <option value=''>Selecione</option>";
                        //cria laco com os operadores telemarketing
                         while($l=$sqlOP->fetch(PDO::FETCH_OBJ)){
                         echo "<option value='$l->id'>$l->nome</option>"; 
                    }
                    echo "</td>
                </tr>   ";
             }
             
             //se gerente de telemarketing
                
           echo "</tr>
                  <tr>
                    <td>Cliente:</td>
                    <td><input type='text' name='cliente' value='".$row->cliente."' readonly/></td>
                    <td><input type='hidden' name='id_cliente' value='$row->idCli'/></td>    
                 </tr>
                 <tr>
                    <td>Endereço:</td>
                    <td><input type='text' name='logradouro' value='$row->logradouro' readonly/></td>
                </tr>
                <tr>
                    <td>Fone 1</td>
                    <td><input type='text' name='fone1' value='$row->fone1' readonly/></td>
                </tr>
                <tr>
                    <td>Fone2</td>
                    <td><input type='text' name='fone2' value='$row->fone2' readonly/></td>
                </tr>   
                 <tr>
                    <td></td><td><input type='submit' name='enviar' value='salvar' class='botao'/></td>
                 </tr>
            </table>
          </form>
          </fieldset>
        </div>
        
            ";
    if(isset($_POST['enviar']))
        {
        $this->salvarEdicao($_POST['id'],$_POST['visita_id'],$_POST['data'],$_POST['hora'],$_POST['novogerente'],$_POST['novovendedor'],$_POST['novooperador']);
        }
}    
 function salvarEdicao($id,$visita_id,$data,$hora,$gerente,$vendedor,$operador)
 { 
     if(!empty($vendedor)){
         $responsavel=", responsavel=".$vendedor;
     }else if(!empty($gerente)){
         $responsavel=", responsavel=".$gerente;
     }else{
         $responsavel="";
     }
   
    
      try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
      
            if(!empty($operador)){
                //atualiza a visita ,adicionando o id do operador
                $this->conn->exec("UPDATE visita SET operador_id=$operador  WHERE id=$visita_id");
            }
           
            $this->conn->exec("UPDATE agendamento_visita SET data='".formata_data_db($data)."',hora='$hora' $responsavel WHERE id=$id ");
     
            $this->conn->commit();
            
            echo "<script type='text/javascript'>alert('Atualização feita com sucesso')
                  location.href='?pg=agendamento';
                    </script>";
         }catch (Exception $e){
            
          $this->conn->rollBack();
        }   
    }   
}
?>
