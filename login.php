<?php

//fazer upload
class Login {

    private $usuario;
    private $senha;
    private $sql;
    private $tabela;
    private $empresa;
    private $codicao;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function FormLogin() {
        echo "
	<div id='legend'><h3 style='color: #fff;'>&Aacute;rea Restrita</h3></div>
	  <section id='login'>
	      <fieldset>
	          <form action='#' method='post'>
	           <table width='100%' border='1'>
	            
	            <tr><td>Empresa</td></tr>
	            <tr>
	            	<td><input type='text' name='empresa' placeholder='nome empresa' /></td>
	             </tr>
	            
	             <tr><td>Usu&aacute;rio</td>
		     </tr>
		     <tr><td><input type='text' name='usuario' placeholder='Digite aqui seu login' required/></td>
	             </tr>
	             <tr><td>Senha</td>
		     </tr> 
	             <tr><td><input type='password' name='senha' placeholder='Digite aqui sua senha' required/> </td> 
	             </tr>
	             <tr><td><input type='submit' name='entrar' class='botao' value='Entrar'/>
		              <input type='reset' name='cancelar' class='botao' value='Limpar' />
			 </td> 
	             </tr>
	            </table>
	           </form> 
	      </fieldset>
	    </section>
	";
        if (isset($_POST['entrar'])) {
            $this->verificaUsuario($_POST['usuario'], $_POST['senha'], $_POST['empresa']);
        }
    }

    function verificaUsuario($usuario,$senha, $empresa) {
        $this->usuario = addslashes($usuario);
        $this->senha = addslashes($senha);
        $this->empresa = $empresa;
            
        //empresa diferente de vazio entao nao é super usuario
        if (!empty($empresa)) {
            $senha=hash("SHA512","$this->senha");
          
            
           $c=$this->conn->query("SELECT F.id as func,F.empresa_id,E.nome as empresa,C.nome as cargo,F.perfil,U.nome,U.senha,U.id FROM empresa AS E 
                                    INNER JOIN  funcionario AS  F ON E.id=F.empresa_id 
                                     INNER JOIN usuario AS U ON U.funcionario_id=F.id
                                     INNER JOIN cargo AS C ON C.id=F.cargo_id
                                    WHERE  U.senha='$senha' AND U.nome='$this->usuario' AND E.nome='$this->empresa' AND F.ativo=0 AND E.ativo=0 ");
            
         
            if($c->rowCount()){
              
                  $l=$c->fetch(PDO::FETCH_OBJ);
          
                    $_SESSION['usuario'] = $l->nome;
                    $_SESSION['func_id'] = $l->func;
                    $_SESSION['id'] = $l->id;
                    $_SESSION['tipo'] = $l->perfil;
                    $_SESSION['nmEmpresa'] = $l->empresa;
                    $_SESSION['nmCargo'] = $l->cargo;
                    $_SESSION['empresaId'] = $l->empresa_id;
                    header("location:?pg=pesquisa");
           }else{
              
               echo "<script type='text/javascript'>
     			  alert('usuario não encontrado');
      			</script>";
               
               } 
       }
    }
}

?>