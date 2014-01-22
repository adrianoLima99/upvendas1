<?php
include_once ("../conexao/conexao.class.php");
class Perfil {
	private $tabela;
	private $cargo;
	private $empresa;
	private $conn;
	function __construct() {
		$this -> conn = new connection();
	}

	function tabelas($cargo,$empresa) {
		
/*	if(!empty($empresa)){
		if($this->cargo!="administrador"){
			$cond="AND cliente_sistema=$empresa";
		}else{
			$cond=" AND  id=$empresa";	
		}
		
	}*/
                
		switch($cargo) {
			
                   
                   case "2" :
    			$nmcargo= "Administrador Master";
			break;
                    case  "3" :
			$nmcargo = "Administrador";
			break;
                    case "4" :
			$nmcargo= "Administrador";
			break;
                    case "5" :
			$nmcargo = "Gerente de Telemarketing";
			break;
                     case "6" :
			$nmcargo = "Gerente de Vendas";
			break;
            }
                                
		if ($cargo >2) {

                                $selCargo=$this->conn->query("SELECT id FROM cargo WHERE  nome='$nmcargo'");
                                $resultaCargo=  $selCargo->fetch(PDO::FETCH_OBJ);
					$consulta = $this -> conn -> query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND cargo_id=$resultaCargo->id AND empresa_id=$empresa  AND perfil>1");

                                        while ($l = $consulta -> fetch(PDO::FETCH_OBJ)) {
                        				echo "<option value='$l->id'>$l->nome($nmcargo)</option>";
						}
                                             
		}elseif($cargo==2){
                      $selCargo=$this->conn->query("SELECT id FROM cargo WHERE  nome='$nmcargo'");
                                $resultaCargo=  $selCargo->fetch(PDO::FETCH_OBJ);
					$consulta = $this -> conn -> query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND cargo_id=$resultaCargo->id AND empresa_id=$empresa  AND perfil=1");

                                        while ($l = $consulta -> fetch(PDO::FETCH_OBJ)) {
                        				echo "<option value='$l->id'>$l->nome($nmcargo)</option>";
						}
                }else{   
				$consulta = $this -> conn -> query("SELECT id,nome  FROM funcionario WHERE ativo=0 AND perfil=0 ");
				$l = $consulta -> fetch(PDO::FETCH_OBJ);
				echo "<option value='$l->id'>$l->nome(Super)</option>";
               }
            $this->conn=null;   
	}
        
}

$obj = new Perfil();
$obj -> tabelas($_GET["perfil"],$_GET["empresa"]);
?>
