<?php
/*private $conn;
    
 function __construct() {
        $this->conn = new connection;
    }
    
}*/
 if($_SESSION["tipo"]==0){
     $empresa="";
     $cliente="";
 }else{
     $empresa=" AND F.empresa_id=".$_SESSION["empresaId"];
     $cliente=" AND C.empresa_id=$_SESSION[empresaId]";
 }
    $sqlGerenteVendas=$this->conn->query("SELECT V.gerente_vendas_id,F.nome,count(V.gerente_vendas_id)AS contador ,V.id
                                          FROM visita AS V  INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id
                                          INNER JOIN vendas AS VN ON VN.visita_id=V.id
                                          INNER JOIN cliente AS C ON C.id=V.cliente_id
                                          INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                          INNER JOIN estado AS E ON E.id=M.estado_uf
                                          WHERE V.ativo=0  AND VN.ativo=0  $empresa $clausula GROUP BY V.gerente_vendas_id");
    
    if($sqlGerenteVendas->rowCount()){
    echo "<div id='listagens'>
        <div style='clear:both;'></span><br/>
        <h3>Relatorio de Vendas</h3>
                   <table>"; 
   while($lista=$sqlGerenteVendas->fetch(PDO::FETCH_OBJ) ){
       
       echo  "
          
                <tr>
                    <th colspan='8' >Gerente de Vendas:$lista->nome - Quantidade: $lista->contador</th>
                     
                </tr>";
                    
        $vendedores=$this->conn->query("SELECT distinct V.vendedor_id,count(V.vendedor_id) AS contador,F.nome,VN.data,VN.id
                                        FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                        INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                         WHERE V.ativo=0 AND VN.ativo=0 AND  V.gerente_vendas_id=$lista->gerente_vendas_id $clausula GROUP BY VN.data ORDER BY F.nome");
    while($listaVendedores=$vendedores->fetch(PDO::FETCH_OBJ) ){
                
                echo "<tr>
                       <th colspan='8' >Vendedor: $listaVendedores->nome - Quantidade: $listaVendedores->contador - Data cadastro:".formata_data($listaVendedores->data)."</th>
                            
                   </tr>";
                
                
                
                $venda="SELECT distinct C.id AS cli_id,C.nome AS cliente,C.fone1,F.nome,P.nome AS produto,V.local_prospectado,VN.numContrato,VN.data
                        FROM  visita AS V INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                            INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                             INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                             INNER JOIN produto AS P ON P.id=VP.produto_id
                             INNER JOIN cliente AS C ON C.id=V.cliente_id
                             WHERE C.ativo=0  AND VN.ativo=0 AND V.ativo=0 AND P.ativo=0 AND VN.data='$listaVendedores->data' AND V.vendedor_id=$listaVendedores->vendedor_id $cliente";
                 $sqlVenda=$this->conn->query($venda);
              //  echo $venda;
                echo " 
                 <tr>
                    <th>Id Cliente</th>
                     <th>Cliente</th>
                     <th>Fone</th>
                     <th>Vendedor</th>
                     <th>Nº Contrato</th>
                     <th>Produto</th>
                     <th>Local Prospectado</th>
                     <th>Vendido</th>
                </tr> ";
                 while($listaVendas=$sqlVenda->fetch(PDO::FETCH_OBJ)){
                      echo "<tr>
                                  <td>$listaVendas->cli_id</td>
                                 <td>$listaVendas->cliente</td>
                                 <td>$listaVendas->fone1</td>
                                 <td>$listaVendas->nome</td>
                                 <td>$listaVendas->numContrato</td>
                                 <td>".$listaVendas->produto."</td>    
                                <td>".$listaVendas->local_prospectado."</td>
                                 <td>".formata_data($listaVendas->data)."</td>   
                            </tr>";
                 }
                
            }   
      }
      echo "</table>
          </div>";
 }else{
     echo "<h3 style='color:red'>Nenhum registro Encontrado!</h3> ";
 }
 
?>