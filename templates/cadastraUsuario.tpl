	
   
<div id='formularios'>
    <fieldset>
    <legend>Cadastrar usuários</legend>
 	   <form method='post' action='?pg=salvaUsuario' onsubmit='return verificaSenha()'>  
            <table>
        	 <tr>
        	 {if $smarty.session.tipo eq 0}
                     <td>Empresa:</td>
                     <td><select name="cliEmpresa" id="cliEmpresa">
                           <option>Selecione  empresa</option>  
                        {html_options  values=$idEmpresa output=$empresa}
                         </select></td>
                 {else}
                      <td><input type='hidden' name='cliEmpresa' id='cliEmpresa' value='{$smarty.session.empresaId}'/></td>
                 {/if}
                 
        	 </tr>   
	    	 <tr>
              <td>Cargo:</td>
              <td><select name='tipo' id='cargo' onchange='selecionaCargo();' >
                    <option value="">Selecione Cargo</option>
                           {html_options  values=$idCargo output=$cargo}
		  
                  </select> 
              </td>
            </tr>
            <tr>
              <td> Nome:</td>
              <td><select name='id_func' id='nomeCargo' >
                    <option></option>
                   </select> 
              </td>
            </tr> 
            <tr> 
	      <td>Usuario</td>
	      <td><input type='text' name='usuario' id='usuario' placeholder='Digite o usuário' required  onblur="verificaUsuario()"/></td>
            </tr>
            <tr > 
	    
            </tr>
            
            <tr>
	      <td>Senha:</td>
	      <td><input type='password' name='senha' id='senha' placeholder='Digite a senha' required/></td>
	   </tr>
           <tr>
	      <td>Confirmar Senha:</td>
	      <td><input type='password' name='confsenha' id='confsenha' placeholder='Digite novamente  a senha' required/></td>
	   </tr>
	   <tr>
	     <td></td>
             <td id="check">
	     </td> 
           </tr>
        </table>
   </form>
   </fieldset>
   </div>";
     
