<script type='text/javascript'>
        selecionaGerOpRel()
 </script>

<?php

class Pendencia{
    private $conn;  
    
    function __construct() {
        $this->conn = new connection;
    }
    
    public function pequisa(){
        
        if($_SESSION["tipo"]==4 ){
            $visibilidade = " AND empresa_id=$_SESSION[empresaId] AND superior_id=$_SESSION[func_id] ";
          }else{
             $visibilidade = "";
        }
        
       echo "<br/><div id='formularios'>
            <fieldset>
               <legend>Pesquisar Pend&ecirc;ncias</legend>
              <table>
                   <form method='post' action='#'>
                   <tr>
                  	<td>Id visita</td>
                  	<td><input type='number' name='id' placeholder='Insira o id visita'/></td>
                  </tr>
                  <tr>
                       <td>Id pend&ecirc;ncia</td>
                       <td><input type='number' name='pendencia_id' placeholder='Insira o id pendencia'/></td>
                  </tr>
                  <tr>
                  	<td>Cliente</td>
                  	<td><input type='text' name='cliente' placeholder='nome do cliente'/></td>
                  </tr>
                   <tr>
		   <td> Periodo:</td>
                    <td><input type='text' name='data1' class='data' placeholder='Insira a data inicial' style='width:110px;'/>A
                   <input type='text' name='data2' class='data' placeholder='Insira a data final' style='width:110px' /></td>
                  </tr>
                 
                 ";
         if($_SESSION['tipo'] == 5){
            echo "<td><input type='hidden' name='operador' value='".$_SESSION["func_id"]."'/>";
                       
         }else if($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 ){
          
            
              echo " <tr>
                        <td>Gerente Telemarketing:</td>
                        <td><select name='gerenteTel'  id='exibiGerTel' onchange='selecionaOperador2()' ></select></td>
                   </tr>
                   <tr>
                       <td>Operador(a) Telemarketing:</td>
                       <td><select name='operador'  id='operador' >
                                <option></option>
                            </select></td>
                  </tr>";
        }
        echo "    <tr>
                    <td> Status:</td>
                    <td><select name='status' >
                           <option value='' >Selecione</option>     
                             <option value='1'>Quente</option>
                             <option value='2'>Morno</option>
                           
                    </select> 
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input class='botao' type='submit' name='buscar' id='buscar' value='Buscar'/></td>
                  </form>
                 </tr>
               </table>
              </fieldset>    
                </div>";
        if(isset($_POST["buscar"])){
            $this->listaHistorico($_POST["id"],$_POST["pendencia_id"],$_POST["operador"], $_POST["data1"], $_POST["data2"], $_POST["status"],$_POST["cliente"]);
        }
        
    }
       function listaHistorico($idVisita,$pendencia_id, $idOperador, $data1, $data2,$status,$cliente) {



        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirpendencia&id='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM      
       $condicao = "";
  //      $condAge = "";
        if (!empty($idVisita)) {
            $condicao = $condicao . " AND A.visita_id=$idVisita";
        }
        if (!empty($idOperador)) {
            $condicao = $condicao . " AND V.operador_id=$idOperador";
        }
        if (!empty($cliente)) {
            $condicao = $condicao . " AND V.cliente_id=$cliente";
        }
        if (!empty($data1) && !empty($data2)) {
            $d1 = formata_data_db($data1);
            $d2 = formata_data_db($data2);
            $condicao = $condicao . " AND A.data BETWEEN '$d1' AND '$d2'";
//            $condAge = " AND data BETWEEN '$d1' AND '$d2'";
        }
        if(!empty($status)){
            $condicao=$condicao." AND VP.status=$status" ;
        }
        if(!empty($pendencia_id)){
            $condicao=$condicao." AND AG.id=$pendencia_id" ;
        }



        if ($_SESSION['tipo'] == 5) {

            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM FUNCIONARIO AS F INNER JOIN visita AS V ON F.id=V.operador_id 
                                                 INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                 INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                 INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id = A.id
                                                 WHERE F.id=$_SESSION[func_id] $condicao AND F.empresa_id=$_SESSION[empresaId] AND A.ativo=0 AND F.ativo=0 AND VP.ativo=0");
        } else {
            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F 
                                                  INNER JOIN visita AS V ON F.id=V.operador_id 
                                                  INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                  INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                  INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id = A.id
                                                   WHERE   F.empresa_id=$_SESSION[empresaId] $condicao AND A.ativo=0 AND F.ativo=0 AND VP.ativo=0");
        }
        
      

        echo "<div id='listagens'>
             <h3>Pend&ecirc;ncias</h3>";
        if($listaOperador->rowCount()){
        while ($list = $listaOperador->fetch(PDO::FETCH_OBJ)) {

           // $qtd = $this->conn->query("SELECT distinct id FROM agendamento_visita WHERE acompanhamento_id=$list->idAcom   $condAge AND ativo=0");

               $sqlConsulta = $this->conn->query("SELECT distinct AG.id,AG.acompanhado ,AG.data,AG.hora,A.statusOcorrencia,A.ocorrencia_id,A.obs,A.resposta_id,C.nome AS cliente,V.id AS idVisita,V.gerente_vendas_id,V.vendedor_id,
                                                V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.status ,PL.nome AS plano
                                                FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id 
                                                INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                INNER JOIN produto AS P ON P.id=VP.produto_id
                                                INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id = A.id
                                                INNER JOIN plano AS PL ON PL.id=VP.plano_id 
                                                WHERE  V.operador_id=$list->id  AND A.ativo=0  AND V.ativo=0 AND AG.ativo=0 AND VP.ativo=0
                                                 $condicao AND F.empresa_id=$_SESSION[empresaId] order by  AG.id desc");
               
               
          
          
                echo "<div class='accordionButton'>$list->nome ( Operador de Telemarketing) <br/>- Quantidade  :" . $sqlConsulta->rowCount() . "</div>
                        <div class='accordionContent'>";
         
            if ($sqlConsulta->rowCount()) {
                echo "<table>
                           <th>Id </th>
                          <th>cliente</th>
                          <th>Produto</th>
                          <th>Status</th>
                          <th>Plano</th>
                          <th>Obs</th>
                          <th>Data</th>
                          <th>Hora</th>
                          <th>Acompanhado</th>
                         <th colspan=2>Ação</th>";
                    
                    while ($l = $sqlConsulta->fetch(PDO::FETCH_OBJ)) {
                    if ($l -> status == 1) {
                      $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                      } elseif ($l -> status == 2) {
                      $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                      }
                      if($l->acompanhado==0){
                          $resposta="Não";
                      }else{
                          $resposta="Sim";
                      }
                    echo "<tr> 
                              <td>$l->id</td>
                              <td>$l->cliente</td>               
                              <td>$l->produto</td>                
                              <td>$status</td> 
                              <td>$l->plano</td>     
                              <td>$l->obs</td>
                              <td>" . formata_data($l->data) . "</td>
                              <td>$l->hora</td>
                              <td>$resposta</td>  ";
                      //  <td><a href='?pg=visualizarPendencia&pen=$l->id'><img src='imagens/view.png' title='visualizar '/></a></td>  
                        echo "      <td><a href='?pg=editarpendenciaoperador&id=$l->id'><img src='imagens/edita.png' title='editar'/></a></td>
		              <td><a href='#' onclick='excluir($l->id)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                  
                    echo " </tr>";
                }
                echo " </table>";
            } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    

            echo "</div>";
        }
       }else{
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    
         
        echo "</div>";
     }
     function edicao($id){
         //cham funcao q exibir os gerente e operadores de telemarketing
        
                 $selecao=$this->conn->query("SELECT distinct A.id AS id_acom,A.data,A.statusOcorrencia,A.ocorrencia_id,A.obs,A.resposta_id,C.id as cliente_id,C.nome AS cliente,V.id AS visita_id,
                                                V.gerente_vendas_id,V.vendedor_id,V.operador_id,V.data_visita,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.produto_id,VP.status,AG.data,AG.hora,VP.plano_id,PL.nome AS plano 
                                                 FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                 INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id=A.id
                                                 INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                                 INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                 INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                 INNER JOIN produto AS P ON P.id=VP.produto_id
                                                 INNER JOIN plano AS PL ON PL.id=VP.plano_id
                                                 WHERE AG.id=$id AND F.empresa_id=$_SESSION[empresaId] AND F.ativo=0");
                 
              $li=$selecao->fetch(PDO::FETCH_OBJ);   
         echo "<div id='formularios'>
             <fieldset>
              <legend>Editar Pendência</legend>
              <form method='post' action='#'>
                <table >
                
                <tr>
                    <td>Id Pendência:</td><td><input type='text' name='agendaOperador'  value='$id' readonly/>  </td> 
                </tr>
                <tr>
                    <td>Id da visita:</td>
                    <td><input type='text' name='visita'  value='$li->visita_id' readonly/>
                        <input type='hidden' name='acompanhamento_id'  value='$li->id_acom' />
                   </td>    
              </tr>
              <tr>
                    <td>Data da Visita:</td><td><input type='text' name='dataVisita' readonly value='" . formata_data($li->data_visita) . "' /></td>
                     <td><input type='hidden' name='data' id='data'  value='" . date('Y-m-d') . "'/></td>    
             </tr>
             
               <tr>
                    <td><input type='hidden' name='hora'   value='" . date('H:i:s') . "'/></td>
              </tr>
               <tr>
                    <td>Data Pendência:</td>
                    <td><input type='text' name='dataPendencia'  class='data' value='" . formata_data($li->data) . "' /></td>
                      
             </tr>
              <tr>
                    <td>Hora Pendência:</td>
                    <td><input type='text' name='horaPendencia'  value='" . $li->hora . "' onkeypress='return valHora(event,this);return false;'  maxlength='8'  /></td>
             </tr>
              <tr>
                  <td>Cliente:</td> 
                  <td><input type='text' name='cliente' id='cliente'  value='$li->cliente' readonly/>
                  <td><input type='hidden' name='id_Cliente' id='idCliente'  value='$li->cliente_id'/> </td>         
             </tr>
             <tr>
                <td>Produto</td>
                <td><input type='text' name='produto' value='$li->produto'/>
                <td><input type='hidden' name='produto_id' value='$li->produto_id'/>   </td>
            </tr>
            <tr>
                <td>Plano</td>
                <td><input type='text' name='plano' value='$li->plano'/>
                <td><input type='hidden' name='plano_id' value='$li->plano_id'/>   </td>
            </tr>
            <tr>
                <td>Novo produto:</td>
                 <td><select name='novoproduto'> 
                       <option></option> ";
                        $listaProduto=  $this->conn->query("SELECT id,nome FROM produto WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 ");
                         while($exibirProduto=$listaProduto->fetch(PDO::FETCH_OBJ)){
                           echo "<option value='$exibirProduto->id'>$exibirProduto->nome</option>";
                          }
                    echo "</select>
                    </td>
                 </tr>
               <tr>
                <td>Novo plano:</td>
                 <td><select name='novoplano'> 
                       <option></option> ";
                        $listaPlano=  $this->conn->query("SELECT id,nome FROM plano WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 ");
                         while($exibirPlano=$listaPlano->fetch(PDO::FETCH_OBJ)){
                           echo "<option value='$exibirPlano->id'>$exibirPlano->nome</option>";
                          }
                    echo "</select>
                    </td>
                 </tr>  ";
                  /*  
         //consulta de operador
                  $listaOperador=  $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$li->operador_id");
                    $exibiroperador=$listaOperador->fetch(PDO::FETCH_OBJ);
      echo " 
              <tr>
                   <td>Operador(a) Telemarketing:</td><td><input type='text' name='operador'  value='$exibiroperador->nome' readonly/></td>
                   <td><input type='hidden' name='operadorEscondido' value='$exibiroperador->id'/>
            </tr>";
    //se nao for 1 operador de telamrketing
      if($_SESSION["tipo"]!=5){ 
            
        echo " <tr>
                    <td>Novo Gerente Telemarketing:</td>
                    <td><select name='novogerenteTel'  id='exibiGerTel' onchange='selecionaOperador2()' ></select></td>
               </tr>
               <tr>
                   <td>Novo Operador(a) Telemarketing:</td>
                   <td><select name='novooperador'  id='operador' >
                           <option></option> 
                        </select></td>
             </tr>";
         }   
         */  
   echo "<tr>
                <td rowspan='2'>Obs:</td><td><textarea rows='15' cols='30' name='motivo' >$li->obs</textarea></td>
         </tr>
         
        <tr>
           <td><input type='submit' name='gravar'  class='botao' value='Atualizar'/></td>
          </tr>
       </table>
      </form>
     </fieldset>
     <a href='javascript:history.go(-1)'>Voltar</a>
     </div>";
   if(isset($_POST["gravar"])){
       $this->salvarEdicao($_POST["agendaOperador"], $_POST["dataPendencia"], $_POST["horaPendencia"],$_POST["visita"],$_POST["novoproduto"],$_POST["acompanhamento_id"],$_POST["novoplano"]);
   }
   
 }
     public function salvarEdicao($id,$data,$hora,$visita,$novoproduto,$acompanhamento_id,$novoplano){
         
         try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
            $data=  formata_data_db($data);
            //se 1 novo produto for escolhido
             if(!empty($novoproduto)|| !empty($novoplano)){
                 //SELECIONE A VISITA ANTIGA
                  $antigo=$this->conn->query("SELECT * FROM visita_produto WHERE visita_id=$visita ORDER BY id DESC LIMIT 1");
                  $listaAntigo=$antigo->fetch(PDO::FETCH_OBJ);
                    //verifica se plano foi modificado
                    if(!empty($novoplano)){
                       $plano=$novoplano; 
                    }else{
                      $plano=$listaAntigo->plano_id;
                    }
                    
                    if(!empty($novoproduto)){
                        $prod=$novoproduto;
                    }else{
                        $prod=$listaAntigo->produto_id;
                    }
                    
                   $this->conn->exec("UPDATE visita_produto SET ativo=-1 WHERE visita_id=$visita");  
                   
                 $novo_visita_produto=$this->conn->query("INSERT INTO visita_produto(plano_id,produto_id,visita_id,status) VALUES($plano,$prod,$visita,$listaAntigo->status)");
                
                
             }
              $this->conn->exec("UPDATE agendamento_operador SET ativo=-1 WHERE id=$id");
             $novoagendaoperador=$this->conn->query("INSERT INTO agendamento_operador(data,hora,ativo,acompanhado,acompanhamento_id)
                                                    VALUES('$data','$hora',0,0,$acompanhamento_id)");
             
            // $atualizar=$this->conn->exec("UPDATE agendamento_operador SET data='".formata_data_db($data)."',hora='$hora' WHERE id=$id" );
                
                echo "<script type='text/javascript'>
                        alert('Atualização feita com sucesso')
                         location.href='?pg=pendenciaoperador';
                     </script>";
           
            $this->conn->commit();
         }catch (Exception $e){
              
             echo "Não foi possivel fazer seu cadastro, entre em contato com o administrador!";
            $this->conn->rollBack();
       }
    }
     public function excluir($id){
         $apagar=$this->conn->exec("DELETe FROM agendamento_operador WHERE id=$id");
         if($apagar){
         echo "<script type='text/javascript'>
                    alert('Exclusão feita com sucesso')
                    location.href='?pg=pendenciaoperador';
                 </script>";
         }
     }
}

?>
