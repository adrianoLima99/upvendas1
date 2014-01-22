<script type="text/javascript" src="../js/func.js">
	
	
</script>

<?php
include_once "../conexao.class.php";
class Lembrete{
	private $conn;

	function __construct() {
		$this -> conn = new connection();
	}
	
	function lembrete(){
		echo "<br/>".$hora=date("H");
		$hoje=date("Y-m-d");
		echo "SELECT *  FROM agendaoperador WHERE horaAdiamento LIKE '$hora%' AND dataAdiamento ='$hoje'";
		$sql=$this->conn->query("SELECT *  FROM agendaoperador WHERE horaAdiamento LIKE '$hora%' AND dataAdiamento ='$hoje'");
		if(	$sql->rowCount()){
			$var="<script type='text/javascript'>
						mensagem()
					</script>";
					
			echo $var;
		}
		
		
	}	
}
$obj=new Lembrete();
$obj->lembrete();
