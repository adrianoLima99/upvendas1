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
        $this->Cell(190,$l,'Relatorio de Pendencia','B',1,'C');  
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
 	$clausula=$clausula." AND V.operador_id=".$operador;
}
if(!empty($periodo1) && !empty($periodo2)){
   $clausula=$clausula." AND  AG.data BETWEEN '$periodo1' AND '$periodo2'"; 	
}
if(!empty($data)){
    $clausula=$clausula." AND  AG.data like'%$data%'"; 	
  }	

 //SELECAO DOS DADOS QUE IR�O PRO PDF  
 $operadores=$conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F 
                                                  INNER JOIN visita AS V ON F.id=V.operador_id 
                                                  INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                  INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                  INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id = A.id
                                                   WHERE   F.empresa_id=$_SESSION[empresaId] $clausula AND A.ativo=0 AND F.ativo=0 AND VP.ativo=0");
	
	
 

 
	$l=2; // ALTURA DA LINHA

        
       $y1 = 39;
	$y2 = 0;
        
        
       
      

    while($row0 =$operadores ->fetch(PDO::FETCH_OBJ)){
    			
 	$sql = $conn->query("SELECT distinct A.id AS id_acom,A.obs,C.id as cliente_id,C.nome AS cliente,C.fone1,
                                    V.id AS visita_id, V.gerente_vendas_id,V.vendedor_id,V.data_visita,F.id as idFunc,F.nome,F.perfil,
                                    P.nome AS produto,VP.produto_id,VP.status,AG.data,AG.hora,VP.plano_id,PL.nome AS plano 
                                    FROM acompanhamento AS A INNER JOIN visita AS V ON V.id=A.visita_id 
                                    INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id=A.id 
                                    INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                    INNER JOIN cliente AS C ON V.cliente_id=C.id 
                                    INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                    INNER JOIN produto AS P ON P.id=VP.produto_id 
                                    INNER JOIN plano AS PL ON PL.id=VP.plano_id 
                                    WHERE V.operador_id=$row0->id AND AG.ativo=0 $clausula AND A.ativo=0 AND V.ativo=0 AND VP.ativo=0 ");	 
	
    
            //$pdf->MultiCell(100,6,$consulta,0,2); 
		$y1 = 40;
		$y2 = 0;
       	
    			
	
            //lista vendedores
         
            
				$dados3 = "Operador(a) Telemarketing: ".$row0->nome." - Quantidade:".$sql->rowCount();
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
	  		 	$pdf->MultiCell(50,6,"Cliente",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  			
	  			//TITULO PRODUTO
	  			
	  			$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(70);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(18,6,"Fone",1,2,1); 
	  			
				//TITULO status
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(88);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(33,6,"Vendedor",1,2,1); 
				
				//titulo local Prospectado
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(121);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(27,6,"Produto",1,2,1);
				
				//titulo informacoes
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(148);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(20,6,"Plano",1,2,1); 
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(168);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(19,6,"Status",1,2,1); 
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(179);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(20,6,"Data",1,2,1); 
                                
                                $pdf->Ln(); 
                                $y1 = $y1+6;
				
				while($row =$sql ->fetch(PDO::FETCH_OBJ)){
                                    
                                   if ($row->status == 1) {
                                               $status = 'Quente';
                                        } elseif ($row->status == 2) {
                                               $status = 'Morno';
                                        }
                                    
                                       $listaVendedor=$conn->query("SELECT nome FROM funcionario WHERE id=$row->vendedor_id");
                                         $exibirVendedor=$listaVendedor->fetch(PDO::FETCH_OBJ);
				
                                       if ($y1>=270){
                                	$y1 = 59;
					$pdf->AddPage();
					}
       			
    		
				         	
                                                $dados1 =$row->cliente_id;
						$dados2 = utf8_decode($row->cliente);
						$dados3=$row->fone1;
                                                $dados4=utf8_decode( $exibirVendedor->nome);
                                                $dados5 = utf8_decode($row->produto);
					//	$dados10 = $row1->data;
							
                                                
						
                                                $dados6=$row->plano;
                                                $dados7=$status;
                                                $dados8=  formata_data($row->data);
                                                
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
					
						//CELULA CONTEUDO O PRODUTO
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(90);  
	  				
						//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados4,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
					
						//CELULA CONTENDO A status	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(70);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(50,6,$dados3,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
						
										
						//CELULA CONTENDO bairro	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(122);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados5,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
                                                //CELULA CONTENDO produto	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(150);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(27,6,$dados6,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
                                                 
                                               $pdf->SetY($y1);  
	  				 	$pdf->SetX(170);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(20,6,$dados7,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
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
		
	    $pdf->AddPage();   // SE ULTRAPASSADO, � ADICIONADO UMA P�GINA  
 


//mysql_close(); // FECHA A CONEX�O COM MYSQL  
$pdf->Output(); // IMPRIME O PDF NA TELA  
Header('Pragma: public'); // ESTA FUN��O � USADA PELO FPDF PARA PUBLICAR NO IE 
