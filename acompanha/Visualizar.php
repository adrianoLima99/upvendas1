<?php

class Visualizar {

    private $data;
    private $vendedor;
    private $gerente;
    private $status;
    private $conn;
    private $clausula;

    function __construct() {
        $this->conn = new connection();
    }

    function listagem($id) {

                //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirAcompanhamento&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
       
        echo " <div id='formularios'> 
                <div id='listagens'>
  
  	<h3>Listagem de Acompanhamento</h3> ";
        
         

                $sqlLista = $this->conn->query("SELECT  A.id AS id_acom,A.data,A.obs,A.statusOcorrencia,A.resposta_id,A.hora,A.data,C.nome AS cliente,C.sexo,C.fone1,C.fone2,C.email,V.id AS idVisita,
                                                V.gerente_vendas_id,V.vendedor_id,V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.status,PL.nome as plano,P.valor, 
                                                M.nome as cidade,Es.nome as uf
                                                FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id 
                                                INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                INNER JOIN produto AS P ON P.id=VP.produto_id
                                                INNER JOIN plano AS PL ON PL.id=VP.plano_id
                                                INNER JOIN municipio as M ON M.id=C.municipio_codigo
                                                INNER JOIN estado as Es ON Es.id=M.estado_uf
                                                WHERE  A.ativo=0 AND  A.id=$id ");
             


                if ($sqlLista->rowCount()) {
                    $l = $sqlLista->fetch(PDO::FETCH_OBJ);
                     if ($l->status == 0) {
                            $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                        } elseif ($l->status == 1) {
                            $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                        } elseif ($l->status == 2) {
                            $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                        }
                        if ($l->statusOcorrencia == 0) {
                            $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$l->id_acom&tabela=acompanhamneto'>Adicionar</a> ";
                        } else {
                            $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$l->id_acom&tabela=acompanhamento'>Resolver</a> ";
                        }
                    echo " <table>
                       
                  <tr>
                      <td>Id</td> 
                      <td>$l->id_acom</td>  
                      <td><a href='?pg=editarAcom&idAcom=$l->id_acom'><img src='imagens/edita.png' title='editar '/></a></td>
                      <td>   <a href='#' onclick='excluir($l->id_acom)'><img src='imagens/excluir.gif' title='excluir '/></a></td> 
                  </tr>
                   <tr>
                     <td>Cliente</td>
                     <td>$l->cliente</td>
	 	 </tr>
                    <tr>
                     <td>Gerente vendas</td>
                     <td>$l->nome</td>
	 	 </tr>
                  <tr>";
                    $listaVendedor=  $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND id=$l->vendedor_id");
                     $exibirVendedor=$listaVendedor->fetch(PDO::FETCH_OBJ);
            echo"   <td>Vendedor</td>
                     <td>$exibirVendedor->nome</td>
	 	 </tr>
                  
                 <tr>
                     <td>Data Cadastro</td>
                     <td>" . formata_data($l->data) . "</td> 
                </tr>
                <tr>
                     <td>Hora Cadastro</td>
                     <td>$l->hora</td> 
                </tr>
		 <tr>
                    <td>Sexo</td>
                    <td>$l->sexo</td>
                </tr>
                <tr>
                    <td>Cidade</td>
                    <td>$l->cidade</td>
                </tr>
                <tr>
                    <td>Uf</td>
                    <td>$l->uf</td>
                </tr>
               <tr>
                    <td>Email</td>
                    <td>$l->email</td>
                </tr> 
                <tr> 
                     <td>Fone 1</td>
                     <td>$l->fone1</td> 
                </tr>
                <tr> 
                     <td>Fone 2</td>
                      <td>$l->fone2</td> 
                <tr>
                      <td>Veiculo</td>
                     <td>$l->produto</td> 
                </tr>
                <tr>
                      <td>Valor R$</td>
                     <td>$l->valor</td> 
                </tr>
                <tr>
                     <td>Status</td>
                     <td>$status</td>  
               </tr>
               <tr>
                     <td>Plano</td>
                     <td>$l->plano</td>  
               </tr>
               <tr>
                    <td>Obs</td>
                    <td>$l->obs</td> 
               </tr>
               <tr>
                    <td>ocorr&ecirc;ncia</td>
                      <td>$ocorrencia</td>
               </tr>
              ";
                 

                      
                    
                    echo "</table>";
                } else {
                    echo "<h3 style='color:red'>Nenhum Registro Encontrado!</h3>";
                }
              
       
        echo "</div></div>";
        $this->conn=NULL; 
    }
}

?>
