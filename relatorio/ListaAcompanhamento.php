<?php


        $agen=$this->conn->query("SELECT AG.acompanhamento_id FROM agendamento_visita AS AG INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                                  INNER JOIN visita AS V ON AC.visita_id=V.id  WHERE AC.ativo=0 AND AG.ativo=0 $clausula");
        
        $acom=$this->conn->query("SELECT AC.id FROM acompanhamento as AC  INNER JOIN visita AS V ON AC.visita_id=V.id WHERE AC.ativo=0 AND V.ativo=0 $clausula");
         $acomresposta=$this->conn->query("SELECT AC.id FROM acompanhamento AS AC INNER JOIN visita AS V ON AC.visita_id=V.id WHERE AC.resposta_id=9 AND AC.ativo=0 $clausula ");
         $contaAcom=$acom->rowCount();
         $contAgen=$agen->rowCount();
         $contResposta=$acomresposta->rowCount();
         $conNatendido=$contaAcom-$contResposta;
   
    echo "<div id='listagens'>
            <div style='clear:both;'></div><br/>
             <h3>Relatorio de Liga&ccedil;&otilde;es</h3>
                 <table>
                        <tr>
                       <th colspan=6>Acompanhados: $contaAcom  Agendados: $contAgen Liga&ccedil;&otilde;es atendidas:$contResposta Liga&ccedil;&otilde;es n&atilde;o atendidas:$conNatendido</th> 
                  </tr> "; 
    
   while($lista=$sql->fetch(PDO::FETCH_OBJ) ){
       
       echo  "<tr>
                    <th colspan='6'>Operador(a) Telemarketing: $lista->nome
                     Quantidade: $lista->contador
                    Data:".formata_data($lista->data)."
                  </th> 
                <tr>
                    <th>Id Cliente</th>
                    <th>Cliente</th>
                    <th>Fone</th>
                    <th>Vendedor</th>
                    <th>Resposta</th>
                     <th>Agendado</th>
               </tr>       ";
       

        $acompanhados=$this->conn->query("SELECT  AC.id,AC.resposta_id,V.cliente_id,V.vendedor_id,V.gerente_vendas_id,V.operador_id,VP.status,C.nome,C.fone1,C.logradouro,C.bairro,P.nome AS produto
                                                     FROM acompanhamento AS AC INNER JOIN  visita AS V ON AC.visita_id=V.id
                                                     INNER JOIN cliente AS C ON C.id=V.cliente_id
                                                     INNER JOIN funcionario AS F ON V.operador_id=F.id
                                                     INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                     INNER JOIN produto AS P ON P.id=VP.produto_id
                                                     WHERE AC.ativo=0 AND F.ativo=0 AND V.ativo=0 $clausula AND V.operador_id=$lista->operador_id AND AC.data='$lista->data'");
         if( $acompanhados->rowCount()){ 
         while($listaAC=$acompanhados->fetch(PDO::FETCH_OBJ) ){
                 $agendados=$this->conn->query("SELECT id FROM agendamento_visita WHERE acompanhamento_id=$listaAC->id");
                             $selecResp= $this->conn->query("SELECT id,resposta FROM respostaautomatica WHERE ativo=0");
                             $resposta=$selecResp->fetch(PDO::FETCH_OBJ);
                             if($agendados->rowCount()){
                                  $agendado="Sim";
                              }else{
                                  $agendado="N&atilde;o";
                              }
                              if($listaAC->resposta_id==$resposta->id){
                                  $exibirResposta=$resposta->resposta;
                              }else{
                                  $exibirResposta="Nenhuma";
                              }
                echo "<tr>
                       <td>$listaAC->cliente_id</td>
                       <td>$listaAC->nome</td>
                        <td>$listaAC->fone1</td>";
                $listaVendedor=$this->conn->query("SELECT nome FROM funcionario WHERE id=$listaAC->vendedor_id");
                 $exibirVendedor=$listaVendedor->fetch(PDO::FETCH_OBJ);
              echo     "<td> $exibirVendedor->nome</td>
                       <td>$exibirResposta</td>
                       <td>$agendado</td>     
                   </tr>";
             }
            }else{
            echo "<tr>
                    <td colspan=7><h3>Nenhum Registro Encontrado!</h3></td>
                 </tr>   ";
        }    
      }
      echo "</table></div>";
       
 
?>
      
      
 