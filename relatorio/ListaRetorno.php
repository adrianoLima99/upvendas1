<?php
   

    echo "<div id='listagens'>
           
            <h3>Relatorio de Retorno Inteligente</h3>
               <table>
                   <tr>
                    <th>Id Cliente</th>
                    <th>Cliente</th>
                     <th>Fone</th>
                    <th>Produto</th>
                    <th>Gerente Vendas</th>
                    <th>Vendedor</th>
                    <th>Visitado</th>
               </tr>       ";
                     
        $listaCliente=$this->conn->query("SELECT id,nome FROM cliente WHERE empresa_id=$_SESSION[empresaId]");
        
       while($row=$listaCliente->fetch(PDO::FETCH_OBJ) ){
           //atualiza a visita recolocando-a para ser associada novamente
           
           $listaVisita=$this->conn->query("SELECT V.id,F.nome,V.cliente_id,C.nome as cliente,C.fone1 ,V.vendedor_id,V.data_visita,P.nome as produto
                                            FROM visita AS V INNER JOIN cliente AS C ON C.id=V.cliente_id
                                            INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                            INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                                            INNER JOIN produto AS P ON P.id=VP.produto_id
                                            INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                            INNER JOIN estado AS E ON E.id=M.estado_uf
                                            WHERE  V.cliente_id=$row->id AND V.empresa_id=$_SESSION[empresaId] $diferenteVendido $clausula  ORDER BY V.data_visita DESC limit 1");
           if($listaVisita->rowCount()){
             while($row2=$listaVisita->fetch(PDO::FETCH_OBJ) ){ 
            $this->conn->exec("UPDATE visita SET acompanhado=0,operador_id=0 WHERE id=$row2->id ");
             $sql=$this->conn->query("SELECT nome FROM funcionario WHERE id=$row2->vendedor_id");
              $listaVendedor=$sql->fetch(PDO::FETCH_OBJ);
                
                echo "<tr>
                         <td>$row2->cliente_id</td>
                         <td>$row2->cliente</td>
                         <td>$row2->fone1</td>     
                         <td>$row2->produto</td> 
                         <td>$row2->nome</td>
                         <td>$listaVendedor->nome</td>    
                         <td>".formata_data($row2->data_visita)."</td>
                          
                    </tr>";
                 }
              }
            }
      
      echo "</table>
          </div>";
 
?>