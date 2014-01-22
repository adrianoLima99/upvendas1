<?php


 class Upload{

function __construct() {
        $this->conn = new connection;
}
function removeCaracter($caracter) {

			$titulo = preg_replace("[çÇ]", "C",$caracter);
			//Substituindo caracteres especiais pela letra respectiva
			$titulo = preg_replace("[áÁäÄàÀãÃâÂ]", "A", $caracter);
			$titulo = preg_replace("[éÉëËèÈêÊ]", "E", $caracter);
			$titulo = preg_replace("[íÍïÏìÌîÎ]", "I", $caracter);
			$titulo = preg_replace("[óÓöÖòÒõÕôÔ]", "O", $caracter);
			$titulo = preg_replace("[úÚüÜùÙûÛ]", "U", $caracter);
			$titulo = preg_replace('""','', $caracter);

			//return $caracter;
                        return $titulo;
	
	}

	function recebeArquivo(){
	
		
		
	  $arquivo = $_FILES['cartaCliente']['tmp_name'];			
		 $lines= file($arquivo);
		
		$cont=0;
		
	
		
			// Percorre o array, mostrando o fonte HTML com numera��o de linhas.
			foreach ($lines as $line_num => $line) {
			
			//$html = explode(',', $line);
				if($_POST['convertido']==1){
				$caracter=";";
				}else{
			 	$caracter=",";
				}
			
				$html = explode("$caracter", $line);
				
			//tipo pessoa
				if(is_string($html[0])){
					$pessoa = $html[0];		
				}
			//nome		
				if(is_string($html[1])){
					$nome = $this->removeCaracter( $html[1]);
				}
                        //razao
                                if(is_string($html[2])){
					$razao = $this->removeCaracter( $html[2]);
				}
                         //numero documento
                                if(is_string($html[3])){
					$numDocumento = $this->removeCaracter( $html[3]);
				}
			//sexo	
				if(is_string($html[4])){
					$sexo=	$html[4] ;
				}
                        //email
                       /*         if(is_string($html[5])){
					$email = $this->removeCaracter( $html[5]);
				}*/
                         //fone
                                if(is_string($html[5])){
					$fone = $this->removeCaracter( $html[5]);
				}    
                        //endereco        
				if(is_string($html[6])){
					$endereco = $this->removeCaracter($html[6]);		
				}
                        //bairro        
				if(is_string($html[7])){
					$bairro = $this->removeCaracter($html[7]);
				}
                       //municipio       
				
						$municipio = $html[8];		
				
						
				
						
				
			$data_insercao = date('Y-m-d');
			$hora_insercao = date('H:i:s');
        		$sql =$this->conn->query("INSERT INTO cliente(tipo_pessoa,nome,razao_social,numero_documento,sexo,fone1,logradouro,bairro,municipio_codigo,data_cadastro,hora_cadastro,usuario_cadastro,empresa_id) 
                                                 VALUES('$pessoa','$nome','$razao','$numDocumento','$sexo','$fone','$endereco','$bairro',$municipio,'$data_insercao','$hora_insercao',$_SESSION[id],$_SESSION[empresaId])")or
                                            die("<div style='color:red;text-align=center;position:relative;left:500px;width:400px;height:200px;'>
                                                        <fieldset>
                                                            <legend>Atenção</legend>
                                                                <p>Ocorreu 1 erro verifique as seguintes possibilidades:</p>
                                                                <p>1º Se a sequencia de inserção foi seguida </p>
                                                                <p>2º O forma foi definito correntamente, se tiver utilizado o excel escolha a opção excel ,se não,escolha outra opção </p>
                                                        <a href='?pg=uploadCliente'>Voltar</a>    
                                                        </fieldset>    
                                                    </div>");

				if($sql){
					$cont+=1;
				}
		            


		}
		echo "<h2>Total de registros inseridos:$cont</h2><a href='?pg=uploadCliente'>Voltar</a>";
	

  }
 }

$obj = new Upload();
$obj->recebeArquivo();
 
?>
