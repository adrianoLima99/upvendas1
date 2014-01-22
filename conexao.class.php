<?php
class Connection extends PDO
{
       
public function __construct(){
 try{
     
      // parent::__construct('mysql:host=localhost;port=3306;dbname=wslservicos','root','');
    parent::__construct('mysql:host=mysql01.upvendasbrasil.hospedagemdesites.ws;port=3306;dbname=upvendasbrasil','upvendasbrasil','adriano');
    }catch(PDOException $e)
	{
        echo 'Error: '.$e->getMessage();
    }
    						}
}



?>