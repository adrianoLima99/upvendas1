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
        $this->Cell(190,$l,'Relatorio','B',1,'C');  
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




$clausula="";
                
                 if (!empty($_GET['uf'])) {
                       $clausula = $clausula . "  AND E.id=$_GET[uf]";
                 }
                 if (!empty($_GET['mun'])) {
                       $clausula = $clausula ."  AND C.municipio_codigo=$_GET[mun]";
                 }
    	 	 if(!empty($_GET['gerV'])){
	  				$clausula=$clausula." AND V.gerente_vendas_id=".$_GET['gerV'];
		 	 }
                 if(!empty($_GET['vend'])){
	  				$clausula=$clausula." AND V.vendedor_id=".$_GET['vend'];
		 	 }        
 	 	 if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
 	 				$clausula=$clausula." AND  V.data_cadastro BETWEEN '".$_GET['periodo1']."' AND '".$_GET['periodo2']."'"; 	
 		  }
                if(!empty($_GET['data'])){
 	 				$clausula=$clausula." AND  V.data_cadastro like'%$data%'"; 	
 		 }
             if(!empty($_GET['status'])){
					$clausula=$clausula." AND VP.status=".$_GET['status'];
                }
 
 
	

 //SELECAO DOS DADOS QUE IR�O PRO PDF  
 
	
	$sql = $conn->query("SELECT distinct V.gerente_vendas_id,F.nome,count(V.gerente_vendas_id)AS contador 
                              FROM visita AS V  INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id
                              INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                              INNER JOIN cliente AS C ON C.id=V.cliente_id
                              INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                              INNER JOIN estado AS E ON E.id=M.estado_uf
                              WHERE V.ativo=0 $clausula AND V.empresa_id=$_GET[emxp] GROUP BY V.gerente_vendas_id");
        
        
	$l=5; // ALTURA DA LINHA  

    // $l = 5 * contaLinhas($dados2,48);   
    // Eu criei a fun��o "contaLinhas" para contar quantas linhas um campo pode conter se tiver largura = 48  

    while($row =$sql ->fetch(PDO::FETCH_OBJ)){
    
			
		
        $pdf->SetFillColor(0,0,0);  
        $pdf->SetTextColor(255,255,255);  
		$dados1 ="Gerente de Vendas: ". $row->nome." - Quantidade:".$row->contador;
		// $dados2 = $row->id;
    	 $pdf->SetY($y);  
	 $pdf->SetX(10);  
	 $pdf->Rect(10,$y,190,$l); 
         $pdf->SetFont('Arial','',10); 
	 $pdf->MultiCell(190,6,$dados1,0,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	 
		
	 // $pdf->SetFont('Arial','',6);  
	 	 
		$pdf->Ln();  
		
		
	//echo "SELECT distinct VD.nome_vendedor,VD.id_vendedor from vendedor AS VD INNER JOIN visita AS V ON VD.id_vendedor=V.id_vendedor where VD.ativo=0 AND $gerente $p $d $status order by VD.nome_vendedor"; 
		$consulta ="SELECT distinct V.vendedor_id,count(V.vendedor_id) AS contador,V.gerente_vendas_id,F.nome,V.data_cadastro,V.id
                                                     FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id 
                                                     WHERE V.ativo=0 AND (F.superior_id=$row->gerente_vendas_id || V.vendedor_id=$row->gerente_vendas_id) GROUP BY V.data_cadastro ORDER BY F.nome"; 
	//	echo "<br/>".$consulta;
                $sql1 = $conn->query($consulta);		
        //$pdf->MultiCell(100,6,$consulta,0,2); 
		$y1 = 59;
		$y2 = 0;
        while($row1 =$sql1 ->fetch(PDO::FETCH_OBJ)){
    	
			
                    //consulta gera cliente
				$consulta1 ="SELECT V.data_cadastro,P.nome AS produto,C.nome,V.id,VP.status,V.obs 
                                             FROM visita AS V INNER JOIN visita_produto AS VP ON V.id=VP.visita_id
                                             INNER JOIN cliente AS C ON C.id=V.cliente_id 
                                             INNER JOIN produto AS P ON P.id=VP.produto_id 
                                             INNER JOIN funcionario AS F ON F.id=V.vendedor_id
                                             WHERE V.vendedor_id=$row1->vendedor_id  $clausula order by V.cliente_id"; 
							 
			//	echo "<br/>".	$consulta1;			 
				$sql2 = $conn->query($consulta1);		
        	//fim consulta	
                    
                    
				$dados3 = "Vendedor: ".$row1->nome." Quantidade:".$sql2->rowCount();
//				$dados4 = $row1->id_vendedor;
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
	  		 	$pdf->MultiCell(20,6,"Cod.Visita",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  						
			
			
				//TITULO NOME DO CLIENTE
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(27);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(97,6,"Cliente",1,2,1); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  			
	  			//TITULO PRODUTO
	  			
	  			$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(120);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(60,6,"Produto",1,2,1); 
	  			
				//TITULO status
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(157);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(25,6,"Status",1,2,1); 
				
				//titulo local Prospectado
			/*	
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(100);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(40,6,"Loc. Prospectado",1,2,1);
				
				//titulo informacoes
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(139);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(45,6,utf8_decode("Informações"),1,2,1); 
				*/
				//titulo data visita
				
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y1);  
	  		 	$pdf->SetX(178);  
	  		  	$pdf->SetFont('Arial','',9);
	  		 	$pdf->MultiCell(22,6,"Cadastrado",1,2,1);
				
	  			$pdf->SetFont('Arial','',6);  	 
				$pdf->Ln(); 
       			$y1 = $y1+6;
			//$pdf->MultiCell(100,6,$consulta,0,2); 
				//if ($y2==0){
				//	$y2 = $y1+5;
				//}else {
				//	$y2 = $y2+5;
				//}
				
				
				if ($y1>=270){
							$y1 = 59;
							
							$pdf->AddPage();
						}
       			while($row2 =$sql2 ->fetch(PDO::FETCH_OBJ)){
    				if($_GET['opc']=="vi"){
				         	
				         
						$dados5 = utf8_decode($row2->nome);
						$dados6 = $row2->produto;
						$dados10 = formata_data($row2->data_cadastro);
						$dados0 =$row2->id;	
						if($row2->status==0){
							$dados7 = "Vendido";
						}elseif($row2->status==1){
							$dados7 = "Quente";
						}elseif($row2->status==2){
							$dados7 = "Morno";
						}
						
						
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
	  				 	$pdf->SetX(120);  
	  				
						//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(60,6,$dados6,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
					
						//CELULA CONTENDO A status	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(157);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(30,6,$dados7,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
	  					$pdf->SetFont('Arial','',6);  
						
						
						
						
						//CELULA CONTENDO A DATA DA VISITA	 
						$pdf->SetY($y1);  
	  				 	$pdf->SetX(186);  
	  					//$pdf->Rect(50,$y,173,$l);  
	  				 	$pdf->MultiCell(40,6,$dados10,0,2); // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA  
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
 	
}  

//mysql_close(); // FECHA A CONEX�O COM MYSQL  
$pdf->Output(); // IMPRIME O PDF NA TELA  
Header('Pragma: public'); // ESTA FUN��O � USADA PELO FPDF PARA PUBLICAR NO IE 
?>