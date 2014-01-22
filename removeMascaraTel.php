<?php
function removeMascaraTel($tel){
	
                $v1 = explode("(",$tel);

                $v2 = implode("",$v1);
                $v3 = explode(")",$v2);
                $v4 = implode("",$v3);
                $v5 = explode("-",$v4);
                $vf = implode("",$v5);
                
           return $vf;     
}

?>