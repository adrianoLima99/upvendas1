<?php
    echo "<div id='listagens'>
        <h3>Relatorio de Funcionario</h3>
            <table>";
         echo  "<tr>
                  <th>Id</th>
                  <th>Nome</th>
                  <th>Cargo</th>
                  <th>Sexo</th>
                  <th>Superior</th>
                  <th>Fone</th>
                  <th>Endereço</th>
                  <th>Bairro</th>
                  <th>Cidade</th>
                  <th>UF</th>
                  <th>Admissão</th>
                </tr>       ";
              
   while($lista=$sql->fetch(PDO::FETCH_OBJ) ){
       $listaSuperior=$this->conn->query("SELECT nome FROM funcionario WHERE id=$lista->superior_id");
        $exibicao=$listaSuperior->fetch(PDO::FETCH_OBJ);
        echo "<tr>
                 <td>$lista->id</td>
                 <td>$lista->nome</td>
                 <td>$lista->cargo</td>    
                 <td>$lista->sexo</td>";
                 if($lista->perfil!=1){
         echo  " <td>$exibicao->nome</td>";       
                 }else{
          echo  " <td>$lista->nome</td>";             
                 }    
       echo "   <td>$lista->fone1</td>
                 <td>$lista->logradouro</td>
                 <td>$lista->bairro</td>
                 <td>$lista->municipio</td>
                 <td>$lista->estado</td>
                 <td>".formata_data($lista->data_admissao)."</td>    
                
              </tr>";
            }   
      
      echo "</table>
          </div>";
 
 
?>