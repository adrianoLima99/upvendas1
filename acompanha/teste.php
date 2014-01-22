<?php
function removeMascaraNum($num){
	$v1=explode(".", $num);
	$vf=implode("",$num);
return $vf;
	
}
echo removeMascaraNum(200.00);

?>