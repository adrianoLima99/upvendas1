<?php

class InserirOcorrenciaAcompanhamento {

    private $tabela;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function lista($tabela) {
        $this->tabela = $tabela;
        echo "	<div id='formularios'>
                    <fieldset>
                     <legend>Adicionar  ocorr&ecirc;ncia $this->tabela</legend>
                        <table>
                            <form method='post' action='#'>
				<tr>
                                    <td>Codigo $this->tabela</td>
                                    <td><input type='text' name=id value='$_GET[id]' readonly></td>
				</tr>
				<tr>	
                                    <td> Ocorr&ecirc;ncia </td>
                                    <td><select name='ocorrencia' required> 
                                        <option value='' >Seleciona uma ocorr&ecirc;ncia </option>";
                                          $sql = $this->conn->query("SELECT id,nome FROM ocorrencia WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND aprovado<>-1");
                                           if($sql->rowCount()){
                                           while ($l = $sql->fetch(PDO::FETCH_OBJ)) {
                                           echo "<option value='$l->id'>$l->id-$l->nome</option>";
                                            }
                                           }
                                    echo "</select></td>	
				</tr>	
				<tr>
                                    <td></td><td><input type='submit' name='enviar' value='Adicionar' class='botao'/></td>
				</tr>
			</form>
            	</table>	
	</fieldset>
        <a href='?pg=visitados'>Voltar</a>
     </div>";
        if (isset($_POST['enviar'])) {
            $this->setOcorrencia($_POST['id'], $_POST['ocorrencia'], $this->tabela);
        }
        
        
    }

    function setOcorrencia($id, $ocorrencia, $tabela) {

        $data_insercao = date('Y-m-d');
        $hora_insercao = date('H:i:s');
       
        $exc = $this->conn->query("UPDATE $tabela SET statusOcorrencia=1 ,ocorrencia_id=$ocorrencia  WHERE ativo=0  AND id=$id  ");
       

        if ($exc) {

            $this->conn->exec("INSERT INTO ocorrencia_realizada(tabela,tabela_id,ocorrencia_id,data,hora,usuario_cadastro) 
							VALUES('$tabela',$id,$ocorrencia,'$data_insercao','$hora_insercao',$_SESSION[id]) ");
        
            
            if($tabela=="visita"){
                echo "<script type='text/javascript'>
     				alert('ocorrencia inserida com sucesso');
      				  location.href='?pg=visitados';
                        </script>";
            }elseif($tabela=="agendamento_visita"){
                echo "<script type='text/javascript'>
     				 alert('ocorrencia inserida com sucesso');
      				  location.href='?pg=agendamento';
                        </script>";
                
            }elseif($tabela=="acompanhamento"){
                echo "<script type='text/javascript'>
     				 alert('ocorrencia inserida com sucesso');
      				  location.href='?pg=acompanhamento';
                        </script>";
                
            }
            
            
        }
    }

}
