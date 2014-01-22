<?php

class SalvarPlano {

    private $plano;
    private $meses;
    private $conn;
   

    function __construct() {
        $this->conn = new connection;
    }

    function setPlano($plano) {

        $this->plano = $plano;

   }
   function setMes($meses) {

        $this->meses = $meses;

   }
   function getPlano(){
       return $this->plano;
   }
   function getMeses(){
       return $this->meses;
   } 
   function salvePlano() {
        $nome=$this->getPlano();
        $qtdMes=$this->getMeses();
        $hora=date("H:m:i");
        $data=date("Y-m-d");
       
        $sql = $this->conn->exec("INSERT INTO plano(nome,meses,usuario_cadastro,empresa_id,data_cadastro,hora_cadastro,ativo) VALUES('$nome','$qtdMes',$_SESSION[func_id],$_SESSION[empresaId],'$data','".$hora."',0)") or die("erro sql");
        if($sql){
            $this->conn=NULL;
            echo "<script type='text/javascript'>
                               alert('Plano cadastrado com sucesso')
                                 location.href='?pg=listaPlano'
                             </script>";
        }
    }

}


?>