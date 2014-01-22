<?php

include_once "mascaras/removeMascara.php";

if (!empty($_SESSION['usuario'])) {

    switch ($_GET["pg"]) {
        case "pesquisa" :
            include_once "cliente/buscaCliente.php";
            break;

        case "funcionario" :
           include_once 'funcionario/frmFuncionario.php';
            $obj= new FrmFuncionario();
            $obj->frmFUncionario();
            break;

      

        case "adicionarFunc" :
            include_once "funcionario/cadastraFuncionario.class.php";

            $obj = new AdicionarFuncionario();

            $obj->adicionar($_POST['cargo'], $_POST['nome'], $_POST['sexo'], $_POST['cpf'],$_POST['pis'], $_FILES['foto']['name'], $_POST['superior'], $_POST['tel'], $_POST['email'], $_POST['lograr'], $_POST['numero'], $_POST['complemento'], $_POST['estado'], $_POST['cidade'], $_POST['bairro'], $_POST['nasc'], $_POST['creden'],$_POST['salario']);

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
            if (!empty($_GET['visita_id'])) {
                $obj->frmEdicao($_GET['visita_id']);
            } else {
                //$obj->listagemAssociacao();
                $obj->pesquisaAssociacao();
            }
            break;

        case "excluirTele" :
            include_once "telemarketing/edicaoTelemarketing.class.php";
            $obj = new EdicaoTelemarketing();
            $obj->excluir($_GET['visita_id']);
            break;
        case "automatica" :
            include_once "AssociacaoAutomatica/AssociacaoAutomatica.class.php";
            $obj = new AssociacaoAutomatica();
            $obj->Associar();
            break;
       
        case "associacaomanual" :
            include_once "AssociacaoAutomatica/AssociacaoAutomatica.class.php";
            $obj = new AssociacaoAutomatica();
            $obj->associacaoManual($_POST["gerente"], $_POST["vendedor"], $_POST["status"], $_POST["telefonia"], $_POST["operador"]);
           break;
       case "pendenciaoperador" :
            include_once "pendenciasOperador/Pendencia.php";
            $obj = new Pendencia();
            $obj->pequisa();
           
           break;
       case "editarpendenciaoperador" :
            include_once "pendenciasOperador/Pendencia.php";
             $obj = new Pendencia();
             $obj->edicao($_GET["id"]);
           
           break;
       case "excluirpendencia" :
            include_once "pendenciasOperador/Pendencia.php";
             $obj = new Pendencia();
             $obj->excluir($_GET["id"]);
           
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
                    $obj->listaHistorico($_POST['id'], $_POST['gerenteTel'], $_POST['operador'], $_POST['data1'], $_POST['data2'], $_POST['status'], $_POST['cliente']);
                } else {
                    $obj->Acompanhados();
                }
            } else {
                $obj->Novo();
                $obj->RegitraAcompanhamento();
            }
            break;
        case "editarAcom":
            include_once "acompanha/editarAcompanhamento.php";
            $obj= new EditarAcompanhamento();
            $obj->listaAcompanhamento($_GET["idAcom"]);
          break;
            case "salvarEdicaoAcompanhamento" :
            include_once "acompanha/editarAcompanhamento.php";
            $obj =  new EditarAcompanhamento();
           if(isset($_POST["enviar"])){
                $obj->salvarEdicao($_POST['id'],$_POST['visita'],$_POST['resposta'],$_POST['ocorrencia'],$_POST['obs'],$_POST['dataAdiamento'],$_POST['horaAdiamento'],$_POST['dataAgendamento'],$_POST['horaAgendamento'],$_POST['cliente_id'],$_POST['cliente'],$_POST['sexo'],$_POST['nascimento'],
                                    $_POST['logradouro'],$_POST['email'],$_POST['numero_documento'],$_POST['fone1'],$_POST['fone2'], $_POST['bairro'],$_POST['municipio']);
           }
           break; 
        case "visualizarAcom";
             include_once "acompanha/Visualizar.php";
             $obj= new Visualizar();
             $obj->listagem($_GET["acom"]);
        break;
       case "excluirAcompanhamento" :
            include_once "acompanha/acompanha.class.php";
            $obj =  new Acompanha();
             $obj->excluir($_GET['id']);
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
          break;  
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

            $obj2 = new ListaCargo();
            $obj2->lista();
            $obj3 = new ListaEmpresa();
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
            $obj->frmEdicao($_GET['id']);
            break;

        case "excluiFuncionario" :
            include_once "funcionario/ListagemFuncionario.class.php";
            $obj = new ListaFuncionario();
            $obj->excluiFuncionario($_GET['registro']);
            break;

        case "listaDeCliente" :
            include_once "cliente/ListaCliente.class.php";
             $obj = new ListaCliente();
             $obj->listagem();
             $obj->clienteJaExiste();
         break;

        case "editarCliente" :
            include_once "cliente/editarCliente.class.php";
            $obj = new EdicaoCliente();
            $obj->escolha($_GET['cliente'], $_GET['pessoa']);
            break;
        case "excluirCliente":
            include_once "cliente/ListaCliente.class.php";
            $obj = new ListaCliente();
            $obj->excluirCliente($_GET["registro"]);

            break;
        case "relatorio" :

            include_once 'listas/ListaCargo.class.php';
            include_once("Estado/Estado.php");
            $obj2 = new ListaCargo();
            $obj2->lista();
            $estado= new Estado();
            $estado->lista2();
            $smarty->assign("idCargo", $obj2->getIdCargo());
            $smarty->assign("cargo", $obj2->getCargo());
            $smarty->assign("idEstado", $estado->getIdUF());
            $smarty->assign("estado",$estado->getEstado());
            $smarty->display("relatorio.tpl");

            if (isset($_POST["enviar"])) {
              if (isset($_POST['opcaoExibicao'])) {
                include_once ("relatorio/relatorio.class.php");
                     if($_GET['opc']=="cliente" || $_GET['opc']=="Produto" ){
                            if($_POST['opcaoExibicao']=="tela"){
                                 $smarty -> display("listaRelatorio.tpl");
                            }
                        }
                   } else {
                    echo "<h2 style='color:red;text-align:center'>Atenção<br/><br/>Opção de exibição não foi preenchida!<br/><br/>Escolha:Tela,PDF ou Grafico</h2>";
                }
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
        case "listaEmpresa":
            include_once 'clienteSistema/ListaEmpresa.class.php';
            $obj = new ListaEmpresa();
            $smarty->assign("empresa", $obj->listaEmpresa());
            $smarty->display("listaEmpresa.tpl");
            break;
        case "editarEmpresa":
            include_once 'clienteSistema/ListaEmpresa.class.php';
            include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';

            $obj = new ListaEmpresa();
            $obj->listaEmpresa();

            $obj2 = new OperadoraTelefonica();
            $obj2->listaEstados();

            $obj->edicaoEmpresa($_GET["id"]);
            $smarty->assign("id", $obj->getId());
            $smarty->assign("cnpj", $obj->getCnpj());
            $smarty->assign("nome", $obj->getNome());
            $smarty->assign("logradouro", $obj->getLogradouro());
            $smarty->assign("bairro", $obj->getBairro());
            $smarty->assign("idMunc", $obj->getIdMunicipio());
            $smarty->assign("municipio", $obj->getMunicipio());
            $smarty->assign("idUf", $obj->getIdUf());
            $smarty->assign("estado", $obj->getEstado());
            $smarty->assign("email", $obj->getEmail());
            $smarty->assign("fone", $obj->getFone());
            $smarty->assign("razao", $obj->getRazao());
            $smarty->assign("complemento", $obj->getComplemento());
            $smarty->assign("numero", $obj->getNumero());
            $smarty->assign("responsavel", $obj->getResponsavel());
            $smarty->assign("dataCadastro", $obj->getDataCadastro());
            $smarty->assign("horaCadastro", $obj->getHoraCadastro());
            $smarty->assign("idEstado", $obj2->getIdEstado());
            $smarty->assign("estado", $obj2->getEstado());
            if (isset($_POST["atualizar"])) {
                $obj->salvarEdicao($_POST["id"], $_POST["nome"], $_POST["cnpj"], $_POST["endereco"], $_POST["fone"], $_POST["razao"], $_POST["responsavel"], $_POST["numero"], $_POST["bairro"], $_POST["complemento"], $_POST["email"], $_POST["data"], $_POST["municipio"]);
            }

            $smarty->display("editarEmpresa.tpl");

            break;
        case "ativaoudesativa":
          include_once 'clienteSistema/ListaEmpresa.class.php';
            $obj= new ListaEmpresa();
            $obj->desativaAtiva($_GET["id"]); 
        break;
        case "excluirempresa":
          include_once 'clienteSistema/ListaEmpresa.class.php';
            $obj= new ListaEmpresa();
            $obj->excluir($_GET["id"]); 
        break;
        case "uploadCliente" :
            include_once 'operadoraTelefonia/OperadoraTelefonia.class.php';
            $obj = new OperadoraTelefonica();
            $obj->listaEstados();
            $smarty->assign("idEstado", $obj->getIdEstado());
            $smarty->assign("estado", $obj->getEstado());
             $smarty->display("formUpload.tpl");
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
        case "listaOcorrencia":
           include_once "ocorrencia/AprovarOcorrencia.class.php";
            $obj = new AprovarOcorrencia();
            $smarty->assign('lista', $obj->listaOcorrenciaCargo());
            $smarty->display("listaOcorrencia.tpl");
            
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
            $obj = new ListaPlano();
            $smarty->assign("lista", $obj->lista());
            $smarty->display("listaPlano.tpl");
            break;
        case "novoPlano":
            $smarty->display("frmPlano.tpl");
            break;
       case "editarPlano":
            include_once 'plano/editar.php';
            $obj=new Editar();
            $obj->frmEditar($_GET["id"]);
           break; 
        case "salvarPlano":
            include_once "plano/salvarPlano.class.php";
            $obj = new SalvarPlano;
            $obj->setPlano($_POST["plano"]);
            $obj->setMes($_POST["meses"]);
            $obj->salvePlano();
            break;
        case "excluirPlano":
            include_once 'plano/editar.php';
            $obj=new Editar();  
            $obj->excluir($_GET["id"]);
        break;
        case "salvarCargo":
            include_once "cargo/SalvarCargo.class.php";
            $obj = new SalvarCargo();
            $obj->setCargo($_POST['cargo']);
            $obj->salvar();
            break;
         case "novaResposta":
                    include_once 'resposta/Resposta.class.php';
                     $smarty -> display("adicionarResposta.tpl");
                    if(isset($_POST["cadastrar"])){
                   
                    $obj=new Resposta();
                    $obj->adicionar($_POST["resposta"],$_POST["descricao"]);
                    }
                   
               break;
               case "listaResposta":
                    include_once 'resposta/Resposta.class.php';
                    $obj=new Resposta();
                     $smarty -> assign('lista',$obj->listaAtivas());
                    $smarty->display("listaResposta.tpl");
               break;
                case "ativaResposta":
                    include_once 'resposta/Resposta.class.php';
                    $obj=new Resposta();
                   $smarty -> assign('lista', $obj ->listaNaoAtivas());
                   $smarty->display("aprovarResposta.tpl");
               break;
              case "ativacaoResposta":
                    include_once 'resposta/Resposta.class.php';
                    $obj=new Resposta();
                    $obj->ativar($_GET["id"]);
               break;
           case "editarResposta":
                    include_once 'resposta/Resposta.class.php';
                    $smarty->display("editarResposta.tpl");
                    if(isset($_POST["atualizar"])){ 
                        $obj=new Resposta();
                         $obj->atualizar($_POST["id"],$_POST["descricao"], $_POST["resposta"]);
                    }
               break;
               case "excluirResposta":
                    include_once 'resposta/Resposta.class.php';
                        $obj=new Resposta();
                         $obj->excluir($_GET["registro"]);
                   
               break;
         case "novaComissao":
             include_once 'comissao/Comissao.php';
             $obj= new Comissao();
             $obj->cadastra();
            break;
        case "listaComissao":
             include_once 'comissao/Comissao.php';
             $obj= new Comissao();
             $obj->lista();
            break;
       case "editarComissao":
             include_once 'comissao/Comissao.php';
             $obj= new Comissao();
             $obj->editar($_GET["id"]);
            break;
       case "excluirComissao":
             include_once 'comissao/Comissao.php';
             $obj= new Comissao();
             $obj->excluir($_GET["id"]);
            break; 
        default :
            include_once "cliente/buscaCliente.php";
            break;
    }
} else {

    echo "<h3>Você nao esta Logado</h3>";
}
?>