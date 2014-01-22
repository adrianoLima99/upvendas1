<?php

class EdicaoProduto {

    
  public $id;
    private $conn;
    private $nome;
    private $valor;
    private $descricao;
    
    

    function __construct() {
        $this->conn = new connection;
    }

    function frmEdicao($id) {
        $this->id=$id;
        

       $consulta =$this->conn->query("SELECT * FROM produto WHERE id=$this->id AND empresa_id=$_SESSION[empresaId]");
       $linhas = $consulta->fetch(PDO::FETCH_OBJ);

        echo "<h3>Atualizar Produto</h3>
      
       <div id='formularios'>
       <a href='?pg=listaProduto'>Voltar</a>
         <form method='post' action='#' >
          <fieldset>
           <table>
             <tr>
                
                <td><input type='hidden' name='codigo' value='$this->id'/></td>
               </tr>
               <tr> <td>Produto:</td>
                <td><input type='text' name='nome' value='$linhas->nome '/></td>
              </tr>
              
                 <td>Valor</td>
                 <td><input type='text' name='valor' value='$linhas->valor' id='valor'  onkeypress='reais(this,event);' onkeydown='backspace(this,event)' maxlength='15'  placeholder='Digite o valor do veiculo' title='digite o valor refente ao veiculo'/></td>
                     
               </tr>
               <tr><td>Descrição:</td><td><textarea cols='30' rows=15 name=descricao>$linhas->descricao</textarea></td></tr>
               <tr>
                  <td>Ano:</td><td><input type='text' name='ano' value='$linhas->ano' maxlength='4' placeholder='formato, ex: 9999' required/></td>
               </tr> 
               <tr>
                  <td><input type='submit' name='atualizar' value='Atualizar' class='botao'/</td>
                </tr>
             </table>
           </fieldset> 
          </form>
          
        </div>";
        if (isset($_POST['atualizar'])) {
            $this->atualizaProduto($_POST['codigo'], $_POST['nome'], $_POST['valor'],$_POST['descricao'],$_POST['ano']);
        }
    }

    
    
    function atualizaProduto($id, $nome,$valor,$descricao,$ano) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao=$descricao;
        $this->valor = removeMascaraNum($valor);
        $data_criacao = date("Y-m-d");
     
        $alteracao = $this->conn->exec("UPDATE   produto SET   nome='$this->nome',valor=$this->valor,data_cadastro='$data_criacao',descricao='$this->descricao',ano='$ano'
                                         WHERE   id=$this->id AND empresa_id=$_SESSION[empresaId]") or die("DEU ERRO");
        if ($alteracao) {

          
            echo "<script type='text/javascript'>
       alert('Atualização Feita com sucesso');
       location.href='?pg=listaProduto';
      </script>";
        }
    }

}

?>
