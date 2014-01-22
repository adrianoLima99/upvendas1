  
<?php

class salvarVisita {

    private $id;
    private $id_cliente;
    private $status;
    private $prospectado;
    private $obs;
    private $produto;
    private $plano;
    private $qtd;
    private $vendedor;
    private $vendido;
    private $dataVenda;
    private $gerente;
    private $tipoClienteSistema;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function VisualizaCadastro() {

        //$this->id=cpf
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $consulta = $this->conn->query("SELECT C.nome,C.numero_documento,C.tipo_pessoa,C.bairro,C.id,C.fone1,C.fone2,C.logradouro,C.data_nascimento,M.nome AS municipio,E.nome AS estado 
                                                            FROM cliente AS C INNER JOIN municipio AS M ON C.municipio_codigo=M.id INNER JOIN estado AS E ON M.estado_uf=E.id
                                                            where C.id=$id AND  C.ativo=0 ");
        } elseif (isset($_GET['telefone']) && isset($_GET['nome'])) {

            $consulta = $this->conn->query("SELECT C.nome,C.numero_documento,C.tipo_pessoa,C.bairro,C.id,C.fone1,C.fone2,C.logradouro,C.data_nascimento,M.nome AS municipio,E.nome AS estado 
                                                            FROM cliente AS C INNER JOIN municipio AS M ON C.municipio_codigo=M.id INNER JOIN estado AS E ON M.estado_uf=E.id
                                                            WHERE (C.fone1='$_GET[telefone]' || C.fone2='$_GET[telefone]') && C.nome='$_GET[nome]' AND  C.ativo=0 ");
        } elseif (isset($_GET['cpf_Cnpj']) && isset($_GET['pessoa'])) {
            $consulta = $this->conn->query("SELECT C.nome,C.numero_documento,C.tipo_pessoa,C.bairro,C.id,C.fone1,C.fone2,C.logradouro,C.data_nascimento,M.nome AS municipio,E.nome AS estado 
                                                            FROM cliente AS C INNER JOIN municipio AS M ON C.municipio_codigo=M.id INNER JOIN estado AS E ON M.estado_uf=E.id
                                                             WHERE C.numero_documento='$_GET[cpf_Cnpj]' && C.tipo_pessoa='$_GET[pessoa]' AND  C.ativo=0 ");
        }

        $l = $consulta->fetch(PDO::FETCH_OBJ);

        echo "<div id='formularios'> 	
           <fieldset>
             <legend>Dados Cliente</legend>
              <form method='post' action='#'>    
                <table>
                   <tr>
                      <td>Nome:</td>
                      <td><input type='text' name='nome'  value='$l->nome' readonly/></td>
                      <td><input type='hidden' name='id_cliente'  value='$l->id' /></td>    
                    </tr>
                    <tr>
		       <td>Cpf/Cnpj:</td><td><input type='cpf' name='cpf_Cnpj'  value='$l->numero_documento' readonly/></td>
                    </tr>";
        if (isset($_GET["pessoa"]) && $_GET["pessoa"] == "f") {
            echo " <tr>     
		        <td>Nascimento:	</td>
                        <td><input type='text' name='nasc'  value='" . formata_data($l->data_nascimento) . "' readonly/></td>
		    </tr>";
        }
        echo "    <tr>
                        <td> Endereco </td>
                        <td> <input type='text' name='end'  value='$l->logradouro' readonly/></td>
                     </tr>
                     <tr>
                        <td>Bairro</td>
		         <td><input type='text' name='bairro'  value='$l->bairro' readonly/></td>
                     </tr>
                     
		     <tr>
		         <td>UF:</td>
			 <td><input type='text' name='uf'  value='$l->estado' readonly/></td>
                     </tr>
                     <tr>
                	 <td>cidade</td>
		         <td><input type='text' name='cid'  value='$l->municipio' readonly/></td>
                     </tr>
                     <tr>
			 <td>Telefone Fixo:</td>
			 <td><input type='text' name='fixo'  value='".formatar($l->fone1,'fone')."' readonly/></td>
		      </tr>
                      <tr>
                	 <td>Celular 1</td>
			 <td><input type='text' name='cel1'  value='".formatar($l->fone2,'fone')."' readonly/></td>
                       </tr>
                       
                  </table>
                </fieldset>
                <fieldset>
                     <legend>Dados Visita</legend>
                        <table>
                          <th>Campos Obrigatorios(<span style='color:red;'>*</span>)</th>
                           <tr>
                             <td>Data da visita</td>
			     <td><input type='text' name='data'  required placeholder='Digite a data visita' class='data'/></td><td style='color:red;'>*</td>
                            </tr>
                              <td>Local Prospectado</td>
			     				 <td><input type='text' name='prospec' placeholder='Digite local prospectado' /></td><td style='color:red;'>* </td>
                            </tr>
                            
                             <tr>
                                 <td><input type=checkbox name='st' id='ac' value='ac' onclick='verificaStatusVisita(this.value)'  />Aceitou Visita</td>
                            	 <td><input type=checkbox name='st' id='mi' value='mi' onclick='verificaStatusVisita(this.value)'/> Mostrou Interesse</td>
                            </tr>
                            <tr> 
                             	<td> <input type=checkbox name='st' id='nao' value='nao' onclick='verificaStatusVisita(this.value)' />Nao</td>
                             	<td> <input type=checkbox name='st' id='pp'   value='pp' onclick='verificaStatusVisita(this.value)'/> Perguntou o preço</td>
                            </tr>
                            <tr>
                             	<td> <input type=checkbox name='st' id='rp' value='rp' onclick='verificaStatusVisita(this.value)'/> resposta positiva</td>
                             	<td > <input type=checkbox name='st' id='v' value='v' onclick='verificaStatusVisita(this.value)'  />vendido   	</td>                               
                             </tr>
                          
                             <tr>
                               <td>Status</td>
                                <td>
                                	<input type='text' name='porcentagem' id='porcentagem'   placeholder='porcentagem de fechamento'  readonly/>
                                	<input type='text' name='verStatus' id='verStatus' placeholder='Variação do status' readonly/>
                                	<input type='hidden' name='status' id='status'  />
                                    <td style='color:red;'>*</td>
                               </tr>
                               <tr>
                                    <td><span style=color:red>Numero do contrato(Se for venda):</span></td>
                                      <td><input type='text' name='contrato' id='contrato' placeholder='Digite número do contrato'  /></td>
                                </tr>
                               <tr>
                                  <td>Obs:</td>
                                  <td><textarea rows='10' cols='35' name='motivo' placeholder='Digite observações sobre a visita' ></textarea></td><td style='color:red;'>*</td>
                                </tr>
                               ";
             echo "<tr> <td>Gerente Vendas:</td>
                                     <td><select  name='gerente' id='gerente'  placeholder='Gerente de vendas' onchange = selecionaVendedor()>
                    			 <option></option> ";
            //visibilida a partir do tipo

            if ($_SESSION['tipo'] == 3) {
                $visibilidade = " AND id=$_SESSION[func_id]";
            } else {
                $visibilidade = "";
            }
            $sqlG = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND  empresa_id=$_SESSION[empresaId] AND perfil=3  $visibilidade");
            while ($row = $sqlG->fetch(PDO::FETCH_OBJ)) {
                echo " <option value='$row->id'>$row->nome</option>";
            }

            echo " </select> </td>
               </tr>";
            if ($_SESSION["tipo"] == 6) {
        echo "<tr>
                 <td><input type='hidden' name='vendedor' value='$_SESSION[func_id]'/></td>
             </tr>";
            } else {
                
      echo "<tr>    
               <td>Vendedor:</td>
              <td><select name='vendedor' id='exibir' placeholder='Nome do vendedor ' >
              </select>
           </td>
        </tr>
      <tr>";
            }
            $sqlP = $this->conn->query("SELECT id,nome FROM plano  WHERE  ativo=0 AND  empresa_id=$_SESSION[empresaId] ");
            echo "<td>Plano:</td>
                 <td><select name='plano' required  placeholder='Nome do plano '>
                	<option value=''>SELECIONE PLANO</option>";
           
               while ($l = $sqlP->fetch(PDO::FETCH_OBJ)) {
                  echo "<option value='$l->id'>$l->nome</option>";
                }
                 echo "	</select>
                 </td>
      </tr>";
         
   $sql = $this->conn->query("SELECT * FROM produto WHERE ativo=0 AND empresa_id=$_SESSION[empresaId]");
   echo "<tr>
            <td>Produto:</td>
            <td><select name='produto' id='produto' placeholder='Nome do produto ' required>
        	  <option value=''>SELECIONE PRODUTO</option>
                                  		 ";
                 while ($l = $sql->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$l->id'>$l->nome</option>
                   ";
        }
        echo "</select></td><td style='color:red;'>* </td>
                      </tr> ";
        echo " <tr>
                    <td>Quantidade</td>
                    <td><input type='number' name='qtd' required placeholder='Quantidade de produtos '/><td style='color:red;'>* </td></td>
                 </tr>
                 <tr>   
                      <td><input  type='submit' name='enviarVisita' class='botao' value='salvar'></td>
                 </tr>
              </table>
          </form>
       </fieldset>
</div>	";

        if (isset($_POST['enviarVisita'])) {
                
            if( $_POST['status']==0){
                if(!empty($_POST['contrato'])){
                    $this->salvaVisita($_POST['data'], $_POST['status'], $_POST['prospec'], $_POST['motivo'], $_POST['produto'], $_POST['qtd'], $_POST['plano'], $_POST['vendedor'], $_POST['id_cliente'], $_POST['gerente'], $_POST['contrato']);
                 }else{
                     echo "<h3 style='color:red'>Não foi possivel salvar visita ,pois não foi adicionado o numero do contrato!</h3>";
                 }
            }else{
                
                $this->salvaVisita($_POST['data'], $_POST['status'], $_POST['prospec'], $_POST['motivo'], $_POST['produto'], $_POST['qtd'], $_POST['plano'], $_POST['vendedor'], $_POST['id_cliente'], $_POST['gerente'], $_POST['contrato']);
            }
                
        }
    }

    function salvaVisita($data, $status, $prospectado, $obs, $produto, $qtd, $plano, $vendedor, $id_cliente, $gerente,$contrato) {
        $this->data = formata_data_db($data);
        if($status==0){
            $operador=-1000;
        }else{
            $operador=0;
        }
        $this->status = $status;
        
        
        $this->prospectado = $prospectado;
        $this->obs = $obs;
        $this->produto = $produto;
        $this->id_cliente = $id_cliente;
        $this->qtd = $qtd;
        $data_insercao = date('Y-m-d');
        $hora_insercao = date('H:i:s');
        $id_criador = $_SESSION['func_id'];
        // $empresa = $_SESSION['empresaId'];

        if (empty($plano)) {
            $this->plano = 1;
        } else {
            $this->plano = $plano;
        }
        //se gerente existir
        if(!empty($gerente)){
            $this->gerente = $gerente;
            if (empty($vendedor)) {
                $this->vendedor = $gerente;
            } else {
                $this->vendedor = $vendedor;
            }
        //se o gerente nao existir a visita va para administrador    
        }else{
            $this->gerente=$_SESSION["func_id"];
            $this->vendedor =$_SESSION["func_id"];
        }
        
         try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
            
            
            echo "INSERT INTO visita(data_visita,
                                                                hora_visita,
                                                                obs,
                                                                cliente_id,
                                                                vendedor_id,
                                                                gerente_vendas_id,
                                                                operador_id,
                                                                ocorrencia_id,
                                                                local_prospectado,
                                                               data_cadastro,
                                                               usuario_cadastro,
                                                               empresa_id)
                                                                VALUES('$this->data',
                                                                     '$hora_insercao',
                                                                     '$this->obs',   
                                                                      $this->id_cliente,   
                                                                      $this->vendedor,    
                                                                      $this->gerente,
                                                                      $operador,0,
                                                                      '$this->prospectado',  
                                                                      '$data_insercao',    
                                                                      $id_criador,$_SESSION[empresaId])";
           $sql = $this->conn->exec("INSERT INTO visita(data_visita,
                                                                hora_visita,
                                                                obs,
                                                                cliente_id,
                                                                vendedor_id,
                                                                gerente_vendas_id,
                                                                operador_id,
                                                                ocorrencia_id,
                                                                local_prospectado,
                                                               data_cadastro,
                                                               usuario_cadastro,
                                                               empresa_id)
                                                                VALUES('$this->data',
                                                                     '$hora_insercao',
                                                                     '$this->obs',   
                                                                      $this->id_cliente,   
                                                                      $this->vendedor,    
                                                                      $this->gerente,
                                                                      $operador,0,
                                                                      '$this->prospectado',  
                                                                      '$data_insercao',    
                                                                      $id_criador,$_SESSION[empresaId])") or die("erro insert normal");
        if ($sql){
           
            //selecione oultimo id inserido
            $ultimaInsercao = $this->conn->query("SELECt id FROM visita  WHERE usuario_cadastro=$_SESSION[func_id] AND ativo=0 order by id desc LIMIT 1");

            if ($ultimaInsercao->rowCount()) {

                $l = $ultimaInsercao->fetch(PDO::FETCH_OBJ);
                //insere visita em  visita_produto 
                
                $this->conn->query("INSERT INTO visita_produto(plano_id,produto_id,visita_id,status)VALUES($this->plano,$this->produto,$l->id,'$this->status') ") or die("erro na visita produt");

                if ($this->status == 0 && $contrato!="") {
                  
                    $sqlVP = $this->conn->query("SELECT VP.id FROM visita_produto AS VP INNER JOIN visita AS V ON VP.visita_id=V.id WHERE V.ativo=0 AND V.usuario_cadastro=$_SESSION[func_id] order by id desc LIMIT 1 ");
                    $ul = $sqlVP->fetch(PDO::FETCH_OBJ);
                
                    //se status for 0 ,ou seja,vendido insere daddo n a venda e no produto_venda
                
                    $sqlVend = $this->conn->exec("INSERT INTO vendas(data,visita_id,numContrato,data_cadastro,usuario_cadastro,visita_produto_id,ativo) VALUES('$this->data',$l->id,'$contrato','$data_insercao',$_SESSION[func_id],$ul->id,0)") or die("erro");
                 
                    if ($sqlVend) {
                
                        $sqlUltId = $this->conn->query("SELECt V.id ,V.visita_produto_id ,P.valor FROM vendas AS V INNER JOIN visita_produto AS VP ON V.visita_produto_id=VP.id 
                                                    INNER JOIN produto AS P ON P.id=VP.produto_id  WHERE V.usuario_cadastro=$_SESSION[func_id]  order by V.id desc LIMIT 1");


                        if ($sqlUltId->rowCount()) {
                            $r = $sqlUltId->fetch(PDO::FETCH_OBJ);
                
                            $prod_venda = $this->conn->exec("INSERT INTO produto_venda(vendas_id,valor,visita_produto_id,quantidade) VALUES($r->id,$r->valor,$r->visita_produto_id,$qtd)") or die("erro na insercao ven_prod");
                            if ($prod_venda) {
                                echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                                         location.href='?pg=visitados';
                                      </script>";
                            }
                        }
                    }
                } else {
                   echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                              location.href='?pg=visitados';
                         </script>";
                }
           }
        }
        
        $this->conn->commit();
        }catch (Exception $e){
              echo "rolback";
          $this->conn->rollBack();
        }  
    }
}

$obj = new salvarVisita;

$obj->VisualizaCadastro();
?>