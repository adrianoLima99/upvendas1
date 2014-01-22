

<?php
session_start();
if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 ){

set_time_limit(0);
ini_set("memory_limit","1G");

ob_start();

 include_once '../conexao/conexao.class.php';
 include_once '../mascaras/formatacao.php';
include_once '../formataData.php';
 define('MPDF_PATH', '../includes/mpdf/');
  include_once(MPDF_PATH.'mpdf.php');
  
 
 
 class ComissaoPDF{ 
     private $stylesheet;
     private $mpdf;
   function __construct() {
        $this->conn = new Connection();
        $this->mpdf=new mPDF();
        $this->stylesheet = file_get_contents('../css/relatorioComissao.css');
    }
  public function lista(){ 
      $clausula="";
     $this->mpdf->WriteHTML($this->stylesheet,1);
if ($_SESSION["tipo"] == 0) {
    $empresa = "";
    $cliente = "";
} else {
    $empresa = " AND F.empresa_id=" . $_SESSION["empresaId"];
    $cliente = " AND C.empresa_id=$_SESSION[empresaId]";
}
if (!empty($_GET["periodo1"]) && !empty($_GET["periodo2"])) {
    $periodo = formata_data($_GET["periodo1"]) . " a " . formata_data($_GET["periodo2"]);
    $data = "AND VN.data BETWEEN '" .$_GET["periodo1"] . "' AND '" .$_GET["periodo2"] . "'";
} else {
    $periodo = "Geral";
    $data = "";
}

$this->mpdf->WriteHTML("<div id='listagens'>");

$this->mpdf->WriteHTML("<table class='tabela'>");

$administradorMaster = $this->conn->query("SELECT id,nome ,cargo_id,salario FROM  funcionario 
                                            WHERE ativo=0  AND empresa_id=$_SESSION[empresaId] AND perfil=1");

if ($administradorMaster->rowCount()) {
    $executaquery = $administradorMaster->fetch(PDO::FETCH_OBJ);

    $comissaoM = 0;
    $producaoM = 0;
    $comissaoM = 0;
    
    $totalVendaM=0;
    // $comissao=0;
    //seleciona a comissao e faixa esperada
    $sqlComissaoMaster = $this->conn->query("SELECT nome,comissao,producao FROM comissao WHERE cargo_id=$executaquery->cargo_id  AND empresa_id=$_SESSION[empresaId]");
    $resultado = $sqlComissaoMaster->fetch(PDO::FETCH_OBJ);
    //quantidade vendida pelos vendedores
     $vendasTotal = $this->conn->query("SELECT count(V.vendedor_id) AS contador,V.vendedor_id,F.salario,F.cargo_id,VN.data,VN.id
                                              FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                              INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                              WHERE V.ativo=0 AND VN.ativo=0  AND F.empresa_id=$_SESSION[empresaId] $clausula $data ORDER BY F.nome");
    //mostra o resultado da consulta de vendedores e vendas
    $producaoMaster = $vendasTotal->fetch(PDO::FETCH_OBJ);
    //fa a soma dos produto que o vendedor Vendeu
    $sqlSomaSubordinados = $this->conn->query("SELECT SUM(P.valor)AS valor FROM visita AS V INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                                                 INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                                 INNER JOIN produto AS P ON P.id=VP.produto_id
                                                                 INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                                                 WHERE VN.ativo=0 AND V.ativo=0 AND  VP.ativo=0 AND P.ativo=0 $data  AND F.empresa_id=$_SESSION[empresaId] ");
 
//exibir a soma 
    $somaFinal = $sqlSomaSubordinados->fetch(PDO::FETCH_OBJ);
    $totalVendaM=   $somaFinal->valor ;
    
    //calcula comissao
    $comissaoM = $executaquery->salario + ($somaFinal->valor * ($resultado->comissao / 100));



   $this->mpdf->WriteHTML("
                    <h3>Relatorio de Comissão</h3>
                      <tr>
                       <th colspan='11' style='text-align:left;' >Administrador Master: $executaquery->nome  </th>
                            
                   </tr>
                   <tr>
                        <th>Produção</th>
                         <th>Meta</th>
                         <th colspan=2>Nome comissão</th>
                         <th>Comissão(%) </th>
                         <th>Total venda</th>
                          <th>Salário</th>
                         <th colspan=2>Salário + Comissão</th>
                        <th colspan=2>Periodo</th>
                  </tr>
                  <tr>
                      <td> $producaoMaster->contador  </td>   
                      <td> $resultado->producao </td>
                      <td colspan=2>$resultado->nome</td>    
                      <td>$resultado->comissao</td>
                      <td>R$ ".moeda($totalVendaM)."</td>    
                      <td>R$" .moeda($executaquery->salario) . "</td>
                      <td colspan=2>R$" . moeda($comissaoM) . "</td>    
                      <td colspan=2>$periodo</td>    
                   </tr>
                   ");
} 
//LISTA GERENTE DE VENDAS E SUBORDINADOS
$sqlGerenteVendas = $this->conn->query("SELECT V.gerente_vendas_id,F.nome,F.id as funcid ,V.id,F.cargo_id,F.salario,VN.data
                                          FROM visita AS V  INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id
                                          INNER JOIN vendas AS VN ON VN.visita_id=V.id
                                          INNER JOIN municipio AS M ON F.municipio_codigo=M.id
                                          INNER JOIN estado AS E ON E.id=M.estado_uf
                                          WHERE V.ativo=0  AND VN.ativo=0 AND F.ativo=0 $empresa $data $clausula GROUP BY V.gerente_vendas_id");

//ultimo dia dos mes
//  date("t/m/Y");
$comissaoG = 0;
$producaoGerente = 0;
$comissaoGerente = 0;
$comissao = 0;



while ($lista = $sqlGerenteVendas->fetch(PDO::FETCH_OBJ)) {


    $comissaoV = "";
    $nomeComissaoGer = "";
    $nomeComissaoGerSub = "";
    $pagoProgerenteSubordinado = 0;
    $pagoaoGerente = 0;
    $valorSoma = 0;
    $somaExibida->valor = 0;

    //consulta a quantigdade vendas do vendedor

    $quantidadeVendidaGerente = $this->conn->query("SELECT count(V.gerente_vendas_id) FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id WHERE V.gerente_vendas_id=$lista->gerente_vendas_id AND VN.data='$lista->data'");

    $vendasGerenteVendas = $quantidadeVendidaGerente->rowCount();
    //consulta a meta e comissao referente a gerente vendas   

    $selecionarComissaoGerenteVendas = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND (funcionario_id=$lista->gerente_vendas_id || cargo_id=$lista->cargo_id)");


    if ($selecionarComissaoGerenteVendas->rowCount()) {

        while ($intervaloGerenteVendas = $selecionarComissaoGerenteVendas->fetch(PDO::FETCH_OBJ)) {

            $nomeComissaoGer = $intervaloGerenteVendas->nome;

            $producaoGerente = $intervaloGerenteVendas->producao;

            $comissaoGerente = $intervaloGerenteVendas->comissao;
            //intervalo da producao
            $intervaloValoresGerente = explode("-", $intervaloGerenteVendas->producao);

            if ($intervaloValoresGerente[0] >= $vendasGerenteVendas && $vendasGerenteVendas <= $intervaloValoresGerente[1]) {
                //fa a soma dos produto que o vendedor Vendeu
                $somaGerenteVendas = $this->conn->query("SELECT SUM(P.valor)AS valor FROM visita AS V INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                                     INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                                     INNER JOIN produto AS P ON P.id=VP.produto_id
                                                     INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                                                     WHERE VN.ativo=0 AND V.ativo=0 AND VN.data='$lista->data' AND  VP.ativo=0 AND P.ativo=0 AND V.vendedor_id=$lista->funcid ");
                //exibir a soma 
                $somaExibidaGerenteVendas = $somaGerenteVendas->fetch(PDO::FETCH_OBJ);

                $valorSoma = $somaExibidaGerenteVendas->valor;

                $pagoaoGerente = $somaExibidaGerenteVendas->valor * ( $intervaloGerenteVendas->comissao / 100);
            }
        }
    }
    //faz a soma dos produto que o vendedor Vendeu
    $comissaoSobreSubordinado = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE ativo=0  AND empresa_id=$_SESSION[empresaId] AND subordinado=1 AND (funcionario_id=$lista->gerente_vendas_id || cargo_id=$lista->cargo_id) ");
    $executeComissaoSobreSubordinado = $comissaoSobreSubordinado->fetch(PDO::FETCH_OBJ);
    if ($comissaoSobreSubordinado->rowCount()) {

        $nomeComissaoGerSub = $executeComissaoSobreSubordinado->nome;
        $comissaoParaGerente = $executeComissaoSobreSubordinado->comissao;
    } else {
        $comissaoParaGerente = 0;
    }
    //sobre subordinado
    $sqlSomaV = $this->conn->query("SELECT SUM(P.valor)AS valor FROM visita AS V INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                    INNER JOIN produto AS P ON P.id=VP.produto_id
                                    INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                                    WHERE VN.ativo=0 AND V.ativo=0 AND  VP.ativo=0 AND P.ativo=0  AND V.gerente_vendas_id=$lista->gerente_vendas_id AND V.vendedor_id<>$lista->gerente_vendas_id ");

    //exibir a soma 
    $somaExibidaV = $sqlSomaV->fetch(PDO::FETCH_OBJ);
    //calcula comissao
    $pagoProgerenteSubordinado = $somaExibidaV->valor * ($comissaoParaGerente / 100);


    $comissaoG = $lista->salario + $pagoProgerenteSubordinado + $pagoaoGerente;

    $this->mpdf->WriteHTML( " <tr>
                    <th colspan='11' style='text-align:left;' >Gerente de Vendas:$lista->nome </th>
                     
                </tr> 
                 <tr>
                     <th>Produção</th>
                     <th>Meta</th>
                     <th>Nome comissão</th>
                     <th>Comissão</th>
                     <th>Comissão sobre subordinado</th>
                     <th>Sobre subordinado</th>
                     <th>Total da venda</th>
                     <th>Salário</th>
                     <th>Salário + Comissão</th>
                     <th colspan=2>Periodo</th>
                </tr>
                <tr>
                    <td> $vendasGerenteVendas</td>   
                     <td>  $producaoGerente</td> 
                     <td>$nomeComissaoGer</td>    
                     <td> $comissaoGerente % - R$ " . moeda($pagoaoGerente) . "</td>
                     <td>$nomeComissaoGerSub</td>    
                     <td> $comissaoParaGerente % -  R$ " . moeda($pagoProgerenteSubordinado) . "</td>
                     <td>R$ " . moeda($valorSoma) . "</td>    
                     <td>R$ " . moeda($lista->salario) . "</td>
                     <td>R$ " . moeda($comissaoG) . "</td>
                    <td colspan=2>$periodo</td>    
               </tr>
            ");
    
 
 $vendedores = $this->conn->query("SELECT V.vendedor_id,F.nome,F.salario,F.cargo_id,VN.data,VN.id
                                              FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                              INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                              WHERE V.ativo=0 AND VN.ativo=0  AND  V.gerente_vendas_id=$lista->gerente_vendas_id AND V.vendedor_id<>$lista->gerente_vendas_id AND VN.data='$lista->data' ORDER BY F.nome");

 if($vendedores->rowCount()){
    while ($listaVendedores = $vendedores->fetch(PDO::FETCH_OBJ)) {
        $nomeComissaoVendedor = "";
        //consulta a quantigdade vendas do vendedor
        $quantidadeVendida = $this->conn->query("SELECT count(V.vendedor_id) FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id WHERE V.vendedor_id=$listaVendedores->vendedor_id ");
        $vendasVendedor = $quantidadeVendida->rowCount();

        $selecionarComissao = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 AND (funcionario_id=$listaVendedores->vendedor_id || cargo_id=$listaVendedores->cargo_id)");

        if ($selecionarComissao->rowCount()) {
            while ($intervalo = $selecionarComissao->fetch(PDO::FETCH_OBJ)) {

                $nomeComissaoVendedor = $intervalo->nome;

                $producaoVendedor = $intervalo->producao;

                $comissaoVendedor = $intervalo->comissao;
                //intervalo da producao
                $intervaloValores = explode("-", $intervalo->producao);

                if ($vendasVendedor >= $intervaloValores[0] && $vendasVendedor <= $intervaloValores[1]) {
                    //fa a soma dos produto que o vendedor Vendeu
                    $sqlSoma = $this->conn->query("SELECT SUM(P.valor)AS valor FROM visita AS V INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                               INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                               INNER JOIN produto AS P ON P.id=VP.produto_id
                                               INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                               WHERE VN.ativo=0 AND V.ativo=0 AND  VP.ativo=0 AND P.ativo=0 
                                               AND V.vendedor_id=$listaVendedores->vendedor_id ");
                    //exibir a soma 
                    $somaExibida = $sqlSoma->fetch(PDO::FETCH_OBJ);
                    //calcula comissao
                    $valorSomaVendedor = $somaExibida->valor;
                    $comissaoV = $somaExibida->valor * ($comissaoVendedor / 100);
                    $comissao = $listaVendedores->salario + $comissaoV;
                }
            }
        } else {
            $producaoVendedor = 0;
            $comissaoVendedor = 0;
        }
  $this->mpdf->WriteHTML("<tr>
                       <th colspan='11' style='text-align:left;' >Vendedor: $listaVendedores->nome  </th>
                            
                   </tr>
                   <tr>
                        <th>Produção</th>
                         <th>Meta</th>
                         <th colspan=2>Nome comissão</th>
                         <th>Comissão</th>
                          <th>Total da venda</th>
                         <th>Salário</th>
                          <th colspan='2'>Salário + Comissão</th>
                        <th colspan=2>Periodo</th>
                  </tr>
                  <tr>
                      <td> $listaVendedores->contador  </td>   
                      <td> $producaoVendedor</td>
                      <td colspan=2>$nomeComissaoVendedor</td>    
                      <td>$comissaoVendedor % - R$ " . moeda($comissaoV) . "</td>
                     <td>R$ " . moeda($valorSomaVendedor ) . "  </td>
                      <td>R$ " . moeda($listaVendedores->salario) . "</td>
                      <td colspan='2'>R$ " . moeda($comissao) . "</td>    
                      <td colspan=2>$periodo</td>    
                   </tr>");
     
    }
 } 

}


//gerente de telematrketing e seus subordinados

$sqlGerenteTel = $this->conn->query("SELECT F.nome,F.id ,F.cargo_id,F.salario,VN.data,V.operador_id FROM  funcionario AS F 
                                    INNER JOIN visita AS V ON V.empresa_id=F.empresa_id
                                    INNER JOIN vendas AS VN ON VN.visita_id=V.id 
                                    WHERE F.ativo=0 AND V.ativo=0  AND VN.ativo=0 $data AND F.id  in 
                                   (SELECT F.superior_id FROM funcionario AS F INNER JOIN visita AS V ON V.operador_id=F.id 
                                    INNER JOIN vendas AS VN ON VN.visita_id=V.id WHERE F.ativo=0 AND VN.ativo=0 AND V.ativo=0  $empresa $clausula )GROUP BY F.id");


if ($sqlGerenteTel->rowCount()) {
    //ultimo dia dos mes
    //  date("t/m/Y");
    $comissaoG = 0;
    // $producaoGerenteT=0;
    // $comissaoGerenteT=0;
    $comissao = 0;

    
    while ($lista = $sqlGerenteTel->fetch(PDO::FETCH_OBJ)) {
    
        $comissaoGT = 0;
        $comissaoOP = 0;
        $comissaoOperador = 0;
        $comissaoNomeOp = "";
        $comissaoNomeGT = "";
        $comissaoSobreSubordinadoOP = "";
        $comissaoParaGerenteTelSub = "";
        //consulta a quantigdade vendas do gerente de telemarketing
        $quantidadeVendidaGerenteTel = $this->conn->query("SELECT V.operador_id FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id 
                                                           WHERE VN.ativo=0 AND V.ativo=0 AND V.operador_id=$lista->id AND VN.data='$lista->data'");

        $vendasGerenteTel = $quantidadeVendidaGerenteTel->rowCount();

        //consulta a meta e comissao referente a gerente vendas   
        $selecionarComissaoGerenteTel = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND (funcionario_id=$lista->id || cargo_id=$lista->cargo_id)");

        if ($selecionarComissaoGerenteTel->rowCount()) {

            while ($intervaloGerenteTel = $selecionarComissaoGerenteTel->fetch(PDO::FETCH_OBJ)) {

                $producaoGerente = $intervaloGerenteTel->producao;

                $comissaoGerente = $intervaloGerenteTel->comissao;
                //intervalo da producao
                $intervaloValoresGerenteTel = explode("-", $intervaloGerenteTel->producao);
                  $comissaoNomeGT = $intervaloGerenteTel->nome;

                if ($vendasGerenteTel >= $intervaloValoresGerenteTel[0] && $vendasGerenteTel <= $intervaloValoresGerenteTel[1]) {

                    $comissaoGT = $lista->salario + $comissaoGerente;
                  
                }
              
            }
             
        }
        
        //consulta a quantidade vendas do operador de telemarketing
        $quantidadeVendidaOPTel = $this->conn->query("SELECT V.operador_id FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id
                                                      INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                                      WHERE VN.ativo=0 AND V.ativo=0 AND V.operador_id=$lista->operador_id AND VN.data='$lista->data'
                                                        AND F.superior_id=$lista->id");

        $vendasOPTel = $quantidadeVendidaOPTel->rowCount();

        //comissao sobre subordinado
        $comissaoSobreSubordinado = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE subordinado=1 AND ativo=0  AND empresa_id=$_SESSION[empresaId] AND subordinado=1 AND (funcionario_id=$lista->id || cargo_id=$lista->cargo_id)");

        if ($comissaoSobreSubordinado->rowCount()) {

            while ($executeComissaoSobreSubordinado = $comissaoSobreSubordinado->fetch(PDO::FETCH_OBJ)) {
                $intervaloValoresSubordinado = explode("-", $executeComissaoSobreSubordinado->producao);
                if ($vendasOPTel >=$intervaloValoresSubordinado[0]  && $vendasOPTel <= $intervaloValoresSubordinado[1]) {
                    $comissaoSobreSubordinadoOP = $executeComissaoSobreSubordinado->nome;
                    $comissaoParaGerenteTelSub = $executeComissaoSobreSubordinado->comissao;
                }
            }
            $comissaoOP = $lista->salario + $comissaoParaGerenteTelSub;
        }

        $comissaoGT = $comissaoGT + $comissaoOP;
       


 $this->mpdf->WriteHTML("
                  <tr>
                    <th colspan='11' style='text-align:left;' >Gerente de Telemarketing:$lista->nome </th>
                     
                </tr> 
                 <tr>
                     <th>Produção</th>
                     <th>Meta</th>
                     <th>Comissão nome</th>
                     <th>Comissão(%)</th>
                     <th>Nome comissao sobre subordinado</th>
                     <th>comissao sobre subordinado</th>
                       <th>Total da venda</th>
                     <th>Salário</th>
                     <th>Salário + Comissão</th>
                     <th colspan=2>Periodo</th>
                </tr>
                <tr>
                    <td> $vendasGerenteTel</td>   
                    <td>  $producaoGerente</td>
                    <td> $comissaoNomeGT</td>    
                    <td> $comissaoGerente</td>
                    <td> $comissaoSobreSubordinadoOP</td>
                     <td>R$" . moeda($comissaoParaGerenteTelSub) . "</td>   
                     <td></td>    
                    <td>R$ " . moeda($lista->salario) . "</td>
                    <td>R$ " . moeda($comissaoGT) . "</td> 
                    <td colspan=2>$periodo</td>    
               </tr>");

        $operador = $this->conn->query("SELECT count(V.operador_id) AS contador,V.operador_id,F.nome,F.salario,F.cargo_id,VN.data,VN.id
                                              FROM visita AS V INNER JOIN funcionario AS F ON V.operador_id=F.id 
                                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                              INNER JOIN vendas AS VN ON V.id=VN.visita_id 
                                              WHERE V.ativo=0 AND VN.ativo=0  AND  F.superior_id=$lista->id AND VN.data='$lista->data' ORDER BY F.nome");

        while ($listaOperador = $operador->fetch(PDO::FETCH_OBJ)) {
            //consulta a quantigdade vendas do vendedor
            $quantidadeVendidaOP = $this->conn->query("SELECT count(V.operador_id) FROM vendas AS VN INNER JOIN visita AS V ON V.id=VN.visita_id WHERE V.operador_id=$listaOperador->operador_id ");
            $vendasOperador = $quantidadeVendidaOP->rowCount();

            $selecionarComissao = $this->conn->query("SELECT nome,producao,comissao FROM comissao WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 AND (funcionario_id=$listaOperador->operador_id || cargo_id=$listaOperador->cargo_id) ");

            if ($selecionarComissao->rowCount()) {
                while ($intervalo = $selecionarComissao->fetch(PDO::FETCH_OBJ)) {
                    $producaoOperador = $intervalo->producao;
                    $comissaoOperador = $intervalo->comissao;
                    //intervalo da producao
                    $intervaloValoresOP = explode("-", $intervalo->producao);
                    if ($vendasOperador >= $intervaloValoresOP[0] && $vendasOperador <= $intervaloValoresOP[1]) {
                        $comissaoOperador = $listaOperador->salario + $comissaoOperador;
                        $comissaoNomeOp = $intervalo->nome;
                    }
                }
            } else {
                $producaoOperador = 0;
                $comissaoOperador = $listaOperador->salario;
            }
            $this->mpdf->WriteHTML("<tr>
                       <th colspan='11' style='text-align:left;' >Operador(a) de Telemarketing: $listaOperador->nome  </th>
                            
                   </tr>
                   <tr>
                        <th>Produção</th>
                         <th>Meta</th>
                         <th colspan=2>Nome comissao </th>
                         <th>Comissão(%)</th>
                           <th>Total da venda</th>
                         <th>Salário</th>
                         <th>Salário + Comissão</th>
                        <th colspan=3>Periodo</th>
                  </tr>
                  <tr>
                      <td> $listaOperador->contador  </td>   
                      <td> $producaoOperador</td>
                      <td colspan=2> $comissaoNomeOp</td>    
                      <td>$comissaoOperador</td>
                          <td></td>
                      <td>R$ " . moeda($listaOperador->salario) . "</td>
                      <td>R$ " . moeda($comissaoOperador) . "</td>    
                      <td colspan=3>$periodo</td>    
                   </tr>");
        }
        
    }
    
} else {
    //   echo "<h3 style='color:red'>Nenhum registro Encontrado!</h3> ";
}
$this->mpdf->WriteHTML( "</table>"); 
 $this->mpdf->WriteHTML( "</div>");
 $this->mpdf->SetFooter('{DATE j/m/Y H:i}|Página {PAGENO} de {nb}|www.upvendasbrasil.com.br');
 $this->mpdf->Output();
  exit(); 
  
  
 }
 
 }
 $obj= new ComissaoPDF();
 $obj->lista();
 
}
 
 ?>