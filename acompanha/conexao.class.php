<?php
class Connection extends PDO
{
       
public function __construct(){
 try{
       //parent::__construct('mysql:host=mysql01.wslservicos.hospedagemdesites.ws;port=3306;dbname=wslservicos','wslservicos','Ws1311');
        parent::__construct('mysql:host=186.202.152.20;port=3306;dbname=clientesupgrade_upgrade','clien_upvendas','upgrade');
    }catch(PDOException $e)
	{
        echo 'Error: '.$e->getMessage();
    }
    						}
}



?>