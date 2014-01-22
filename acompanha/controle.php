<?php
echo "sessao ".$_SESSION["empresaId"];
include_once "mascaras/removeMascara.php";
if (!empty($_SESSION['usuario'])) {

    switch ($_GET["pg"]) {
        case "pesquisa" :
            include_once "cliente/buscaCliente.php";
            break;

        case "funcionario" :
            include_once 'listas/ListaEmpresa.class.php';
            include_once 'listas/ListaCargo.class.php';
            include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';
            $obj = new OperadoraTelefonica();
            $obj->listaEstados();
            $obj2=new ListaCargo();
            $obj2->lista();
            $obj3=new ListaEmpresa();
            $obj3->listaEmpresa();
            $smarty->assign("idEstado", $obj->getIdEstado());
            $smarty->assign("estado", $obj->getEstado());
            $smarty->assign("idCargo", $obj2->getIdCargo());
            $smarty->assign("cargo", $obj2->getCargo());
            $smarty->assign("idEmpresa", $obj3->getIdEmpresa());
            $smarty->assign("empresa", $obj3->getEmpresa());

            $smarty->display("frmFuncionario.tpl");
         break;

        //classe empreendedor
        case "empreendedor" :
            include_once ("clienteSistema/frmClienteSistema.php");
            break;

        case "adicionarFunc" :
            include_once "funcionario/cadastraFuncionario.class.php";

            $obj = new AdicionarFuncionario();
            
            $obj->adicionar($_POST['cargo'], $_POST['nome'], $_POST['sexo'], $_POST['cpf'], $_FILES['foto']['name'], $_POST['superior'], $_POST['tel'], $_POST['email'], $_POST['lograr'], $_POST['numero'], $_POST['complemento'], $_POST['estado'], $_POST['cidade'], $_POST['bairro'], $_POST['nasc'], $_POST['creden']);

            break;

        case "pf" :
         
            include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';
            $obj = new OperadoraTelefonica();
            $obj->listaOperadorasTelefonia();
            $obj->listaEstados();
            $smarty->assign("id", $obj->getIdOperadora());
            $smarty->assign("nome", $obj->getOperadora());
             $smarty->assign("idEstado", $obj->getIdEstado());
            $smarty->assign("estado", $obj->getEstado());
            $smarty->display("frmCliente.tpl");

            break;
            

        case "visita" :
            include_once "visita/salvarVisita.class.php";
            break;

  
        case "salvarPs" :
            include_once "cliente/salvarCliente.php";
            break;

        case "operador" :
            include_once "operador_marketing/operador.html";
            break;

        case "salveGer" :
            include_once "gerente/salvarGerVendas.class.php";
            break;

        case "gerTele" :
            include_once "gerente_telemarketing/gerente_teleMark.html";
            break;

        case "salveGerTele" :
            include_once "gerente_telemarketing/salvarGerenteMark.class.php";
            break;

        case "produto" :
            include_once "produto/produto.html";
            break;

        case "listaProduto" :
            include_once "produto/listaProduto.class.php";
            $obj = new ListaProduto();
            $obj->listagem();
            break;

        case "editaProduto" :
            include_once "produto/editarProduto.class.php";
            $obj = new EdicaoProduto();
            $obj->frmEdicao($_GET['id']);
            break;

        case "salveProduto" :
            include_once "produto/salvarProduto.class.php";
            break;

        case "excluirProduto" :
            include_once "produto/listaProduto.class.php";
            include_once "produto/listaProduto.class.php";
            $obj = new ListaProduto();
            $obj->excluirProduto($_GET['registro']);
            break;

        case "tele" :
            include_once "telemarketing/frmTeleOperador.php";
            break;

        case "editarTele" :
            include_once "telemarketing/edicaoTelemarketing.class.php";
            $obj = new EdicaoTelemarketing();
            if (!empty($_GET['associacao'])) {
                $obj->frmEdicao($_GET['associacao']);
            } else {
                $obj->listagemAssociacao();
            }
            break;

        case "excluirTele" :
            include_once "telemarketing/edicaoTelemarketing.class.php";
            $obj = new EdicaoTelemarketing();
            $obj->excluir($_GET['associacao']);
            break;
          case "automatica" :
			include_once "AssociacaoAutomatica/AssociacaoAutomatica.class.php"; 
            break;  

        case "vendedor" :
            include "vendedor/formVendedor.php";
            break;

        case "vendedorsalvo" :
            include_once "vendedor/salvarVendedor.php";
            break;

        case "listaGerVisita" :
            include_once "telemarketing/listaVisitasGerente.class.php";
            break;

        case "acompanha" :
            include_once "acompanha/acompanha.class.php";
            $obj = new Acompanha();
            //se nao for passado nenhum id para vendedor
            if (empty($_GET['idVend'])) {
                if (isset($_POST['pesquisar'])) {
                    $obj->listaHistorico($_POST['id'],$_POST['operador'], $_POST['data1'], $_POST['data2']);
                } else {
                    $obj->Acompanhados();
                }
            } else {
                $obj->Novo();
                $obj->RegitraAcompanhamento();
            }
            break;

        case "agendamento" :
            include_once "agendamento/Agendados.php";
            $obj = new Agendados();
            $obj->pesquisaAgendados();
            break;

        case "editaAgenda" :
            include_once "agendamento/editaAgendamento.class.php";
            $obj = new editaAgendamento();
            $obj->frmEdicao($_GET['idAgenda']);
        case "excluiAgendamento" :
            include_once "agendamento/Agendados.php";
            $obj = new Agendados();
            $obj->excluiAgendados($_GET['registro']);
            break;

        case "visitados" :
            include_once "visita/Visitados.class.php";
            $obj = new Visitados();
            $obj->pesquisaVisita();
            if (isset($_GET['visita'])) {
                $obj->excluirVisita($_GET['visita']);
            }
            break;

        case "editarVisita" :
            include_once "visita/editarVisita.class.php";
            $obj = new editarVisita();
            $obj->editaVisita($_GET['visita']);
            break;

        case "excluirVisita" :
            include_once "visita/Visitados.class.php";
            $obj = new Visitados();
            $obj->excluirVisita($_GET['registro']);
            break;

        case "sair" :
            include_once "logout.php";
            break;

        case "novoUsuario" :
             include_once 'listas/ListaEmpresa.class.php';
             include_once 'listas/ListaCargo.class.php';
             $obj2=new ListaCargo();
             $obj2->lista();
             $obj3=new ListaEmpresa();
             $obj3->listaEmpresa();
             $smarty->assign("idCargo", $obj2->getIdCargo());
             $smarty->assign("cargo", $obj2->getCargo());
             $smarty->assign("idEmpresa", $obj3->getIdEmpresa());
             $smarty->assign("empresa", $obj3->getEmpresa());
             $smarty->display("cadastraUsuario.tpl");
            
       
        break;

        case "salvaUsuario" :
            include_once "usuario/salvarUsuario.class.php";
            $obj = new SalvarUsuario();
            $obj->recebeusuario($_POST['id_func'], $_POST['usuario'], $_POST['senha'], $_POST['tipo']);
            $obj->UsuarioSalvar();
            break;

        case "novaSenha" :
            include_once "usuario/redefinirSenha.class.php";
            $obj = new RedefinirSenha();
            $obj->novaSenha($_GET['id']);
            break;

        case "listaFuncionario" :
            include_once "funcionario/ListagemFuncionario.class.php";
            $obj = new ListaFuncionario();
            $obj->listagem();
            break;

        case "editarFuncionario" :
            include_once "funcionario/editarFuncionario.class.php";
            $obj = new EdicaoFuncionario();
            $obj->frmEdicao( $_GET['id']);
            break;

        case "excluiFuncionario" :
            include_once "funcionario/ListagemFuncionario.class.php";
            $obj = new ListaFuncionario();
            $obj->excluiFuncionario( $_GET['registro']);
            break;

        case "listaDeCliente" :
            include_once "cliente/ListaCliente.class.php";
            $obj = new ListaCliente();
            $obj->listagem();
            break;

        case "editarCliente" :
            include_once "cliente/editarCliente.class.php";
            $obj = new EdicaoCliente();
            $obj->escolha($_GET['cliente'], $_GET['pessoa']);
            break;

        case "relatorio" :
            
            include_once 'listas/ListaCargo.class.php';
             $obj2=new ListaCargo();
            $obj2->lista();
            $smarty->assign("idCargo", $obj2->getIdCargo());
            $smarty->assign("cargo", $obj2->getCargo());
            $smarty->display("relatorio.tpl");
            
            if (isset($_POST["enviar"])) {
             if(isset($_POST['opcaoExibicao'])){
                include_once ("relatorio/relatorio.class.php");

                $smarty->display("listaRelatorio.tpl");
            }else{ echo "<script type='text/javascript'>
                            alert('Opção de exibição não foi preenchida!')
                            
                            </script>";}
          }
            break;

        case "formularioEmpresa" :
            include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';
            $obj = new OperadoraTelefonica();
            $obj->listaEstados();
           
            $smarty->assign("idEstado", $obj->getIdEstado());
            $smarty->assign("estado", $obj->getEstado());
             $smarty->display("frmClienteSistema.tpl");
            
            break;
        case "salvarEmpresa" :
            include_once "clienteSistema/salvarClienteSistema.class.php";

            break;
        case "uploadCliente" :
            include_once "cliente/formUpload.php";
            break;
        case "envioCartaCliente" :
            include_once "cliente/upload.php";
            break;

        case "novaOcorrencia" :
            include_once "ocorrencia/cargos.php";
            $obj = new Cargos();
            $obj->listaCargos();
            $smarty->assign('id', $obj->getId());
            $smarty->assign('nome', $obj->getNome());
            $smarty->display("novaOcorrencia.tpl");
            break;

        case "salvaOcorrencia" :
            include_once "ocorrencia/SalvarOcorrencia.class.php";
            $obj = new SalvarOcorrencia();
            $obj->setNome($_POST['ocorrencia']);
            $obj->setResponsavel($_POST['responsavel']);
            $obj->setDescricao($_POST['descricao']);
            $obj->Salvar();

            break;
        case "editarOcorrencia":
            include_once "ocorrencia/cargos.php";
            $obj = new Cargos();
            $obj->listaCargos();
            $smarty->assign('id', $obj->getId());
            $smarty->assign('nome', $obj->getNome());
            $smarty->display("editarOcorrencia.tpl");
            break;
        case "aprovarOcorrencia":
            include_once "ocorrencia/AprovarOcorrencia.class.php";
            $obj = new AprovarOcorrencia();

            $smarty->assign('lista', $obj->lista());
            $smarty->display("aprovarOcorrencia.tpl");
            if (isset($_GET['id'])) {
                $obj->ativaOcorrencia($_GET['id']);
            }


            break;
        case "ativarOcorrencia":
            include_once "ocorrencia/AtivarOcorrencia.class.php";
            $obj = new AtivarOcorrencia();

            break;
        case "salvarEdicaoOcorrencia":
            include_once "ocorrencia/editarOcorrencia.class.php";
            $obj = new EditarOcorrencia();
            $obj->edicao($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['responsavel']);

            break;
        case "ocorrenciaAcompanhamento":
            include_once "ocorrencia/InserirOcorrenciaAcompanhamento.class.php";
            $obj = new InserirOcorrenciaAcompanhamento();
            $obj->lista($_GET['tabela']);



            break;
        case "resolverOcorrencia":
            include_once "ocorrencia/ResolverOcorrencia.class.php";
            $obj = new ResolverOcorrencia();
            if ($_GET['tabela'] == "visita") {

                $obj->frmResolverVisita($_GET['id']);
            } else if ($_GET['tabela'] == "acompanhamento") {

                $obj->frmResolverAcompanhamento($_GET['id']);
            } else if ($_GET['tabela'] == "agendamento_visita") {
                $obj->frmResolverAgendamento($_GET['id']);
            }

            $smarty->assign('cliente', $obj->getcliente());
            $smarty->assign('ocorrencia', $obj->getOcorrencia());
            $smarty->assign('idOcorrencia', $obj->getIdOcorrencia());
            $smarty->assign('obs', $obj->getObs());
            $smarty->assign('operador', $obj->getOperador());
            $smarty->assign('vendedor', $obj->getVendedor());
            $smarty->assign('acom', $obj->getAcom());
            $smarty->assign('idAgen', $obj->getAg());
            $smarty->assign('visita', $obj->getVisita());
            $smarty->assign('telefone', $obj->getTel());
            $smarty->assign('produto', $obj->getProduto());
            $smarty->assign('email', $obj->getEmail());

            if ($_GET['tabela'] == "visita") {

                $smarty->display("resolverOcorrenciaVisita.tpl");
            } else if ($_GET['tabela'] == "acompanhamento") {

                $smarty->display("resolverOcorrenciaAcompanhamento.tpl");
            } else if ($_GET['tabela'] == "agendamento_visita") {
                $smarty->display("resolverOcorrenciaAgendamento.tpl");
            }

          if (isset($_POST['enviar'])) {
                $texto = "Codigo Ocorrencia:$_POST[ocorrencia]" . $_POST['obs'];

                $obj->enviaEmail($_POST['email'], $_POST['cliente'], "Ocorrencia Nº:", $texto);
            }
         break;
        case "novoCargo":
            $smarty->display("novoCargo.tpl");
            break;
        case "listaPlano":
            include_once 'plano/ListaPlano.class.php';
            $obj=new ListaPlano();
            $smarty->assign("lista",$obj->lista());
            $smarty->display("listaPlano.tpl");
            break;
        case "novoPlano":
            $smarty->display("frmPlano.tpl");
            break;
        case "salvarPlano":
            include_once "plano/salvarPlano.class.php";
            $obj = new SalvarPlano;
            $obj->setPlano($_POST["plano"]);
            $obj->salvePlano();
            break;

        case "salvarCargo":
            include_once "cargo/SalvarCargo.class.php";
            $obj = new SalvarCargo();
            $obj->setCargo($_POST['cargo']);
            $obj->salvar();
            break;
        default :
            include_once "cliente/buscaCliente.php";
            break;
    }
} else {

    echo "<h3>Você nao esta Logado</h3>";
}
?>