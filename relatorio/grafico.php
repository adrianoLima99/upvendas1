<?php
session_start();
include_once '../conexao/conexao.class.php';
require_once 'phplot.php';
//SetFileFormat("png");
# Output the start of the HTML page:


$grafico = new PHPlot(1300, 600);

#Indicamos o títul do gráfico e o título dos dados no eixo X e Y do mesmo




$grafico->SetLegendPixels(50, 0);
$grafico->SetPrecisionY(1);

//$grafico->SetLineWidth(1);
//cria conexao
$conn = new Connection();

//CLAUSULA PARA CONsULTA

/*/*if(empty($_GET["emxp"])){
     
    $empresa="";
     
}else{
   
     $empresa=" AND F.empresa_id=$_GET[emxp]";
 }
 */
 
if(isset($_GET["adm"])){
$adm = $_GET["adm"];
    
}
if(isset($_GET["operador"])){
    $operador=$_GET["operador"];
}
if(isset($_GET['gerV'])){
        $gerente = $_GET['gerV'];
}
if(isset( $_GET['vend'])){
    $vendedor = $_GET['vend'];
}
if(isset($_GET['data'])){
    $data = $_GET['data'];
}
if(isset( $_GET['periodo1'])){
    $periodo1 = $_GET['periodo1'];
}
if(isset($_GET['periodo2'])){
    $periodo2 = $_GET['periodo2'];
}

$clausula = "";
            
        
//grafico de vendas
 if ($_GET['opc'] == "venda") {
                      if (!empty($_GET['periodo1']) && !empty($_GET['periodo2'])) {
                               $clausula = $clausula . " AND  VN.data BETWEEN '$periodo1' AND '$periodo2'";
                          }
                         if (!empty($_GET['data'])) {
                               $clausula = $clausula . " AND  VN.data like'%$data%'";
                        }
    //grafico por vendedor
        if (!empty($_GET['gerV']) || !empty($_GET['vend'])) {
                $titulo = "Vendedor";
               
                $sql = $conn->query("SELECT F.nome,F.id,count(V.vendedor_id) AS contador
                                    FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id
                                    INNER JOIN funcionario AS F ON F.id = V.vendedor_id
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                    WHERE VP.status=0 AND VN.ativo=0 AND V.ativo=0 AND F.ativo=0 $clausula GROUP BY V.vendedor_id");

        } else {
                $titulo = " Gerentes de vendas";
               
                
                $sql = $conn->query("SELECT F.nome,F.id,count(V.gerente_vendas_id) AS contador
                                    FROM vendas AS VN  INNER JOIN visita AS V ON V.id=VN.visita_id
                                    INNER JOIN funcionario AS F ON F.id = V.gerente_vendas_id
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                    WHERE VP.status=0 AND VN.ativo=0 AND  V.ativo=0 AND F.ativo=0 $clausula   GROUP BY  V.gerente_vendas_id");

        }


            $grafico->SetTitle(utf8_decode("Gráfico de Venda"));
            $grafico->SetXTitle($titulo);
            $grafico->SetYTitle("Quantidade de vendas");

    
}  else if ($_GET['opc'] == "visita") {
             if(!empty($_GET['status'])){
                    $clausula=$clausula." AND VP.status=".$_GET['status'];
             }
            if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
                $clausula=$clausula." AND  V.data_visita BETWEEN '$periodo1' AND '$periodo2'"; 	
             }
             if(!empty($_GET['data'])){
 	 	$clausula=$clausula." AND  V.data_visita like'%$data%'"; 	
            }
            if(!empty($_GET["emxp"])){
               $clausula=$clausula." AND F.empresa_id=$_GET[emxp]";
           }
           if (!empty($_GET['gerente'])) {
                $clausula =$clausula." AND ( V.gerente_vendas_id=$_GET[gerente] || F.superior_id=$_GET[gerente]) ";
         }

            
       if (!empty($_GET['gerente'])) {
                $titulo = "Vendedor";
                $group = " GROUP BY V.vendedor_id";
        } else {
                $titulo = " Gerentes de vendas";
                $group = " GROUP BY V.gerente_vendas_id";
        }    
                 
                 
                 $sql = $conn->query("SELECT count(V.gerente_vendas_id) as contador,F.nome,F.id FROM visita AS V 
                                      INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                      INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                      WHERE V.ativo=0 AND F.ativo=0  $clausula $group");
                
      

    $grafico->SetTitle(utf8_decode("Gráfico de Visita"));
    $grafico->SetXTitle($titulo);
    $grafico->SetYTitle("Quantidade de visitas");
				
				
		

//GRAFICO ACOMPANAHMENTO                         
} else if ($_GET['opc'] == "ac") {
    $grafico->SetTitle(utf8_decode("Gráfico de Acompanhamento"));
        $grafico->SetXTitle("Operador(a) de Telemarketing");
         $grafico->SetYTitle("Quantidade de Acompanhamento");
         
        if (!empty($_GET['gerenteTele'])){
              $clausula=$clausula." AND  F.superior_id=$_GET[gerenteTele]";  
          } 
        if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
            
                $clausula=$clausula." AND  AC.data BETWEEN '$periodo1' AND '$periodo2'"; 	
             }
             if(!empty($_GET['data'])){
 	 	$clausula=$clausula." AND  AC.data like'%$data%'"; 	
            }
            
           if(!empty($operador)){
               $clausula=$clausula." AND V.operador_id=$_GET[operador]";
           } 
           if(empty($_GET["emxp"])){
               $clausula=$clausula." AND F.empresa_id=$_GET[emxp]";
           }
           
        $sql = $conn->query("SELECT count(V.operador_id) AS contador,F.nome,F.superior_id 
                             FROM acompanhamento AS AC INNER JOIN visita AS V ON AC.visita_id=V.id
                             INNER JOIN funcionario AS F ON F.id=V.operador_id
                             WHERE AC.ativo=0 AND F.ativo=0  $clausula group by V.operador_id");
  
} else if ($_GET['opc'] == "ag") {
       
            if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
                $clausula=$clausula." AND  AG.data BETWEEN '$periodo1' AND '$periodo2'"; 	
             }
             if(!empty($_GET['data'])){
 	 	$clausula=$clausula." AND  AG.data like'%$data%'"; 	
            }
            if (!empty($operador)) {
             	$clausula=$clausula." AND  V.operador_id=$operador"; 	
           
            }
             if(!empty($_GET["emxp"])){
               $clausula=$clausula." AND F.empresa_id=$_GET[emxp]";
           }


        $grafico->SetTitle(utf8_decode("Gráfico de Agendamento"));
        $grafico->SetXTitle("Operador(a) de Telemarketing");
         $grafico->SetYTitle("Quantidade de Agendamento");

    $sql = $conn->query("SELECT F.nome,count(F.id) AS contador,F.id, AG.data,AG.hora
                         FROM agendamento_visita AS AG 
                         INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                         INNER JOIN visita AS V ON V.id=AC.visita_id
                         INNER JOIN funcionario AS F ON V.operador_id=F.id 
                         WHERE F.ativo=0  AND AC.ativo=0 $clausula group by F.id");

    
} else if ($_GET['opc']=="pen"){
       
            if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
                $clausula=$clausula." AND  AG.data BETWEEN '$periodo1' AND '$periodo2'"; 	
             }
             if(!empty($_GET['data'])){
 	 	$clausula=$clausula." AND  AG.data like'%$data%'"; 	
            }
            if (!empty($operador)) {
             	$clausula=$clausula." AND  V.operador_id=$operador"; 	
           
            }
             if(!empty($_GET["emxp"])){
               $clausula=$clausula." AND F.empresa_id=$_GET[emxp]";
           }


        $grafico->SetTitle(utf8_decode("Gráfico de Pendência"));
        $grafico->SetXTitle("Operador(a) de Telemarketing");
         $grafico->SetYTitle("Quantidade ");
         
   

    $sql = $conn->query("SELECT  V.gerente_vendas_id,V.vendedor_id,F.id as idFunc,F.nome,F.perfil,count(AG.id) as contador,AG.data,AG.hora 
                         FROM acompanhamento AS A INNER JOIN visita AS V ON V.id=A.visita_id 
                         INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id=A.id 
                         INNER JOIN funcionario AS F ON F.id=V.operador_id 
                         INNER JOIN cliente AS C ON V.cliente_id=C.id 
                         INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                         INNER JOIN produto AS P ON P.id=VP.produto_id 
                         INNER JOIN plano AS PL ON PL.id=VP.plano_id 
                         WHERE  AG.ativo=0 $clausula  AND A.ativo=0 AND V.ativo=0 AND VP.ativo=0 AND F.ativo=0 group by V.operador_id");
}


while ($resultado = $sql->fetch(PDO::FETCH_OBJ)) {
    if ($_GET['opc'] == "cliente") {

        $dados[] = array($resultado->id_cliente, $resultado->nome);
        $grafico->SetLegend($resultado->nome);
    } else if ($_GET['opc'] == "venda") {
     
            $n = explode(" ", $resultado->nome);
            $param = $resultado->id . "-" . $n[0];
            $dados[] = array($param, $resultado->contador);
      
    } else if ($_GET['opc'] == "visita") {

        if (!empty($_GET['gerV'])) {

            $n = explode(" ", $resultado->nome_vendedor);
            $param = $resultado->id_vendedor . "-" . $n[0];
            $dados[] = array($param, $resultado->contador);
        } else {
            $n = explode(" ", $resultado->nome);
            $param = $resultado->id . "-" . $n[0];
            $dados[] = array($param, $resultado->contador);
        }
    } else if ($_GET['opc'] == "ac") {
        
        $dados[] = array($resultado->nome, $resultado->contador);
 
    } else if ($_GET['opc'] == "ag") {

            $n = explode(" ", $resultado->nome);
            $param = $resultado->id . "-" . $n[0];
            $dados[] = array($param, $resultado->contador);
        
    } else if ($_GET['opc'] == "pen") {

            $n = explode(" ", $resultado->nome);
            $dados[] = array($resultado->nome,$resultado->contador);
        
    }
    
}


$grafico->SetDataValues($dados);


#Neste caso, tipo de gráfico 
//if($_GET['tGraf']=="bars"){
$grafico->SetDataType("text-data");
$grafico->SetPlotType("bars");


//}elseif($_GET['tGraf']=="area"){
//$grafico->SetPlotType("area");
//}elseif($_GET['tGraf']=="pie"){
//	 $grafico->SetPlotType("pie");
//	 $grafico->SetDataType("text-data-single");
//}
$grafico->SetYDataLabelPos('plotin');
#Exibimos o gráfico
$grafico->DrawGraph();
?>


