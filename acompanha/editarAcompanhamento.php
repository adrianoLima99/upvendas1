<?php
class EditarAcompanhamento{
    private $conn;
   
    public function __construct()
    {
     $this->conn = new connection;

    }
    public function listaAcompanhamento($id){
        $selAcompanhamento=  $this->conn->query("SELECT distinct A.id AS id_acom,A.data,A.statusOcorrencia,A.ocorrencia_id,A.obs,A.resposta_id,C.id as cliente_id,C.nome AS cliente,C.sexo,C.data_nascimento,
                                                 C.logradouro,C.tipo_documento,C.numero_documento,C.email,C.bairro,C.fone1,C.fone2,C.municipio_codigo,V.id AS idVisita,V.gerente_vendas_id,V.vendedor_id,
                                                 V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.status,M.id as idMunc,M.nome as municipio,E.id as idUF,E.nome as estado 
                                                 FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                 INNER JOIN funcionario AS F ON F.id=V.operador_id 
                                                 INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                 INNER JOIN municipio AS M ON C.municipio_codigo=M.id
                                                 INNER JOIN estado AS E ON E.id=M.estado_uf
                                                 INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                 INNER JOIN produto AS P ON P.id=VP.produto_id
                                                 WHERE A.id=$id");
       $r=$selAcompanhamento->fetch(PDO::FETCH_OBJ);
     
?> 
<div id='formularios'>
      <br/><br/>
            <fieldset>
		<legend>Edi&ccedil;&atilde;o de Acompanhamento</legend>
                    <form method='post' action='?pg=salvarEdicaoAcompanhamento'>
			<table>
                            <tr>
				<td>Id Acompanhamento:</td>
				<td><input type='text' name='id' value='<?php echo $id;?>' readonly/></td>
                            </tr>
                            <tr>
                              <td><input type='hidden' name='visita' value='<?php echo $r->idVisita;?>' readonly/></td>
                            </tr>
                            <tr>
                                <td>Cliente:</td>
				<td><input type='text' name='cliente' value='<?php echo $r->cliente;?>' />
                                    <input type='hidden' name='cliente_id' value='<?php echo $r->cliente_id;?>' />
                                </td>
                            </tr>
                            <tr>
                                <td>Sexo:</td>
				<td><select name='sexo'>
                                        <option><?php echo $r->sexo;?></option>
                                        <option>M</option>
                                        <option>F</option>
                                    </select>
                                </td>
                            </tr>
                           
                            <tr>
                                <td>(CPF/CNPJ):</td>
				<td><input type='text' name='numero_documento' value='<?php echo $r->numero_documento;?>'/></td>
                            </tr>
                            <tr>
                                <td>Data Nascimento :</td>
				<td><input type='text' name='nascimento' value='<?php echo $r->data_nascimento;?>' class='data'/></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
				<td><input type='text' name='email' value='<?php echo $r->email;?>' /></td>
                            </tr>
                            <tr>
                                <td>Fone 1:</td>
				<td><input type='text' name='fone1' value='<?php echo $r->fone1;?>' /></td>
                            </tr>
                             <tr>
                                <td>Fone2:</td>
				<td><input type='text' name='fone2' value='<?php echo $r->fone2;?>' /></td>
                            </tr>
                             <tr>
                                <td>Endereço:</td>
				<td><input type='text' name='logradouro' value='<?php echo $r->logradouro;?>' /></td>
                            </tr>
                            <tr>
                                <td>UF:</td>
                                <td><select name='uf' id='uf' onchange='listaCidades()' >
                                      <option value='<?php echo $r->idUF;?>'><?php echo $r->estado;?></option>
                                       <?php
                                            $estado=  $this->conn->query("SELECT id,nome FROM estado WHERE id<>$r->idUF");
                                            while($rUF=$estado->fetch(PDO::FETCH_OBJ)){
                                            echo "<option value='$rUF->id'>$rUF->nome</option>";
                                            }
                                        ?>
                                      </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Municipio:</td>
                                <td><select name='municipio' id='municipio'>
                                      <option value='<?php echo $r->idMunc;?>'><?php echo $r->municipio;?></option>
                                     </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Bairro:</td>
                                <td><input type='text' name='bairro' value='<?php echo $r->bairro?>'/></td>
                            </tr>
                            <tr>
                            <?php if($_SESSION["tipo"]!= 5){ ?>
                                <td>Operador de Telemarketing:</td>
                                 <td><select name='operador'>
                                        <option value="<?php echo $r->idFunc;?>"><?php echo  $r->nome;?></option>
                                        <?php 
                                            $listOperador=$this->conn->query("SELECT id ,nome FROM funcionario  WHERE perfil=5 AND ativo=0 AND id<>$r->idFunc AND empresa_id=$_SESSION[empresaId]");
                                            while($rowoperador=$listOperador->fetch(PDO::FETCH_OBJ)){
                                                echo "<option value='$rowoperador->id'>$rowoperador->nome</option>";
                                            }
                                        ?> 
                                       </select> </td>   
                             <?php }else{?>
                                         <td>Operador de Telemarketing:</td>
					 <td><input type='hidden' name='operador' value='<?php echo $_SESSION["func_id"];?>' /></td>
                             <?php }?>       
			</tr>
                        <tr>
                            <td>Resposta Automatica</td>
                            <td>
                                <?php if($r->resposta_id!=0){
                                        
                                        $listaResposta=$this->conn->query("SELECT id,resposta FROM respostaautomatica WHERE id=$r->resposta_id");
                                         $exibirResposta=$listaResposta->fetch(PDO::FETCH_OBJ);
                                          $resposta_nome=$exibirResposta->resposta;
                                          $resposta_id=$exibirResposta->id;
                                    }else{
                                        $resposta_id="";
                                        $resposta_nome="";
                                    }
                                ?>
                                <select name="resposta">
                                    <option value="<?php echo $resposta_id;?>"><?php echo $resposta_nome;?></option>
                                    <?php
                                        $listaResposta=$this->conn->query("SELECT R.id,R.resposta FROM respostaautomatica AS R INNER JOIN funcionario AS F ON R.usuario_cadastro=F.id 
                                                                            WHERE R.ativo=0 AND F.empresa_id=$_SESSION[empresaId]");
                                        while($exibirResposta=$listaResposta->fetch(PDO::FETCH_OBJ)){
                                            echo "<option value='$exibirResposta->id'>$exibirResposta->resposta</option>";
                                        }
                                    ?>
                                </select> 
                                
                            </td>
                        </tr>
			<tr>
                            <td>Obs:</td>
                            <td><textarea name='obs' cols="33" rows="10"><?php echo $r->obs?></textarea></td>
                        </tr>
                        </table>  
                      </fieldset>   
                      <fieldset>
                      <legend>Registrar Ocorr&ecirc;ncia</legend>
                        <table>
                             <tr>
                                <td>Ocorr&ecirc;ncia</td>
                               <td><select name='ocorrencia'>
                                    <option value=''>Selecione uma Ocorr&ecirc;ncia </option>
                                    <?php
                                        $oc = $this->conn->query("SELECT id,nome FROM ocorrencia WHERE ativo=0 AND aprovado=0 AND empresa_id=$_SESSION[empresaId]");
                                         while ($l = $oc->fetch(PDO::FETCH_OBJ)) {
                                             echo "<option value='$l->id'>$l->id-$l->nome</option>";
                                        }
                                   ?>     
             		
             			</select></td>
                            </tr>  
                        </table>
                      </fieldset>
                     <fieldset>
                      <legend>Acompanhar Depois?</legend>
                        <table>
                        <tr>
                           <td>Data Adiamento:</td> 
                           <td><input type='text' name='dataAdiamento' class='data'  id='dataAdiamento' /></td>
                        </tr>
                         <tr>
                            <td>Hora Adiamento:</td>
                             <td><input type='text' name='horaAdiamento' onkeypress='return valHora(event,this);return false;'  maxlength='8'  id='horaAdiamento' /></td>
                        </tr>
                    </table>
                  </fieldset>
                <fieldset>
                 <legend>Agendar Visita?</legend>
                    <table>
                       <tr>
                         <td>Data Visita:</td><td><input type='text' name='dataAgendamento'class='data'  /> </td>               
                      </tr>
                      <tr>
                        <td>Horario:</td><td><input type='text' name='horaAgendamento' onkeypress='return valHora(event,this);return false;'  maxlength='8' /></td>
                             
                    </tr>
                 </table>
            </fieldset>
            	<tr>
                            <td></td><td><input type='submit' name='enviar' value='salvar' class='botao'/></td>
			</tr>
            </table>
	</form>
</fieldset>
             <a href='?pg=acompanha' style='align:center'><img src='imagens/voltar.gif' title="voltar"/></a>                                            
	</div>
 <?php
        }
      public function salvarEdicao($id,$visita,$resposta,$ocorrencia,$obs,$dataAdiamento,$horaAdiamento,$dataAgendamento,$horaAgendamento,$cliente_id,$cliente,$sexo,$nascimento,$logradouro,$email,$numero_documento,$fone1,$fone2,$bairro,$municipio){
          $data=date("Y-m-d");
          $hora=date("H:m:s");
          
          if(!empty($resposta)){
              $resposta=$resposta; 
          }else{
              $resposta=0;
          }
          if(!empty($ocorrencia)){
              
              $statusOcorrencia=1;
          }else{
              $ocorrencia=0;
               $statusOcorrencia=0;
          }
         if(!empty($nascimento)){
             $nascimento=  formata_data_db($nascimento);
         }else{
             $nascimento=$nascimento;
         } 
         
         try{
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
            $this->conn->query("INSERT INTO acompanhamento(data,hora,obs,visita_id,statusOcorrencia,ocorrencia_id,resposta_id,usuario_cadastro) 
                                        VALUES('$data','$hora','$obs',$visita,$statusOcorrencia,$ocorrencia,$resposta,$_SESSION[func_id])");
            if(!empty($dataAgendamento)){
              $dataAgendamento=  formata_data_db($dataAgendamento);
                $this->conn->exec("INSERT INTO agendamento_visita(data,hora,acompanhamento_id,ocorrencia_id,statusOcorrencia,ativo) VALUES('$dataAgendamento','$horaAgendamento',$id,$ocorrencia,$statusOcorrencia,0)");
            }
            if(!empty($dataAdiamento)){
               $dataAdiamento=  formata_data_db($dataAdiamento);
                $this->conn->exec("INSERT INTO agendamento_operador(data,hora,ativo,acompanhado,acompanhamento_id) VALUES('$dataAdiamento','$horaAdiamento',0,$id,$ocorrencia,$statusOcorrencia)");
            }
            
            $this->conn->exec("UPDATE cliente SET nome='$cliente',email='$email',data_nascimento='$nascimento',logradouro='$logradouro',sexo='$sexo',municipio_codigo=$municipio,bairro='$bairro',numero_documento='$numero_documento',fone1='$fone1',
                               fone2='$fone2',bairro='$bairro' WHERE id=$cliente_id ");
            
            $this->conn->commit();
            
            echo "<script type='text/javascript'>alert('Atualização feita com sucesso')
                  location.href='?pg=acompanha';
                 </script>";
            
          }catch (Exception $e){
              echo "deu erro";
          $this->conn->rollBack();
        }
      }
      
    }   
?>