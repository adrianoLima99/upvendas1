<?php

class SalvarOcorrencia {

    private $nome;
    private $responsavel;
    private $descricao;
    private $conn;

    function __construct() {
        $this->conn = new connection;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getNome() {
        return $this->nome;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function Salvar() {
        $data = date("Y-m-d");
        $hora = date("H:m:s");
        $nome = $this->getNome();
        $responsavel = $this->getResponsavel();
        $descricao = $this->getDescricao();

        $r = $this->conn->exec("INSERT INTO ocorrencia(nome,cargo_responsavel,descricao,aprovado,data_cadastro,hora_cadastro,usuario_cadastro,empresa_id,ativo) VALUES
                                              ('$nome',$responsavel,'$descricao',-1,'$data','$hora',$_SESSION[id],$_SESSION[empresaId],0)") or die("erro");


        if ($r) {
            echo "<script type='text/javascript'>
     			  alert('Ocorrencia cadastrado com sucesso');
      				 location.href='?pg=pesquisa';
      		</script>";
        }
    }

}

?>