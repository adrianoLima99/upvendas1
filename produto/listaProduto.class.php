<?php


class ListaProduto{
 private $conn;
function __construct()
 {
       $this->conn = new connection();
  }
 function listagem()
  {
     //INICIO MENSAGENS EXCLUSÃO
     echo "<script type='text/javascript'>
               function excluirProduto(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluirProduto&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
    //FIM       
    echo "<br/><br/><h3>Lista de Produtos</h3>";
     $lista1= $this->conn->query("SELECT * FROM produto  WHERE ativo=0 AND empresa_id=$_SESSION[empresaId] ORDER BY nome ");
     
      echo " <div id='listagens'>";
       
         if ($lista1->rowCount()) {
        
          echo "<table>
            <tr>
             <th>Id</th>
             <th>Produto</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Ano</th>
            <th colspan='2'>Ação</th>
            </tr>";
              
      while ($l = $lista1->fetch(PDO::FETCH_OBJ))
      {
     
          echo " 
       <tr>
        <td>$l->id</td>
         <td>$l->nome</td>
         <td>".number_format($l->valor,2,',','.')."</td>
         <td>$l->descricao</td>   
         <td>$l->ano</td>       
         <td><a href='?pg=editaProduto&id=$l->id'><img src='imagens/edita.png' title='editar'/></a></td>
         <td><a href='#' onclick=excluirProduto($l->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
       </tr>";
       }
        echo "</table>";   
      }else{
          echo "<h3 style=color:red>Nenhum Produto Encontrado!</h3>";
      } 
    
     echo "</div>";
  
}
function excluirProduto($id){
  
     $exc=$this->conn->exec("UPDATE produto SET ativo=-1 WHERE id=$id AND empresa_id=$_SESSION[empresaId]");
        if($exc){
              echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                  location.href='?pg=listaProduto';
                    </script>";
            }
    }

}
?>
