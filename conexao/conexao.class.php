<?php
class Connection extends PDO
{
       
public function __construct(){
 try{
       //parent::__construct('mysql:host=mysql01.wslservicos.hospedagemdesites.ws;port=3306;dbname=wslservicos','wslservicos','Ws1311');
        parent::__construct('mysql:host=localhost;port=3306;dbname=upvendas','root','upgrade2013Solucoes');
    }catch(PDOException $e)
	{
        echo 'Error: '.$e->getMessage();
    }
    						}
}



?>