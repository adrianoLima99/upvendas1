<script type="text/javascript" src="ajax/listaCidades.js"></script>
<?php

//fazer upload
class Acompanha {

    private $conn;
    private $codigo;
    private $visita;
    private $operador;
    private $vendedor;
    private $gerente;
    private $motivo;
    private $hora;
    private $data;
    private $cliente;
    private $id_cliente;
    private $horaAgendamento;
    private $dataAgendamento;
    private $telFixo;
    private $cel1;
    private $cel2;
    public $resposta;
    private $condicao;
    private $tipo;
    private $endereco;
    private $estado;
    private $cidade;
    private $bairro;
    private $produto;
    private $nascimento;

    function __construct() {
        $this->conn = new connection;
    }

    //REMOVE MASCARA TELEFONE
    function removeMascaraTel($v) {
        $vf = removeMascaraTel($v);
        return $vf;
    }

    function Acompanhados() {

        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirAcompanhamento&id='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM   


       // $this->tipoUsuario();
        $data = date('Y-m-d');
        if ($_SESSION['tipo'] == 5) {

            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F INNER JOIN visita AS V ON F.id=V.operador_id 
                                                 INNER JOIN acompanhamento AS A ON A.visita_id=V.id 
                                                 WHERE F.id=$_SESSION[func_id] and A.data='$data' AND F.empresa_id=$_SESSION[empresaId] AND A.ativo=0");
        } else {
            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F INNER JOIN visita AS V ON F.id=V.operador_id 
                                                 INNER JOIN acompanhamento AS A ON A.visita_id=V.id 
                                                   WHERE  A.data='$data' AND F.empresa_id=$_SESSION[empresaId] AND A.ativo=0");

           
        }
         $this->pesquisaHistorico();

        echo "<br/><br/> <div id='listagens'>
  <h3>Acompanhamento por operador de Telemarketing</h3> ";

        // $listaOperador = $this->conn->query("select distinct nome_operador,id_operador from operador_marketing $operador");

        while ($list = $listaOperador->fetch(PDO::FETCH_OBJ)) {
           

            $sqlConsulta = $this->conn->query("SELECT distinct A.id AS id_acom,A.data,A.hora,A.obs,A.statusOcorrencia,A.resposta_id,C.nome AS cliente,V.id AS idVisita,V.gerente_vendas_id,V.vendedor_id,
                                                V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.status 
                                                               FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                               INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id 
                                                               INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                               INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                               INNER JOIN produto AS P ON P.id=VP.produto_id
                                                               WHERE  V.operador_id=$list->id
                                                               AND  A.data = '$data'   
                                     		                AND A.ativo=0
                                                                AND F.ativo=0
                                                                AND V.ativo=0
                                                                AND F.empresa_id=$_SESSION[empresaId]
                                                                order by  A.id desc         ");
            

           $listaAgendados=  $this->conn->query("SELECT count(AG.acompanhamento_id) AS conta FROM agendamento_visita AS AG INNER JOIN 
                                                    acompanhamento AS AC ON AG.acompanhamento_id=AC.id
                                                    INNER JOIN visita AS V ON  V.id=AC.visita_id
                                                    WHERE V.operador_id=$list->id AND AG.data='$data' AND AG.ativo=0 AND AC.ativo=0 GROUP BY V.operador_id");
            $contaAgendados=$listaAgendados->fetch(PDO::FETCH_OBJ);
               
            echo "<div class='accordionButton'>$list->nome ( Operador de Telemarketing) <br/>- Quantidade Acompanhados:" . $sqlConsulta->rowCount() . "<br/> - Quantidade Agendados:$contaAgendados->conta</div>
                        <div class='accordionContent'>";
            if ($sqlConsulta->rowCount()) {
                echo "
   			<table>
          		<tr>
                            <th>Id </th>
                            <th>cliente</th>
                            <th>Gerente De Vendas</th>
                            <th>Vendedor</th>
                            <th>Produto</th>
                            <th>Status</th>
                            <th>Obs</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Agendado</th>
                            <th>Ocorr&ecirc;ncia</th>
                            <th>Resposta Automatica</th>";
                if ($_SESSION["tipo"] == 0 ||$_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 2 || $_SESSION["tipo"] == 4) {
                    echo "	<th colspan=2>Ação</th>";
                }
                echo "</tr>";
                while ($l = $sqlConsulta->fetch(PDO::FETCH_OBJ)) {
                    $sqlVd = $this->conn->query("SELECT nome FROM funcionario WHERE id=$l->vendedor_id");
                    $lv = $sqlVd->fetch(PDO::FETCH_OBJ);




                     if ($l -> status == 0) {
                      $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                      } elseif ($l -> status == 1) {
                      $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                      } elseif ($l -> status == 2) {
                      $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                      }
                    //verifica se existe resposta aumtomatica
                    if($l->resposta_id !=0){
                        $listRespostaAutomatica=  $this->conn->query("SELECT R.id,R.resposta FROM respostaautomatica as R INNER JOIN funcionario as F ON  F.id=R.usuario_cadastro
                                                                      WHERE R.ativo=0 AND F.empresa_id=$_SESSION[empresaId] AND R.id=$l->resposta_id ");
                    
                        $exibirresposta=$listRespostaAutomatica->fetch(PDO::FETCH_OBJ);
                        $repostaAutomatica=$exibirresposta->resposta;
                    }else{
                        $repostaAutomatica="não possui";
                    }
                    //verifica se foi agendado
                    $agendados = $this->conn->query("SELECT id FROM agendamento_visita WHERE acompanhamento_id = $l->id_acom AND ativo=0");
                    if ($agendados->rowCount()) {
                        $this->resposta = 'sim';
                    } else {
                        $this->resposta = 'não';
                    }
                    if ($l->statusOcorrencia == 0) {
                        $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$l->id_acom&tabela=acompanhamento'>Adicionar </a> ";
                    } else {
                        $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$l->id_acom&tabela=acompanhamento'>Resolver </a> ";
                    }
                    echo "<tr>
                        <td>$l->id_acom</td>
                        <td>$l->cliente</td>               
                        <td>$l->nome</td>
                        <td>$lv->nome</td>    
                        <td>$l->produto</td>
                       <td>$status</td>     
                          <td>$l->obs</td>
                          <td>" . formata_data($l->data) . "</td>
                         <td>$l->hora</td>     
                          <td>$this->resposta</td>
                         <td>$ocorrencia</td>
                         <td>$repostaAutomatica</td>";
                    if ($_SESSION["tipo"] == 0 || $_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 2 || $_SESSION["tipo"] == 4) {
                        echo "<td>
                                    <a href='?pg=visualizarAcom&acom=$l->id_acom'><img src='imagens/view.png' title='visualizar visita'/></a>       
                                     <a href='?pg=editarAcom&idAcom=$l->id_acom'><img src='imagens/edita.png' title='editar'/></a>
		                      <a href='#' onclick='excluir($l->id_acom)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                    }
                    echo "</tr>";
                }
                echo " </table>";
            } else {
                echo "<p>N&atilde;o foi feito  nenhum acompanhamento!</p>";
            }

            echo "</div>";
        }

        echo "</div>";
    }

    function pesquisaHistorico() {


        if ($_SESSION['tipo'] == 0 || $_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 4 || $_SESSION['tipo'] == 5) {
            echo "
             <div id='formularios'>
            <fieldset> 
          <legend>Pesquisa  Acompanhados</legend>
           <form method='post' action='#'>
            <table>
                <tr>
	             <td>Id Visita</td>
	             <td><input type='number' name='id' placeholder='Insira o id visita'/></td>
	        </tr>
	       	<tr>
		    <td>Periodo :</td>
	             <td><input type='text' name='data1' class='data' placeholder='Insira a data inicio' style='width:110px;'/>A
	        	<input type='text' name='data2' class='data' placeholder='Insira a data final' style='width:110px' /></td>
	        </tr>";
            if($_SESSION["tipo"]!=5){
           echo "<tr>
                     <td>Operador(a):</td>
	             <td><select name='operador' title='Selecione um operador de telemarketing'>
	                    <option value=''> Selecione um operador telemarketing</option>";
                                $historico = $this->conn->query("SELECT id,nome FROM funcionario where ativo=0 AND  empresa_id=$_SESSION[empresaId] AND perfil=5  ");
                                 while ($l = $historico->fetch(PDO::FETCH_OBJ)) {
                                 echo "<option value='$l->id'>$l->nome</option>";
                                 }
                         echo "</td>
                       </tr>";
            }else{
                echo "<input type='hidden' name='operador' value='$_SESSION[func_id]' /></td>";
            }           
           echo "       <tr>
                            <td>Status</td>
                            <td><select name='status'>
                                    <option value=''>Selecione status</option>
                                    <option value='1'>Quente</option>
                                    <option value='2'>Morno</option>
                                  
                                 </select></td>
                       </tr>
                   <tr><td></td><td><input type='submit' name='pesquisar' value='pesquisar' class='botao'/></td></tr>    
                
            </table>
           </fieldset> 
            </form>
            </div>";
        }
       
    }

    /*function tipoUsuario() {

        if ($_SESSION['tipo'] == 5) {
            $this->tipo = " AND id_operador=$_SESSION[id] ";
        } else {
            $this->tipo = "";
        }
    }*/

    //funcao para contar visita para acompanhamento

    function Novo() {


        $consulta = $this->conn->query("SELECT V.id AS visita,V.data_visita,V.obs,V.local_prospectado,V.data_cadastro,V.operador_id,V.gerente_vendas_id,F.id,F.nome,F.superior_id ,F.perfil,
                                        C.id AS idCliente,C.nome AS cliente,C.sexo,C.email,C.fone1,C.fone2,C.logradouro,C.municipio_codigo,C.bairro,C.data_nascimento,
                                        VP.produto_id,P.nome AS produto,M.nome AS municipio,M.id AS municipio_id,E.id AS estado_id,E.nome AS estado
                                        FROM visita V INNER JOIN funcionario AS F ON V.vendedor_id=F.id
                                        INNER JOIN cliente AS C ON V.cliente_id =C.id
                                        INNER JOIN  municipio AS M ON M.id=C.municipio_codigo
                                        INNER JOIN estado AS E ON E.id=M.estado_uf
                                        INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                        INNER JOIN produto AS P ON VP.produto_id = P.id 
                                         WHERE  V.ativo=0 AND V.id=$_GET[visita] AND F.empresa_id=$_SESSION[empresaId]");

        $li = $consulta->fetch(PDO::FETCH_OBJ);
        $produtos = $this->conn->query("SELECT id,nome FROM produto WHERE empresa_id=$_SESSION[empresaId] AND ativo=0 ");
        echo "<div id='formularios'>
             <fieldset>
              <legend>Inserir Acompanhamento</legend>
              <form method='post' action='#'>
                <table >
                
                <tr>
                    <td><input type='hidden' name='agendaOperador'  value='$_GET[agendaOperador]'/>  </td> 
                </tr>
                <tr>
                    <td><input type='hidden' name='gerente'  value='$_GET[gerente]'/>  </td> 
                </tr>
                <tr>
            
                    <td>Codigo da Visita:</td>
                    <td><input type='text' name='visita'  value='$li->visita' readonly/></td>    
                             
              </tr>
              <tr>
                    <td>Data da Visita:</td><td><input type='text' name='dataVisita' readonly value='" . formata_data($li->data_visita) . "' /></td>
                         <td><input type='hidden' name='data' id='data'  value='" . date('Y-m-d') . "'/></td>    
             </tr>
               <tr>
                    <td><input type='hidden' name='hora'   value='" . date('H:i:s') . "'/></td>
              </tr>
              <tr>
                   <td>Vendedor:</td>";
                   $listavend=  $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$li->id");
                    $exibirVend=$listavend->fetch(PDO::FETCH_OBJ);
      echo "      <td><input type='hidden' name='vendedor_id' value='$exibirVend->id' />
                      <input type='text' name='vendedor_nome' value='$exibirVend->nome' readonly/>  </td>   
            </tr>
             <tr>
                  <td>Cliente:</td> 
                  <td><input type='text' name='cliente' id='cliente'  value='$li->cliente'/>
                  <td><input type='hidden' name='id_Cliente' id='idCliente'  value='$li->idCliente'/> </td>         
             </tr>
             <tr>
                  <td>Sexo:</td>
                  <td><select name='sexo'>
                           <option> $li->sexo</option>
                            <option>M</option>
                           <option>F</option>
                      </select>
                   </td>
           </tr>
            <tr>
                  <td>Data Nascimento:</td>
                  <td><input type='text' name='nascimento'  value='" . formata_data($li->data_nascimento) . "' onkeypress='return valNASC(event,this);return false;'  maxlength='10'/>
            </tr>
            <tr>
                 <td>Email:</td>
		 <td><input type='text' name='email' value='$li->email' /></td>
            </tr>
             <tr>
                  <td>Endereço:</td>
                  <td><input type='text' name='endereco' id='endereco'  value='$li->logradouro'/>
            </tr>
             <tr>
                  <td>UF:</td>
                  <td><input type='hidden' name='estadoEscondido' id='estadoEscondido'  value='$li->estado_id'/>
                      <select name='estado' id='uf' onchange='listaCidades()'>
                            <option>$li->estado</option>";
        $estado = $this->conn->query("SELECT id,nome FROM estado ");
        while ($rw = $estado->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$rw->id'>$rw->nome</option>";
        }
        echo"            </select>
            </tr>
              <tr>
                  <td>Cidade:</td>
                  <td><input type='hidden' name='cidadeEscondida' id='cidadeEscondida'  value='$li->municipio_id'/>
                      <select name='cidade' id='municipio'>
                            <option value='$li->municipio_id'>$li->municipio</option>
                        </select>
            </tr>
             <tr>
                 <td>Bairro:</td>
                 <td><input type='text' name='bairro' id='bairro'  value='$li->bairro'/>
            </tr>
            <tr>
                 <td>Fone 1:</td>
                 <td><input type='text' name='telFixo' id='telFixo'  value='$li->fone1' onkeypress='return valPHONE(event,this);return false;'  maxlength='13' />
            </tr>
            <tr>
                 <td>Fone 2:</td> 
                 <td><input type='text' name='cel1' id='cel1'  value='$li->fone2' onkeypress='return valPHONE(event,this);return false;'  maxlength='13' />
           </tr>
              <tr>
                  <td>Produto:</td>
                  <td>
                      <select name='produto' >
                            <option value='$li->produto_id'>$li->produto</option>";
        while ($prod = $produtos->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$prod->id'>$prod->nome</option>";
        }
        echo "                </select></td>
            </tr>

            <tr>";
                   $listaOperador=  $this->conn->query("SELECT id,nome FROM funcionario WHERE id=$li->operador_id");
                    $exibiroperador=$listaOperador->fetch(PDO::FETCH_OBJ);
      echo " 
               <td>Operador:</td><td><input type='text' name='operador' id='operador' value='$exibiroperador->nome' readonly/></td>
                                <td><input type='hidden' name='operadorEscondido' id='operadorEscondido'  value='$exibiroperador->id'/>
            </tr>
           
            <tr>
        	    <td rowspan='2'>Obs:</td><td><textarea rows='15' cols='25' name='motivo' ></textarea></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
         <legend>Registrar Ocorr&ecirc;ncia</legend>
         <table>
            <tr>
	             <td>Ocorr&ecirc;ncia</td>
    	         <td><select name='ocorrencia'>
        	            <option value=''>Selecione uma Ocorr&ecirc;ncia </option>";
        $oc = $this->conn->query("SELECT id,nome FROM ocorrencia WHERE ativo=0 AND aprovado=0 AND empresa_id=$_SESSION[empresaId]");
        while ($l = $oc->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$l->id'>$l->id-$l->nome</option>";
        }
        echo "                
             		
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
          <table>
           <tr>
           <td><input type='submit' name='acompanhar' id='acompanha'  class='botao' value='Salvar'/></td>
        </form>
           </tr>
       </table>
 </div>";
    }

    function RegitraAcompanhamento() {




        if (isset($_POST['acompanhar'])) {
            $this->id_cliente = $_POST['id_Cliente'];
            $this->cliente = $_POST['cliente'];
            $this->visita = $_POST['visita'];
            $this->gerente = $_POST['gerente'];
            $this->vendedor = $_POST['vendedor_id'];
            $this->operador = $_POST['operadorEscondido'];
            $this->motivo = $_POST['motivo'];
            $sexo=$_POST["sexo"];
            $email=$_POST["email"];
            if (empty($_POST['ocorrencia'])) {
                $ocorrencia = 0;
                $statusOcorrencia = 0;
            } else {
                $ocorrencia = $_POST['ocorrencia'];
                $statusOcorrencia = 1;
            }

            $this->data = $_POST['data'];

            if (!empty($_POST['dataAgendamento'])) {
                $this->dataAgendamento = formata_data_db($_POST['dataAgendamento']);
            } else {
                $this->dataAgendamento = "";
            }
            if (!empty($_POST['dataAdiamento'])) {
                $dataAdiamento = formata_data_db($_POST['dataAdiamento']);
            } else {
                $dataAdiamento = "";
            }
            if (!empty($_POST['nascimento'])) {
                $this->nascimento = formata_data_db($_POST['nascimento']);
            } else {
                $this->nascimento = "";
            }
            $this->hora = $_POST['hora'];
            $this->produto = $_POST['produto'];

            $this->horaAgendamento = $_POST['horaAgendamento'];

            $horaAdiamento = $_POST['horaAdiamento'];
            $this->endereco = $_POST['endereco'];
            $this->telFixo = $this->removeMascaraTel($_POST['telFixo']);
            $this->cel1 = $this->removeMascaraTel($_POST['cel1']);

            $agendaOperador = $_POST['agendaOperador'];

            if (empty($_POST['estado'])) {
                $this->estado = $_POST['estadoEscondido'];
            } else {
                $this->estado = $_POST['estado'];
            }
            if (empty($_POST['cidade'])) {
                $this->cidade = $_POST['cidadeEscondida'];
            } else {
                $this->cidade = $_POST['cidade'];
            }

            $this->bairro = $_POST['bairro'];
         //////////////////////////////////////////////////////////////////////////////////   
            try{
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $this->conn->beginTransaction();
            $this->conn->query("INSERT INTO acompanhamento(data,hora,obs,visita_id,statusOcorrencia,ocorrencia_id,resposta_id,usuario_cadastro,ativo) 
                                        VALUES('$this->data','$this->hora','$this->motivo',$this->visita,$statusOcorrencia, $ocorrencia,0,$_SESSION[func_id],0)");
            
            if(!empty($this->dataAgendamento)){
               
               $consultaAcom=  $this->conn->query("SELECT A.id,V.vendedor_id FROM acompanhamento AS A INNER JOIN visita AS V ON  A.visita_id=V.id
                                                   WHERE A.usuario_cadastro=$_SESSION[func_id] ORDER BY A.id DESC LIMIT 1");
                $acompanhamento=$consultaAcom->fetch(PDO::FETCH_OBJ);
               
                $this->conn->exec("INSERT INTO agendamento_visita(data,hora,responsavel,acompanhamento_id,ocorrencia_id,statusOcorrencia,ativo) VALUES('$this->dataAgendamento','$this->horaAgendamento',$acompanhamento->vendedor_id,$acompanhamento->id,$ocorrencia,$statusOcorrencia,0)");
            }
            if(!empty($dataAdiamento)){
                
              $ultimo=  $this->conn->query("SELECT id FROM acompanhamento  WHERE usuario_cadastro=$_SESSION[func_id] AND ativo=0 order by id DESC limit 1");
              $exibiUltimo=$ultimo->fetch(PDO::FETCH_OBJ); 
       
              $this->conn->exec("INSERT INTO agendamento_operador(data,hora,ativo,acompanhado,acompanhamento_id) VALUES('$dataAdiamento','$horaAdiamento',0,0,$exibiUltimo->id)");
            }
            if (!empty($agendaOperador)) {
                $sq=$this->conn->query("SELECt id FROM agendamento_operador WHERE acompanhado=1 AND id=$agendaOperador");
                 if($sq->rowCount()==0){
                    $this->conn->exec("UPDATE agendamento_operador SET acompanhado=1 WHERE id=$agendaOperador ")or die("UPDATE agendamento_operador SET acompanhado=1 WHERE id=$agendaOperador ");    
                 }
            } 
            $this->conn->exec("UPDATE cliente SET nome='$this->cliente',email='$email',data_nascimento='$this->nascimento',logradouro='$this->endereco',sexo='$sexo',municipio_codigo=$this->cidade,fone1='$this->telFixo',
                               fone2='$this->cel1',bairro='$this->bairro' WHERE id=$this->id_cliente ");
            
            $this->conn->commit();
            
            echo "<script type='text/javascript'>alert('Acompanhamento feito com sucesso')
                  location.href='?pg=acompanha';
                 </script>";
            
          }catch (Exception $e){
              echo "deu erro";
          $this->conn->rollBack();
          } 
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
            
            

            /*$con = $this->conn->exec("insert into acompanhamento values(null,'$this->data','$this->hora','$this->motivo',$this->visita,$statusOcorrencia, $ocorrencia,0,$_SESSION[func_id],0)") or die("erro insercao");

            if ($con) {
                //verifca se ja foi setado valor em visita
                $sV=$this->conn->query("SELECT id FROM visita WHERE acompanhado=1 AND id=$this->visita");
                if($sV->rowCount()==0){
                     $gravaBanco = $this->conn->exec("UPDATE visita SET acompanhado=1 WHERE id=$this->visita")or die("erro");
                }
                //atualiza dados do cliente
                $this->conn->exec("UPDATE cliente SET nome='$this->cliente',logradouro='$this->endereco',bairro='$this->bairro',municipio_codigo='$this->cidade',
                                                        fone1='$this->telFixo',data_nascimento='$this->nascimento',fone2='$this->cel1' WHERE id=$this->id_cliente ");
                //atualiza o campo acompanhado para 1 da tabela visita
            }

            if (!empty($agendaOperador)) {
                $sq=$this->conn->query("SELECt id FROM agendamento_operador WHERE acompanhado=1 AND id=$agendaOperador");
                 if($sq->rowCount()==0){
                    $this->conn->exec("UPDATE agendamento_operador SET acompanhado=1 WHERE id=$agendaOperador ")or die("UPDATE agendamento_operador SET acompanhado=1 WHERE id=$agendaOperador ");    
                 }
              
            }
            //agenda uma visita
            if (!empty($this->dataAgendamento) && !empty($this->horaAgendamento)) {

                $sql_consulta = $this->conn->query("SELECT id FROM acompanhamento ORDER BY id DESC LIMIT 1  ");

                $row = $sql_consulta->fetch(PDO::FETCH_OBJ);

                $this->conn->exec("INSERT INTO agendamento_visita values(null,$this->vendedor, '$this->dataAgendamento','$this->horaAgendamento',$row->id,$ocorrencia,$statusOcorrencia,0)") or die("deu erro agendamento");

                echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                  location.href='?pg=agendamento';
                    </script>";
            }
            if (!empty($dataAdiamento) && !empty($horaAdiamento)) {
                $sql_consulta = $this->conn->query("SELECT id FROM acompanhamento WHERE visita_id=$this->visita ORDER BY id DESC LIMIT 1  ");
                $li = $sql_consulta->fetch(PDO::FETCH_OBJ);
                $this->conn->exec("UPDATE visita SET acompanhado=1 WHERE id=$this->visita ");
                $this->conn->exec("INSERT INTO agendamento_operador  VALUES(null,'$dataAdiamento','$horaAdiamento',0,0,$li->id)");
                echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                      location.href='?pg=acompanha';
                     </script>";
            }
            if ($con) {
                echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                  location.href='?pg=acompanha';
                    </script>";
            }*/
        }
    }

    function listaHistorico($idVisita, $idOperador, $data1, $data2,$status) {



        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluir(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirAcompanhamento&id='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM      





        $condicao = "";
        $condAge = "";
        if (!empty($idVisita)) {
            $condicao = $condicao . " AND A.visita_id=$idVisita";
        }
        if (!empty($idOperador)) {
            $condicao = $condicao . " AND V.operador_id=$idOperador";
        }
        if (!empty($data1) && !empty($data2)) {
            $d1 = formata_data_db($data1);
            $d2 = formata_data_db($data2);
            $condicao = $condicao . " AND A.data BETWEEN '$d1' AND '$d2'";
            $condAge = " AND data BETWEEN '$d1' AND '$d2'";
        }
        if(!empty($status)){
            $condicao=$condicao." AND VP.status=$status" ;
        }




        if ($_SESSION['tipo'] == 5) {

            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM FUNCIONARIO AS F INNER JOIN visita AS V ON F.id=V.operador_id 
                                                 INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                 INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                 WHERE F.id=$_SESSION[func_id] $condicao AND F.empresa_id=$_SESSION[empresaId] AND A.ativo=0");
        } else {
            $listaOperador = $this->conn->query("SELECT  distinct F.nome,F.id FROM funcionario AS F 
                                                  INNER JOIN visita AS V ON F.id=V.operador_id 
                                                  INNER JOIN acompanhamento AS A ON A.visita_id=V.id
                                                  INNER JOIN visita_produto AS VP ON VP.visita_id = V.id
                                                   WHERE   F.empresa_id=$_SESSION[empresaId] $condicao AND A.ativo=0");
        }
        
        
        

        $this->pesquisaHistorico();


        echo "<div id='listagens'>
             <h3>Hitorico de Acompanhamento</h3>";

        while ($list = $listaOperador->fetch(PDO::FETCH_OBJ)) {

           // $qtd = $this->conn->query("SELECT distinct id FROM agendamento_visita WHERE acompanhamento_id=$list->idAcom   $condAge AND ativo=0");

               $sqlConsulta = $this->conn->query("SELECT distinct A.id AS id_acom,A.data,A.hora,A.statusOcorrencia,A.ocorrencia_id,A.obs,A.resposta_id,C.nome AS cliente,V.id AS idVisita,V.gerente_vendas_id,V.vendedor_id,
                                                V.operador_id,F.id as idFunc,F.nome,F.perfil,P.nome AS produto,VP.status 
                                                               FROM acompanhamento AS A INNER JOIN  visita AS V ON V.id=A.visita_id
                                                               INNER JOIN funcionario AS F ON F.id=V.gerente_vendas_id 
                                                               INNER JOIN cliente AS C ON V.cliente_id=C.id
                                                               INNER JOIN visita_produto AS  VP ON VP.visita_id=V.id
                                                               INNER JOIN produto AS P ON P.id=VP.produto_id
                                                               WHERE  V.operador_id=$list->id
                                                             
                                     		                AND A.ativo=0
                                                                AND V.ativo=0
                                                                AND F.ativo=0
                                                                 $condicao
                                                                AND F.empresa_id=$_SESSION[empresaId]
                                                                order by  A.id desc");
               
               
              $listaAgendados=  $this->conn->query("SELECT count(AG.acompanhamento_id) AS conta FROM agendamento_visita AS AG INNER JOIN 
                                                    acompanhamento AS AC ON AG.acompanhamento_id=AC.id
                                                    INNER JOIN visita AS V ON  V.id=AC.visita_id
                                                    WHERE V.operador_id=$list->id AND AG.ativo=0 AND AC.ativo=0 GROUP BY V.operador_id");
            $contaAgendados=$listaAgendados->fetch(PDO::FETCH_OBJ);
               
            echo "<div class='accordionButton'>$list->nome ( Operador de Telemarketing) <br/>- Quantidade Acompanhados:" . $sqlConsulta->rowCount() . "<br/> - Quantidade Agendados:$contaAgendados->conta</div>
                        <div class='accordionContent'>";

         
            if ($sqlConsulta->rowCount()) {
                echo "<table>
   			<th>Id </th>
                            <th>cliente</th>
                            <th>Gerente De Vendas</th>
                            <th>Vendedor</th>
                            <th>Produto</th>
                            <th>Status</th>
                            <th>Obs</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Agendado</th>
                            <th>Ocorr&ecirc;ncia</th>
                            <th>Resposta Automatica</th>";

                if ($_SESSION["tipo"] == 0 || $_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 2 || $_SESSION["tipo"] == 4) {
                    echo "	<th colspan=2>Ação</th>";
                }
                echo "</tr>";
                while ($l = $sqlConsulta->fetch(PDO::FETCH_OBJ)) {
                    $sqlVd = $this->conn->query("SELECT nome FROM funcionario WHERE id=$l->vendedor_id");
                    $lv = $sqlVd->fetch(PDO::FETCH_OBJ);
                    
                    
                     //verifica se existe resposta aumtomatica
                    if($l->resposta_id !=0){
                        
                        $listRespostaAutomatica=  $this->conn->query("SELECT R.id,R.resposta FROM respostaautomatica as R INNER JOIN funcionario as F ON  F.id=R.usuario_cadastro
                                                                   WHERE R.ativo=0 AND F.empresa_id=$_SESSION[empresaId] AND R.id=$l->resposta_id ");
                    
                        $exibirresposta=$listRespostaAutomatica->fetch(PDO::FETCH_OBJ);
                        $repostaAutomatica=$exibirresposta->resposta;
                    }else{
                        $repostaAutomatica="não possui";
                    }
                    
                    //verifica se foi agendado
                    $agendados = $this->conn->query("SELECT id FROM agendamento_visita WHERE acompanhamento_id=$l->id_acom AND ativo=0");
                    if ($agendados->rowCount()) {
                        $this->resposta = 'sim';
                    } else {
                        $this->resposta = 'não';
                    }
                    //verifica se a existe ocorrencia		
                    if ($l->statusOcorrencia == 0) {
                        $ocorrencia = "<a href='?pg=ocorrenciaAcompanhamento&id=$l->id_acom&tabela=acompanhamento' title='adicionar ocorrencia'>adicionar</a> ";
                    } else if ($l->statusOcorrencia == 1) {
                        $c = $this->conn->query("SELECT id,cargo_responsavel FROM ocorrencia WHERE id=$l->ocorrencia_id");
                        $r = $c->fetch(PDO::FETCH_OBJ);
                        $ocorrencia = "";
                         if ($r->cargo_responsavel == $_SESSION["nmCargo"] || $_SESSION["tipo"] == 0 || $_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 2) {
                             $ocorrencia = "<a href='?pg=resolverOcorrencia&id=$l->id_acom&tabela=acompanhamento'>Resolver</a> ";
                         }
                       
                    }
                    if ($l -> status == 0) {
                      $status = '<img src="imagens/status_vendido.png" alt="Vendido" title="Vendido" />';
                      } elseif ($l -> status == 1) {
                      $status = '<img src="imagens/status_quente.png" alt="Quente" title="Quente" />';
                      } elseif ($l -> status == 2) {
                      $status = '<img src="imagens/status_morno.png" alt="Morno" title="Morno" />';
                      }
                    echo "<tr> <td>$l->id_acom</td>
                        <td>$l->cliente</td>               
                        <td>$l->nome</td>
                        <td>$lv->nome</td>    
                        <td>$l->produto</td>                
                          <td>$status</td>     
                          <td>$l->obs</td>
                          <td>" . formata_data($l->data) . "</td>
                          <td>$l->hora</td>    
                          <td>$this->resposta</td>
                         <td>$ocorrencia</td>
                         <td>$repostaAutomatica</td>";
                    if ($_SESSION["tipo"] == 0 || $_SESSION["tipo"] == 1 || $_SESSION["tipo"] == 2 || $_SESSION["tipo"] == 4) {
                        echo "<td>
                                   <a href='?pg=visualizarAcom&acom=$l->id_acom'><img src='imagens/view.png' title='visualizar visita'/></a>  
                                   <a href='?pg=editarAcom&idAcom=$l->id_acom'><img src='imagens/edita.png' title='editar'/></a>
		                   <a href='#' onclick='excluir($l->id_acom)'><img src='imagens/excluir.gif' title='excluir'/></a></td>";
                    }
                    echo " </tr>";
                }
                echo " </table>";
            } else {
                echo "<p>N&atilde;o foi feito  nenhum acompanhamento!</p>";
            }

            echo "</div>";
        }

        echo "</div>";
        echo "<a href='?pg=acompanha'>Voltar</a>";
    }
    function excluir($id) {

        $exc = $this->conn->exec("UPDATE acompanhamento SET ativo=-1 WHERE id=$id");
        if ($exc) {
            echo "<script type='text/javascript'>alert('ExclusÃ£o feita com sucesso')
                  location.href='?pg=acompanha';
                    </script>";
            }
        }

}
?>
