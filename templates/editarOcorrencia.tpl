
<div id="formularios">
    <fieldset>
        <legend>Editar Ocorrencia	</legend>
        <table>
            <form action="?pg=salvarEdicaoOcorrencia" method="post">
                <tr>
                <input type="hidden" name="id" value="{$smarty.get.id}" />
                <td>Ocorrencia</td>
                <td><input type="text" name="nome" value="{$smarty.get.ocorrencia}" required/></td>
                </tr>
                <tr>
                    <td>Descricao</td>
                    <td><textarea name="descricao" cols="40" rows="20" required>{$smarty.get.descricao}
                        </textarea>	
                    </td>
                </tr>
                <tr>
                    <td>Responsavel:</td>
                    <td><select name="responsavel" required >
                            <option value="{$smarty.get.idCargo}">{$smarty.get.cargo}</option>
                            {html_options  values=$id output=$nome}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="cadastrar" name="cadastrar" class="botao"/></td>
                </tr>

            </form>

        </table>
    </fieldset>
</div>	