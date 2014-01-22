<script type="text/javascript" src="../js/func.js"></script>
<?php
include_once("../conexao/conexao.class.php");

class LembraOperador{
	private $conn;
	
	function __construct() {
		$this -> conn = new connection;
	}
	function agendadosOperador(){
		echo $data=date("Y-m-d");
		echo "<br/>".$hora=date("H:i:s");
		echo "<br/>SELECT * FROM agendaoperador WHERE dataAdiamento='$data' AND horaAdiamento='$hora'<br/>";
		$lembra = $this->conn->query("SELECT * FROM agendaoperador WHERE dataAdiamento='$data' AND horaAdiamento='$hora'");
		if(	$lembra->rowCount()){
			$l=$lembra->fetch(PDO::FETCH_OBJ);
			
				echo "<script type='text/javascript'>
							
						 alert('acompanha agendados!')
						 
						</script>";
				
		}else{
			echo "sem alerta";
		}
	}
}
$obj=new LembraOperador();
$obj->agendadosOperador();

?>