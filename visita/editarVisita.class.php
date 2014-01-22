<?php

class editarVisita {

    private $id;
    private $data;
    private $produto;
    private $motivo;
    private $status;
    private $identificador;
    private $telfixo;
    private $visita;
    private $cliente;
    private $vendedor;
    private $plano;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function editaVisita($visita) {
        if($_SESSION["tipo"]==0){
            $empresa="";
        }else{
            $empresa=" AND empresa_id=$_SESSION[empresaId]";
        }
        $this->visita = $visita;
       

        $consultar = $this->conn->query("SELECT V.*,C.id AS idCli,C.nome as cliente,C.fone1,C.fone2,PL.id as idPlano,
                                         PL.nome as plano,C.numero_documento,F.id AS idFunc,F.nome,F.superior_id,P.id AS idProd,P.nome AS produto,VP.status
                                          FROM  visita AS V INNER JOIN funcionario AS F ON V.vendedor_id=F.id
                                          INNER JOIN cliente C ON C.id=V.cliente_id
                                          INNER JOIN visita_produto AS VP ON VP.visita_id=V.id
                                          INNER JOIN produto AS P ON P.id=VP.produto_id
                                          INNER JOIN plano AS PL ON PL.id=VP.plano_id
                                          WHERE  V.id=$visita");
        $linha = $consultar->fetch(PDO::FETCH_OBJ);
        echo "<div id='formularios'>
		<fieldset>
                <legend>Editar Visita</legend>
                 <table>
            	<form method='post' action='#'>
                <tr><td>Codigo da Visita:</td>
                    <td><input type='text' name='visita' value='$linha->id' readonly/></td>
                    <td><input type='hidden' name='cliente' value='$linha->idCli'/></td>
                </tr>
                <tr>
                    <td>Data Visita:</td>
                    <td><input type='text' name='data' class='data' value='" . formata_data($linha->data_visita) . "' />
                        <input type='hidden' name='dataEscondido'  value='" . formata_data($linha->data_visita) . "' />
                    </td>
            	</tr>
              	<tr>
                    <td>Cliente:</td>
		    <td><input type='text' name='nome' value='$linha->cliente' /></td>
                    <td><input type='hidden' name='nomeEscondido' value='$linha->cliente' /></td>    
                    <td><input type='hidden' name='id_cliente' value='$linha->cliente_id' /></td>
                </tr>
                <tr>
                    <td>Fone 1:</td>
                    <td><input type='text' name='telfixo' value='$linha->fone1' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  />
                        <input type='hidden' name='telfixoEscondido' value='$linha->fone1' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  />
                    </td>
            	</tr>
                <tr>
                    <td>Fone 2:</td>
                    <td><input type='text' name='cel1' value='$linha->fone2' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  />
                        <input type='hidden' name='cel1Escondido' value='$linha->fone2' onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  />
                    </td>
            	</tr>
            	<tr>
                    <td>Identificador(CPF/CNPJ):</td>
                    <td><input type='text' name='idt' value='$linha->numero_documento' />
                        <input type='hidden' name='idtEscondido' value='$linha->numero_documento' />
                    </td>
            	</tr>
                 <tr>
                      <td>Gerente de vendas</td>";
                            $sqlGer=$this->conn->query("SELECT id,nome FROM funcionario WHERE id=$linha->gerente_vendas_id AND perfil=3 AND ativo=0");
                             $lista=$sqlGer->fetch(PDO::FETCH_OBJ);
           echo "        <input type='hidden' name='copiaGerenteId' value='$lista->id' />
                    <td> <input type='text' name='copiaGerenteNome' value='$lista->nome' readonly/></td>
                </tr>
                 <tr>
                   <td>Novo Gerente Vendas</td>
                    <td><select name='gerente' id='gerente' onchange='selecionaVendedor()'> ";
                 $sqlger=  $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND perfil=3 $empresa");
                    while($list=$sqlger->fetch(PDO::FETCH_OBJ)){
                        echo "<option value='$list->id'>$list->nome</option>";
                    }
           
         echo "     </select>
                </td>
             </tr>
              <tr>
                   <td>Vendedor:</td>
                    <td>
                        <input type='hidden' name='vendedorEscondido' value='$linha->idFunc' />
                        <select name=vendedor id=exibir >
                         <option  value='$linha->idFunc'>$linha->nome</option>";
        //LISTA OS VENDEDORES
        $selecionaVendedor = $this->conn->query("SELECT id,nome FROM funcionario  
                                                 WHERE superior_id=$linha->superior_id AND id<>$linha->id AND perfil=6 AND ativo=0 AND empresa_id=$_SESSION[empresaId]");

        while ($rs = $selecionaVendedor->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$rs->id'>$rs->nome</option>";
        }
        echo " </select></td>
              </tr>
              <tr>
                   <td>Status:</td>";
        if ($linha->status == 0) {
            $estado = "Vendido";
        } elseif ($linha->status == 1) {
            $estado = "Quente";
        } elseif ($linha->status == 2) {
            $estado = "Morno";
        }
        echo "<td>
              
                <select name='status'>
                        <option value='$linha->status'>$estado</option>
                         <option value='0'>Vendido</option>
                          <option value='1'>Quente</option>
                          <option value='2'>Morno</option>
                </select></td>
                <td><input type='hidden' name='statusEscondido' value='$linha->status'/></td>
            </tr>
            <tr>
                <td>Produto</td>
                 <td>
                    <input type='hidden' name='produtoEscondido' value='$linha->idProd'/>
                    <select name='produto' >
                            <option value='$linha->idProd'>$linha->produto</option>";
                                 $sql = $this->conn->query("SELECT id,nome from produto WHERE id<>$linha->idProd AND ativo=0 AND empresa_id=$_SESSION[empresaId]");
                                     while ($l = $sql->fetch(PDO::FETCH_OBJ)) {
                                        echo "<option value='$l->id'>$l->nome</option>";
                                    }
                echo "
                      </select>
               </tr>
               <tr>
                    <td>Plano:</td>
                    <td>
                        <input type='hidden' name='planoEscondido' value='$linha->idPlano'/> 
                        <select name='plano' >

                            <option value='$linha->idPlano'>$linha->plano</option>";
        $sql2 = $this->conn->query("SELECT id,nome from plano WHERE id<>$linha->idPlano  AND ativo=0 AND empresa_id=$_SESSION[empresaId]");
        while ($l = $sql2->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$l->id'>$l->nome</option>";
        }
        echo "</select></td>
               </tr>
            	<tr>
                    <td>Observações:</td>
                    <td>
                        <input type='hidden' name='motivoEscondido' value='$linha->obs'/>
                            <textarea cols=30 rows=20 name='motivo' >
                           $linha->obs
                           </textarea>
                    </td>
                </tr>

               <tr>
                    <td></td>
                    <td><input class='botao' type='submit' name='gravar' value='Salvar' /></td>
               </tr>
            </form>
         </table>
         </fieldset>
      </div>
";
        if (isset($_POST['gravar'])) {
            $this->gravarVisita($_POST['data'],$_POST['dataEscondido'], $_POST['visita'], $_POST['motivo'],$_POST['motivoEscondido'], $_POST['produto'],$_POST['produtoEscondido'],
                                $_POST['plano'], $_POST['planoEscondido'], $_POST['telfixo'],$_POST['telfixoEscondido'], $_POST['cliente'], $_POST['cel1'],$_POST['cel1Escondido'],
                                $_POST['copiaGerenteId'], $_POST['gerente'],$_POST['vendedor'],$_POST['vendedorEscondido'],$_POST['status'],$_POST['statusEscondido'],$_POST['idt'],
                                $_POST['idtEscondido'],$_POST['nome'],$_POST['nomeEscondido']);
        }
    }

    function gravarVisita($data,$copiaData, $visita, $motivo,$copiaMotivo, $produto,$copiaProduto, $plano,$copiaPlano, $telfixo,$copiaTelfixo, $cliente, $cel1, $copiaCel1,
                            $copiaGerente, $gerente,$vendedor,$copiaVendedor,$status,$copiaStatus,$idt,$copiaIdt,$nome,$copiaNome) {
        $this->data = formata_data_db($data);
        $this->visita = $visita;
        $this->motivo = $motivo;
        $this->produto = $produto;
        $this->plano = $plano;
        $this->telfixo = $telfixo;
        $this->cliente = $cliente;
        $this->cel1 = $cel1;
        $this->vendedor = $vendedor;
        $this->hora = date("H:m:i");
         $data=date("Y-m-d");

 //SE ALGUM DADO FOR ALTERADO
       if(($data!=$copiaData) || ($motivo!=$copiaMotivo)||($vendedor!=$copiaVendedor)||($copiaGerente!=$gerente)){
         if (empty($gerente)) {
                $gerente = $copiaGerente;
            }
           if (empty($vendedor)) {
                $this->vendedor = $gerente;
            } 
           echo "UPDATE visita SET data_visita='$this->data',obs='$this->motivo',vendedor_id=$this->vendedor,gerente_vendas_id=$gerente
                                             WHERE id=$this->visita  and ativo=0";
                $atualizacao = $this->conn->exec("UPDATE visita SET data_visita='$this->data',obs='$this->motivo',vendedor_id=$this->vendedor,gerente_vendas_id=$gerente
                                             WHERE id=$this->visita  and ativo=0") or die("deu erro atualiza visita");
        } 
      
      if(($plano!=$copiaPlano)||($status!= $copiaStatus)|| ($produto!= $copiaProduto)){
              echo "<br/>UPDATE visita_produto SET plano_id=$this->plano,produto_id=$this->produto WHERE visita_id=$this->visita<br/> ";
                $this->conn->exec("UPDATE visita_produto SET plano_id=$this->plano,produto_id=$produto,status=$status WHERE visita_id=$this->visita ")or die("deu erro atualiza visita_produto");   
  
      }
     
      if(($telfixo!=$copiaTelfixo)||($idt!=$copiaIdt)||($nome!=$copiaNome)|| ($cel1!= $copiaCel1)){
            $atualCli=$this->conn->exec("UPDATE cliente SET fone1='$this->telfixo',fone2='$this->cel1',nome='$nome' WHERE id=$this->cliente AND empresa_id=$_SESSION[empresaId] AND ativo=0")or die("deu erro atualiza cliente");
       }
        //verifica e set visita ma tabela vendas
       if($copiaStatus!=$status){
  				//verifica se a visita esta na venda
				$cVenda = $this -> conn -> query("SELECT visita_id FROM vendas WHERE visita_id=$this->visita AND ativo=0");
				if ($status == 0) {
					if ($cVenda -> rowCount() == 0) {
                                            //seleciona a utilma inserca da tabela 
                                            $VP=$this -> conn ->query("SELECT id FROM visita_produto WHERE visita_id=$this->visita  ORDER BY id DESC LIMIT 1 "); 
                                             $rvp=$VP->fetch(PDO::FETCH_OBJ);
                                           //  echo "<br/>INSERT INTO vendas(data,visita_produto_id,data_cadastro,hora_cadastro,usuario_cadastro,ativo)VALUES
          							//	 ('$this->data',$rvp->id,'$data', '$this->hora', $_SESSION[id],0 ) ";
						$this -> conn -> exec("INSERT INTO vendas(data,visita_produto_id,visita_id,data_cadastro,hora_cadastro,usuario_cadastro,ativo)VALUES
          								 ('$this->data',$rvp->id,$this->visita,'$data', '$this->hora', $_SESSION[id],0 ) ") or die("erro atualiza status");
					} else {
						$this -> conn -> exec("UPDATE vendas SET ativo=0 WHERE visita_id=$this->visita ")or die("atualizacao vendas");
					}

				} elseif ($status > 0 || $status < 3) {
					if ($cVenda -> rowCount()) {
						$v = $cVenda -> fetch(PDO::FETCH_OBJ);
						if ($v -> ativo == 0)
							$venda=$this -> conn -> exec("UPDATE vendas SET ativo=-1 WHERE visita_id=$this->visita") or die("erro atualizacao vendasexclusao");
					
                                                echo "<h3 style='color:green'>Operação Realizada com sucesso</h3>";
                                        }
				}
			     	
       }
         //fim de veificação/
	   
	     //	
        
        if ($atualizacao || $venda) {
            echo "<script type='text/javascript'>
                   alert('Atualizacao feita com sucesso!')
                      location.href='?pg=visitados';
               </script>";
        }
      }
    

}

?>
