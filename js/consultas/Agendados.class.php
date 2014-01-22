<?php
class Agendados{
	private $conn;
    
 function __construct() {
        $this->conn = new connection;
    }
 
 
 function verifica(){
 	$linha=$this->conn->query("SELECT * FROM agendaOperador WHERE ");
	

 }
 
 
}
?>