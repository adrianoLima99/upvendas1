
 <!--INICIO MENSAGENS EXCLUSÃO-->
 {literal}    
        <script type='text/javascript'>
               function exclua(id){
                var resposta=confirm("Atenção:Esse registro pode esta contida em algum acompanhamento,Tem certeza que deseja exclui-lo")
                 if(resposta)
                 {
                 location.href='?pg=excluirResposta&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }
         </script>
 {/literal}        
        <!--FIM-->

<br/><br/>
<div id="listagens">

 {if $lista!=""}
<h3>Resposta Automaticas ativas</h3>
<br/>	<table>
              <tr>
                  <th>Id</th>
                  <th>Resposta</th>
		  <th>Descricao</th>
		  <th>Data Cadastro </th>
                  <th>Hora Cadastro </th>
{if $smarty.session.tipo eq 0 ||  $smarty.session.tipo eq 1 || $smarty.session.tipo eq 2}
                  <th colspan='2'>Ações</th>    
 {/if}
              </tr>
	{foreach from=$lista item=r }
	      <tr>
            	<td>{$r.id}</td>
                <td>{$r.resposta}</td>
                <td>{$r.descricao}</td>
                <td>{$r.data_cadastro}</td>
                 <td>{$r.hora_cadastro}</td>
               {if $smarty.session.tipo eq 0 ||  $smarty.session.tipo eq 1 || $smarty.session.tipo eq 2 } 
                    {if $r.id!=9}
                         <td><a href="?pg=editarResposta&id={$r.id}&resposta={$r.resposta}&descricao={$r.descricao}"><img src='imagens/edita.png' title='editar resposta'/></a></td>
                         <td><a href="#" onclick='exclua({$r.id})'><img src='imagens/excluir.gif' title='excluir resposta'/></a></td>
                      {else}
                          <td></td>
                          <td></td>
                     {/if}       
               {/if}	 
             </tr>
	{/foreach}
       </table>
  {else}
        <br/>
        <h3 style='color:red;'>N&atilde;o existe resposta ativas<br/>
        <a href="javascript:history.go(-1)"><img src='imagens/voltar.gif' title='voltar'/></a></h3>
    {/if}
</div>