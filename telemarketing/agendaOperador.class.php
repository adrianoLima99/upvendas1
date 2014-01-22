<?php

class AgendaOperador {

    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function agendados() {
        $hoje = date("Y-m-d");
         $hora=date("H");
        if ($_SESSION['tipo'] != 6) {
            echo "<div id='listagens'>";


                
                    $sqlLista2 = $this->conn->query("SELECT AO.id,F.nome,F.id as idFuc,AO.data, C.nome AS cliente ,C.fone1,C.fone2,P.nome AS produto,VP.status,
                                                      V.gerente_vendas_id,V.vendedor_id,V.operador_id,V.id AS idVisita , AC.obs 
                                                       FROM visita AS V INNER JOIN acompanhamento AS AC ON V.id=AC.visita_id
                                                        INNER JOIN funcionario AS F ON F.id=V.operador_id
                                                        INNER JOIN agendamento_operador AS AO ON AC.id=AO.acompanhamento_id
                                                        INNER JOIN cliente AS C  ON C.id=V.cliente_id
                                                        INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                        INNER JOIN produto AS P ON P.id=VP.produto_id
                                                        WHERE AO.data<='$hoje' AND VP.status<>0
                                                       	AND AO.hora LIKE '$hora%'    
                                                        AND  F.ativo=0 AND AO.ativo=0
                                                        AND AO.acompanhado=0");
                                           //ABAIXA A SELECAO DOS REACOMPANHAMENTOS
                    if ($sqlLista2->rowCount()) {
                        		      echo "<script type='text/javascript'>
                                                       alert(' voce possui pendencias para acompanhar ');
                                                  </script>";
 
                     echo "<h3>Pendências</h3>";
                    echo "<div class='accordionButton'>Quantidade: ".$sqlLista2->rowCount()."</div>
	  		  <div class='accordionContent'>";

                        echo "<table>
    		    <tr>
			         <th>Id Visita</th>
			         <th>Operador Telemarketing</th>
			         <th>Status</th>
			          <th>Data Cadastro</th>
			         <th>Cliente</th>
                                 <th>Fone1</th>
                                 <th>Fone2</th>
			         <th>Produto</th>
			         <th>Obs</th>
			         <th>Acompanhamento</th>
       			</tr>";

                        while ($l2 = $sqlLista2->fetch(PDO::FETCH_OBJ)) {
                          //seleciona operador
                            $sqlOp=$this->conn->query("SELECT id,nome FROM funcionario  WHERE id=$l2->operador_id AND ativo=0");
                           $row=$sqlOp->fetch(PDO::FETCH_OBJ);
                      //fim selecao
      
                            if ($l2->status == 0) {
                                $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                            } elseif ($l2->status == 1) {
                                $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                            } elseif ($l2->status == 2) {
                                $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                            }


                            echo "<tr style='color:red;'>
                                         <td>$l2->idVisita</td>
					  <td>$row->nome</td>
					  <td>$status</td>      
					  <td>" . formata_data($l2->data) . "</td>
					   <td>$l2->cliente</td>
                                           <td>$l2->fone1</td>    
					   <td>$l2->fone2</td>
                                           <td>$l2->produto</td>   
					   <td>$l2->obs</td>
					   <td  style='color:red;'><a href='?pg=acompanha&operador=$row->nome&idOP=$row->id&vendedor=$l2->nome&idVend=$l2->vendedor_id&visita=$l2->idVisita&gerente=$l2->gerente_vendas_id&agendaOperador=$l2->id'>Novo</a></td>
			         </tr>";
                        }
                    }
                    echo "</table></div>";
                
            
            echo "</div>";
        }
    }

}

?>
