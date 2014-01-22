<?php
class EdicaoTelemarketing {

	private $conn;
	private $associacao;
	private $codigo;
	private $gerente;
	private $operador;
	private $dataAssociacao;
	function __construct() {
		$this -> conn = new connection;
	}

	function frmEdicao($visita_id) {
		
            $alteracao = $this -> conn -> query("SELECT V.id,F.nome,F.id
                                                FROM visita AS V INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                                 WHERE V.id=$visita_id
                                                AND V.empresa_id=$_SESSION[empresaId]
                                        ");
		$rs = $alteracao -> fetch(PDO::FETCH_OBJ);
		echo "
           <div id='formularios'>
           <fieldset>
           <legend>Alterar Associação</legend>
            <form action='#' method='post'>
              <table>
                <tr>
                    <td>Id visita:</td>
                    <td><input type='text' name='visita_id' value='$visita_id' readonly /></td>
                </tr>
                <tr>
                      <td>Operador Telemarketing:</td>
                      <td><select name='operador' >
                          <option value='$rs->id'>$rs->nome</option>";
                          if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 || $_SESSION["tipo"]==2 || $_SESSION["tipo"]==4  ){
                             $selOperador = $this -> conn -> query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=5 AND id<>$rs->id ");
                             while ($Op = $selOperador -> fetch(PDO::FETCH_OBJ)) {
                                 echo "        <option value='$Op->id'>$Op->nome</option>";
                            }
                          } 
		echo "
                      </td>
               </tr>
               <tr>
                     <td></td>
                     <td><input type='submit' name='alterar' value='Atualizar' class='botao'/></td>
                 
               </tr>
               
             </table>
            </form>
          </fieldset>
        </div> ";
		if (isset($_POST['alterar'])) {
			$this -> atulaizarAssociacao($_POST['visita_id'],$_POST['operador']);
		}
	}


	function atulaizarAssociacao($visita_id,$operador) {
		
		$atual = $this -> conn -> exec("UPDATE visita SET operador_id= $operador    WHERE id=$visita_id AND empresa_id=$_SESSION[empresaId]");
		if ($atual) {
                    echo "<script type='text/javascript'>alert('Atualização feita com sucesso')
                            location.href='?pg=editarTele';
                         </script>";
            	}
	}
        
     public  function pesquisaAssociacao() {
        if ($_SESSION['tipo'] == 0) {
            $visibilidade = "";
        } else{
             $visibilidade = " AND  empresa_id=$_SESSION[empresaId]";
        } 
          
        
    echo "<div id='formularios'>
             <br/><a href='#' onclick='MostraDiv()' style='hover:background-color:#CC0;'>Transferir de operador para operador</a><br/><br/>
                    <div id='conteudo' style='display:block'>
                            <fieldset>	
	    			<legend>Pesquisar Associações </legend>
	    		        <form method='post' action='#'>

                                      <table>
		    			  <tr>
                                             <td>Id :</td>
		    			      <td><input type='number' name='id'  placeholder='insira a codigo de visita'/></td>
		    			   </tr>
		    			   <tr>
		    			       <td>Periodo :</td>
		    				<td><input type='text' name='data1' class='data' placeholder='inicio' style='width:100px'/>A
		    				    <input type='text' name='data2' class='data' placeholder='fim'  style='width:100px'/>
		    				</td>
		    			    </tr>
                                             <tr>
		    			       <td>Status:</td>
		    				<td><select name='status'>
                                                        <option value=''>Selecione</option>
                                                        <option value='1'>Quente</option>
                                                        <option value='2'>Morno</option>
                                                     </select>
		    				</td>
		    			    </tr>
		    			    <tr>
				                <td>Operador Telemarketing:</td>
				                <td><select  name='operador'>
				                    		 <option value=''>Selecione</option> ";
                                                    $sql = $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND perfil=5 $visibilidade");
                                                    while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                                        echo " <option value='$row->id'>$row->nome</option>";
                                                    }
                                                    echo " </select> </td>
                                            </tr>
                                             <tr>
		                  	       <td></td>
		                    		<td><input class='botao' type='submit' name='buscar' id='buscar' value='Buscar'/></td>
		                      	   </tr>		
		       		  </table>
              		      </form>
		    	 </fieldset>
                         <br/>
                        <a href='javascript:history.go(-1)'>Voltar</a>  
                     </div>   
    		  </div>
               <br/>
                 ";
               $this->passaPara();                                    
               if(isset($_POST["buscar"])){
                   $this->pesquisaDetalhada($_POST["id"],$_POST["data1"], $_POST["data2"], $_POST["operador"], $_POST["status"]);
               }                                     
    }

    function pesquisaDetalhada($id, $data1, $data2, $operador,$status) {

        echo "<script type='text/javascript'>
               function exclua(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirTele&visita_id='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";

        $condicao = "";
        if (!empty($id)) {
            $condicao = $condicao . " AND  V.id=$id";
        }
        if (!empty($operador)) {
            $condicao = $condicao . " AND V.operador_id=" . $operador;
        }
         if (!empty($status)) {
            $condicao = $condicao . " AND VP.status=" . $status;
        }
        if (!empty($data1) && !empty($data2)) {
            $d1 = formata_data_db($data1);
            $d2 = formata_data_db($data2);

            $condicao = $condicao . " AND  V.data_visita BETWEEN '$d1' AND '$d2'";
        }

        $sq = $this->conn->query("SELECT SQL_CACHE V.id AS visita_id,V.data_visita,VP.status,F.nome,F.id,C.nome AS cliente,C.fone1,C.fone2,C.logradouro,C.bairro,C.email,C.data_nascimento,C.sexo,C.numero_documento
                                    FROM visita AS V INNER JOIN funcionario AS F ON F.id = V.operador_id
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                    INNER JOIN cliente AS C ON C.id=V.cliente_id
                                    WHERE V.ativo=0 AND F.ativo=0
                                    $condicao
                                    ORDER BY V.operador_id DESC");

      if($sq->rowCount()){
        echo "<h3>Associações</h3>";
        echo "<div id='listagens'>
             <table>
              <th>Id Visita</th>
              <th>Operador de Telemarketing</th>
              <th>Cliente</th>
              <th>Fone</th>
              <th>Status</th>
              <th>Data</th>
              <th  colspan='2'>Ação</th>
              ";
        while ($lista = $sq->fetch(PDO::FETCH_OBJ)) {
              
                if ($lista -> status == 1) {
                    $sta = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
        	} elseif ($lista -> status == 2) {
                    $sta = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                }
				
            echo "<tr>
                    <td>$lista->visita_id</td>
                    <td>$lista->nome</td>
                    <td>$lista->cliente</td>
                    <td>$lista->fone1</td>
                     <td>$sta</td>
                    <td>".formata_data($lista->data_visita)."</td>     
                    <td><a href='?pg=editarTele&visita_id=$lista->visita_id'><img src='imagens/edita.png' title='editar'/></a></td> 
                   <td><a href='#' onclick='exclua($lista->visita_id)'><img src='imagens/excluir.gif' title='excluir'/></a></td>     
                </tr>";
        }
        echo "</table>
             </div>";
        }else{
            echo "<h3 style='color:red;'>Nenhum registro encontrado!</h3>";
        }
    }
     //transfere as visita de 1 operadora para outra 
    function passaPara() {
        echo "<div id='formularios'>
                 <div id=conteudo2 style='display:none'>
                        <fieldset>	
                            <legend>Transferência</legend>
                              <form method='post' action='#'>
                                <table>
                                    <tr>
                                      <td>De:</td>
                                      <td><select name='op1'>
                                            <option value=''>Selecione</option>";
                                            $list = $this->conn->query("SELECT SQL_CACHE distinct F.id,F.nome,F.ativo,count(*) as contador
                                                                        FROM funcionario AS F INNER JOIN visita AS V ON V.operador_id=F.id
                                                                        INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                                        WHERE V.ativo=0 AND V.empresa_id=$_SESSION[empresaId] AND V.acompanhado=0 AND VP.status<>0 AND F.empresa_id=$_SESSION[empresaId] group by F.id");
                                             while ($rs = $list->fetch(PDO::FETCH_OBJ)) {
                                              if($rs->ativo==0){
                                                 echo "<option style='color:green;font-weight:bold;' value=$rs->id>$rs->nome($rs->contador)</option>";
                                               }else{
                                                echo "<option style='color:red;font-weight:bold;' value=$rs->id>$rs->nome($rs->contador)</option>";
                                              }     
                                             }
                                    echo "</select>
                                        </td>
                                     </tr>
                                     <tr>
                                       <td>Para:</td>
                                       <td><select name='op2'>
                                              <option value=''>Selecione</option>";
                                         $lists = $this->conn->query("SELECT SQL_CACHE distinct  id,nome FROM funcionario  WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=5 ");
                                          while ($rss = $lists->fetch(PDO::FETCH_OBJ)) {
                                              echo "<option value=$rss->id>$rss->nome</option>";
                                            }
                                     echo "</select>
                                          </td>
                                        </tr> 
                                        <tr>
                                          <td>Quantidade </td>
                                           <td><input type='text' name='qtd'/></td>
                                        </tr>
                                        <tr>
                                            <td><input type='submit' name='transferir' value='transferir' class='botao'/></td>
                                        </tr>
                                     </table>   
                                     </form>
                                </fieldset>
                             </div>    
                       </div>";
        if (isset($_POST["transferir"])) {
            $this->transferencia($_POST["op1"], $_POST["op2"], $_POST["qtd"]);
        }
    }
    public function transferencia($op1, $op2, $qtd) {
        $sqlT = $this->conn->query("SELECT F.id,F.nome FROM visita AS V INNER JOIN funcionario AS F ON V.operador_id=F.id 
                                    WHERE V.operador_id=$op1 AND V.ativo=0 AND V.empresa_id=$_SESSION[empresaId] AND F.empresa_id=$_SESSION[empresaId] ");
       //verifica  a quantidade de visitas que o operador possui
        $qtdOP = $sqlT->rowCount();
       //verifica se a quantidade passada é igual ou menor a que ele possui ..para poder fazer a transferencia
        if (($qtd <= $qtdOP) || empty($qtd)) {
            $clausula = "";
           
            if (!empty($qtd)) {
                $clausula = $clausula . "  LIMIT $qtd";
            }
         
            $atua = $this->conn->query("UPDATE visita SET operador_id=$op2 WHERE operador_id=$op1 AND ativo=0 AND acompanhado=0  $clausula");
           
            if ($atua) {

                echo "<script type='text/javascript'>alert('Transferencia feita com sucesso')
                  location.href='?pg=editarTele';
                    </script>";
            }
        
       }else{
               echo "<script type='text/javascript'>
                        alert('Quantidade inserida é superior a quantidade que o operador possui!')
                      </script>"; 
        }
    }
    
    public function excluir($id) {
       if(!empty($id)){
       	
		 $exc = $this -> conn -> exec("UPDATE visita SET operador_id=0  WHERE id=$id ");
		if ($exc) {
			echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                  location.href='?pg=editarTele';
                    </script>";
		}
		
      }else{
      	 	echo "<script type='text/javascript'>alert('Não foi possivel passar o codigo registro')
                  
                    </script>";
      }
		
	}

}
?>
