<?php

    echo "<div id='listagens'>
        <h3>Relatorio de Agendamento</h3>
                   <table>"; 
   while($lista=$sql->fetch(PDO::FETCH_OBJ) ){
       
       echo  "
          
                <tr>
                    <th colspan=7>Operador Telemarketing(a):  $lista->nome - Quantidade:$lista->contador</th>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <th>Fone</th>
                    <th>Gerente Vendas</th>
                    <th>Vendedor</th>
                    <th>Produto</th>
                    <th>Data</th>
                    <th>Hora</th>
                </tr>       ";
      
           $agendados=$this->conn->query("SELECT distinct AG.data,AG.hora,C.nome AS cliente,C.fone1,F.nome,V.gerente_vendas_id,P.nome as produto 
                                             FROM agendamento_visita AS AG INNER JOIN acompanhamento AS AC ON AG.acompanhamento_id=AC.id
                                             INNER JOIN visita AS V ON V.id=AC.visita_id
                                             INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                             INNER JOIN cliente AS C ON C.id=V.cliente_id
                                             INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                             INNER JOIN produto AS P ON P.id=VP.produto_id
                                             WHERE AG.ativo=0 AND V.operador_id=$lista->id $clausula ORDER by AG.data");

        if( $agendados->rowCount()){ 
         while($listaAg=$agendados->fetch(PDO::FETCH_OBJ) ){
                
                echo "<tr>
                       
                        <td>$listaAg->cliente</td>
                        <td>$listaAg->fone1</td>";
                        $listagerente=$this->conn->query("SELECT nome FROM funcionario WHERE id=$listaAg->gerente_vendas_id");
                        $exibirgerente=$listagerente->fetch(PDO::FETCH_OBJ);
              echo     "<td> $exibirgerente->nome</td>";
                 echo"   <td>$listaAg->nome</td>
                         <td>$listaAg->produto</td>
                        <td>".formata_data($listaAg->data)."</td>
                        <td>$listaAg->hora</td>
                    </tr>";
            } 
        }else{
            echo "<tr>
                    <td colspan=7><h3>Nenhum Registro Encontrado!</h3></td>
                 </tr>   ";
        }  
      }
      echo "</table>
          </div>";
 
 
?>