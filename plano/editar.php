<?php
class Editar{
    private $conn;
    
   public function __construct() {
        $this->conn = new connection;
   }
   public function frmEditar($id){
       $selPlano=$this->conn->query("SELECT * FROM plano WHERE id=$id");
       $list=$selPlano->fetch(PDO::FETCH_OBJ);
       ?>
       <br/><br/>
        <div id="formularios">
         <fieldset>
          <legend>Edição Plano</legend> 
           <form method="post" action="#">
             <table>
                
                 <tr>
                    <td>Plano:</td><td><input type="text" name="plano" placeholder="nome do plano" value="<?php echo $list->nome;?>"/></td>
                      <input type="hidden" name="id" value="<?php echo $list->id;?>"/></td> 
                </tr>
                 <tr>
                    <td>Meses:</td><td><input type="text" name="meses" placeholder="quantidade de meses" value="<?php echo $list->meses;?>"/></td>
                </tr>
                <tr>
                    <td></td><td><input type="submit" name="atualizar" value="atualizar" class="botao"/></td>

                </tr>
            </table>
         </form>   
      </fieldset>
   </div>   
    
 <?php
    if(isset($_POST["atualizar"])){
        $this->salvarEdicao($_POST["id"], $_POST["plano"],$_POST["meses"]);
   }
 }
    public function salvarEdicao($id,$nome,$meses){
        $salve=$this->conn->exec("UPDATE plano SET nome='$nome',meses='$meses' WHERE id=$id");
         if($salve){ 
           echo "<script type='text/javascript'>
                        alert('Atualização feita com sucesso');
                        location.href='?pg=listaPlano';
                </script>";
        }
        
    }
    public function excluir($id){
        $excluido=  $this->conn->query("DELETE FROM plano WHERE id=$id");
        if($excluido){ 
           echo "<script type='text/javascript'>
                        alert('Registro excluido  com sucesso');
                        location.href='?pg=listaPlano';
                </script>";
        }
    }
}

?>
