<?php

class ListaEmpresa {

    private $lista;
    private $id;
     private $cnpj;
    private $conn;
    private $nome;
    private $logradouro;
    private $bairro;
    private $municipio;
    private $idMunicipio;
    private $idUf;
    private $estado;
    private $email;
    private $complemento;
    private $numero;
    private $fone;
    private $dataCadastro;
    private $horaCadastro;
    private $responsavel;
    private $razao;

    function __construct() {
        $this->conn = new connection();
    }

    function listaEmpresa() {
        if($_SESSION["tipo"]==0){
            $cond="";
        }else{
            $cond=" WHERE  E.ativo=0 AND E.id=$_SESSION[empresaId]";
        }
        //gera consulta de listagem das empresa cadastradas
        $this->lista = "SELECT E.*,M.id AS idMunc, M.nome AS municipio,U.id AS idUF,U.nome AS estado 
                        FROM empresa AS E INNER JOIN municipio AS M ON M.id=E.municipio_codigo 
                        INNER JOIN estado AS U ON U.id=M.estado_uf  $cond ";
        
        $listagem = $this->conn->query($this->lista);//executa a consulta
        return $listagem;//retorna a listagem
    }
    //metodo para desativar empresa
    public function  desativaAtiva($id){
        
        $selEmpresa=  $this->conn->query("SELECT ativo FROM empresa WHERE id=$id");//seleciona o campo ativo de empresa atraves do id passado
         
        $r=$selEmpresa->fetch(PDO::FETCH_OBJ);//recebe o valor campo ativo
        
        if($r->ativo == 0){//se ativo =0 então a empresa sera desativada
            
              $atualizacao=  $this->conn->exec("UPDATE empresa SET ativo=-1 WHERE id=$id");
                      
          }else{//se ativo =0 então a empresa sera ativada
        
              $atualizacao=  $this->conn->exec("UPDATE empresa SET ativo=0 WHERE id=$id");
          }
            if($atualizacao){//se 
                       echo "<script type='text/javascript'>
                                 alert(' Atualizacao feita com sucesso');
                                location.href='?pg=listaEmpresa';
                             </script>";
            }
    }
    public function  excluir($id){
      echo "DELETE FROM empresa WHERE id=$id";
         $excluir=  $this->conn->exec("DELETE FROM empresa WHERE id=$id");
      
            if($excluir){
                       echo "<script type='text/javascript'>
                                 alert(' Excluisão feita com sucesso');
                                location.href='?pg=listaEmpresa';
                             </script>";
            }
    }
   function setId($id) {
     $this->id = $id;    
    }
    function setCnpj($cnpj) {
     $this->cnpj = $cnpj;    
    }
    
    function setNome($nome) {
     $this->nome = $nome;    
    }
    function setLogradouro($logradouro) {
     $this->logradouro = $logradouro;    
    }
    function setBairro($bairro) {
     $this->bairro = $bairro;    
    }
    function setMunicipio($municipio) {
     $this->municipio = $municipio;    
    }
    function setIdMunicipio($idMunicipio) {
     $this->idMunicipio = $idMunicipio;    
    }
    function setIdUf($idUf) {
     $this->idUf = $idUf;    
    }
    function setEstado($estado) {
     $this->estado = $estado;    
    }
    
    
    function setFone($fone) {
     $this->fone = $fone;    
    }
    function setEmail($email) {
     $this->email = $email;    
    }
    function setResponsavel($responsavel) {
     $this->responsavel = $responsavel;    
    }
    function setComplemento($complemento) {
     $this->compelemento = $complemento;    
    }
    function setNumero($numero) {
     $this->numero = $numero;    
    }
    function setRazao($razao) {
     $this->razao = $razao;    
    }
    function setDataCadastro($dataCadastro) {
            $this->dataCadastro = $dataCadastro; 
        
    }
    function setHoraCadastro($horaCadastro) {
     $this->horaCadastro = $horaCadastro;    
    }
    function getId(){
        return $this->id;
    }
    function getCnpj(){
        return $this->cnpj;
    }
    function getNome(){
        return $this->nome;
    }
     function getLogradouro(){
        return $this->logradouro;
    }
    function getEmail(){
        return $this->email;
    }
     function getBairro(){
        return $this->bairro;
    }
    function getMunicipio(){
        return $this->municipio;
    }
    function getIdMunicipio(){
        return $this->idMunicipio;
    }
    function getIdUf(){
        return $this->idUf;
    }
    function getEstado(){
        return $this->estado;
    }
     function getRazao(){
        return $this->razao;
    }
     function getResponsavel(){
        return $this->responsavel;
    }
    function getFone(){
        return $this->fone;
    }
    function getComplemento(){
        return $this->complemento;
    }
    function getNumero(){
        return $this->numero;
    }
     function getDataCadastro(){
        return $this->dataCadastro;
    }
     function getHoraCadastro(){
        return $this->horaCadastro;
        
    }

    function edicaoEmpresa($id) {
        
        $editar = $this->lista . " AND E.id=" . $id;//recebe concatenação da consulta gerada no atributo lista + condicão q recebe o id da empresa 
        
        $edicao = $this->conn->query($editar);//executa a consulta
        
        if ($edicao->rowCount()) {///se gerou algum registro
            $row= $edicao->fetch(PDO::FETCH_OBJ);
             $this->setId($row->id);
             $this->setCnpj($row->cnpj);
             $this->setNome($row->nome);
             $this->setLogradouro($row->logradouro);
             $this->setBairro($row->bairro);
             $this->setMunicipio($row->municipio);
             $this->setComplemento($row->complemento);
             $this->setnumero($row->numero);
             $this->setIdMunicipio($row->idMunc);
             $this->setIdUf($row->idUF);
             $this->setEstado($row->estado);
             $this->setEmail($row->email);
             $this->setFone($row->fone);
             $this->setRazao($row->razao_social);
             $this->setResponsavel($row->responsavel);
             $this->setDataCadastro($row->data_cadastro);
             $this->setHoraCadastro($row->hora_cadastro);
        }
    }
 //recebe os atributos da empresa   
function salvarEdicao($id,$empresa,$cnpj,$logradouro,$fone,$razao,$responsavel,$numero,$bairro,$complemento,$email,$data,$municipio){
    
     if(!empty($data)){
             $data =  formata_data_db($data);
        }
      //gera e executa a consulta  
    $atualizar=$this->conn->exec("UPDATE empresa SET nome='$empresa',cnpj='$cnpj',logradouro='$logradouro',fone='$fone',razao_social='$razao',responsavel='$responsavel',numero='$numero',
                        bairro='$bairro',complemento='$complemento',email='$email',data_cadastro='$data',municipio_codigo=$municipio WHERE id=$id ");
    if($atualizar){//se atualizacao for bem sucedida redireciona para lista de empresa
        echo "<script type='text/javascript'>
             alert(' Dados Atualizados com sucesso');
             location.href='?pg=listaEmpresa';
                </script>";
    }
 }
}

?>
