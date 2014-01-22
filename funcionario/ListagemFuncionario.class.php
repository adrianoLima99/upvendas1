<?php

class ListaFuncionario {

    private $conn;

    function __construct() {
        $this->conn = new connection();
    }

    function listagem() {
        
        if($_SESSION["tipo"]==0){
            $empresa="";
        }else{
            $empresa="AND empresa_id=$_SESSION[empresaId]";
        }
       
        //INICIO MENSAGENS EXCLUSÃO
        echo "<script type='text/javascript'>
               function excluirFuncionario(id){
                var resposta=confirm('Deseja realmente excluir esse registro?')
                 if(resposta)
                 {
                 location.href='?pg=excluiFuncionario&registro='+id;
                 }else{alert('A ação foi abortada!')}
                }</script>";
        //FIM
            $lista0 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0 $empresa AND perfil=0");
            $lista1 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0 $empresa AND perfil=1");
            $lista2 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario  WHERE ativo=0 $empresa AND perfil=2");
             $lista3 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0 $empresa AND perfil=3");
            $lista4 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0 $empresa AND perfil=4");
            $lista5 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0  $empresa AND perfil=5");
            $lista6 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario WHERE ativo=0  $empresa AND perfil=6");
       
            $clausula = " AND superior_id =" . $_SESSION['func_id'];
        echo "<h3>Lista de Funcionarios</h3>";
        //USUARIO SUPER
        if ($_SESSION['tipo'] == 0) {

            $lista0 = $this->conn->query("SELECT id,nome FROM  cliente_sistema WHERE ativo=0");
           //lista as empresas clientes do upvendas
          /*  echo "<div class='accordionButton'> cliente Sistema </div>
                     <div class='accordionContent'>";
                    echo "<div id='listagens'>
                              <table>
                                <th>Nome</th>
                        	<th colspan='3'>Ações</th>";

                        while ($row0 = $lista0->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>
                                 <td>$row0->nome</td>
               			 <td><a href='?pg=editarFuncionario&tabela=cliente_sistema&id=$row0->id'>Editar</a></td>
                                 <td><a href='#' onclick=excluirFuncionario($row0->id)>Excluir</a></td>       
            			 <td><a href='?pg=novaSenha&id=$row0->id'>Nova Senha</a></td>     
                             </tr>";
                        }
                        echo "</table>
                         </div>
                    </div>";*/
            //lista os administradores Master
            echo "<div class='accordionButton'>Administrador Master</div>
                    <div class='accordionContent'>";
                echo "<div id='listagens'>
                           <table>
                                <th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
                                <th colspan='3'>Ações</th>";
                while ($row1 = $lista1->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>
                                <td>$row1->id</td>
                                <td>$row1->cpf</td>
                               <td>$row1->nome</td>
                               <td>$row1->sexo</td>
                               <td>$row1->logradouro</td>
                               <td>".formatar($row1->fone1,'fone')."</td>
                               <td>$row1->email</td>
                                <td><a href='?pg=editarFuncionario&id=$row1->id'><img src='imagens/edita.png' title='editar'/></a></td>
                                <td><a href='#' onclick=excluirFuncionario($row1->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
                                <td><a href='?pg=novaSenha&id=$row1->id'>Nova Senha</a></td>      
                             </tr>";
                     }
                    echo "</table>
                     </div>
                   </div>";

            //adminstrador
            echo "<div class='accordionButton'>Administrador </div>
                     <div class='accordionContent'>";
                 echo "<div id='listagens'>
                	    <table>
                                  <th>Id</th>
                                    <th>CPF</th>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Endereço</th>
                                    <th>Fone1</th>
                                    <th>email</th>
                        	  <th colspan='3'>Ações</th>";

            while ($row2 = $lista2->fetch(PDO::FETCH_OBJ)) {
                           echo "<tr>
                                     <td>$row2->id</td>
                                    <td>$row2->cpf</td>
                                   <td>$row2->nome</td>
                                   <td>$row2->sexo</td>
                                   <td>$row2->logradouro</td>
                                   <td>".formatar($row2->fone1,'fone')."</td>
                                   <td>$row2->email</td>
                                     <td><a href='?pg=editarFuncionario&id=$row2->id'><img src='imagens/edita.png' title='editar'/></a></td>
                                     <td><a href='#' onclick=excluirFuncionario($row2->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
                                     <td><a href='?pg=novaSenha&id=$row2->id'>Nova Senha</a></td>      
                                 </tr>";
                    }
                         echo "</table>
                        </div>
                </div>";
            //LISTAGEM DE GERENTE DE vendas
            echo "<div class='accordionButton'> Gerente de Vendas </div>
	 	    <div class='accordionContent'>";
                   echo "<div id='listagens'>
                          <table>
                               <th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
                               <th colspan='3'>Ações</th> ";
           while ($row2 = $lista2->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>
         		        <td>$row2->id</td>
                                <td>$row2->cpf</td>
                               <td>$row2->nome</td>
                               <td>$row2->sexo</td>
                               <td>$row2->logradouro</td>
                               <td>".formatar($row2->fone1,'fone')."</td>
                               <td>$row2->email</td>
                                <td><a href='?pg=editarFuncionario&tabela=gerente_marketing&id=$row2->id'><img src='imagens/edita.png' title='editar'/></a></td>
               		        <td><a href='#' onclick=excluirFuncionario($row2->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>     
               			<td><a href='?pg=novaSenha&id=$row2->id'>Nova Senha</a></td>      
                	  </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //listagem DE OPERADORES DE TELEMARKETING
            echo "<div class='accordionButton'> Gerente de telemarketing </div>
	   			<div class='accordionContent'>";

            echo "<div id='listagens'>
           		 <table>
             		 <th>Id</th>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Fone1</th>
                        <th>email</th>
              		  <th colspan='3'>Ações</th>";

            while ($row3 = $lista3->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                        <td>$row3->id</td>
                        <td>$row3->cpf</td>
                       <td>$row3->nome</td>
                       <td>$row3->sexo</td>
                       <td>$row3->logradouro</td>
                       <td>".formatar($row3->fone1,'fone')."</td>
                       <td>$row3->email</td>
                <td><a href='?pg=editarFuncionario&tabela=operador_marketing&id=$row3->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='#' onclick=excluirFuncionario($row3->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
                <td><a href='?pg=novaSenha&id=$row3->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //LISTAGEM DE VENDEDORES
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   				<div class='accordionContent'>";

            echo "<div id='listagens'>
            		<table>
             			<th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
             			<th colspan='3'>Ações</th> ";

            while ($row4 = $lista4->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
              				 <td>$row4->id</td>
                                        <td>$row4->cpf</td>
                                       <td>$row4->nome</td>
                                       <td>$row4->sexo</td>
                                       <td>$row4->logradouro</td>
                                       <td>".formatar($row4->fone1,'fone')."</td>
                                       <td>$row4->email</td>
               				 <td><a href='?pg=editarFuncionario&tabela=vendedor&id=$row4->id'><img src='imagens/edita.png' title='editar'/></a></td>
                			 <td><a href='#' onclick=excluirFuncionario($row4->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>   
                 			 <td><a href='?pg=novaSenha&id=$row4->id'>Nova Senha</a></td>      
              			  </tr>";
            }
            echo "</table>
            </div>
           </div>";

            //USUARIO MASTER
        } elseif ($_SESSION['tipo'] == 1) {
             $lista1 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario  WHERE ativo=0 and id=$_SESSION[func_id] $empresa AND perfil=1");
                //lista as empresas clientes do upvendas
            echo "<div class='accordionButton'> Administrador(a) Master </div>
	  				 <div class='accordionContent'>";

            echo "<div id='listagens'>
         		   <table>
        		       <th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
            		    <th colspan='2'>Ações</th>
               ";

            while ($row1 = $lista1->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                		<td>$row1->id</td>
                                <td>$row1->cpf</td>
                                <td>$row1->nome</td>
                                <td>$row1->sexo</td>
                                <td>$row1->logradouro</td>
                                 <td>".formatar($row1->fone1,'fone')."</td>
                                 <td>$row1->email</td>
               			 <td><a href='?pg=editarFuncionario&tabela=administrador&id=$row1->id'><img src='imagens/edita.png' title='editar'/></a></td>
                                     <td><a href='?pg=novaSenha&id=$row1->id'>Nova Senha</a></td>      
                	</tr>";
            }
            echo "</table>
            </div>
           </div>";

            
            //lista as administradores comuns
            echo "<div class='accordionButton'> Administrador </div>
	  				 <div class='accordionContent'>";

            echo "<div id='listagens'>
         		   <table>
        		       <th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
            		    <th colspan='3'>Ações</th>
               ";

            while ($row2 = $lista2->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                		<td>$row2->id</td>
                                <td>$row2->cpf</td>
                                <td>$row2->nome</td>
                                <td>$row2->sexo</td>
                                <td>$row2->logradouro</td>
                                 <td>".formatar($row2->fone1,'fone')."</td>
                                 <td>$row2->email</td>
               			 <td><a href='?pg=editarFuncionario&tabela=administrador&id=$row2->id'><img src='imagens/edita.png' title='editar'/></a></td>
                 		 <td><a href='#' onclick=excluirFuncionario($row2->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
               			 <td><a href='?pg=novaSenha&id=$row2->id'>Nova Senha</a></td>      
                	</tr>";
            }
            echo "</table>
            </div>
           </div>";

            //lista os Gerente de vendas
            echo "<div class='accordionButton'>Gerente vendas </div>
	 				  <div class='accordionContent'>";

            echo "<div id='listagens'>
        			    <table>
          				    <th>Id</th>
                                    <th>CPF</th>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Endereço</th>
                                    <th>Fone1</th>
                                    <th>email</th>
              				  <th colspan='3'>Ações</th>
             ";

            while ($row3 = $lista3->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                		<td>$row3->id</td>
                                <td>$row3->cpf</td>
                               <td>$row3->nome</td>
                               <td>$row3->sexo</td>
                               <td>$row3->logradouro</td>
                                <td>".$row3->fone1."</td>
                               <td>$row3->email</td>
               			 <td><a href='?pg=editarFuncionario&tabela=gerente_vendas&id=$row3->id'><img src='imagens/edita.png' title='editar'/></a></td>
                 		 <td><a href='#' onclick=excluirFuncionario($row3->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
               			 <td><a href='?pg=novaSenha&id=$row3->id'>Nova Senha</a></td>      
                	</tr>";
            }
            echo "</table>
            </div>
           </div>";
            //LISTAGEM DE GERENTE DE TELEMARKETING
            echo "<div class='accordionButton'> Gerente de telemarketing </div>
	 				  <div class='accordionContent'>";

            echo "<div id='listagens'>
            		<table>
               		<th>Id</th>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Fone1</th>
                        <th>email</th>
                	 	<th colspan='3'>Ações</th> ";

            while ($row4 = $lista4->fetch(PDO::FETCH_OBJ)) {

                echo "<tr>
               		<td>$row4->id</td>
                        <td>$row4->cpf</td>
                         <td>$row4->nome</td>
                        <td>$row4->sexo</td>
                          <td>$row4->logradouro</td>
                         <td>".formatar($row4->fone1,'fone')."</td>
                        <td>$row4->email</td>
                		<td><a href='?pg=editarFuncionario&tabela=gerente_marketing&id=$row4->id'><img src='imagens/edita.png' title='editar'/></a></td>
               			<td><a href='#' onclick=excluirFuncionario($row4->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>     
               			<td><a href='?pg=novaSenha&id=$row4->id'>Nova Senha</a></td>      
                	  </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //listagem DE OPERADORES DE TELEMARKETING
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   			<div class='accordionContent'>";

            echo "<div id='listagens'>
           		 <table>
             		<th>Id</th>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Sexo</th>
                            <th>Endereço</th>
                            <th>Fone1</th>
                            <th>email</th>
              		  <th colspan='3'>Ações</th>";

            while ($row5 = $lista5->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                        <td>$row5->id</td>
                         <td>$row5->cpf</td>
                        <td>$row5->nome</td>
                        <td>$row5->sexo</td>
                        <td>$row5->logradouro</td>
                        <td>".formatar($row5->fone1,'fone')."</td>
                        <td>$row5->email</td>
                <td><a href='?pg=editarFuncionario&tabela=operador_marketing&id=$row5->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='#' onclick=excluirFuncionario($row5->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
                <td><a href='?pg=novaSenha&id=$row5->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //LISTAGEM DE VENDEDORES
            echo "<div class='accordionButton'> Vendedores </div>
	   				<div class='accordionContent'>";

            echo "<div id='listagens'>
            		<table>
             			<th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
             			<th colspan='3'>Ações</th> ";

            while ($row6 = $lista6->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
              				 <td>$row6->id</td>
                                            <td>$row6->cpf</td>
                                           <td>$row6->nome</td>
                                           <td>$row6->sexo</td>
                                           <td>$row6->logradouro</td>
                                           <td>".formatar($row6->fone1,'fone')."</td>
                                           <td>$row6->email</td>
               				 <td><a href='?pg=editarFuncionario&tabela=vendedor&id=$row6->id'><img src='imagens/edita.png' title='editar'/></a></td>
                			 <td><a href='#' onclick=excluirFuncionario($row6->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>   
                 			 <td><a href='?pg=novaSenha&id=$row6->id'>Nova Senha</a></td>      
              			  </tr>";
            }
            echo "</table>
            </div>
           </div>";

            //USUARIO ADMINISTRADOR
        } elseif ($_SESSION['tipo'] == 2) {
             $lista2 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM  funcionario  WHERE ativo=0 AND id=$_SESSION[func_id] $empresa AND perfil=2");
            //lista as administradores comuns
            echo "<div class='accordionButton'> Adminsitradora </div>
	  				 <div class='accordionContent'>";

            echo "<div id='listagens'>
         		   <table>
        		       <th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
            		    <th colspan='2'>Ações</th>
               ";

            while ($row2 = $lista2->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                		<td>$row2->id</td>
                                <td>$row2->cpf</td>
                                <td>$row2->nome</td>
                                <td>$row2->sexo</td>
                                <td>$row2->logradouro</td>
                                 <td>".formatar($row2->fone1,'fone')."</td>
                                 <td>$row2->email</td>
               			 <td><a href='?pg=editarFuncionario&tabela=administrador&id=$row2->id'><img src='imagens/edita.png' title='editar'/></a></td>
                 		 <td><a href='?pg=novaSenha&id=$row2->id'>Nova Senha</a></td>      
                	</tr>";
            }
            echo "</table>
            </div>
           </div>";

            //lista os Gerente de vendas
            echo "<div class='accordionButton'>Gerente vendas </div>
	 				  <div class='accordionContent'>";

            echo "<div id='listagens'>
        			    <table>
          				    <th>Id</th>
                                    <th>CPF</th>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Endereço</th>
                                    <th>Fone1</th>
                                    <th>email</th>
              				  <th colspan='3'>Ações</th>
             ";

            while ($row3 = $lista3->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                		<td>$row3->id</td>
                                <td>$row3->cpf</td>
                               <td>$row3->nome</td>
                               <td>$row3->sexo</td>
                               <td>$row3->logradouro</td>
                               <td>".formatar($row3->fone1,'fone')."</td>
                               <td>$row3->email</td>
               			 <td><a href='?pg=editarFuncionario&tabela=gerente_vendas&id=$row3->id'><img src='imagens/edita.png' title='editar'/></a></td>
                 		 <td><a href='#' onclick=excluirFuncionario($row3->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
               			 <td><a href='?pg=novaSenha&id=$row3->id'>Nova Senha</a></td>      
                	</tr>";
            }
            echo "</table>
            </div>
           </div>";
            //LISTAGEM DE GERENTE DE TELEMARKETING
            echo "<div class='accordionButton'> Gerente de telemarketing </div>
	 				  <div class='accordionContent'>";

            echo "<div id='listagens'>
            		<table>
               		<th>Id</th>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Fone1</th>
                        <th>email</th>
                	 	<th colspan='3'>Ações</th> ";

            while ($row4 = $lista4->fetch(PDO::FETCH_OBJ)) {

                echo "<tr>
               		<td>$row4->id</td>
                        <td>$row4->cpf</td>
                         <td>$row4->nome</td>
                        <td>$row4->sexo</td>
                          <td>$row4->logradouro</td>
                         <td>".formatar($row4->fone1,'fone')."</td>
                        <td>$row4->email</td>
                		<td><a href='?pg=editarFuncionario&tabela=gerente_marketing&id=$row4->id'><img src='imagens/edita.png' title='editar'/></a></td>
               			<td><a href='#' onclick=excluirFuncionario($row4->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>     
               			<td><a href='?pg=novaSenha&id=$row4->id'>Nova Senha</a></td>      
                	  </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //listagem DE OPERADORES DE TELEMARKETING
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   			<div class='accordionContent'>";

            echo "<div id='listagens'>
           		 <table>
             		<th>Id</th>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Sexo</th>
                            <th>Endereço</th>
                            <th>Fone1</th>
                            <th>email</th>
              		  <th colspan='3'>Ações</th>";

            while ($row5 = $lista5->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                        <td>$row5->id</td>
                         <td>$row5->cpf</td>
                        <td>$row5->nome</td>
                        <td>$row5->sexo</td>
                        <td>$row5->logradouro</td>
                        <td>".formatar($row1->fone5,'fone')."</td>
                        <td>$row5->email</td>
                <td><a href='?pg=editarFuncionario&tabela=operador_marketing&id=$row5->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='#' onclick=excluirFuncionario($row5->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>    
                <td><a href='?pg=novaSenha&id=$row5->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           </div>";
            //LISTAGEM DE VENDEDORES
            echo "<div class='accordionButton'> Vendedores </div>
	   				<div class='accordionContent'>";

            echo "<div id='listagens'>
            		<table>
             			<th>Id</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Sexo</th>
                                <th>Endereço</th>
                                <th>Fone1</th>
                                <th>email</th>
             			<th colspan='3'>Ações</th> ";

            while ($row6 = $lista6->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
              				 <td>$row6->id</td>
                                            <td>$row6->cpf</td>
                                           <td>$row6->nome</td>
                                           <td>$row6->sexo</td>
                                           <td>$row6->logradouro</td>
                                           <td>".formatar($row6->fone1,'fone')."</td>
                                           <td>$row6->email</td>
               				 <td><a href='?pg=editarFuncionario&tabela=vendedor&id=$row6->id'><img src='imagens/edita.png' title='editar'/></a></td>
                			 <td><a href='#' onclick=excluirFuncionario($row6->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>   
                 			 <td><a href='?pg=novaSenha&id=$row6->id'>Nova Senha</a></td>      
              			  </tr>";
            }
            echo "</table>
            </div>
           </div>";


            //USUARIO GERENTE DE VENDAS
        } elseif ($_SESSION['tipo'] == 3) {
            $lista3 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario  WHERE id=$_SESSION[func_id] AND ativo=0 $empresa");
            $lista4 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario WHERE  ativo=0 $clausula    $empresa");

            //lista o gerente
            echo "<div class='accordionButton'> Gerente de venda </div>
	   
	      <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
              <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
                <th colspan='2'>Ações</th>
              ";
            while ($row3 = $lista3->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                <td>$row3->id</td>
                 <td>$row3->cpf</td>
                <td>$row3->nome</td>
                <td>$row3->sexo</td>
                <td>$row3->logradouro</td>
                <td>".formatar($row3->fone1,'fone')."</td>
                <td>$row3->email</td>
                <td><a href='?pg=editarFuncionario&tabela=gerente_vendas&id=$row3->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='?pg=novaSenha&id=$row3->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           </div>";

            //lista os vendedores	
            echo "<div class='accordionButton'> Vendedores </div>
	   
	      <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
               <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
                <th colspan='3'>Ações</th>
              ";
            while ($row4 = $lista4->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>
                <td>$row4->id</td>
                 <td>$row4->cpf</td>
                <td>$row4->nome</td>
                <td>$row4->sexo</td>
                <td>$row4->logradouro</td>
                <td>".formatar($row4->fone1,'fone')."</td>
                <td>$row4->email</td>    
                <td><a href='?pg=editarFuncionario&tabela=vendedor&id=$row4->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='#' onclick=excluirFuncionario($row4->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>   
                  <td><a href='?pg=novaSenha&id=$row4->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           </div>";

            // USUARIO GERENTE DE TELEMRKETING
        } else if ($_SESSION['tipo'] == 4) {
            $lista3 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario  WHERE id=$_SESSION[func_id] AND ativo=0 $empresa");
            $lista4 = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario WHERE ativo=0 $clausula  $empresa");
           
      echo "<div class='accordionButton'>Gerente de Telemarketing </div>
	   <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
               <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
               <th colspan='2'>Ações</th> ";
            while ($row3 = $lista3->fetch(PDO::FETCH_OBJ)) {
         echo "<tr>
                <td>$row3->id</td>
                 <td>$row3->cpf</td>
                <td>$row3->nome</td>
                <td>$row3->sexo</td>
                <td>$row3->logradouro</td>
                <td>".formatar($row3->fone1,'fone')."</td>
                <td>$row3->email</td>
                  
                <td><a href='?pg=editarFuncionario&tabela=gerente_marketing&id=$row3->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='?pg=novaSenha&id=$row3->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           
           </div>";
            
            
            
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
               <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
               <th colspan='3'>Ações</th> ";
            while ($row4 = $lista4->fetch(PDO::FETCH_OBJ)) {
         echo "<tr>
                <td>$row4->id</td>
                 <td>$row4->cpf</td>
                <td>$row4->nome</td>
                <td>$row4->sexo</td>
                <td>$row4->logradouro</td>
                <td>".formatar($row4->fone1,'fone')."</td>
                <td>$row4->email</td>
                  
                <td><a href='?pg=editarFuncionario&tabela=operador_marketing&id=$row4->id'><img src='imagens/edita.png' title='editar'/></a></td>
                     <td><a href='#' onclick=excluirFuncionario($row4->id)><img src='imagens/excluir.gif' title='excluir'/></a></td>
                  <td><a href='?pg=novaSenha&id=$row4->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           
           </div>";
             // USUARIO operador DE TELEMRKETING   
        }else if ($_SESSION['tipo'] == 5) {
            
            $listaOp = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario WHERE ativo=0 AND perfil=5 AND id=$_SESSION[func_id]   $empresa");
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
               <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
               <th colspan='2'>Ações</th> ";
            while ($row5 = $listaOp->fetch(PDO::FETCH_OBJ)) {
         echo "<tr>
                <td>$row5->id</td>
                 <td>$row5->cpf</td>
                <td>$row5->nome</td>
                <td>$row5->sexo</td>
                <td>$row5->logradouro</td>
                <td>".formatar($row5->fone1,'fone')."</td>
                <td>$row5->email</td>
                  
                <td><a href='?pg=editarFuncionario&tabela=operador_marketing&id=$row5->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='?pg=novaSenha&id=$row5->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           
           </div>";
             // USUARIO vendedor   
        }else if ($_SESSION['tipo'] == 6) {
            
            $listaVend = $this->conn->query("SELECT id,nome,sexo,logradouro,fone1,email,cpf FROM funcionario WHERE ativo=0 AND perfil=6 AND id=$_SESSION[func_id]   $empresa");
            echo "<div class='accordionButton'>Operadores de Telemarketing </div>
	   <div class='accordionContent'>";

            echo "<div id='listagens'>
            <table>
               <th>Id</th>
               <th>CPF</th>
               <th>Nome</th>
               <th>Sexo</th>
               <th>Endereço</th>
               <th>Fone1</th>
               <th>email</th>
               <th colspan='2'>Ações</th> ";
            while ($row6 = $listaVend->fetch(PDO::FETCH_OBJ)) {
         echo "<tr>
                <td>$row6->id</td>
                 <td>$row6->cpf</td>
                <td>$row6->nome</td>
                <td>$row6->sexo</td>
                <td>$row6->logradouro</td>
                <td>".formatar($row6->fone1,'fone')."</td>
                <td>$row6->email</td>
                  
                <td><a href='?pg=editarFuncionario&tabela=vendedor&id=$row6->id'><img src='imagens/edita.png' title='editar'/></a></td>
                  <td><a href='?pg=novaSenha&id=$row6->id'>Nova Senha</a></td>      
                </tr>";
            }
            echo "</table>
            </div>
           
           </div>";
         
        }
        
       echo  "<a href='javascript:history.go(-1)'>Voltar</a>"; 
    }

    //EXCLUI FUNCIONARIO
    function excluiFuncionario($id) {
       

        $exc = $this->conn->exec("UPDATE funcionario SET ativo=-1 WHERE id=$id");
        if ($exc) {
           
            $this->conn->exec("UPDATE usuario SET ativo=-1 WHERE funcionario_id=$id ");
            echo "<script type='text/javascript'>alert('Exclusão feita com sucesso')
                        location.href='?pg=listaFuncionario';
                 </script>";
        }
    }

}

?>
