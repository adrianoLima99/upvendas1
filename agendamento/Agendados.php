<script type='text/javascript'>
    selecionaGerOpRel()
</script>
<?php

//fazer upload
class Agendados {

    private $conn;
    private $cliente;
    private $telFixo;
    private $cel1;
    private $cel2;
    private $visibilidade;

    function __construct() {
        $this->conn = new connection;
    }

    function visao() {
        
    }

    function listar() {
        $hoje = date('Y-m-d');
        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function exclua(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluiAgendamento&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
        echo "<div id='listagens'>
        <h3>Agendados</h3>";
        //verifica se usuario é um gerente de vendas
        if($_SESSION['tipo'] == 0){
            $cond="";
        }else{ 
            $cond="AND F.empresa_id=$_SESSION[empresaId]";
        }
        if ($_SESSION['tipo'] == 3) {
            $this->visibilidade = " && V.gerente_vendas_id=$_SESSION[func_id]";
        } else {

            $this->visibilidade = "";
        }
        //verifica se usuario é um operador
        if ($_SESSION['tipo'] == 5) {
            $condicaoOperador = " && V.operador_id=$_SESSION[func_id]";
        } else {

            $condicaoOperador = "";
        }
        
     //gera a lista dos gerentes de vendas  
        $listaGerente = $this->conn->query("SELECT distinct F.nome,F.id  FROM funcionario AS F  INNER JOIN agendamento_visita AS AG ON F.id = AG.responsavel
                                            INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                                            INNER JOIN visita AS V ON V.id=AC.visita_id
                                            WHERE AG.data='$hoje' $this->visibilidade   $condicaoOperador AND AG.ativo=0 AND AC.ativo=0");
       //verifica se retornou algum resultado 
        if ($listaGerente->rowCount()) {
            while ($list = $listaGerente->fetch(PDO::FETCH_OBJ)) {
                $consulta = $this->conn->query("SELECT distinct A.*,F.id as id_func,AC.obs,F.nome,F.perfil,VP.status,V.id  AS id_visita,V.operador_id,C.id as idCliente,C.nome as cliente,C.fone1,C.fone2
                                                FROM agendamento_visita AS A INNER JOIN acompanhamento AS AC ON A.acompanhamento_id=AC.id
                                                INNER JOIN visita AS V ON V.id=AC.visita_id
                                                INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                INNER JOIN funcionario AS F ON F.id=A.responsavel
                                                INNER JOIN produto AS P ON P.id=VP.produto_id
                                                INNER JOIN cliente AS C ON V.cliente_id=C.id
						WHERE   A.data='$hoje'  AND A.responsavel=$list->id $cond
                                                AND A.ativo=0	");
                
                echo "<div class='accordionButton'>Responsavel: $list->nome <br/>Quantidade: ".$consulta->rowCount()."</div>
	         <div class='accordionContent'>";

                
                if ($consulta->rowCount()) {
                    echo "<table>
            		<tr>
                           <th>Id</th>
                           <th>Data Agendada</th>
                           <th>Hora Agendada</th>
                           <th>Operador de Telemarketing</th>
                           <th>Cliente</th>
                           <th>Status</th>
                           <th>Obs</th>
                           <th>Fone</th>
                           <th>Responsavel</th>
                           <th>Ocorr&ecirc;ncia</th> ";
                    //acao de excluir e editar so é ativada pra usuario: UPGRADE,MASTER,ADMINSTRADOR,GERENTE TELEMARKETING
                    if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 4) {
                        echo " <th colspan='2'>Ações</th>";
                    }
                    echo "</tr>";
                    //CRIA O LAÇO COM AS INFORMAÇÕES
                    while ($linha = $consulta->fetch(PDO::FETCH_OBJ)) {
                        
                        //operador
                         $list_operador = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND id=$linha->operador_id AND empresa_id=$_SESSION[empresaId]");
                        $lo = $list_operador->fetch(PDO::FETCH_OBJ);

                        //VERIFICA O STATUS DA VISITA : VENDIDO = 0,QUENTE=1,MORNO=2
                        if ($linha->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($linha->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($linha->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        //VERIFICA SE EXISTE OCORRÊNCIA: 0= Ñ EXISTE, 1= EXISTE
                        if ($linha->statusOcorrencia == 0) {
                            
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$linha->id&tabela=agendamento_visita'>Adicionar</a> ";
                   
                        } else {
                           
                            $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$linha->id&tabela=agendamento_visita'>Resolver </a> ";
                        }


               echo "<tr>
                    <td>$linha->id</td>
                    <td>" . formata_data($linha->data) . "</td>
                    <td>$linha->hora</td>";
            echo "  <td>$lo->nome</td> ";
            echo "  <td>$linha->cliente</td>
                    <td> $status</td>
                     <td>$linha->obs</td>    
                    <td>$linha->fone1</td>
                    <td>$linha->nome</td>    
                    <td>$ocorrencia</td>";
                    //acao de excluir e editar so é ativada pra usuario: UPGRADE,MASTER,ADMINSTRADOR,GERENTE TELEMARKETING
                    if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 4) {
                            echo " <td><a href='?pg=editaAgenda&idAgenda=$linha->id'><img src='imagens/edita.png' title='editar'/></a></td>
                                  <td><a href='#' onClick='exclua($linha->id)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                        }
                  echo "</tr>";
                }
                echo '</table>';
            } else {
                    echo "Nenhum Registro Encontrado!";
            }
                echo "</div>";
          }
        } else {
            echo "<h3>Nenhuma Visita Agendada!</h3>";
      }
    }

    function listagemDetalhada($id, $data1, $data2, $gerente, $vendedor,$status,$operador) {

        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function exclua(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluiAgendamento&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
        //verifca se é super
        if($_SESSION['tipo'] == 0){
                  $empresa=" ";
        }else{
                $empresa=" AND F.empresa_id=$_SESSION[empresaId]" ;
        }
        
        if ($_SESSION['tipo'] == 3) {
            $this->visibilidade = " && V.gerente_vendas_id=$_SESSION[func_id]";
        } else {

            $this->visibilidade = "";
        }
        
       /* //verifica se usuario é um operador
        if ($_SESSION['tipo'] == 5) {
            $condicaoOperador = " && V.operador_id=$_SESSION[func_id]";
        } else {

            $condicaoOperador = "";
        }
        */
        $cond = "";
        //condicoes pelo parametro passado
        if (!empty($id)) {
            $this->id = $id;
            $cond = $cond . "AND V.id=$this->id ";
        }
        //se as data diferente de vazio
        if (!empty($data1) && !empty($data2)) {
            $this->data1 = formata_data_db($data1);
            $this->data2 = formata_data_db($data2);
            $cond = $cond . " AND AG.data BETWEEN '$this->data1' AND '$this->data2'";
        }
        //se as gerente vendas diferente de vazio
        if (!empty($gerente)) {
            $this->gerente = $gerente;
            $cond = $cond . " AND V.gerente_vendas_id=$this->gerente";
        }
        //se as vendedor diferente de vazio
        if (!empty($vendedor)) {
            $this->vendedor = $vendedor;
            $cond = $cond . " AND V.vendedor_id=$this->vendedor";
        }
        
       if(!empty($status)){
            $cond=$cond." AND VP.status=$status" ;
        }
        if(!empty($operador)){
            $cond=$cond." AND V.operador_id=$operador" ;
        }
        //se cliente diferente de vazio
        if (!empty($cliente)) {
          
            $cond = $cond . " AND V.cliente_id=$cliente";
        }


        echo "<div id='listagens'>
	  <h3>Listagem de Agendados</h3> ";

        $listaGerente = $this->conn->query("SELECT distinct F.nome,F.id  FROM funcionario AS F  INNER JOIN agendamento_visita AS AG ON F.id = AG.responsavel
                                            INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                                            INNER JOIN visita AS V ON V.id=AC.visita_id
                                            WHERE   F.ativo=0 AND AG.ativo=0 $cond $this->visibilidade
                                             ");

        if ($listaGerente->rowCount()) {

            while ($list = $listaGerente->fetch(PDO::FETCH_OBJ)) {

 

                $sqlLista = $this->conn->query("SELECT AG.id,AG.data,AG.hora,AG.ocorrencia_id,AG.statusOcorrencia,V.operador_id,V.id AS idVis,V.vendedor_id,VP.status,
                                                  F.id AS idFunc,F.nome,C.id AS idCli,C.nome AS cliente,C.fone1,C.sexo 
                                                  FROM visita AS V INNER JOIN acompanhamento AS AC ON AC.visita_id=V.id
                                                 INNER JOIN agendamento_visita AS AG ON AG.acompanhamento_id=AC.id    
                                                 INNER JOIN visita_produto  AS VP ON VP.visita_id=V.id
                                                 INNER JOIN funcionario AS F ON F.id = AG.responsavel 
                                                 INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                 WHERE  F.ativo=0 AND AG.ativo=0
                                                 AND AG.responsavel=$list->id
                                                 $cond
                                                $empresa
                                                 ORDER BY  AG.data DESC   ");
             
             
                $list_operador = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0  AND empresa_id=$_SESSION[empresaId]");
                $lo = $list_operador->fetch(PDO::FETCH_OBJ);

                
                //SE A PESQUISA FOR BASEADA SOMENTE NA DATA(abertura)
                //if (!empty($this->gerente) || !empty($this->vendedor)) {
                    echo "<div class='accordionButton'>Responsavel: $list->nome <br/>Quantidade: ". $sqlLista->rowCount()."</div>
	   		<div class='accordionContent'>";
                //}

                if ($sqlLista->rowCount()) {
                    echo "<table>
                <tr>
                   <th>Id </th>
                    <th>Data </th>
                    <th>Hora </th>
                    <th>Operador de Telemarketing</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Telefone </th>
                   <th>Gerente Vendas</th>
                    <th>Vendedor</th>
                    <th>Ocorr&ecirc;ncia</th>
                   ";

                    if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2) {
                        echo "              <th colspan='2'>Ação</th>";
                    }
                    echo "         </tr>";

                    while ($linha = $sqlLista->fetch(PDO::FETCH_OBJ)) {
                        if ($linha->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($linha->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($linha->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        if ($linha->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$linha->id&tabela=agendamento_visita'>Adicionar </a> ";
                        } else {
                            $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$linha->id&tabela=agendamento_visita'>Resolver </a> ";
                        }

                        echo "<tr>
                   <td>$linha->id</td>
                   <td>".formata_data($linha->data) . "</td>
                   <td>$linha->hora</td>";  
                      //lista operador  
                     $sqlOperador = $this->conn->query("SELECT nome FROM funcionario WHERE id=$linha->operador_id");
                    $lo = $sqlOperador->fetch(PDO::FETCH_OBJ) ;
                                                
            echo " <td>$lo->nome</td>
                   <td>$linha->cliente</td>
                   <td>$status</td>    
                   <td>$linha->fone1</td>
                   <td>$linha->nome</td>";
                    //lista vendedor
                    $sqlVd = $this->conn->query("SELECT nome FROM funcionario WHERE id=$linha->vendedor_id");
                    $lv = $sqlVd->fetch(PDO::FETCH_OBJ);
                    
            echo" <td>$lv->nome</td>
                  <td>$ocorrencia</td>";
                        
                  if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2) {
                  echo "<td><a href='?pg=editaAgenda&idAgenda=$linha->id'><img src='imagens/edita.png' title='editar'/></a></td>
                         <td><a href='#' onClick='exclua($linha->id)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<br/><h3>Nenhum registro encontrado!</h3>";
                }

                echo "</div>";
            }
        } else {
            echo "<h3>Não ha Agendamentos registrados! </h3>";
        }
    }

    function pesquisaAgendados() {

        if ($_SESSION['tipo'] == 3) {
            $clausula = " AND id=$_SESSION[func_id]";
        } else {
            $clausula = "";
        }
        //if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 5) {


        echo "<div id='formularios'>
	    <fieldset>
            <legend>Pesquisar Agendados</legend>
              <table>
                 <tr>
                  <form method='post' action='#'>
                   <tr>
                  	<td>Id Visita</td>
                  	<td><input type='number' name='id' placeholder='Insira o id visita'/></td>
                  </tr>
                  <tr>
		    <td>Periodo :</td>
                    <td><input type='text' name='data1' class='data' placeholder='Insira a data inicio' style='width:100px;'/>A
                   <input type='text' name='data2' class='data' placeholder='Insira a data final' style='width:100px' /></td>
                  </tr>
                  <tr>
                   <td>Gerente Vendas:</td>";
             if ($_SESSION['tipo'] != 3) {
                 $sql = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=3 ");
                 
              echo " <td><select  name='gerente' id='gerente'  placeholder='Gerente de vendas' onchange = selecionaVendedor() >
                          <option></option> " ;
               while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                echo " <option value='$row->id'>$row->nome</option>";
                }
             echo  "  </select> </td>    ";
            } else {
    
                $sql = $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND id=$_SESSION[empresaId] ");
                $listger=$sql->fetch(PDO::FETCH_OBJ);
                echo "<td><select name=gerente >
                            <option value=''>Selecione</option>
                            <option value='$listger->id'>$listger->nome</option>>
                        </td>";
        }
       
        echo " 
                  </tr>
                  <tr>
                    <td> Vendedor:</td>
                    <td><select name='vendedor' id='exibir'>
                          <option></option>
                    </select> 
                    </td>
                  </tr>";
           if($_SESSION["tipo"]!=5){
            echo "<tr> 
                      <td>Gerente Telemarketing:</td>
                       <td><select name='gerenteTelemarketing' id='exibiGerTel' onchange='selecionaOperador2()'>
                             <option value=''>Selecione</option>";
                             
            echo "          </select></td>
                  </tr>
                  <tr>
                     <td>Operador(a) Telemarketing:</td>
                       <td><select name='operador' id='operador'>
                            </select></td>
                 </tr>";          
                  }else{
                     echo "<input  type='hidden' name='operador'  value='$_SESSION[func_id]'/>";
                  }
   echo "        
                  <tr>
                      <td>Status</td>
                      <td><select name='status'>
                           <option value=''>Selecione status</option>
                           <option value='1'>Quente</option>
                          <option value='2'>Morno</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input class='botao' type='submit' name='buscar' id='buscar' value='Buscar'/></td>
                  </form>
                 </tr>
               </table>
              </fieldset>    
                </div>";
       

        if (isset($_POST['buscar'])) {
            $this->listagemDetalhada($_POST["id"], $_POST['data1'], $_POST['data2'], $_POST['gerente'], $_POST['vendedor'], $_POST['status'], $_POST['operador']);
        } else {
            $this->listar();
        }
    }

    //EXCLUI AGENDAMENTO
    function excluiAgendados($id) {
        //atualiza o valor do ativo para -1
        $exc = $this->conn->exec("UPDATE agendamento_visita SET ativo=-1 WHERE id=$id ")or die("deu erro");
        if ($exc) {
            echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                  location.href='?pg=agendamento';
                    </script>";
        }
    }

}

?>
