<?php

class RedefinirSenha
{
private $conn;
private $novaSenha;
private $id;
function __construct()
 {
  $this->conn = new connection;
 }
 function novaSenha($id)
 {
      $this->id = $id;
     
     $consulta = $this->conn->query("SELECT funcionario_id,nome FROM usuario WHERE funcionario_id=$this->id  AND ativo=0");
     
     if($consulta->rowCount()){
         $row=$consulta->fetch(PDO::FETCH_OBJ);
     
        echo "<br/><div id='formularios'>
                <fieldset>
                  <legend>Cadastrar usuários</legend>
                    <form action='#' method='post'>
                       <table>
                         <tr>
                          <td>Usuario</td><td><input type='text' name='usuario' value='$row->nome' /></td>
                        </tr>
                        <tr>
                          <td>Nova Senha:</td><td><input type='password' name='senha'  placeholder='Digite Nova Senha'  required /></td>
                        </tr>
                         <tr>
                          <td>Repetir  Senha:</td><td><input type='password' name='confSenha' placeholder='Digite Novamente Nova Senha' required/></td>
                        </tr>
                        <tr>
                        <td colspan='2'><input type='submit' name='redefinir' value='Redefinir Agora' class='botao'/></td>
                        </tr>
                     </form>
                   </fieldset>  
                 </div>";
        if(isset($_POST['redefinir']))
         {

          $this->novaSenha=hash("SHA512","$_POST[senha]");

            $atualizacao = $this->conn->exec("UPDATE usuario SET senha='$this->novaSenha',nome='$_POST[usuario]'  WHERE funcionario_id=$this->id 
                                               AND ativo=0")or die("erro de atualização");
            if($atualizacao){

             echo "<script type='text/javascript'>alert('Senha atualizada com sucesso!')
                      location.href='?pg=listaFuncionario' 
                   </script>";
              $this->conn=null;
             }
           }
        }else{
            echo "<br/><br/>
                   <div id='formularios'> 
                    <fieldset>   
                             <h1 style=text-align:center;color:red>Aten&ccedil;&atilde;o :</h1>
                             <h2 style=text-align:center;color:red>
                                    Esse funcionario ainda não possui usuario e senha Voc&ecirc; deve primeiro cadastra um nome de usuario e uma senha
                                    pra ele!<br/>,<a href='?pg=novoUsuario'>Ir para pagina</a>
                            </h2>
                     </fielset>    </div>   ";
        }
     }
 }
?>
