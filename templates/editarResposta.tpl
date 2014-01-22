<br/>
<div id="formularios">
	<fieldset>
            <legend>Editar Resposta	</legend>
	      <table>
		 <form action="#" method="post">
		   <tr>
		       <input type="hidden" name="id" value="{$smarty.get.id}" />
			<td>Resposta</td>
			<td><input type="text" name="resposta" value="{$smarty.get.resposta}" required/></td>
            	   </tr>
		   <tr>
			<td>Descri&ccedil;&atilde;o</td>
			<td><textarea name="descricao" cols="40" rows="20" required>{$smarty.get.descricao}
                        	</textarea>	
			</td>
               	   </tr>
                    <tr>
                        <td><input type="submit" value="atualizar" name="atualizar" class="botao"/></td>
                    </tr>
                </form>
            </table>
	</fieldset>
</div>	