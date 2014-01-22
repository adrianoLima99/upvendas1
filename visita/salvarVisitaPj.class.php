<?php



class salvarVisita {

    private $id;
    private $status;
    private $motivo;
    private $produto;
    private $plano;
    private $vendedor;
    private $vendido;
    private $dataVenda;
    private $id_cliente;

    function __construct() {
        $this->conn = new connection;
    }

    function VisualizaCadastro($id) {
        //visibilidade do gerente
        if ($_SESSION['tipo'] == 1) {
            $visibilidade = " WHERE id=$_SESSION[id]";
        } else {
            $visibilidade = "";
        }
        //verifica a variavel passada via GET para realizar a busca  
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $consulta = $this->conn->query("SELECT * FROM cliente  where id_cliente=$id ");
        } elseif (isset($_GET['telefone']) && isset($_GET['nome'])) {
            $consulta = $this->conn->query("SELECT * FROM cliente  where tel_fixo='$_GET[telefone]' && nome='$_GET[nome]' ");
        } elseif (isset($_GET['cpf_Cnpj']) && isset($_GET['pessoa'])) {
            $consulta = $this->conn->query("SELECT * FROM cliente  where cpf_Cnpj='$_GET[cpf_Cnpj]' && pessoa='$_GET[pessoa]' ");
        }


        $l = $consulta->fetch(PDO::FETCH_OBJ);
        echo "<div id='formularios'>
      <fieldset>
         <legend>Dados Cliente</legend>
          <table>
          <tr>
         <form method='post' action='#'>
         <td> Nome:        </td><td>  <input type='text' name='nome'  value='$l->nome' readonly/> </td>
              <td><input type='hidden' name='id_cliente'  value='$l->id_cliente' /></td>
         </tr> 
         <tr>
          <td>Razao Social: </td><td> <input type='text' name='razao'  value='$l->razaoSocial' readonly/>                 </td>
          </tr> 
          <tr>
          <td> CNPJ:       </td><td> <input type='text' name='cnpj'  value='$l->cpf_Cnpj' readonly/>                      </td>
	  </tr> 
          <tr>
          <td>Responsavel: </td><td> <input type='text' name='responsavel'  value='$l->responsavel' readonly/>       </td>
          </tr> 
          <tr>
          <td> Endereco    </td><td> <input type='text' name='end'  value='$l->endereco' readonly readonly/>                  </td>
	  </tr> 
          <tr>
          <td> Bairro	  </td><td>  <input type='text' name='bairro'  value='$l->bairro'readonly/>                  </td>
	  </tr> 
          <tr>
          <td>cidade      </td><td>  <input type='text' name='cid'  value='$l->cidade'readonly/>                     </td>
	  </tr> 
          <tr>
          <td>UF :        </td><td>  <input type='text' name='uf'  value='$l->uf' readonly/>                          </td>  
	  </tr> 
         <tr>
          <td>Tel. Fixo:  </td><td>  <input type='text' name='fixo'  value='$l->tel_fixo' onLoad=formatatel(this.value,this) readonly/>                  </td>
	  </tr> 
          <tr>
          <td>	cel. 1	  </td><td> <input type='text' name='cel1'  value='$l->cel1' onLoad=formatatel(this.value,this) readonly/>                       </td>
          </tr> 
          <tr>
          <td> cel. 2	 </td><td>  <input type='text' name='cel2'  value='$l->cel2' onLoad=formatatel(this.value,this) readonly/>                       </td>
	</tr>
       </table>
        </fieldset>
        <fieldset>
        <legend>Dados Visita</legend>
        <table>
        <thead>Campos Obrigatorios(*)</thead>
        <tr><td> Data</td>
            <td><input type='text' name='data' class='data' required/></td><td>*</td>
	</tr>
            
         <tr>
             <td> valor da Carta: R$</td>
             <td><input type='tex' name='venda' value=''  onkeypress='reais(this,event);' onkeydown='backspace(this,event)' maxlength='15' required/> </td><td>*</td>
       </tr>
        <tr>
            <td>Status</td>
             <td><select  name='status' required>
						<option></option>
						<option value='0'>vendido</option>
                                                <option value='1'>quente</option>
						<option value='2'>morno</option>
							
			</select>
            </td><td>*</td>
         </tr>
         <tr>
            <td><span class='obs'> Obs:</span></td>
            <td><textarea rows='10' cols='35' name='motivo' required placeholder='Informações sobre a visita realizada'></textarea></td><td>*</td>
         </tr>
         <tr>
           <td>Gerente Vendas:</td>
           
                    <td><select  name='gerente' id='gerente'   onchange = selecionaVendedor()  >
                     <option></option> ";

        $sqlG = $this->conn->query("SELECT id,nome FROM gerente_vendas  $visibilidade");
        while ($row = $sqlG->fetch(PDO::FETCH_OBJ)) {
            echo " <option value='$row->id'>$row->nome</option>";
        }
        echo " </select></td><td>*</td>

                                </tr> <tr>    
                        	     <td>  Vendedor:</td>
                                     <td><select name='vendedor' id='exibir' required >
     </select></td><td>*</td>
       </tr>
       <tr>";
        $sqlplano = $this->conn->query("SELECT * FROM plano");
        echo "<td>Plano:</td><td><select name='plano' id='plano' >";
        while ($lp = $sqlplano->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$lp->id_plano'>$lp->nome_plano</option>";
        }


        echo "</select></td><td>*</td>
       </tr>
       <tr>";

        $sqlproduto = $this->conn->query("SELECT * FROM produto");
        echo "<td>Produto:</td><td><select name='produto' id='produto' >";
        while ($lprod = $sqlproduto->fetch(PDO::FETCH_OBJ)) {
            echo "<option value='$lprod->id_produto'>$lprod->nome_produto</option>";
        }


        echo "</select></td><td>*</td>
     </tr>
     <tr>";


        echo "<td></td><td>
			<input  type='submit' name='enviarVisita' value='Salvar' class='botao'></td>
  		</form>
                </tr>
                </table>
                </fieldset>
                </div>";
        if (isset($_POST['enviarVisita'])) {
          
            $this->salvaVisita($_POST['data'], $_POST['status'], $_POST['motivo'], $_POST['produto'], $_POST['plano'], $_POST['vendedor'], $_POST['id_cliente']);
        }
    }

        
    function salvaVisita($data, $status, $motivo, $produto, $plano, $vendedor, $id_cliente) {
        $this->data = formata_data_db($data);
        $this->status = $status;
        $this->motivo = $motivo;
        $this->produto = $produto;
        $this->plano = $plano;
        $this->vendedor = $vendedor;
        $this->id_cliente = $id_cliente;
      
        $data_insercao = date('Y-m-d');
        $hora_insercao = date('H:i:s');



        //procura pelo gerente responsavel pelo vendefor
        $sqlvd = $this->conn->query("SELECT id_vendedor,superior FROM vendedor where id_vendedor=$this->vendedor");
        $lvd = $sqlvd->fetch(PDO::FETCH_OBJ);
        //fim


        $this->sql = $this->conn->exec("INSERT INTO visita VALUES(null,
                                                                    '$this->data',
                                                                     $this->status,
                                                                     
                                                                      '$this->motivo',
                                                                      $this->vendedor,
                                                                      $this->plano,
                                                                      $this->produto,
                                                                      '$this->id_cliente',
                                                                       $lvd->superior,
                                                                      '$data_insercao',
                                                                      '$hora_insercao', 
                                                                       $_SESSION[id_login],0,0,0,$_SESSION[empresaId])") or die("erro");

        if ($this->status == 0) {

            $ultimaInsercao = $this->conn->query("SELECt * FROM visita  order by id_visita desc LIMIT 1");

            $id_vis = $ultimaInsercao->fetch(PDO::FETCH_OBJ);
            //insercao tabela vendas
            $hora = date('H:m:s');
            $this->conn->exec("INSERT INTO vendas VALUES(null,'$this->data','$hora',$this->produto,$id_vis->id_visita,'$data_insercao','$hora',$_SESSION[id_login],0,$_SESSION[empresaId])") or die("erro");

            echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                  location.href='?pg=visitados';
                    </script>";
        } else {
            echo "<script type='text/javascript'>alert('Dados Salvos com sucesso')
                  location.href='?pg=visitados';
                    </script>";
        }
    }

}

$obj = new salvarVisita;
$obj->VisualizaCadastro($_GET['id']);