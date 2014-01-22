<?php

class Visitados {

    private $id;
    private $data1;
     private $data2;
    private $vendedor;
    private $gerente;
    private $status;
    private $conn;
    private $clausula;

    function __construct() {
        $this->conn = new connection();
    }

  public function listagem(){
      
     if($_SESSION["tipo"]==0){
         $empresa="";
       }else{
         $empresa="AND F.empresa_id=$_SESSION[empresaId]";
    }
        //pega data atual
        $dia = date("Y-m-d");
        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirVisita&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
        echo "<div id='listagens'>
  
  	<h3>Listagem de Visita</h3> ";
        
        $visibilidade = "";
        if ($_SESSION['tipo'] == 3) {
            $visibilidade = " AND V.gerente_vendas_id=$_SESSION[func_id]";
        } else if ($_SESSION['tipo'] == 6) {
           $visibilidade = " AND V.vendedor_id=$_SESSION[func_id]";
        } 
            //usuario q cadastrou
            $listaGerente = $this->conn->query("SELECT distinct F.nome,F.id  FROM funcionario AS F INNER JOIN visita AS V  ON F.id = V.usuario_cadastro
                                              WHERE V.ativo=0  $visibilidade AND V.data_visita='$dia' $empresa");
        

        //lista os gerente e suas visitas
        if ($listaGerente->rowCount()) {
            
            while ($list = $listaGerente->fetch(PDO::FETCH_OBJ)) {
                
                $sqlLista = $this->conn->query("SELECT V.id AS visita_id,V.ocorrencia_id,V.statusOcorrencia,V.data_visita,V.gerente_vendas_id,C.nome AS cliente,C.fone1,C.fone2,P.nome AS produto, VP.status,V.obs,F.id AS vendedor_id, F.nome AS vendedor
                                                FROM funcionario AS F INNER JOIN visita AS V ON F.id=V.vendedor_id
                                                INNER JOIN cliente AS C ON C.id=V.cliente_id 
                                                INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                INNER JOIN produto AS P ON VP.produto_id=P.id 
						where V.usuario_cadastro=$list->id 
						AND V.data_visita='$dia'
						AND V.ativo=0 
                                                $visibilidade
						$empresa
						order by cliente DESC ");

                echo "<div class='accordionButton'>$list->nome  <br/>Quantidade Visitas:".$sqlLista->rowCount()."</div>
					   <div class='accordionContent'>";
                
                if ($sqlLista->rowCount()) {

             echo " <table>
                      <tr>
                        <th>Codigo da Visita</th>      
                        <th>Gerente de vendas</th> 
                        <th>Vendedor</th>
	 	 	
                        <th>Data </th>
			 <th>Cliente</th>
			 <th>Telefone </th>
                       
                         <th>Veiculo</th>
                         <th>Status</th>
                         <th>Obs</th>
                         <th>Ocorr&ecirc;ncia</th>
                         <th colspan='2'>Ações</th>
			 
                     </tr>";
                    while ($l = $sqlLista->fetch(PDO::FETCH_OBJ)) {

                        if ($l->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($l->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($l->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        if ($l->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$l->visita_id&tabela=visita'>Adicionar </a> ";
                        } else {
                            $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$l->visita_id&tabela=visita'>Resolver</a> ";
                        }
         echo "<tr>
                 <td>$l->visita_id</td>";
                    $listGer=  $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$l->gerente_vendas_id");
                    $exibirGer=$listGer->fetch(PDO::FETCH_OBJ);
        echo      "<td>$exibirGer->nome</td>                                    
                 <td>$l->vendedor</td>
                 <td>" . formata_data($l->data_visita) . "</td>
                 <td>$l->cliente</td>
                 <td>$l->fone1</td> 
               
                 <td>$l->produto</td>
                 <td>$status</td>    
                 <td>$l->obs</td>
                   <td> $ocorrencia</td>
                  <td><a href='?pg=editarVisita&visita=$l->visita_id'><img src='imagens/edita.png' title='tem ocorrencia'/></a></td>
                  <td><a href='#' onclick='excluir($l->visita_id)'><img src='imagens/excluir.gif' title='tem ocorrencia'/></a></td>    
                </tr>    
                          ";
                    }
                    echo "</table>";
                } else {
                    echo "<h3 style='color:red'>Nenhum Registro Encontrado!</h3>";
                }
                echo "</div>";
            }
        } else {
            echo "<h3 style='color:red'>Nenhum Registro Encontrado!</h3>";
        }
        echo "</div>";
    }

    function listagemDetalhada($id, $data1, $data2, $gerente, $vendedor, $status) {
        
         //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirVisita&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
        
        
        if($_SESSION["tipo"]==0){
           $empresa="";
         }else{
             $empresa="AND F.empresa_id=$_SESSION[empresaId]";
         }
       
       
        if ($status == 3) {

            $this->status = 0;
        } else {
            $this->status = $status;
        }
      
        
        //se gerente de vendas
        if ($_SESSION['tipo'] == 3) {
            $this->clausula = " AND V.gerente_vendas_id=$_SESSION[func_id]";
        }else if ($_SESSION['tipo'] == 6) {
        
            $this->clausula = " AND (V.usuario_cadastro=$_SESSION[id] || V.vendedor_id=$_SESSION[func_id])";
        
        } else {
            $this->clausula = "";
        }
       
        

        $condicao = "";
       if (!empty($gerente)) {
           $this->gerente=$gerente;
               $condicao = $condicao . "  AND V.gerente_vendas_id=$this->gerente ";
            if (!empty($vendedor)) {
                $this->vendedor=$vendedor;
                $condicao = $condicao . "  AND V.vendedor_id=$this->vendedor ";
            }
        }
        if (!empty($id)) {
            $this->id=$id;
            $condicao = $condicao . " AND V.id=$this->id";
        }
        if (!empty($data1) && !empty($data2)) {
            $this->data1 = formata_data_db($data1);
            $this->data2 = formata_data_db($data2);
            $condicao = $condicao . " AND V.data_visita BETWEEN '$this->data1' AND '$this->data2' ";
        }
        if (!empty($status)) {
            $condicao = $condicao . "   AND VP.status=$this->status";
        }
        
       
        $listaGerente = $this->conn->query("SELECT  distinct F.id,F.nome AS gerente FROM funcionario AS F 
                                            INNER JOIN visita AS V ON F.id=V.usuario_cadastro
                                            INNER JOIN visita_produto AS VP  ON VP.visita_id=V.id
                                            WHERE  V.ativo=0 $empresa  $condicao ");


        echo "<div id='listagens'>
            <h3>Listagem de Visita</h3> ";
        if ($_SESSION['tipo'] == 3) {
            $visibilidade = " AND F.id=$_SESSION[func_id]";
        } else {
            $visibilidade = "";
        }

        if ($listaGerente->rowCount()) {
            while ($list = $listaGerente->fetch(PDO::FETCH_OBJ)) {
              
                $sqlLista = $this->conn->query("SELECT distinct V.id as visita,V.statusOcorrencia,V.gerente_vendas_id,V.obs,V.data_visita,F.id,F.nome AS vendedor,P.nome as produto,
                                                C.nome as cliente,C.fone1,C.fone2,VP.status 
                                                FROM     visita V INNER JOIN funcionario F ON V.vendedor_id=F.id 
                                                INNER JOIN visita_produto VP ON VP.visita_id=V.id
                                                INNER JOIN produto P    ON P.id=VP.produto_id
                                                INNER JOIN cliente C    ON C.id=V.cliente_id
                                                 where  V.ativo=0  AND V.usuario_cadastro=$list->id
                                                 $condicao
                                                 $this->clausula
                                                    $empresa
                                                 ORDER BY cliente");

                echo "<div class='accordionButton'>$list->gerente  <br/>Quantidade Visitas:".$sqlLista->rowCount()."</div>
        	   <div class='accordionContent'>";
                    
                if ($sqlLista->rowCount()) {
              echo "<table cellspacing=0 cellpadding=0 border=1 width='800px'>
                <tr>
                        <th>Codigo Visita</th>  
                        <th>Gerente vendas</th>
                        <th>Vendedor</th>
	 	 	<th>Data da Visita</th>
			 <th>Cliente</th>
			 <th>Fone</th>
                        <th>Produto</th>
                         <th>Status</th>
                         <th>Obs</th>
                          <th>Ocorr&ecirc;ncia</th>
                         <th colspan='2'>Ações</th>
			 
                </tr>";

                    while ($linha = $sqlLista->fetch(PDO::FETCH_OBJ)) {
                        if ($linha->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($linha->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($linha->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        if ($linha->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$linha->visita&tabela=visita'>Adicionar</a> ";
                        } else {
                            $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$linha->visita&tabela=visita'>Resolver </a> ";
                        }
                        echo "<tr>
                  <td>$linha->visita</td>";
                    $listGer=  $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$linha->gerente_vendas_id");
                    $exibirGer=$listGer->fetch(PDO::FETCH_OBJ);
        echo      "<td>$exibirGer->nome</td>    
                 <td>$linha->vendedor</td>
                 <td>" . formata_data($linha->data_visita) . "</td>
                 <td>$linha->cliente</td>
                 <td>$linha->fone1</td> 
                
                 <td>$linha->produto</td>
                  <td>$status</td>    
                 <td>$linha->obs</td>  
                 <td>$ocorrencia</td>
                  <td><a href='?pg=editarVisita&visita=$linha->visita'><img src='imagens/edita.png' title='editar'/></a></td>
                    <td><a href='#' onclick='excluir($linha->visita)'><img src='imagens/excluir.gif' title='excluir'/></a></td>     
                          </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<br/><h3>nenhum registro encontrado</h3>";
                }
                echo "</div>";
            }
            echo "</div>";
        }else{    echo "<br/><h3 style=color:red>nenhum registro encontrado</h3>";}
    }

    function pesquisaVisita() {
        
        if($_SESSION["tipo"]==3 ){
            $visibilidade = " AND  id=$_SESSION[func_id] ";
          }else{
             $visibilidade = "";
        }
        
  echo "<div id='formularios'>
            <fieldset>
               <legend>Pesquisar Visita</legend>
              <table>
                   <form method='post' action='#'>
                   <tr>
                  	<td>Id visita</td>
                  	<td><input type='number' name='id' placeholder='Insira o id visita'/></td>
                  </tr>
                  <tr>
		   <td> Periodo:</td>
                    <td><input type='text' name='data1' class='data' placeholder='data inicial' style='width:100px;'/>A
                   <input type='text' name='data2' class='data' placeholder=' data final' style='width:100px' /></td>
                  </tr>
                 
                 ";
         if($_SESSION['tipo'] == 3){
            echo "<td><input type='hidden' name='vendedor' value='".$_SESSION["func_id"]."'/>";
                       
         }else if($_SESSION['tipo'] == 6){
          echo   "<tr>
                       <td><input type='hidden' name='vendedor' value='".$_SESSION["func_id"]."'/>
                             
                    		</select> 
                   		 </td>"; 
            
       }else{
            $sql = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=3 $visibilidade");
            echo " <td>Gerente Vendas:</td>
                    <td><select  name='gerente' id='gerente'  placeholder='Gerente de vendas' onchange = selecionaVendedor() >
                     <option value=''>Selecione o gerente</option> ";
            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                echo " <option value='$row->id'>$row->nome</option>";
            }
            echo " </select> </td>
            	      </tr>
                	  <tr>
                    	<td> Vendedor:</td>
                    	<td><select name='vendedor' id='exibir'>
                            <option></option>
                                
                    		</select> 
                   		 </td>";
        }

        echo " </tr> 
                  <tr>
                    <td> Status:</td>
                    <td><select name='status' >
                           <option ></option>     
                           <option value='00'>Vendidos</option>
                            <option value='1'>Quente</option>
                             <option value='2'>Morno</option>
                           
                    </select> 
                    </td>
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

            $this->listagemDetalhada($_POST['id'], $_POST['data1'], $_POST['data2'],  $_POST['gerente'], $_POST['vendedor'], $_POST['status']);
        } else {
            $this->listagem();
        }
    }

    //EXCLUI 
    function excluirVisita($id) {

        $exc = $this->conn->exec("UPDATE visita SET ativo=-1 WHERE id=$id ");
        if ($exc) {
            echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                  location.href='?pg=visitados';
                    </script>";
        }
    }

}

?>
