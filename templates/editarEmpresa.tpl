
<script type="text/javascript" src="ajax/listaCidades.js"></script>
<div id="formularios">
    <fieldset>
        <legend>Editar Empresa</legend>
        <table>
            <form action="#" method="post">
                <tr>
                <input type="hidden" name="id" value="{$smarty.get.id}" />
                <td>Empresa</td>
                <td><input type="text" name="nome" value="{$nome}" placeholder="digite o nome da empresa" /></td>
                </tr>
                <tr>
                    <td>CNPJ</td>
                    <td><input type="text" name="cnpj" value="{$cnpj}"  onkeypress='return valCNPJ(event,this);return false;'  placeholder='Numero CNPJ' maxlength='18' /></td>
                </tr>
                
                <tr>
                    <td>Razão Social</td>
                    <td><input type="text" name="razao" value="{$razao}" /></td>
                </tr>
                <tr>
                    <td>Responsavel</td>
                    <td><input type="text" name="responsavel" value="{$responsavel}" placeholder="digite o nome do responsavel" /></td>
                </tr>
                
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="{$email}" placeholder="digite o email..ex:fictico@ficticio.com" /></td>
                </tr>
                <tr>
                    <td>Fone</td>
                    <td><input type="text" name="fone" value="{$fone}" maxlength="11" placeholder="digite apenas numeros.."/></td>
                </tr>
                <tr>
                    <td>Endereço</td>
                    <td><input type="text" name="endereco" value="{$logradouro}" placeholder="digite o  seu endereço" /></td>
                </tr>
                <tr>
                    <td>Bairro</td>
                    <td><input type="text" name="bairro" value="{$bairro}" placeholder="digite o bairro " /></td>
                </tr>
                 <tr>
                    <td>Complemento</td>
                    <td><input type="text" name="complemento" value="{$complemento}" placeholder="digite o complemento"/></td>
                </tr>
                 <tr>
                    <td>Numero</td>
                    <td><input type="number" name="numero" value="{$numero}" placeholder="digite o numero" /></td>
                </tr>
                
                 
                <tr>
                    <td>Estado</td>
                    <td><select name="estado"  id="uf" onchange="listaCidades()">
                            <option id="{$idUf}">{$estado}</option>
                             {html_options  values=$idEstado output=$estado}
                        </select>
                           
                    </td>
                </tr>
               
                <tr>
                    <td>Municipio</td>
                    <td><select name="municipio" id="municipio" >
                            <option value="{$idMunc}">{$municipio}</option>
                        </select>
                           
                    </td>
                </tr>
              <tr>
                    <td>Data Cadastro</td>
                    <td><input type="text" name="data" value="{$dataCadastro}" placeholder="digite o numero" class='data' /></td>
                </tr>
                
                <tr>
                    <td><input type="submit" value="gravar" name="atualizar" class="botao"/></td>
                </tr>
                
            </form>

        </table>
                <a href="?pg=listaEmpresa">Voltar</a>     
    </fieldset>
</div>	