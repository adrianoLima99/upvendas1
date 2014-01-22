<?php
   
    echo "<div id='listagens'>
            <div style='clear:both;'></div><br/>
             <h3>Relatorio de Pendência</h3>
                 <table> "; 
    
    
    while($listaOperador=$operadores->fetch(PDO::FETCH_OBJ)){ 
           $sql = $this->conn->query("SELECT distinct A.id AS id_acom,A.obs,C.id as cliente_id,C.nome AS cliente,C.fone1,
                                    V.id AS visita_id, V.gerente_vendas_id,V.vendedor_id,V.data_visita,F.id as idFunc,F.nome,F.perfil,
                                    P.nome AS produto,VP.produto_id,VP.status,AG.data,AG.hora,VP.plano_id,PL.nome AS plano 
                                    FROM acompanhamento AS A INNER JOIN visita AS V ON V.id=A.visita_id 
                                    INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id=A.id 
                                    INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                    INNER JOIN cliente AS C ON V.cliente_id=C.id 
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                    INNER JOIN produto AS P ON P.id=VP.produto_id 
                                    INNER JOIN plano AS PL ON PL.id=VP.plano_id 
                                    WHERE V.operador_id=$listaOperador->id AND AG.ativo=0 $clausula  AND A.ativo=0 AND V.ativo=0 AND VP.ativo=0 ");
       

        echo "<tr>
                <th colspan='9'>Operador(a) Telemarketing : $listaOperador->nome
                      Quantidade : ".$sql->rowCount()."
                </th> 
             <tr>
                  <th>Id Cliente</th>
                  <th>Cliente</th>
                  <th>Fone</th>
                  <th>Vendedor</th>
                   <th>Produto</th>
                   <th>Plano</th>
                   <th>Status</th>
                   <th>Data Pendência</th>
                   <th>Visitado</th>
               </tr>";
        
         while($lista=$sql->fetch(PDO::FETCH_OBJ) ){
       
   

       
       
             if ($lista->status == 0) {
                    $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
             } elseif ($lista->status == 1) {
                   $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
            } elseif ($lista->status == 2) {
                   $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
            }
            //lista vendedores
            $listaVendedor=$this->conn->query("SELECT nome FROM funcionario WHERE id=$lista->vendedor_id");
             $exibirVendedor=$listaVendedor->fetch(PDO::FETCH_OBJ);
                 
            
                echo "<tr>
                       <td>$lista->cliente_id</td>
                       <td>$lista->cliente</td>
                        <td>$lista->fone1</td>
                        <td> $exibirVendedor->nome</td>    
                        <td>$lista->produto</td>
                        <td>$lista->plano</td>
                        <td>$status</td>    
                        <td>".formata_data($lista->data)."</td>
                        <td>".formata_data($lista->data_visita)."</td>    
                      </tr> ";
                
             
             
           
        }  
      
      echo "</table></div>";
    }    
 
?>