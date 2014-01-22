
<br/>
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<div id="formularios">
    <fieldset>
        <legend>
           
           <h3> Empresa</h3>
                    
        </legend>
        <form name="clienteSistema"  action="?pg=salvarEmpresa" method="post"  enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Nome:</td><td><input type="text" name="empresa" required="required" placeholder='Digite nome da empresa' /><span style='color:red;'>*</span></td>
                </tr>
               <tr>
                   <td>Razão Social:</td><td><input type='text' name='razao' required  placeholder='Digite razão social'/><span style='color:red;'>*</span></td>
		</tr>
		<tr>
                   <td>Cnpj:</td>
                  <td><input type='text' name='cnpj' onkeypress='return valCNPJ(event,this);return false;'  placeholder='Digite numero CNPJ' maxlength='18'  /></td>
                </tr>
                <tr>
                   <td>Responsavel:</td><td><input type='text' name='responsavel' placeholder='Digite nome do responsavel pela empresa' required /><span style='color:red;'>*</span></td>
		</tr>
                <tr>
                    <td>Foto:</td><td><input type="file" name="foto"   /></td>
                </tr>          
                <tr>
                    <td>Telefone</td>
                    <td><input type="tel" name="tel" class='tel' placeholder="Digite o telefone" required/><span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" id="email" placeholder="Digite o e-mail" /></td>
                </tr>
                <tr>
                    <td>Endere&ccedil;o:</td>
                    <td><input type="text" name="endereco" id="lograr" placeholder="Digite o nome da rua" /></td>
                </tr>
                <tr>
                    <td>Número:</td>
                    <td><input type="number" name="numero" id="numero" placeholder="Digite o número" /></td>
                </tr>
                <tr>
                    <td>Complemento:</td>
                    <td><input type="text" name="complemento" placeholder="Digite o complemento" id="complemento" /></td>
                </tr>
                <tr>
                    <td>Uf:</td>
                    <td><select name="estado" id="uf" onchange="listaCidades()" required>
                           <option>Selecione o estado</option>  
                        {html_options  values=$idEstado output=$estado}
                        </select> <span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Municipio:</td>
                    <td><select name="cidade"  id="municipio" required>
                            <option></option>
                        </select><span style='color:red;'>*</span></td>
                </tr>
                <tr>
                    <td>Bairro:</td>
                    <td><input type="text" name="bairro" id="bairro" placeholder="Digite o bairro" />
                </tr>
               <tr>
                    <td>Usuario:</td>
                    <td><input type="text" name="usuario" id="usuario" placeholder="Digite o nome de usuario" required/><span style='color:red;'>*</span>
                </tr> 
                <tr>
                    <td>Senha:</td>
                    <td><input type="password" name="senha" id="senha" placeholder="Digite o senha" required/><span style='color:red;'>*</span>
                </tr>
                <tr>
                    <td>Confirmar senha:</td>
                    <td><input type="password" name="confSenha"  placeholder="Digite o novamente a senha"  required/><span style='color:red;'>*</span>
                </tr>
                
                <tr>
                    <td><input type="submit" name="gravar" value="Salvar" class="botao"/></td>
                </tr>
            </table>
        </form>
    </fieldset>		
</div>