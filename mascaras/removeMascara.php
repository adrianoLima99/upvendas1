<?php
 function removeCpf($cpf){
 	
 	$v1 = explode(".", $cpf);
                $v2 = implode("", $v1);
                $v3 = explode("-", $v2);
                $vf = implode("", $v3); 
	return $vf;			
 
 }
 function removeCnpj($cnpj){
 	  				
 	  			$v1 = explode(".", $cnpj);
                $v2 = implode("", $v1);
                $v3 = explode("-", $v2);
                $v4 = implode("", $v3);
                $v5 = explode("/", $v4);
                $vf = implode("", $v5);
  return $vf;					
 }
function removeMascaraNum($num){
	//$v1=explode(".", $num);
        //$v=$v1[0].$v1[1].".".$v1[2];
        
        $number = str_replace(',','.',str_replace('.','',$num));
return $number;
	
}
function removeMascaraTel($telefone){
    $vc1 = explode("(", $telefone);
    $vc2 = implode("", $vc1);
    $vc3 = explode(")", $vc2);
    $vc4 = implode("", $vc3);
    $vc5 = explode("-", $vc4);
    $vcf = implode("", $vc5);
    return $vcf;
}


?>