<link rel="stylesheet" type="text/css" href="js/lightbox/css/lightbox.css" media="screen"/>
{literal}
    	<script type="text/javascript" src="js/lightbox/js/modernizr.custom.js"></script>
         <script type="text/javascript" src="js/lightbox/js/jquery-1.10.2.min.js"></script>
        
<script  type="text/javascript" src="js/lightbox/js/lightbox-2.6.min.js"></script>

    <script type="text/javascript" src="ajax/listaCidades.js"></script>
    <script type="text/javascript" >
      function frmCodigo(){
          document.getElementById("tbCodigo").style.display="block";
       }
      function mostraCodigo(valor){
          document.getElementById("codigo").value=valor;
      }
    </script>
    
 {/literal}   
{if $smarty.session.usuario neq ""}
    <br/>
    <div style="margin:0 auto;width:600px;color:green;font-family:verdana, helvetica,arial ">
     <p>Atenção:</p>
        <p>Siga as instruções, onde tiver a palavra vazio ,o campo não poderá ser preenchido, o formato do arquivo devera ser ".csv"!</p>
        <p>Se for pessoa fisica,siga a sequência:</p>
        <figure>
           <div class="image-row">
		<a class="example-image-link" href="imagens/pessoaFisica.png"  data-lightbox="example-1">
	                <img src="imagens/pessoaFisica.png" width="600px" title="Pessoa Fisica"/>
            </a>
           </div> 
        </figure>
        <p>Se for pessoa juridica,siga a sequência:</p>
        <figure>
            <div class="image-row">
		<a class="example-image-link" href="imagens/pessoaJuridica.png"  data-lightbox="example-1">
	                <img src="imagens/pessoaJuridica.png" width="600px" title="Pessoa Juridica" />
            </a>
           </div>
        </figure>
       <br/>
      </div> 
    <div id=formularios>
          
        <fieldset>
            <legend>Enviar carta Cliente</legend>
            <form method='post' action='?pg=envioCartaCliente' name='uploadCSV' enctype='multipart/form-data'>

                <table>
                    <tr>
                        <td>Inserir Arquivo</td>
                        <td><input type='file' name='cartaCliente' /></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Convertido pelo:</td>
                        <td><select name='convertido' required >
                                <option></option>
                                <option value='1'>EXCEL</option>
                                <option value='2'>BROFFICE</option>	
                            </select>
                        </td>
                    <tr>  
                    <tr><td colspan="2" onclick="frmCodigo()"><a href="#" style="text-decoration:none;">Consultar codigo municipio</a></td></tr>
                    <table style="display:none " id="tbCodigo">  
                    <tr>
                           <td>Estado</td>
                            <td><select name='estado'id="uf" onchange="listaCidades()">
                                    <option>Selecione o estado</option>
                              {html_options  values=$idEstado output=$estado}
                                </select>
                            </td>
                        </tr>
                        <tr>   
                            <td>Municipio</td>
                            <td><select name='municipio' id="municipio" onchange="mostraCodigo(this.value)" >
                                   <option value=""></option>  
                                </select>
                            </td>
                        </tr>
                        <tr>   
                            <td>Codigo</td> <td><input type="text" name='codigo' id="codigo" placeholder="copie este codigo " /></td>
                        </tr>
                    </table>  
                       <tr>
                        <td><input type='submit' name='upload' value='enviar' class='botao'/></td>
                    </tr>

                </table>

            </form>

        </fieldset> 
        <a href='javascript:history.go(-1)'>Voltar</a>
    </div> 
{/if}