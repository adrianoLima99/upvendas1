<script  type="text/javascript" src="js/jquery-1.6.1.js"></script> 

<script type="text/javascript">
   
    $(document).ready(function() {
        $(".mostra1").toggle(
        function() {
            $(".oculto1").fadeIn(); // ou slideDown()
        },
        function() {
            $(".oculto1").fadeOut(); // ou slideUp()
        }
    );
    });
    $(document).ready(function() {
        $(".mostra2").toggle(
        function() {
            $(".oculto2").fadeIn(); // ou slideDown()
        },
        function() {
            $(".oculto2").fadeOut(); // ou slideUp()
        }
    );
    });
    $(document).ready(function() {
        $(".mostra3").toggle(
        function() {
            $(".oculto3").fadeIn(); // ou slideDown()
        },
        function() {
            $(".oculto3").fadeOut(); // ou slideUp()
        }
    );
    });

</script>


<?php

class ListaCliente {

    private $nome;
    private $telefone;
    private $identificador;
    private $data1;
    private $data2;
    private $conn;

    function __construct() {
        $this->conn = new connection();
    }

    function listagem() {
        //formulario de pesquisa para cliente
        echo "<div id='formularios'>
        <fieldset>
         <legend>Pesquisa Cliente</legend>
            <form method='post' action='#'>
              <table>
               <tr>
                <td>Id Cliente:</td>
                 <td><input type='number' name='id' placeholder='Digite o Id do Cliente' title='informe o id do cliente'/></td>
              </tr> 
                <tr>
                <td>Nome</td>
                 <td><input type='text' name='nome' placeholder='Digite o Nome do Cliente' title='informe o nome do cliente'/></td>
              </tr>
                <tr>
                <td>Telefone</td>
                 <td><input type='text' name='telefone' placeholder='Digite o Numero do telefone' title='informe o numero do telefone'  onkeypress='return valPHONE(event,this);return false;'  maxlength='13' /></td>
              </tr>
                <tr>
                <td>(CPF/CNPJ)</td>
                 <td><input type='text' name='identificador' placeholder='Digite o Numero de identificação' title='informe o Numero de identificação'  maxlength='14'/></td>
              </tr>
               <tr>
		   <td> Periodo:</td>
                    <td><input type='text' name='data1' class='data' placeholder='data inicial' style='width:100px;'/>A
                   <input type='text' name='data2' class='data' placeholder=' data final' style='width:100px' /></td>
                  </tr>
                 
                <tr>
                 <td></td><td><input type='submit' name='pesquisar' value='pesquisar' class='botao'/></td>
              </tr>
            </table>
         </form>
       </fieldset>  
       <br/>
       <a href='?pg=pf'>Novo Cliente</a>
      </div>";
        
        if (isset($_POST['pesquisar'])) {
            //se telefone via get tiver sido passado 
            if (isset($_GET["telefone"])) {
                unset($_GET["telefone"]);
            }
            $this->clienteEncontrado($_POST['id'], $_POST['nome'], $_POST['telefone'], $_POST['identificador'], $_POST['data1'], $_POST['data2']);
        }
    }

    //verifica se o cliente existe no banco de dados
    public function clienteJaExiste() {
        if (isset($_GET["telefone"])) {
            $this->clienteEncontrado("", "", $_GET["telefone"], "");
        }
    }

    //funcao para pesquisar cliente
    function clienteEncontrado($id, $nome, $telefone, $identificador, $data1, $data2) {

        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirCliente&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM      
        if ($_SESSION["tipo"] == 0) {
            $empresa = "";
        } else {
            $empresa = " AND empresa_id=$_SESSION[empresaId]";
        }
        $condicao = "";
        //se id diferente de vazio
        if (!empty($id)) {
            $this->id = $id;
            $condicao = " AND id=" . $this->id;
        }
        //se nome diferente de vazio
        if (!empty($nome)) {
            $this->nome = $nome;
            $condicao = $condicao . " AND nome like'%$this->nome%'";
        }
        //se telefone diferente de vazio
        if (!empty($telefone)) {

            $this->telefone = removeMascaraTel($telefone);
            $condicao = $condicao . " AND (fone1='$this->telefone' OR fone2='$this->telefone' )";
        }
        //se identificador(CPF/CNPJ) diferente de vazio
        if (!empty($identificador)) {
            $this->identificador = $identificador;
            $condicao = $condicao . " AND  numero_documento='$this->identificador'";
        }
        if (!empty($data1) && !empty($data2)) {
            $this->data1 = formata_data_db($data1);
            $this->data2 = formata_data_db($data2);
            $condicao = $condicao . " AND data_cadastro BETWEEN '$this->data1' AND '$this->data2' ";
        }
        //gera consulta que lista cliente
        $sqlLista = $this->conn->query("SELECT id,tipo_pessoa,nome,logradouro,fone1,bairro,sexo,numero_documento  FROM cliente WHERE  ativo=0 $empresa $condicao ORDER BY nome ");
        echo "<div id='listagens'>
                         <br/>
                        <h3>Clientes Encontrados</h3>";
        if ($sqlLista->rowCount()) {
            echo "<h1>Total de Registros:" . $sqlLista->rowCount() . "</h1>";
            while ($l = $sqlLista->fetch(PDO::FETCH_OBJ)) {
                echo "<div class='accordionButton'>$l->nome </div>
                  <div class='accordionContent'>";


                //sql visita
                $visita = "SELECT V.id AS visita_id,V.ocorrencia_id,V.statusOcorrencia,V.data_visita,C.nome AS cliente,C.fone1,C.fone2,P.nome AS produto, VP.status,V.obs,F.id AS vendedor_id, F.nome AS vendedor
                                              FROM funcionario AS F INNER JOIN visita AS V ON F.id=V.vendedor_id
                                              INNER JOIN cliente AS C ON C.id=V.cliente_id 
                                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                              INNER JOIN produto AS P ON VP.produto_id=P.id
                                              where  V.cliente_id=$l->id
                                              AND V.ativo=0  order by V.data_visita DESC  ";
                $sqlVis = $this->conn->query($visita);
                //sql acompanhamento
                $acompanhados = "SELECT distinct A.id AS id_acom,A.data,A.obs,A.statusOcorrencia,A.ocorrencia_id,A.hora,C.nome AS cliente,V.id AS idVisita,V.gerente_vendas_id,V.vendedor_id,
                                VP.status,V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto 
                                FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id 
                                INNER JOIN cliente AS C ON V.cliente_id=C.id
                                INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                INNER JOIN produto AS P ON P.id=VP.produto_id
                                WHERE   V.cliente_id=$l->id  order by  data desc ";
                $sqlAcompanhados = $this->conn->query($acompanhados);
                //sql agendados
                $agendamento = "SELECT distinct A.*,F.id as id_func,AC.obs,F.nome,F.perfil,VP.status,P.nome as produto,V.id  AS id_visita,V.operador_id,V.gerente_vendas_id,V.vendedor_id,C.id as idCliente,C.nome as cliente,C.fone1,C.fone2
                              FROM agendamento_visita AS A INNER JOIN acompanhamento AS AC ON A.acompanhamento_id=AC.id
                              INNER JOIN visita AS V ON V.id=AC.visita_id
                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                              INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                              INNER JOIN produto AS P ON P.id=VP.produto_id
                              INNER JOIN cliente AS C ON V.cliente_id=C.id
                               WHERE  V.cliente_id=$l->id AND A.ativo=0  order by  data desc ";
                $sqlAgendados = $this->conn->query($agendamento);


                echo "    <table>
                       <tr>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>CPF/CNPJ</th>
                        <th>Endereço</th>
                        <th colspan='3'>Ação</th>
                       </tr>";
                echo " 
                                <tr>
                                   <td>$l->id</td>   
                                  <td>$l->nome</td>
                                  <td>" . formatar($l->fone1, 'fone') . "</td>
                                  <td>" . formatar($l->numero_documento, 'cpf') . "</td>  
                                  <td>$l->logradouro</td>    
                                  <td><a href='?pg=editarCliente&cliente=$l->id&pessoa=$l->tipo_pessoa'><img src='imagens/edita.png' title='editar'/></a></td>";

                if ($_SESSION["tipo"] != 5 || $_SESSION["tipo"] != 6) {
                    echo " <td><a href='#' onclick='excluir($l->id)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                }
                echo "<td><a href='?pg=visita&id=$l->id&pessoa=$l->tipo_pessoa' >Nova visita</a></td>     

                         </tr></table>";

                //tabela visitas
                echo "<div class='mostra3' /><h1>visita:" . $sqlVis->rowCount() . "</h1></div>
                    <div class='oculto3' style='display:none'>
                     <table>";
                if ($sqlVis->rowCount()) {

                    echo "<tr>
                        <th>Id</th>      
                         <th>Vendedor</th>
	 	         <th>Data</th>
			 <th>Produto</th>
                         <th>Status</th>
                         <th>Obs</th>
                         <th>Ocorr&ecirc;ncia</th>
     		 
		 </tr>";

                    $numreg = 5; // Quantos registros por página vai ser mostrado
                    if (!isset($_GET["pagina"])) {
                        $_GET["pagina"] = 0;
                    }
                    $inicial = $_GET["pagina"] * $numreg;

                    //######### FIM dados Paginação
                    // Faz o Select pegando o registro inicial até a quantidade de registros para página
                    $limiteV = $this->conn->query($visita . " LIMIT $inicial, $numreg");

                    // Serve para contar quantos registros você tem na seua tabela para fazer a paginação
                    //$sql_conta =$sqlLista->rowCount();
                    $quantreg = $sqlVis->rowCount();
                    //$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

                    include("includes/paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>

                    echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo

                    while ($lV = $limiteV->fetch(PDO::FETCH_OBJ)) {

                        if ($lV->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($lV->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($lV->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        if ($lV->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$lV->visita_id&tabela=visita' title='adicionar ocorrencia'>Adicionar</a> ";
                        } else {
                            $ocorrencia = "Sim,<a href='?pg=resolverOcorrencia&id=$lV->visita_id&tabela=visita'>Resolver ocorr&ecirc;ncia</a> ";
                        }

                        echo "<tr>
                 <td>$lV->visita_id</td>                                   
                 <td>$lV->vendedor</td>
                 <td>" . formata_data($lV->data_visita) . "</td>
                 <td>$lV->produto</td> 
                 <td>$status</td>    
                 <td>$lV->obs</td>  
                 <td>$ocorrencia</td>
               </tr> ";
                    }
                } else {
                    echo "<p style='color:red;font-weight:bold'>Nenhum Registro Encontrado!</p>";
                }
                echo "</table>";

                echo "</div>";




                //tabela acompanhamento

                echo "<div class='mostra1'><h1>Acompanhados:" . $sqlAcompanhados->rowCount() . "</h1></div>
                    <div class='oculto1' style='display:none'>";
                if ($sqlAcompanhados->rowCount()) {
                    echo " 	<table>
          		<tr>
          		    <th>Id Acompanhamento</th>
			    <th>Gerente De Vendas</th>
			    <th>Vendedor</th>
                            <th>Produto</th>
                            <th>Status</th>
			    <th>Observação</th>
			    <th>Data Acompanhado</th>
			    <th>Hora</th>
			    <th>Agendado</th>
			    <th>ocorr&ecirc;ncia</th>
                       </tr>
                       <tr>";
                    $numreg = 5; // Quantos registros por página vai ser mostrado
                    if (!isset($_GET["pagina"])) {
                        $_GET["pagina"] = 0;
                    }
                    $inicial = $_GET["pagina"] * $numreg;

                    //######### FIM dados Paginação
                    // Faz o Select pegando o registro inicial até a quantidade de registros para página
                    $limiteAC = $this->conn->query($acompanhados . " LIMIT $inicial, $numreg");

                    // Serve para contar quantos registros você tem na seua tabela para fazer a paginação
                    //$sql_conta =$sqlLista->rowCount();
                    $quantreg = $sqlAcompanhados->rowCount();
                    //$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

                    include("includes/paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>

                    echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo

                    while ($lAC = $limiteAC->fetch(PDO::FETCH_OBJ)) {
                        if ($lAC->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($lAC->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($lAC->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        //verifica se foi agendado
                        $agendados = $this->conn->query("SELECT acompanhamento_id FROM agendamento_visita WHERE acompanhamento_id = $lAC->id_acom");
                        if ($agendados->rowCount()) {
                            $this->resposta = 'sim';
                        } else {
                            $this->resposta = 'não';
                        }
                        if ($lAC->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$lAC->id_acom&tabela=acompanhamento' title='adicionar ocorrencia'>Adicionar</a> ";
                        } else if ($lAC->statusOcorrencia == 1) {
                            $c = $this->conn->query("SELECT id,cargo_responsavel FROM ocorrencia WHERE id=$lAC->ocorrencia_id");
                            $r = $c->fetch(PDO::FETCH_OBJ);
                            $ocorrencia = "";
                            if ($r->cargo_responsavel == $_SESSION["func_id"] || $_SESSION["tipo"] == 0) {
                                $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$lAC->id_acom&tabela=acompanhamento'>Resolver</a> ";
                            }
                            $ocorrencia = "Sim," . $ocorrencia;
                        }

                        echo "<tr>
                      <td>$lAC->id_acom</td>
                      <td>$lAC->nome</td>";
                        $sqllistVendedor = $this->conn->query("SELECT * FROM funcionario WHERE id=$lAC->vendedor_id");
                        $mostre = $sqllistVendedor->fetch(PDO::FETCH_OBJ);

                        echo "  <td>$mostre->nome</td>
                      <td>$lAC->produto</td> 
                      <td>$status</td>    
                      <td>$lAC->obs</td>
                      <td>" . formata_data($lAC->data) . "</td>
                      <td>$lAC->hora</td>
                      <td>$this->resposta</td> 
                      <td>$ocorrencia</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<p style='color:red;font-weight:bold'>Nenhum Registro Encontrado!</p>";
                }
                echo "  </table>  
                </div>";
                //tabela agendamento 
                echo "<div class='mostra2'><h1>Agendados:" . $sqlAgendados->rowCount() . "</h1></div>
                    <div class='oculto2' style='display:none'>
                       <table>";
                if ($sqlAgendados->rowCount()) {
                    echo "<tr>
                        <th>Id</th>
               	 	<th>Data</th>
               		<th>Hora</th>
                        <th>Operador de Telemarketing</th>
               		<th>Produto</th>
                        <th>Status</th>
                        <th>Fone 1</th>
               		<th>Fone 2</th>
               		<th>Gerente Vendas</th>
      			 <th>Vendedor</th>
                          <th>Ocorrência</th>
                      </tr>";
                    $numreg = 5; // Quantos registros por página vai ser mostrado
                    if (!isset($_GET["pagina"])) {
                        $_GET["pagina"] = 0;
                    }
                    $inicial = $_GET["pagina"] * $numreg;

                    //######### FIM dados Paginação
                    // Faz o Select pegando o registro inicial até a quantidade de registros para página
                    $limiteAG = $this->conn->query($agendamento . " LIMIT $inicial, $numreg");

                    // Serve para contar quantos registros você tem na seua tabela para fazer a paginação
                    //$sql_conta =$sqlLista->rowCount();
                    $quantreg = $sqlAgendados->rowCount();
                    //$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

                    include("includes/paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>

                    echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo

                    while ($lA = $limiteAG->fetch(PDO::FETCH_OBJ)) {

                        if ($lA->status == 0) {
                            $status = "<img src='imagens/status_vendido.png' alt='Vendido' title='Vendido' />";
                        } elseif ($lA->status == 1) {
                            $status = "<img src='imagens/status_quente.png' alt='Quente' title='Quente' />";
                        } elseif ($lA->status == 2) {
                            $status = "<img src='imagens/status_morno.png' alt='Morno' title='Morno' />";
                        }
                        //verifica se a existe ocorrencia		
                        if ($lA->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$lA->id&tabela=agendamento' title='adicionar ocorrencia'>Adicionar</a> ";
                        } else if ($lA->statusOcorrencia == 1) {
                            $c = $this->conn->query("SELECT id FROM ocorrencia WHERE id=$lA->ocorrencia_id");
                            $r = $c->fetch(PDO::FETCH_OBJ);
                            $ocorrencia = "";
                            if ($r->responsavel == $_SESSION["tipo"] || $_SESSION["tipo"] == 0) {
                                $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$lA->id&tabela=agendamento'>Resolver</a> ";
                            }
                            $ocorrencia = "Sim," . $ocorrencia;
                        }
                        echo "<tr>
                                <td>$lA->id</td>
                                <td>" . formata_data($lA->data) . "</td>
                                <td>$lA->hora</td>";
                        $listoperador = $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$lA->operador_id");
                        $exibir = $listoperador->fetch(PDO::FETCH_OBJ);
                        echo "    <td>$exibir->nome</td>         
                                <td>$lA->produto</td>    
                                <td> $status</td>    
                               <td>$lA->fone1</td>
                                <td>$lA->fone2</td>";
                        $sqlger = $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$lA->gerente_vendas_id");
                        $sqlVendedor = $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$lA->vendedor_id");
                        $listGerente = $sqlger->fetch(PDO::FETCH_OBJ);
                        $listVendedor = $sqlVendedor->fetch(PDO::FETCH_OBJ);
                        echo "       <td>$listGerente->nome</td>    
                                <td>$listVendedor->nome</td>
                                <td>$ocorrencia</td>
                          </tr>";
                    }
                } else {
                    echo "<p style='color:red;font-weight:bold'>Nenhum Registro Encontrado!</p>";
                }
                echo "</table>";


                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<h3>Nenhum registro encontrado!<h3>";
        }

        echo "</div>";
    }

    //EXCLUI 
    function excluirCliente($id) {

        $exc = $this->conn->exec("UPDATE cliente SET ativo=-1 WHERE id=$id ");
        if ($exc) {
            echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                  location.href='?pg=listaDeCliente';
                    </script>";
        }
    }

}
?>
