<?php
    //funcao retorna data no padra mysql
    function formata_data_db($data){
		list($dia,$mes,$ano)	= explode("/",$data);
		return $ano."-".$mes."-".$dia;
	}
 function formata_data($data){
		list($ano,$mes,$dia)	= explode("-",$data);
		return $dia."/".$mes."/".$ano;
	}
?>
