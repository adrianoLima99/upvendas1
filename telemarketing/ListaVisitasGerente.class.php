<?php

class ListaVisitaGerente {

	private $conn;
	private $tipo;
	private $diaPassado;

	function __construct() {
		$this -> conn = new connection;
	}

	function listagemGerente() {
		//$this->tipoUsuario();
		$dia = date('Y-m-d');
		
		

		echo "
             <div id='listagens'>
            <h3> Acompanhamento  para hoje:</h3><br/><br/> ";
		if($_SESSION["tipo"]==4){
                    $condicao="AND V.operador_id=$_SESSION[func_id]";
                }else{
                    $condicao="";
                }	
             

	
                    
		

$sqlLista = "SELECT V.id AS visita,F.id,F.nome,F.perfil ,VP.status,C.id,C.nome AS cliente,P.id, P.nome AS produto,V.obs,V.data_visita,V.acompanhado,
                                    V.operador_id,V.vendedor_id,V.gerente_vendas_id
                                    FROM visita AS V INNER JOIN funcionario AS F ON F.id=V.operador_id  
                                    INNER JOIN cliente AS C ON C.id = V.cliente_id
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                    INNER JOIN produto AS P ON P.id=VP.produto_id
                                    WHERE V.acompanhado =0
                                    AND V.ativo=0 AND operador_id<>0
                                    $condicao 
                                    AND VP.status <>0
                                    AND F.empresa_id=$_SESSION[empresaId] ORDER BY V.data_visita";

$sqlConsulta=$this->conn->query($sqlLista);
if ($sqlConsulta -> rowCount()) {
          echo "<table>
                      <tr>
                         <th colspan=3 style='background-color: #006666;color:#F5F5F5;'>Quantidade: ".$sqlConsulta->rowCount()."</th>     
                       </tr>

                        <tr>
                         <th>Id Visita</th>
                         <th>Operador Telemarketing</th>
                         <th>Status</th>
                          <th>Data visita</th>
                         <th>Cliente</th>
                         <th>Produto</th>
                         <th>Obs</th>
                         <th>Acompanhamento</th>
                      
                       </tr>";
          //######### INICIO Paginação
	$numreg = 5; // Quantos registros por página vai ser mostrado
	if (!isset($_GET["pagina"])) {
		$_GET["pagina"] = 0;
	}
	$inicial = $_GET["pagina"] * $numreg;
	
//######### FIM dados Paginação
	
	// Faz o Select pegando o registro inicial até a quantidade de registros para página
	$sql =$this->conn->query($sqlLista ." LIMIT $inicial, $numreg");

	// Serve para contar quantos registros você tem na seua tabela para fazer a paginação
//	$sql_conta =$sqlLista->rowCount();
	$quantreg =$sqlConsulta -> rowCount();
	//$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
	
	include("includes/paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>
	
	echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo
	
	
                         while ($l = $sql-> fetch(PDO::FETCH_OBJ)) {
                              
		               if ($l -> status == 0) {
                                	$status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        	} elseif ($l -> status == 1) {
					$status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
				} elseif ($l -> status == 2) {
					$status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
				}
				
			echo " 
                        <tr>
                              <td>$l->visita</td>
                               <td>$l->nome</td>    
                              <td>$status</td>   
                              <td>" . formata_data($l -> data_visita) . "</td>
                              <td>$l->cliente</td>
                              <td>$l->produto</td>
                              <td>$l->obs</td>
                              <td><a href='?pg=acompanha&operador=$l->nome&idOP=$l->id&vendedor=$l->nome&idVend=$l->id&visita=$l->visita&gerente=$l->id&idProduto=$l->id&produto=$l->produto'>Novo</a></td>
                        </tr>";
                	}
	echo "</table><br/>";
        include("includes/paginacao.php");
    
    }    
	
    }

}
?>
