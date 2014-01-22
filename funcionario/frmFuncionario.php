<script type="text/javascript" src="ajax/listaCidades.js"></script>
<?php
include_once("Estado/Estado.php");
class FrmFuncionario{

    function __construct() {
        $this->conn = new connection;
    }
    public function frmFUncionario(){
 ?>
<div id="formularios">
    
<fieldset>
    <legend>Cadastro de Funcionários</legend>
    <form method="post" action="?pg=adicionarFunc" enctype="multipart/form-data">
        <table>
         <tr>
          
           <?php if($_SESSION["tipo"]==0){?>
             
            <tr>
                 <td>Empresa:</td>
                    <td><select name="cliEmpresa" id="cliEmpresa">
                          <option>Selecione o empresa</option>     
                            <?php
                             $queyEmpresa=$this->conn->query("SELECT id,nome FROM empresa WHERE ativo=0");
                             while($list=$queyEmpresa->fetch(PDO::FETCH_OBJ)){
                                 echo "<option value='$list->id'>$list->nome</option>";
                             }
                           ?>  
                
                         </select>
                 </td>
             </tr> 
            <td>Cargo:</td>
               <td><select name="cargo" onchange="selecionaPerfil()" id="perfil" required>   
                        <option value=''>selecione cargo</option>
                         <option value="1">Administrador Master</option>
                        <option value="2">Administrador</option>
                        <option value="3">Gerente de Vendas</option>
                        <option value="4">Gerente de TeleMarketing</option>
                        <option value="5">Operador de Telemarketing</option>
                        <option value="6">vendedor</option>
                   </select>   
                </td>  
             
             <tr>
                 
             <!--  MASTER-->
           <?php }else if($_SESSION["tipo"] == 1){ ?>
              <input type="hidden" name="cliEmpresa" value="<?php echo $_SESSION["empresaId"];?>" id="cliEmpresa"/>
                <td>Cargo:</td>
                <td><select name="cargo" onchange="selecionaPerfil()" id="perfil" required>   
                        <option value=''>selecione cargo</option>
                        <option value="2">Administrador</option>
                        <option value="3">Gerente de Vendas</option>
                        <option value="4">Gerente de TeleMarketing</option>
                        <option value="5">Operador de Telemarketing</option>
                        <option value="6">vendedor</option>
                    </select><span style='color:red;'>*</span>
                </td>
    
                <!-- adminsitrador-->
           <?php }else if($_SESSION["tipo"] == 2){ ?>
              <input type="hidden" name="cliEmpresa" value="<?php echo $_SESSION["empresaId"];?>" id="cliEmpresa"/>
                <td>Cargo:</td>
                <td><select name="cargo" onchange="selecionaPerfil()" id="perfil" required>   
                        <option value=''>selecione cargo</option>
                        <option value="3">Gerente de Vendas</option>
                        <option value="4">Gerente de TeleMarketing</option>
                        <option value="5">Operador de Telemarketing</option>
                        <option value="6">vendedor</option>
                    </select><span style='color:red;'>*</span>
                </td>

                <!--GERENTE DE VENDAS-->
           <?php }else if($_SESSION["tipo"] == 3){?>
                
                    <td> <td><input type="hidden" name="cargo" value="6"/></td></td>   
                    
               <!--GERENTE DE TELEMARKETING-->
           <?php }else if($_SESSION["tipo"]== 4){?>

                <td><input type="hidden" name="cargo" value="5"/></td>
                
           <?php }?>
            </tr>
            <tr>
                <td>Nome:</td>
                <td>

                    <input type="text" name="nome" placeholder="Digite o nome" required/>
                    <span style='color:red;'>*</span></td>
            </tr>
            <tr>
                <td>Sexo:</td>
                <td><select name="sexo" placeholder="Digite o nome" required>
                        <option value="">Selecione o sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                    <span style='color:red;'>*</span></td>
            </tr>

            <tr>
                <td>Cpf:</td>
                <td>
                    <input type="text" name="cpf" placeholder="Digite o CPF"  placeholder='numero cpf' title='digite o numero do CPF'   onkeypress='return valCPF(event,this);return false;' maxlength="14"/>
                </td>
            </tr>
             <tr>
                <td>PIS:</td>
                <td>
                    <input type="text" name="pis" placeholder="Digite o PIS"  placeholder='numero PIS' title='digite o numero do PIS'  />
                </td>
            </tr>
            <tr>
                    <td>Salário R$:</td>
                 <td><input type='text' name='salario'  id='valor'  maxlength='15'  placeholder='Digite o valor do salario' title='digite o valor refente ao veiculo' required/></td>
                     
               </tr>
            <tr>
                <td>Foto:</td>
                <td>
                    <input type="file" name="foto" id="foto" />
                </td>
            </tr>
                  
                <tr>
                   <!--Gerente de vendas ou telemarketing--> 
                 <?php if($_SESSION["tipo"]== 3 || $_SESSION["tipo"]== 4 ){?>
                     <td><input type="hidden" name="superior" value="<?php echo $_SESSION["func_id"];?>"/></td>
                 
                 <?php }else{?>   
                    <td>Superior:</td>
                    <td><select name='superior' id="retornaPerfil">
                            <option></option>   
                        </select>
                    </td>

                 <?php }?>  
                </tr>
            <tr>
                <td>Fone</td><td>
                    <input type="tel" name="tel" class='tel' placeholder="Digite o telefone" required/><span style='color:red;'>*</span></td>

            </tr>
            <tr>
                <td>Email</td><td>
                    <input type="email" name="email" id="email" placeholder="Digite o e-mail" />
                </td>
            </tr>
            <tr>
                <td>Logradouro:</td><td>
                    <input type="text" name="lograr" id="lograr" placeholder="Digite o nome da rua" />
                </td>
            </tr>
            <tr>
                <td>Número:</td><td>
                    <input type="text" name="numero" id="numero" placeholder="Digite o número" />
                </td>
            </tr>
            <tr>
                <td>Complemento:</td><td>
                    <input type="text" name="complemento" placeholder="Digite o complemento" id="complemento" />
                </td>
            </tr>
            <tr>
                <td>Uf:</td><td>
                    <select name="estado" id="uf" onchange="listaCidades()" required>
                        <option>Selecione o estado</option>  
                        <?php
                            $estado= new Estado();
                            $estado->lista();
                                    
                        ?>
                    </select> <span style='color:red;'>*</span></td>
            </tr>
            <tr>
                <td>Municipio:</td><td>
                    <select name="cidade"  id="municipio" required>
                        <option></option>
                    </select><span style='color:red;'>*</span></td>
            </tr>

            <tr>
                <td>Bairro:</td><td>
                    <input type="text" name="bairro" id="bairro" placeholder="Digite o nome bairro" />
            </tr>

            <tr>
                <td>Data Nascimento:</td><td>
                    <input type="text" name="nasc" id="nasc" placeholder="Digite a data de nascimento" />
                 
            </tr>

            <tr>
                <td>Data Admissão:</td><td>
                    <input type='text' name='creden' class='data' placeholder='Digite a data de admissão' required/>
                    <span style='color:red;'>*</span>
                <td><input type='hidden' name='pg' value=''/></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="botao" name="cadastrar" id="cadastrar" value="cadastrar"/>
                </td>
            </tr>

    </form>
</tr>

</table>
</fieldset>                    
</div>        
<?php 
 }
} ?>        
        
 