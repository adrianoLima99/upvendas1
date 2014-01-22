<?php

class Pesquisa {

    private $conn;
    private $id;
    private $condGerente;
    private  $condData;

    function __construct() {
        $this->conn = new connection();
    }

    function listagemGerente($id,$operador,$data1,$data2) {
      
   $this->id = $id;
   	$cond="";
	if(!empty($this->id)){
		 $cond =$cond. " && V.id= $this->id";
	}
	
	
          if(!empty($operador)){
        	 $cond =$cond. " && V.operador_id= $operador";
	 }
   
   if(!empty($data1) AND !empty($data2)){
   
   	 $cond=$cond." && V.data_cadastro  BETWEEN '".formata_data_db($data1)."' AND '".formata_data_db($data2)."'";
   }    
       
       echo "
             <div id='listagens'>
            <h3>Registros Encontrados: </h3> ";
 //SE ESTIVE LOGADO COMO OPERADOR   
      
       if ($_SESSION['tipo'] == 5) {
             
            $condicao=" AND V.operador_id=".$_SESSION['func_id'];
       }else if ($_SESSION['tipo'] == 7) {
             
            $condicao=" AND V.vendedor_id=".$_SESSION['func_id'];
       }else{
            $condicao="";
       }		
          
           
           
       
       //ABAIXO AS ASSOCIACOES NORMAIS  
      
               $sqlLista = $this->conn->query("SELECT  V.id AS visita,F.id,F.nome,F.perfil ,VP.status,C.id,C.nome AS cliente,P.id, P.nome AS produto,V.obs,V.data_cadastro,V.acompanhado,
                                                V.operador_id,V.vendedor_id,V.gerente_vendas_id
                                                FROM visita AS V INNER JOIN funcionario AS F ON F.id=V.vendedor_id  
                                                INNER JOIN cliente AS C ON C.id = V.cliente_id
                                                INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                INNER JOIN produto AS P ON P.id=VP.produto_id
                                                WHERE  V.acompanhado =0 AND V.ativo=0   $condicao   $cond 
                                                AND VP.status <>0 AND V.operador_id<>0
                                                AND F.empresa_id=$_SESSION[empresaId] ORDER BY V.id ");
      if ($sqlLista->rowCount()) {
           	
            echo "<div class='accordionButton'>Quantidade: ".$sqlLista->rowCount()."</div>
        	   <div class='accordionContent'>";
   
                echo "<table>
                        <tr>
                            <th>Id Visita</th>
                            <th>Operador Telemarketing</th>
                            <th>Data Cadastro</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Produto</th>
                            <th>Obs</th>
                            <th>Acompanhamento</th>
                        </tr>";
                
                  while ($l = $sqlLista->fetch(PDO::FETCH_OBJ)) {
                     //seleciona operador
                      $sqlOp=$this->conn->query("SELECT id,nome FROM funcionario  WHERE id=$l->operador_id AND ativo=0");
                       $row=$sqlOp->fetch(PDO::FETCH_OBJ);
                      //fim selecao
                      if ($l -> status == 0) {
                                        	$status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
					     } elseif ($l -> status == 1) {
						$status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
					     } elseif ($l -> status == 2) {
						$status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
					     }
echo "                <tr>
                          <td>$l->visita</td>";
                          echo "<td>$row->nome</td>";
                          echo "<td>".formata_data($l->data_cadastro)."</td>
                          <td>$l->cliente</td>
                          <td>$status</td>     
                          <td>$l->produto</td>
                          <td>$l->obs</td>";
                          if($l->acompanhado==0){
                         		echo  "<td><a href='?pg=acompanha&operador=$row->nome&idOP=$row->id&vendedor=$l->nome&idVend=$l->vendedor_id&visita=$l->visita&gerente=$l->gerente_vendas_id'>Novo</a></td>
                      </tr>"; 	
                          }else{
                       			echo  "<td style='color:green'>Acompanhado</td>
                      </tr>";   	
                          }
                         
                  }
                
            } else {
               echo "Nenhum Registro Encontrado";
           } 
          
           
         
             echo "</table>";
            echo "</div>";
        
        
       
    }

    

}

?>
