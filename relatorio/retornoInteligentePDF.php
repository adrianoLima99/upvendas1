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
        $this->Cell(190,$l,'Relatorio de Retorno Inteligente','B',1,'C');  
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

  $clausula = "";
  $diferenteVendido="";
     
if(!empty($_GET["gerente"])){
     $clausula = $clausula . " AND V.gerente_vendas_id=" .$_GET["gerente"];
}
if(!empty($_GET["vendedor"])){
       $clausula = $clausula . " AND V.vendedor_id=" .$_GET["vendedor"];
}
if(!empty($_GET["status"])){
    if($_GET["status"]!=0){
                    $diferenteVendido=$diferenteVendido." AND VP.status<>0";
                }
               $clausula = $clausula . " AND VP.status=$_GET[status]";
}
if(!empty($_GET["uf"])){
       $clausula = " AND E.id=$_GET[uf]";
}
if(!empty($_GET["mun"])){
      $clausula = " AND C.municipio_codigo=$_GET[mun]";
}
if(!empty($_GET["operador"])){
           $clausula = $clausula ." AND V.operador_id=$_GET[operador]";
   }
  if(!empty($_GET['data'])){
     
    $clausula = $clausula ."  AND V.data_visita LIKE'%$_GET[data]%' "; 
   }
 if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
    
     $clausula = $clausula ."  AND V.data_visita BETWEEN '$_GET[periodo1]' AND '$_GET[periodo1]'"; 	
 
  
 }
 
     
                    
           
  
  

 //SELECAO DOS DADOS QUE IR�O PRO PDF  
 
	$l=2; // ALTURA DA LINHA

        
       $y1 = 39;
	$y2 = 0;
        
        
       
      

   
            //$pdf->MultiCell(100,6,$consulta,0,2); 
		$y1 = 31;
		$y2 = 0;
       	
    			
	
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
	  		 	$pdf->MultiCell(50,6,"Cliente",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  			
	  			//TITULO PRODUTO
	  			
	  			$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(70);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(18,6,"Fone1",1,2,1); 
	  			
                                $pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(88);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(18,6,"Fone2",1,2,1);
				
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(105);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(40,6,"Gerente",1,2,1); 
				
				//titulo local Prospectado
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(140);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(40,6,"Vendedor",1,2,1);
				
				//titulo informacoes
				
					
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(180);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(20,6,"Visitado",1,2,1); 
                                
                                $pdf->Ln(); 
                                $y1 = $y1+6;

                                $listaCliente=$conn->query("SELECT id,nome FROM cliente WHERE empresa_id=$_SESSION[empresaId]");

				  while($row =$listaCliente ->fetch(PDO::FETCH_OBJ)){
                                    
                                    $listaVisita=$conn->query("SELECT V.id,F.nome,V.cliente_id,C.nome as cliente,C.fone1 ,C.fone2 ,V.vendedor_id,V.data_visita,P.nome as produto
                                                                    FROM visita AS V INNER JOIN cliente AS C ON C.id=V.cliente_id
                                                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                                                    INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                                                                    INNER JOIN produto AS P ON P.id=VP.produto_id
                                                                    INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                                                    INNER JOIN estado AS E ON E.id=M.estado_uf
                                                                    WHERE  V.cliente_id=$row->id AND V.empresa_id=$_GET[iexm] $diferenteVendido $clausula  ORDER BY V.data_visita DESC limit 1");
                                    
                                    
                               if($listaVisita->rowCount()){
                                     while($row2=$listaVisita->fetch(PDO::FETCH_OBJ) ){ 
                                     //  $conn->exec("UPDATE visita SET acompanhado=0,operador_id=0 WHERE id=$row2->id ");
                                        $sql=$conn->query("SELECT nome FROM funcionario WHERE id=$row2->vendedor_id");
                                        $listaVendedor=$sql->fetch(PDO::FETCH_OBJ);
    
                                       if ($y1>=270){
                                	$y1 = 59;
					$pdf->AddPage();
					}
       			
    		
				         	
                                                $dados1 =$row2->cliente_id;
						$dados2 = utf8_decode($row2->cliente);
						$dados3=$row2->fone1;
                                                $dados4=utf8_decode( $row2->nome);
                                                $dados5=utf8_decode( $listaVendedor->nome);
						$dados6 = $row2->fone2;
					                                                                                 
                                                $dados8=  formata_data($row2->data_visita);
                                                
						//CELULA CONTENDO O id visita
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(10);  
	  					//$pdf->Rect(10,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados1,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6); 
						
						//CELULA CONTENDO O NOME DO CLIENTE
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(25);  
	  					//$pdf->Rect(10,$y,173,$l);  
	  				 	$pdf->MultiCell(50,6,$dados2,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                
                                                //CELULA CONTENDO A fone	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(70);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(50,6,$dados3,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);
                                                
                                                //CELULA CONTENDO A fone	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(90);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(50,6,$dados6,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);
                                                
                                                
						//CELULA CONTEUDO O PRODUTO
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(107);  
	  				
						//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados4,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
					
					  
						
										
						//CELULA CONTENDO bairro	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(142);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados5,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
                                                //CELULA CONTENDO produto	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(150);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(27,6,"",0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
                                              
                                                $pdf->SetY($y1);  
	  				 	$pdf->SetX(180);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados8,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6); 
                                                
                                                
						$pdf->Ln(); 
       					$y1 = $y1+6;
					
						if ($y1>=250){
							$y1 = 59;
							
							$pdf->AddPage();
						}
                                     }
                               }
                    }	
		
		
	    $pdf->AddPage();   // SE ULTRAPASSADO, � ADICIONADO UMA P�GINA  
 


//mysql_close(); // FECHA A CONEX�O COM MYSQL  
$pdf->Output(); // IMPRIME O PDF NA TELA  
Header('Pragma: public'); // ESTA FUN��O � USADA PELO FPDF PARA PUBLICAR NO IE 
