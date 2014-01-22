<?php

//include_once("../conexao/conexao.class.php");
class AssociacaoAutomatica {

    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function Associar() {
        $z = 0;
        $j = 1;

        echo "<br/><br/><h3>Associação feita com sucesso,<br/><a href='javascript:history.go(-1)'>Voltar</a></h3>";
        $sqlV = $this->conn->query("SELECT V.id FROM visita AS V INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id 
                                  WHERE V.acompanhado=0 AND V.ativo=0 AND V.operador_id=0 AND F.empresa_id=$_SESSION[empresaId]
                                  ");

        $contaVisita = $sqlV->rowCount();
        $sqlOperador = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND perfil=5 AND empresa_id=$_SESSION[empresaId]");

        $contaOperador = $sqlOperador->rowCount();
        
        if ($sqlOperador->rowCount()) {
              $x = $contaVisita % $contaOperador;
              $div = ($contaVisita - $x) / $contaOperador;
           
            for ($i = $contaOperador; $i > 0; $i--) {
                $j=$i-1;
                           
               
               //seleciona operadores
               $Operador = $this->conn->query("SELECT id FROM funcionario WHERE ativo=0 AND perfil=5 AND empresa_id=$_SESSION[empresaId]  LIMIT 1 OFFSET $j") or die("erro operador");
                $r = $Operador->fetch(PDO::FETCH_OBJ);
                  $this->conn->exec("UPDATE visita SET operador_id=$r->id WHERE operador_id=0 AND empresa_id=$_SESSION[empresaId] LIMIT $div ") ;
               
             }
              if ($x != 0) {
                  $sqlR = $this->conn->query("SELECT id FROM  funcionario where ativo=0 AND perfil=5 AND empresa_id=$_SESSION[empresaId] AND RAND() LIMIT 1 ");
                 $l = $sqlR->fetch(PDO::FETCH_OBJ);
                  $this->conn->exec("UPDATE visita SET operador_id=$l->id  WHERE ativo=0 AND operador_id=0 AND empresa_id=$_SESSION[empresaId] AND gerente_vendas_id IN(
                                    SELECT id FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId])");
              }
         } else {
             //se nao existe operador
               while ($l = $sqlV->fetch(PDO::FETCH_OBJ)) {
                $this->conn->exec("UPDATE visita SET operador_id=$l->vendedor_id  WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND vendedor_id=$l->vendedor_id AND operador_id=0 AND gerente_vendas_id IN(
                                    SELECT  id FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId])");
            }
        }
    }
    public function associacaoManual($gerente,$vendedor,$status,$telefonia,$operador){
        $condicao="";
        $cond="";
        if(!empty($gerente)){
            $condicao=$condicao." AND gerente_vendas_id=$gerente";
        }
        if(!empty($vendedor)){
            $condicao=$condicao." AND vendedor_id=$vendedor";
        }
        if(!empty($status)){
            $condicao=$condicao." AND id IN(SELECT visita_id FROM visita_produto WHERE status=$status)";
        }
        if(!empty($telefonia)){
               $condicao=$condicao." AND cliente_id IN(SELECT id FROM cliente WHERE telefonia=$telefonia)";
        }
        
        if($_SESSION["tipo"]==0){
            $cond=$cond." AND empresa_id=$_SESSION[empresaId]";
        }else{
            $cond="";
        }
        try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
           
            $associacao= $this->conn->exec("UPDATE visita SET operador_id=$operador WHERE ativo=0 AND acompanhado=0 AND operador_id=0 $condicao $cond");
            $this->conn->commit();
            if($associacao){
                echo "<script type='text/javascript'>alert('Associação feita com sucesso')
                          location.href='?pg=tele';
                     </script>";
            }else{
                echo "<h3>Nenhum registro encontrado que satisfaz a sua seleção!
                        <br/><a href='?pg=tele'>Voltar</a></h3>
                        ";
            }
        }catch (Exception $e){
            echo "<h3>Ocorreu 1 erro, por favor, entre em contato com o administrador!</h3>"; 
            $this->conn->rollBack();
             
        }
    }

}


?>
