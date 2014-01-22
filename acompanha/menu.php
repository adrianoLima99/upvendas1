<nav id="menu"> 
	<!--SUPER USUARIO-->
	<?php if ($_SESSION['tipo'] == 0) { ?> 
        <ul>
			<li class='has-sub '><a class="cadastro" href='#'><span>Cadastros</span></a>
                <ul>
                    <li><a href='?pg=funcionario'><span>Novo Funcionário</span></a></li>
                    <li><a href='?pg=novoUsuario'><span>Novo Usuário</span></a></li>
                    <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
                    <li><a href='?pg=formularioEmpresa'><span>Nova Empresa</span></a></li>
                    <li><a href='?pg=empreendedor'><span>Novo Empreendedor</span></a></li>
                    <li><a href='?pg=novoCargo'><span>Novo Cargo</span></a></li>
                     <li><a href='?pg=novoPlano'><span>Novo Plano</span></a></li>
                    
                    
                </ul>
			
			<li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
                    <li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
					<li><a  href='?pg=listaFuncionario'><span>Funcionários</span></a></li>
					<li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                    <li><a  href='?pg=editarTele'><span>Associações</span></a></li>
                    
                 </ul>
				 	
            </li>
			
			<li class='has-sub'><a class="ocorrencia" href='#'><span>Ocorrências</span></a>
				<ul>
					<li><a href='?pg=novaOcorrencia'><span>Nova Ocorrência</span></a></li>
                    <li><a href='?pg=aprovarOcorrencia'><span>Ativar Ocorrência</span></a></li>
					<li><a  href='?pg=OcorrenciasPendentes'><span>Ocorr&ecirc;ncias Pendentes</span></a></li>
			
				</ul>
			</li>
			
        	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Cliente</span></a></li>
			<li><a class="visita" href='?pg=visitados'><span>Visitas Realizadas</span></a></li>
			<li><a class="tele" href='?pg=tele'><span>SAC</span></a></li>
			<li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
			<li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
			<li><a class="relatorio" href="?pg=relatorio&opc="><span>Relatórios</span></a></li>	 
            </li>   
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>
<?php 
//USUARIO MASTER
	}else	 if ($_SESSION['tipo'] == 1) {
?> 
        <ul>
			<li class='has-sub '><a class="cadastro" href='#'><span>Cadastros</span></a>
                <ul>
                    <li><a href='?pg=funcionario'><span>Novo Funcionário</span></a></li>
                    <li><a href='?pg=novoUsuario'><span>Novo Usuário</span></a></li>
                    <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
                    <li><a href='?pg=novoCargo'><span>Novo Cargo</span></a></li>      
                     <li><a href='?pg=novoPlano'><span>Novo Plano</span></a></li>
                </ul>
			
			<li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
					<li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
                    <li><a  href='?pg=listaFuncionario'><span>Funcionários</span></a></li>
                    <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                    <li><a  href='?pg=editarTele'><span>Associações</span></a></li>
                     
                 </ul>
				 
			<li class='has-sub'><a class="ocorrencia" href='#'><span>Ocorrências</span></a>
				<ul>
					<li><a href='?pg=novaOcorrencia'><span>Nova Ocorrência</span></a></li>
                    <li><a href='?pg=aprovarOcorrencia'><span>Ativar Ocorrência</span></a></li>
					<li><a  href='?pg=OcorrenciasPendentes'><span>Ocorr&ecirc;ncias Pendentes</span></a></li>
			
				</ul>
				
            </li>
        	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Cliente</span></a></li>
			<li><a class="visita" href='?pg=visitados'><span>Visitas Realizadas</span></a></li>
			<li><a class="tele" href='?pg=tele'><span>SAC</span></a></li>
			<li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
			<li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
	
			<li><a class="relatorio" href="?pg=relatorio&opc="><span>Relatórios</span></a></li>	 
            </li>   
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>
<?php 
//USUARIO ADMINISTRADOR
	}else	 if ($_SESSION['tipo'] == 2) {

 ?> 
        <ul>
             <li class='has-sub '><a class="cadastro" href='#'><span>Cadastros</span></a>
                <ul>
                    <li><a href='?pg=funcionario'><span>Novo Funcionário</span></a></li>
                    <li><a href='?pg=novoUsuario'><span>Novo Usuário</span></a></li>
                    <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
                      <li><a href='?pg=novoCargo'><span>Novo Cargo</span></a></li>
                       <li><a href='?pg=novoPlano'><span>Novo Plano</span></a></li>
                  
                </ul>
			
			<li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
					<li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
                    <li><a  href='?pg=listaFuncionario'><span>Funcionários</span></a></li>
                    <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                    <li><a  href='?pg=editarTele'><span>Associações</span></a></li>
                     
                 </ul>
				 	
            </li>
			
			<li class='has-sub'><a class="ocorrencia" href='#'><span>Ocorrências</span></a>
				<ul>
					<li><a href='?pg=novaOcorrencia'><span>Nova Ocorrência</span></a></li>
                    <li><a href='?pg=aprovarOcorrencia'><span>Ativar Ocorrência</span></a></li>
					<li><a  href='?pg=OcorrenciasPendentes'><span>Ocorr&ecirc;ncias Pendentes</span></a></li> 
			
				</ul>
				
            </li>
        	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Cliente</span></a></li>
			<li><a class="visita" href='?pg=visitados'><span>Visitas Realizadas</span></a></li>
			<li><a class="tele" href='?pg=tele'><span>SAC</span></a></li>
			<li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
			<li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
			<li><a class="relatorio" href="?pg=relatorio&opc="><span>Relatórios</span></a></li>	 
            </li>   
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>
<?php
//USUARIO GERENTE VENDAS
 } else if ($_SESSION['tipo'] == 3) { ?>
 	
    <ul class="tipo1">
    	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Clientes</span></a></li>
		<li class='has-sub'><a class="ocorrencia" href='#'><span>Ocorrências</span></a>
				<ul>
					<li><a href='?pg=novaOcorrencia'><span>Nova Ocorrência</span></a></li>
					<li><a  href='?pg=OcorrenciasPendentes'><span>Ocorr&ecirc;ncias Pendentes</span></a></li>
			
				</ul>
		</li>
        <li class='has-sub'><a class="cadastro" href="#"><span>Cadastros</span></a>
            <ul>
                <li><a href='?pg=funcionario'><span>Novo Funcionário</span></a></li> 
                <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
                <li><a href='?pg=novoCargo'><span>Novo Cargo</span></a></li>
                     
                    
            </ul>
        </li>
        <li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
					<li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
                    <li><a  href='?pg=listaFuncionario'><span>Funcionários</span></a></li>
                    <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                      
                 </ul>
        </li>     
        <li><a class="visita" href="?pg=visitados"><span>Visitas Realizadas</span></a></li>
        <li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
		
		
    </ul>
<?php
//USUARIO GERENTE TELEMARKETING
 } else if ($_SESSION['tipo'] == 4) { ?>
    <ul class="tipo2">
        <li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Clientes</span></a></li>
        <li class='has-sub'><a class="cadastro" href="#"><span>Cadastros</span></a>
            <ul>
                <li><a href='?pg=funcionario'><span>Novo Funcionário</span></a></li> 
                <li><a href='?pg=novaOcorrencia'><span>Nova Ocorrencia</span></a></li>
				<li><a href='?pg=novoCargo'><span>Novo Cargo</span></a></li>
                <li><a  href='?pg=OcorrenciasPendentes'><span>Ocorr&ecirc;ncias Pendentes</span></a></li> 
                    
            </ul>  
        </li> 
         <li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
                  
                    <li><a  href='?pg=listaFuncionario'><span>Funcionários</span></a></li>
                    <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                      <li><a  href='?pg=editarTele'><span>Associações</span></a></li>
                 </ul>
         </li>     
        <li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
        <li><a class="tele" href="?pg=tele"><span>SAC</span></a></li>
        <li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>  
<?php 
//USUARIO OPERADOR TELEMARKETING
} else if ($_SESSION['tipo'] == 5) { ?>
    <ul class="tipo3">
    	 <li class='has-sub'><a class="ocorrencia" href="#"><span>Ocorrêcias</span></a>
            <ul>
         
                 <li><a href='?pg=novaOcorrencia'><span>Nova Ocorrencia</span></a></li>
                    
            </ul>  
         </li> 
       
        <li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
        <li><a class="tele" href="?pg=tele"><span>SAC</span></a></li>
        <li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>   
<?php
//USUARIO INDIVIAUL OU EMPREENDEDOR
 }else if ($_SESSION['tipo'] == 6) { ?> 
        <ul>
			<li class='has-sub '><a class="cadastro" href='#'><span>Cadastros</span></a>
                <ul>
                   
                    <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
                    <li><a href='?pg=novaOcorrencia'><span>Nova Ocorrencia</span></a></li>
                    
                </ul>
			
			<li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
                <ul>
                  
                    <li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
                    <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
                   
                 </ul>
				 	
            </li>
        	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Cliente</span></a></li>
			<li><a class="visita" href='?pg=visitados'><span>Visitas Realizadas</span></a></li>
			<li><a class="tele" href='?pg=tele'><span>SAC</span></a></li>
			<li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
			<li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
			
			<li><a class="relatorio" href="?pg=relatorio&opc="><span>Relatórios</span></a></li>	 
            </li>   
        <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
    </ul>
<?php }else if ($_SESSION['tipo'] == 7) {?>
        
          <ul>
               <li class='has-sub '><a class="cadastro" href='#'><span>Cadastros</span></a>
          <ul>
               <li><a href='?pg=produto'><span>Novo Produto</span></a></li>
               <li><a href='?pg=novaOcorrencia'><span>Nova Ocorrencia</span></a></li>
               <li><a href='?pg=novoPlano'><span>Novo Plano</span></a></li>
         </ul>
               <li class='has-sub '><a class="pesquisa" href='#'><span>Consultar</span></a>
          <ul>
              <li><a  href="?pg=editarFuncionario&tabela=vendedor&id=<?php echo $_SESSION["func_id"];?>"<span>Dados Pessoais</span></a></li>
               <li><a  href='?pg=listaDeCliente'><span>Clientes</span></a></li>
               <li><a  href='?pg=listaProduto'><span>Produtos</span></a></li>
               <li><a  href='?pg=#'><span>Plano</span></a></li>
          </ul>
                </li>
        	<li><a class="cadastrar_visitas" href='?pg=pesquisa'><span>Inserir Cliente</span></a></li>
			<li><a class="visita" href='?pg=visitados'><span>Visitas Realizadas</span></a></li>
			<li><a class="tele" href='?pg=tele'><span>SAC</span></a></li>
			<li><a class="agendamento" href="?pg=agendamento"><span>Agendados</span></a></li>
			<li><a class="acompanhamento" href="?pg=acompanha"><span>Acompanhados</span></a></li>
                	 
               </li>   
               <li><a class="sair" href="?pg=sair"><span>Sair</span></a></li>
        </ul>
<?php }?>

       

</nav>