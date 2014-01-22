<?php

$sqlGerenteVendas = $this->conn->query("SELECT V.gerente_vendas_id,F.nome,count(V.gerente_vendas_id)AS contador 
                                        FROM visita AS V  INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id
                                        INNER JOIN cliente AS C ON C.id=V.cliente_id
                                        INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                        INNER JOIN estado AS E ON E.id=M.estado_uf 
                                        WHERE V.ativo=0  $clausula  $empresa GROUP BY V.gerente_vendas_id");


if ($sqlGerenteVendas->rowCount()) {
    echo "<div id='listagens'>
            <div style='clear:both;'></span><br/>
            <h3>Relatorio de visitas</h3>
               <table>";
    while ($lista = $sqlGerenteVendas->fetch(PDO::FETCH_OBJ)) {

        echo " <tr>
                    <th colspan='8'>Gerente de Vendas: $lista->nome - Quantidade: $lista->contador</th>
               </tr>";

                  $vendedores = $this->conn->query("SELECT distinct V.vendedor_id,count(V.vendedor_id) AS contador,V.data_visita,F.nome
                                                  FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                                  WHERE V.ativo=0  AND V.gerente_vendas_id=$lista->gerente_vendas_id $clausula GROUP BY V.data_visita ORDER BY F.nome");
                  while ($listaVendedores = $vendedores->fetch(PDO::FETCH_OBJ)) {
         echo "<tr>
                <th colspan='7' >Vendedor: $listaVendedores->nome - Quantidade: $listaVendedores->contador - Data Visita:" . formata_data($listaVendedores->data_visita) . "</th>
               </tr>";

         echo" <tr>
                    <th>Id Cliente</th>
                    <th>Cliente</th>
                     <th>Fone</th>
                    <th>Produto</th>
                    <th>Local Prospectado</th>
                    <th>Visitado</th>
               </tr>";

            $visitados = $this->conn->query("SELECT distinct V.vendedor_id,F.nome,V.data_visita,V.id,V.local_prospectado,V.cliente_id,C.nome AS cliente,
                                        C.fone1,P.nome as produto
                                        FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id
                                        INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                        INNER JOIN cliente AS C ON C.id=V.cliente_id
                                        INNER JOIN produto AS P ON P.id=VP.produto_id
                                         WHERE V.ativo=0 AND V.gerente_vendas_id=$lista->gerente_vendas_id AND V.data_visita='$listaVendedores->data_visita' $clausula  ORDER BY F.nome");

            while ($listaVis = $visitados->fetch(PDO::FETCH_OBJ)) {

                echo "<tr>
                         <td>$listaVis->cliente_id</td>
                         <td>$listaVis->cliente</td>
                        <td>$listaVis->fone1</td>     
                        <td>$listaVis->produto</td> 
                          <td>$listaVis->local_prospectado</td>       
                        <td>" . formata_data($listaVis->data_visita) . "</td>
                          
                   </tr>";
            }
        }
    }
    echo "</table>
          </div>";
} else {
    echo "<h3>nenhum</h3> ";
}
?>