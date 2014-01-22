
<script type="text/javascript" src="ajax/listaCidades.js"></script>

<div id="formularios">

    <fieldset>
        <legend>Novo Cliente</legend>
        <p style="color:red;font-size:18px">Campos Obrigatorios:*</p>
        <form action="?pg=salvarPs" method="post">
            <table>
                <tr>
                    <td>Nome Cliente:</td>  
                    {if isset($smarty.get.nome )}
                        <td><input type="text" name='nome'  placeholder='Digite No Cliente' value="{$smarty.get.nome}" required/></td><td style="color:red">*</td>
                        {else}
                        <td><input type="text" name='nome'  placeholder='Digite No Cliente' required/></td><td style="color:red">*</td>
                        {/if}
                </tr>
                <tr>
                    {if isset($smarty.get.identificador) && ($smarty.get.pessoa eq "f")}
                        <td>CPF:</td><td><input type="text" name="cpf"  onkeypress='return valCPF(event,this);return false;' placeholder='numero cpf' value='{$smarty.get.identificador}' maxlength='14'/></td>
                        <td><input type="hidden" name="pessoa" value="f"/></td>
                <tr>
                        <td>Sexo:</td>
                         <td><select name='sexo' required>
                                 <option value=''>Selecione o sexo</option>
                                 <option value='f'>Feminino</option>
                                 <option value='m'>Masculino</option>
                             </select>
                         </td>
                </tr>
                <tr>
                     <td>Data de Nascimento:</td><td><input type='text' name='nasc' id="nasc"  maxlength='10' placeholder='Data de Nascimento' /></td>
                </tr>
                    {else if isset($smarty.get.identificador) && ($smarty.get.pessoa eq "j")}
                     <tr><td>CNPJ:</td>
                         <td><input type="text" name="cnpj" onkeypress='return valCNPJ(event,this);return false;'  placeholder='numero cnpj' value='{$smarty.get.identificador}' maxlength='18' /></td>
                         <td><input type="hidden" name="pessoa" value="j"/></td>
                     </tr>
                     <tr>
                         <td>Razão Social:</td>
                          <td><input type="text" name="razao"  placeholder='infrome a razão social' /></td>
                     </tr>
                    {else}

                        <td>Tipo de  Pessoa :</td>
                        <td><select name="pessoa" id="pessoa" onchange="habilitaDesabilita(this)" required>
                                <option value="">Selecione o tipo</option>
                                <option value="f">Pessoa Fisica</option>
                                <option value="j">Pessoa Juridica</option>
                            </select>
                        </td><td style="color:red">*</td>


                    </tr>  
                </table>
                <table id="tbFisica" style="display:none">    
                    <tr>

                        <td>Numdero do Cpf: </td>
                        <td ><input type='text' name='cpf'  onkeypress='return valCPF(event,this);return false;' placeholder='numero cpf' maxlength='14'/></td>

                    </tr>
                    <tr>

                        <td>Data de Nascimento</td>
                        <td><input type='text' name='nasc' id="nasc" maxlength='10' placeholder='digite a data nascimento' /></td>

                    </tr>
                    <tr> 
                        <td>Sexo.:</td>
                        <td><select   name='sexo'>
                                <option value="">sexo do cliente </option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>	
                        </td>

                    </tr>  
                </table>
                <table id="tbJuridica" style="display:none">   
                    <tr>
                        <td>Numero do CNPJ : </td>
                        <td><input type='text' name='cnpj'   onkeypress='return valCNPJ(event,this);return false;'  placeholder='numero cnpj' maxlength='18' /></td>
                    </tr> 
                     <tr>
                        <td>Razão Social  :</td>
                        <td><input type='text' name='razao'    placeholder='razao social'  /></td>
                    </tr> 
                  
                {/if}  
            </table>
            <table>    
                <tr> 
                    <td> Endere&ccedil;o:</td><td><input type="text" name="end" id="end" placeholder='rua,avenida..' /></td><td style="color:red">*</td>
                </tr>
                <tr>
                    <td>UF:</td><td><select name="uf" id="uf" onchange="listaCidades()"  >
                          <option>Selecione o estado</option>  
                         {html_options  values=$idEstado output=$estado}
                        </select></td><td style="color:red">*</td>
                </tr>
                <tr>
                    <td>Cidade:</td>
                    <td><select name="cid" id="municipio" >
                            <option></option>
                        </select></td><td  style="color:red">*</td>
                </tr>
                <tr>    
                    <td>Bairro:</td><td><input type="text" name="bairro" id="Bairro" required placeholder='digite o nome do bairro'/></td><td  style="color:red">*</td>
                </tr>

                <tr>
                    <td>Email:</td><td><input type="email" name="email" placeholder='digite o email do cliente' /></td>
                </tr>

                <tr>
                    <td>Operadora telefonia</td>
                    <td><select name="opTelefonia" required="required">
                            <option value="">Selecione</option>
                            {html_options  values=$id output=$nome}
                        </select>
                    </td><td  style="color:red">*</td>
                </tr>    

                <tr>
                    <td>Telefone Fixo:</td>
                    {if isset($smarty.get.fone)} 
                        <td><input type="text" name="telefone" value="{$smarty.get.fone}" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td><td  style="color:red">*</td>
                        {else}
                        <td><input type="text" name="telefone" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td><td  style="color:red">*</td>
                        {/if}
                </tr>
                <tr>
                    <td>Celular 1:</td><td><input type="text" name="cel1" onkeypress='return valPHONE(event,this);return false;'  maxlength='13'  /></td>
                </tr>
                <tr>
                    <td>Celular 2:</td><td><input type="text" name="cel2" onkeypress='return valPHONE(event,this);return false;'  maxlength='13' /></td>
                </tr>
                <tr>
                    <td></td>  <td><input type="submit" name="enviar" value="salvar" class="botao"/>


                </tr>


            </table>


        </form>
        <a href="?pg=listaDeCliente">Voltar</a>            
    </fieldset>            
</div>