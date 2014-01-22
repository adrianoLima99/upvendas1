<script type="text/javascript">

    function mensagem() {
        location.reload(true);
    }

    setInterval("mensagem()", 500000);

</script>

<?php
include_once "ListaVisitasGerente.class.php";
include_once "agendaOperador.class.php";

class FrmTeleOperador {

    private $operador;
    private $gerente;
    private $data;
    private $hora;
    private $dataIns;
    private $ontem;
    private $h;
    public $id_visita;
    private $conn;
    public $v;

    function __construct() {
        $this->conn = new connection;
    }

    function associar() {

        include_once "AssociacaoAutomatica.class.php";
    }

   

    function frmGerenteOperador() {

        echo "<div id='formularios'>";
        if ($_SESSION["tipo"] < 5) {
            $sqlVisita = $this->conn->query("SELECT V.id FROM visita AS V INNER JOIN funcionario AS F ON V.gerente_vendas_id=F.id
                                                WHERE V.operador_id=0 AND V.ativo=0 AND F.empresa_id=$_SESSION[empresaId]");
            if ($sqlVisita->rowCount()) {
                echo " <fieldset>
                           <legend>Associação</legend>
                            <form action='?pg=automatica' method='post'>
                              <table>
                                <tr>
                                    <td><input type='submit' name='associar' value='Automatica' class='botao'  title='Associação Automatica'/>
                                    <input type='button' name='manual' class='botao' value='Manual' title='Associação manual' onclick='MostraDiv();'/></td>
                                </tr>
                               </table> 
                            </form>
                           </fieldset> 
                           ";
            }
        }
      echo "<br/>
             <br/><div id='conteudo2' style='display:block'>
               <fieldset> 
          	 <legend>Pesquisa Associações </legend>
	             <form action='#' method='post'>
	                 <table>
                             <tr>
		              	 <td>Id da Visita:</td>
		              	 <td><input type='number'  name='id' placeholder='insira um id da visita'/></td>
		              </tr>
		              <tr>
		               	<td>Periodo de Inserção:</td>
		    		<td><input type='text' name='data1' class='data' placeholder='insira a data' style='width:100px'/>A
		    	            <input type='text' name='data2' class='data' placeholder='insira a data'  style='width:100px'/>
		    		</td>
		             </tr>
		               <tr>
                                        <td>Operador Telemarketing</td>
                                        <td><select name='operador' id='operador'>
                                                    <option value=''>Selecione</option>";
        $sqlG = $this->conn->query("SELECT id,nome FROM funcionario  WHERE ativo=0 AND perfil=5 AND empresa_id=$_SESSION[empresaId] ");
        while ($rs = $sqlG->fetch(PDO::FETCH_OBJ)) {
            echo "                          <option value='$rs->id'>$rs->nome</option>";
        }
        echo "                   </select> </td>
                              </tr>
                              <tr>
                                 <td></td>
		                  <td><input type='submit' name='encontrar' class='botao' value='pesquisar'/></td>
		'            </tr>
            		 </table>
          	 </form>
        </fieldset>
      </div> 
     <br/>
    
   ";

       //associacao manual 
     echo  "<div id='conteudo' style='display:none'>
                <fieldset> 
          	 <legend> Associaçao Manual </legend>
	             <form action='?pg=associacaomanual' method='post'>
	                 <table>
                             <tr>
		              	 <td>Gerente Vendas:</td>";
                                    $sqlGerente = $this->conn->query("SELECT id,nome FROM funcionario WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] AND perfil=3 ");
                             echo "<td><select name='gerente' id='gerente' onchange='selecionaVendedor()'>
                                        <option value=''>Selecione</option>";
                                    while ($rowGerente = $sqlGerente->fetch(PDO::FETCH_OBJ)) {
                                     echo " <option value='$rowGerente->id'>$rowGerente->nome</option>";
                                    }
                             echo " </select></td>
		              </tr>
		              <tr>
		               	<td>Vendedor</td>
		    		<td><select name='vendedor' id='exibir'>
                                    <option></option>
                                   </select></td>
		             </tr>
                             
                             <tr>
                                <td>Telefonia</td>
                                <td><select name='telefonia'>
                                      <option value=''>Selecione</option>  
                                      <option value='1'>OI</option>
                                      <option value='2'>TIM</option>
                                      <option value='3'>CLARO</option>
                                      <option value='4'>VIVO</option>
                                      <option value='5'>Fixo</option>
                                   </select></td>
                             </tr>
                             <tr>
                                <td>Status</td>
                                <td><select name='status'>
                                    <option value=''>Selecione</option>
                                     <option value='1'>Quente</option>
                                      <option value='2'>Morno</option>
                                    </select></td>
                             </tr>
                             <tr>
                                <td>Operador Telemarketing</td>
                               <td><select name='operador' id='operador' required>
                                               <option value=''>Selecione</option>";
                                                 $listaOperador=  $this->conn->query("SELECT id,nome FROM funcionario WHERE perfil=5 AND ativo=0 AND empresa_id=$_SESSION[empresaId]"); 
                                                 while($exibiOperador=$listaOperador->fetch(PDO::FETCH_OBJ)){
                                                     echo "<option value='$exibiOperador->id'>$exibiOperador->nome</option>";
                                                 }
                                                 
                        echo "        </select></td>
                              </tr>
                             <tr>
                                <td></td>
                                <td><input type='submit' name='enviar' value='associar' class='botao' /></td>
                            </tr>
                         </table>   
                       </form>
                     </fieldset>  
                 </div>";
       //fim associacao manual 
        
        if ($_SESSION["tipo"] != 5) {
            $listaQtd = $this->conn->query("SELECT V.operador_id,count(V.operador_id) AS contador,F.nome 
                                                   from visita AS V INNER JOIN funcionario AS F ON V.operador_id=F.id
                                                    where V.acompanhado=0 AND F.ativo=0 AND V.ativo=0 AND F.empresa_id=$_SESSION[empresaId] GROUP BY V.operador_id");
       if($listaQtd->rowCount()){ 
            echo "<br/>
                   <div id='listagens'>
                     <table>
                         <tr>
                             <th>Operador Telemarketing</td>
                             <th>Quantidade</td>
                        </tr>";
                        while ($contador = $listaQtd->fetch(PDO::FETCH_OBJ)) {
                   echo "<tr>
                             <td>$contador->nome</th><td>$contador->contador</td>  </tr>";
                        }
            echo "</table>
                 </div>";
            }
        }
        echo "</div><br/>";

        if (isset($_POST['encontrar'])) {

            include_once "telemarketing/pesquisaDetalhada.class.php";
            $obj = new Pesquisa();
            $obj->listagemGerente($_POST['id'], $_POST['operador'], $_POST['data1'], $_POST['data2']);
        }
    }

   
}

$obj = new FrmTeleOperador();
$obj->frmGerenteOperador();
//$obj->consulta();
$obj3 = new AgendaOperador();
$obj3->agendados();
$obj2 = new ListaVisitaGerente();
$obj2->listagemGerente();
?>