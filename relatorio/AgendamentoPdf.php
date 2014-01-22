<?php
ob_start();
// PRIMEIRAMENTE: INSTALEI A CLASSE NA PASTA FPDF DENTRO DE MEU SITE.  

  session_start();
// INSTALA AS FONTES DO FPDF  
include_once("../conexao/conexao.class.php");
include_once("../formataData.php");
require('fpdf/fpdf.php');   
  define('FPDF_FONTPATH','fpdf/font/');   
// INSTALA A CLASSE FPDF  
class PDF extends FPDF {
	
	 
  
// CRIA UMA EXTENS�O QUE SUBSTITUI AS FUN��ES DA CLASSE.   
// SOMENTE AS FUN��ES QUE EST�O DENTRO DESTE EXTENDS � QUE SER�O SUBSTITUIDAS.  
  
  
    function Header(){ //CABECALHO  
        global $codigo; // EXEMPLO DE UMA VARIAVEL QUE TER� O MESMO VALOR EM QUALQUER �REA DO PDF.  
        $l=5; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA  
        $this->SetXY(10,10); // SetXY - DEFINE O X E O Y NA PAGINA  
        $this->Rect(10,10,190,280); // CRIA UM RET�NGULO QUE COME�A NO X = 10, Y = 10 E   
                                    //TEM 190 DE LARGURA E 280 DE ALTURA.   
                                    //NESTE CASO, � UMA BORDA DE P�GINA.  
  
       //$this->Image('',11,11,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.  
        $this->SetFont('Arial','B',8); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8  
  
        $this->Cell(170,15,'Upvendas',0,0,'L');   
        // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE:   
        // LARGURA = 170,   
        // ALTURA = 15,   
        // TEXTO = 'INSIRA SEU TEXTO AQUI'  
        // BORDA = 0. SE = 1 TEM BORDA SE 'R' = RIGTH, 'L' = LEFT, 'T' = TOP, 'B' = BOTTOM  
        // QUEBRAR LINHA NO FINAL = 0 = N�O  
        // ALINHAMENTO = 'L' = LEFT  
  
       // $this->Cell(20,$l,'N� '.$codigo,1,0,'C',0);   
        // CRIA UMA CELULA DA MESMA FORMA ANTERIOR MAS COM ALTURA DEFINIDA PELA VARIAVEL $l E   
        // INSERINDO UMA VARI�VEL NO TEXTO.  
  
        $this->Ln(); // QUEBRA DE LINHA  
  
        $this->Cell(190,10,'',0,0,'L');  
        $this->Ln();  
        $l = 17;  
        $this->SetFont('Arial','B',12);  
        $this->SetXY(10,15);  
        $this->Cell(190,$l,'Relatorio de Agendamento ','B',1,'C');  
        $l=5;  
        $this->SetFont('Arial','B',10);  
        $this->Cell(15,$l,'Data:',0,0,'L');  
        $this->Cell(20,$l,date('d/m/Y'),'B',0,'L'); // INSIRO A DATA CORRENTE NA CELULA  
  
		$this->Ln();  
		
		
  
        //FINAL DO CABECALHO COM DADOS  
        //ABAIXO � CRIADO O TITULO DA TABELA DE DADOS  
  
        $this->Cell(190,2,'',0,0,'C');   
        //ESPA�AMENTO DO CABECALHO PARA A TABELA  
        $this->Ln();  
  		   $this->SetTextColor(0,0,0);
        //$this->SetTextColor(255,255,255);  
       // $this->Cell(190,$l,'Relatorio',1,0,'C',1);  
        $this->Ln();  
  

	   }   
    function Footer(){ // CRIANDO UM RODAPE  
  
        /*$this->SetXY(15,280);  
        $this->Rect(10,270,190,20);  
        $this->SetFont('Arial','',10);  
        $this->Cell(70,8,'Assinatura ','T',0,'L');  
        $this->Cell(40,8,' ',0,0,'L');  
        $this->Cell(70,8,'Assinatura','T',0,'L');   
        $this->Ln();  
		 */ 
        $this->SetFont('Arial','',7);  
        $this->Cell(190,7,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');  
        }  
  
  
  }
  
//CONECTE SE AO BANCO DE DADOS SE PRECISAR   
//include_once ("../conexao/db_connect.inc.php"); // A MINHA CONEX�O   
  $conn= new Connection();
  $pdf=new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4  
  $pdf->AddPage(); // ADICIONA UMA PAGINA  
  $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE  
  $pdf->SetFont('Arial','',8);  
  $y = 49; // AQUI EU COLOCO O Y INICIAL DOS DADOS   

	
	
//CLAUSULA PARA CONsULTA


   if(isset($_GET["operador"])){
      $operador=$_GET["operador"];
   }
  if(isset($_GET['data'])){
     
    $data=$_GET['data'];
   }
 if(isset($_GET['periodo1'])&& isset($_GET['periodo2'])){
     $periodo1=$_GET['periodo1'];
     $periodo2=$_GET['periodo2'];
 }
 
 
$clausula="";

if(!empty($operador)){
 	$clausula=$clausula." AND V.id_operador=".$operador;
}
if(!empty($periodo1) && !empty($periodo2)){
   $clausula=$clausula." AND  AG.data BETWEEN '$periodo1' AND '$periodo2'"; 	
}
if(!empty($data)){
    $clausula=$clausula." AND  AG.data like'%$data%'"; 	
  }	

 //SELECAO DOS DADOS QUE IR�O PRO PDF  
 
	
	$sql = $conn->query("SELECT F.nome,count(F.id) AS contador,F.id,C.id as idCli,C.nome As cliente, AG.data,AG.hora
                                       FROM agendamento_visita AS AG 
                                       INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                                       INNER JOIN visita AS V ON V.id=AC.visita_id
                                       INNER JOIN cliente AS C ON C.id=V.cliente_id
                                       INNER JOIN funcionario AS F ON V.operador_id=F.id 
                                       WHERE F.ativo=0 $clausula ");	 
	
 
	$l=5; // ALTURA DA LINHA  

    // $l = 5 * contaLinhas($dados2,48);   
    // Eu criei a fun��o "contaLinhas" para contar quantas linhas um campo pode conter se tiver largura = 48  

    while($row =$sql ->fetch(PDO::FETCH_OBJ)){
    			
		
	/*	$pdf->SetFillColor(0,0,0);  
        $pdf->SetTextColor(255,255,255);  
		$dados1 ="Gerente de Vendas: ". $row->nome_operador;
		 $dados2 = $row->id_operador;
    	$pdf->SetY($y);  
	    $pdf->SetX(10);  
	    $pdf->Rect(10,$y,190,$l); 
		$pdf->SetFont('Arial','',10); 
	    $pdf->MultiCell(190,6,$dados1,0,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	 
	  // if(empty($_GET['gerV'])){
	//		$gerente="VD.superior=".$dados2;
	//	}
		
	 // $pdf->SetFont('Arial','',6);  
	 	 
		$pdf->Ln();  
	*/	
		
	//echo "SELECT distinct VD.nome_vendedor,VD.id_vendedor from vendedor AS VD INNER JOIN visita AS V ON VD.id_vendedor=V.id_vendedor where VD.ativo=0 AND $gerente $p $d $status order by VD.nome_vendedor"; 
		   $agendados=$conn->query("SELECT distinct AG.data,AG.hora,C.nome AS cliente,V.vendedor_id,V.cliente_id,C.fone1,C.logradouro,C.bairro
                                             FROM agendamento_visita AS AG INNER JOIN acompanhamento AS AC ON AG.acompanhamento_id=AC.id
                                             INNER JOIN visita AS V ON V.id=AC.visita_id
                                             INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                             INNER JOIN cliente AS C ON C.id=V.cliente_id
                                             INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                             INNER JOIN produto AS P ON P.id=VP.produto_id
                                             WHERE AG.ativo=0 AND V.operador_id=$row->id $clausula ORDER by AG.data");
                 	
                   
        //$pdf->MultiCell(100,6,$consulta,0,2); 
		$y1 =39;
		$y2 = 0;
       	
    			
				
				$dados3 = "Operador(a) Telemarketing: ".$row->nome." - Quantidade:".$row->contador." ";
				//$dados4 = $row->id_operador;
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(10);  
	  		//	$pdf->Rect(10,$y1,173,$l);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(190,6,$dados3,1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  			$pdf->SetFont('Arial','',6);  	 
				$pdf->Ln();
                               
       			$y1 = $y1+6;
	 		
				
				//TITULO NOME DO CLIENTE
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(10);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(15,6,"Id cliente",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  						
			
			
				//TITULO NOME DO CLIENTE
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(25);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(65,6,"Cliente",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  			
	  			//TITULO PRODUTO
	  			
	  			$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(90);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(17,6,"Telefone",1,2,1); 
	  			
				//TITULO status
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(107);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(64,6,"Vendedor",1,2,1); 
				
				//titulo local Prospectado
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(170);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(17,6,"Data",1,2,1);
				
				//titulo informacoes
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(185);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(15,6,"Hora",1,2,1); 
				
				//titulo data visita
				
				$pdf->SetFont('Arial','',6);  	 
				$pdf->Ln(); 
       			$y1 = $y1+6;
				
				if ($y1>=270){
							$y1 = 59;
							
							$pdf->AddPage();
						}
       			//while($row2 =$sql2 ->fetch(PDO::FETCH_OBJ)){
    		
				         	
		while($row1 = $agendados->fetch(PDO::FETCH_OBJ)){
                    
                    $sqlVendedor=$conn->query("SELECT id,nome FROM funcionario  WHERE id=$row1->vendedor_id AND ativo=0");
                     $nomeVendedor=$sqlVendedor->fetch(PDO::FETCH_OBJ);
                                                $dados0 =$row1->cliente_id;
						$dados5 = utf8_decode($row1->cliente);
                                                $dados6=$row1->fone1;
						$dados7 = utf8_decode($nomeVendedor->nome);
					//	$dados10 = $row1->data;
						$dados8=utf8_decode($row1->logradouro);
						
                                                $dados9=  formata_data($row1->data);
                                                 $dados10=$row1->hora; 
                                                
						//CELULA CONTENDO O id visita
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(10);  
	  					//$pdf->Rect(10,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados0,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6); 
						
						//CELULA CONTENDO O NOME DO CLIENTE
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(27);  
	  					//$pdf->Rect(10,$y,173,$l);  
	  				 	$pdf->MultiCell(97,6,$dados5,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
					
						//CELULA CONTEUDO O PRODUTO
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(90);  
	  				
						//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados6,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
					
						//CELULA CONTENDO A status	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(107);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(64,6,$dados7,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
						
										
						//CELULA CONTENDO bairro	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(170);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(40,6,$dados9,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
                                                //CELULA CONTENDO produto	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(185);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados10,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
						$pdf->Ln(); 
       					$y1 = $y1+6;
					
						if ($y1>=250){
							$y1 = 59;
							
							$pdf->AddPage();
						}
					
				//}
			
		}
		
	    $pdf->AddPage();   // SE ULTRAPASSADO, � ADICIONADO UMA P�GINA  
 
}  

//mysql_close(); // FECHA A CONEX�O COM MYSQL  
$pdf->Output(); // IMPRIME O PDF NA TELA  
Header('Pragma: public'); // ESTA FUN��O � USADA PELO FPDF PARA PUBLICAR NO IE 
