
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<div id="formularios">
    <h3>{$smarty.session.tipo}</h3>
<fieldset>
    <legend>Cadastro de Funcionários</legend>
    <form method="post" action="?pg=adicionarFunc" enctype="multipart/form-data">
        <table>
            <thead>
                Campos Obrigatorios(<span style='color:red'>*</span>)
        {if $smarty.session.tipo  eq 3}
         <p style=color:red>Atenção:certifique-se que o cargo vendedor esteja criado!</p>    
        {elseif $smarty.session.tipo  eq 4}
        
        {/if}
            </thead>
            <tr>
            <input type="hidden" name="cliEmpresa" value="{$smarty.session.empresaId}" id="cliEmpresa"/>
            <!--UPGRADE-->
            {if $smarty.session.tipo eq 0}
                <td>Cargo:</td>
               <td><select name="cargo" >
                        <option value="">Selecione Cargo</option>
                           {html_options  values=$idCargo output=$cargo}
                       </select>
                    </select> 
                </td>  
             <tr>
                 <td>Empresa:</td>
                 <td><select name="empresa">
                         <option>Selecione o empresa</option>  
                         {html_options  values=$idEmpresa output=$empresa}</select>
                 </td>
             </tr>
                <!--  MASTER-->
            {else if $smarty.session.tipo eq 1}  
                <td>Cargo:</td>
                <td><select name="perfil" onchange="selecionaPerfil()" id="perfil">   
                        <option>selecione perfil</option>
                        <option value="2">Administrador</option>
                        <option value="3">Gerente de Vendas</option>
                        <option value="4">Gerente de TeleMarketing</option>
                        <option value="5">Operador de Telemarketing</option>
                        <option value="7">vendedor</option>
                    </select></td>

                <!--ADMINISTRADOR-->
            {else if $smarty.session.tipo eq 2}
                <td>Cargo:</td>
               <!-- <td><select name="perfil" onchange="selecionaPerfil()" id="perfil">-->  
                     <td><select name="cargo">
                        <option value="">Selecione Cargo</option>
                           {html_options  values=$idCargo output=$cargo}
                       </select></td>   
                     <td> <span style='color:red;'>*</span> </td> 
                <!--GERENTE DE VENDAS-->
            {else if $smarty.session.tipo eq 3 }

                <td><input type="hidden" name="cargo" value="11"/></td>
                <!--GERENTE DE TELEMARKETING-->
            {else if $smarty.session.tipo eq 4}
                <td><input type="hidden" name="perfil" value="5"/></td>
                {/if}
          
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
                    <input type="text" name="cpf" placeholder="Digite o cpf"  placeholder='numero cpf' title='digite o numero do CPF'   onkeypress='return valCPF(event,this);return false;' maxlength="14"/>
                </td>
            </tr>
            <tr>
                <td>Foto:</td>
                <td>
                    <input type="file" name="foto" id="foto" />
                </td>
            </tr>
            {if $smarty.session.tipo>1}
                <tr>
                    <td>
                        <input type="hidden" name="superior" value="{$smarty.session.func_id}" />
                    </td>
                </tr> 
            {else}       
                <tr>
                    <td>Superior:
                    <td><select name='superior'>
                            <option></option>   
                        </select></td>

                    </td>
                </tr>
            {/if}  
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
                    <input type="text" name="lograr" id="lograr" placeholder="Digite a rua" />
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
                        {html_options  values=$idEstado output=$estado}
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
                    <input type="text" name="bairro" id="bairro" placeholder="Digite o bairro" />
            </tr>

            <tr>
                <td>Data Nascimento:</td><td>
                    <input type="text" name="nasc" id="nasc" placeholder="Digite a data de nascimento" />
                 
            </tr>

            <tr>
                <td>Data Admissão:</td><td>
                    <input type='text' name='creden' class='data' placeholder='Digite a data de crescimento' required/>
                    <span style='color:red;'>*</span>
                <td><input type='hidden' name='pg' value=''/></td>;
            </tr>";
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
