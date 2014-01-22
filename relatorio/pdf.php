<?php
ob_start();
// PRIMEIRAMENTE: INSTALEI A CLASSE NA PASTA FPDF DENTRO DE MEU SITE.

session_start();
// INSTALA AS FONTES DO FPDF
include_once ("../conexao/conexao.class.php");
include_once ("../formataData.php");
require ('fpdf/fpdf.php');
define('FPDF_FONTPATH', 'fpdf/font/');
// INSTALA A CLASSE FPDF
class PDF extends FPDF {

	// CRIA UMA EXTENS�O QUE SUBSTITUI AS FUN��ES DA CLASSE.
	// SOMENTE AS FUN��ES QUE EST�O DENTRO DESTE EXTENDS � QUE SER�O SUBSTITUIDAS.

	function Header() {//CABECALHO
		global $codigo;
		// EXEMPLO DE UMA VARIAVEL QUE TER� O MESMO VALOR EM QUALQUER �REA DO PDF.
		$l = 5;
		// DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
		$this -> SetXY(10, 10);
		// SetXY - DEFINE O X E O Y NA PAGINA
		$this -> Rect(10, 10, 190, 280);
		// CRIA UM RET�NGULO QUE COME�A NO X = 10, Y = 10 E
		//TEM 190 DE LARGURA E 280 DE ALTURA.
		//NESTE CASO, � UMA BORDA DE P�GINA.

		//$this->Image('',11,11,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
		$this -> SetFont('Arial', 'B', 8);
		// DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8

		$this -> Cell(170, 15, 'Upvendas', 0, 0, 'L');
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

		$this -> Ln();
		// QUEBRA DE LINHA

		$this -> Cell(190, 10, '', 0, 0, 'L');
		$this -> Ln();
		$l = 17;
		$this -> SetFont('Arial', 'B', 12);
		$this -> SetXY(10, 15);
		$this -> Cell(190, $l, 'Relatorio', 'B', 1, 'C');
		$l = 5;
		$this -> SetFont('Arial', 'B', 10);
		//$this->Cell(20,$l,'Dados 1:',0,0,'L');
		//$this->Cell(100,$l,'','B',0,'L');
		//$this->Cell(35,$l,'',0,0,'L');
		$this -> Cell(15, $l, 'Data:', 0, 0, 'L');
		$this -> Cell(20, $l, date('d/m/Y'), 'B', 0, 'L');
		// INSIRO A DATA CORRENTE NA CELULA

		/* $this->Ln();
		 $this->Cell(20,$l,'Dados 2:',0,0,'L');
		 $this->Cell(100,$l,'','B',0,'L');
		 $this->Ln();
		 $this->Cell(20,$l,'Dados 3:',0,0,'L');
		 $this->Cell(100,$l,'','B',0,'L');
		 $this->Cell(35,$l,'',0,0,'L');
		 $this->Cell(15,$l,'Dados 4:',0,0,'L');
		 $this->Cell(20,$l,'','B',0,'L');
		 */
		$this -> Ln();

		//FINAL DO CABECALHO COM DADOS
		//ABAIXO � CRIADO O TITULO DA TABELA DE DADOS

		$this -> Cell(190, 2, '', 0, 0, 'C');
		//ESPA�AMENTO DO CABECALHO PARA A TABELA
		$this -> Ln();

		$this -> SetTextColor(255, 255, 255);
		$this -> Cell(190, $l, 'Relatorio', 1, 0, 'C', 1);
		$this -> Ln();

		if ($_GET['opc'] == "cliente") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(7, $l, 'Id', 1, 0, 'L', 1);
			$this -> Cell(40, $l, 'Nome', 1, 0, 'l', 1);
			$this -> Cell(9, $l, 'Sexo', 1, 0, 'l', 1);
			$this -> Cell(15, $l, 'Fone', 1, 0, 'C', 1);
			$this -> Cell(37, $l, 'Endereco', 1, 0, 'L', 1);
                        $this -> Cell(30, $l, 'Bairro', 1, 0, 'L', 1);
                        $this -> Cell(30, $l, 'Cidade', 1, 0, 'L', 1);
                        $this -> Cell(7, $l, 'UF', 1, 0, 'L', 1);
			$this -> Cell(15, $l, 'Cadastro', 1, 0, 'L', 1);
			/* $this->Cell(12,$l,'Titulo 5',1,0,'C',1);
			 $this->Cell(40,$l,'Titulo 6',1,0,'C',1);
			 $this->Cell(15,$l,'Titulo 7',1,0,'C',1);
			 */
			$this -> Ln();
		}/* elseif($_GET['opc']=="vi"){
		 //TITULO DA TABELA DE SERVI�OS
		 $this->SetFillColor(232,232,232);
		 $this->SetTextColor(0,0,0);
		 $this->SetFont('Arial','B',8);
		 $this->Cell(53,$l,'Gerente Vendas',1,0,'L',1);
		 $this->Cell(66,$l,'Vendedor',1,0,'l',1);
		 $this->Cell(20,$l,'Data Visita',1,0,'L',1);
		 $this->Cell(30,$l,'Visitas/Vendedor',1,0,'C',1);
		 /* $this->Cell(12,$l,'Titulo 5',1,0,'C',1);
		 $this->Cell(40,$l,'Titulo 6',1,0,'C',1);
		 $this->Cell(15,$l,'Titulo 7',1,0,'C',1);

		 $this->Ln();
		 }*/
		elseif ($_GET['opc'] == "vn") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(66, $l, 'Gerente', 1, 0, 'l', 1);
			$this -> Cell(60, $l, 'Vendedor', 1, 0, 'L', 1);
			$this -> Cell(20, $l, 'Data Venda', 1, 0, 'C', 1);
			$this -> Cell(30, $l, 'Venda/Vendedor', 1, 0, 'C', 1);
			/* $this->Cell(40,$l,'Titulo 6',1,0,'C',1);
			 $this->Cell(15,$l,'Titulo 7',1,0,'C',1);
			 */
			$this -> Ln();
		} elseif ($_GET['opc'] == "admin") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(12, $l, 'Codigo ', 1, 0, 'L', 1);
			$this -> Cell(62, $l, 'Nome', 1, 0, 'l', 1);
			$this -> Cell(17, $l, 'Telefone', 1, 0, 'L', 1);
			$this -> Cell(32, $l, 'Endereco', 1, 0, 'C', 1);
                        $this -> Cell(23, $l, 'Bairro', 1, 0, 'C', 1);
                        $this -> Cell(20, $l, 'Cidade', 1, 0, 'C', 1);
                        $this -> Cell(5, $l, 'UF', 1, 0, 'C', 1);
                        $this -> Cell(18, $l, 'DT cadastro', 1, 0, 'C', 1);

			$this -> Ln();

		} elseif ($_GET['opc'] == "gt") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(19, $l, 'Codigo ', 1, 0, 'L', 1);
			$this -> Cell(62, $l, 'Nome', 1, 0, 'l', 1);
			$this -> Cell(64, $l, 'Superior', 1, 0, 'L', 1);
			$this -> Cell(18, $l, 'Telefone', 1, 0, 'C', 1);
			$this -> Cell(27, $l, 'Data de Cadastro', 1, 0, 'L', 1);
			$this -> Ln();

		} elseif ($_GET['opc'] == "gv") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(19, $l, 'Codigo ', 1, 0, 'L', 1);
			$this -> Cell(62, $l, 'Nome', 1, 0, 'l', 1);
			$this -> Cell(64, $l, 'Superior', 1, 0, 'L', 1);
			$this -> Cell(18, $l, 'Telefone', 1, 0, 'C', 1);
			$this -> Cell(27, $l, 'Data de Cadastro', 1, 0, 'L', 1);
			$this -> Ln();
		} elseif ($_GET['opc'] == "op") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(20, $l, 'Codigo ', 1, 0, 'L', 1);
			$this -> Cell(66, $l, 'Nome', 1, 0, 'l', 1);
			$this -> Cell(56, $l, 'Superior', 1, 0, 'L', 1);
			$this -> Cell(20, $l, 'Telefone', 1, 0, 'C', 1);
			$this -> Cell(28, $l, 'Data de cadastro', 1, 0, 'L', 1);
			$this -> Ln();
		} elseif ($_GET['opc'] == "vd") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(19, $l, 'Codigo ', 1, 0, 'L', 1);
			$this -> Cell(60, $l, 'Vendedor', 1, 0, 'l', 1);
			$this -> Cell(66, $l, 'Gerente Vendas', 1, 0, 'l', 1);
			$this -> Cell(18, $l, 'Telefone', 1, 0, 'C', 1);
			$this -> Cell(27, $l, 'Data de Cadastro', 1, 0, 'L', 1);
			$this -> Ln();
		} elseif ($_GET['opc'] == "pr") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(30, $l, 'Id', 1, 0, 'L', 1);
			$this -> Cell(50, $l, 'Produto', 1, 0, 'l', 1);
			$this -> Cell(25, $l, 'Valor', 1, 0, 'l', 1);
			$this -> Cell(30, $l, 'Cadastrado', 1, 0, 'C', 1);
                        $this -> Cell(55, $l, 'Cadastrador(a)', 1, 0, 'C', 1);

			$this -> Ln();
		} elseif ($_GET['opc'] == "ac") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(66, $l, 'Operador Telemarketing', 1, 0, 'l', 1);
			$this -> Cell(66, $l, 'Quantidade', 1, 0, 'l', 1);
			$this -> Cell(25, $l, 'Data cadastro', 1, 0, 'l', 1);
			//$this -> Cell(33, $l, '', 1, 0, 'C', 1);

			$this -> Ln();
		} elseif ($_GET['opc'] == "ag") {
			//TITULO DA TABELA DE SERVI�OS
			$this -> SetFillColor(232, 232, 232);
			$this -> SetTextColor(0, 0, 0);
			$this -> SetFont('Arial', 'B', 8);
			$this -> Cell(66, $l, 'Gerente Telemarketing', 1, 0, 'l', 1);
			$this -> Cell(66, $l, 'Operador Telemarketing', 1, 0, 'l', 1);
			$this -> Cell(26, $l, 'Agendamento/Operador', 1, 0, 'l', 1);
			$this -> Cell(32, $l, 'Data da agendamento', 1, 0, 'C', 1);

			$this -> Ln();
		}
	}

	function Footer() {// CRIANDO UM RODAPE

		/*$this->SetXY(15,280);
		 $this->Rect(10,270,190,20);
		 $this->SetFont('Arial','',10);
		 $this->Cell(70,8,'Assinatura ','T',0,'L');
		 $this->Cell(40,8,' ',0,0,'L');
		 $this->Cell(70,8,'Assinatura','T',0,'L');
		 $this->Ln();
		 */
		$this -> SetFont('Arial', '', 7);
		$this -> Cell(190, 7, 'Pagina ' . $this -> PageNo() . ' de {nb}', 0, 0, 'C');
	}

}

//CONECTE SE AO BANCO DE DADOS SE PRECISAR
//include_once ("../conexao/db_connect.inc.php"); // A MINHA CONEX�O
	$conn = new Connection();
	$pdf = new PDF('P', 'mm', 'A4');
//CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
	$pdf -> AddPage();
// ADICIONA UMA PAGINA
	$pdf -> AliasNbPages();
// SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
		$pdf -> SetFont('Arial', '', 8);
		$y = 49;
// AQUI EU COLOCO O Y INICIAL DOS DADOS

//SELECAO DOS DADOS QUE IR�O PRO PDF
   $clausula="";
	 if ($_GET['opc'] == "cliente") {
                        if(!empty($_GET["data"])){
                            $clausula=$clausula." AND C.data_cadastro  like'%".$_GET["data"]."%'";    
                        } 
                        if(!empty($_GET["periodo1"])&& !empty($_GET["periodo2"])){
                            $clausula=$clausula." AND C.data_cadastro BETWEEN '".$_GET["periodo1"]."' AND '".$_GET["periodo2"]."'";
                        }
                        if(!empty($_GET["uf"])){
                            $clausula=$clausula." AND E.id=$_GET[uf]";
                        }
                        if(!empty($_GET["municipio"])){
                            $clausula=$clausula." AND C.municipio_codigo=$_GET[municipio]";
                        }
                       $sql = $conn -> query("select C.*,M.nome AS municipio,E.uf AS estado from cliente AS C INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                                INNER JOIN estado AS E ON E.id=M.estado_uf WHERE ativo=0 AND C.empresa_id=$_SESSION[empresaId] $clausula ORDER BY nome");

		} else if ($_GET['opc'] == "funcionario") {

			$sql = $conn->query("SELECT F.id,F.nome,F.fone1,F.fone2,F.email,F.sexo,F.logradouro,F.data_nascimento,F.superior_id,F.perfil,CA.nome AS cargo,
                                           F.data_admissao,F.complemento,F.bairro,F.data_cadastro,F.cpf,M.nome AS municipio,E.uf AS estado
                                           FROM  funcionario AS F INNER JOIN municipio AS M ON F.municipio_codigo=M.id
                                           INNER JOIN estado AS E ON E.id=M.estado_uf
                                           INNER JOIN cargo AS CA ON CA.id=F.cargo_id
                                           WHERE F.ativo=0 AND F.empresa_id=$_SESSION[empresaId] AND F.cargo_id=$_GET[req]");

                } else if ($_GET['opc'] == "vi") {

			if (!empty($_GET['req'])) {
					$ordenacao = " order by V.data";
				} else {
					$ordenacao = " order by V.id_gerVendas";
					}
	
					$sql = $conn -> query("SELECT distinct G.nome,VD.nome_vendedor,V.id_vendedor,V.data,count(V.id_vendedor)as contador FROM visita AS V INNER JOIN vendedor AS VD ON V.id_vendedor = VD.id_vendedor 
										INNER JOIN gerente_vendas G ON G.id=V.id_gerVendas $_GET[req]   group by V.data $ordenacao ");

			} else if ($_GET['opc'] == "pr") {
                                 if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
                                         $clausula=$clausula." AND  P.data_cadastro BETWEEN '".$_GET['periodo1']."' AND '".$_GET['periodo2']."'"; 	
                                 }
                                 if(!empty($_GET['data'])){
                                    $clausula=$clausula." AND  P.data_cadstro like'%".$_GET['data']."%'"; 	
                                }
                               
                                $sql = $conn-> query("SELECT P.*,F.nome as cadastrador FROM produto as P INNER JOIN funcionario AS F ON F.id=P.usuario_cadastro 
                                                               WHERE P.ativo=0 AND F.empresa_id=$_SESSION[empresaId] $clausula");
                                        

			}/* else if ($_GET['opc'] == "ac") {
                            //condicao
                               if(!empty($_GET['periodo1'])&& !empty($_GET['periodo2'])){
                                $clausula=$clausula." AND  AC.data BETWEEN '".$_GET['periodo1']."' AND '".$_GET['periodo2']."'"; 	
                                }
                                if(!empty($_GET['data'])){
                        	$clausula=$clausula." AND  AC.data like'%".$_GET['data']."%'"; 	
                                }
                                if(!empty($_GET["operador"])){
                                  $clausula=$clausula."AND AC.id_operador=".$_GET["operador"];
                                    } 
                            
					$sql = $conn -> query("SELECT count(AC.id_operador) AS contador,AC.id_operador,OP.nome_operador,AC.data 
                                                                FROM acompanhamento AS AC INNER JOIN operador_marketing AS OP ON AC.id_operador=OP.id_operador
                                                                WHERE AC.ativo=0 AND OP.ativo=0 $clausula group by AC.data ORDER BY AC.id_operador");
			} else if ($_GET['opc'] == "ag") {

					$sql = $conn -> query("SELECT count(AG.id_operador) AS  contador,OP.nome_operador,GT.nome,AG.data FROM agendamento AS AG 
													INNER JOIN operador_marketing AS OP ON AG.id_operador=OP.id_operador INNER JOIN gerente_marketing AS GT 
													ON GT.id=OP.superior    $_GET[req] group by AG.id_operador");
				}*/

$l = 5;
// ALTURA DA LINHA

// $l = 5 * contaLinhas($dados2,48);
// Eu criei a fun��o "contaLinhas" para contar quantas linhas um campo pode conter se tiver largura = 48

while ($row = $sql -> fetch(PDO::FETCH_OBJ)) {
	if ($_GET['opc'] == "cliente") {
            
		$dados1 = $row -> id;
		$dados2 = $row -> nome;
		$dados3 = $row -> sexo;
                if(!empty($row->fone1)){
                    $dados4 = $row -> fone1;
                }else{
                    $dados4 = $row -> fone2;
                }
                $dados5 = $row -> logradouro;
		$dados6 = $row -> bairro;
		$dados7 = $row -> municipio;
		$dados8 = $row -> estado;
		$dados9 =  formata_data($row -> data_cadastro);
		$dados10 ="";

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 7, $l);
		$pdf -> MultiCell(7, 6, $dados1, 0, 2);
		// codigo
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(18);
		$pdf -> Rect(17, $y, 40, $l);
		$pdf -> MultiCell(40, 6, $dados2, 0, 2);
		//nome
		$pdf -> SetY($y);
		$pdf -> SetX(57);
		$pdf -> Rect(57, $y, 9, $l);
		$pdf -> MultiCell(9, 5, $dados3, 0, 2);
		//sexo
		$pdf -> SetY($y);
		$pdf -> SetX(66);
		$pdf -> Rect(66, $y, 15, $l);
		$pdf -> MultiCell(15, 6, $dados4, 0, 2);
		//telefone fixo
		$pdf -> SetY($y);
		$pdf -> SetX(81);
		$pdf -> Rect(81, $y, 37, $l);
		$pdf -> MultiCell(37, 6, $dados5, 0, 2);
		//celular
		$pdf -> SetY($y);
		$pdf -> SetX(118);
		$pdf -> Rect(118, $y,30, $l);
		$pdf -> MultiCell(30, 6, $dados6, 0, 2);
		//endereco
                $pdf -> SetY($y);
		$pdf -> SetX(148);
		$pdf -> Rect(148, $y, 30, $l);
		$pdf -> MultiCell(30, 6, $dados7, 0, 2);
                
                $pdf -> SetY($y);
		$pdf -> SetX(178);
		$pdf -> Rect(178, $y,7, $l);
		$pdf -> MultiCell(7, 6, $dados8, 0, 2);
                
                $pdf -> SetY($y);
		$pdf -> SetX(185);
		$pdf -> Rect(185, $y, 15, $l);
		$pdf -> MultiCell(15, 6, $dados9, 0, 2);
                
	} else if ($_GET['opc'] == "admin") {
		$dados1 = $row -> id;
		$dados2 = $row -> nome;
                $dados3 = $row -> fone;
                $dados4 = $row -> logradouro;
                $dados5 = $row -> bairro;
		$dados6 = $row -> municipio;
                $dados7 = $row -> uf;
                $dados8 = $row -> data_crenden;
		
		//$dados5 = $row->logradouro;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 12, $l);
		$pdf -> MultiCell(10, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(22);
		$pdf -> Rect(22, $y, 62, $l);
		$pdf -> MultiCell(61, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(84);
		$pdf -> Rect(84, $y, 17, $l);
		$pdf -> MultiCell(18, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(101);
		$pdf -> Rect(101, $y, 32, $l);
		$pdf -> MultiCell(31, 6, $dados4, 0, 2);
                $pdf -> SetY($y);
		$pdf -> SetX(133);
		$pdf -> Rect(133, $y, 23, $l);
		$pdf -> MultiCell(23, 6, $dados5, 0, 2);
                $pdf -> SetY($y);
		$pdf -> SetX(156);
		$pdf -> Rect(156, $y, 20, $l);
		$pdf -> MultiCell(20, 6, $dados6, 0, 2);
                $pdf -> SetY($y);
		$pdf -> SetX(176);
		$pdf -> Rect(176, $y, 5, $l);
		$pdf -> MultiCell(5, 6, $dados7, 0, 2);
                $pdf -> SetY($y);
		$pdf -> SetX(181);
		$pdf -> Rect(181, $y, 19, $l);
		$pdf -> MultiCell(18, 6, $dados8, 0, 2);

                        
	} else if ($_GET['opc'] == "gt") {
		$dados1 = $row -> id;
		$dados2 = $row -> gerente;
		$dados3 = $row -> nome;
		$dados4 = $row -> fone;
		$dados5 = $row -> data_crenden;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 19, $l);
		$pdf -> MultiCell(19, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(29);
		$pdf -> Rect(29, $y, 62, $l);
		$pdf -> MultiCell(60, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(91);
		$pdf -> Rect(91, $y, 64, $l);
		$pdf -> MultiCell(60, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(155);
		$pdf -> Rect(155, $y, 18, $l);
		$pdf -> MultiCell(18, 6, $dados4, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(173);
		$pdf -> Rect(173, $y, 27, $l);
		$pdf -> MultiCell(27, 6, $dados5, 0, 2);

	} else if ($_GET['opc'] == "gv") {
		$dados1 = $row -> id;
		$dados2 = $row -> nome;
		$dados3 = $row -> superior;
		$dados4 = $row -> fone;
		$dados5 = formata_data($row -> data_crenden);

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 19, $l);
		$pdf -> MultiCell(19, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(29);
		$pdf -> Rect(29, $y, 62, $l);
		$pdf -> MultiCell(60, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(91);
		$pdf -> Rect(91, $y, 64, $l);
		$pdf -> MultiCell(60, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(155);
		$pdf -> Rect(155, $y, 18, $l);
		$pdf -> MultiCell(18, 6, $dados4, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(173);
		$pdf -> Rect(173, $y, 27, $l);
		$pdf -> MultiCell(27, 6, $dados5, 0, 2);

	} else if ($_GET['opc'] == "op") {
		$dados1 = $row -> id_operador;
		$dados2 = $row -> nome_operador;
		$dados3 = $row -> nome;
		$dados4 = $row -> fone;
		$dados5 = $row -> data_crenden;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 20, $l);
		$pdf -> MultiCell(20, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(30);
		$pdf -> Rect(30, $y, 66, $l);
		$pdf -> MultiCell(66, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(96);
		$pdf -> Rect(96, $y, 56, $l);
		$pdf -> MultiCell(56, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(152);
		$pdf -> Rect(152, $y, 20, $l);
		$pdf -> MultiCell(30, 6, $dados4, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(172);
		$pdf -> Rect(172, $y, 28, $l);
		$pdf -> MultiCell(28, 6, $dados5, 0, 2);

	} else if ($_GET['opc'] == "vd") {
		$dados1 = $row -> id_vendedor;
		$dados2 = $row -> nome_vendedor;
		$dados3 = $row -> nome;
		$dados4 = $row -> fone;
		$dados5 = $row -> data_crenden;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 19, $l);
		$pdf -> MultiCell(19, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(29);
		$pdf -> Rect(29, $y, 60, $l);
		$pdf -> MultiCell(60, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(89);
		$pdf -> Rect(89, $y, 66, $l);
		$pdf -> MultiCell(60, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(155);
		$pdf -> Rect(155, $y, 18, $l);
		$pdf -> MultiCell(18, 6, $dados4, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(173);
		$pdf -> Rect(173, $y, 27, $l);
		$pdf -> MultiCell(27, 6, $dados5, 0, 2);
	} else if ($_GET['opc'] == "vn") {

		$dados1 = $row -> nome;
		$dados2 = $row -> nome_vendedor;
		$dados3 = formata_data($row -> data_venda);
		$dados4 = $row -> contador;

	} else if ($_GET['opc'] == "vi") {

		$pdf -> SetFillColor(232, 232, 232);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetFont('Arial', 'B', 8);
		$pdf -> Cell(53, $l, 'Gerente Vendas', 1, 0, 'L', 1);
		$pdf -> Cell(66, $l, 'Vendedor', 1, 0, 'l', 1);
		$pdf -> Cell(20, $l, 'Data Visita', 1, 0, 'L', 1);
		$pdf -> Cell(30, $l, 'Visitas/Vendedor', 1, 0, 'C', 1);
		/* $this->Cell(12,$l,'Titulo 5',1,0,'C',1);
		 $this->Cell(40,$l,'Titulo 6',1,0,'C',1);
		 $this->Cell(15,$l,'Titulo 7',1,0,'C',1);
		 */
		$dados1 = $row -> nome;
		$dados2 = $row -> nome_vendedor;
		$dados3 = formata_data($row -> data);
		$dados4 = $row -> contador;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 53, $l);
		$pdf -> MultiCell(100, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(65);
		$pdf -> Rect(63, $y, 66, $l);
		$pdf -> MultiCell(66, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(129);
		$pdf -> Rect(129, $y, 20, $l);
		$pdf -> MultiCell(20, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(149);
		$pdf -> Rect(149, $y, 30, $l);
		$pdf -> MultiCell(50, 6, $dados4, 0, 2);

		$pdf -> Ln();

		//TITULO DA TABELA

		$pdf -> SetY(49);
		$pdf -> SetX(10);
		$pdf -> SetFont('Arial', '', 8);
		$pdf -> Cell(20, $l, 'Codigo ', 1, 0, 'L');
		$pdf -> Cell(66, $l, 'Nome', 1, 0, 'L');
		$pdf -> Cell(56, $l, 'Superior', 1, 0, 'L', 1);
		$pdf -> Cell(20, $l, 'Telefone', 1, 0, 'L', 1);
		$pdf -> Cell(28, $l, 'Data de cadastro', 1, 0, 'L', 1);

		//busca a visita  do vendedor

		//condicao
		if (!empty($_GET['req'])) {
			$condicao = $_GET['req'] . " AND ";
		} else {
			$condicao = "WHERE";

		}

		$pdf -> SetY(49);
		$pdf -> SetX(10);
		$pdf -> SetFillColor(232, 232, 232);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetFont('Arial', 'B', 8);
		$pdf -> Cell(53, $l, 'vendedor', 1, 0, 'L', 1);
		$pdf -> Cell(66, $l, 'cliente', 1, 0, 'l', 1);
		$pdf -> Cell(20, $l, 'produto', 1, 0, 'L', 1);
		$pdf -> Cell(30, $l, 'Visitas/Vendedor', 1, 0, 'C', 1);

		$sql2 = $conn -> query("SELECT V.id_visita,VD.nome_vendedor,V.data,G.nome,V.id_produto,C.nome AS cliente,P.nome_produto FROM visita AS V 
		   						INNER JOIN gerente_vendas AS G ON V.id_gerVendas=G.id INNER JOIN vendedor AS VD ON	V.id_vendedor = VD.id_vendedor
		   						INNER JOIN cliente AS C ON V.id_cliente=C.id_cliente INNER JOIN produto P ON P.id_produto=V.id_produto
		   						 $condicao  V.id_vendedor=$row->id_vendedor
								 ");
		$y = $y + 5;
		while ($lin = $sql2 -> fetch(PDO::FETCH_OBJ)) {

			$pdf -> SetY($y);
			$pdf -> SetX(10);
			$pdf -> Rect(10, $y, 20, $l);
			$pdf -> MultiCell(20, 6, $lin -> id_visita, 0, 2);
			$pdf -> SetY($y);
			$pdf -> SetX(30);
			$pdf -> Rect(30, $y, 58, $l);
			$pdf -> MultiCell(58, 6, $lin -> nome_vendedor, 0, 2);
			$pdf -> SetY($y);
			$pdf -> SetX(88);
			$pdf -> Rect(88, $y, 51, $l);
			$pdf -> MultiCell(51, 6, $lin -> cliente, 0, 2);
			$pdf -> SetY($y);
			$pdf -> SetX(139);
			$pdf -> Rect(139, $y, 40, $l);
			$pdf -> MultiCell(40, 6, $lin -> nome_produto, 0, 2);
			$y = $y + 5;
			if ($y + $l >= 230) {// 230 � O TAMANHO MAXIMO ANTES DO RODAPE

				$pdf -> AddPage();
				// SE ULTRAPASSADO, � ADICIONADO UMA P�GINA
				$y = 49;
				// E O Y INICIAL � RESETADO

			}

		}
		// 230 � O TAMANHO MAXIMO ANTES DO RODAPE

		$pdf -> AddPage();
		// SE ULTRAPASSADO, � ADICIONADO UMA P�GINA
		$y = 49;
		// E O Y IN
//RELATOIO DE ACOMPANHADOS
	} elseif ($_GET['opc'] == "ac") {
                         $dados1 =$row->id_operador;
                        $dados2 = $row -> nome_operador;
                        $dados3 = $row -> contador;
                        $dados4 = formata_data($row -> data);
                        
                        $pdf -> SetY($y);
                        $pdf -> SetX(10);
                        $pdf -> Rect(10, $y, 66, $l);
                        $pdf -> MultiCell(100, 6, $dados2, 0, 2);
                        // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
                        $pdf -> SetFont('Arial', '', 6);
                        $pdf -> SetY($y);
                        $pdf -> SetX(76);
                        $pdf -> Rect(76, $y, 66, $l);
                        $pdf -> MultiCell(66, 6, $dados3, 0, 2);
                        $pdf -> SetY($y);
                        $pdf -> SetX(142);
                        $pdf -> Rect(142, $y, 25, $l);
                        $pdf -> MultiCell(26, 5, $dados4, 0, 2);
                        //$pdf -> SetY($y);
                        //$pdf -> SetX(167);
                        //$pdf -> Rect(167, $y, 33, $l);
                        //$pdf -> MultiCell(33, 6,, 0, 2);
            //LISTA O DADOS DO ACOMPANHAMENTO
             $acompanhados= $conn->query("SELECT  AC.id_cliente,C.nome,C.tel_fixo,C.endereco,C.bairro,P.nome_produto
                                                     FROM acompanhamento AS AC INNER JOIN operador_marketing AS OP ON AC.id_operador=OP.id_operador
                                                     INNER JOIN cliente AS C ON C.id_cliente=AC.id_cliente
                                                     INNER JOIN visita AS V ON V.id_visita=AC.id_visita
                                                     INNER JOIN produto AS P ON P.id_produto=V.id_produto
                                                     WHERE AC.ativo=0 AND OP.ativo=0 AND AC.id_operador=$row->id_operador AND AC.data='".$dados4."'");
            $pdf -> Ln();
             $y=$y+6;
             $pdf -> SetFillColor(232, 232, 232);
             $pdf -> SetTextColor(0, 0, 0);
			
             $pdf -> SetY($y);
             $pdf -> SetX(10);
             $pdf -> Rect(10, $y, 66, $l);
             //ID CLIENTE
             $pdf -> MultiCell(100, 6,'id Cliente',  1, 0, 'C', 1);
                        // ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
            $pdf -> SetFont('Arial', '', 6);
            //NOME CLIENTE
            $pdf -> SetY($y);
             $pdf -> SetX(76);
             $pdf -> Rect(76, $y, 66, $l);
             $pdf -> MultiCell(66, 6,'Cliente', 1, 0, 'C', 1);
             //TELEFONE
             $pdf -> SetY($y);
             $pdf -> SetX(142);
             $pdf -> Rect(142, $y, 25, $l);
             $pdf -> MultiCell(26, 5,"Fone", 1, 0, 'C', 1);
            //ENDRECO
             
                       
          while ($lista=$acompanhados->fetch(PDO::FETCH_OBJ)){
              
              $dados5 =$lista->id_cliente;
              $dados6=$lista->nome;
              $dados7 =$lista->tel_fixo;
              $dados8 =$lista->endereco;
              $dados9 =$lista->bairro;
              $dados10 =$lista->nome_produto;

              }
              if ($y + $l >= 230) {// 230 � O TAMANHO MAXIMO ANTES DO RODAPE

		$pdf -> AddPage();
		// SE ULTRAPASSADO, � ADICIONADO UMA P�GINA
		$y = 49;
		// E O Y INICIAL � RESETADO
                }
  
        

	} elseif ($_GET['opc'] == "ag") {
		$dados1 = $row -> nome;
		$dados2 = $row -> nome_operador;
		$dados3 = $row -> contador;
		$dados4 = formata_data($row -> data);

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 66, $l);
		$pdf -> MultiCell(100, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(76);
		$pdf -> Rect(76, $y, 66, $l);
		$pdf -> MultiCell(66, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(142);
		$pdf -> Rect(142, $y, 26, $l);
		$pdf -> MultiCell(26, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(168);
		$pdf -> Rect(168, $y, 32, $l);
		$pdf -> MultiCell(32, 6, $dados4, 0, 2);

	}

	if ($y + $l >= 230) {// 230 � O TAMANHO MAXIMO ANTES DO RODAPE

		$pdf -> AddPage();
		// SE ULTRAPASSADO, � ADICIONADO UMA P�GINA
		$y = 49;
		// E O Y INICIAL � RESETADO

	}

	//DADOS
	if ($_GET['opc'] == "vn") {
		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 66, $l);
		$pdf -> MultiCell(66, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(76);
		$pdf -> Rect(76, $y, 60, $l);
		$pdf -> MultiCell(60, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(136);
		$pdf -> Rect(136, $y, 20, $l);
		$pdf -> MultiCell(20, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(156);
		$pdf -> Rect(156, $y, 30, $l);
		$pdf -> MultiCell(30, 6, $dados4, 0, 2);
		//$pdf->SetY($y);
		//$pdf->SetX(169);
		//$pdf->Rect(169,$y,20,$l);
		// $pdf->MultiCell(30,6,$dados5,0,2);

	} elseif ($_GET['opc'] == "pr") {
		$dados1 = $row -> id;
		$dados2 = $row -> nome;
		$dados3 = $row -> valor;
		$dados4 = formata_data($row -> data_cadastro);
                $dados5 = $row -> cadastrador;

		$pdf -> SetY($y);
		$pdf -> SetX(10);
		$pdf -> Rect(10, $y, 30, $l);
		$pdf -> MultiCell(30, 6, $dados1, 0, 2);
		// ESTA � A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA
		$pdf -> SetFont('Arial', '', 6);
		$pdf -> SetY($y);
		$pdf -> SetX(40);
		$pdf -> Rect(40, $y, 50, $l);
		$pdf -> MultiCell(50, 6, $dados2, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(90);
		$pdf -> Rect(90, $y, 25, $l);
		$pdf -> MultiCell(25, 5, $dados3, 0, 2);
		$pdf -> SetY($y);
		$pdf -> SetX(115);
		$pdf -> Rect(115, $y, 30, $l);
		$pdf -> MultiCell(30, 6, $dados4, 0, 2);
                
                $pdf -> SetY($y);
		$pdf -> SetX(145);
		$pdf -> Rect(145, $y, 55, $l);
		$pdf -> MultiCell(55, 6, $dados5, 0, 2);

	}

	
	$pdf -> Ln();
	$y += $l;

}


$pdf -> Output();
// IMPRIME O PDF NA TELA
Header('Pragma: public');
// ESTA FUN��O � USADA PELO FPDF PARA PUBLICAR NO IE
?>