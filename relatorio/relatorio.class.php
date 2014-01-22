<?php

ob_start();

class Relatorio {

    private $adm;
    private $sql;
    private $conn;
    private $gerVendas;
    private $vendedor;
    private $operador;
    private $gerenteTelemarketing;
    private $status;
    private $prod;
    private $plano;
    private $opcaoData;
    private $tipoGrafico;
    private $contador;
    private $conta;
     //escolheu relatorio por dia / mes /ano
    private $data;
    private $opcaoExibicao;
    //escolheu por periodo
    private $periodo1;
    private $periodo2;
    private $pendente;
    private $municipio;
    private $comissao;
    private $uf;
    
    function __construct() {
        $this->conn = new Connection();
    }

    function setAdm($adm) {
        $this->adm = $adm;
    }

    function setOpcaoData($opcaoData) {
        $this->opcaoData = $opcaoData;
    }

    function setGerVendas($gerVendas) {
        $this->gerVendas = $gerVendas;
    }

    function setVendedor($vendedor) {
        $this->vendedor = $vendedor;
    }

    function setOperador($operador) {
        $this->operador = $operador;
    }

    function setGerTelemarketing($gerenteTelemarketing) {
        if (!empty($gerenteTelemarketing))
            $this->gerenteTelemarketing = $gerenteTelemarketing;
    }

    function setStatus($status) {
        if ($status == 0) {
            $this->status = '00';
        } else {
            $this->status = $status;
        }
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }

    function setProduto($prod) {
        $this->prod = $prod;
    }

    function setPeriodo1($periodo1) {
        if (!empty($periodo1)) {
            $this->periodo1 = formata_data_db($periodo1);
        } else {
            $this->periodo1 = $periodo1;
        }
    }

    function setPeriodo2($periodo2) {
        if (!empty($periodo2)) {
            $this->periodo2 = formata_data_db($periodo2);
        } else {
            $this->periodo2 = $periodo2;
        }
    }

    function setdata($data) {
        if (!empty($data)) {
            $d = explode("/", $data);

            //SE FOR DATA COMPLETA DIA/MES/ANO
            if ($this->opcaoData == "dia") {

                $this->data = $d[2] . "-" . $d[1] . "-" . $d[0];
            }
            //SE FOR DATA /MES/ANO
            else if ($this->opcaoData == "mes") {

                $this->data = $d[1] . "-" . $d[0];
            }//SE FOR DATA /ANO
            else if ($this->opcaoData == "ano") {

                $this->data = $d[0];
            }
        }
    }

    function setContador($contador) {
        $this->contador = $contador;
    }
     function setPendentes($pendente) {
        $this->pendente = $pendente;
    }
     function setUF($uf) {
        $this->uf = $uf;
    }
     function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    function setOpcaoExibicao($opcaoExibicao) {
        if (!empty($opcaoExibicao)) {
            $this->opcaoExibicao = $opcaoExibicao;
        }
    }
    function setComissao($comissao) {
            $this->comissao = $comissao;
      
    }
    

    function getOpcaoExibicao() {
        return $this->opcaoExibicao;
    }

    function setTipoGrafico($tipoGrafico) {
        if (!empty($tipoGrafico)) {
            $this->tipoGrafico = $tipoGrafico;
        }
    }

    function getTipoGrafico() {
        return $this->tipoGrafico;
    }

    function getAdm() {
        return $this->adm;
    }

    function getOpcaoData() {
        return $this->opcaoData;
    }

    function getGerVendas() {
        return $this->gerVendas;
    }

    function getVendedor() {
        return $this->vendedor;
    }

    function getOperador() {
        return $this->operador;
    }

    function getGerTelemarketing() {
        return $this->gerenteTelemarketing;
    }

    function getStatus() {
        return $this->status;
    }

    function getProduto() {
        return $this->prod;
    }

    function getplano() {
        return $this->plano;
    }

    function getDia() {
        return $this->dia;
    }

    function getMes() {
        return $this->mes1;
    }

    function getAno() {
        return $this->ano;
    }

    function getdata() {
        return $this->data;
    }

    function getPeriodo1() {
        return $this->periodo1;
    }
    function getMunicipio() {
        return $this->municipio;
    }

    function getPeriodo2() {
        return $this->periodo2;
    }

    function getContador() {
        return $this->contador;
    }
 function retornaGerente()
 {
       $sql_gerente=  $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND perfil=3 AND empresa_id=$_SESSION[empresaId] ");
    if($sql_gerente){
        return $sql_gerente;
    }
 }  
 function retornaGerenteVisita()
 {
   
       $sql_gerente=  $this->conn->query("SELECT F.id,F.nome FROM funcionario AS F InNER JOIN visita AS V ON F.id=V.gerente_vendas_id 
                                            WHERE V.ativo=0 AND F.perfil=3 AND F.empresa_id=$_SESSION[empresaId] ");
    if($sql_gerente){
        return $sql_gerente;
    }
 } 
 
 function retornaSuperior()
 {
       $sql_sup=  $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0  AND empresa_id=$_SESSION[empresaId] ");
    if($sql_sup){
        return $sql_sup;
    }
 }  
 function consultaCliente() {
     
       $clausula = "";
        //SE  PERIoDO TIVER SIDO PASSADO
        if (!empty($this->periodo1)) {
            $clausula =$clausula. " AND C.data_cadastro BETWEEN '$this->periodo1' AND '$this->periodo2'";
        } else if (!empty($this->data)) {
            $clausula =$clausula. " AND C.data_cadastro LIKE'%$this->data%'";
        }
        if (!empty($this->uf)) {
            $clausula =$clausula. " AND E.id=$this->uf";
        }
        if (!empty($this->municipio)) {
            $clausula =$clausula. " AND C.municipio_codigo=$this->municipio";
        }
           
        
        $sql = $this->conn->query("select C.*,M.nome AS municipio,E.nome AS estado from cliente AS C 
                                    INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                    INNER JOIN estado AS E ON E.id=M.estado_uf WHERE C.ativo=0 AND C.empresa_id=$_SESSION[empresaId] $clausula  ORDER BY C.nome ");

        $this->setContador($sql->rowCount());

        if ($this->contador != 0) {
          
            if ($this->opcaoExibicao == "tela") {

                return $sql;
            } else if ($this->opcaoExibicao == "pdf") {
                                 
                       echo "  <script type='text/javascript'>
                                  window.open('relatorio/pdf.php?periodo1=$this->periodo1&perido2=$this->periodo2&data=$this->data&uf=$this->uf&mun=$this->municipio&opc=cliente')
                                </script>"; 
            }
         
       } else {

            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }

    function consultaFuncionario($perfil) {


        $sql = $this->conn->query("SELECT F.id,F.nome,F.fone1,F.fone2,F.email,F.sexo,F.logradouro,F.data_nascimento,F.superior_id,F.perfil,CA.nome AS cargo,
                                           F.data_admissao,F.complemento,F.bairro,F.data_cadastro,F.cpf,M.nome AS municipio,E.uf AS estado
                                           FROM  funcionario AS F INNER JOIN municipio AS M ON F.municipio_codigo=M.id
                                           INNER JOIN estado AS E ON E.id=M.estado_uf
                                           INNER JOIN cargo AS CA ON CA.id=F.cargo_id
                                           WHERE F.ativo=0 AND F.empresa_id=$_SESSION[empresaId] AND F.cargo_id=$perfil");
        $this->setContador($sql->rowCount());

        if ($this->contador != 0) {

            if ($this->opcaoExibicao == "tela") {
                include_once 'ListaFuncionario.php';
            } elseif ($this->opcaoExibicao == "pdf") {
                 echo "  <script type='text/javascript'>
                                  window.open('relatorio/pdf.php?req=$perfil&opc=funcionario')
                                </script>"; 
                
            }
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }

    ################################################################################################################################################################################
    # //RELATORIO DE VISITA
    ################################################################################################################################################################################

    function consultaVisita() {
        $clausula = "";
            if($_SESSION["tipo"]==0){
                $empresa="";
            }else{
                $empresa=" AND F.empresa_id=$_SESSION[empresaId]";
            }
       
            if (!empty($this->gerVendas)) {
                if (!empty($this->vendedor)) {
                    $clausula = $clausula . " AND V.vendedor_id=" . $this->vendedor;
                } else {
                    $clausula = $clausula . " AND V.gerente_vendas_id=" . $this->gerVendas;
                }
            } 
        
            if (!empty($this->status)) {
                     $clausula = $clausula . " AND VP.status=$this->status";
             }
            if (!empty($this->periodo1) && !empty($this->periodo2)) {
                    $clausula = $clausula . " AND V.data_visita BETWEEN '$this->periodo1' AND '$this->periodo2'";
             }
        
             if (!empty($this->data)) {
                $clausula = $clausula . " AND V.data_visita like'%$this->data%' ";
            }
             if (!empty($this->uf)) {
                $clausula = $clausula . "  AND E.id=$this->uf";
            }
            if (!empty($this->municipio)) {
                $clausula = $clausula ."  AND C.municipio_codigo=$this->municipio";
            }

         //coonsulta as visitas existentes 
             
            
        $sql = $this->conn->query("SELECT F.id,F.nome,F.superior_id,V.id as idVisita,V.gerente_vendas_id,V.vendedor_id,
                                    V.data_cadastro,V.data_visita,P.nome AS produto,C.nome AS cliente 
                                    FROM visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id
                                    INNER JOIN cliente AS C ON C.id=V.cliente_id
                                    INNER JOIN visita_produto AS VP ON	VP.visita_id = V.id
                                    INNER JOIN produto AS P On VP.produto_id=P.id
                                    INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                    INNER JOIN estado AS E ON E.id=M.estado_uf 
                                    WHERE V.ativo=0  $clausula      $empresa  ");
       
        $this->setContador($sql->rowCount());

        if ($sql->rowCount()) {
             
            if ($this->opcaoExibicao == "tela") {

                include_once 'ListaVisita.php';
            } else if ($this->opcaoExibicao == "grafico") {
                  echo "<script type='text/javascript'>
                         window.open('relatorio/grafico.php?uf=$this->uf&mun=$this->municipio&adm=$this->adm&gerente=$this->gerVendas&vend=$this->vendedor&status=$this->status&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=visita&emxp=$_POST[empresa]')    
                        </script>";   
            } elseif ($this->opcaoExibicao == "pdf") {
                    //REDIRECIONAR PARA PAGINA PDF
              echo "<script type='text/javascript'>
                    window.open('relatorio/relatorio.php?uf=$this->uf&mun=$this->municipio&adm=$this->adm&gerV=$this->gerVendas&vend=$this->vendedor&status=$this->status&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&emxp=$_SESSION[empresaId]&opc=vi')
                 </script>";
            
            }
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }

    //RELATORIO DE Vendas
 function consultaVenda() {
        $clausula = "";
            if($_SESSION["tipo"]==0){
                $empresa="";
            }else{
                $empresa=" AND F.empresa_id=$_SESSION[empresaId]";
            }
             if (!empty($this->uf)) {
                $clausula = " AND E.id=$this->uf";
             }
             if (!empty($this->municipio)) {
                $clausula = " AND C.municipio_codigo=$this->municipio";
             }
             if (!empty($this->gerVendas)) {
                           $clausula = $clausula . " AND V.gerente_vendas_id=" . $this->gerVendas;
             }
             if (!empty($this->vendedor)) {
                    $clausula = $clausula . " AND V.vendedor_id=" . $this->vendedor;
             }
            
            if (!empty($this->periodo1) && !empty($this->periodo2)) {
                  $clausula = $clausula . " AND VN.data BETWEEN '$this->periodo1' AND '$this->periodo2'";
            }
         
            if (!empty($this->data)) {
                $clausula = $clausula . " AND VN.data like'%$this->data%' ";
            }
        

      


        $sql = $this->conn->query("SELECT VN.id,VN.data,V.gerente_vendas_id,F.nome AS nomeFunc,F.id AS idFunc,P.id AS idProd,P.nome AS nomeProd,C.nome as cliente
                                    FROM visita AS V INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                    INNER JOIN  vendas AS VN ON VP.id=VN.visita_produto_id
                                    INNER JOIN produto AS P ON P.id=VP.produto_id
                                    INNER JOIN funcionario AS F ON F.id = V.vendedor_id 
                                    INNER JOIN cliente AS C ON C.id=V.cliente_id
                                    INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                    INNER JOIN estado AS E ON E.id=M.estado_uf 
				    WHERE V.ativo=0 AND VN.ativo=0  $empresa $clausula");
     
        if ($sql->rowCount()) {

            if ($this->opcaoExibicao == "tela") {
                  include_once 'ListaVenda.php';
            } elseif ($this->opcaoExibicao == "pdf") {

             echo "<script type='text/javascript'>
                    window.open('relatorio/relatorio2.php?uf=$this->uf&mun=$this->municipio&adm=$this->adm&gerV=$this->gerVendas&vend=$this->vendedor&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&emxp=$_POST[empresa]','_blank') 
                        </script>";
             
            } elseif ($this->opcaoExibicao == "grafico") {
                    echo "<script type='text/javascript'>
                       window.open('relatorio/grafico.php?uf=$this->uf&mun=$this->municipio&adm=$this->adm&gerV=$this->gerVendas&vend=$this->vendedor&status=$this->status&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&emxp=$_POST[empresa]&opc=venda&tGraf=$this->tipoGrafico','_blank')
                          </script>";
              
           
            }
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }
     function consultaComissao() {
         
        $clausula = "";
            if($_SESSION["tipo"]==0){
                $empresa="";
            }else{
                $empresa=" AND F.empresa_id=$_SESSION[empresaId]";
            }
             if (!empty($this->uf)) {
                $clausula = " AND E.id=$this->uf";
             }
             if (!empty($this->municipio)) {
                $clausula = " AND F.municipio_codigo=$this->municipio";
             }
             
             if (!empty($this->gerVendas)) {
                $clausula = $clausula . " AND V.gerente_vendas_id=" . $this->gerVendas;
             }
             if (!empty($this->vendedor)) {
                    $clausula = $clausula . " AND V.vendedor_id=" . $this->vendedor;
             }
             if(!empty($this->gerenteTelemarketing)){
                 $clausula=$clausula." AND F.superior_id=$this->gerenteTelemarketing";
             }
            if (!empty($this->operador)) {
              $clausula =$clausula." AND V.operador_id=$this->operador"; 
           }  
            if (!empty($this->periodo1) && !empty($this->periodo2)) {
                  $clausula = $clausula . " AND VN.data BETWEEN '$this->periodo1' AND '$this->periodo2'";
            }
            
         
            if (!empty($this->data)) {
                $clausula = $clausula . " AND VN.data like'%$this->data%' ";
            }
        


        $sql = $this->conn->query("SELECT VN.id,VN.data,V.gerente_vendas_id,F.nome AS nomeFunc,F.id AS idFunc,P.id AS idProd,P.nome AS nomeProd
                                    FROM visita AS V INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                                    INNER JOIN  vendas AS VN ON VP.id=VN.visita_produto_id
                                    INNER JOIN produto AS P ON P.id=VP.produto_id
                                    INNER JOIN funcionario AS F ON F.id = V.vendedor_id 
                                    WHERE V.ativo=0 AND VN.ativo=0  $empresa $clausula");
     
        if ($sql->rowCount()) {

            if ($this->opcaoExibicao == "tela") {
                if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 ){
                       include_once 'ListaComissao.php';
                 }else{
                    echo "<h3 style='color:red;'>Atenção você não tem permissão para acessa essas informações!</h3>";
                 } 
            } elseif ($this->opcaoExibicao == "pdf") {
                if($_SESSION["tipo"]==0 || $_SESSION["tipo"]==1 ){
                        echo "<script type='text/javascript'>
                                 window.open('relatorio/ComissaoPDF.php?gerV=$this->gerVendas&vend=$this->vendedor&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&gerT=$this->gerenteTelemarketing&op=$this->operador&emxp=$_POST[empresa]','_blank') 
                                </script>";
                 }else{
                    echo "<h3 style='color:red;'>Atenção você não tem permissão para acessa essas informações!</h3>";
                 }        
             
            } elseif ($this->opcaoExibicao == "grafico") {
                    echo "<script type='text/javascript'>
                       window.open('relatorio/grafico.php?uf=$this->uf&mun=$this->municipio&adm=$this->adm&gerV=$this->gerVendas&vend=$this->vendedor&status=$this->status&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&emxp=$_POST[empresa]&opc=venda&tGraf=$this->tipoGrafico','_blank')
                          </script>";
              
           
            }
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }

    //RELATORIO DE veiculos
    function consultaProduto() {
        //SE  PERIoDO TIVER SIDO PASSADO
        if (!empty($this->periodo1)) {

            $clausula = "AND data_cadastro BETWEEN '$this->periodo1' AND '$this->periodo2'";
        } elseif (!empty($this->this->data)) {
            $clausula = "AND data_cadastro LIKE'%$this->data%'";
        } else {
            $clausula = "";
        }
       
        $sql = $this->conn->query("SELECT  * from produto WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] $clausula");
        $this->setContador($sql->rowCount());

        if ($this->contador != 0) {

            if ($this->opcaoExibicao == "tela") {

                return $sql;
            } elseif ($this->opcaoExibicao == "pdf") {

                echo "  <script type='text/javascript'>
                       window.open('relatorio/pdf.php?opc=pr&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2')
                  </script>";    
                 

            }
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }

    function consultaAcompanhamento() {

         $clausula = "";
          
                 
        if (!empty($this->operador)) {
            $clausula = $clausula ." AND V.operador_id=$this->operador";
        }
            //SE  PERIoDO TIVER SIDO PASSADO
            if (!empty($this->periodo1)) {

                $clausula = $clausula ."  AND AC.data BETWEEN '$this->periodo1' AND '$this->periodo2'";
                //SE DATA NAO FOR VAZIA E PERIODO FOR VAZIO
            } else if (!empty($this->data)) {

                $clausula = $clausula ."  AND AC.data LIKE'%$this->data%' ";
               
                //SE DATA E PERIODO VAZIO
            } 

        $sql = $this->conn->query("SELECT count(F.id)AS contador,F.id ,F.nome ,V.operador_id,AC.id AS idAcom,AC.visita_id,AC.data,AC.hora,AC.statusOcorrencia,AC.ocorrencia_id
                                    FROM visita AS V INNER JOIN acompanhamento AS AC ON V.id=AC.visita_id 
                                    INNER JOIN funcionario AS F ON V.operador_id=F.id
                                    WHERE AC.ativo=0 AND F.ativo=0 AND F.empresa_id=$_SESSION[empresaId] $clausula group by AC.data ORDER BY V.operador_id");

        $this->setContador($sql->rowCount());
        if($this->contador) {

            if ($this->opcaoExibicao == "tela") {
               include_once 'ListaAcompanhamento.php';
            } elseif ($this->opcaoExibicao == "pdf"){
               echo "<script type='text/javascript'>
                       window.open('relatorio/AcompanhamentoPdf.php?gerenteTele=$this->gerenteTelemarketing&operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=ac')
                     </script>";
                 
            } else if ($this->opcaoExibicao == "grafico") {

              echo "  <script type='text/javascript'>
                       window.open('relatorio/grafico.php?gerenteTele=$this->gerenteTelemarketing&operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=ac&tGraf=$this->tipoGrafico&emxp=$_POST[empresa]')
                    </script>";
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }
    
    }

    function consultaAgendamento() {
        $clausula = "";
        if (!empty($this->operador)) {
             $clausula =$clausula." AND V.operador_id=$this->operador"; 
        }
            //SE  PERIoDO TIVER SIDO PASSADO
            if (!empty($this->periodo1)) {

                $clausula = $clausula." AND AG.data BETWEEN '$this->periodo1' AND '$this->periodo2' ";
                
                //SE DATA NAO FOR VAZIA E PERIODO FOR VAZIO
            } else if (!empty($this->data)) {

                $clausula = $clausula." AND AG.data LIKE'%$this->data%' ";
                
                //SE DATA E PERIODO VAZIO
            } 

            $sql = $this->conn->query("SELECT F.nome,count(F.id) AS contador,F.id,C.id as idCli,C.nome As cliente, AG.data,AG.hora
                                       FROM agendamento_visita AS AG 
                                       INNER JOIN acompanhamento AS AC ON AC.id=AG.acompanhamento_id
                                       INNER JOIN visita AS V ON V.id=AC.visita_id
                                       INNER JOIN cliente AS C ON C.id=V.cliente_id
                                       INNER JOIN funcionario AS F ON V.operador_id=F.id 
                                       WHERE F.ativo=0 AND AG.ativo=0 AND AC.ativo=0 AND V.ativo=0 AND C.ativo=0 $clausula ");

      
       if($sql->rowCount()){
            if ($this->opcaoExibicao == "tela") {   
                 include_once 'ListaAgendamento.php';
            } elseif ($this->opcaoExibicao == "pdf") {
                  echo "  <script type='text/javascript'>
                       window.open('relatorio/AgendamentoPdf.php?operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2')
                  </script>";      

            } else if ($this->opcaoExibicao == "grafico") {
                  echo "  <script type='text/javascript'>
                       window.open('relatorio/grafico.php?operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=ag&tGraf=$this->tipoGrafico&emxp=$_POST[empresa]')
                      </script>";       

            }
        }else{ echo "<h3>Nenhum registro encontrado</h3>";}
    }

function consultaPendencia() {

         $clausula = "";
          
                 
        if (!empty($this->operador)) {
            $clausula = $clausula ." AND V.operador_id=$this->operador";
        }
            //SE  PERIoDO TIVER SIDO PASSADO
            if (!empty($this->periodo1)) {

                $clausula = $clausula ."  AND AG.data BETWEEN '$this->periodo1' AND '$this->periodo2'";
                //SE DATA NAO FOR VAZIA E PERIODO FOR VAZIO
            } else if (!empty($this->data)) {

                $clausula = $clausula ."  AND AG.data LIKE'%$this->data%' ";
               
                //SE DATA E PERIODO VAZIO
            }
            if (!empty($this->pendente)) {

                $clausula = $clausula ."  AND AG.acompanhado=$this->pendente ";
               
                //SE DATA E PERIODO VAZIO
            } 
             
       $operadores=$this->conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F 
                                                  INNER JOIN visita AS V ON F.id=V.operador_id 
                                                  INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                  INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                  INNER JOIN agendamento_operador AS AG ON AG.acompanhamento_id = A.id
                                                   WHERE   F.empresa_id=$_SESSION[empresaId] $clausula AND A.ativo=0  AND VP.ativo=0");
       
      
        if($operadores->rowCount()) {

            if ($this->opcaoExibicao == "tela") {
               include_once 'ListaPendencia.php';
            } elseif ($this->opcaoExibicao == "pdf"){
               echo "<script type='text/javascript'>
                       window.open('relatorio/pendenciaPdf.php?gerenteTele=$this->gerenteTelemarketing&operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=ac')
                     </script>";
                 
            } else if ($this->opcaoExibicao == "grafico") {

              echo "  <script type='text/javascript'>
                       window.open('relatorio/grafico.php?gerenteTele=$this->gerenteTelemarketing&operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&opc=pen&tGraf=$this->tipoGrafico&emxp=$_POST[empresa]')
                    </script>";
        } else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    }else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
        }
    
    }
    function consultaRetornoInteligente() {

         $clausula = "";
         $diferenteVendido="";
         
        if (!empty($this->gerVendas)) {
              $clausula = $clausula . " AND V.gerente_vendas_id=" . $this->gerVendas;
        }
         if (!empty($this->vendedor)) {
              $clausula = $clausula . " AND V.vendedor_id=" . $this->vendedor;
         }
        if (!empty($this->operador)) {
            $clausula = $clausula ." AND V.operador_id=$this->operador";
        }
         if (!empty($this->status)) {
                if($this->status!=0){
                    $diferenteVendido=$diferenteVendido." AND VP.status<>0";
                }
               $clausula = $clausula . " AND VP.status=$this->status";
         }
        if (!empty($this->uf)) {
            $clausula = " AND E.id=$this->uf";
        }
        if (!empty($this->municipio)) {
            $clausula = " AND C.municipio_codigo=$this->municipio";
        }
             
            //SE  PERIoDO TIVER SIDO PASSADO
        if (!empty($this->periodo1)) {

            $clausula = $clausula ."  AND V.data_visita BETWEEN '$this->periodo1' AND '$this->periodo2'";
                //SE DATA NAO FOR VAZIA E PERIODO FOR VAZIO
         } else if (!empty($this->data)) {

            $clausula = $clausula ."  AND V.data_visita LIKE'%$this->data%' ";
               
                //SE DATA E PERIODO VAZIO
        }
              
         $sqlRetorno="SELECT V.id,V.cliente_id,V.data_visita FROM visita AS V INNER JOIN cliente AS C ON C.id=V.cliente_id
                      INNER JOIN visita_produto AS VP ON VP.visita_id=V.id 
                      INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id
                      INNER JOIN produto AS P ON P.id=VP.produto_id
                      INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                      INNER JOIN estado AS E ON E.id=M.estado_uf
                      WHERE C.ativo=0 AND V.ativo=0 AND VP.ativo=0  AND V.empresa_id=$_SESSION[empresaId] $diferenteVendido $clausula ORDER BY C.nome";
       
      //echo $sqlRetorno;
       
         $queryRetorno= $this->conn->query($sqlRetorno);
        //se encontra algum regitro
        if($queryRetorno->rowCount()){
          //processa a consulta
             
                if($this->opcaoExibicao == "tela") {
                     include_once 'ListaRetorno.php';
                  } elseif($this->opcaoExibicao == "pdf"){
                     echo "<script type='text/javascript'>
                             window.open('relatorio/retornoInteligentePDF.php?uf=$this->uf&mun=$this->municipio&gerente=$this->gerVendas&vendedor=$this->vendedor&status=$this->status&gerenteTele=$this->gerenteTelemarketing&operador=$this->operador&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2&iexm=$_SESSION[empresaId]')
                           </script>";

                  }
         }else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
      }
  }
  function consultaEmpresa() {

         $clausula = "";
         
        if (!empty($this->uf)) {
            $clausula = " AND E.id=$this->uf";
        }
        if (!empty($this->municipio)) {
            $clausula = " AND EM.municipio_codigo=$this->municipio";
        }
             
            //SE  PERIoDO TIVER SIDO PASSADO
        if (!empty($this->periodo1)) {

            $clausula = $clausula ."  AND V.data_cadastro BETWEEN '$this->periodo1' AND '$this->periodo2'";
                //SE DATA NAO FOR VAZIA E PERIODO FOR VAZIO
         } else if (!empty($this->data)) {

            $clausula = $clausula ."  AND V.data_cadastro LIKE'%$this->data%' ";
               
                //SE DATA E PERIODO VAZIO
        }
              
         $sqlEmpresa="SELECT Em.*,E.nome as uf,M.nome as municipio FROM empresa AS EM INNER JOIN municipio AS M ON EM.municipio_codigo=M.id
                      INNER JOIN estado AS E ON E.id=M.estado_uf
                      WHERE EM.ativo=0  $clausula ORDER BY EM.nome";
        //echo $sqlEmpresa;
      
       
         $queryEmpresa= $this->conn->query($sqlEmpresa);
        //se encontra algum regitro
        if($queryEmpresa->rowCount()){
          //processa a consulta
             
                if($this->opcaoExibicao == "tela") {
                     include_once 'ListaEmpresa.php';
                  } elseif($this->opcaoExibicao == "pdf"){
                     echo "<script type='text/javascript'>
                             window.open('relatorio/empresaPDF.php?uf=$this->uf&mun=$this->municipio&data=$this->data&periodo1=$this->periodo1&periodo2=$this->periodo2')
                           </script>";

                  }
         }else {
            echo "<h3 style='color:red;clear:both;'>Nenhum Registro Encontrado!</h3>";
      }
  }

}

$obj = new Relatorio();
 if(!empty($_POST["estado"])){
        $obj->setMunicipio($_POST["estado"]);
   }
   if(!empty($_POST["municipio"])){
         $obj->setMunicipio($_POST["municipio"]);
   }
  if (!empty($_POST['opcaoData'])) {
    $obj->setOpcaoData($_POST['opcaoData']);
  }
      if (!empty($_POST['operador'])) {
                         $obj->setOperador($_POST['operador']);
                     }
       if (!empty($_POST['gerenteTel'])) {
                     $obj->setGerTelemarketing($_POST['gerenteTel']);
                     }
                     if(!empty($_POST['gerenteV'])){
                            $obj->setGerVendas($_POST['gerenteV']);  
                    }
                     if(!empty($_POST['vendedor'])){
                           $obj->setVendedor($_POST['vendedor']);  
                     }  
                     if (!empty($_POST['status'])) {
                            $obj->setStatus($_POST['status'] - 1);
                     }

        $obj->setOpcaoExibicao($_POST['opcaoExibicao']);

            if ($_POST['opcaoExibicao'] == "grafico") {

                  $obj->setTipoGrafico($_POST['opcaoGrafico']);
                }
            if (!empty($_POST['dataDia'])) {

                 $obj->setData($_POST['dataDia']);
            } else if (!empty($_POST['dataMes'])) {

                $obj->setData($_POST['dataMes']);
            } else if (!empty($_POST['dataAno'])) {

                $obj->setData($_POST['dataAno']);
            }
        if (empty($_POST['dataDia']) && empty($_POST['dataMes']) && empty($_POST['dataAno']) && !empty($_POST['periodo1']) && !empty($_POST['periodo2'])) {

                $obj->setPeriodo1($_POST['periodo1']);
                $obj->setPeriodo2($_POST['periodo2']);
        }
       if ($_POST['opcao'] == "cliente") {
             /* if(!empty($_POST["estado"])){
                   $obj->setUF($_POST["estado"]);
               }
               if(!empty($_POST["municipio"])){
                   $obj->setMunicipio($_POST["municipio"]);
               }*/
                $smarty->assign("lista", $obj->consultaCliente());
                $smarty->assign("contador", $obj->getContador());
    
        } elseif ($_POST['opcao'] == "visita") {
    /*
                //se tiver seleciona gerente
                   if($_POST['gerenteV']){
                    $obj->setGerVendas($_POST['gerenteV']);
                    //se tiver selecionado vendedor
                    if($_POST['vendedor']){
                        $obj->setVendedor($_POST['vendedor']);
                    }
                }
                if (!empty($_POST['status'])) {
                    $obj->setStatus($_POST['status'] - 1);
                }
               //  $obj->retornaGerente();
*/
                $smarty->assign("lista", $obj->consultaVisita());
                $smarty->assign("listaGerente", $obj->retornaGerenteVisita());
                $smarty->assign("contador", $obj->getContador());
   
        } elseif ($_POST['opcao'] == "venda") {

              /*  if(!empty($_POST['gerenteV'])){
                   $obj->setGerVendas($_POST['gerenteV']);  
                }
               if(!empty($_POST['vendedor'])){
                   $obj->setVendedor($_POST['vendedor']);  
               }*/  
               if (!empty($_POST['status'])) {
                   $obj->setStatus($_POST['status'] - 1);
               }
               $obj->setTipoGrafico($_POST['opcaoGrafico']);
               $smarty->assign("lista", $obj->consultaVenda());
                $smarty->assign("listaGerente", $obj->retornaGerente());
               $smarty->assign("contador", $obj->getContador());

    
        } elseif ($_POST['opcao'] == "Produto") {
     
            if(!empty($_POST['produto'] ))   
                $obj->setProduto($_POST['produto']);
                $smarty->assign("lista", $obj->consultaProduto());
                $smarty->assign("contador", $obj->getContador());

        
        } elseif ($_POST['opcao'] == "acompanhamento") {

   
          /*  if (!empty($_POST['operador'])) {
                $obj->setOperador($_POST['operador']);
            }
            if (!empty($_POST['gerenteTel'])) {
                $obj->setGerTelemarketing($_POST['gerenteTel']);
            }*/
            $obj->consultaAcompanhamento();


    
        } elseif ($_POST['opcao'] == "agendamento") {

           /* if (!empty($_POST['gerenteTel'])) {
                $obj->setGerTelemarketing($_POST['gerenteTel']);
            }
            if (!empty($_POST['operador'])) {
                $obj->setOperador($_POST['operador']);
            }*/

            $smarty->assign("lista", $obj->consultaAgendamento());
            $smarty->assign("contador", $obj->getContador());

    
        } elseif ($_POST['opcao'] == "funcionario") {

            if (!empty($_POST["cargo"])) {
                $obj->consultaFuncionario($_POST["cargo"]);

             }

        }elseif ($_POST['opcao'] == "Pendencia"){
            /*if (!empty($_POST['operador'])) {
                $obj->setOperador($_POST['operador']);
            }
            if (!empty($_POST['gerenteTel'])) {
                $obj->setGerTelemarketing($_POST['gerenteTel']);
            }*/
            $obj->setPendentes($_POST["pendente"]);   
            $obj->consultaPendencia(); 
         
      }elseif ($_POST['opcao'] == "Empresa"){
          
          /*  if(!empty($_POST["estado"])){
                  $obj->setUF($_POST["estado"]);
              }
             if(!empty($_POST["municipio"])){
                   $obj->setMunicipio($_POST["municipio"]);
             }*/
            $obj->consultaEmpresa();   
            
     }elseif ($_POST['opcao'] == "comissao"){
         
         $obj->consultaComissao();
         
         
     }elseif ($_POST['opcao'] == "retorno"){
            if(!empty($_POST["estado"]) || !empty($_POST["municipio"])|| !empty($_POST['operador']) || !empty($_POST['gerenteTel']) || !empty($_POST['gerenteV']) || !empty($_POST['vendedor']) || !empty($_POST['status'])){
                  /*  if(!empty($_POST["estado"])){
                            $obj->setMunicipio($_POST["estado"]);
                     }
                     if(!empty($_POST["municipio"])){
                            $obj->setMunicipio($_POST["municipio"]);
                     }
                     if (!empty($_POST['operador'])) {
                         $obj->setOperador($_POST['operador']);
                     }
                     if (!empty($_POST['gerenteTel'])) {
                         $obj->setGerTelemarketing($_POST['gerenteTel']);
                     }
                     if(!empty($_POST['gerenteV'])){
                            $obj->setGerVendas($_POST['gerenteV']);  
                    }
                     if(!empty($_POST['vendedor'])){
                           $obj->setVendedor($_POST['vendedor']);  
                     }  
                     if (!empty($_POST['status'])) {
                            $obj->setStatus($_POST['status'] - 1);
                     }*/
                      $obj->consultaRetornoInteligente() ;
            }else{
                echo "<h3 style=color:red>Atenção:<br/> Selecione pelos menos 1 das opções, acima</h3>";
            }        
        }
        
?>

