<?php

    echo "<div id='listagens'>
        <div style='clear:both;'></span><br/>
        <h3>Relatorio de Empresa</h3>
                   <table>
                 <tr>
                    <th>Id </th>
                     <th>Empresa</th>
                     <th>Razão Social</th>
                     <th>CNPJ</th>
                     <th>Fone</th>
                     <th>Email</th>
                     <th>Responsavel</th>
                     <th>Endereço</th>
                     <th>Bairro</th>
                     <th>Municipio</th>
                     <th>UF</th>
                     <th>Cadastrado</th>
                </tr> ";
                 while($listaEmpresa=$queryEmpresa->fetch(PDO::FETCH_OBJ)){
                      echo "<tr>
                                 <td>$listaEmpresa->id</td>
                                 <td>$listaEmpresa->nome</td>
                                 <td>$listaEmpresa->razao_social</td>
                                 <td>$listaEmpresa->cnpj</td>    
                                 <td>$listaEmpresa->fone</td>
                                 <td>$listaEmpresa->email</td>
                                 <td>$listaEmpresa->responsavel</td>
                                 <td>$listaEmpresa->logradouro</td>    
                                 <td>$listaEmpresa->bairro</td>
                                 <td>$listaEmpresa->municipio</td>
                                 <td>$listaEmpresa->uf</td>     
                                 <td>".formata_data($listaEmpresa->data_cadastro)."</td>   
                            </tr>";
                 }
                
           
      echo "</table>
          </div>";
 
 
?>